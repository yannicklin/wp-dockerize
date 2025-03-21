<?php

namespace Atlas\Blocks;

use App\Blocks\HasPaddings;
use App\Blocks\HasMargins;
use Atlas\Core\Blocks\BaseBlock;

class CustomerFeedback extends BaseBlock implements HasPaddings, HasMargins
{
    public $name = 'customer-feedback';

    public $title = 'Customer Feedback';

    public $description = 'Customer Feedback';

    public function with($block, $fields)
    {
        $product_review = get_field('product_review_rating', 'options');
        $feefo = get_field('feefo_rating', 'options');

        $trust_text = get_field('trust_display_text', 'options');
        $title_block = get_field('title_block', 'options')['title_block'];

        if (isset($fields['content_override']) && $fields['content_override']) {
            $trust_text = $fields['trust_display_text'];
            $title_block = $fields['title_block'];
        }

        return [
            'title_block' => $title_block,
            'product_review' => $product_review,
            'feefo' => $feefo,
            'trust_text' => $trust_text,
            'data_date' => get_field('data_update_date', 'options'),
            'divider' => $fields['divider']
        ];
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
        return 'group_65308837aad6e';
    }
}
