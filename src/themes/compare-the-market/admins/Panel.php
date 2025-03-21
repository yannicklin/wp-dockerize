<?php

/**
 * Backend Admin Panels setup. (Except UserManagment and Documentation)
 */

namespace Admins\Panels;

use Atlas\Taxonomies\{Partner, Vertical};

/**
 * Scripts used across all Admin Panels
 */
add_action('admin_enqueue_scripts', function () {
    [$styles, $scripts, $isHot] = vite([
        'resources/scripts/block-names.ts'
    ]);

    foreach ($scripts as $handle => $script) {
        wp_enqueue_script($handle, $script, ['acf-blocks'], null, true);
    }
});


/**
 * Register the theme assets with the block editor.
 */
add_action('enqueue_block_editor_assets', function () {

    [$styles, $scripts, $isHot] = vite([
        'resources/scripts/editor.ts'
    ]);

    foreach ($scripts as $handle => $script) {
        wp_enqueue_script($handle, $script, [], null, true);
    }
}, 100);


add_filter('mce_buttons_2', function ($buttons) {
    array_unshift($buttons, 'styleselect');
    return $buttons;
});


add_filter('tiny_mce_before_init', function ($init_array) {
    $settings['style_formats_merge'] = true;
    $style_formats = array(
        array(
            'title' => 'body-L',
            'block' => 'p',
            'classes' => 'body-l',
            'wrapper' => false,

        ),
        array(
            'title' => 'body-XL',
            'block' => 'p',
            'classes' => 'body-xl',
            'wrapper' => false,

        ),
        array(
            'title' => 'body-XXL',
            'block' => 'p',
            'classes' => 'body-xxl',
            'wrapper' => false,

        ),
        array(
            'title' => 'List Bullets Inside',
            'selector' => 'ul',
            'classes' => 'list-position-inside',
            'wrapper' => true,

        ),
    );
    $init_array['style_formats'] = wp_json_encode($style_formats);
    return $init_array;
});


add_action('admin_head', function () {
    // Override the Dashboard title to CTM v2024
    if (isset($GLOBALS['title']) && 'Dashboard' === $GLOBALS['title']) {
        $GLOBALS['title'] =  'Compare the Market ADMIN v2024';
    }

    // Hardcoded by LAMB for some ACF fields
    $acf_admin_style = <<<ADMIN_ACF_STYLE
    <style>
        // Disable the NEW content in Admin Bar
        #wp-admin-bar-new-content {
            display:none;
        }

        #wp-admin-bar-new-content-default {
            display:none;
        }

        // Page Editor: Side-Navigation Specific
        .wp-block-acf-side-navigation .acf-field-6347a760005ce a.acf-tab-button[data-key="field_6347a9cdd80f8"] {
            display: none;
        }

        .wp-block-acf-side-navigation .acf-field[data-name="branded_curve_colour"],
        .wp-block-acf-side-navigation .acf-field[data-name="branded_curve_offset_colour"],
        .wp-block-acf-side-navigation .acf-field[data-name="branded_curve"] {
            display: none;
        }

        .wp-block-acf-side-navigation .acf-field-64eebffa66bfa a.acf-tab-button[data-key="field_6347a9cdd80f8"] {
            display: none;
        }

        // Extend the Vertical/Partner edit area
        form#edittag {
            max-width: min(100%, 1344px);
        }

        // Unknown Needs
        .components-base-control.components-checkbox-control {
            display: none;
        }

        .wp-block-acf-content .acf-field-6343b862c29fc .acf-field[data-key="field_63116b21f5cc5"] {
            display: none;
        }

        .wp-block-acf-side-navigation .acf-field-64eebffa66bfa div[data-layout="content"] .acf-field-6343b862c29fc .acf-field[data-key="field_63116b21f5cc5"] {
            display: none;
        }
    </style>
ADMIN_ACF_STYLE;

    echo $acf_admin_style;
});


// Remove Comments
add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
});


/**
 * Extend Media Libary Panel
 */
add_filter('manage_media_columns', function ($columns) {
    unset($columns['comments']);
    $columns['dimensions'] = 'Dimensions';
    $columns['filesize'] = 'File Size';
    return $columns;
});


add_filter('manage_media_custom_column', function ($column_name, $post_id) {
    if ('dimensions' === $column_name) {
        list($url, $width, $height) = wp_get_attachment_image_src($post_id, 'full');
        printf('%d &times; %d', (int) $width, (int) $height);
    } else if ('filesize' === $column_name) {
        $filesize = filesize(get_attached_file($post_id));
        print(esc_attr(size_format($filesize, 2)));
    }
}, 10, 3);


/**
 * Remove Yoast SEO Columns From Admin Area
 */
function ctm_remove_yoast_seo_admin_columns($columns)
{
    /* remove the Yoast SEO columns */
    unset($columns['wpseo-score']);
    unset($columns['wpseo-score-readability']);
    unset($columns['wpseo-focuskw']);
    unset($columns['wpseo-title']);
    unset($columns['wpseo-metadesc']);
    // unset( $columns['wpseo-links'] );
    // unset( $columns['wpseo-linked'] );
    return $columns;
}
/* remove from posts and pages */
add_filter('manage_edit-post_columns', __NAMESPACE__ . '\\ctm_remove_yoast_seo_admin_columns');
add_filter('manage_edit-page_columns', __NAMESPACE__ . '\\ctm_remove_yoast_seo_admin_columns');


/**
 * Remove Columns and Row Actions in Taxanomy: Vertical & Partner
 */
// Remove the description field in the Taxonomy Edit
function ctm_remove_taxonomy_description_field()
{
    global $current_screen;
    if (in_array($current_screen->id, ['edit-vertical', 'edit-partner'])) {
?>
        <script type="text/javascript">
            (function($) {
                $(function() {
                    $('#tag-description').parent().remove();
                    $('.term-description-wrap').hide();
                });
            })(jQuery);
        </script>
    <?php
    }
}
add_action('admin_footer',  __NAMESPACE__ . '\\ctm_remove_taxonomy_description_field');


// remove Description column
function ctm_remove_taxonomy_columns($columns)
{
    unset($columns['description']);
    return $columns;
}
add_filter('manage_edit-vertical_columns', __NAMESPACE__ . '\\ctm_remove_taxonomy_columns');
add_filter('manage_edit-partner_columns', __NAMESPACE__ . '\\ctm_remove_taxonomy_columns');


// remove QuickEdit and View actions
function ctm_remove_taxonomy_row_actions($actions, $tag)
{
    unset($actions['inline hide-if-no-js']);
    unset($actions['view']);
    return $actions;
}
add_filter('vertical_row_actions',  __NAMESPACE__ . '\\ctm_remove_taxonomy_row_actions', 10, 2);
add_filter('partner_row_actions',  __NAMESPACE__ . '\\ctm_remove_taxonomy_row_actions', 10, 2);


/**
 * Taxanomy: Partner specific
 */
function ctm_taxonomy_partner_logo_dropdown($field)
{
    global $current_screen;
    if ('edit-partner' === $current_screen->id) {
        $choices = [];
        $images_folder = dirname(__DIR__, 1) . '/resources/images/partner/';
        $images = array_slice(scandir($images_folder, SCANDIR_SORT_DESCENDING), 0);

        foreach ($images as $file) {
            $file_pathparts = pathinfo(strtolower($file));
            if (in_array($file_pathparts['extension'], ['jpeg', 'jpg', 'png'])) {
                $choices[$file_pathparts['basename']] = $file_pathparts['filename'];
            }
        }

        $field['choices'] = $choices;
    }

    return $field;
}
add_filter('acf/load_field/key=field_6535c2d3df29b', __NAMESPACE__ . '\\ctm_taxonomy_partner_logo_dropdown');


function ctm_taxonomy_partner_logo_render($field)
{
    global $current_screen;
    if ('edit-partner' === $current_screen->id) {
        $imagefolder_path = get_theme_file_uri() . Partner::$logoFolderPath;
        if (isset($field['value'])) {
            $imagefile_path = $imagefolder_path . $field['value'];
        } else {
            $imagefile_path = "";
        }
    ?>
        <script type="text/javascript" id="admin-acf-extra-render-partner-logo">
            (function($) {
                $(function() {
                    var parentNode = $('[data-key="<?= $field['key'] ?>"]');

                    parentNode.find('td.acf-input').append('<img id="admin-acf-partner-logo" alt="" src="<?= $imagefile_path ?>" data-folder-path="<?= $imagefolder_path ?>" height="128" decoding="async">');

                    // If there are any changes
                    parentNode.on('change.select2', function(e) {
                        var selected = parentNode.find('select').select2('data');
                        let imgDiv = parentNode.find('img#admin-acf-partner-logo');
                        var newImageSrc = "";
                        if (null != selected) {
                            newImageSrc = imgDiv.data("folderPath") + selected[0].id;
                        }
                        imgDiv.attr('src', newImageSrc);
                    });
                });
            })(jQuery);
        </script>
<?php
    }

    return $field;
}
add_filter('acf/prepare_field/key=field_6535c2d3df29b', __NAMESPACE__ . '\\ctm_taxonomy_partner_logo_render');

//Default to tinymce in editor
function ctm_default_editor() {
    return "tinymce";
}
add_filter( 'wp_default_editor', __NAMESPACE__ . '\\ctm_default_editor' );


// Extend the page queries
function ctm_restapi_maximum($params) {
    if ( isset( $params['per_page'] ) ) {
        $params['per_page']['maximum'] = 9999;
    }
    return $params;
}
add_filter('rest_page_collection_params', __NAMESPACE__ . '\\ctm_restapi_maximum', 10, 1);
add_filter('rest_post_collection_params', __NAMESPACE__ . '\\ctm_restapi_maximum', 10, 1);