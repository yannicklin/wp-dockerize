<?php

namespace App\Schema;

/**
 * Facilities
 */
function adjust_dates_for_schema_graph($data) {
    $dateFields = ['uploadDate', 'datePublished', 'dateModified'];
    $inputFormat = 'd/m/Y';
    $outputFormat = 'Y-m-d\TH:i:sP';
    $timezone = 'Australia/Brisbane';

    foreach ($data as $key => &$piece) {
        if (is_array($piece)) {
            $piece = adjust_dates_for_schema_graph($piece);
        } else {
            if (in_array($key, $dateFields) && !empty($piece)) {
                try {
                    $datetime = \DateTime::createFromFormat($inputFormat, $piece, new \DateTimeZone('UTC'));
                    if ($datetime) {
                        $datetime->setTimezone(new \DateTimeZone($timezone));
                        $piece = $datetime->format($outputFormat);
                    }
                } catch (\Exception $e) {
                    $piece = $piece;
                }
            }
        }
    }

    return $data;
}
add_filter('wpseo_schema_graph', __NAMESPACE__ . '\\adjust_dates_for_schema_graph', 99, 1);


function remove_attributes($html) {
    return preg_replace('/\s*(class|id)="[^"]*"/i', '', $html);
}

function remove_square_bracketed_tags($text) {
    return preg_replace('/\[.*?\]/', '', $text);
}

function format_duration_to_iso8601($duration) {
    if (empty($duration)) {
        return '';
    }

    $parts = explode(':', $duration);
    $hours = $minutes = $seconds = 0;

    switch(count($parts)) {
        case 3:
            list($hours, $minutes, $seconds) = $parts;
            break;
        case 2:
            list($minutes, $seconds) = $parts;
            break;
        case 1:
            $seconds = $parts[0];
            break;
        default:
            break;
    }

    $formatted_duration = 'PT';

    if ($hours > 0) {
        $formatted_duration .= ltrim($hours, '0') . 'H';
    }
    if ($minutes > 0) {
        $formatted_duration .= ltrim($minutes, '0') . 'M';
    }
    if ($seconds > 0) {
        $formatted_duration .= ltrim($seconds, '0') . 'S';
    }

    return $formatted_duration;
}


/**
 * Schema: Videos
 */
function ctm_schema_video_collect($block_source, $fields) {
    $result = [];

    switch($block_source) {
        case 'video':
            $schema_video_name = !empty($fields['schema_video_title']) ? $fields['schema_video_title'] : (!empty($fields['title_block']['title']) ? $fields['title_block']['title'] : $fields['title']);
            $schema_video_description = !empty($fields['schema_video_description']) ? $fields['schema_video_description'] : (!empty($fields['title_block']['content']) ? $fields['title_block']['content'] : '');
            $schema_video_thumbnail = !empty($fields['thumbnail']['ID']) ? wp_make_link_relative(wp_get_attachment_url($fields['thumbnail']['ID'])) : '';
            break;
        case 'acf/video':
            $schema_video_name = !empty($fields['schema_video_title']) ? $fields['schema_video_title'] : (!empty($fields['title_block']['title_block']['title']) ? $fields['title_block']['title_block']['title'] : '');
            $schema_video_description = !empty($fields['schema_video_description']) ? $fields['schema_video_description'] : (!empty($fields['title_block']['title_block']['content']) ? $fields['title_block']['title_block']['content'] : '');
            $schema_video_thumbnail = !empty($fields['thumbnail']['ID']) ? wp_make_link_relative(wp_get_attachment_url($fields['thumbnail']['ID'])) : '';
            break;
        case 'acf/video-reel':
            $schema_video_name = !empty($fields['schema_video_title']) ? $fields['schema_video_title'] : ($fields['video_title'] ?? '');
            $schema_video_description = !empty($fields['schema_video_description']) ? $fields['schema_video_description'] : ($fields['video_description'] ?? '');
            $schema_video_thumbnail = !empty($fields['image']['image']['url']) ? wp_make_link_relative($fields['image']['image']['url']) : '';
            break;
        default:
            break;
    }

    $result['@type'] = "VideoObject";
    $result['@id'] = 'https://fast.wistia.net/embed/iframe/' . $fields['wistia_id'];
    $result['name'] = $schema_video_name;
    $result['description'] = wp_strip_all_tags($schema_video_description);
    $result['thumbnailUrl'] = $schema_video_thumbnail;
    $result['uploadDate'] = !empty($fields['video_upload_date']) ? $fields['video_upload_date'] : '';
    $result['duration'] = format_duration_to_iso8601($fields['video_duration'] ?? '');
    $result['embedUrl'] = 'https://fast.wistia.net/embed/iframe/' . $fields['wistia_id'];

    // Add Transcript
    if (!empty($fields['transcript'])) {
        $result['transcript'] = wp_strip_all_tags($fields['transcript']);
    }

    // Add Author
    if ('manual' == $fields['expert_label']['user_toggle'] && !empty($fields['expert_label']['burrow_url'])) {
        $result['author'] = [
            "@type" => "Person",
            "@id" => $fields['expert_label']['burrow_url'],
            "name" => $fields['expert_label']['name'],
            "url" => $fields['expert_label']['burrow_url'],
        ];
    } elseif (!empty($fields['expert_label']['user'])) {
        $user_id = $fields['expert_label']['user']['ID'];

        $expert_burrow_url = get_field('expert_burrow_url', 'user_' . $user_id);
        $expert_burrow_url = empty($expert_burrow_url) ? get_author_posts_url($user_id) : $expert_burrow_url;

        $result['author'] = [
            "@type" => "Person",
            "@id" => site_url('/#/schema/Person/'. $user_id),
            "name" => get_the_author_meta('display_name', $user_id),
            "url" => $expert_burrow_url,
        ];
    }

    return $result;
}


/**
 * Schema: FAQItems
 */
function ctm_schema_faqitem_collect($block_source, $items) {
    $Google_Allowed_Tags_in_Schema_FAQPage_Answer = '<h1><h2><h3><h4><h5><h6><br><ol><ul><li><a><p><div><b><strong><i><em>';
    $collectedFaqs = [];

    foreach ($items as $item) {

        switch($block_source) {
            case 'accordion':
            case 'acf/accordion':
                $accordion = $item['accordion_item'];
                $accordion_title = $accordion['title'] ?? '';
                $accordion_content = $accordion['content'] ?? '';
                break;
            case 'hybrid_accordion':
            case 'acf/hybrid-accordion':
                $accordion = $item;
                $accordion_title = $accordion['accordion_header']['title'] ?? '';
                $accordion_content = $accordion['accordion_body']['content'] ?? '';
                break;
            default:
                break;
        }

        $faqType = $accordion['selected_faq_type'] ?? 'Seleted'; // As default, especially for Block/Accordions
        if ($faqType === 'None') continue;

        $faq_title = remove_attributes(strip_tags(remove_square_bracketed_tags($accordion_title)));
        $same_as_urls = array_filter(array_column($accordion['sameas_repeater'] ?? [], 'sameas_url'));

        // Defaults
        $question = [
            '@type' => 'Question',
            'name' => $faq_title
        ];
        $answer_text = remove_attributes(strip_tags($accordion_content, $Google_Allowed_Tags_in_Schema_FAQPage_Answer));

        if (!empty($same_as_urls)) {
            $question['sameAs'] = $same_as_urls;
        }

        // Customize
        switch ($faqType) {
            case 'Custom Answer':
                if (!empty($accordion['custom_answer'])) {
                    $answer_text = remove_attributes(strip_tags($accordion['custom_answer'], $Google_Allowed_Tags_in_Schema_FAQPage_Answer));
                }
                break;
            case 'Custom Question':
                if (!empty($accordion['custom_question'])) {
                    $question['name'] = remove_attributes(strip_tags($accordion['custom_question'], $Google_Allowed_Tags_in_Schema_FAQPage_Answer));
                }
                break;
            case 'Custom Q and A':
                $question['name'] = remove_attributes(strip_tags($accordion['custom_question'], $Google_Allowed_Tags_in_Schema_FAQPage_Answer));
                $answer_text = remove_attributes(strip_tags($accordion['custom_answer'], $Google_Allowed_Tags_in_Schema_FAQPage_Answer));
                break;
            case 'Selected':
            default:
                break;
        }

        $collectedFaqs[] = $question + ['acceptedAnswer' => ['@type' => 'Answer', 'text' => $answer_text]];
    }

    return $collectedFaqs;
}


/**
 * Schema: change the SearchAction; but disable it since there is no insite search
 */
function ctm_schema_change_search_url()
{
    return site_url('/search-results/?term={search_term_string}');
}
add_filter('wpseo_json_ld_search_url', __NAMESPACE__ . '\\ctm_schema_change_search_url');
add_filter('disable_wpseo_json_ld_search', '__return_true');


/**
 * Schema: convert image path from relative to absolute
 */
function ctm_schema_images_path_convert($data, $context)
{
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            $data[$key] = ctm_schema_images_path_convert($value, $context);
        } else {
            if (array_key_exists("@type", $data) && ("ImageObject" === $data["@type"])) {
                if (in_array($key, array("contentUrl", "url")) && (0 === strncmp('/static-content/', $value, 16))) {
                    $data[$key] = site_url($value);
                }
            } elseif (in_array($key, array("thumbnailUrl")) && (0 === strncmp('/static-content/', $value, 16))) {
                $data[$key] = site_url($value);
            }
        }
    }

    return $data;
}
add_filter('wpseo_schema_graph', __NAMESPACE__ . '\\ctm_schema_images_path_convert', 99, 2);


/**
 * Schema: handcode the ContactPoints to Organisation
 */
function ctm_schema_organisation_add_contactpoint($data, $context)
{
    $data['contactPoint'] = [
        [
            "@type" => "ContactPoint",
            "areaServed" => "Australia",
            "contactType" => "Customer Service",
            "contactOption" => "TollFree",
            "telephone" => "+(61)1800 645 617",
            "productSupported" => "Business Insurance Comparison"
        ],
        [
            "@type" => "ContactPoint",
            "areaServed" => "Australia",
            "contactType" => "Customer Service",
            "contactOption" => "TollFree",
            "telephone" => "+(61)1800 338 253",
            "productSupported" => "Health Insurance Comparison"
        ],
        [
            "@type" => "ContactPoint",
            "areaServed" => "Australia",
            "contactType" => "Customer Service",
            "contactOption" => "TollFree",
            "telephone" => "+(61)1800 204 124",
            "productSupported" => "Income Protection and Life Insurance Comparison"
        ]
    ];

    return $data;
}
add_filter('wpseo_schema_organization', __NAMESPACE__ . '\\ctm_schema_organisation_add_contactpoint', 10, 2);


/**
 * Schema: WebPage modification, with Block/Written-Reviewed-By
 */
function ctm_schema_user_info_generate($type = 'author', $user_id) {
    $result = [];
    if (0 < $user_id) {
        $result["@type"] = "Person";
        $result["@id"] = site_url('/#/schema/Person/'. $user_id);
        $result["name"] = get_the_author_meta('display_name', $user_id);
        $result["url"] = ('expert' == $type) ? get_field('expert_burrow_url', 'user_' . $user_id) : get_author_posts_url($user_id);
    }

    return $result;
}


function ctm_schema_webpage_append_author_reviewers($blocks) {
    foreach ($blocks as $block) {
        $written_by = ctm_schema_user_info_generate('author', $block['attrs']['data']['written_by']);
        $reviewed_by = ctm_schema_user_info_generate('author', $block['attrs']['data']['reviewed_by']);
        $expert_reviewed_by = ctm_schema_user_info_generate('expert', $block['attrs']['data']['expert_reviewed_by']);

        add_filter('wpseo_schema_webpage', function($data) use ($written_by, $reviewed_by, $expert_reviewed_by) {
            $data['author'] = $written_by;
            $data['reviewedBy'] = [$reviewed_by, $expert_reviewed_by];
            return $data;
        }, 11, 1);
    }
}
add_action( 'wpseo_pre_schema_block_type_acf/written-reviewed-by', __NAMESPACE__ . '\\ctm_schema_webpage_append_author_reviewers', 10, 1 );


/**
 * Schema: WebPage modification, with Block/Standard-Hero
 */
function ctm_schema_webpage_remove_breadcrumb($blocks) {
    foreach ($blocks as $block) {
        $removeBreadCrumbs = $block['attrs']['data']['hidebreadcrumbs'] ?? false;
        if ($removeBreadCrumbs) {
            add_filter('wpseo_schema_webpage', function($data) {
                if (array_key_exists('breadcrumb', $data)) {
                    unset($data['breadcrumb']);
                }
                return $data;
            }, 11, 1);
        }
    }
}
add_action('wpseo_pre_schema_block_type_acf/standard-hero', __NAMESPACE__ . '\\ctm_schema_webpage_remove_breadcrumb', 10, 1);


/**
 * Schema: Block/Accordion, Block/Hybrid-Accordion
 */
function ctm_schema_append_faq_objects($blocks) {
    $schema_faq = [];

    foreach ($blocks as $block) {
        $block_name = $block['attrs']['name'];
        $block_data = $block['attrs']['data'];
        $block_id = acf_get_block_id( $block_data );
        acf_setup_meta( $block['attrs']['data'], $block_id );

        switch ($block_name) {
            case 'acf/accordion':
                $accordion_items = get_field_object( 'items', $block_id )['value'];
                $enable_faq_schema = get_field_object( 'enable_faq_schema', $block_id )['value'] ?? false;

                break;
            case 'acf/hybrid-accordion':
                $accordion_items = get_field_object( 'accordions', $block_id )['value'];
                $enable_faq_schema = get_field_object( 'enable_faq_schema', $block_id )['value'] ?? false;

                break;
            default:
                break;
            }

            if (!empty($accordion_items) && $enable_faq_schema)
            {
                $schema_faq[] = ctm_schema_faqitem_collect($block_name, $accordion_items);
            }

        acf_reset_meta( $block_id );
    }

    // Adding FAQPage/FAQItems
    if (!empty($schema_faq)) {
        add_filter('wpseo_schema_graph', function($data, $context) use ($schema_faq) {
            $FAQPageExists = null;

            foreach ($data as $key => $value) {
                if (array_key_exists("@type", $value) && ("FAQPage" === $value["@type"])) {
                    $FAQPageExists = $key;
                }
            }

            if (isset($FAQPageExists)) {
                $data[$FAQPageExists]["mainEntity"] = array_merge($data[$FAQPageExists]["mainEntity"], array_merge(...$schema_faq));
            } else {
                $data[] = [
                    '@type' => 'FAQPage',
                    'mainEntity' => array_merge(...$schema_faq)
                ];
            }

            return $data;
        }, 11, 2);
    }
}
add_action('wpseo_pre_schema_block_type_acf/accordion', __NAMESPACE__ . '\\ctm_schema_append_faq_objects', 10, 1);
add_action('wpseo_pre_schema_block_type_acf/hybrid-accordion', __NAMESPACE__ . '\\ctm_schema_append_faq_objects', 10, 1);


/**
 * Schema: Block/Video, Block/Video-Reels
 */
function ctm_schema_append_video_objects($blocks) {
    $schema_video = [];

    foreach ($blocks as $block) {

        $block_name = $block['attrs']['name'];
        $block_data = $block['attrs']['data'];

        $block_id = acf_get_block_id( $block_data );
        acf_setup_meta( $block['attrs']['data'], $block_id );

        switch ($block_name) {
            case 'acf/video':
                $acf_video = get_fields($block_id);

                if (!empty($acf_video['wistia_id']) && (isset($acf_video['enable_video_schema']) && $acf_video['enable_video_schema']))
                {
                    $schema_video[] = ctm_schema_video_collect($block_name, $acf_video);
                }
                break;
            case 'acf/video-reel':
                $acf_video_reels = get_field_object( 'video_reels', $block_id )['value'];

                if (!empty($acf_video_reels)) {
                    foreach ($acf_video_reels as $video_reel) {
                        $schema_video[] = ctm_schema_video_collect($block_name, $video_reel);
                    }
                }
                break;
            default:
                break;
            }

        acf_reset_meta( $block_id );
    }

    // Adding Video
    if (!empty($schema_video)) {
        add_filter('wpseo_schema_graph', function($data, $context) use ($schema_video) {
            foreach ($schema_video as $video_object) {
                $data[] = $video_object;
            }

            return $data;
        }, 11, 2);
    }
}
add_action('wpseo_pre_schema_block_type_acf/video', __NAMESPACE__ . '\\ctm_schema_append_video_objects', 10, 1);
add_action('wpseo_pre_schema_block_type_acf/video-reel', __NAMESPACE__ . '\\ctm_schema_append_video_objects', 10, 1);


/**
 * Schema: crawling Block Side Navigation, to generate the FAQItem/Video inside
 */
function ctm_schema_block_side_navigation_render($blocks) {
    $schema_faq = [];
    $schema_video = [];

    foreach ($blocks as $block) {
        $block_data = $block['attrs']['data'];
        $block_id = acf_get_block_id( $block_data );
        acf_setup_meta( $block['attrs']['data'], $block_id );
        $acf_blocks = get_field_object( 'blocks', $block_id )['value'];

        if (!empty($block_data['blocks'])) {
            foreach ($block_data['blocks'] as $key => $block_name) {
                switch ($block_name) {
                    case 'accordion':
                        $acf_block = $acf_blocks[$key];

                        if (!empty($acf_block['items']) && (isset($acf_block['enable_faq_schema']) && $acf_block['enable_faq_schema']))
                        {
                            $schema_faq[] = ctm_schema_faqitem_collect($block_name, $acf_block['items']);
                        }
                        break;
                    case 'hybrid_accordion':
                        $acf_block = $acf_blocks[$key];

                        if (!empty($acf_block['accordions']) && (isset($acf_block['enable_faq_schema']) && $acf_block['enable_faq_schema']))
                        {
                            $schema_faq[] = ctm_schema_faqitem_collect($block_name, $acf_block['accordions']);
                        }
                        break;
                    case 'video':
                        $acf_block = $acf_blocks[$key];

                        if (!empty($acf_block['wistia_id']) && (isset($acf_block['enable_video_schema']) && $acf_block['enable_video_schema']))
                        {
                            $schema_video[] = ctm_schema_video_collect($block_name, $acf_block);
                        }
                        break;
                    default:
                        break;
                }
            }
        }
        acf_reset_meta( $block_id );
    }

    // Adding FAQPage/FAQItems
    if (!empty($schema_faq)) {
        add_filter('wpseo_schema_graph', function($data, $context) use ($schema_faq) {
            $FAQPageExists = null;

            foreach ($data as $key => $value) {
                if (array_key_exists("@type", $value) && ("FAQPage" === $value["@type"])) {
                    $FAQPageExists = $key;
                }
            }

            if (isset($FAQPageExists)) {
                $data[$FAQPageExists]["mainEntity"] = array_merge($data[$FAQPageExists]["mainEntity"], array_merge(...$schema_faq));
            } else {
                $data[] = [
                    '@type' => 'FAQPage',
                    'mainEntity' => array_merge(...$schema_faq)
                ];
            }

            return $data;
        }, 11, 2);
    }

    // Adding Video
    if (!empty($schema_video)) {
        add_filter('wpseo_schema_graph', function($data, $context) use ($schema_video) {
            foreach ($schema_video as $video_object) {
                $data[] = $video_object;
            }

            return $data;
        }, 11, 2);
    }
}
add_action('wpseo_pre_schema_block_type_acf/side-navigation', __NAMESPACE__ . '\\ctm_schema_block_side_navigation_render', 10, 1);