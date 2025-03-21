<?php

namespace Atlas\Core\Extensions\ACF;

class FilterData
{
    public function register()
    {
        add_action('acf/format_value', [$this, 'updateFalseValues'], 10, 3);
    }

    public function updateFalseValues($value, $post_id, $field)
    {
        if ($field['type'] == 'true_false') {
            return $value;
        }
        if ($value === false) {
            return null;
        }
        return $value;
    }
}
