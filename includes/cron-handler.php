<?php

if (!defined('ABSPATH')) {
    exit;
}

// Register custom cron schedule (every 1 hour)
add_filter('cron_schedules', function($schedules) {
    if (!isset($schedules['aawp_pcbuild_1_hour'])) {
        $schedules['aawp_pcbuild_1_hour'] = [
            'interval' => 1 * HOUR_IN_SECONDS,
            'display'  => __('Every 1 Hour (AAWP PC Builder)')
        ];
    }
    return $schedules;
});

// Schedule the cron event on plugin activation
function aawp_pcbuild_schedule_cron() {
    if (!wp_next_scheduled('aawp_pcbuild_cron_hook')) {
        wp_schedule_event(time(), 'aawp_pcbuild_1_hour', 'aawp_pcbuild_cron_hook');
    }
}
register_activation_hook(__FILE__, 'aawp_pcbuild_schedule_cron');

// Clear cron on plugin deactivation
function aawp_pcbuild_clear_cron() {
    $timestamp = wp_next_scheduled('aawp_pcbuild_cron_hook');
    if ($timestamp) {
        wp_unschedule_event($timestamp, 'aawp_pcbuild_cron_hook');
    }
}
register_deactivation_hook(__FILE__, 'aawp_pcbuild_clear_cron');

// Define the cron job callback
add_action('aawp_pcbuild_cron_hook', 'aawp_pcbuild_fetch_all_categories');

function aawp_pcbuild_fetch_all_categories() {
    $categories = [
        'cpu',
        'cpu cooler',
        'motherboard',
        'memory',
        'ram',
        'storage',
        'video card',
        'gpu',
        'case',
        'pc-case',
        'power supply',
        'operating system',
        'monitor'
    ];

    foreach ($categories as $category) {
        $result = aawp_pcbuild_get_products($category);
        if (is_string($result)) {
            error_log("AAWP PC Build: Error fetching $category - $result");
        } else {
            error_log("AAWP PC Build: Cached products for $category");
        }
    }
}
