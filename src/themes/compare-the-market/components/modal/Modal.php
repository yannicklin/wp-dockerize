<?php

namespace Atlas\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{
    public function render()
    {
        return view('Components::modal.modal');
    }
}
