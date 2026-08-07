<?php

/**
 * Plugin Name: Esteem NGO Plugin
 * Description: A plugin for managing NGO activities and donations.
 * Version: 1.0
 * Author: Esteempro01
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Include necessary files
include_once plugin_dir_path( __FILE__ ) . 'includes/helpers.php';

esteem_ngo_include_files(
    array(
        'database-tables',
        'admin-settings',
        'modules',
        'shortcodes',
        'email-templates',
        'payment-integration',
        'branding-settings',
    )
);
