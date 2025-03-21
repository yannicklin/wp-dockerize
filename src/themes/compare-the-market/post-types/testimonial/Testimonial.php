<?php

namespace Atlas\PostTypes;

use Illuminate\View\Component;
use Atlas\Core\PostTypes\BasePostType;
use WP_Post;

class Testimonial extends BasePostType
{
    public const POST_TYPE = 'testimonial';

    private string $testimonial = '';
    private string $organisation = '';
    private mixed $position;
    private array $authorImage = [];

    public function __construct(int|WP_Post $post)
    {
        parent::__construct($post);
        $this
            ->setTestimonial()
            ->setAuthor($this->fields['author'] ?? '')
            ->setOrganisation()
            ->setPosition()
            ->setAuthorImage();
    }

    public static function postTypeArgs(): array
    {
        return [
            'publicly_queryable' => false,
            'public'             => false,
            'show_ui'            => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'query_var'          => true,
            'rewrite'            => false,
            'supports'           => ['title'],
            'taxonomies'         => [],
            'has_archive'        => false,
            'menu_icon'          => 'dashicons-format-quote'
        ];
    }

    /**
     * Get the testimonial
     *
     * @return string
     */
    public function getTestimonial(): string
    {
        return $this->testimonial;
    }

    /**
     * Set the testimonial
     */
    public function setTestimonial(): static
    {
        $this->testimonial = $this->fields['testimonial'] ?? '';
        return $this;
    }

    /**
     * Get the Organisation
     *
     * @return string
     */
    public function getOrganisation(): string
    {
        return $this->organisation;
    }

    /**
     * Set the Organisation
     */
    public function setOrganisation(): static
    {
        $this->organisation = $this->fields['organisation'] ?? '';
        return $this;
    }

    /**
     * Get the position
     *
     * @return mixed
     */
    public function getPosition(): mixed
    {
        return $this->position;
    }

    /**
     * Set the position
     */
    public function setPosition(): static
    {
        $this->position = $this->fields['position'] ?? '';
        return $this;
    }

    /**
     * Check if author image exists
     * @return bool
     */
    public function hasAuthorImage(): bool
    {
        return !empty($this->authorImage);
    }

    /**
     * Get the Author Image
     *
     * @return mixed
     */
    public function getAuthorImage(): mixed
    {
        return $this->authorImage;
    }

    /**
     * Set the Author Image
     */
    public function setAuthorImage(): static
    {
        $this->authorImage = $this->fields['author_image'] ?? $this->authorImage;
        return $this;
    }
}
