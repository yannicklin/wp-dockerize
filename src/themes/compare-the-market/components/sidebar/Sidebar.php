<?php

namespace Atlas\Components;

use Roots\Acorn\View\Component;

class Sidebar extends Component
{
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
        return view('Components::sidebar.sidebar');
    }
}
