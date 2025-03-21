<?php

namespace Atlas\Blocks;

use Atlas\Core\Blocks\BaseBlock;

class AdvancedContent extends BaseBlock
{
    public $name = 'advanced-content';

    public $title = 'Advanced Content';

    public $description = 'Advanced Content';

    public function with($block, $fields)
    {
        foreach ($fields['rows'] as $row_index => $row) {
            foreach ($row['columns'] as $column_index => $column) {
                $desktopPadding = match ($column['padding_style']) {
                    'all'         => 'm-lg-' . $column['padding_amount'],
                    'top-bottom'  => 'my-lg-' . $column['padding_amount'],
                    'left-right'  => 'mx-lg-' . $column['padding_amount'],
                    'top'         => 'mt-lg-' . $column['padding_amount'],
                    'bottom'      => 'mb-lg-' . $column['padding_amount'],
                    'left'        => 'ms-lg-' . $column['padding_amount'],
                    'right'       => 'me-lg-' . $column['padding_amount'],
                    'none'        => 'm-lg-0',
                    default       => '',
                };

                $mobilePadding = match ($column['padding_style_mobile']) {
                    'all'         => 'm-' . $column['padding_amount_mobile'],
                    'top-bottom'  => 'my-' . $column['padding_amount_mobile'],
                    'left-right'  => 'mx-' . $column['padding_amount_mobile'],
                    'top'         => 'mt-' . $column['padding_amount_mobile'],
                    'bottom'      => 'mb-' . $column['padding_amount_mobile'],
                    'left'        => 'ms-' . $column['padding_amount_mobile'],
                    'right'       => 'me-' . $column['padding_amount_mobile'],
                    'none'        => 'm-lg-0',
                    default       => '',
                };

                $padding = join(' ', array_filter([$desktopPadding, $mobilePadding, 'p-0']));

                $fields['rows'][$row_index]['columns'][$column_index]['custom_class'] = $padding;
            }
        }

        return parent::with($block, $fields);
    }
}
