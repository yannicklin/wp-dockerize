<?php

/**
 * Theme filters.
 */

namespace App\Filters;

use Atlas\Taxonomies\Vertical;
use Atlas\Components\Header;
use Illuminate\Support\Str;

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
    return '...';
});

/**
 * Bootstrap 5 Navwalker Temp Hax
 */
add_filter('nav_menu_link_attributes', function ($atts, $item, $args) {
    if (is_object($args) && is_a($args->walker, 'WP_Bootstrap_Navwalker') && array_key_exists('data-toggle', $atts)) {
        unset($atts['data-toggle']);
        $atts['data-bs-toggle'] = 'dropdown';
    }
    return $atts;
}, 20, 3);

add_action('nav_menu_item_title', function ($title, $menu_item, $args, $depth) {
    if ($depth !== 0) {
        return $title;
    }

    if ($icon = get_field('icon', $menu_item)) {
        $title = '<section class="component component-icon menu-icon">' .
            file_get_contents($icon['file']) .
            '</section>' .
            $title;
    }

    return $title;
}, 10, 4);


/**
 * Wrap Core Blocks in container
 */
add_filter('render_block', function ($block_content, $block) {
    $coreBlocks = ['core/paragraph', 'core/heading', 'core/quote', 'core/list', 'core/embed'];
    if (in_array($block['blockName'], $coreBlocks)) {
        $block_content = '<div class="container">' . $block_content . '</div>';
    } elseif ('core/image' === $block['blockName']) {
        $block_content = '<div class="container"><div class="rte">' . $block_content . '</div></div>';
    }
    return $block_content;
}, 10, 2);


add_filter('body_class', function ($classes = '') {
    $lightDarkMode = Header::getHeaderDarkLightMode();
    return array_merge($classes, array('theme-cream-white page-theme-' . $lightDarkMode));
});

add_filter('body_attributes', function (string $attributes = '') {
    global $post;
    $vertical = Vertical::getVerticalinPage($post, false);
    $attributes = [
        'data-vertical' => ($vertical ? $vertical->slug : null),
    ];

    return array_reduce(array_keys($attributes), function ($carry, $key) use ($attributes) {
        $carry .= sprintf(' %s="%s"', $key, $attributes[$key]);
        return $carry;
    }, '');
});


// Add .lottie to the list of allowed file types
add_filter('upload_mimes', function ($existing_mimes) {
    $existing_mimes['lottie'] = 'application/json';
    return $existing_mimes;
});

// Add dotlottie-player to the list of allowed tags so that the lottie file gets pulled in
add_filter('ss_match_tags', function ($match_tags) {
    $match_tags['dotlottie-player'] = ['src'];
    return $match_tags;
});

add_filter('wp_enqueue_scripts', function () {
    if (!is_user_logged_in()) {
        wp_dequeue_script('jquery');
        wp_deregister_script('jquery');
    }
}, PHP_INT_MAX);

// Allow Font Awesome to enqueue on all pages
add_filter('ACFFA_always_enqueue_fa', '__return_true');

// Allow SVG upload
add_filter('upload_mimes', function ($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
});

// Add SVG dimension on image call
add_filter('wp_get_attachment_image_src', function ($image, $attachment_id, $size, $icon) {
    if (is_array($image) && preg_match('/\.svg$/i', $image[0]) && $image[1] <= 1) {
        if (is_array($size)) {
            $image[1] = $size[0];
            $image[2] = $size[1];
        } elseif (($xml = simplexml_load_file($image[0])) !== false) {
            $attr = $xml->attributes();
            $viewbox = explode(' ', $attr->viewBox);
            $image[1] = isset($attr->width) && preg_match('/\d+/', $attr->width, $value) ? (int) $value[0] : (count($viewbox) == 4 ? (int) $viewbox[2] : null);
            $image[2] = isset($attr->height) && preg_match('/\d+/', $attr->height, $value) ? (int) $value[0] : (count($viewbox) == 4 ? (int) $viewbox[3] : null);
        } else {
            $image[1] = $image[2] = null;
        }
    }
    return $image;
}, 10, 4);

// Save SVG dimension on image upload
add_filter('wp_update_attachment_metadata', function ($image, $attachment_id) {
    $attachment = get_post($attachment_id); // Filter makes sure that the post is an attachment
    $mime_type = $attachment->post_mime_type;

    if ('image/svg+xml' == $mime_type) {
        if (empty($image) || empty($image['width']) || empty($image['height'])) {
            $xml = simplexml_load_file(wp_get_attachment_url($attachment_id));
            $attr = $xml->attributes();
            $viewbox = explode(' ', $attr->viewBox);
            $image['width'] = isset($attr->width) && preg_match('/\d+/', $attr->width, $value) ? (int) $value[0] : (count($viewbox) == 4 ? (int) $viewbox[2] : null);
            $image['height'] = isset($attr->height) && preg_match('/\d+/', $attr->height, $value) ? (int) $value[0] : (count($viewbox) == 4 ? (int) $viewbox[3] : null);
        }
    }

    return $image;
}, 10, 2);


// Remove redirect guessing
add_filter('do_redirect_guess_404_permalink', '__return_false');
add_filter('strict_redirect_guess_404_permalink', '__return_true');


//Change User URL slug depending on role (mostly for experts)
add_action('init', function () {
    add_rewrite_rule('experts/([^/]+)/?$', 'index.php?author_name=$matches[1]', 'top');
    add_rewrite_rule('blog/author/([^/]+)/?$', 'index.php?author_name=$matches[1]', 'top');
});

add_filter('author_link', function ($link, $author_id) {
    $author = get_user_by('id', $author_id);

    $base = in_array('expert', $author->roles) ? 'experts' : 'blog/author';

    return str_replace(home_url('author'), home_url($base), $link);
}, 10, 2);


// Force all images go to HTTPS
add_filter('wp_calculate_image_srcset', function ($sources) {
    foreach ($sources as &$source) {
        $source['url'] = set_url_scheme($source['url'], 'https');
    }
    return $sources;
});


// Remove YoastSEO HTML Head info, comment & version on Head
add_filter('wpseo_debug_markers', '__return_false');
add_filter('wpseo_hide_version', '__return_true');


// YoastSEO Breadcrumbs
add_filter('wpseo_breadcrumb_links', function ($links) {

    // limit to 3 levels
    if (is_singular() && !is_front_page()) {
        global $post;
        $ancestors = get_post_ancestors($post->ID);
        $new_breadcrumb = [];

        if ($ancestors) {
            $most_upper_ancestor_id = end($ancestors);
            $new_breadcrumb[] = [
                'url' => get_permalink($most_upper_ancestor_id),
                'text' => get_the_title($most_upper_ancestor_id),
            ];
        }

        $new_breadcrumb[] = [
            'url' => get_permalink($post->ID),
            'text' => get_the_title($post->ID),
        ];

        $links = array_merge(array_slice($links, 0, 1), $new_breadcrumb);
    }

    // limit text characters maximum
    foreach ($links as $key => $link) {
        $links[$key]['text'] = Str::limit($link['text'], 24);
    }

    return $links;
});

add_action('pre_get_posts', function ($query) {
    if (is_user_logged_in() && $query->is_search() && $query->is_main_query()) {
        $query->set('search_columns', ['post_title']);
    }
});