<?php

namespace Atlas\Core\Commands;

use Atlas\Core\Extensions\Support\GeneratorHelpers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Roots\Acorn\Console\Commands\Command;
use Symfony\Component\Finder\Finder;

/**
 * The GenerateBlock class extends the Command class from the Roots\Acorn\Console\Commands namespace,
 * which provides a base implementation for console commands in Laravel.
 * This class is designed to generate a new block with the given name and optional list of components.
 */
class GenerateBlock extends Command
{
    use GeneratorHelpers;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'atlas:generate-block';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a block';

    /**
     * The directory containing the stub files that will be used to generate the block files.
     * @var string
     */
    public $stubsDirectory = '/core/stubs/';

    /**
     * The directory where the generated block files will be saved
     * @var string
     */
    public $directory = '/blocks/';

    /**
     * The namespace that will be used for the block's PHP class.
     * @var string
     */
    public $classNamespace = 'Atlas\\Blocks';

    /**
     * The name of the block to generate, as provided by the user.
     * @var string
     */
    public $block = '';

    /**
     * A list of the components to include in the block, as provided by the user.
     * @var array
     */
    public $components = [];

    /**
     * This method is called by Laravel when the command is executed. It prompts the user for the name
     * of the block to generate and any optional components to include in the block, and then it
     * generates the files for the block and its components.
     * @return int|void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        $this->block = $this->ask('What would you like to call the block?');

        $this->components = $this->choice(
            'What components would you like to add to the block?',
            config('generator.available-components'),
            multiple: true,
        );

        $component_index = [];

        foreach ($this->components as $component) {
            $component = class_basename($component);

            $group_key = $this->findGroupKeyForComponent($component);

            if (is_null($group_key)) {
                $this->error('Could not find component with name ' . $component);

                return self::FAILURE;
            }

            $component_index[$component] = $group_key;
        }

        $replaces = $this->stubTemplateReplacements(
            $this->block,
            $this->classNamespace,
        );

        collect([
            'BlockClass.stub' => $replaces['class_name'] . '.php',
            'block_view.stub' => $replaces['view_name'] . '.blade.php',
            '_block_scss.stub' => $replaces['style_name'] . '.scss',
            'blockTs.stub' => $replaces['ts_name'] . '.ts',
            '_block_acf.stub' => $replaces['acf_name'] . '.json',
        ])->each(function ($filename, $stub) use ($replaces, $component_index) {


            $content = $this->processStubContent($this->stubsDirectory, $stub, $replaces);

            if ($stub === '_block_acf.stub') {
                $content = $this->processACFStub($content, $component_index);
            }

            $this->transformStubFile(
                $this->directory,
                sprintf("%s/%s", $replaces['directory'], $filename),
                $content
            );
        });
    }

    /**
     * Attempt to find the ACF group key for the given component by searching the theme's components
     * directory for a group_*.json file that contains the key. It returns the key if found, or null if not.
     * @param $name
     * @return null
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function findGroupKeyForComponent($name)
    {
        if (!Storage::disk('theme')->exists('components/' . Str::kebab($name))) {
            return null;
        }

        foreach (Storage::disk('theme')->allFiles('components/' . Str::kebab($name)) as $file) {
            if (str_contains($file, 'group_') && str_contains($file, '.json')) {
                $fields = json_decode(Storage::disk('theme')->get($file));


                return $fields->key ?? null;
            }
        }

        return null;
    }

    /**
     * Process the ACF group stub file by adding fields for each component specified by the user.
     * It takes the initial stub content and a list of components, and returns the updated content as a JSON string.
     * @param $content
     * @param $components
     * @return string
     */
    private function processACFStub($content, $components): string
    {
        $content = json_decode($content);

        foreach ($components as $componentName => $componentGroupKey) {
            $content->fields[] = $this->getComponentFieldGroup(
                Str::snake($componentName),
                $componentName,
                $componentGroupKey
            );
        }

        return acf_json_encode($content);
    }

    /**
     * This method generates an ACF field group object for the given component with the given field name and
     * ACF group key. It returns the field group as an object.
     * @param $fieldName
     * @param $componentName
     * @param $componentGroupKey
     * @return mixed
     */
    private function getComponentFieldGroup($fieldName, $componentName, $componentGroupKey)
    {
        return json_decode('{
            "key": "' . uniqid('field_') . '",
            "label": "' . join(' ', Str::ucsplit($componentName)) . '",
            "name": "' . $fieldName . '",
            "type": "clone",
            "instructions": "",
            "required": 0,
            "conditional_logic": 0,
            "wrapper": {
                "width": "",
                "class": "",
                "id": ""
            },
            "clone": [
                "' . $componentGroupKey . '"
            ],
            "display": "group",
            "layout": "block",
            "prefix_label": 0,
            "prefix_name": 0
        }');
    }
}
