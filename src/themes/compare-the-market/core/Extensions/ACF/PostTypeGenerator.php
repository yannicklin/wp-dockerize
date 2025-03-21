<?php

namespace Atlas\Core\Extensions\ACF;

class PostTypeGenerator extends Generator
{
    public $detectOn = 'Post Type - ';

    public $directory = '/post-types/';

    public $classNamespace = 'Atlas\\PostTypes';

    public function register()
    {
        add_action('save_post', function ($post_id, $post, $update) {
            if (!$this->shouldProcess($post)) {
                return;
            }

            $replaces = $this->getReplaces($post);

            collect([
                'PostTypeClass.stub' => $replaces['class_name'] . '.php',
                'post_view.stub' => '/single/single.blade.php',
                '_single_scss.stub' => '/single/_single.scss',
                '_card_scss.stub' => '/card/_card.scss',
                'post_card.stub' => '/card/card.blade.php',
            ])->each(function ($filename, $stub) use ($replaces) {
                $this->transformFile(
                    sprintf("%s/%s", $replaces['directory'], $filename),
                    $this->processStub($stub, $replaces)
                );
            });
        }, 10, 3);
    }
}
