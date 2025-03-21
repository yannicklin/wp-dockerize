<?php

namespace Atlas\Blocks;

use Atlas\Core\Blocks\BaseBlock;

class ProductComparison extends BaseBlock
{
    public $name = 'product-comparison';
    public $title = 'Product Comparison';
    public $description = 'Product Comparison';

    public function with($block, $fields)
    {
        $tabs = get_field('Tabs');

        return array_merge(parent::with($block, $fields), [
            'tabs' => $tabs,
        ]);
    }
}
