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
include_once plugin_dir_path( __FILE__ ) . 'includes/database-tables.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/admin-settings.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/modules.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/shortcodes.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/email-templates.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/payment-integration.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/branding-settings.php';
