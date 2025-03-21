<?php

namespace Atlas\Components;

use Illuminate\View\Component;

class Tag extends Component
{
    public $type;
    public $size;
    public $title;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type = '', $size = '', $title = '')
    {
        $this->type = $type;
        $this->size = $size;
        $this->title = $title;
    }


    public function classes(): array
    {
        $classes = ['component component-tag tag'];
        $classes[] = 'tag-' . $this->type;
        $classes[] = 'tag-' . $this->size;

        return $classes;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('Components::tag.tag');
    }
}
