<?php

namespace Atlas\PostTypes;

use Atlas\Core\PostTypes\BasePostType;

class Media extends BasePostType
{
    public const POST_TYPE = 'ctm-media';

    public static function postTypeArgs(): array
    {
        return [
            'publicly_queryable' => false,
            'public' => false,
            'show_ui' => true,
            'hierarchical' => false,
            'menu_position' => null,
            'query_var' => false,
            'rewrite' => [
                'slug' => 'ctm-media',
                'with_front' => false
            ],
            'supports' => ['title'],
            'taxonomies' => [],
            'has_archive' => false,
            'menu_icon' => 'dashicons-video-alt'
        ];
    }
}
