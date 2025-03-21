<?php

namespace Atlas\Components;

use Atlas\Taxonomies\Vertical;
use Roots\Acorn\View\Component;

class Footer extends Component
{
    public $disclaimer;

    public $footer_top_columns;

    public $footer_menu_accordion;

    public $footer_menu_text;

    public function __construct()
    {
        $this->disclaimer = $this->disclaimer();
        $this->footer_top_columns = get_field('footer_top_columns', 'options');
        $this->footer_menu_accordion = get_field('footer_menu_accordion', 'options');
        $this->footer_menu_text = get_field('footer_menu_text', 'options');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('Components::footer.footer');
    }

    private function disclaimer()
    {
        global $post;
        // Page Level Override
        if ($disclaimer = get_field('disclaimer', get_the_ID())) {
            return $disclaimer;
        }

        // Vertical Level Override
        $vertical = Vertical::getVerticalinPage($post, false);
        $vertical_page_ID = $vertical ? Vertical::$slug . '_' . $vertical->term_id : 'options';
        if ($disclaimer = get_field('footer_disclaimer', $vertical_page_ID)) {
            return $disclaimer;
        }

        // Using Theme Global setting
        return get_field('disclaimer', 'option');
    }
}
