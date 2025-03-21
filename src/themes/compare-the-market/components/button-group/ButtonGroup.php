<?php

namespace Atlas\Components;

use Illuminate\View\Component;

class ButtonGroup extends Component
{
    public $buttons;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($acf = [])
    {
        if (!empty($acf)) {
            $this->buttons = $acf['buttons'] ?? [];
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('Components::button-group.button-group');
    }
}
