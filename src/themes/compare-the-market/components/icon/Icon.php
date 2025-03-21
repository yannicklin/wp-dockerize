<?php

namespace Atlas\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Icon extends Component
{
    public $icon;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($icon = '', $acf = [])
    {
        if (!empty($acf)) {
            $this->icon = $acf['file'];
        } else {
            $this->icon =  str_contains($icon, '.svg') ?
                $icon :
                get_stylesheet_directory() . '/resources/icons/' . $icon . '.svg';
        }
    }

    public function render(): View
    {
        return view('Components::icon.icon');
    }
}
