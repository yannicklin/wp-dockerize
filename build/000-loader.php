<?php

/* Exit if accessed directly */
if (!defined('ABSPATH')) {
    exit;
}

require '/var/www/html/static-content/themes/compare-the-market/vendor/autoload.php';


# Installed as a Must Use plugin. Constants and any hacks go here

# Disable new relic if we are attempting to scrape the site
if (!empty($_SERVER["HTTP_USER_AGENT"]) && str_starts_with($_SERVER["HTTP_USER_AGENT"], "Scrapy/")) {
    if (extension_loaded('newrelic')) { // Ensure PHP agent is available
        newrelic_disable_autorum();
    }
}
