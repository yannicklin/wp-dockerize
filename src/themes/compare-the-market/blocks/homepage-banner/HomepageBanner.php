<?php

namespace Atlas\Blocks;

use App\Blocks\HasBackgroundColors;
use App\Blocks\HasPaddings;
use App\Blocks\HasMargins;
use Atlas\Core\Blocks\BaseBlock;

class HomepageBanner extends BaseBlock implements HasBackgroundColors, HasPaddings, HasMargins
{
    public $name = 'homepage-banner';

    public $title = 'Homepage Banner';

    public $description = 'Homepage Banner';

    public function with($block, $fields)
    {

        $widgetBGColour = $this->getWidgetTextColour($fields);

        return [
            'widget_theme_bg' => $widgetBGColour,
            'widget_theme_is_dark' => $this->isColorTooDark($widgetBGColour)
        ];
    }

    public function isColorTooDark($color)
    {
        $color = str_replace('#', '', $color);
        $rgb = hexdec($color);   // convert rrggbb to decimal
        $r   = ($rgb >> 16) & 0xff;  // extract red
        $g   = ($rgb >> 8) & 0xff;  // extract green
        $b   = ($rgb >> 0) & 0xff;  // extract blue

        $luma = 0.2126 * $r + 0.7152 * $g + 0.0722 * $b; // per ITU-R BT.709

        // too dark
        if ($luma < 150) {
            return true;
        }

        return false;
    }

    public function getWidgetTextColour($fields)
    {
        if (!empty($fields['trust_widget_colour'])) {
            if ($fields['trust_widget_colour'] == "custom") {
                return $fields['trust_widget_hex'];
            } else {
                return $fields['trust_widget_colour'];
            }
        } else {
            return '';
        }
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
        return 'group_65024185d57ec';
    }
}
