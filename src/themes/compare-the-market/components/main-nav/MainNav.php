<?php

namespace Atlas\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MainNav extends Component
{
    public $close_icon = [];

    public $header_theme = '';

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($theme)
    {
        $this->close_icon = get_stylesheet_directory() . '/resources/icons/close.svg';
        $this->header_theme = $theme;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        $theme_locations = get_nav_menu_locations();

        $menu = get_term($theme_locations['header-main'], 'nav_menu');

        return view(
            'Components::main-nav.main-nav',
            get_fields(wp_get_nav_menu_object($menu->term_id))
        );
    }
}