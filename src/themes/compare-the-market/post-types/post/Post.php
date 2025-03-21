<?php

namespace Atlas\PostTypes;

use Illuminate\View\Component;
use Atlas\Core\PostTypes\BasePostType;
use WP_Post;

class Post extends BasePostType
{
    public const POST_TYPE = 'post';

    private string $content;
    private mixed $date;
    private string|array $categories;

    public function __construct(int|WP_Post $post)
    {
        parent::__construct($post);

        $this->setContent()
            ->setDate('j F Y');
    }

    /**
     * Get the content
     *
     * @param bool $excerpt Return excerpt instead of full text
     *
     * @return string
     */
    public function getContent($excerpt = false): string
    {
        $content = $this->content;

        if ($excerpt) {
            $content = wp_trim_words($content, 50, null);
        }

        return $content;
    }


    /**
     * Set the content
     */
    public function setContent(): static
    {
        $this->content = $this->fields['description'] ?? $this->content;
        return $this;
    }


    /**
     * Get the date
     *
     * @return mixed
     */
    public function getDate(): mixed
    {
        return $this->date;
    }


    /**
     * Set the date
     *
     * @param string $format Optional format override
     */
    public function setDate($format = ''): static
    {
        $this->date = get_the_date($format, $this->getPostID());
        return $this;
    }

    /**
     * Get the categories
     *
     * @param bool $string
     *
     * @return array|string
     */
    public function getCategories($string = true): array|string
    {
        $categories = [];

        if ($this->categories) {
            foreach ($this->categories as $category) {
                $categories[$category->term_id] = $category->name;
            }
        }

        return $string ? implode(' | ', $categories) : $categories;
    }


    /**
     * Set the categories
     */
    public function setCategories(): static
    {
        $term_list = wp_get_post_terms($this->postID, 'category');
        $this->categories = !empty($term_list) ? $term_list : $this->categories;
        return $this;
    }
}
