<?php

// This Component (Breadcrumbs) is not used anywhere. -- 08 AUG 2024

namespace Atlas\Blocks;

use App\Features\BreadcrumbConcatenation;
use Atlas\Core\Blocks\BaseBlock;
use Atlas\Core\Features\HasFeature;

class Breadcrumbs extends BaseBlock implements HasFeature
{
    public $name = 'breadcrumbs';

    public $title = 'Breadcrumbs';

    public $description = 'Breadcrumbs';

    public static function features(): array
    {
        return [
            BreadcrumbConcatenation::class
        ];
    }

    public function with($block, $fields)
    {
        return parent::with($block, $fields);
    }
}
