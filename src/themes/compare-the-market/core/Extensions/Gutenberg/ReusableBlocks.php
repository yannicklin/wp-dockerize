<?php

namespace Atlas\Core\Extensions\Gutenberg;

class ReusableBlocks
{
    public function register()
    {
        // admin junk
        add_action('admin_menu', function () {
            if (!get_theme_support('atlas-reusable-blocks')) {
                return;
            }

            add_menu_page(
                'Reusable Blocks',
                'Reusable Blocks',
                'edit_posts',
                'edit.php?post_type=wp_block',
                '',
                'dashicons-editor-table',
                22
            );
        });
    }
}
