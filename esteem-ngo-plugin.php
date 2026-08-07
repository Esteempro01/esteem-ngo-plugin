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

/**
 * Files that make up the plugin, loaded in dependency order.
 */
function esteem_ngo_plugin_includes() {
    return array(
        'includes/database-tables.php',
        'includes/admin-settings.php',
        'includes/modules.php',
        'includes/shortcodes.php',
        'includes/email-templates.php',
        'includes/payment-integration.php',
        'includes/branding-settings.php',
        'includes/super-admin-dashboard.php',
    );
}

/**
 * Loads the plugin's include files.
 *
 * Missing files are collected and reported instead of being ignored, so a
 * broken install surfaces in the logs and in the admin area rather than
 * leaving the plugin half-initialised.
 *
 * @return string[] Relative paths that could not be loaded.
 */
function esteem_ngo_load_includes() {
    $missing = array();

    foreach ( esteem_ngo_plugin_includes() as $relative_path ) {
        $path = plugin_dir_path( __FILE__ ) . $relative_path;

        if ( ! is_readable( $path ) ) {
            $missing[] = $relative_path;
            continue;
        }

        require_once $path;
    }

    return $missing;
}

$esteem_ngo_missing_includes = esteem_ngo_load_includes();

if ( ! empty( $esteem_ngo_missing_includes ) ) {
    $esteem_ngo_missing_message = sprintf(
        'Esteem NGO Plugin: unable to load required file(s): %s',
        implode( ', ', $esteem_ngo_missing_includes )
    );

    error_log( $esteem_ngo_missing_message );

    add_action(
        'admin_notices',
        function () use ( $esteem_ngo_missing_message ) {
            if ( ! current_user_can( 'activate_plugins' ) ) {
                return;
            }

            printf(
                '<div class="notice notice-error"><p>%s</p></div>',
                esc_html( $esteem_ngo_missing_message )
            );
        }
    );
}
