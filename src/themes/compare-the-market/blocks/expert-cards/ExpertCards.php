<?php

namespace Atlas\Blocks;

use Atlas\Core\Blocks\BaseBlock;

class ExpertCards extends BaseBlock
{
    public $name = 'expert-cards';

    public $title = 'Expert Cards';

    public $description = 'Expert Cards';

    public function with($block, $fields)
    {
        return parent::with($block, $fields);
    }
}
