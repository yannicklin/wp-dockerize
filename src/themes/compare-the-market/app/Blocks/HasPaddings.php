<?php

namespace App\Blocks;

interface HasPaddings
{
    public const PD_ZERO = 'none';
    public const PD_SMALL = 'small';
    public const PD_MEDIUM = 'medium';
    public const PD_LARGE = 'large';
    public const PD_XLARGE = 'x-large';

    public const PD_DEFAULT_SET = [
        self::PD_ZERO,
        self::PD_SMALL,
        self::PD_MEDIUM,
        self::PD_LARGE,
        self::PD_XLARGE,
    ];

    public function availablePaddings(): array;

    public function setDefaultPadding(): string;

    // This is only needed when we need to customise the default settings
    public function getACFGroupKey(): string;
}
