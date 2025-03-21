<?php

/**
 * Theme setup.
 */

namespace App\Setup;

/**
 * Register the theme assets.
 */
add_action('wp_enqueue_scripts', function () {
    [$styles, $scripts, $isHot] = vite([
        'resources/styles/app.scss',
        'resources/scripts/app.ts'
    ]);

    wp_enqueue_style(
        'google-fonts',
        '//fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=optional',
        [],
        null
    );

    foreach ($styles as $handle => $style) {
        wp_enqueue_style($handle, $style, false, null);
    }

    if (!is_user_logged_in()) {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('global-styles');
    }

    foreach ($scripts as $handle => $script) {
        wp_enqueue_script($handle, $script, [], null, true);
    }

    // If vite is running in dev mode it needs module tags for each script
    add_filter('script_loader_tag', function ($tag, $wordpressHandle, $src) use ($scripts) {
        if (in_array($wordpressHandle, array_keys($scripts))) {
            return '<script type="module" src="' . esc_url($src) . '"></script>';
        }
        return $tag;
    }, 10, 3);
}, 100);

/**
 * Register the initial theme setup.
 */
add_action('after_setup_theme', function () {

    /**
     * Add theme support
     */
    foreach (config('theme.support') as $key => $value) {
        if (!is_array($value)) {
            add_theme_support($value);
        } else {
            add_theme_support($key, $value);
        }
    }

    /**
     * Remove theme support
     */
    foreach (config('theme.remove_support') as $key => $value) {
        if (!is_array($value)) {
            remove_theme_support($value);
        } else {
            remove_theme_support($key, $value);
        }
    }

    /**
     * Register the navigation menus.
     *
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */

    foreach (config('theme.menus') as $key => $value) {
        register_nav_menus([
            $key => __($value, 'sage'),
        ]);
    }

    /**
     * deregister unused default image sizes
     */
    add_filter('intermediate_image_sizes', function ($sizes) {
        $targets = config('theme.remove_image_sizes');

        foreach ($sizes as $size_index => $size) {
            if (in_array($size, $targets)) {
                unset($sizes[$size_index]);
            }
        }

        return $sizes;
    }, 10, 1);

    /**
     * Register all custom image sizes
     *
     * @link https://developer.wordpress.org/reference/functions/add_image_size/
     */
    foreach (config('theme.extra_image_sizes') as $key => $value) {
        if (empty($value['width']) || empty($value['height'])) {
            global $sage_error;
            $sage_error(__($key . ' is missing a width or height in theme.image_sizes', 'sage'));
        }
        add_image_size($key, $value['width'], $value['height'], $value['crop'] ?? false);
    }
}, 20);

/**
 * Register the theme sidebars.
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ];

    // Register all widgets from within the navigation config file
    foreach (config('theme.widgets') as $key => $value) {
        register_sidebar([
            'name' => __($value, 'sage'),
            'id' => $key,
        ] + $config);
    }
});

/**
 * re-enqueue FA kit
 */
add_filter('script_loader_tag', function ($tag, $handle, $src) {
    if ('acffa_font-awesome-kit' !== $handle) {
        return $tag;
    }

    if (stristr($src, 'https://kit.fontawesome.com/')) {
        $tag = str_replace('<script ', '<script async ', $tag);
    }

    return $tag;
}, 11, 3);

/**
 * Remove WP built Privacy Tools
 */
add_action('admin_init', function () {
    $privacy_tools_enabled = true;
    if (false === $privacy_tools_enabled) :
        add_filter('map_meta_cap', function ($required_capabilities, $requested_capability, $user_id, $args) {
            switch ($requested_capability) {
                case 'export_others_personal_data':
                case 'erase_others_personal_data':
                case 'manage_privacy_options':
                    $required_capabilities[] = 'do_not_allow';
                    break;
            }

            return $required_capabilities;
        }, 10, 4);
        add_filter('pre_option_wp_page_for_privacy_policy', '__return_zero');
        remove_action('init', 'wp_schedule_delete_old_privacy_export_files');
        remove_action('wp_privacy_delete_old_export_files', 'wp_privacy_delete_old_export_files');
    endif;
});

/**
 * Add custom favicons for iOS and Android.
 */
function add_favicons()
{
    $template_dir = get_template_directory_uri();

    $head_meta = <<<META
    <link rel="shortcut icon" type="image/x-icon" href="$template_dir/resources/images/logos/favicon.ico" />

    <!-- Android Icons -->
    <link rel="manifest" href="$template_dir/resources/images/logos/manifest.json">

    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="format-detection" content="telephone=no" />
META;

    echo $head_meta;
}
add_action('wp_head',  __NAMESPACE__ . '\\add_favicons');

/**
 * Inject iOS icons in meta tags
 */
function custom_apple_touch_icon($meta_tags)
{
    $template_dir = get_template_directory_uri();

    foreach ($meta_tags as $key => $meta_tag) {
        if (strpos($meta_tag, 'apple-touch-icon') !== false) {
            unset($meta_tags[$key]);
        }
    }

    $meta_tags[] = '<link rel="apple-touch-icon" href="' . $template_dir . '/resources/images/logos/phone.png" />';
    $meta_tags[] = '<link rel="apple-touch-icon" sizes="76x76" href="' . $template_dir . '/resources/images/logos/tablet.png" />';
    $meta_tags[] = '<link rel="apple-touch-icon" sizes="120x120" href="' . $template_dir . '/resources/images/logos/phone@2x.png" />';
    $meta_tags[] = '<link rel="apple-touch-icon" sizes="152x152" href="' . $template_dir . '/resources/images/logos/tablet@2x.png" />';
    $meta_tags[] = '<link rel="apple-touch-icon" sizes="180x180" href="' . $template_dir . '/resources/images/logos/phone@3x.png" />';

    return $meta_tags;
}
add_filter('site_icon_meta_tags',  __NAMESPACE__ . '\\custom_apple_touch_icon');


/**
 * Inject GTM script
 */
function inject_GTM()
{
    $head_script = <<<SCRIPT
    <script type="text/javascript" data-cfasync="false">(function (w, d, s, l, i) {
        w[l] = w[l] || []; w[l].push({
            'gtm.start':
                new Date().getTime(), event: 'gtm.js'
        }); var f = d.getElementsByTagName(s)[0],
            j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src =
                'https://ssgtm.xxx.xxx.xxx/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-KKD5M78');</script>
SCRIPT;

    echo $head_script;
}
add_action('wp_head',  __NAMESPACE__ . '\\inject_GTM', -1000);

/**
 * Inject Preconnect and DNS-Prefetch meta
 */
function extra_preconnects()
{
    $head_meta = <<<META
        <link rel="dns-prefetch" href="//fast.wistia.com" />
        <link rel="preconnect" href="//ssgtm.xxx.xxx.xxx" />
        <link rel="preconnect" href="//fonts.googleapis.com" />
        <link rel="preconnect" href="//fonts.gstatic.com" />
        <link rel="preconnect" href="//kit.fontawesome.com" />
META;

    echo $head_meta;
}
add_action('wp_head',  __NAMESPACE__ . '\\extra_preconnects', -999);

/**
 * Inject Page Alternate HrefLang Links
 */
function hreflang_links()
{
    global $post;
    $current_url = get_permalink($post->ID);
    $hreflang_uk = get_field('hreflang_uk', $post->ID) ?: '';

    $head_linkalternate = "<link rel='alternate' hreflang='en-au' href='" . $current_url . "' />";

    if (!empty($hreflang_uk)) {
        $head_linkalternate .= "<link rel='alternate' hreflang='en-gb' href='" . $hreflang_uk . "' />";
    }
    echo $head_linkalternate;
}
add_action('wp_head',  __NAMESPACE__ . '\\hreflang_links');