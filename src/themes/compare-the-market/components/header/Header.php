<?php

namespace Atlas\Components;

use Atlas\Taxonomies\Vertical;
use Illuminate\Contracts\View\View;
use Roots\Acorn\View\Component;

class Header extends Component
{
    public $enable_search = false;

    public $search_icon = [];

    public $close_icon = [];

    public $header_theme = '';
    public $site_logo = false;
    public $mobile_logo = false;
    public $small_logo = false;

    public $cta_buttons = [];
    public $cta_title = '';
    public $cta_enabled = false;

    public function __construct()
    {
        $fields = get_fields(
            wp_get_nav_menu_object(wp_get_nav_menu_name('header-main'))
        );

        $this->enable_search = $fields['enable_search'] ?? false;

        $this->search_icon = get_stylesheet_directory() . '/resources/icons/search.svg';

        $this->close_icon = get_stylesheet_directory() . '/resources/icons/close.svg';

        $this->small_logo = get_field('logo_small', 'options');


        $this->setHeaderTheme();
        $this->setHeaderCTA();
    }

    public function setHeaderTheme()
    {
        $this->header_theme = self::getHeaderDarkLightMode();

        $this->mobile_logo = match ($this->header_theme) {
            'dark' => get_field('site_logo_dark_mobile', 'options'),
            default => get_field('site_logo_mobile', 'options'),
        };

        $this->site_logo = match ($this->header_theme) {
            'dark' => get_field('site_logo_dark', 'options'),
            default => get_field('site_logo', 'options'),
        };
    }

    public function setHeaderCTA()
    {
        global $post;
        $vertical = Vertical::getVerticalinPage($post, false);
        $cta_option_source = $vertical ? Vertical::$slug . '_' . $vertical->term_id : 'options';

        $this->cta_title = $vertical ? $vertical->name : $post?->post_title;
        $this->cta_buttons = get_field('sticky_cta_buttons', $cta_option_source);

        $this->cta_enabled = $this->getCTAVisibility($post?->ID);
    }

    private function getCTAVisibility($page_id)
    {
        $cta_enabled_setting = get_field('sticky_nav_visibility', $page_id);
        if ($cta_enabled_setting === 'default') {
            $parent_id = wp_get_post_parent_id($page_id);
            if ($parent_id === 0) {
                return false;
            }
            return $this->getCTAVisibility($parent_id);
        } else {
            return $cta_enabled_setting === 'show';
        }
    }

    public static function getHeaderDarkLightMode()
    {
        global $post;
        $darklightmode_global = get_field('light_dark_mode', 'options');

        if (is_null($post)) {
            $darklightmode = $darklightmode_global;
        } else {
            $vertical = Vertical::getVerticalinPage($post, false);
            $vertical_page_id = $vertical ? Vertical::$slug . '_' . $vertical->term_id : '';

            $darklightmode_page = get_field('light_dark_mode');
            $darklightmode_vertical = !empty($vertical_page_id) ? get_field('light_dark_mode', $vertical_page_id) : null;

            $darklightmode = in_array($darklightmode_page, [null, 'default']) ? (in_array($darklightmode_vertical, [null, 'default']) ? $darklightmode_global : $darklightmode_vertical) : $darklightmode_page;
        }

        return $darklightmode;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('Components::header.header');
    }
}
