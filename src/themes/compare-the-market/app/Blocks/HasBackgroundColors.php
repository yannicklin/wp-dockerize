<?php

namespace App\Blocks;

interface HasBackgroundColors
{
    public const BG_BRAND_GRADIENT = 'theme-brand-gradient-1';
    public const BG_WHITE = 'theme-white';
    public const BG_BLUE = 'theme-blue';
    public const BG_CREAM_WHITE = 'theme-cream-white';
    public const BG_LIGHT_BLUE = 'theme-light-blue';
    public const BG_DARK_BLUE = 'theme-dark-blue';
    public const BG_TRANSPARENT = 'theme-transparent';

    public const BG_DEFAULT_SET = [
        self::BG_BRAND_GRADIENT,
        self::BG_WHITE,
        self::BG_BLUE,
        self::BG_CREAM_WHITE,
        self::BG_LIGHT_BLUE,
        self::BG_DARK_BLUE,
        self::BG_TRANSPARENT,
    ];

    public function availableBackgroundColors(): array;

    public function setDefaultBackgroundColor(): string;

    // This is only needed when we need to customise the default settings
    public function getACFGroupKey(): string;
}
