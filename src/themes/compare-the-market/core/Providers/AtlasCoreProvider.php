<?php

namespace Atlas\Core\Providers;

use Atlas\Core\Autoloader\CoreAutoloader;
use Atlas\Core\Extensions\ACF\FilterData;
use Atlas\Core\Commands\GenerateBlock;
use Atlas\Core\Extensions\ACF\Icons;
use Atlas\Core\Extensions\ACF\PostTypeGenerator;
use Atlas\Core\Extensions\Gutenberg\BlockCategories;
use Atlas\Core\Extensions\ACF\LocalJson;
use Atlas\Core\Extensions\ACF\BlockGenerator;
use Atlas\Core\Extensions\ACF\ComponentGenerator;
use Atlas\Core\Extensions\ACF\ThemeSettings;
use Atlas\Core\Extensions\Blade\BladeCompiler;
use Atlas\Core\Extensions\Gutenberg\BlockLimiter;
use Atlas\Core\Extensions\Gutenberg\DefaultBlocks;
use Atlas\Core\Extensions\Gutenberg\ReusableBlocks;
use Atlas\Core\Extensions\WordPress\Cleanup;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Arr;
use Roots\Acorn\ServiceProvider;

class AtlasCoreProvider extends ServiceProvider
{
    public function boot()
    {
        $this->commands([
            GenerateBlock::class
        ]);

        // Checks if array has only empty values
        Blade::if('exists', function ($value) {
            return count(
                Arr::where(Arr::flatten($value), function ($value, $key) {
                    return !empty($value);
                })
            ) > 0;
        });

        Blade::if('doesntExist', function ($value) {
            return !count(
                Arr::where(Arr::flatten($value), function ($value, $key) {
                    return !empty($value);
                })
            );
        });
    }

    public function register()
    {
        // Override blade compiler so that it can figure out where to load atlas components
        $this->app->singleton('blade.compiler', function () {
            $compiler = new BladeCompiler(
                $this->app['files'],
                $this->app['config']['view.compiled']
            );

            $compiler->directive('debug', function () {
                return '<?php dd($__data); ?>';
            });

            return $compiler;
        });

        // Update view namespaces for blocks/components
        // This allows you to render a block like
        config([
            'view.namespaces' => [
                'Blocks' => get_theme_file_path() . '/blocks',
                'Components' => get_theme_file_path() . '/components',
                'PostTypes' => get_theme_file_path() . '/post-types'
            ]
        ]);

        // Generators
        (new CoreAutoloader())->register();
        (new BlockGenerator())->register();
        (new ComponentGenerator())->register();
        (new PostTypeGenerator())->register();

        // ACF functionality
        (new LocalJson())->register();
        (new ThemeSettings())->register();
        (new Icons())->register();
        (new FilterData())->register();

        // Gutenberg modifications
        (new BlockCategories())->register();
        (new BlockLimiter())->register();
        (new DefaultBlocks())->register();
        (new ReusableBlocks())->register();

        // WordPress modifications
        (new Cleanup())->register();
    }
}
