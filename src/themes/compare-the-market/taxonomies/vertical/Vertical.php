<?php

namespace Atlas\Taxonomies;

use Atlas\Core\Taxonomies\BaseTaxonomy;
use Atlas\PostTypes\Page;
use Atlas\Taxonomies\Partner;

class Vertical extends BaseTaxonomy
{

    public static array $postTypes = [
        Page::POST_TYPE
    ];

    public static string $slug = 'vertical';

    public static string $singularName = 'Vertical';

    public static string $pluralName = 'Verticals';

    public static array $args = [
        'hierarchical'               => false,
        'publicly_queryable'         => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_in_rest'               => true,
        'query_var'                  => true,
    ];


    public static function getVertical($id = '', $slug = '')
    {
        $vertical = null;
        if (!empty($id)) {
            $vertical = get_term_by('id', $id, 'vertical');
        } elseif (!empty($slug)) {
            $vertical = get_term_by('slug', $slug, 'vertical');
        }

        return $vertical;
    }


    public static function getVerticalinPage($page, $exclude_global = true)
    {
        $excludes = [];
        if ($exclude_global) {
            $excludes[] = 45;
        }

        if (is_null($page)) return null;

        // Get all verticals on the page, except Global
        $verticals = wp_get_object_terms($page->ID, 'vertical', array('fields' => 'all', 'exclude' => $excludes));
        if (!is_wp_error($verticals)) {
            $verticals = apply_filters('get_the_terms', $verticals, $page->ID, 'vertical');
        }

        $vertical = $verticals && $verticals[0] ? $verticals[0] : null;
        return $vertical;
    }


    public static function getPartnersList($vertical, $list_mode = 'ol', $sorting = '')
    {
        $partners = [];
        $vertical_key = Vertical::$slug . '_' . $vertical->term_id;
        $vertical_partners = get_field('partners', $vertical_key);
        if ($vertical_partners) {
            foreach ($vertical_partners as $record) {
                if (Partner::checkPartnerAlive($record['partner']?->term_id)) {
                    $partners[] = $record;
                }
            }
        }

        if ('raw' == $list_mode) {
            // This is used to generate the Partners Logos Block.
            $result = $partners;
        } else {
            $partnerPageDisabled = get_field('disable_detail_page', $vertical_key) ?: false;

            foreach ($partners as $record) {
                $partnerAlternativeLink = $record['override_url'] ?: '';
                $partnerPageLink = '/' . $vertical->slug . '/' . $record['partner']->slug . '/';
                $partnerUrl = $partnerPageDisabled ? '' : (empty($partnerAlternativeLink) ? $partnerPageLink : $partnerAlternativeLink);
                $partnerUrl = generatePageLink($partnerUrl);

                $results[] = [
                    'name' => $record['partner']->name,
                    'url' => $partnerUrl,
                    'extra' => ($record['extra_comment'] ?: ''),
                ];
            }

            if (count($results)) {
                if ('ascend' == $sorting) {
                    array_multisort(array_column($results, 'name'), SORT_ASC, SORT_STRING | SORT_FLAG_CASE, $results);
                } else if ('descend' == $sorting) {
                    array_multisort(array_column($results, 'name'), SORT_DESC, SORT_STRING | SORT_FLAG_CASE, $results);
                }

                $list_mode_html = str_replace("-link", "", $list_mode);
                $result = '';
                if (in_array($list_mode, ['ol', 'ul']) || $partnerPageDisabled) {
                    foreach ($results as $record) {

                        $result .= sprintf('<li>%1$s%2$s</li>', $record['name'], (empty($record['extra']) ? '' : (' ' . $record['extra'])));
                    }
                } elseif (in_array($list_mode, ['ol-link', 'ul-link'])) {
                    foreach ($results as $record) {
                        $result .= sprintf('<li><a href="%1$s">%2$s</a>%3$s</li>', $record['url'], $record['name'], (empty($record['extra']) ? '' : (' ' . $record['extra'])));
                    }
                }
                $result = sprintf('<%1$s>%2$s</%1$s>', $list_mode_html, $result);
            } else {
                $result = '';
            }
        }

        return $result;
    }


    public static function getStandardHeroDefaultCTAs($vertical)
    {
        $vertical_key = Vertical::$slug . '_' . $vertical->term_id;
        $defaultCTAbuttons = get_field('standard_hero_cta_buttons', $vertical_key)['button_group'] ?? [];

        return $defaultCTAbuttons;
    }


    public static function getVerticalBannerDefaultCTAs($vertical)
    {
        $vertical_key = Vertical::$slug . '_' . $vertical->term_id;
        $defaultCTAbuttons = [];

        $defaultCTAbuttons['button'] = get_field('vertical_banner_cta_button', $vertical_key)['button'] ?? [];
        $defaultCTAbuttons['display_phone_number'] = get_field('vertical_banner_display_phone_number', $vertical_key) ?? false;
        $defaultCTAbuttons['phone'] = get_field('vertical_banner_phone', $vertical_key) ?? '';
        $defaultCTAbuttons['display_opening_hours'] = get_field('vertical_banner_display_opening_hours', $vertical_key) ?? false;

        return $defaultCTAbuttons;
    }
}
