<?php
/**
 * Test bootstrap: minimal WordPress stubs so plugin files can be loaded
 * without a full WordPress installation.
 */

define( 'ABSPATH', __DIR__ . '/' );
define( 'ESTEEM_NGO_PLUGIN_DIR', dirname( __DIR__ ) . '/' );

/**
 * Mutable state used by the stubs below and asserted on by the tests.
 */
class Esteem_Test_State {
    /** @var array<string,bool> */
    public static $capabilities = array();
    /** @var array<int,array{hook:string,callback:mixed,priority:int}> */
    public static $actions = array();
    /** @var array<int,array<string,mixed>> */
    public static $menu_pages = array();
    /** @var array<int,string> */
    public static $died = array();

    public static function reset(): void {
        self::$capabilities = array();
        self::$actions      = array();
        self::$menu_pages   = array();
        self::$died         = array();
    }
}

/**
 * Thrown by the wp_die() stub so execution stops like it does in WordPress.
 */
class Esteem_Wp_Die_Exception extends RuntimeException {}

function plugin_dir_path( string $file ): string {
    return rtrim( dirname( $file ), '/' ) . '/';
}

function current_user_can( string $capability ): bool {
    return ! empty( Esteem_Test_State::$capabilities[ $capability ] );
}

function wp_die( string $message = '' ) {
    Esteem_Test_State::$died[] = $message;
    throw new Esteem_Wp_Die_Exception( $message );
}

function add_action( string $hook, $callback, int $priority = 10 ): bool {
    Esteem_Test_State::$actions[] = array(
        'hook'     => $hook,
        'callback' => $callback,
        'priority' => $priority,
    );
    return true;
}

function add_menu_page( string $page_title, string $menu_title, string $capability, string $menu_slug, $callback = '' ): string {
    Esteem_Test_State::$menu_pages[] = array(
        'page_title' => $page_title,
        'menu_title' => $menu_title,
        'capability' => $capability,
        'menu_slug'  => $menu_slug,
        'callback'   => $callback,
    );
    return 'toplevel_page_' . $menu_slug;
}

function number_format_i18n( $number, int $decimals = 0 ): string {
    return number_format( (float) $number, $decimals );
}
