<?php

namespace Atlas\Components;

use Illuminate\View\Component;

class PromoBanner extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view(
            'Components::promo-banner.promo-banner',
        );
    }
}
