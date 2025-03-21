<?php

namespace App\View\Composers;

use Illuminate\Support\Str;
use Roots\Acorn\View\Composer;

class Single extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'single',
        'partner'
    ];

    /**
     * Data to be passed to view before rendering, but after merging.
     *
     * @return array
     */
    public function override()
    {
        return [
            'singleViewName' => $this->getSingleViewName(),
        ];
    }

    public function getSingleViewName()
    {
        return sprintf('PostTypes::%s.single.single', Str::kebab(get_post_type()));
    }
}
