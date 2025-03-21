<?php

namespace Atlas\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TitleBlock extends Component
{
    public $title;
    public $title_type;


    public $subtitle;
    public $subtitle_type;

    public $content;
    public $color;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $subtitle = '',
        $title = '',
        $content = '',
        $acf = [],
        $color = '',
        $subtitleType = 'div',
        $titleType = 'h2'
    ) {

        $this->color = $color;

        if (!empty($acf)) {
            $this->subtitle = $acf['subtitle'] ?? '';
            $this->title = $acf['title'] ?? '';
            $this->content = $acf['content'] ?? '';
            $this->title_type = $acf['title_type'] ?? 'h2';
            $this->subtitle_type = $acf['subtitle_type'] ?? 'div';
        } else {
            $this->subtitle = $subtitle;
            $this->title = $title;
            $this->content = $content;
            $this->title_type = $titleType;
            $this->subtitle_type = $subtitleType;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('Components::title-block.title-block');
    }
}
