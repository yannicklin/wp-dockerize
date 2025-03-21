<?php

namespace Atlas\Core\Extensions\ACF;

use Symfony\Component\Finder\Finder;
use Illuminate\Support\Str;

/**
 * Haandles loading JSON from custom folder locations
 */
class LocalJson
{
    public static function folders()
    {
        return [
            'Component - ' => get_theme_file_path() . '/components/',
            'Block - ' => get_theme_file_path() . '/blocks/',
            'Post Type - ' => get_theme_file_path() . '/post-types/',
        ];
    }

    private function directoryName($title, $split, $folder)
    {
        if (!Str::contains($title, $split)) {
            return false;
        }

        // Determine our intended directory
        $block_name = trim(str_alphanumeric(str_replace($split, '', $title)));
        $dir_name = Str::kebab($block_name) . '/';
        $block_directory = $folder;

        // return directory if it exists
        if (file_exists($block_directory . $dir_name)) {
            return $block_directory . $dir_name;
        }

        return false;
    }

    public function register()
    {
        add_filter('acf/json/save_paths', function ($path, $post) {
            // Prevent accessing non existent json file when trashing field groups whose local json no longer exists
            if ($post == null) {
                return;
            }

            $finder = new Finder();

            // generates the ACF field group json file file name
            $field_group = $post['key'] . '.json';

            $finder->files()->in(self::folders());

            // if the file name already exists in any of the above folders and subfolders, write to it specifically
            if ($finder->hasResults()) {
                foreach ($finder as $file) {
                    if ($file->getFilename() == $field_group) {
                        return $file->getPath();
                    }
                }
            }

            foreach (self::folders() as $splitBy => $folder) {
                if ($directory = $this->directoryName($post['title'], $splitBy, $folder)) {
                    return $directory;
                }
            }

            // otherwise, write to the default ACF field group json path
            return get_theme_file_path() . '/resources/acf-json';
        }, 2, 10);

        add_filter('acf/settings/load_json', function (array $paths) {
            $paths[] = get_theme_file_path() . '/resources/acf-json';

            $finder = new Finder();

            $finder->directories()->in(self::folders());

            if ($finder->hasResults()) {
                foreach ($finder as $directory) {
                    $paths[] = $directory->getpathName();
                }
            }

            return $paths;
        });
    }
}
