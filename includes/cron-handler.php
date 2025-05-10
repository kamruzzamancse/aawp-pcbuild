<?php

if (!defined('ABSPATH')) {
    exit;
}

// Register custom cron schedule (hourly)
add_filter('cron_schedules', function($schedules) {
    if (!isset($schedules['aawp_pcbuild_hourly'])) {
        $schedules['aawp_pcbuild_hourly'] = [
            'interval' => HOUR_IN_SECONDS,
            'display'  => __('Every Hour (AAWP PC Builder)')
        ];
    }
    return $schedules;
});

// Schedule the cron event on plugin activation
//register_activation_hook(__FILE__, 'aawp_pcbuild_schedule_cron');
function aawp_pcbuild_schedule_cron() {
    if (!wp_next_scheduled('aawp_pcbuild_cron_hook')) {
        wp_schedule_event(time(), 'aawp_pcbuild_hourly', 'aawp_pcbuild_cron_hook');
    }
}

// Clear cron on plugin deactivation
//register_deactivation_hook(__FILE__, 'aawp_pcbuild_clear_cron');
function aawp_pcbuild_clear_cron() {
    $timestamp = wp_next_scheduled('aawp_pcbuild_cron_hook');
    if ($timestamp) {
        wp_unschedule_event($timestamp, 'aawp_pcbuild_cron_hook');
    }
}

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
