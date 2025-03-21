<?php

namespace Atlas\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TitleBlockHeadless extends Component
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
     * @return View|string
     */
    public function render()
    {
        return view('Components::title-block-headless.title-block-headless');
    }
}
