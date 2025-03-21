<?php

namespace Atlas\Components;

use Illuminate\View\Component;

class AppPromoBanner extends Component
{
    public $buttons;
    public $icon;
    public $text;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($buttons, $icon, $text)
    {
        $this->buttons = $buttons;
        $this->icon = $icon;
        $this->text = $text;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view(
            'Components::app-promo-banner.app-promo-banner',
        );
    }
}
