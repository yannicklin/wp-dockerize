<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class AppPromoBanner extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'Components::main-nav.main-nav',
        'Components::footer.footer',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'app_banner_text' => get_field('app_banner_text', 'option'),
            'app_icon_image' => get_field('app_icon_image', 'option'),
            'app_buttons' => get_field('app_buttons', 'option'),
        ];
    }
}
