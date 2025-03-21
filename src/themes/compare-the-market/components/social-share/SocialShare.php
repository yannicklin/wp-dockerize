<?php

namespace Atlas\Components;

use Illuminate\View\Component;

class SocialShare extends Component
{
    private static $availableChannels = [
        'facebook' => [
            'channel'     => 'facebook',
            'label'     => 'Facebook',
            'logo'      => 'licon licon-facebook',
            'url'       => ''
        ],
        'twitter' => [
            'channel'     => 'twitter',
            'label'     => 'Twitter',
            'logo'      => 'licon licon-twitter',
            'url'       => ''
        ],
        'linkedin' => [
            'channel'     => 'linkedin',
            'label'     => 'LinkedIn',
            'logo'      => 'licon licon-linkedin',
            'url'       => ''
        ]
    ];

    public $shares;
    public $permalink;
    public $shareTitle;
    public $icons;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->icons = get_field('social_media_icons', 'option');
        $this->setShareChannels();
        $this->setShareLinks();
    }

    /**
     * Set the available share channels
     *
     */
    public function setShareChannels()
    {
        $shares = get_field('available_social_media_sharing', 'option');

        if ($shares && is_array($shares)) {
            foreach ($shares as $key) {
                if (array_key_exists($key, self::$availableChannels)) {
                    $this->shares[] = self::$availableChannels[$key];
                }
            }
        }
    }

    /**
     * Set the relevant URLs for share functionality
     *
     */
    public function setShareLinks()
    {
        $permalink = get_permalink();
        $shareTitle = get_the_title();
        foreach ($this->shares as &$share) {
            if ($share['channel'] == 'facebook') {
                $share['url'] = "https://facebook.com/sharer/sharer.php?u=" . $permalink;
            }
            if ($share['channel'] == 'twitter') {
                $share['url'] = "https://twitter.com/intent/tweet/?text=" . $shareTitle . "&amp;url=" . $permalink;
            }
            if ($share['channel'] == 'linkedin') {
                $share['url'] = "https://www.linkedin.com/shareArticle?mini=true&amp;url=" . $permalink .
                    "&amp;title=" . $shareTitle . "&amp;source=" . $permalink;
            }
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('Components::social-share.social-share');
    }
}
