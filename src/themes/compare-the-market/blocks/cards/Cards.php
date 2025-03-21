<?php

namespace Atlas\Blocks;

use Atlas\Core\Blocks\BaseBlock;

class Cards extends BaseBlock
{
    public $name = 'cards';
    public $title = 'Cards';
    public $description = 'Cards';

    public function with($block, $fields)
    {
        $is_heading_white = false;

        if ($fields['branded_curve'] === 'top' && in_array($fields['branded_curve_colour'], ['blue-400', 'blue-500'])) {
            $is_heading_white = true;
        } elseif ($fields['branded_curve'] !== 'top' && 
                  !empty($fields['block_theme']['background_colour']) &&
                  in_array($fields['block_theme']['background_colour'], ['theme-blue', 'theme-dark-blue', 'theme-brand-gradient-1'])) {
            $is_heading_white = true;
        }

        return ['is_heading_white' => $is_heading_white];
    }
}
