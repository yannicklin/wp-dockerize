<?php

namespace Atlas\Core\Extensions\WordPress;

class Cleanup
{
    public function register()
    {
        add_action('init', function () {
            if (!get_theme_support('atlas-cleanup')) {
                return;
            }

            add_action('wp_before_admin_bar_render', [$this, 'adminBar'], 999);
            add_action('wp_dashboard_setup', [$this, 'dashboard']);
        });
    }

    public function adminBar()
    {
        global $wp_admin_bar;

        foreach (config('cleanup.admin_bar', []) as $menu) {
            $wp_admin_bar->remove_menu($menu);
        }
    }

    public function dashboard()
    {
        remove_action('welcome_panel', 'wp_welcome_panel');

        foreach (config('cleanup.meta_boxes', []) as $meta_box) {
            remove_meta_box($meta_box['id'], $meta_box['screen'] ?? 'dashboard', $meta_box['context'] ?? 'normal');
        }
    }
}
