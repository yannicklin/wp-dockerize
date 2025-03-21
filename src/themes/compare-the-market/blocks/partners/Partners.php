<?php

namespace Atlas\Blocks;

use App\Blocks\HasBackgroundColors;
use Atlas\Core\Blocks\BaseBlock;
use Atlas\Taxonomies\Partner;
use Atlas\Taxonomies\Vertical;

class Partners extends BaseBlock implements HasBackgroundColors
{
    public $name = 'partners';

    public $title = 'Partner Logos';

    public $description = 'Partners';

    public function with($block, $fields)
    {
        $vertical = $fields['vertical'];
        $vertical_key = Vertical::$slug . '_' . $vertical?->term_id;

        $blockAlternativeLink = $fields['link_override'] ?? '';
        $verticalAlternativeLink = get_field('partners_list_page', $vertical_key) ?: '';

        $terms_conditions = get_field('terms_conditions', $vertical_key) ?: '';
        $randomize = ($fields['randomize'] ?? false) ? true : (get_field('randomise_logos', $vertical_key) ?: false);
        $partnerPageDisabled = ('individual' !== ($fields['url_behaviour'] ?? 'individual') || !empty($blockAlternativeLink)) ? true : (get_field('disable_detail_page', $vertical_key) ?: false);

        $logos = [];
        $vertical_partners = Vertical::getPartnersList($vertical, 'raw');
        if ($vertical_partners) {
            foreach ($vertical_partners as $record) {
                $partner = $record['partner'];
                $partnerLogo = Partner::getPartnerLogo($partner?->term_id, 'absolute');
                $partnerLogoDimensions = wp_getimagesize(Partner::getPartnerLogo($partner?->term_id, 'relative')); // Index 0 is width, 1 is height, 2 is file type, 3 is the html image tag (height and width string)
                $partnerTitle =  $partner?->name ? ('logo of ' . $partner->name) : '';
                $partnerAlt =  $partner?->slug ? ($partner->slug . ' logo') : '';

                // Decide the link: Block > Vertical > Vertical-Partner > Partner (default)
                $partnerAlternativeLink = $record['override_url'] ?: '';
                $partnerPageLink = '/' . $vertical?->slug . '/' . $partner?->slug . '/';

                $wrapperOverrideUrl = $partnerPageDisabled ? (empty($blockAlternativeLink) ? (empty($verticalAlternativeLink) ? '' : $verticalAlternativeLink) : $blockAlternativeLink) : '';
                $wrapperOverrideUrl = generatePageLink($wrapperOverrideUrl);

                $partnerUrl = $partnerPageDisabled ? '' : (empty($partnerAlternativeLink) ? $partnerPageLink : $partnerAlternativeLink);
                $partnerUrl = generatePageLink($partnerUrl);

                $logos[] = [
                    'logo' => $partnerLogo,
                    'url' => $partnerUrl,
                    'title' => $partnerTitle,
                    'alt' => $partnerAlt,
                    'image_dimensions' => ($partnerLogoDimensions) ? 'width=' . $partnerLogoDimensions[0] . ' height=' . $partnerLogoDimensions[1] : '',
                ];
            }
        }

        return [
            'logos' => $logos,
            'terms' => $terms_conditions ?: '',
            'view_all_mobile' => 'View all partners',
            'randomize' => $randomize,
            'wrapper_override_url' => $wrapperOverrideUrl,
            'title' => $fields['title_block']['title'],
            'title_type' => $fields['title_block']['title_type'] ?? 'h2',
            'subtitle' => $fields['title_block']['subtitle'],
            'subtitle_type' => $fields['title_block']['subtitle_type'] ?? 'p',
            'title_content' => $fields['title_block']['content'],
            'title_section_exist' => !empty($fields['title_block']['title'] || $fields['title_block']['subtitle'] || $fields['title_block']['content']),
        ];
    }


    public function availableBackgroundColors(): array
    {
        return [
            HasBackgroundColors::BG_WHITE,
            HasBackgroundColors::BG_CREAM_WHITE,
        ];
    }

    public function setDefaultBackgroundColor(): string
    {
        return HasBackgroundColors::BG_CREAM_WHITE;
    }

    public function getACFGroupKey(): string
    {
        return 'group_65389e302c531';
    }
}
