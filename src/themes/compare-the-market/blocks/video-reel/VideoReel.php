<?php

namespace Atlas\Blocks;

use App\Blocks\HasBackgroundColors;
use Atlas\Core\Blocks\BaseBlock;

class VideoReel extends BaseBlock
{
    public $name = 'video-reel';
    public $title = 'Video Reel';
    public $description = 'Video Reel';

    public function with($block, $fields)
    {
        return [
            'modalId' => uniqid('modal-')
        ];
    }
}
