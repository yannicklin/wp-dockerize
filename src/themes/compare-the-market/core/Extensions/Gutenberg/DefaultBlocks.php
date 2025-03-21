<?php

namespace Atlas\Core\Extensions\Gutenberg;

use Illuminate\Support\Str;

/**
 * Adds functionality to automatically add blocks to specific post types when they are created
 */
class DefaultBlocks
{
    public function register()
    {

        add_action('acf/init', function () {
            if (!get_theme_support('acf-default-blocks')) {
                return;
            }

            $this->generateDefaultBlocksFields();
            $this->registerOptionsSubPage();

            add_action('enqueue_block_editor_assets', [$this, 'registerEditorAssets']);
        });
    }

    public function registerOptionsSubPage()
    {
        acf_add_options_sub_page(
            [
                'page_title'  => __('Default Blocks'),
                'menu_title'  => __('Default Blocks'),
                'slug'        => 'default-modules',
                'parent_slug' => 'theme-settings',
                'autoload'    => true
            ]
        );
    }

    public function registerEditorAssets()
    {
        $currentScreen = \get_current_screen();

        if (!$currentScreen->post_type) {
            return;
        }

        $fields = get_fields('option')["blocks_posttype_{$currentScreen->post_type}"] ?? [];

        $blockNames = array_map(function ($field) use ($currentScreen) {
            return $field["field_blocks_posttype_{$currentScreen->post_type}_block"] ?? '';
        }, $fields ?: []);

        if (!empty($blockNames)) {
            $this->registerDefaultBlocksScript($blockNames);
        }
    }

    public function generateDefaultBlocksFields()
    {
        $fields = [];

        foreach ($this->getPostTypes() as $postType) {
            // Create a left tab for each post type
            $fields[] = [
                'key'       => "field_modules_posttype_{$postType->name}_tab",
                'label'     => $postType->label,
                'name'      => '',
                'type'      => 'tab',
                'placement' => 'left',
                'endpoint'  => 0
            ];

            // Create a new repeater field for each post type
            $fields[] = [
                'key'           => "field_blocks_posttype_{$postType->name}",
                'label'         => __(Str::of($postType->name)->title() . ' Blocks'),
                'name'          => "blocks_posttype_{$postType->name}",
                'type'          => 'repeater',
                'display'       => 'seamless',
                'layout'        => 'block',
                'prefix_name'   => 1,
                'button_label'  => __('Add Block')
            ];

            // Create a list of blocks that can be used in the repeater as a select field
            $choices = [];

            foreach (BlockLimiter::filteredAcfBlocks($postType->name) as $block) {
                $choices[$block] =  Str::of($block)->replace('acf/', '')->replace('-', ' ')->ucfirst();
            }

            acf_add_local_field([
                'key'     => "field_blocks_posttype_{$postType->name}_block",
                'name'    => "field_blocks_posttype_{$postType->name}_block",
                'parent'  => "field_blocks_posttype_{$postType->name}",
                'label'   => 'Block',
                'type'    => 'select',
                'choices' => $choices,
                'ui'      => 1
            ]);
        }

        // Output the fields onto the default blocks option page
        acf_add_local_field_group([
            'key'       => 'group_module_framework',
            'title'     => 'Default Blocks',
            'fields'    => $fields,
            'location' => [
                [
                    [
                        'param'     => 'options_page',
                        'operator'  => '==',
                        'value'     => 'default-modules'
                    ]
                ]
            ]
        ]);
    }

    private function getPostTypes()
    {
        $postTypes = get_post_types([
            'public' => true,
            'show_ui' => true
        ], 'objects');

        return array_filter($postTypes, function ($postType) {
            return $postType->name !== 'attachment';
        });
    }

    private function registerDefaultBlocksScript($blockNames)
    {
        [$styles, $scripts, $isHot] = vite([
            'resources/scripts/default-blocks.ts'
        ]);

        foreach ($scripts as $handle => $script) {
            wp_enqueue_script($handle, $script, ['acf-blocks'], null, true);
        }

        // If vite is running in dev mode it needs module tags for each script
        if ($isHot) {
            add_filter('script_loader_tag', function ($tag, $wordpressHandle, $src) use ($scripts) {
                if (in_array($wordpressHandle, array_keys($scripts))) {
                    return '<script type="module" src="' . esc_url($src) . '"></script>';
                }
                return $tag;
            }, 10, 3);
        }

        wp_localize_script(
            $handle,
            '__atlas',
            [
                'blocks' => $blockNames
            ]
        );
    }
}
