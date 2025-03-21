<?php

namespace Atlas\Core\PostTypes;

use Illuminate\Support\Str;

trait RendersPostType
{
    /**
     * Render the singular post
     */
    public function renderPost()
    {
        return view(self::getSingleViewPath(get_called_class()::POST_TYPE), [
            'data' => $this,
            'post' => $this->getPost()
        ]);
    }

    /**
     * Render the post preview
     */
    public function renderCard()
    {
        return view(self::getCardViewPath(get_called_class()::POST_TYPE), [
            'data' => $this,
            'post' => $this->getPost()
        ]);
    }


    public static function getCardViewPath($post_type)
    {
        return sprintf('PostTypes::%s.card.card', Str::kebab($post_type));
    }

    public static function getSingleViewPath($post_type)
    {
        return sprintf('PostTypes::%s.single.single', Str::kebab($post_type));
    }
}
