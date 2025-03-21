<?php

namespace Atlas\Core\Autoloader;

use Atlas\Core\Features\HasFeature;
use Symfony\Component\Finder\Finder;

class CoreAutoloader
{
    // Handles automatically requiring all components and blocks from their custom folder structure
    public function register()
    {
        $finder = new Finder();

        // find all files within the app/View/blocks directory
        $finder->files()->in([
            get_theme_file_path() . '/components',
            get_theme_file_path() . '/blocks',
            get_theme_file_path() . '/post-types',
            get_theme_file_path() . '/taxonomies'
        ]);

        // load all of those files
        // Autoloader for PHP classes(components/blocks)
        if ($finder->hasResults()) {
            foreach ($finder as $file) {
                if (str_contains($file->getRealPath(), '.blade.php')) {
                    continue;
                }

                if (!str_contains($file->getRealPath(), '.php')) {
                    continue;
                }
                require_once $file->getRealPath();
            }
        }

        $this->registerBlocks();
        $this->registerPostTypes();
        $this->registerTaxonomies();
        $this->registerFeatures();
    }

    private function registerFeatures(): void
    {
        $classes = array_merge(
            $this->getClassesInNamespace('Atlas\\Blocks\\'),
            $this->getClassesInNamespace('Atlas\\PostTypes\\'),
            $this->getClassesInNamespace('Atlas\\Taxonomies\\')
        );

        $features = [];

        foreach ($classes as $class) {
            // if the block doesnt have features enabled skip it
            if (!in_array(HasFeature::class, class_implements($class))) {
                continue;
            }

            // if the block doesnt have any features on it or hasnt implemented the interfaces method skip it
            if (!method_exists($class, 'features')) {
                continue;
            }

            // add the feature to the list of features to register
            foreach ($class::features() as $feature) {
                $features[$feature] = $feature;
            }
        }

        // register all features that the current set of blocks require
        foreach ($features as $feature) {
            (new $feature())->register();
        }
    }

    private function registerBlocks(): void
    {
        $blocks = $this->getClassesInNamespace('Atlas\\Blocks\\');

        add_action('acf/init', function () use ($blocks) {
            foreach ($blocks as $block) {
                $block = new $block();
                $block->register();
            }
        });
    }

    private function registerPostTypes(): void
    {
        add_action('init', function () {
            $postTypes = $this->getClassesInNamespace('Atlas\\PostTypes\\');

            foreach ($postTypes as $postType) {
                $postType::registerPostType();
            }
        }, 1);
    }

    private function registerTaxonomies()
    {
        add_action('init', function () {
            $taxonomies = $this->getClassesInNamespace('Atlas\\Taxonomies\\');

            foreach ($taxonomies as $taxonomy) {
                $taxonomy::registerTaxonomy();
            }
        }, 1);
    }


    private function getClassesInNamespace($namespace)
    {
        $classes = [];
        foreach (get_declared_classes() as $class) {
            if (str_contains($class, $namespace)) {
                $classes[] = $class;
            }
        }
        return $classes;
    }
}
