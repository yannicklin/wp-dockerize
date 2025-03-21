<?php

namespace Atlas\Blocks;

use App\Blocks\HasBackgroundColors;
use App\Blocks\HasPaddings;
use App\Blocks\HasMargins;
use Atlas\Core\Blocks\BaseBlock;
use Atlas\Taxonomies\Vertical;

class VerticalBanner extends BaseBlock implements HasBackgroundColors, HasPaddings, HasMargins
{
    public $name = 'vertical-banner';

    public $title = 'Vertical Banner';

    public $description = 'Vertical Banner';

    public function with($block, $fields)
    {
        global $post;
        $vertical = Vertical::getVerticalinPage($post, true);
        $banner_cta = is_null($vertical) ? [] : Vertical::getVerticalBannerDefaultCTAs($vertical);

        // Check Customized
        if (true == ($customized_buttons = $fields['customize_buttons'] ?? false)) {
            $banner_cta = [];
            $banner_cta['button'] = $fields['cta_button']['button'] ?? [];
            $banner_cta['display_phone_number'] = $fields['display_phone_number'] ?? false;
            $banner_cta['phone'] = $fields['phone'] ?? '';
            $banner_cta['display_opening_hours'] = $fields['display_opening_hours'] ?? false;
        }

        return [
            'imagelink' =>  $fields['imagelink'] ?? '',
            'banner_cta_buttons' => $banner_cta,
            'opening_hours_api' =>  get_field('opening_hours_api', 'options'),
        ];
    }

    public function availableBackgroundColors(): array
    {
        return HasBackgroundColors::BG_DEFAULT_SET;
    }

    public function setDefaultBackgroundColor(): string
    {
        return HasBackgroundColors::BG_BRAND_GRADIENT;
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
        return 'group_654d78434c5c7';
    }
}
