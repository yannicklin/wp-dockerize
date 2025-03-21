<?php

namespace Atlas\Core\PostTypes;

use Illuminate\Support\Str;
use WP_Post;

abstract class BasePostType
{
    use RegistersPostType;
    use RendersPostType;

    public const POST_TYPE = null;

    protected ?WP_Post $post;

    protected int $postID;

    protected string $title;

    protected string|array $featuredImage;

    protected array|bool $fields;

    protected string $author;

    public function __construct(int|WP_Post $post)
    {
        $this
            ->setPost($post instanceof \WP_Post ? $post : get_post($post))
            ->setPostID($this->post->ID)
            ->setFeaturedImage()
            ->setTitle(get_the_title($this->getPostID()))
            ->setFields(get_fields($this->getPostID()))
            ->setAuthor(get_the_author());
    }

    public function setPost(WP_Post $post): static
    {
        $this->post = $post;
        return $this;
    }

    public function getPost(): ?WP_Post
    {
        return $this->post;
    }

    /**
     * Get the post ID
     *
     * @return false|int
     */
    public function getPostID(): bool|int
    {
        if (!$this->postID) {
            return $this->post->ID;
        }
        return $this->postID;
    }


    /**
     * Set the post ID
     *
     * @param bool|int $postID
     */
    public function setPostID(bool|int $postID): static
    {
        $this->postID = $postID;
        return $this;
    }


    /**
     * Get the title
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set the title
     *
     * @param string $title
     */
    public function setTitle($title): static
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Set the author
     *
     * @param string $author
     */
    public function setAuthor(string $author): static
    {
        $this->author = $author;
        return $this;
    }

    /**
     * Get the author
     *
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }


    /**
     * Set the feature image
     */
    public function setFeaturedImage(): static
    {
        $images = [];

        // Get all image sizes
        $sizes = wp_get_additional_image_sizes();

        // Loop through each size and assign url to image array
        foreach ($sizes as $size => $attributes) {
            $featuredImage = wp_get_attachment_image_src(
                get_post_thumbnail_id($this->getPostID()),
                $size
            );

            if ($featuredImage) {
                $images['sizes'][$size] = $featuredImage[0];
                $images['sizes'][$size . '-width'] = $featuredImage[1];
                $images['sizes'][$size . '-height'] = $featuredImage[2];
            }
        }

        $this->featuredImage = $images;

        return $this;
    }


    /**
     * Get the fields
     *
     * @return array|bool
     */
    public function getFields(): bool|array
    {
        return $this->fields;
    }


    /**
     * Set the fields
     *
     * @param bool|array $fields
     */
    public function setFields(bool|array $fields): static
    {
        $this->fields = $fields;

        return $this;
    }


    /**
     * Get the post permalink
     *
     * @return false|string
     */
    public function getPermalink(): bool|string
    {
        return get_permalink($this->getPostID());
    }
}
