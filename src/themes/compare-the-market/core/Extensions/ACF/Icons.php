<?php

namespace Atlas\Core\Extensions\ACF;

use Symfony\Component\Finder\Finder;

class Icons
{
    public function register()
    {
        add_filter('acf_svg_icon_filepath', [$this, 'registerIconFolder']);
    }

    public function registerIconFolder($filepaths)
    {
        // create a new instance of finder and retrieve all files in /resources/icons in the theme directory
        $finder = new Finder();

        $finder->files()->in(get_stylesheet_directory() . '/resources/icons');

        // loop over the files and add them to the filepath array
        foreach ($finder as $file) {
            $filepaths[] = $file->getRealPath();
        }

        return $filepaths;
    }
}
