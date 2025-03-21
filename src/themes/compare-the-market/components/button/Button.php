<?php

namespace Atlas\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    public $link;
    public $theme;
    public $size;
    public $icon_position;
    public $icon;
    public $classes;

    public const SIZE_SMALL = 'small';
    public const SIZE_MEDIUM = 'medium';
    public const SIZE_LARGE = 'large';
    public const SIZE_EXPANDED = 'expanded';

    public const THEME_PRIMARY = 'primary';
    public const THEME_SECONDARY = 'secondary';
    public const THEME_HERO = 'hero';
    public const THEME_TERTIARY = 'text';

    public const ICON_POSITION_NONE = 'none';
    public const ICON_POSITION_LEFT = 'left';
    public const ICON_POSITION_RIGHT = 'right';

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $title = '',
        $href = '',
        $theme = self::THEME_PRIMARY,
        $size = self::SIZE_MEDIUM,
        $icon_position = self::ICON_POSITION_NONE,
        $icon = [],
        $acf = []
    ) {
        if (!empty($acf)) {
            $this->link = $acf['link'] ?? [];
            $this->theme = $acf['theme'] ?? '';
            $this->size = $acf['size'] ?? '';
            $this->icon_position = $acf['icon_position'] ?? '';
            $this->icon = $acf['icon'] ?? [];
        } else {
            $this->link = [
                'title' => $title,
                'type' => Link::TYPE_LINK,
                'link' => [
                    'url' => $href
                ]
            ];
            $this->theme = $theme;
            $this->size = $size;
            $this->icon_position = $icon_position;
            $this->icon = $icon;
        }
    }

    public function classes(): array
    {
        $classes = ['btn'];
        $classes[] = 'btn-' . $this->theme;
        $classes[] = 'btn-' . $this->size;

        if ($this->link['title']) {
            $classes[] = 'icon-' . $this->icon_position;
        } else {
            $classes[] = 'no-title';
        }

        return $classes;
    }

    public function render(): View
    {
        return view('Components::button.button');
    }
}
