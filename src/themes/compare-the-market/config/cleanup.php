<?php

return [
    'admin_bar' => [
        'wp-logo', // Remove the WordPress logo
        'about', // Remove the about WordPress link
        'wporg', // Remove the about WordPress link
        'documentation', // Remove the WordPress documentation link
        'support-forums', // Remove the support forums link
        'feedback' // Remove the feedback link
    ],
    'meta_boxes' => [
        // Remove 'Site health' metabox
        [
            'id' => 'dashboard_site_health',
            'screen' => 'dashboard',
            'context' => 'normal'
        ],
        // Remove the 'At a Glance' metabox
        [
            'id' => 'dashboard_right_now',
            'screen' => 'dashboard',
            'context' => 'normal'
        ],
        // Remove the 'Activity' metabox
        [
            'id' => 'dashboard_activity',
            'screen' => 'dashboard',
            'context' => 'normal'
        ],
        // Remove the 'WordPress News' metabox
        [
            'id' => 'dashboard_primary',
            'screen' => 'dashboard',
            'context' => 'side'
        ],
        // Remove the 'Quick Draft' metabox
        [
            'id' => 'dashboard_quick_press',
            'screen' => 'dashboard',
            'context' => 'side'
        ],
        // Remove the Yoast SEO Overview metabox
        [
            'id' => 'wpseo-dashboard-overview',
            'screen' => 'dashboard',
            'context' => 'side'
        ],
        // Remove the Yoast SEO Wincher Overview metabox
        [
            'id' => 'wpseo-wincher-dashboard-overview',
            'screen' => 'dashboard',
            'context' => 'side'
        ],
    ]
];
