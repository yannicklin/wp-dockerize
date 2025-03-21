<?php

namespace Atlas\Components;

use Illuminate\View\Component;

class StarRating extends Component
{
    public $rating = 0;
    public $size = 30;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($size, $rating)
    {
        $this->size = $size;
        $this->rating = $rating;
    }



    public function classes(): array
    {
        $classes = ['component component-star-rating'];

        return $classes;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('Components::star-rating.star-rating');
    }
}
