<?php

namespace Atlas\Components;

use Illuminate\View\Component;

class Card extends Component
{
    public function __construct()
    {
    }

    public function render()
    {
        return view('Components::card.card');
    }
}
