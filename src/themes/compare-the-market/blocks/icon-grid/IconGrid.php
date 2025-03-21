<?php

namespace Atlas\Blocks;

use Atlas\Core\Blocks\BaseBlock;

class IconGrid extends BaseBlock
{
    public $name = 'icon-grid';

    public $title = 'Icon Grid';

    public $description = 'Icon Grid';

    public function with($block, $fields)
    {
        return parent::with($block, $fields);
    }
}
