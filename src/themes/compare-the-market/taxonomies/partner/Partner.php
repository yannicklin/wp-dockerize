<?php

namespace Atlas\Taxonomies;

use Atlas\Core\Taxonomies\BaseTaxonomy;
use Atlas\PostTypes\Page;
use Atlas\Taxonomies\Vertical;

class Partner extends BaseTaxonomy
{

    public static array $postTypes = [
        Page::POST_TYPE
    ];

    public static string $slug = 'partner';

    public static string $singularName = 'Partner';

    public static string $pluralName = 'Partners';

    public static string $logoFolderPath = '/resources/images/partner/';

    public static array $args = [
        'hierarchical'               => false,
        'publicly_queryable'         => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => false,
        'show_in_rest'               => true,
        'query_var'                  => true,
    ];


    public static function getPartner($id = '', $slug = '')
    {
        $partner = null;
        if (!empty($id)) {
            $partner = get_term_by('id', $id, 'partner');
        } elseif (!empty($slug)) {
            $partner = get_term_by('slug', $slug, 'partner');
        }

        return $partner;
    }


    public static function getPartnerinPage($page)
    {
        $partners = get_the_terms($page->ID, 'partner');
        $partner = $partners && $partners[0] ? $partners[0] : null;

        return $partner;
    }


    public static function getPartnerLogo($partner_id, $path_type = 'absolute')
    {
        // Seems Logo cannot work via normal ACF query. Needs use get_term_meta instead?!
        $logo = get_term_meta($partner_id, 'logo', true) ?: '';
        $validFileExtention = array('png', 'jpg', 'jpeg', 'gif', 'svg', 'webp');
        $vaildFilePattern = '/^[^`~!@#$%^&*()+=[\];\',.\/?><":}{]+\.(' . implode('|', $validFileExtention) . ')$/u';

        if (empty($logo) || !preg_match($vaildFilePattern, $logo)) {
            return '';
        }

        if ('relative' == $path_type) {
            // Relatvie Path
            $logo = dirname(__DIR__, 2) . self::$logoFolderPath . $logo;
        } else {
            // Absolute Path
            $logo = get_theme_file_uri() . self::$logoFolderPath . $logo;
        }

        return $logo;
    }


    public static function checkPartnerAlive($partner_id)
    {
        $enabled = get_term_meta($partner_id, 'enabled', true) ?: false;

        return $enabled;
    }


    public static function checkPartnerExist($partner, $vertical)
    {
        $verticalExist = false;
        $partnerEnabled = self::checkPartnerAlive($partner);
        if ($partnerEnabled) {
            $vertical_partners = get_field('partners', Vertical::$slug . "_" . $vertical);
            if ($vertical_partners) {
                foreach ($vertical_partners as $record) {
                    if ($partner == $record['partner']?->term_id) {
                        $verticalExist = true;
                    }
                }
            }
        }

        return ($partnerEnabled && $verticalExist);
    }
}
