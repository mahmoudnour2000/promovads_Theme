<?php
/**
 * Scripts & Styles Enqueue
 *
 * @package PromovaDS_News
 */

defined( 'ABSPATH' ) || exit;

function promovads_scripts() {

	// ── Styles ─────────────────────────────────────────────────────────────────
	wp_enqueue_style(
		'promovads-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@700;900&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'promovads-icons',
		'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css',
		array(),
		'6.5.0'
	);

	wp_enqueue_style(
		'promovads-style',
		get_stylesheet_uri(),
		array( 'promovads-fonts', 'promovads-icons' ),
		PROMOVADS_VERSION
	);

	wp_style_add_data( 'promovads-style', 'rtl', 'replace' );

	// Demo-specific stylesheet
	$demo = get_theme_mod( 'promovads_active_demo', '' );
	if ( $demo ) {
		wp_enqueue_style(
			'promovads-demo-' . sanitize_key( $demo ),
			PROMOVADS_URI . '/assets/css/demos/' . sanitize_key( $demo ) . '.css',
			array( 'promovads-style' ),
			PROMOVADS_VERSION
		);
	}

	// Dark mode saved preference (critical, inline)
	wp_add_inline_style(
		'promovads-style',
		'.pds-preload * { transition: none !important; }'
	);

	// ── Scripts ────────────────────────────────────────────────────────────────
	wp_enqueue_script(
		'promovads-main',
		PROMOVADS_URI . '/assets/js/main.js',
		array(),
		PROMOVADS_VERSION,
		array( 'strategy' => 'defer', 'in_footer' => true )
	);

	wp_localize_script(
		'promovads-main',
		'promovaDS',
		array(
			'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
			'nonce'     => wp_create_nonce( 'promovads_nonce' ),
			'isRtl'     => (int) is_rtl(),
			'homeUrl'   => esc_url( home_url( '/' ) ),
			'i18n'      => array(
				'search'    => esc_html__( 'Search...', 'promovads' ),
				'noResults' => esc_html__( 'No results found.', 'promovads' ),
				'loading'   => esc_html__( 'Loading...', 'promovads' ),
				'darkMode'  => esc_html__( 'Toggle dark mode', 'promovads' ),
			),
		)
	);

	// Comments reply script
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'promovads_scripts' );

/**
 * Admin enqueue.
 */
function promovads_admin_scripts( $hook ) {
	wp_enqueue_style(
		'promovads-admin',
		PROMOVADS_URI . '/assets/css/admin.css',
		array(),
		PROMOVADS_VERSION
	);
}
add_action( 'admin_enqueue_scripts', 'promovads_admin_scripts' );

/**
 * Preload critical assets.
 */
function promovads_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array( 'href' => 'https://fonts.googleapis.com', 'crossorigin' => true );
		$urls[] = array( 'href' => 'https://fonts.gstatic.com',    'crossorigin' => true );
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'promovads_resource_hints', 10, 2 );

/**
 * Add defer/async attributes.
 */
function promovads_script_loader_tag( $tag, $handle, $src ) {
	$defer_scripts = array( 'promovads-main' );
	if ( in_array( $handle, $defer_scripts, true ) ) {
		return str_replace( ' src', ' defer src', $tag );
	}
	return $tag;
}
add_filter( 'script_loader_tag', 'promovads_script_loader_tag', 10, 3 );
