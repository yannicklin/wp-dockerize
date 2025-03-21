<?php

namespace Atlas\Blocks;

use App\Blocks\HasBackgroundColors;
use Atlas\Core\Blocks\BaseBlock;

class MediaLogos extends BaseBlock implements HasBackgroundColors
{
    public $name = 'media-logos';

    public $title = 'Media Logos';

    public $description = 'Media Logos';

    public function with($block, $fields)
    {
        $wrapperOverrideUrl = $fields['link_override'] ?: '';
        $logos = [];
        $logos = collect($fields['media_logos'])->map(function (\WP_Post $post) use ($fields) {
            $logo = get_field('image', $post->ID) ?: false;
            if (!$logo || 'publish' !== get_post_status($post->ID)) {
                return [];
            }

            return [
                'logo' => $logo['url'] ?? '',
                'url' => null,
                'title' => $logo['title'] ?? '',
                'alt' => $logo['alt'] ?? '',
                'image_dimensions' => ($logo['width'] && $logo['height']) ? 'width=' . $logo['width'] . ' height=' . $logo['height'] : '',
            ];
        })->toArray();

        return [
            'logos' => $logos,
            'view_all_mobile' => 'View all media partners',
            'wrapper_override_url' => $wrapperOverrideUrl,
            'title' => $fields['title_block']['title'],
            'title_type' => $fields['title_block']['title_type'] ?? 'h2',
            'subtitle' => $fields['title_block']['subtitle'],
            'subtitle_type' => $fields['title_block']['subtitle_type'] ?? 'p',
            'title_content' => $fields['title_block']['content'],
            'title_section_exist' => !empty($fields['title_block']['title'] || $fields['title_block']['subtitle'] || $fields['title_block']['content']),
        ];
    }

    public function availableBackgroundColors(): array
    {
        return [
            HasBackgroundColors::BG_WHITE,
            HasBackgroundColors::BG_CREAM_WHITE,
        ];
    }

    public function setDefaultBackgroundColor(): string
    {
        return HasBackgroundColors::BG_CREAM_WHITE;
    }

    public function getACFGroupKey(): string
    {
        return 'group_653af7504c2d5';
    }
}
