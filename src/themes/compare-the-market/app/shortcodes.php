<?php

/**
 * Register shortcodes for the theme
 */

namespace App\Shortcodes;

use Atlas\Taxonomies\Partner;
use Atlas\Taxonomies\Vertical;

add_action('init', function () {

    /**
     * This is used to get the current page title
     *
     * @param $atts
     *
     * @return string
     * @example shortcode use: [page_title]
     *
     */
    add_shortcode('page_title', function ($atts, $content = null) {
        $title = get_the_title();

        // Blog listing Page
        if (is_home()) {
            $title = get_the_title(get_option('page_for_posts'));
            // Category Page
        } elseif (is_category()) {
            $title = single_cat_title('', false);
            // Custom Post Type Archive Page
        } elseif (is_post_type_archive()) {
            $title = post_type_archive_title('', false);
            // Search Results page
        } elseif (is_search()) {
            $title = 'Search Results';
            // 404 Page
        } elseif (is_404()) {
            $title = '404';
        } elseif (is_tax()) {
            $title = single_term_title('', false);
        }

        return $title;
    });

    add_shortcode('button', function ($atts) {
        $a = shortcode_atts([
            'text' => '', 'link' => '#', 'type' => 'primary', 'size' => 'medium',
            'class' => '', 'id' => '', 'rel' => '', 'aria_label' => '',
            'icon' => '', 'icon_position' => 'left', 'tag' => 'a',
        ], $atts);
    
        $class = 'btn btn-' . esc_attr($a['type']) . ' btn-' . esc_attr($a['size']) 
                 . ($a['class'] ? ' ' . esc_attr($a['class']) : '')
                 . ($a['type'] === 'link' ? ' link-style' : ($a['type'] === 'text' ? ' text-style' : ''));
    
        $attributes = ($a['rel'] ? ' rel="' . esc_attr($a['rel']) . '"' : '') 
                    . ($a['id'] ? ' id="' . esc_attr($a['id']) . '"' : '') 
                    . ($a['aria_label'] ? ' aria-label="' . esc_attr($a['aria_label']) . '"' : '');
    
        $icon_html = '';
        if (!empty($a['icon'])) {
            $icon_class = esc_attr($a['icon']);
            $margin_class = !empty($a['text']) ? ($a['icon_position'] === 'right' ? ' ms-8' : ' me-8') : '';
            $icon_html = $a['type'] === 'link'
                ? '<span class="component-icon w-auto"><i class="fa-regular ' . $icon_class . $margin_class . '"></i></span>'
                : '<i class="fa-regular ' . $icon_class . $margin_class . '"></i>';
        }
    
        $button_content = $a['icon_position'] === 'right' ? esc_html($a['text']) . ' ' . $icon_html : $icon_html . ' ' . esc_html($a['text']);
    
        return $a['tag'] === 'button' 
            ? '<button type="button" class="' . $class . '"' . $attributes . '>' . $button_content . '</button>'
            : '<a href="' . esc_url($a['link']) . '" class="' . $class . '"' . $attributes . '>' . $button_content . '</a>';
    });

    add_shortcode('read_more', function ($atts, $content = null) {
        return sprintf(
            '
            <div class="read-more-content" hidden>%s</div>
            <div class="read-more-link text-link d-flex align-items-center">
            <span class="read-more-text">Read More</span>
            <span class="read-more-toggle position-relative"></span>
            </div>',
            $content
        );
    });


    // Add Bold Text shortcode
    add_shortcode('b', function ($atts, $content = null) {
        return '<strong>' . $content . '</strong>';
    });


    add_shortcode('strong', function ($atts, $content = null) {
        return '<strong>' . $content . '</strong>';
    });


    add_shortcode('em', function ($atts, $content = null) {
        return '<em>' . $content . '</em>';
    });


    add_shortcode('br', function ($atts, $content = null) {
        return '<br/>';
    });

    add_shortcode('icon', function ($atts) {
        $atts = shortcode_atts(['type' => ''], $atts);
    
        if ($atts['type'] === 'green-check') {
            $iconHtml = '<i class="fa-regular fa-check fs-14 bg-apple-300 rounded-pill text-white d-inline-flex justify-content-center align-items-center height-24 width-24" aria-label="Yes"></i>';
        } elseif ($atts['type'] === 'red-cross') {
            $iconHtml = '<i class="fa-regular fa-xmark fs-14 text-crimson-200 bg-crimson-100 rounded-pill text-white d-inline-flex justify-content-center align-items-center height-24 width-24" aria-label="No"></i>';
        } else {
            return '';
        }
    
        return $iconHtml;
    });

    add_shortcode('a', function ($atts, $content = null) {
        $atts = shortcode_atts(
            [
                'href' => '#',
                'id' => '',
            ],
            $atts
        );

        $href = esc_url($atts['href']);
        $id = $atts['id'] ? ' id="' . esc_attr($atts['id']) . '"' : '';

        return sprintf('<a href="%s"%s>%s</a>', $href, $id, $content);
    });


    add_shortcode('span', function ($atts, $content = null) {
        $atts = shortcode_atts(
            [
                'id' => '',
            ],
            $atts
        );

        $id = $atts['id'] ? ' id="' . esc_attr($atts['id']) . '"' : '';

        return sprintf('<span %s>%s</span>', $id, $content);
    });


    add_shortcode('jump', function ($atts, $content = null) {
        $atts = shortcode_atts(
            [
                'id' => '',
            ],
            $atts
        );

        $id = $atts['id'] ? ' id="' . esc_attr($atts['id']) . '"' : '';

        return sprintf(
            '<span %s style="display: block;position: relative;top: -100px;visibility: hidden;">%s</span>',
            $id,
            $content
        );
    });


    add_shortcode('style', function ($atts, $content = null) {
        $atts = shortcode_atts(
            [
                'style' => '',
            ],
            $atts
        );

        $id = $atts['style'] ? ' style="' . esc_attr($atts['style']) . '"' : '';

        return sprintf('<span %s>%s</span>', $id, $content);
    });


    //Footer and copyright shortcode
    add_shortcode('current_year', function () {
        return date("Y");
    });


    add_shortcode('CTM_copyright', function () {
        return '&copy; ' . date("Y") . ' Compare The Market. All rights reserved. ACN: 117 323 378 AFSL: 422926 ACL: 422926';
    });


    /* new Partner Management System */
    add_shortcode('partner', function ($atts, $content = null) {
        $atts = shortcode_atts(
            [
                'type' => 'logo',
                'source' => 'slug',
                'slug' => null,
                'id' => null,
            ],
            $atts
        );

        if ('slug' == $atts['source'] && empty($atts['slug'])) {
            return 'No partner slug provided';
        }

        if ('id' == $atts['source'] && empty($atts['id'])) {
            return 'No partner id provided';
        }

        $partner = Partner::getPartner($atts['id'], $atts['slug']);
        if (empty($partner)) {
            return 'No such partner found';
        }

        // Logo Image or Partner Name
        if ("logo" == $atts['type']) {
            $logo_uri = Partner::getPartnerLogo($partner->term_id, 'relative');
            if (empty($logo_uri)) {
                return 'This partner has no logo assigned.';
            }

            $logo_url = Partner::getPartnerLogo($partner->term_id, 'absolute');
            $logo_imagesizes = wp_getimagesize($logo_uri); // Index 0 is width, 1 is height, 2 is file type, 3 is the html image tag (height and width string)

            $result = '<img id="partner-logo" alt="' . $partner->name . '" src="' . $logo_url . '" ' .  $logo_imagesizes[3] . ' loading="lazy" class="img-fluid" decoding="async" >';
        } else {
            $result = $partner->name;
        }
        return $result;
    });


    add_shortcode('partners', function ($atts, $content = null) {
        $atts = shortcode_atts(
            [
                'vertical' => '',
                'list_mode' => 'ol', // ol | ul | ol-link | ul-link
                'sort' => 'ascend', // ascend | descend
            ],
            $atts
        );

        $vertical = Vertical::getVertical(null, $atts['vertical']);
        if (empty($vertical)) {
            return 'No such Vertical found';
        }

        $list = Vertical::getPartnersList($vertical, $atts['list_mode'], $atts['sort']);
        return $list;
    });


    //LVR Calculator
    add_shortcode('lvr_calculator', function ($atts, $content = null) {

        return <<<CALCULATOR_HTML
        <style>
            .form-input {
                background-color: white !important;
                border: 1px solid #B4D4F8 !important;
                color: #787573;
                border-radius: 8px !important;
                padding-left: 25px !important;
            }

            .form-input:focus {
                color: #0F58AB;
                border: 1px solid #0F58AB;
            }

            .form-input.used {
                color: #0F58AB !important;
                border: 1px solid #0F58AB !important;
            }

            .form-input::placeholder {
                color: #001464;
            }

            .input-wrapper {
                display: flex;
                align-items: center;
                background-color: white;
                position: relative;
            }

            .dollar-symbol {
                position: absolute;
                left: 10px;
                color: #001464;
                margin-right: 8px;
            }
        </style>

        <div class="border container p-24 p-md-32 bg-white radius-s my-40" style="border-color: #B4D4f8 !important;box-shadow: 8px 8px #B4D4f8;">
            <div class="row m-auto">
                <div class="col-md p-0 me-md-20 mb-32 mb-lg-0">
                    <p class="h2 fs-lg-32 text-blue-500 mb-16 fw-500">LVR Calculator</p>
                    <p class="body-s fs-lg-16 text-blue-600 mb-16 mb-lg-32">Your loan-to-value ratio (LVR) is a percentage that expresses how big your home loan is, relative to the value of your property. Fill in the fields below to calculate your LVR.</p>
                    <div class="form-group mb-16 mb-lg-32">
                        <label for="loan_amount" class="body-m fs-lg-20 text-blue-500 mb-8 mb-lg-16 fw-lg-800 fw-700">Loan Amount</label>
                        <div class="input-wrapper">
                            <span class="dollar-symbol body-l">&dollar; </span>
                            <input id="loan_amount" type="text" class="form-input body-m fs-lg-18 pt-16 pb-16 pe-16 ps-25" placeholder="Enter loan amount" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="property_value" class="body-m fs-lg-20 text-blue-500 mb-8 mb-lg-16 fw-lg-800 fw-700">Property Value</label>
                        <div class="input-wrapper">
                            <span class="dollar-symbol body-l">&dollar; </span>
                            <input id="property_value" type="text" class="form-input body-m fs-lg-18 pt-16 pb-16 pe-16 ps-25" placeholder="Enter property value" required>
                        </div>
                    </div>
                </div>

                <div class="col-md radius-xs d-flex flex-column justify-content-between p-16 py-20 py-lg-24 p-lg-32 bg-blue-200 ms-md-20">
                    <div class="mt-4 pt-2 mb-24 mb-lg-0">
                        <p class="body-m fs-lg-20 fw-700">Loan-to-value ratio (LVR)</p>
                        <p class="fw-800 h2 fs-lg-48 lvrCalculationNumber mb-0"><span id="lvr_ratio">0</span>%</p>
                    </div>
                    <div>
                        <p class="fs-10 fs-lg-12 blue-600">Generally speaking, lenders require borrowers to have an LVR of 80% or less if they want to avoid paying lenders mortgage insurance (LMI). If your LVR is too high for your liking, you may be able to reduce it by taking out a smaller home loan or aiming to buy a lower-value property. </p>
                    </div>
                </div>
            </div>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loanAmountInput = document.getElementById('loan_amount');
            const propertyValueInput = document.getElementById('property_value');
            const lvrRatio = document.getElementById('lvr_ratio');

            const defaultLoanAmount = '600,000';
            const defaultPropertyValue = '800,000';

            function formatNumberWithCommas(number) {
                return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            }

            function calculateLVR() {
                const loanAmount = parseFloat(loanAmountInput.value.replace(/,/g, ''));
                const propertyValue = parseFloat(propertyValueInput.value.replace(/,/g, ''));
                const lvr = (loanAmount && propertyValue) ? (loanAmount / propertyValue) * 100 : 0;
                lvrRatio.textContent = Math.floor(lvr);
            }

            function handleInput(event) {
                event.target.value = event.target.value.replace(/[^0-9]/g, '');
                if (event.target.value.length > 9) {
                    event.target.value = event.target.value.slice(0, 9);
                }
                if (event.target.value) {
                    event.target.value = formatNumberWithCommas(event.target.value.replace(/,/g, ''));
                }
                calculateLVR();
                event.target.classList.add('used');
            }

            function handleFocus(event) {
                if (!event.target.classList.contains('used')) {
                    event.target.value = '';
                }
                setTimeout(() => {
                    event.target.selectionStart = event.target.selectionEnd = event.target.value.length;
                }, 0);
            }

            function handleBlur(event) {
                if (!event.target.value) {
                    event.target.value = event.target.id === 'loan_amount' ? defaultLoanAmount : defaultPropertyValue;
                    event.target.classList.remove('used');
                }
            }

            loanAmountInput.addEventListener('input', handleInput);
            propertyValueInput.addEventListener('input', handleInput);
            loanAmountInput.addEventListener('focus', handleFocus);
            propertyValueInput.addEventListener('focus', handleFocus);
            loanAmountInput.addEventListener('blur', handleBlur);
            propertyValueInput.addEventListener('blur', handleBlur);

            loanAmountInput.value = defaultLoanAmount;
            propertyValueInput.value = defaultPropertyValue;
            calculateLVR();
        });

        </script>
    CALCULATOR_HTML;
    });


    add_shortcode('health_opening_hours', function ($atts, $content = null) {
        $atts = shortcode_atts(
            [
                'id' => '',
                'api' => '',
                'class' => '',
                'wrapper' => 'div',
            ],
            $atts
        );

        $id = empty($atts['id']) ? uniqid('ctm-health_opening_hours-', false) : esc_attr($atts['id']);
        $opening_hours_api = empty($atts['api']) ? get_field('opening_hours_api', 'options') : esc_attr($atts['api']);

        $rendered = <<<SHORTCODE_HTML
            <%s id="%s" class="opening-hours %s" data-endpoint="%s"></%s>
            <script type="text/javascript">
                var getOpeningHours = async (targetElem) => {
                    const url = targetElem.dataset.endpoint;
                    const response = await fetch(url);
                    const openingHours = await response.json();
                    return openingHours;
                };

                var setOpeningHours = async (elem) => {
                    const todayDate = new Date();
                    const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
                    const todayDay = days[todayDate.getDay()];
                    const response = await getOpeningHours(elem);
                    const todayOpeningHours = response.openingHours.find(el => {
                        return el.description == todayDay;
                    });
                    if (!!todayOpeningHours) {
                        elem.innerText = "Today we are open until " + todayOpeningHours.endTime + " AEST";
                    }
                };

                var elementContainer = document.querySelector("%s#%s");

                if (!!elementContainer && ("function" === typeof getOpeningHours) && ("function" === typeof setOpeningHours)) {
                    setOpeningHours(elementContainer);
                }
            </script>
        SHORTCODE_HTML;

        return sprintf($rendered, $atts['wrapper'], $id, $atts['class'], $opening_hours_api, $atts['wrapper'],  $atts['wrapper'], $id);
    });
});
