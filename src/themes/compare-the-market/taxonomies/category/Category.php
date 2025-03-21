<?php

namespace Atlas\Taxonomies;

use Atlas\Core\Taxonomies\BaseTaxonomy;
use Atlas\PostTypes\Post;

class Category extends BaseTaxonomy
{

    public static array $postTypes = [
        Post::POST_TYPE
    ];

    public static string $slug = 'category';

    public static string $singularName = 'Category';

    public static string $pluralName = 'Categories';

    public static array $args = [
        'hierarchical'               => true,
        'publicly_queryable'         => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_in_rest'               => true,
        'query_var'                  => true,
    ];

}
