<?php

namespace Atlas\Components;

use Atlas\Core\Blocks\BaseBlock;
use Illuminate\View\Component;

class CtmAccordion extends Component
{
    /** @var BaseBlock An instance of the block object that the Accordion is used on  */
    public $block;

    /** @var string The title of the expand button */
    public $showTitle;

    /** @var string The title of the collapse button */
    public $hideTitle;
    public $id;

    public function __construct($block, $id, $showTitle, $hideTitle)
    {
        $this->block = $block;
        $this->showTitle = $showTitle;
        $this->hideTitle = $hideTitle;
        $this->id = $id;
    }
    public function render()
    {
        return view('Components::ctm-accordion.ctm-accordion');
    }
}
