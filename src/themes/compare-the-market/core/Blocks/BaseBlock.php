<?php

namespace Atlas\Core\Blocks;

use App\Blocks\HasBackgroundColors;
use App\Blocks\HasPaddings;
use App\Blocks\HasMargins;
use Illuminate\Support\Str;

/**
 * A wrapper around https://www.advancedcustomfields.com/resources/acf_register_block/
 * Class BaseBlock.
 */
abstract class BaseBlock
{
    public const CATEGORY_BEST_PRACTICE = 'atlas-best-practice';

    public const CATEGORY_BEST_PRACTICE_LIKE = 'atlas-best-practice-like';

    public const CATEGORY_CUSTOM = 'atlas-custom';

    public const EXCLUDE_FROM_POST_TYPE = [];

    public const INCLUDE_IN_POST_TYPE = [];
    public static $index = 1;
    /**
     * (String) (Optional) The default block alignment. Available settings are “left”, “center”, “right”,
     * “wide” and “full”. Defaults to an empty string.
     * @var string
     */
    public $align = '';
    /**
     * The blocks view name if this needs to be overridden for any reason.
     * @var
     */
    public $view;
    /**
     * The block name, can only contain lowercase alphanumeric characters and dashes, and must begin with a letter.
     * @var string
     */
    public $name;
    /**
     * (String) The display title for your block. For example ‘Testimonial’.
     * @var string
     */
    public $title;
    /**
     * (String) (Optional) This is a short description for your block.
     * @var string
     */
    public $description;
    /**
     * An icon property can be specified to make it easier to identify a block.
     * These can be any of WordPress’ Dashicons, or a custom svg element.
     * @var string|array|null
     */
    public $icon = '';
    /**
     * (String) (Optional) The display mode for your block. Available settings are “auto”,
     * “preview” and “edit”. Defaults to “preview”. auto: Preview is shown by
     * default but changes to edit form when block is selected. preview: P
     * review is always shown. Edit form appears in sidebar
     * when block is selected. edit: Edit form is always shown.
     *
     * Note. When in “preview” or “edit” modes, an icon will appear in the block toolbar to toggle between modes.
     * @var bool
     */
    public $mode = 'edit';
    /**
     * This property allows the block to be added multiple times. Defaults to true.
     * @var bool
     */
    public $supportsMultiple = true;
    /**
     * This property adds block controls which allow the user to change the block’s alignment.
     * Defaults to false. Set to true to enable the alignment toolbar.
     * Set to an array of specific alignment names to customize the toolbar.
     * @var bool
     */
    public $supportsAlign = false;
    /**
     * This property allows the user to toggle between edit and preview modes via a button. Defaults to true.
     * @var bool
     */
    public $supportsMode = false;
    /**
     * This property allows the use of the jsx components within the block, specifically <InnerBlocks />.
     * @var bool
     */
    public $supportsJsx = false;
    /**
     * (Array) An array of search terms to help user discover the block while searching.
     * @var array
     */
    public $keywords = [
        'Burger',
    ];
    /**
     * Which category to assign the block to
     * @var string
     */
    public $category = self::CATEGORY_BEST_PRACTICE;
    /**
     * If the block should only be enabled during development
     * @var bool
     */
    public $developmentOnly = false;
    /** @var object */
    public $wordpress_block_data;
    public $block_index;

    /**
     * Register the block via the acf_register_block function.
     */
    public function register()
    {
        // Dont register the module if its for development only
        if ($this->developmentOnly && defined('WP_ENV') && WP_ENV !== 'development') {
            return;
        }

        if (function_exists('acf_register_block')) {
            acf_register_block_type([
                'align' => $this->align,
                'name' => $this->name,
                'mode' => $this->mode,
                'title' => __($this->title),
                'description' => __($this->description),
                'render_callback' => function ($block) {
                    $this->render($block);
                },
                'example' => [
                    'attributes' => [
                        'mode' => 'preview',
                        'data' => [
                            '__is_preview' => true
                        ]
                    ]
                ],
                'category' => $this->category,
                'icon' => $this->icon,
                'keywords' => $this->keywords,
                'supports' => [
                    'align' => $this->supportsAlign,
                    'mode' => $this->supportsMode,
                    'multiple' => $this->supportsMultiple,
                    'jsx' => $this->supportsJsx,
                ],
            ]);
        }

        $this->filterBackgroundColors();
        $this->filterPaddings();
        $this->filterMargins();
        $this->disableStyleTab();
    }

    /**
     * Render the module passing in all field values for it
     * All fields values are automatically injected via get_fields as php variables.
     * @param $block
     */
    public function render($block)
    {

        $this->block_index = self::$index;
        self::$index++;

        if (isset($block['data']['__is_preview']) && method_exists($this, 'renderPreview')) {
            return $this->renderPreview($block);
        }

        $this->wordpress_block_data = $block;

        $fields = $block['fields'] ?? [];

        if (empty($fields)) {
            $fields = get_fields() ?: [];
        }

        foreach ($fields as $k => $field) {
            if (is_array($field) && isset($field[$k])) {
                $fields[$k] = $field[$k];
            }
        }

        $viewData = array_merge(
            ['html_id' => $this->getBlockHtmlId()],
            ['block' => $block],
            $fields,
            method_exists($this, 'with') ? $this->with($block, $fields) : [],
            [
                'block_object' => $this,
                'block_class' => class_basename(get_class($this))
            ],
        ) ?: [];

        echo view($this->view(), $viewData);
    }

    public function renderPreview($block)
    {
        $filename = Str::kebab(class_basename(get_class($this))) . '.png';

        echo sprintf(
            '<img src="%s/resources/images/preview/%s" alt="" style="max-width: 100%%;" decoding="async">',
            get_template_directory_uri(),
            $filename
        );
    }

    public function getBlockHtmlId()
    {
        $fields = $this->wordpress_block_data['fields'] ?? [];

        if (isset($fields['block_theme']) && ($internal_campaign_id = $fields['block_theme']['internal_campaign_id'] ?? false ) ) {
            return $internal_campaign_id;
        } else {
            return sprintf(
                '%s-%s',
                $this->name,
                $this->block_index
            );
        }
    }


    /**
     * Pass additional fields back into the block
     *
     * @param $block
     * @param $fields
     * @return array
     */
    public function with($block, $fields)
    {
        $name = Str::slug(class_basename($this));

        return [
            'block_slug' => $name,
        ] + $fields + $block;
    }

    /**
     * Return the blade path of the view to render.
     * @return string
     */
    public function view()
    {
        if (is_null($this->view)) {
            // if the view hasn't been overridden the base view name will be the class name converted into kebab case
            // for example the class - HeroBanner will be transformed to the name - hero-banner
            $blockViewName = Str::kebab(class_basename(get_class($this)));
            return sprintf('Blocks::%s.%s', $blockViewName, $blockViewName);
        }

        return $this->view;
    }

    public function filterBackgroundColors()
    {
        add_filter('acf/load_field/name=block_theme', function ($field) {
            if ($this instanceof HasBackgroundColors && $this->getACFGroupKey() === $field['parent']) {
                if (!isset($field['sub_fields'][0]['sub_fields'])) {
                    return $field;
                }
                $field['sub_fields'][0]['sub_fields'] = collect($field['sub_fields'][0]['sub_fields'])
                    ->map(function ($field) {
                        if ($field['name'] === 'background_colour') {
                            $field['choices'] = collect($field['choices'])->filter(function ($choice, $key) {
                                return in_array($key, $this->availableBackgroundColors());
                            })->toArray();
                            if (!empty($this->setDefaultBackgroundColor())) {
                                $field['default_value'] = $this->setDefaultBackgroundColor();
                            }
                        }
                        return $field;
                    })->toArray();
            }
            return $field;
        });
    }

    public function filterPaddings()
    {
        add_filter('acf/load_field/name=block_theme', function ($field) {
            if ($this instanceof HasPaddings && $this->getACFGroupKey() === $field['parent']) {
                if (!isset($field['sub_fields'][0]['sub_fields'])) {
                    return $field;
                }

                $field['sub_fields'][0]['sub_fields'] = collect($field['sub_fields'][0]['sub_fields'])
                    ->map(function ($field) {
                        if ($field['name'] === 'block_paddings') {
                            $field['sub_fields'] = collect($field['sub_fields'])
                                ->map(function ($subfield) {
                                    if (str_starts_with($subfield['name'], 'block_padding_')) {
                                        $subfield['choices'] = collect($subfield['choices'])->filter(function ($choice, $key) {
                                            return in_array($key, $this->availablePaddings());
                                        })->toArray();

                                        if (!empty($this->setDefaultPadding())) {
                                            $field['default_value'] = $this->setDefaultPadding();
                                        }
                                    }

                                    return $subfield;
                                })->toArray();
                        }
                        return $field;
                    })->toArray();
            }
            return $field;
        });
    }


    public function filterMargins()
    {
        add_filter('acf/load_field/name=block_theme', function ($field) {
            if ($this instanceof HasMargins && $this->getACFGroupKey() === $field['parent']) {
                if (!isset($field['sub_fields'][0]['sub_fields'])) {
                    return $field;
                }

                $field['sub_fields'][0]['sub_fields'] = collect($field['sub_fields'][0]['sub_fields'])
                    ->map(function ($field) {
                        if ($field['name'] === 'block_margins') {
                            $field['sub_fields'] = collect($field['sub_fields'])
                                ->map(function ($subfield) {
                                    if (str_starts_with($subfield['name'], 'block_margin_')) {
                                        $subfield['choices'] = collect($subfield['choices'])->filter(function ($choice, $key) {
                                            return in_array($key, $this->availableMargins());
                                        })->toArray();

                                        if (!empty($this->setDefaultMargin())) {
                                            $field['default_value'] = $this->setDefaultMargin();
                                        }
                                    }

                                    return $subfield;
                                })->toArray();
                        }
                        return $field;
                    })->toArray();
            }
            return $field;
        });
    }

    public function disableStyleTab()
    {
        add_filter('acf/load_field/name=block_theme', function ($field) {
            if (isset($field['sub_fields'][0]['sub_fields'])) {

                $fields_to_cleanout = [];

                if ($this instanceof HasMargins && empty($this->availableMargins()) && $this->getACFGroupKey() === $field['parent']) {
                    $fields_to_cleanout[] = 'Block Margins';
                }
                if ($this instanceof HasPaddings && empty($this->availablePaddings()) && $this->getACFGroupKey() === $field['parent']) {
                    $fields_to_cleanout[] = 'Block Paddings';
                }
                if ($this instanceof HasBackgroundColors && empty($this->availableBackgroundColors()) && $this->getACFGroupKey() === $field['parent']) {
                    $fields_to_cleanout[] = 'Background Colour';
                }
                if (3 <= count($fields_to_cleanout)) {
                    $fields_to_cleanout[] = 'Styling';
                }

                if (1 <= count($fields_to_cleanout)) {
                    $field['sub_fields'][0]['sub_fields'] = collect($field['sub_fields'][0]['sub_fields'])
                        ->filter(function ($field) use ($fields_to_cleanout) {
                            return !in_array($field['label'], $fields_to_cleanout);
                        })->toArray();
                }
            }

            return $field;
        });
    }
}
