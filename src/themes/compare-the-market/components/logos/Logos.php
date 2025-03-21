<?php

namespace Atlas\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Logos extends Component
{
    public function __construct(
        public array $logos = [],
        public bool $randomize = false,
        public string $disclaimer = '',
        public string $viewAllMobile = 'View all',
        public string $viewLessMobile = 'View less',
        public bool $headings = false,
        public string|null $wrapperOverride = '',
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('Components::logos.logos');
    }
}
