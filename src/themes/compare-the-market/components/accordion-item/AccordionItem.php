<?php

namespace Atlas\Components;

use Illuminate\View\Component;

class AccordionItem extends Component
{
    public string $title;
    public string $content;
    public bool $open_on_load;
    public string $id;
    public bool $custom_faq_schema;
    public string $selected_faq_type;
    public string $custom_answer;
    public array $same_as_items;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $id = '',
        $title = '',
        $content = '',
        $open_on_load = false,
        $custom_faq_schema = false,
        $selected_faq_type = '',
        $custom_answer = '',
        $acf = []
    ) {
        $this->id = $id;

        if (!empty($acf)) {
            $this->title = $acf['title'] ?? '';
            $this->content = $acf['content'] ?? '';
            $this->open_on_load = $acf['open_on_load'] ?? false;
            $this->custom_faq_schema = $acf['custom_faq_schema'] ?? false;
            $this->selected_faq_type = $acf['selected_faq_type'] ?? '';
            $this->custom_answer = $acf['custom_answer'] ?? '';

            if (isset($acf['sameas_repeater']) && is_array($acf['sameas_repeater'])) {
                $this->same_as_items = array_map(function($item) {
                    return $item['sameas_url'] ?? ''; 
                }, $acf['sameas_repeater']);
            } else {
                $this->same_as_items = [];
            }

        } else {
            $this->title = $title;
            $this->content = $content;
            $this->open_on_load = $open_on_load;
            $this->custom_faq_schema = $custom_faq_schema;
            $this->selected_faq_type = $selected_faq_type;
            $this->custom_answer = $custom_answer;
            $this->same_as_items = [];
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('Components::accordion-item.accordion-item');
    }
}


