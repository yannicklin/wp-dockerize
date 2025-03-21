<?php

namespace Atlas\PostTypes;

use Illuminate\View\Component;
use Atlas\Core\PostTypes\BasePostType;
use WP_Post;

class TeamMember extends BasePostType
{
    public const POST_TYPE = 'team-member';

    private $firstName = '';
    private $surname = '';
    private $position = '';

    public static function postTypeArgs(): array
    {
        return [
            'publicly_queryable' => true,
            'public'             => true,
            'show_ui'            => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'query_var'          => true,
            'rewrite'            => [
                'slug' => 'team-members',
                'with_front' => false
            ],
            'supports'           => ['title', 'thumbnail'],
            'taxonomies'         => [],
            'has_archive'        => false,
            'menu_icon'          => 'dashicons-groups'
        ];
    }

    public function __construct(int|WP_Post $post)
    {
        parent::__construct($post);

        $this
            ->setFirstname()
            ->setSurname()
            ->setPosition();
    }

    /**
     * Get the first name
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }


    /**
     * Set the first name
     */
    public function setFirstName(): static
    {
        $this->firstName = $this->fields['first_name'] ?: $this->firstName;
        return $this;
    }


    /**
     * Get the surname
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }


    /**
     * Set the surname
     */
    public function setSurname()
    {
        $this->surname = $this->fields['surname'] ?: $this->surname;
        return $this;
    }


    /**
     * Get the position
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }


    /**
     * Set the position
     */
    public function setPosition()
    {
        $this->position = $this->fields['position'] ?? $this->position;
        return $this;
    }
}
