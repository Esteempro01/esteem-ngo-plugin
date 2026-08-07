<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Capability required to view the dashboard
if ( ! defined( 'ESTEEM_NGO_ADMIN_CAP' ) ) {
    define( 'ESTEEM_NGO_ADMIN_CAP', is_multisite() ? 'manage_network' : 'manage_options' );
}

// Dashboard function to display stats
function display_super_admin_dashboard() {
    if ( ! current_user_can( ESTEEM_NGO_ADMIN_CAP ) ) {
        wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'esteem-ngo-plugin' ) );
    }

    // Sample data for widgets (replace with dynamic data)
    $total_campaigns = 100;
    $total_donations = 250000;
    $total_beneficiaries = 500;
    $total_volunteers = 150;

    // Recent Donations (replace with dynamic data)
    $recent_donations = array(
        array('name' => 'Campaign 1', 'amount' => 5000, 'date' => '2026-04-01'),
        array('name' => 'Campaign 2', 'amount' => 3000, 'date' => '2026-03-30'),
    );

    // HTML for the dashboard
    echo '<h1>Super Admin Dashboard</h1>';
    echo '<div>';
    echo '<h2>Total Campaigns: ' . esc_html( $total_campaigns ) . '</h2>';
    echo '<h2>Total Donations: $' . esc_html( number_format( $total_donations ) ) . '</h2>';
    echo '<h2>Total Beneficiaries: ' . esc_html( $total_beneficiaries ) . '</h2>';
    echo '<h2>Total Volunteers: ' . esc_html( $total_volunteers ) . '</h2>';
    echo '</div>';

    echo '<h3>Recent Donations</h3>';
    echo '<ul>';
    foreach ($recent_donations as $donation) {
        echo '<li>' . esc_html( $donation['name'] ) . ' - $' . esc_html( number_format( $donation['amount'] ) ) . ' on ' . esc_html( $donation['date'] ) . '</li>';
    }
    echo '</ul>';

    // Performance and trends charts would go here
    echo '<h3>Campaign Performance Chart</h3>';
    echo '<div style="height:300px; border:1px solid #ccc;">Chart Placeholder</div>';
    echo '<h3>Donation Trends Chart</h3>';
    echo '<div style="height:300px; border:1px solid #ccc;">Chart Placeholder</div>';
    echo '<h3>User Activity Feed</h3>';
    echo '<div>User Activity Placeholder</div>';
}

// Add the dashboard to the admin menu
add_action('admin_menu', function() {
    add_menu_page('Super Admin Dashboard', 'Dashboard', ESTEEM_NGO_ADMIN_CAP, 'super_admin_dashboard', 'display_super_admin_dashboard');
});
