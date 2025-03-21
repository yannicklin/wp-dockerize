<?php




/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our theme. We will simply require it into the script here so that we
| don't have to worry about manually loading any of our classes later on.
|
*/

if (!file_exists($composer = __DIR__ . '/vendor/autoload.php')) {
    wp_die(__('Error locating autoloader. Please run <code>composer install</code>.', 'ctm-atlas'));
}

require $composer;

/*
|--------------------------------------------------------------------------
| Register The Bootloader
|--------------------------------------------------------------------------
|
| The first thing we will do is schedule a new Acorn application container
| to boot when WordPress is finished loading the theme. The application
| serves as the "glue" for all the components of Laravel and is
| the IoC container for the system binding all of the various parts.
|
*/

try {
    \Roots\bootloader();
} catch (Throwable $e) {
    wp_die(
        __('You need to install Acorn to use this theme.', 'ctm-atlas'),
        '',
        [
            'link_url' => 'https://docs.roots.io/acorn/2.x/installation/',
            'link_text' => __('Acorn Docs: Installation', 'ctm-atlas'),
        ]
    );
}

if (!file_exists(__DIR__ . '/public/build/manifest.json') && !file_exists(__DIR__ . '/public/hot')) {
    wp_die(__('No Vite manifest or hot file found, npm run dev or npm run build', 'ctm-atlas'));
}

/*
|--------------------------------------------------------------------------
| Register Sage Theme Files
|--------------------------------------------------------------------------
|
| Out of the box, Sage ships with categorically named theme files
| containing common functionality and setup to be bootstrapped with your
| theme. Simply add (or remove) files from the array below to change what
| is registered alongside Sage.
|
*/

collect(['setup', 'filters', 'shortcodes', 'schema'])
    ->each(function ($file) {
        if (!locate_template($file = "app/{$file}.php", true, true)) {
            wp_die(
                sprintf(__('Error locating <code>%s</code> for inclusion.', 'ctm-atlas'), $file)
            );
        }
    });

collect(['Panel', 'UserMgmt', 'Documents/Documentation', 'Documents/Images', 'Documents/Partners', 'Documents/Shortcodes'])
    ->each(function ($file) {
        if (!locate_template($file = "admins/{$file}.php", true, true)) {
            wp_die(
                sprintf(__('Error locating <code>%s</code> for Admins Management.', 'ctm-atlas'), $file)
            );
        }
    });

/*
 * Ensure Advanced Custom Fields is enabled
 */
if (!function_exists('get_field') && !is_admin()) {
    wp_die(
        __('Install Advanced Custom Fields v5.8 or higher before proceeding!', 'ctm-atlas')
    );
}

/*
 * Ensure Yoast & its Breadcrumb is enabled
 */
if (
    in_array(
        "wordpress-seo/wp-seo.php",
        apply_filters("active_plugins", get_option("active_plugins"))
    ) &&
    class_exists("WPSEO_Options") &&
    WPSEO_Options::get("breadcrumbs-enable", false)
) {
    /* Yoast breadcrumbs is active */
} elseif (!is_admin()) {
    wp_die(
        __(
            "Install Yoast and enable the Breadcrumb before proceeding!",
            "atlas"
        )
    );
}


/*
|--------------------------------------------------------------------------
| Enable Sage Theme Support
|--------------------------------------------------------------------------
|
| Once our theme files are registered and available for use, we are almost
| ready to boot our application. But first, we need to signal to Acorn
| that we will need to initialize the necessary service providers built in
| for Sage when booting.
|
*/

add_theme_support('sage');
