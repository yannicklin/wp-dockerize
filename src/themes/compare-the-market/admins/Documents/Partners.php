<?php

namespace Admins\Documentation;

use Atlas\Taxonomies\Partner;

class Partners
{
    public static function page_menu()
    {
        return false;
    }

    public static function content()
    {

        $output = '';
        $partners = get_terms([
            'taxonomy' => 'partner',
            'hide_empty' => false,
        ]);

        foreach ($partners as $partner) {

            $partnerAlive = Partner::checkPartnerAlive($partner->term_id);
            $partnerLogoURL = Partner::getPartnerLogo($partner->term_id, 'absolute');

            $output .= '
                <div class="provider" style="width: 15%; padding: 5px; text-align: center; margin-bottom: 20px; border-bottom: 2px solid #dddddd;">' . ($partnerAlive ? '' : '<p class="alert-danger">Disabled!!</p> ') . '<pre class="source">[partner type="logo" source="slug" slug="' . $partner->slug . '"]</pre>' . '<img src="' . $partnerLogoURL . '" style="max-width: 90%;" loading="eager" decoding="async">' . '
                </div>
            ';
        }

        return <<<CONTENT
                <div class="ctm">
                    <div style="display: flex; flex: 0 1 auto; flex-direction: row; flex-wrap: wrap; margin-bottom: 20px; justify-content: space-evenly;">
                        {$output}
                    </div>
                </div>
CONTENT;
    }
}
