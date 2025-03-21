<?php

namespace Atlas\Core\Extensions\Gutenberg;

use Atlas\Core\Blocks\BaseBlock;

/**
 * Registers block categories
 */
class BlockCategories
{
    public function register()
    {
        add_filter('block_categories_all', function ($categories, $post) {
            return array_merge(
                config('theme.blocks.categories'),
                $categories
            );
        }, 10, 2);
    }
}
