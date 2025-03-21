<?php

namespace Atlas\Components;

use Illuminate\View\Component;

class AggregateRating extends Component
{
    public $aggregate_rating = 0;
    public $size = 30;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($size)
    {
        $this->size = $size;
        $this->aggregate_rating = $this->getRating();
    }

    public function getRating(): float
    {
        $productreview = get_field('product_review_rating', 'options');
        $feefo = get_field('feefo_rating', 'options');

        $productreview_rating = $productreview['rating'] * 10;
        $productreview_counts = $productreview['number_of_reviews'];
        $feefo_rating = $feefo['rating'] * 10;
        $feefo_counts = $feefo['number_of_reviews'];

        return floor((array_sum([$productreview_rating * $productreview_counts, $feefo_rating * $feefo_counts]) / array_sum([$productreview_counts, $feefo_counts]))) / 10;
    }


    public function classes(): array
    {
        $classes = ['component component-aggregate-rating'];

        return $classes;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('Components::aggregate-rating.aggregate-rating');
    }
}
