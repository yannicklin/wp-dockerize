<?php

namespace Atlas\Blocks;

use Atlas\Core\Blocks\BaseBlock;

class ContentCarousel extends BaseBlock
{
    public $name = 'content-carousel';

    public $title = 'Content Carousel';

    public $description = 'Content Carousel';

    public function with($block, $fields)
    {
        return parent::with($block, $fields);
    }
}
