<?php

namespace Atlas\Blocks;

use App\Blocks\HasPaddings;
use App\Blocks\HasMargins;
use Atlas\Core\Blocks\BaseBlock;
use Atlas\Taxonomies\Vertical;

class StandardHero extends BaseBlock implements HasPaddings, HasMargins
{
    public $name = 'standard-hero';

    public $title = 'Standard Hero';

    public $description = 'Standard Hero';

    public function with($block, $fields)
    {
        $image_type = $fields['image_type'];
        $featured_image = $fields['featured_image']['image'];

        $desktop_ratio = $featured_image['image']
            ? $image_type == 'square' ? '100' : $this->getRatio($featured_image, 'image')
            : '';
        $tablet_ratio = $featured_image['tablet_image']
            ? $image_type == 'square' ? '100' : $this->getRatio($featured_image, 'tablet_image')
            : '';
        $mobile_ratio = $featured_image['mobile_image']
            ? $image_type == 'square' ? '100' : $this->getRatio($featured_image, 'mobile_image')
            : '';

        global $post;
        $vertical = Vertical::getVerticalinPage($post, true);
        $vertical_cta = is_null($vertical) ? [] : Vertical::getStandardHeroDefaultCTAs($vertical);

        return [
            'imagelink' => $fields['imagelink'] ?? '',
            'hidebreadcrumbs' =>  $fields['hidebreadcrumbs'] ?? false,
            'vertical_cta_buttons' => $vertical_cta,
            'desktop_ratio' => $desktop_ratio,
            'tablet_ratio' => $tablet_ratio,
            'mobile_ratio' => $mobile_ratio,
        ];
    }

    private function getRatio($image, $image_type)
    {
        return (($image[$image_type]['height'] ?? 1) / ($image[$image_type]['width'] ?? 1)) * 100;
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
        return 'group_6567ec8bcd12a';
    }
}
