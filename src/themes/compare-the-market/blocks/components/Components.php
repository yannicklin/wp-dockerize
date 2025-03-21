<?php

// This Component (Components) is to show Buttons and Tags combinations, not for Production use. -- 08 AUG 2024

namespace Atlas\Blocks;

use Atlas\Components\Button;
use Atlas\Components\Link;
use Atlas\Core\Blocks\BaseBlock;

class Components extends BaseBlock
{
    public $name = 'components';

    public $title = 'Components';

    public $description = 'Components';

    public $developmentOnly = true;

    public function with($block, $fields)
    {
        return [
            'buttons' => $this->buttons()
        ];
    }

    public function buttons()
    {
        $button_variations = [];

        $sizes = [
            Button::SIZE_EXPANDED,
            Button::SIZE_LARGE,
            Button::SIZE_MEDIUM,
            Button::SIZE_SMALL,
        ];

        $themes = [
            Button::THEME_PRIMARY,
            Button::THEME_SECONDARY,
            Button::THEME_HERO,
            Button::THEME_TERTIARY,
        ];

        $icon_positions = [
            Button::ICON_POSITION_LEFT,
            Button::ICON_POSITION_NONE,
            Button::ICON_POSITION_RIGHT
        ];

        $titles = [
            "Button",
            ""
        ];

        foreach ($sizes as $size) {
            foreach ($themes as $theme) {
                foreach ($icon_positions as $icon_position) {
                    foreach ($titles as $title) {
                        if ($icon_position == Button::ICON_POSITION_NONE && empty($title)) {
                            continue;
                        }
                        $button_variations[$size][] = [
                            'link' => [
                                'title' => $title,
                                'type' => Link::TYPE_LINK,
                                'link' => [
                                    'url' => '/'
                                ]
                            ],
                            'size' => $size,
                            'icon_position' => $icon_position,
                            'theme' => $theme,
                            'icon' => '<i class="fa-regular fa-xmark" aria-hidden="true"></i>'
                        ];
                    }
                }
            }
        }

        return $button_variations;
    }
}
