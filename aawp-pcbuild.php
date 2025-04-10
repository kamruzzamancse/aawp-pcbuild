<?php
/*
Plugin Name: AAWP-PCBuild
Description: A plugin for Amazon affiliate-based PC part selection and dynamic product display via shortcode.
Version: 1.1
Author: Md. Kamruzzaman
Author URI: https://sparktech.agency/
License: GPL2
Text Domain: aawp-pcbuild
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly. 
}

// ==========================
// Define Plugin Constants
// ==========================
define('AAWP_PCBUILD_PATH', plugin_dir_path(__FILE__));
define('AAWP_PCBUILD_URL', plugin_dir_url(__FILE__));

// ==========================
// Include Required Files
// ==========================
require_once AAWP_PCBUILD_PATH . 'includes/api-handler.php';
require_once AAWP_PCBUILD_PATH . 'includes/shortcode-handler.php';
require_once AAWP_PCBUILD_PATH . 'includes/admin-settings.php';
require_once AAWP_PCBUILD_PATH . 'includes/pc-builder-ui.php';

// ==========================
// Enqueue Plugin Styles
// ==========================
function aawp_pcbuild_enqueue_styles() {
    $plugin_url  = AAWP_PCBUILD_URL;
    $plugin_path = AAWP_PCBUILD_PATH;

    // Styles
    wp_enqueue_style(
        'aawp-pcbuild-style',
        $plugin_url . 'assets/css/style.css',
        array(),
        filemtime($plugin_path . 'assets/css/style.css')
    );

    // Scripts
    wp_enqueue_script(
        'aawp-pcbuild-products-card',
        $plugin_url . 'assets/js/productsCard.js',
        array('jquery'), // Dependencies
        filemtime($plugin_path . 'assets/js/productsCard.js'),
        true // Load in footer
    );

    wp_enqueue_script(
        'aawp-pcbuild-main-script',
        $plugin_url . 'assets/js/mainScript.js',
        array('jquery'),
        filemtime($plugin_path . 'assets/js/mainScript.js'),
        true
    );

    wp_localize_script('aawp-pcbuild-main-script', 'pcbuild_ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
    ));
}
add_action('wp_enqueue_scripts', 'aawp_pcbuild_enqueue_styles');

// ==========================
// Activation Hook
// ==========================
function aawp_pcbuild_activate() {
    if (!current_user_can('activate_plugins')) return;

    add_option('aawp_pcbuild_amazon_access_key', '');
    add_option('aawp_pcbuild_amazon_secret_key', '');
    add_option('aawp_pcbuild_amazon_associate_tag', '');
}
register_activation_hook(__FILE__, 'aawp_pcbuild_activate');

// ==========================
// Deactivation Hook
// ==========================
function aawp_pcbuild_deactivate() {
    if (!current_user_can('activate_plugins')) return;

    // Clean up temp data or transients if needed
}
register_deactivation_hook(__FILE__, 'aawp_pcbuild_deactivate');

// ==========================
// Uninstall Cleanup Hook
// ==========================
function aawp_pcbuild_uninstall() {
    if (!current_user_can('activate_plugins')) return;

    delete_option('aawp_pcbuild_amazon_access_key');
    delete_option('aawp_pcbuild_amazon_secret_key');
    delete_option('aawp_pcbuild_amazon_associate_tag');

    // You can delete transients/logs if any
}
register_uninstall_hook(__FILE__, 'aawp_pcbuild_uninstall');
