<?php

namespace Atlas\Blocks;

use App\Blocks\HasBackgroundColors;
use App\Blocks\HasPaddings;
use App\Blocks\HasMargins;
use Atlas\Core\Blocks\BaseBlock;

class PopUpModal extends BaseBlock implements HasBackgroundColors, HasPaddings, HasMargins
{
    public $name = 'pop-up-modal';

    public $title = 'PopUpModal';

    public $description = 'PopUpModal';

    public function with($block, $fields)
    {
        $favselect = $fields['favselect'] ?? [];
        $selectedFavicon = !empty($favselect) ? $favselect['url'] : 'default-favicon-url';

        return
            [
                'backgroundcolor' => $fields['backgroundcolor'],
                'choice' => $fields['choices'] ?? 'Exit intent',
                'page_title' => html_entity_decode($fields['page_title'] ?? '', ENT_QUOTES | ENT_HTML5, 'UTF-8'),
                'favselect' => $favselect,
                'cookies' => $fields['cookies'] ?? '0',
                'popup_class' => $fields['popupclass'] ?? 'modalClick',
                'modal_id' => uniqid('modal-'),
                'selected_favicon' => $selectedFavicon,
                'emoji_favicon' => $fields['emojifavicon'] ?? '',
            ];
    }

    public function availableBackgroundColors(): array
    {
        return [];
    }

    public function setDefaultBackgroundColor(): string
    {
        return '';
    }

    public function availablePaddings(): array
    {
        return [];
    }

    public function setDefaultPadding(): string
    {
        return '';
    }

    public function availableMargins(): array
    {
        return [];
    }

    public function setDefaultMargin(): string
    {
        return '';
    }

    public function getACFGroupKey(): string
    {
        return 'group_66736d74d8185';
    }
}
