<?php

namespace Atlas\Core\PostTypes;

use Illuminate\Support\Str;

trait RegistersPostType
{
    public static string $pluralName;

    public static string $singularName;

    /**
     * Override this function to change the post type registration arguments
     * @return array
     */
    public static function postTypeArgs(): array
    {
        return [];
    }

    /**
     * @return void
     * @throws \Exception
     */
    public static function registerPostType(): void
    {
        /** @var self $class */
        $class = get_called_class();

        if ($class::POST_TYPE === null) {
            throw new \Exception('The POST_TYPE constant must be overriden in ' . get_called_class());
        }

        if (post_type_exists($class::POST_TYPE)) {
            return;
        }

        $singularName = $class::$singularName ?? Str::of($class::POST_TYPE)
            ->swap([
                '_' => ' ',
                '-' => ' '
            ])
            ->ucfirst()
            ->__toString();

        $pluralName = $class::$pluralName ?? Str::of($singularName)
            ->plural()
            ->__toString();

        $args = get_called_class()::postTypeArgs() + [
            'labels' => [
                'name'               => __($pluralName),
                'singular_name'      => __($singularName),
                'add_new'            => __('Add New'),
                'add_new_item'       => __('Add New ' . $singularName),
                'edit_item'          => __('Edit ' . $singularName),
                'new_item'           => __('New ' . $singularName),
                'all_items'          => __('All ' . $pluralName),
                'view_item'          => __('View ' . $singularName),
                'search_items'       => __('Search ' . $pluralName),
                'not_found'          => __('No ' . $pluralName . ' found'),
                'not_found_in_trash' => __('No ' . $pluralName . ' found in Trash'),
                'parent_item_colon'  => '',
                'menu_name'          => $pluralName
            ],
            'supports' => ['title', 'revisions', 'excerpt', 'author', 'thumbnail', 'editor'],
            'public'        => true,
            'show_ui'       => true,
            'show_in_menu'  => true,
            'show_in_rest'  => true,
            'rewrite' => [
                'with_front' => false
            ]
        ];

        register_post_type($class::POST_TYPE, $args);
    }
}
