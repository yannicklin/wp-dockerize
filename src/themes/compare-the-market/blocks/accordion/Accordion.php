<?php

namespace Atlas\Blocks;

use Atlas\Core\Blocks\BaseBlock;

class Accordion extends BaseBlock
{
    public $name = 'accordion';
    public $title = 'Accordion';
    public $description = 'Accordion';

    public function with($block, $fields)
    {
        $data = parent::with($block, $fields);

        return $data;
    }
}
