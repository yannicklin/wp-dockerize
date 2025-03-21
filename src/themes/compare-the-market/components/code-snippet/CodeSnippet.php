<?php

namespace Atlas\Components;

use Atlas\Taxonomies\Vertical;
use Roots\Acorn\View\Component;

class CodeSnippet extends Component
{
    /**
     * @var array{name: string, code: string}
     */
    public $snippets;

    public function __construct($fieldName)
    {
        $snippets_theme = get_field($fieldName, 'options') ?: [];
        $snippets_vertical = $this->fetchSnippetsfromVertical($fieldName, get_post());
        $snippets_page = get_field($fieldName) ?: [];

        $this->snippets = array_merge($snippets_theme, $snippets_vertical, $snippets_page);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('Components::code-snippet.code-snippet');
    }


    /**
     * Get the Vertical specific snippets.
     *
     * @return []
     */
    private function fetchSnippetsfromVertical($fieldName, $post)
    {
        $vertical_snippets = [];

        $vertical = Vertical::getVerticalinPage($post, false);
        $vertical_id = $vertical ? Vertical::$slug . '_' . $vertical->term_id : '';

        if ('' != $vertical_id) $vertical_snippets = get_field($fieldName, $vertical_id) ?: [];

        return $vertical_snippets;
    }
}
