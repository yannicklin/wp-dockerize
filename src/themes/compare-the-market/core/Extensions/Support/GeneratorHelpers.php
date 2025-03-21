<?php

namespace Atlas\Core\Extensions\Support;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait GeneratorHelpers
{
    public function stubTemplateReplacements($title, $namespace, $titleReplacement = '')
    {
        // Removes the "Block -" or "Component -" prefixes from the title and also removes
        // anything between [] and forces the string into alphanumeric
        $block_name = str_alphanumeric(
            preg_replace(
                '#\[[^\]]*\]\W*#i',
                '',
                str_replace($titleReplacement, '', $title)
            )
        );

        return [
            'directory' => Str::kebab($block_name),
            'class_name' => Str::studly($block_name),
            'block_name' => $block_name,
            'view_name' => Str::kebab($block_name),
            'style_name' => '_' . Str::kebab($block_name),
            'ts_name' => Str::studly($block_name),
            'acf_name' => 'group_' . Str::snake($block_name),
            'class_namespace' => $namespace ?? '',
            'post_type' => Str::kebab($block_name),
            'acf_block_title' => $block_name
        ];
    }

    public function transformStubFile($directory, $path, $contents)
    {
        if (Storage::disk('theme')->exists($directory . $path)) {
            return;
        }

        if (Storage::disk('theme')->put($directory . $path, $contents)) {
            return;
        }

        throw new \Exception("Could not create file: $path");
    }

    public function processStubContent($stubDirectory, $stub, $replace = [])
    {
        $content = Storage::disk('theme')->get($stubDirectory . $stub);

        foreach ($replace as $k => $replace) {
            $content = str_replace(sprintf('{%s}', $k), $replace, $content);
        }

        return $content;
    }
}
