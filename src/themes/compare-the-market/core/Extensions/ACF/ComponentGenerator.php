<?php

namespace Atlas\Core\Extensions\ACF;

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Str;

class ComponentGenerator extends Generator
{
    public $detectOn = 'Component - ';

    public $directory = '/components/';

    public $classNamespace = 'Atlas\\Components';

    public function register()
    {
        add_action('save_post', function ($post_id, $post, $update) {
            if (!$this->shouldProcess($post)) {
                return;
            }

            $replaces = $this->getReplaces($post);

            collect([
                'ComponentClass.stub' => $replaces['class_name'] . '.php',
                'component_view.stub' => $replaces['view_name'] . '.blade.php',
                '_component_css.stub' => $replaces['style_name'] . '.scss',
                'componentTs.stub' => $replaces['ts_name'] . '.ts',
            ])->each(function ($filename, $stub) use ($replaces) {
                $this->transformFile(
                    sprintf("%s/%s", $replaces['directory'], $filename),
                    $this->processStub($stub, $replaces)
                );
            });
        }, 10, 3);
    }
}
