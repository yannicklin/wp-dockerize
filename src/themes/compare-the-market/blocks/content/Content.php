<?php

namespace Atlas\Blocks;

use Atlas\Core\Blocks\BaseBlock;

class Content extends BaseBlock
{
    public $name = 'content';

    public $title = 'Content';

    public $description = 'Content';

    public $icon = 'text-page';

    public function with($block, $fields)
    {
        return parent::with($block, $fields);
    }
}
