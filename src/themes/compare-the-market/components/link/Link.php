<?php

namespace Atlas\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Link extends Component
{
    public const TYPE_FILE = 'file';
    public const TYPE_LINK = 'link';
    public $type;
    public $title;
    public $link;
    public $file;

    public function __construct($type = self::TYPE_LINK, $title = '', $link = '', $file = '', $acf = [])
    {
        if (!empty($acf)) {
            $this->type = $acf['type'] ?? self::TYPE_LINK;
            $this->title = $acf['title'] ?? '';
            $this->link = $acf['link'] ?? [];
            $this->file = $acf['file'] ?? [];
        } else {
            $this->type = $type;
            $this->title = $title;
            $this->link = $link;
            $this->file = $file;
        }
    }

    public function render(): View
    {
        return view('Components::link.link');
    }
}
