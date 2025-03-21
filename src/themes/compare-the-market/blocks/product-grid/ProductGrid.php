<?php

namespace Atlas\Blocks;

use App\Blocks\HasBackgroundColors;
use App\Blocks\HasPaddings;
use App\Blocks\HasMargins;
use Atlas\Core\Blocks\BaseBlock;

class ProductGrid extends BaseBlock implements HasBackgroundColors, HasPaddings, HasMargins
{
    public $name = 'product-grid';

    public $title = 'Product Grid';

    public $description = 'Product Grid';

    public function with($block, $fields)
    {
        return parent::with($block, $fields);
    }

    public function availableBackgroundColors(): array
    {
        return [];
    }

    public function setDefaultBackgroundColor(): string
    {
        return '';
    }

    public function availablePaddings(): array
    {
        return [];
    }

    public function setDefaultPadding(): string
    {
        return '';
    }

    public function availableMargins(): array
    {
        return [];
    }

    public function setDefaultMargin(): string
    {
        return '';
    }

    public function getACFGroupKey(): string
    {
        return 'group_65078e9dd22a8';
    }
}
