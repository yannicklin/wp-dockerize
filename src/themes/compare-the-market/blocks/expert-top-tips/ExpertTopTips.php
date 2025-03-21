<?php

namespace Atlas\Blocks;

use Atlas\Core\Blocks\BaseBlock;

class ExpertTopTips extends BaseBlock
{
    public $name = 'expert-top-tips';

    public $title = 'Expert Top Tips';

    public $description = 'Expert Top Tips';

    public function with($block, $fields)
    {
        return parent::with($block, $fields);
    }
}
