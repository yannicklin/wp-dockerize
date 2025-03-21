<?php

namespace Atlas\Blocks;

use Atlas\Core\Blocks\BaseBlock;

class BestPricePromiseBanner extends BaseBlock
{
    public $name = 'best-price-promise-banner';

    public $title = 'Card Banner';

    public $description = 'Card Banner';

    public function with($block, $fields)
    {
        return [
            'sized_image' => $this->getSizedImage($fields)
        ];
    }

    public function getSizedImage($fields)
    {
        $imageURL = '';

        if (!empty($fields['image'])) {
            switch ($fields['image_size']) {
                case 144:
                    $imageURL = $fields['image']['sizes']['image_size_small'];
                    break;
                case 240:
                    $imageURL = $fields['image']['sizes']['image_size_medium'];
                    break;
                case 408:
                    $imageURL = $fields['image']['sizes']['image_size_large'];
                    break;
            }
        }

        return $imageURL;
    }
}
