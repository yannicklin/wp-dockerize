<?php

namespace Atlas\Blocks;

use App\Blocks\HasPaddings;
use App\Blocks\HasMargins;
use App\Blocks\HasBackgroundColors;
use Atlas\Core\Blocks\BaseBlock;

class CtaBanner extends BaseBlock implements HasMargins
{
    public $name = 'cta-banner';

    public $title = 'CTA Banner';

    public $description = 'CTA Banner';

    public function with($block, $fields)
    {
        $content_column = match ($fields['layout']) {
            'small' => 'col-lg-8',
            'large' => 'col-lg-4',
            'half'  => 'col-lg-6',
            'stack' => 'col-12',
            default => 'col-12',
        };

        $media_column = match ($fields['layout']) {
            'small' => 'col-lg-4',
            'large' => 'col-lg-8',
            'half'  => 'col-lg-6',
            'stack' => 'col-12',
            default => 'col-12',
        };

        // Block Sytle Custormize Margin
        $lgMargin = $fields['block_style']['block_margin_desktop'] ?? '';
        $margin = $fields['block_style']['block_margin_mobile'] ?? '';
        $marginStyle = $lgMargin ?
            sprintf(
                '--mt-lg:%dpx; --mb-lg:%dpx; --mt:%dpx; --mb:%dpx',
                $lgMargin['top'],
                $lgMargin['bottom'],
                $margin['top'],
                $margin['bottom']
            )
            : '';

        return [
            'block_contained' => $fields['block_style']['contained'] ?? false,
            'block_background_choice' => $fields['block_style']['background'] ?? 'colour',
            'block_background_image' => $fields['block_style']['background_image'] ?? [],
            'imagelink' => $fields['imagelink'] ?? '',
            'content_column' => $content_column,
            'media_column' => $media_column,
            'inline_margin_style' => $marginStyle
        ];
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
        return 'group_659356834deba';
    }
}
