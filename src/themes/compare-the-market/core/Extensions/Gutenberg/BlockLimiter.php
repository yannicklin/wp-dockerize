<?php

namespace Atlas\Core\Extensions\Gutenberg;

use Atlas\Blocks\SomeBlock;
use Atlas\Core\Blocks\BaseBlock;
use Illuminate\Support\Str;

/**
 * Handles limiting blocks to specific post types
 */
class BlockLimiter
{
    public function register()
    {
        add_filter('allowed_block_types_all', function ($allowed_block_types, $block_editor_context) {
            $post = $block_editor_context->post;

            // If we're on the ACF Field Group Page, module scoping or default modules pages
            // Just grab all possible blocks
            if (
                empty($post)
                || $post->post_type === 'acf-field-group'
                || $post->base === 'theme-settings_page_module-scoping'
                || $post->base === 'theme-settings_page_default-modules'
            ) {
                return $allowed_block_types;
            }

            // Otherwise, limit the available blocks to ACF blocks or the ones defined under /config/theme.php
            return array_merge(
                self::filteredAcfBlocks($post->post_type),
                config('theme.blocks.allowed')
            );
        }, 10, 2);
    }

    /**
     * Only return ACF blocks that should be usable on given post types
     * @return int[]|string[]
     * @throws \ReflectionException
     */
    public static function filteredAcfBlocks(string $post_type): array
    {
        $acf_block_types = acf_get_block_types();

        foreach ($acf_block_types as $block_type) {
            // get block class name from reflected render callback
            /** @var ?BaseBlock $blockClass */
            $blockClass = (new \ReflectionFunction($block_type['render_callback']))->getClosureThis();

            if (!$blockClass instanceof BaseBlock) {
                continue;
            }

            // get the INCLUDE_IN_POST_TYPE and EXCLUDE_FROM_POST_TYPE constants from the block class
            // and check to see if the current post type is either not in the INCLUDE_IN_POST_TYPE constant
            // or the current post type is in the EXCLUDE_FROM_POST_TYPE constant
            // and remove them from the available blocks on the current post type
            $includedPostTypes = $blockClass::INCLUDE_IN_POST_TYPE;
            $excludedPostTypes = $blockClass::EXCLUDE_FROM_POST_TYPE;

            if (!empty($excludedPostTypes) && in_array($post_type, $excludedPostTypes)) {
                unset($acf_block_types[$block_type['name']]);
            }

            if (!empty($includedPostTypes) && !in_array($post_type, $includedPostTypes)) {
                unset($acf_block_types[$block_type['name']]);
            }
        }

        return array_keys($acf_block_types);
    }
}
