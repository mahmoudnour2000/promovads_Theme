<?php
/**
 * Scripts & Styles Enqueue
 *
 * @package PromovaDS_News
 */

defined( 'ABSPATH' ) || exit;

function promovads_scripts() {

	$demo   = promovads_active_demo();
	$config = promovads_get_demo_config( $demo );

	wp_enqueue_style(
		'promovads-icons',
		'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css',
		array(),
		'6.5.0'
	);

	if ( ! $config ) {
		wp_enqueue_style(
			'promovads-fonts',
			'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@700;900&display=swap',
			array(),
			null
		);
	}

	wp_enqueue_style(
		'promovads-style',
		get_stylesheet_uri(),
		array( $config ? 'promovads-icons' : 'promovads-fonts', 'promovads-icons' ),
		PROMOVADS_VERSION
	);

	wp_style_add_data( 'promovads-style', 'rtl', 'replace' );

	if ( $config ) {
		if ( ! empty( $config['fonts'] ) ) {
			wp_enqueue_style(
				'promovads-demo-fonts',
				$config['fonts'],
				array(),
				null
			);
		}

		wp_enqueue_style(
			'promovads-pds-core',
			PROMOVADS_URI . '/assets/css/pds-core.css',
			array( 'promovads-style' ),
			PROMOVADS_VERSION
		);

		wp_enqueue_style(
			'promovads-demo-shared',
			PROMOVADS_URI . '/assets/css/demo-shared.css',
			array( 'promovads-pds-core' ),
			PROMOVADS_VERSION
		);

		$css_slug = promovads_demo_css_slug( $demo );
		wp_enqueue_style(
			'promovads-demo-' . sanitize_key( $css_slug ),
			PROMOVADS_URI . '/assets/css/demos/' . sanitize_key( $css_slug ) . '.css',
			array( 'promovads-demo-shared' ),
			PROMOVADS_VERSION
		);

		wp_enqueue_style(
			'promovads-demo-fixes',
			PROMOVADS_URI . '/assets/css/demo-front-fixes.css',
			array( 'promovads-demo-' . sanitize_key( $css_slug ) ),
			PROMOVADS_VERSION
		);

		wp_enqueue_style(
			'promovads-demo-colors',
			PROMOVADS_URI . '/assets/css/demo-color-system.css',
			array( 'promovads-demo-fixes' ),
			PROMOVADS_VERSION
		);

		wp_enqueue_style(
			'promovads-demo-skins',
			PROMOVADS_URI . '/assets/css/demo-skins.css',
			array( 'promovads-demo-colors' ),
			PROMOVADS_VERSION
		);

		wp_enqueue_script(
			'promovads-nav-overflow',
			PROMOVADS_URI . '/assets/js/nav-overflow.js',
			array(),
			PROMOVADS_VERSION,
			array( 'strategy' => 'defer', 'in_footer' => true )
		);

		wp_enqueue_script(
			'promovads-demo-ui',
			PROMOVADS_URI . '/assets/js/demo-ui.js',
			array( 'promovads-main' ),
			PROMOVADS_VERSION,
			array( 'strategy' => 'defer', 'in_footer' => true )
		);
	} elseif ( $demo ) {
		wp_enqueue_style(
			'promovads-demo-' . sanitize_key( $demo ),
			PROMOVADS_URI . '/assets/css/demos/' . sanitize_key( $demo ) . '.css',
			array( 'promovads-style' ),
			PROMOVADS_VERSION
		);
	}

	wp_add_inline_style(
		'promovads-style',
		'.pds-preload * { transition: none !important; }'
	);

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
			'isRtl'     => (int) ( is_rtl() || (bool) $config ),
			'homeUrl'   => esc_url( home_url( '/' ) ),
			'i18n'      => $config ? array(
				'search'     => esc_html__( 'ابحث في الأخبار…', 'promovads' ),
				'noResults'  => esc_html__( 'لا توجد نتائج.', 'promovads' ),
				'loading'    => esc_html__( 'جاري البحث…', 'promovads' ),
				'copied'     => esc_html__( 'تم نسخ الرابط', 'promovads' ),
				'copyFailed' => esc_html__( 'تعذّر نسخ الرابط', 'promovads' ),
				'darkMode'   => esc_html__( 'تبديل الوضع الداكن', 'promovads' ),
			) : array(
				'search'    => esc_html__( 'Search...', 'promovads' ),
				'noResults' => esc_html__( 'No results found.', 'promovads' ),
				'loading'   => esc_html__( 'Loading...', 'promovads' ),
				'darkMode'  => esc_html__( 'Toggle dark mode', 'promovads' ),
			),
		)
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'promovads_scripts' );

function promovads_admin_scripts( $hook ) {
	if ( str_contains( $hook, 'promovads-theme' ) ) {
		return;
	}
	wp_enqueue_style(
		'promovads-admin',
		PROMOVADS_URI . '/assets/css/admin.css',
		array(),
		PROMOVADS_VERSION
	);
}
add_action( 'admin_enqueue_scripts', 'promovads_admin_scripts' );

function promovads_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array( 'href' => 'https://fonts.googleapis.com', 'crossorigin' => true );
		$urls[] = array( 'href' => 'https://fonts.gstatic.com',    'crossorigin' => true );
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'promovads_resource_hints', 10, 2 );

function promovads_script_loader_tag( $tag, $handle, $src ) {
	$defer_scripts = array( 'promovads-main', 'promovads-nav-overflow', 'promovads-demo-ui' );
	if ( in_array( $handle, $defer_scripts, true ) ) {
		return str_replace( ' src', ' defer src', $tag );
	}
	return $tag;
}
add_filter( 'script_loader_tag', 'promovads_script_loader_tag', 10, 3 );
