<?php
/**
 * Shared helpers used across the plugin.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'esteem_ngo_include_files' ) ) {
    /**
     * Include a list of files relative to the plugin's includes directory.
     *
     * @param string[] $files File names, without the .php extension.
     */
    function esteem_ngo_include_files( array $files ) {
        foreach ( $files as $file ) {
            include_once plugin_dir_path( __FILE__ ) . $file . '.php';
        }
    }
}

if ( ! function_exists( 'esteem_ngo_require_cap' ) ) {
    /**
     * Stop rendering unless the current user has the given capability.
     *
     * @param string $capability
     */
    function esteem_ngo_require_cap( $capability ) {
        if ( ! current_user_can( $capability ) ) {
            wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'esteem-ngo' ) );
        }
    }
}

if ( ! function_exists( 'esteem_ngo_format_amount' ) ) {
    /**
     * Format a monetary amount for display.
     *
     * @param int|float $amount
     * @return string
     */
    function esteem_ngo_format_amount( $amount ) {
        return '$' . number_format( $amount );
    }
}

if ( ! function_exists( 'esteem_ngo_render_stat' ) ) {
    /**
     * Render a single dashboard statistic.
     *
     * @param string    $label
     * @param int|float $value
     * @param bool      $is_currency
     */
    function esteem_ngo_render_stat( $label, $value, $is_currency = false ) {
        $formatted = $is_currency ? esteem_ngo_format_amount( $value ) : number_format( $value );

        echo '<h2>' . esc_html( $label ) . ': ' . esc_html( $formatted ) . '</h2>';
    }
}

if ( ! function_exists( 'esteem_ngo_render_stats' ) ) {
    /**
     * Render a group of dashboard statistics.
     *
     * @param array[] $stats List of arrays with `label`, `value` and optional `currency` keys.
     */
    function esteem_ngo_render_stats( array $stats ) {
        echo '<div>';
        foreach ( $stats as $stat ) {
            esteem_ngo_render_stat(
                $stat['label'],
                $stat['value'],
                ! empty( $stat['currency'] )
            );
        }
        echo '</div>';
    }
}

if ( ! function_exists( 'esteem_ngo_render_section' ) ) {
    /**
     * Render a titled dashboard section.
     *
     * @param string   $title
     * @param callable $render_body
     */
    function esteem_ngo_render_section( $title, callable $render_body ) {
        echo '<h3>' . esc_html( $title ) . '</h3>';
        $render_body();
    }
}

if ( ! function_exists( 'esteem_ngo_render_placeholder' ) ) {
    /**
     * Render a placeholder block for a not-yet-implemented widget.
     *
     * @param string $title
     * @param string $text
     * @param bool   $boxed Whether to draw the fixed-height bordered box used by charts.
     */
    function esteem_ngo_render_placeholder( $title, $text, $boxed = false ) {
        esteem_ngo_render_section(
            $title,
            function () use ( $text, $boxed ) {
                $style = $boxed ? ' style="height:300px; border:1px solid #ccc;"' : '';
                echo '<div' . $style . '>' . esc_html( $text ) . '</div>';
            }
        );
    }
}
