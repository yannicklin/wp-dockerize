<?php

namespace Atlas\Blocks;

use Atlas\Core\Blocks\BaseBlock;

class UserCards extends BaseBlock
{
    public $name = 'user-cards';

    public $title = 'User Cards';

    public $description = 'User Cards';

    private function getUserDetails($card)
    {
        $user = $card['user'];

        $user_details = [
            'name' => $user['display_name'] ?? [],
            'role' => $card['show_role'] ? (get_field('expert_title', 'user_' . $user['ID']) ?? '') : '',
            'email' => $card['show_email'] ? (get_field('expert_email', 'user_' . $user['ID']) ?? '') : '',
            'phone' => $card['show_phone'] ? (get_field('expert_phone', 'user_' . $user['ID']) ?? '') : '',
            'profile_image' => get_field('expert_profile_image', 'user_' . $user['ID']) ?? []
        ];

        return $user_details;
    }

    public function with($block, $fields)
    {
        foreach ($fields['row'] as &$item) {
            foreach ($item['user_cards'] as &$card) {
                if ($card['user_toggle'] == 'user') {
                    $card = array_merge($card, $this->getUserDetails($card));
                }
            }
        }

        return parent::with($block, $fields) + [
            'userprofile_image_size' => 150,
        ];
    }
}
