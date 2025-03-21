<?php

namespace Atlas\Components;

use Illuminate\View\Component;

class ExpertLabel extends Component
{
    public $name;
    public $area_of_expertise;
    public $image;
    public $user;
    public $background;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $name = '',
        $area_of_expertise = '',
        $image = [],
        $acf = [],
        $background = 'bg-alabaster-300'
    ) {
        if (!empty($acf)) {
            if ($acf['user_toggle'] == 'user' && isset($acf['user'])) {
                $user = $acf['user'];
                $this->name = $user['display_name'] ?? [];
                $this->area_of_expertise = get_field('expert_title', 'user_' . $user['ID']) ?? '';
                $this->image = get_field('expert_profile_image', 'user_' . $user['ID']) ?? [];
            } else {
                $this->name = $acf['name'] ?? '';
                $this->area_of_expertise = $acf['area_of_expertise'] ?? '';
                $this->image = $acf['profile_image'] ?? [];
            }
        } else {
            $this->name = $name;
            $this->area_of_expertise = $area_of_expertise;
            $this->image = $image;
        }

        $this->background = $background;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('Components::expert-label.expert-label');
    }
}
