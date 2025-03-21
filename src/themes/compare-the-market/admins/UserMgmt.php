<?php

/**
 * User Management
 */

namespace Admins\UserMgmt;

/**
 * Remove admin menu items depending on role.
 */
function remove_role_menu_options()
{
    $user_roles = wp_get_current_user()->roles;
    $pages_to_remove = [];
    $submenus_to_remove = [];

    if (array_intersect(['page_builders', 'public_relations', 'product_team'], (array) $user_roles)) {
        $pages_to_remove = array_merge($pages_to_remove, [
            'edit-comments.php',
            'ReusableBlocks.php',
            'edit.php?post_type=wp_block',
            'edit.php?post_type=ctm-media',
            'theme-settings',
            'edit.php?post_type=acf-field-group',
            'members',
            'admin.php?page=code-snippets',
            'tools.php',
            'options-general.php',
            'edit.php?post_type=team-member',
            'edit.php?post_type=testimonial',
            'activity_log_page',
            'wpseo_dashboard',
            'wpseo_workouts',
        ]);

        $submenus_to_remove = array_merge($submenus_to_remove, [
            ['edit.php?post_type=page', 'edit-tags.php?taxonomy=vertical&amp;post_type=page'],
            ['edit.php?post_type=page', 'edit-tags.php?taxonomy=partner&amp;post_type=page'],
            ['upload.php', 'tiny-bulk-optimization'],
            ['edit.php?post_type=page', 'post-new.php?post_type=page'],
            ['edit.php?post_type=page', 'edit-tags.php?taxonomy=page-type&amp;post_type=page']
        ]);
    }
    if (in_array('wp_manager', $user_roles)) {
        $pages_to_remove = array_merge($pages_to_remove, [
            'theme-settings',
            'admin.php?page=activity_log_page',
            'wpseo_dashboard',
            'wpseo_workouts',
            'edit.php?post_type=wp_block',
            'tools.php',
            'members',
            'edit.php?post_type=acf-field-group',
            'activity_log_page',
            'options-general.php'
        ]);
    }

    //Expert and guest code not in here.
    foreach ($pages_to_remove as $page) {
        remove_menu_page($page);
    }

    foreach ($submenus_to_remove as $submenu) {
        remove_submenu_page($submenu[0], $submenu[1]);
    }
}
add_action('admin_menu', __NAMESPACE__ . '\\remove_role_menu_options', 2000);


/**
 * handle user profile updates
 * @param object  &$errors Instance of WP_Error class.
 * @param boolean $update  True if updating an existing user, false if saving a new user.
 * @param object  &$user   User object for user being edited.
 */
add_action('user_profile_update_errors', function ($errors, $update, $user) {
    if (!$update) return;

    if (empty($_POST['user_slugname'])) {
        $errors->add(
            'empty_slugname',
            sprintf(
                '<strong>%1$s</strong>: %2$s',
                esc_html__('Error'),
                esc_html__('Please enter a SLUG.')
            ),
            array('form-field' => 'user_slugname')
        );
    } else {
        $user->user_nicename = $_POST['user_slugname'];
    }
}, 10, 3);


/**
 * Adds Custom Column To Users List Table
 */
add_filter('manage_users_columns', function ($columns) {
    unset($columns['posts']);
    $columns['user_slug'] = 'SLUG';
    $columns['pages_count num'] = 'Pages';
    $columns['posts_count num'] = 'Posts';
    return $columns;
});


/**
 * Adds Content To The Custom Added Column
 */
add_filter('manage_users_custom_column', function ($value, $column_name, $user_id) {
    global $wpdb;
    $result = $value;

    switch ($column_name) {
        case 'user_slug':
            $arrayURL = explode('/', rtrim(get_author_posts_url($user_id), '/'));
            $result = end($arrayURL);
            break;
        case 'pages_count num':
            $count = (int) $wpdb->get_var($wpdb->prepare(
                "SELECT COUNT( ID ) FROM $wpdb->posts WHERE post_type IN ( 'page' ) AND post_status = 'publish' AND post_author = %d",
                $user_id
            ));

            if (0 < $count) {
                $result = "<a href='edit.php?post_status=publish&post_type=page&author=$user_id'>" . $count . "</a>";
            } else {
                $result = 0;
            }
            break;
        case 'posts_count num':
            $count = (int) $wpdb->get_var($wpdb->prepare(
                "SELECT COUNT( ID ) FROM $wpdb->posts WHERE post_type IN ( 'post' ) AND post_status = 'publish' AND post_author = %d",
                $user_id
            ));

            if (0 < $count) {
                $result = "<a href='edit.php?post_status=publish&post_type=post&author=$user_id'>" . $count . "</a>";
            } else {
                $result = 0;
            }
            break;
        default:
            break;
    }

    return $result;
}, 10, 3);


// Remove Contact Methods in User Profile
add_filter('user_contactmethods', function ($methods) {
    unset($methods['facebook']);
    unset($methods['instagram']);
    unset($methods['linkedin']);
    unset($methods['instagram']);
    unset($methods['myspace']);
    unset($methods['pinterest']);
    unset($methods['soundcloud']);
    unset($methods['tumblr']);
    unset($methods['twitter']);
    unset($methods['youtube']);
    unset($methods['wikipedia']);

    return $methods;
});


/**
 * Add Author Filter work for all post/page/custom-types
 */
add_action('restrict_manage_posts', function () {
    $params = array(
        'name' => 'author',
        'show_option_all' => 'All authors', // label for all authors (display posts without filter)
        'who' => 'authors'
    );

    if (isset($get_query_var['user']))
        $params['selected'] = $_GET['user'];

    wp_dropdown_users($params);
});


/**
 * Display User Slug field below the Username
 * @param object $user The current WP_User object.
 */
function ctm_user_management_create_slugname_input($user)
{
?>
    <h3><?php _e("Change the SLUG", "blank"); ?></h3>
    <table id="user-slug_table" class="form-table">
        <tr class="user-user-slugname-wrap">
            <th>
                <label for="user_slugname">SLUG</label>
            </th>
            <td>
                <input type="text" name="user_slugname" id="user_slugname" value="<?= esc_attr($user->user_nicename); ?>" class="regular-text" /> <span class="description">Must be unique.</span>
                <p>This field will update to last part of the author URL to hide real username.</p>
            </td>
        </tr>
    </table>
<?php
}
add_action('show_user_profile',  __NAMESPACE__ . '\\ctm_user_management_create_slugname_input');
add_action('edit_user_profile',  __NAMESPACE__ . '\\ctm_user_management_create_slugname_input');


/**
 * SEO Managers Page Review Process
 */
function review_readiness_checkbox_callback($post)
{
    $value = get_post_meta($post->ID, '_review_readiness_checkbox', true);
    wp_nonce_field('review_readiness_checkbox_data', 'review_readiness_checkbox_nonce');
?>
    <p>
        <input type="checkbox" id="review_readiness_checkbox" name="review_readiness_checkbox" value="1" <?php checked($value, 1); ?> />
        <label for="review_readiness_checkbox">Mark as ready for review</label>
    </p>
    <?php
}

function add_reviewfilter_meta_boxes()
{
    add_meta_box(
        'review_readiness_checkbox',
        'Mark For Review',
        __NAMESPACE__ . '\\review_readiness_checkbox_callback',
        'page',
        'side'
    );
}
add_action('add_meta_boxes', __NAMESPACE__ . '\\add_reviewfilter_meta_boxes');

function review_readiness_page_columns($columns)
{
    $columns['review_readiness'] = 'Needs Review';
    return $columns;
}

function review_readiness_page_columns_content($column, $post_id)
{
    if ($column === 'review_readiness') {
        $value = get_post_meta($post_id, '_review_readiness_checkbox', true);
        echo $value ? 'Ready' : '';
    }
}

function review_readiness_filter_posts_by_meta()
{
    global $typenow;
    if ($typenow == 'page') {
    ?>
        <select name="review_readiness_filter">
            <option value="">All Pages</option>
            <option value="ready" <?php echo isset($_GET['review_readiness_filter']) && $_GET['review_readiness_filter'] == 'ready' ? 'selected' : ''; ?>>Ready for Review</option>
        </select>
<?php
    }
}

function review_readiness_filter_by_meta_query($query)
{
    global $pagenow;
    if ($pagenow == 'edit.php' && isset($_GET['review_readiness_filter']) && $_GET['review_readiness_filter'] != '' && is_array($query)) {
        $query['meta_query'] = [
            [
                'key' => '_review_readiness_checkbox',
                'value' => $_GET['review_readiness_filter'] == 'ready' ? '1' : '0',
            ],
        ];
    }
    return $query;
}

function handle_post_status_transition($new_status, $old_status, $post)
{
    if ('publish' === $new_status && $post->post_type == 'page') {
        $update_success = update_post_meta($post->ID, '_review_readiness_checkbox', '0');
        error_log("Post ID: {$post->ID} | Old Status: {$old_status} -> New Status: {$new_status} | Update Success: {$update_success}");
    }
}
add_action('transition_post_status', __NAMESPACE__ . '\\handle_post_status_transition', 10, 3);

function save_review_readiness_checkbox_state($post_id)
{
    if (!isset($_POST['review_readiness_checkbox_nonce'])) {
        return;
    }
    if (!wp_verify_nonce($_POST['review_readiness_checkbox_nonce'], 'review_readiness_checkbox_data')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (get_post_status($post_id) === 'publish') {
        return;
    }
    if (is_admin()) {
        $checkbox_value = isset($_POST['review_readiness_checkbox']) ? '1' : '0';
        update_post_meta($post_id, '_review_readiness_checkbox', $checkbox_value);
    }
    update_post_meta($post_id, '_review_readiness_checkbox', '1');
}
add_action('save_post', __NAMESPACE__ . '\\save_review_readiness_checkbox_state');

function ctm_manager_pages_publish_management()
{
    add_filter('manage_edit-page_columns', __NAMESPACE__ . '\\review_readiness_page_columns');
    add_action('manage_page_posts_custom_column', __NAMESPACE__ . '\\review_readiness_page_columns_content', 10, 2);
    add_action('restrict_manage_posts', __NAMESPACE__ . '\\review_readiness_filter_posts_by_meta');
    add_filter('request', __NAMESPACE__ . '\\review_readiness_filter_by_meta_query');
}
add_action('admin_init', __NAMESPACE__ . '\\ctm_manager_pages_publish_management');

//Remove code snippet for editors
function remove_codesnippet_pages()
{
    if (array_intersect(wp_get_current_user()->roles, ['page_builders', 'public_relations', 'product_team', 'editor'])) {
        foreach (['post', 'page'] as $post_type) {
            remove_meta_box('acf-group_62e2065ceeaca', $post_type, 'normal');
        }
    }
}
add_action('do_meta_boxes', __NAMESPACE__ . '\\remove_codesnippet_pages', 120);


/**
 * WPDataTables Pages Access Restriction
 */
function restrict_wpdatatables_pages_access()
{
    $current_url = $_SERVER['REQUEST_URI'];
    $restricted_slugs = [
        'wpdatatables-dashboard',
        'wpdatatables-settings',
        'wpdatatables-system-info',
        'wpdatatables-add-ons',
        'wpdatatables-getting-started',
        'wpdatatables-lite-vs-premium',
        'wpdatatables-support'
    ];

    $restricted_for_higheroles = [
        'edit-tags.php?taxonomy=partner&post_type=page',
        'edit-tags.php?taxonomy=vertical&post_type=page'
    ];

    $current_user = wp_get_current_user();
    $current_user_roles = $current_user->roles;

    // Restrict all roles besides admin
    if (!current_user_can('administrator')) {
        foreach ($restricted_slugs as $slug) {
            if (strpos($current_url, $slug) !== false) {
                wp_die('Sorry, you are not allowed to access this page.', 'Access Denied', ['response' => 403]);
            }
        }

        // Restrict pages for roles not including admin or wp_manager
        if (!current_user_can('administrator') && !in_array('wp_manager', $current_user_roles)) {
            foreach ($restricted_for_higheroles as $slug) {
                if (strpos($current_url, $slug) !== false) {
                    wp_die('Sorry, you are not allowed to access this page.', 'Access Denied', ['response' => 403]);
                }
            }
        }
    }
}
add_action('admin_init',  __NAMESPACE__ . '\\restrict_wpdatatables_pages_access');
