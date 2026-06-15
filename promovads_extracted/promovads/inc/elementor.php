<?php
/**
 * Elementor Compatibility
 *
 * @package PromovaDS_News
 */

defined( 'ABSPATH' ) || exit;

/**
 * Add Elementor theme support.
 */
function promovads_elementor_support(): void {
	add_theme_support( 'header-footer-elementor' );
}
add_action( 'after_setup_theme', 'promovads_elementor_support' );

/**
 * Register Elementor locations.
 */
function promovads_elementor_locations( $elementor_theme_manager ): void {
	$elementor_theme_manager->register_location( 'header' );
	$elementor_theme_manager->register_location( 'footer' );
}
add_action( 'elementor/theme/register_locations', 'promovads_elementor_locations' );

/**
 * Disable Elementor default colors/fonts to use theme's.
 */
function promovads_elementor_disable_defaults(): void {
	update_option( 'elementor_disable_color_schemes', 'yes' );
	update_option( 'elementor_disable_typography_schemes', 'yes' );
}
add_action( 'after_switch_theme', 'promovads_elementor_disable_defaults' );

/**
 * Add custom Elementor CSS variables.
 */
function promovads_elementor_css( string $css ): string {
	$primary   = get_theme_mod( 'promovads_color_primary',   '#e63329' );
	$secondary = get_theme_mod( 'promovads_color_secondary', '#1a1a2e' );
	$accent    = get_theme_mod( 'promovads_color_accent',    '#f5a623' );

	$custom_css = sprintf(
		'.elementor { --e-global-color-primary: %s; --e-global-color-secondary: %s; --e-global-color-accent: %s; }',
		sanitize_hex_color( $primary ),
		sanitize_hex_color( $secondary ),
		sanitize_hex_color( $accent )
	);

	return $css . $custom_css;
}
add_filter( 'elementor/frontend/print_google_fonts', 'promovads_elementor_css' );
