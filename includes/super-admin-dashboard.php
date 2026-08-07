<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

include_once plugin_dir_path( __FILE__ ) . 'helpers.php';

// Dashboard function to display stats
function display_super_admin_dashboard() {
    esteem_ngo_require_cap( 'super_admin' );

    // Sample data for widgets (replace with dynamic data)
    $total_campaigns     = 100;
    $total_donations     = 250000;
    $total_beneficiaries = 500;
    $total_volunteers    = 150;

    // Recent Donations (replace with dynamic data)
    $recent_donations = array(
        array( 'name' => 'Campaign 1', 'amount' => 5000, 'date' => '2026-04-01' ),
        array( 'name' => 'Campaign 2', 'amount' => 3000, 'date' => '2026-03-30' ),
    );

    echo '<h1>Super Admin Dashboard</h1>';

    esteem_ngo_render_stats(
        array(
            array( 'label' => 'Total Campaigns', 'value' => $total_campaigns ),
            array( 'label' => 'Total Donations', 'value' => $total_donations, 'currency' => true ),
            array( 'label' => 'Total Beneficiaries', 'value' => $total_beneficiaries ),
            array( 'label' => 'Total Volunteers', 'value' => $total_volunteers ),
        )
    );

    esteem_ngo_render_section(
        'Recent Donations',
        function () use ( $recent_donations ) {
            echo '<ul>';
            foreach ( $recent_donations as $donation ) {
                echo '<li>' . esc_html(
                    $donation['name'] . ' - ' . esteem_ngo_format_amount( $donation['amount'] ) . ' on ' . $donation['date']
                ) . '</li>';
            }
            echo '</ul>';
        }
    );

    esteem_ngo_render_placeholder( 'Campaign Performance Chart', 'Chart Placeholder', true );
    esteem_ngo_render_placeholder( 'Donation Trends Chart', 'Chart Placeholder', true );
    esteem_ngo_render_placeholder( 'User Activity Feed', 'User Activity Placeholder' );
}

// Add the dashboard to the admin menu
add_action('admin_menu', function() {
    add_menu_page('Super Admin Dashboard', 'Dashboard', 'super_admin', 'super_admin_dashboard', 'display_super_admin_dashboard');
});
