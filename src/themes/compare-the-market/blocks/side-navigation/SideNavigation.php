<?php

namespace Atlas\Blocks;

use App\Blocks\HasBackgroundColors;
use App\Blocks\HasPaddings;
use App\Blocks\HasMargins;
use Atlas\Core\Blocks\BaseBlock;

class SideNavigation extends BaseBlock implements HasBackgroundColors, HasPaddings, HasMargins
{
    public $name = 'side-navigation';

    public $title = 'Side Navigation';

    public $description = 'Side Navigation';

    private $blockMap = [
        'accordion' => Accordion::class,
        'content' => Content::class,
        'expert_top_tips' => ExpertTopTips::class,
        'standard_left_right' => StandardLeftRight::class,
        'hybrid_accordion' => HybridAccordion::class,
        'video' => Video::class,
        'expert_cards' => ExpertCards::class,
        'posts' => Posts::class,
        'cta_banner' => CtaBanner::class,
        'card_banner' => BestPricePromiseBanner::class
    ];

    public function with($block, $fields)
    {
        return parent::with($block, $fields + [
            'block_classes' => $this->buildBlockClasses($fields),
        ]);
    }

    public function buildBlockClasses($fields)
    {
        $blocks = [];

        foreach ($fields['blocks'] as $block) {
            if (!isset($this->blockMap[$block['acf_fc_layout']])) {
                $blocks[] = null;
                continue;
            }
            $blocks[] = new $this->blockMap[$block['acf_fc_layout']]();
        }

        return $blocks;
    }

    public function availableBackgroundColors(): array
    {
        return [];
    }

    public function setDefaultBackgroundColor(): string
    {
        return '';
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
        return 'group_64eebffbcdce2';
    }
}
