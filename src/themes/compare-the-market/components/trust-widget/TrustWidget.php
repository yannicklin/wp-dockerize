<?php

namespace Atlas\Components;

use Illuminate\View\Component;

class TrustWidget extends Component
{
    public $trust_widget_toggle;
    public $trust_widget_opacity;
    public $widget_theme_bg;
    public $widget_theme_is_dark;
    public $trust_lists;
    public $trust_disclaimer;
    public $choose_widget; 
    public $list_item_header;
    public $trust_card;
    public $text_color;
    public $card_color;
    public $block_theme;
    public $background_colour;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($acf = [])
    {
        if (!empty($acf)) {
            $widgetBGColour = $this->getWidgetTextColour($acf);
            $this->trust_widget_toggle = $acf['trust_widget_toggle'];
            $this->trust_widget_opacity = $acf['trust_widget_opacity'];
            $this->widget_theme_bg = $widgetBGColour;
            $this->widget_theme_is_dark = $this->isColorTooDark($widgetBGColour);
            $this->trust_lists = $acf['trust_lists'] ?? [];
            $this->trust_disclaimer = get_field('trust_disclaimer');
            $this->choose_widget = $acf['choose_widget']; 
            $this->list_item_header = $acf['list_item_header'];
            $this->text_color = get_field('text_color');
            $this->card_color = $acf['card_color'];
            $block_theme = get_field('block_theme');
            $this->background_colour = $block_theme['block_theme']['background_colour'] ?? 'default-color';
                                   
        }
    }

    public function classes(): array
    {
        $classes = ['component component-trust-widget'];

        $classes = array_merge($classes, [
            'position-relative overflow-hidden p-0 py-md-16 px-md-24 px-xl-32 radius-s gap-0 gap-md-48 text-center mt-8 mt-lg-0'
        ]);

        $classes = array_merge($classes, [
            'd-inline-flex justify-content-between align-items-center flex-wrap flex-md-nowrap'
        ]);

        $classes[] = $this->widget_theme_is_dark ? 'text-white' : 'text-dark';

        if ($this->background_colour !== 'default-color') {
            $classes[] = $this->background_colour;
        }        

        return $classes;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('Components::trust-widget.trust-widget', [
            'cardClasses' => $this->getCardClasses(),
        ]);
    }

    public function isColorTooDark($color)
    {
        $color = str_replace('#', '', $color);
        $rgb = hexdec($color);   // convert rrggbb to decimal
        $r   = ($rgb >> 16) & 0xff;  // extract red
        $g   = ($rgb >> 8) & 0xff;  // extract green
        $b   = ($rgb >> 0) & 0xff;  // extract blue

        $luma = 0.2126 * $r + 0.7152 * $g + 0.0722 * $b; // per ITU-R BT.709

        // too dark
        if ($luma < 150) {
            return true;
        }

        return false;
    }

    public function getCardClasses(): string
    {
        return match($this->card_color) {
            'White' => 'bg-white text-blue-600 card-shadow',
            'Soft Blue' => 'light-card text-blue-600',
            'Dark Blue' => 'dark-card text-white',
            default => ''
        };
    }
    
    public function getWidgetTextColour($fields)
    {
        if (!empty($fields['trust_widget_colour'])) {
            if ($fields['trust_widget_colour'] == "custom") {
                return $fields['trust_widget_hex'];
            } else {
                return $fields['trust_widget_colour'];
            }
        } else {
            return '';
        }
    }
}
