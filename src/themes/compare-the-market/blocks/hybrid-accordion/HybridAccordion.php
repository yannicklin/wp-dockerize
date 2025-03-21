<?php

namespace Atlas\Blocks;

use Atlas\Core\Blocks\BaseBlock;

class HybridAccordion extends BaseBlock
{
    public $name = 'hybrid-accordion';
    public $title = 'Hybrid Accordion';
    public $description = 'Hybrid Accordion';

    public function with($block, $fields)
    {
        $data = parent::with($block, $fields);

        return $data;
    }
}
