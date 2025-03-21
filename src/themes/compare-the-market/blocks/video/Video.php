<?php

namespace Atlas\Blocks;

use Atlas\Core\Blocks\BaseBlock;

class Video extends BaseBlock
{
    public $name = 'video';
    public $title = 'Video';
    public $description = 'Video';

    public function with($block, $fields)
    {
        return parent::with($block, $fields);
    }
}