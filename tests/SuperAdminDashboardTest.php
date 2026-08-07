<?php

use PHPUnit\Framework\TestCase;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class SuperAdminDashboardTest extends TestCase {

    private const FILE = ESTEEM_NGO_PLUGIN_DIR . 'includes/super-admin-dashboard.php';

    protected function setUp(): void {
        Esteem_Test_State::reset();
    }

    public function test_loading_denies_access_without_super_admin_capability(): void {
        $this->expectException( Esteem_Wp_Die_Exception::class );

        try {
            include self::FILE;
        } finally {
            $this->assertSame(
                array( 'You do not have sufficient permissions to access this page.' ),
                Esteem_Test_State::$died
            );
            $this->assertSame( array(), Esteem_Test_State::$actions );
        }
    }

    public function test_loading_registers_admin_menu_for_super_admin(): void {
        Esteem_Test_State::$capabilities['super_admin'] = true;

        include self::FILE;

        $this->assertSame( array(), Esteem_Test_State::$died );
        $this->assertTrue( function_exists( 'display_super_admin_dashboard' ) );

        $this->assertCount( 1, Esteem_Test_State::$actions );
        $action = Esteem_Test_State::$actions[0];
        $this->assertSame( 'admin_menu', $action['hook'] );
        $this->assertIsCallable( $action['callback'] );

        $this->assertSame( array(), Esteem_Test_State::$menu_pages );
        call_user_func( $action['callback'] );

        $this->assertSame(
            array(
                array(
                    'page_title' => 'Super Admin Dashboard',
                    'menu_title' => 'Dashboard',
                    'capability' => 'super_admin',
                    'menu_slug'  => 'super_admin_dashboard',
                    'callback'   => 'display_super_admin_dashboard',
                ),
            ),
            Esteem_Test_State::$menu_pages
        );
    }

    public function test_dashboard_renders_stat_widgets_and_recent_donations(): void {
        $html = $this->renderDashboard();

        $this->assertStringContainsString( '<h1>Super Admin Dashboard</h1>', $html );
        $this->assertStringContainsString( 'Total Campaigns: 100', $html );
        $this->assertStringContainsString( 'Total Donations: $250,000', $html );
        $this->assertStringContainsString( 'Total Beneficiaries: 500', $html );
        $this->assertStringContainsString( 'Total Volunteers: 150', $html );

        $this->assertStringContainsString( '<li>Campaign 1 - $5,000 on 2026-04-01</li>', $html );
        $this->assertStringContainsString( '<li>Campaign 2 - $3,000 on 2026-03-30</li>', $html );
        $this->assertSame( 2, substr_count( $html, '<li>' ) );
    }

    public function test_dashboard_renders_chart_and_activity_placeholders(): void {
        $html = $this->renderDashboard();

        foreach ( array( 'Campaign Performance Chart', 'Donation Trends Chart', 'User Activity Feed' ) as $heading ) {
            $this->assertStringContainsString( '<h3>' . $heading . '</h3>', $html );
        }
        $this->assertSame( 2, substr_count( $html, 'Chart Placeholder' ) );
        $this->assertStringContainsString( 'User Activity Placeholder', $html );
    }

    public function test_dashboard_output_has_balanced_wrapper_markup(): void {
        $html = $this->renderDashboard();

        $this->assertSame( substr_count( $html, '<div' ), substr_count( $html, '</div>' ) );
        $this->assertSame( substr_count( $html, '<ul>' ), substr_count( $html, '</ul>' ) );
    }

    private function renderDashboard(): string {
        Esteem_Test_State::$capabilities['super_admin'] = true;
        include self::FILE;

        ob_start();
        display_super_admin_dashboard();
        return (string) ob_get_clean();
    }
}
