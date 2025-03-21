<?php

namespace Atlas\Blocks;

use Atlas\Core\Blocks\BaseBlock;

class SavingsClaim extends BaseBlock
{
    public $name = 'savings-claim';

    public $title = 'Savings Claim';

    public $description = 'Savings Claim';

    public function with($block, $fields)
    {
        $claims_data = [];
        $claims_origin = $fields['claims'];
        $today_date = date(time());

        foreach ($claims_origin as $claim) {
            $expiry_date = strtotime(str_replace('/', '-', $claim['expiry_date']));
            if ($expiry_date > $today_date) {
                $claims_data[] = $claim;
            }
        }

        $is_header_white = in_array($fields['block_theme']['background_colour'], ['theme-blue', 'theme-dark-blue']);
        $is_disclaimer_white = in_array($fields['block_theme']['background_colour'], ['theme-blue', 'theme-dark-blue']);
        switch (($fields['branded_curve'] ?? 'none')) {
            case 'none':
                // Keep the settings as they are
                break;
            case 'top':
                $is_header_white = in_array($fields['branded_curve_colour'], ['blue-400', 'blue-500']);
                break;
            case 'bottom':
                $is_disclaimer_white = in_array($fields['branded_curve_colour'], ['blue-400', 'blue-500']);
                break;
        }

        return [
            'claims_count' => count($claims_data) ?? 0,
            'claims_data' => $claims_data,
            'is_heading_white' => $is_header_white,
            'is_disclaimer_white' => $is_disclaimer_white,
        ];
    }
}
