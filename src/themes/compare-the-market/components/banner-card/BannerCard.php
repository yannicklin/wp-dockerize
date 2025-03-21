<?php

namespace Atlas\Components;

use Illuminate\View\Component;

class BannerCard extends Component
{
    public $type;
    public $background;
    public $rounded;
    public $padding;

    public function __construct($type = 'flat', $background = 'alabaster-100', $rounded = true, $padding = true)
    {
        $this->type = $type;
        $this->background = $background;
        $this->rounded = $rounded;
        $this->padding = $padding;
    }

    public function classes(): array
    {
        $classes = ['banner-card'];
        $classes[] = $this->padding ? 'p-24' : 'p-0';
        $classes[] = $this->rounded ? 'radius-s' : 'rounded-0';
        $classes[] = $this->type;
        $classes[] = 'bg-' . $this->background;
        $classes[] = in_array($this->background, ['blue-400', 'blue-500']) ? 'text-white' : 'text-blue-500';

        return $classes;
    }

    public function render()
    {
        return view('Components::banner-card.banner-card');
    }
}
