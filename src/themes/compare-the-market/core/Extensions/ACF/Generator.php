<?php

namespace Atlas\Core\Extensions\ACF;

use Atlas\Core\Extensions\Support\GeneratorHelpers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

abstract class Generator
{
    use GeneratorHelpers;

    public $detectOn = null;

    public $directory = null;

    public $stubsDirectory = '/core/stubs/';

    /**
     * Chuck the file contents into a path in the theme
     * @param $path
     * @param $contents
     * @return void
     * @throws \Exception
     */
    public function transformFile($path, $contents)
    {
        $this->transformStubFile(
            $this->directory,
            $path,
            $contents
        );
    }

    /**
     * Detect if the post should be procssed
     * @param $post
     * @return bool
     */
    public function shouldProcess($post)
    {
        return $post->post_type === 'acf-field-group' &&
            Str::contains($post->post_title, $this->detectOn) &&
            $post->post_status !== 'trash';
    }

    /**
     * Gets the final title of the generators subject
     * @param $title
     * @return string
     */
    public function getName($title)
    {
        return trim(str_replace($this->detectOn, '', $title));
    }


    /**
     * @return array{
     *     directory: string,
     *     class_name: string,
     *     block_name: string,
     *     view_name: string,
     *     style_name: string,
     *     ts_name: string
     *  }
     */
    public function getReplaces($post)
    {
        return $this->stubTemplateReplacements(
            $post->post_title,
            $this->classNamespace ?? '',
            $this->detectOn
        );
    }

    /**
     * Processes the stubs content and run some replacements within said content
     * @param $stub
     * @param $replace
     * @return array|string|string[]
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function processStub($stub, $replace = [])
    {
        return $this->processStubContent($this->stubsDirectory, $stub, $replace);
    }
}
