<?php

/**
 * Documentation Management
 */

namespace Admins\Documentation;

use Admins\Documentation\{Images, Partners, Shortcodes};

function documentation_index()
{
    $content = <<<CONTENT
    <p>Welcome to Compare the Market website documentation.</p>
    <p>Select from the menu above to the left to navigate to the section you would like to know more on.</p>
CONTENT;
    $rendered = setup_documentation_content($content, 'Compare the Market - Documentation');

    echo $rendered;
}

function documentation_images()
{
    $content = Images::content();
    $rendered = setup_documentation_content($content, 'Compare the Market - Images');

    echo $rendered;
}

function documentation_partners()
{
    $content = Partners::content();
    $rendered = setup_documentation_content($content, 'Compare the Market - Partners');

    echo $rendered;
}

function documentation_shortcodes()
{
    $page_menu = Shortcodes::page_menu();
    $content = Shortcodes::content();
    $rendered = setup_documentation_content($content, 'Compare the Market - Shortcodes', $page_menu);

    echo $rendered;
}

function setup_documentation_content($content = false, $title = false, $page_menu = false)
{
    $title = setup_documentation_title($title);

    if (false === $content) {
        return 'No content detected. Contact IT support.';
    }

    if (false === $page_menu) {
        $page_menu = '';
    } else {
        $page_menu = '<h2>Sub menu</h2>' . $page_menu . '<hr style="margin-bottom: 30px;" />';
    }

    $styles = <<<STYLES
    <style type="text/css">
    div.ctm {margin: 0 auto;}
    div.ctm h2 pre {font-size: 20px;}
    div.ctm ul.params, ul.sub-menu {margin-left: 20px;}
    div.ctm ul.params li, ul.sub-menu li {list-style: disc;}
    div.ctm ul.params ul {margin-left: 20px;}
    div.ctm .alert {background: #e5f5fa; border-color: #00a0d2; padding: 1rem; margin: .5rem; overflow: auto; position: relative; border-width: 0 0 0 .5rem; border-style: solid;}
    div.ctm .alert-danger {background: #F8D7Da; border-color: #601F26; padding: .5rem; margin: .1rem; overflow: auto; position: relative; border-width: 0 0 0 .5rem; border-style: solid;}
    div.ctm pre.source {background: #dddddd; padding: 15px; margin-top: 0; white-space: inherit;}
    div.sep {padding-bottom: 15px; margin-bottom: 15px; border-bottom: 1px solid #dddddd;}
    </style>
STYLES;

    return <<<PAGE
    {$styles}
    <div class="wrap">
        {$title}
        <hr class="wp-header-end">

        <ul class="subsubsub">
            <li><a href="admin.php?page=ctm-documentation">Documentation Index</a></li>
            <li> | <a href="admin.php?page=ctm-images">Images</a></li>
            <li> | <a href="admin.php?page=ctm-partners">Partners Logos</a></li>
            <li> | <a href="admin.php?page=ctm-shortcodes">Shortcodes</a></li>
        </ul>

        <div class="clear" style="margin-bottom: 30px;"></div>

        {$page_menu}

        {$content}

    </div>
PAGE;
}

function setup_documentation_title($title = false)
{
    if (false === $title) {
        return null;
    }

    return '<h1 class="wp-heading-inline">' . $title . '</h1>';
}

function documentation_menus()
{
    add_menu_page('Documentation', 'Documentation', 'edit_posts', 'ctm-documentation', __NAMESPACE__ . '\\documentation_index', '', 3);
    add_submenu_page('ctm-documentation', 'Documentation', 'Documentation', 'edit_posts', 'ctm-documentation', __NAMESPACE__ . '\\documentation_index');
    add_submenu_page('ctm-documentation', 'Images documentation', 'Images', 'edit_posts', 'ctm-images', __NAMESPACE__ . '\\documentation_images');
    add_submenu_page('ctm-documentation', 'Partners documentation', 'Partners', 'edit_posts', 'ctm-partners', __NAMESPACE__ . '\\documentation_partners');
    add_submenu_page('ctm-documentation', 'Shortcode documentation', 'Shortcodes', 'edit_posts', 'ctm-shortcodes', __NAMESPACE__ . '\\documentation_shortcodes');
}
add_action('admin_menu',  __NAMESPACE__ . '\\documentation_menus');
