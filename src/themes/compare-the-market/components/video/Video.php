<?php

namespace Atlas\Components;

use Illuminate\View\Component;

class Video extends Component
{
    public string $video_type;
    public ?array $video_file;
    public ?string $video_embed;
    public bool $autoplay;
    public ?array $image_placeholder;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($acf = [])
    {
        if (!empty($acf)) {
            $this->video_type = $acf['video_type'];
            $this->video_file = !empty($acf['video_file']) ? $acf['video_file'] : [];
            $this->video_embed = $acf['video_embed'] ?? '';
            $this->autoplay = $acf['autoplay'] ?? false;
            $this->image_placeholder = $acf['image_placeholder'] ?? [];
        }

        if ($this->autoplay && $this->video_embed) {
            $this->updateVideoEmbed();
        }
    }

    private function updateVideoEmbed()
    {
        preg_match('/src="(.+?)"/', $this->video_embed, $matches);
        $src = $matches[1];
        $params = array(
            'controls'  => 0,
            'hd'        => 1,
            'autohide'  => 1,
            'showinfo'  => 0,
            'autoplay'  => 1,
            'mute'      => 1,
            'loop'      => 1,
            'playsinline' => 1,
            'modestbranding' => 1
        );
        $new_src = add_query_arg($params, $src);
        $this->video_embed = str_replace($src, $new_src, $this->video_embed);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('Components::video.video');
    }
}
