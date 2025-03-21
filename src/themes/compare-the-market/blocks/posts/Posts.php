<?php

namespace Atlas\Blocks;

use Atlas\Core\Blocks\BaseBlock;

class Posts extends BaseBlock
{
    public $name = 'posts';

    public $title = 'Posts';

    public $description = 'Posts';

    public int $per_page = 8;

    public function with($block, $fields)
    {

        if (in_array($fields['type'], ['manual', 'category'])) {
            return [
                'posts' => $this->getPosts($fields),
                'per_page' => $this->per_page
            ];
        }

        return parent::with($block, $fields);
    }

    private function getPosts($fields)
    {
        if ($fields['type'] === 'manual') {
            return $fields['posts'];
        }

        return get_posts([
            'numberposts' => $fields['paginate'] ? -1 : $this->per_page,
            'tax_query' => [
                [
                    'taxonomy' => 'category',
                    'field' => 'id',
                    'terms' => $fields['categories'],
                    'operator' => 'IN',
                ]
            ]
        ]);
    }
}
