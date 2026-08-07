<?php

use PHPUnit\Framework\TestCase;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class PluginLoaderTest extends TestCase {

    private const FILE = ESTEEM_NGO_PLUGIN_DIR . 'esteem-ngo-plugin.php';

    private const INCLUDED_FILES = array(
        'includes/database-tables.php',
        'includes/admin-settings.php',
        'includes/modules.php',
        'includes/shortcodes.php',
        'includes/email-templates.php',
        'includes/payment-integration.php',
        'includes/branding-settings.php',
    );

    protected function setUp(): void {
        Esteem_Test_State::reset();
    }

    public function test_plugin_header_declares_required_fields(): void {
        $source = (string) file_get_contents( self::FILE );

        $this->assertMatchesRegularExpression( '/^\s*\*\s*Plugin Name:\s*\S/m', $source );
        $this->assertMatchesRegularExpression( '/^\s*\*\s*Description:\s*\S/m', $source );
        $this->assertMatchesRegularExpression( '/^\s*\*\s*Version:\s*\d/m', $source );
        $this->assertMatchesRegularExpression( '/^\s*\*\s*Author:\s*\S/m', $source );
    }

    public function test_plugin_aborts_when_accessed_directly(): void {
        $this->assertMatchesRegularExpression(
            "/if\s*\(\s*!\s*defined\(\s*'ABSPATH'\s*\)\s*\)\s*\{\s*exit;/",
            (string) file_get_contents( self::FILE )
        );
    }

    public function test_every_included_file_exists(): void {
        $source = (string) file_get_contents( self::FILE );
        preg_match_all( "/include_once\s+plugin_dir_path\(\s*__FILE__\s*\)\s*\.\s*'([^']+)'/", $source, $matches );

        $this->assertSame( self::INCLUDED_FILES, $matches[1] );

        foreach ( $matches[1] as $relative_path ) {
            $this->assertFileExists( ESTEEM_NGO_PLUGIN_DIR . $relative_path );
        }
    }

    public function test_loading_the_plugin_produces_no_output(): void {
        ob_start();
        include self::FILE;
        $output = (string) ob_get_clean();

        $this->assertSame( '', $output, 'Loading the plugin must not emit output; that breaks headers in WordPress.' );
    }

    public function test_included_files_open_with_a_php_tag(): void {
        foreach ( glob( ESTEEM_NGO_PLUGIN_DIR . 'includes/*.php' ) as $path ) {
            $contents = (string) file_get_contents( $path );
            if ( '' === trim( $contents ) ) {
                continue;
            }
            $this->assertStringStartsWith( '<?php', ltrim( $contents ), basename( $path ) . ' must start with a PHP open tag.' );
        }
    }
}
