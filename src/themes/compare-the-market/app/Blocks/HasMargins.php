<?php

namespace App\Blocks;

interface HasMargins
{
    public const MG_ZERO = 'none';
    public const MG_SMALL = 'small';
    public const MG_MEDIUM = 'medium';
    public const MG_LARGE = 'large';
    public const MG_XLARGE = 'x-large';

    public const MG_DEFAULT_SET = [
        self::MG_ZERO,
        self::MG_SMALL,
        self::MG_MEDIUM,
        self::MG_LARGE,
        self::MG_XLARGE,
    ];

    public function availableMargins(): array;

    public function setDefaultMargin(): string;

    // This is only needed when we need to customise the default settings
    public function getACFGroupKey(): string;
}
