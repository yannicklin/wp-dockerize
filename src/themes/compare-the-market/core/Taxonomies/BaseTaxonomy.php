<?php

namespace Atlas\Core\Taxonomies;

// use Illuminate\Support\Str;

abstract class BaseTaxonomy
{
    public static array $postTypes;

    public static string $slug;

    public static string $singularName;

    public static string $pluralName;

    public static array $args = [];

    /**
     * Register the taxonomy
     */
    public static function registerTaxonomy()
    {

        $class = get_called_class();

        $args = $class::$args + [
                'labels' => [
                    'name'              => $class::$pluralName,
                    'singular_name'     => $class::$singularName,
                    'search_items'      => "Search " . $class::$pluralName,
                    'all_items'         => "All " .  $class::$pluralName,
                    'parent_item'       => "Parent " . $class::$singularName,
                    'parent_item_colon' => "Parent " . $class::$singularName,
                    'edit_item'         => "Edit " . $class::$singularName,
                    'update_item'       => "Update " . $class::$singularName,
                    'add_new_item'      => "Add New " . $class::$singularName,
                    'new_item_name'     => "New " . $class::$singularName,
                    'menu_name'         => $class::$pluralName
                ],
                'hierarchical'               => true,
                'publicly_queryable'         => true,
                'public'                     => true,
                'show_ui'                    => true,
                'show_admin_column'          => true,
                'show_in_nav_menus'          => true,
                'show_in_rest'               => true,
                'query_var'                  => true,
            ];

        register_taxonomy($class::$slug, $class::$singularName, $args);

        foreach ($class::$postTypes as $postType) {
            register_taxonomy_for_object_type($class::$slug, $postType);
        }
    }
}
