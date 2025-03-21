<?php

namespace Atlas\Core\Extensions\ACF;

class BlockGenerator extends Generator
{
    public $detectOn = 'Block - ';

    public $directory = '/blocks/';

    public function register()
    {

        add_action('save_post', function ($post_id, $post, $update) {
            if (!$this->shouldProcess($post)) {
                return;
            }

            $replaces = $this->getReplaces($post);

            collect([
                'BlockClass.stub' => $replaces['class_name'] . '.php',
                'block_view.stub' => $replaces['view_name'] . '.blade.php',
                '_block_scss.stub' => $replaces['style_name'] . '.scss',
                'blockTs.stub' => $replaces['ts_name'] . '.ts',
            ])->each(function ($filename, $stub) use ($replaces) {
                $this->transformFile(
                    sprintf("%s/%s", $replaces['directory'], $filename),
                    $this->processStub($stub, $replaces)
                );
            });
        }, 10, 3);
    }
}
