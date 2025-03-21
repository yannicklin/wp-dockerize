<?php

namespace Atlas\Blocks;

use App\Blocks\HasBackgroundColors;
use App\Blocks\HasPaddings;
use App\Blocks\HasMargins;
use Atlas\Core\Blocks\BaseBlock;
use Atlas\Taxonomies\Vertical;

class WrittenReviewedBy extends BaseBlock implements HasBackgroundColors, HasPaddings, HasMargins
{
    public $name = 'written-reviewed-by';

    public $title = 'Written/Reviewed By';

    public $description = 'Written/Reviewed By';

    public function with($block, $fields)
    {
        global $post;
        $vertical = Vertical::getVerticalinPage($post, false);
        return parent::with($block, $fields) + [
            'slim_verion' => $fields['hide_reviewedby_banner'] ?? false,
            'vertical_icon' => get_field('icon', Vertical::$slug . '_' . $vertical?->term_id),
            'author_avatar_size' => 48,
        ];
    }

    public function availableBackgroundColors(): array
    {
        return HasBackgroundColors::BG_DEFAULT_SET;
    }

    public function setDefaultBackgroundColor(): string
    {
        return HasBackgroundColors::BG_LIGHT_BLUE;
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
        return 'group_64ffb7b101a2a';
    }
}
