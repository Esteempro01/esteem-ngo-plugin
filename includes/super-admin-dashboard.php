<?php

// Check if the user is a super admin
if (!current_user_can('super_admin')) {
    wp_die('You do not have sufficient permissions to access this page.');
}

// Dashboard function to display stats
function display_super_admin_dashboard() {
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
    echo '<h2>Total Campaigns: ' . $total_campaigns . '</h2>';
    echo '<h2>Total Donations: $' . number_format($total_donations) . '</h2>';
    echo '<h2>Total Beneficiaries: ' . $total_beneficiaries . '</h2>';
    echo '<h2>Total Volunteers: ' . $total_volunteers . '</h2>';
    echo '</div>';

    echo '<h3>Recent Donations</h3>';
    echo '<ul>';
    foreach ($recent_donations as $donation) {
        echo '<li>' . $donation['name'] . ' - $' . number_format($donation['amount']) . ' on ' . $donation['date'] . '</li>';
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
    add_menu_page('Super Admin Dashboard', 'Dashboard', 'super_admin', 'super_admin_dashboard', 'display_super_admin_dashboard');
});

?>