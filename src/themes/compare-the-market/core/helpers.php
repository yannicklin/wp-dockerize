<?php

use Illuminate\Support\HtmlString;

if (!function_exists('str_alphanumeric')) {
    function str_alphanumeric($string)
    {
        return preg_replace('/[^A-Za-z0-9 ]/', '', $string);
    }
}

if (!function_exists('theme_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @param  bool|null  $secure
     * @return string
     */
    function theme_asset($path, $secure = null)
    {
        return get_template_directory_uri() . '/public' . $path;
    }
}

if (!function_exists('vite')) {
    /**
     * @return \Atlas\Core\Assets\Vite
     */
    function vite($assets = [])
    {
        return app(\Atlas\Core\Assets\Vite::class)($assets);
    }
}

if (!function_exists('recursively_get_field')) {
    function recursively_get_field($field_name, $post_id)
    {
        $parent_id = wp_get_post_parent_id($post_id);

        if ($parent_id) {
            $parent_field_value = get_field($field_name, $parent_id);

            if ($parent_field_value !== null && $parent_field_value !== false) {
                return $parent_field_value;
            } else {
                return recursively_get_field($field_name, $parent_id);
            }
        }

        return null;
    }
}

if (!function_exists('generatePageLink')) {
    /**
     * Generate the full page link from relative path
     *
     * @param  string  $link
     * @return string
     */
    function generatePageLink($link)
    {
        $linkGenerated = !empty($link) ? (ctype_space($link) ? '' : (str_starts_with($link, 'http') ? $link : site_url($link))) : '';

        return $linkGenerated;
    }
}
