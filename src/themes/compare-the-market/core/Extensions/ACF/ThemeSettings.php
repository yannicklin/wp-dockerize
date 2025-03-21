<?php

namespace Atlas\Core\Extensions\ACF;

class ThemeSettings
{
    public function register()
    {
        add_action('acf/init', [$this, 'registerOptionPages']);
    }

    public function registerOptionPages()
    {
        // Add options pages to WordPress admin area if acf is enabled
        if (!function_exists('acf_add_options_page') || !function_exists('acf_add_options_sub_page')) {
            return;
        }

        foreach (config('theme.options_pages') as $optionsPage) {
            acf_add_options_page($optionsPage);

            if (!isset($optionsPage['sub_pages'])) {
                continue;
            }

            foreach ($optionsPage['sub_pages'] as $subPage) {
                acf_add_options_sub_page($subPage);
            }
        }
    }
}
