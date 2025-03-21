<?php

namespace Atlas\Components;

use Illuminate\View\Component;

class Image extends Component
{
    public array $image = [];

    public ?array $tablet_image;

    public ?array $mobile_image;

    public bool $alternate_images;

    public ?string $alt;

    public bool $lazy;

    public string $width;

    public string $height;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($image = [], $lazy = true, $alt = '', $width = 0, $height = 0)
    {
        $this->setImage($image);
        $this->alt = $alt;
        $this->tablet_image = !empty($image['tablet_image']) ? $image['tablet_image'] : [];
        $this->mobile_image = !empty($image['mobile_image']) ? $image['mobile_image'] : [];
        $this->alternate_images = $image['alternate_images'] ?? false;
        $this->width = $width;
        $this->height = $height;
        $this->lazy = $lazy;
    }

    /**
     * Sets an image or default image
     * @param $image
     * @return $this
     */
    private function setImage($image)
    {

        // If just a string is passed through the image property set it up as the only URL
        if (is_string($image)) {
            $this->image = [
                'url' => $image
            ];
        }

        // If a bool is passed through the image prop we'll setup a placeholder image
        if (is_bool($image)) {
            $this->image = [
                'url' => get_field('default_card_image', 'options')['url'] ?? 'https://via.placeholder.com/1920x1080'
            ];
        }

        // Otherwise we'll setup the ACF fields
        if (is_array($image) && isset($image['image']) && $image['image']) {
            $this->image = $image['image'];
        }

        return $this;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('Components::image.image');
    }
}
