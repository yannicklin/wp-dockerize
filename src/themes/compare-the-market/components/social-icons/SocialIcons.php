<?php

namespace Atlas\Components;

use Illuminate\View\Component;

class SocialIcons extends Component
{
    public $channels;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->channels = get_field('social_media_channels', 'option');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('Components::social-icons.social-icons');
    }
}
