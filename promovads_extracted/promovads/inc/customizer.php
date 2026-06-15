<?php
/**
 * Theme Customizer Settings
 *
 * @package PromovaDS_News
 */

defined( 'ABSPATH' ) || exit;

function promovads_customize_register( WP_Customize_Manager $wp_customize ): void {

	// ── Site Identity ─────────────────────────────────────────────────────────
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	// ── General Settings ──────────────────────────────────────────────────────
	$wp_customize->add_section(
		'promovads_general',
		array(
			'title'    => esc_html__( 'General Settings', 'promovads' ),
			'priority' => 25,
		)
	);

	// Active Demo
	$wp_customize->add_setting( 'promovads_active_demo', array( 'default' => '', 'sanitize_callback' => 'sanitize_key' ) );
	$wp_customize->add_control(
		'promovads_active_demo',
		array(
			'label'   => esc_html__( 'Active Demo Layout', 'promovads' ),
			'section' => 'promovads_general',
			'type'    => 'select',
			'choices' => array(
				''           => esc_html__( 'Default', 'promovads' ),
				'tech-ai'    => esc_html__( 'Tech & AI', 'promovads' ),
				'jobs'       => esc_html__( 'Jobs', 'promovads' ),
				'finance'    => esc_html__( 'Finance', 'promovads' ),
				'sports'     => esc_html__( 'Sports', 'promovads' ),
				'automotive' => esc_html__( 'Automotive', 'promovads' ),
				'real-estate'=> esc_html__( 'Real Estate', 'promovads' ),
				'health'     => esc_html__( 'Health', 'promovads' ),
				'education'  => esc_html__( 'Education', 'promovads' ),
				'crypto'     => esc_html__( 'Crypto', 'promovads' ),
				'gaming'     => esc_html__( 'Gaming', 'promovads' ),
			),
		)
	);

	// Text Direction
	$wp_customize->add_setting( 'promovads_rtl_mode', array( 'default' => 'auto', 'sanitize_callback' => 'sanitize_key' ) );
	$wp_customize->add_control(
		'promovads_rtl_mode',
		array(
			'label'   => esc_html__( 'Text Direction', 'promovads' ),
			'section' => 'promovads_general',
			'type'    => 'select',
			'choices' => array(
				'auto' => esc_html__( 'Auto (follow WordPress)', 'promovads' ),
				'ltr'  => esc_html__( 'LTR', 'promovads' ),
				'rtl'  => esc_html__( 'RTL', 'promovads' ),
			),
		)
	);

	// Dark mode default
	$wp_customize->add_setting( 'promovads_dark_mode_default', array( 'default' => 0, 'sanitize_callback' => 'absint' ) );
	$wp_customize->add_control(
		'promovads_dark_mode_default',
		array(
			'label'   => esc_html__( 'Enable Dark Mode by Default', 'promovads' ),
			'section' => 'promovads_general',
			'type'    => 'checkbox',
		)
	);

	// ── Colors ────────────────────────────────────────────────────────────────
	$wp_customize->add_section(
		'promovads_colors',
		array(
			'title'    => esc_html__( 'Theme Colors', 'promovads' ),
			'priority' => 30,
		)
	);

	$color_settings = array(
		'promovads_color_primary'   => array( 'label' => esc_html__( 'Primary Color', 'promovads' ),   'default' => '#e63329' ),
		'promovads_color_secondary' => array( 'label' => esc_html__( 'Secondary Color', 'promovads' ), 'default' => '#1a1a2e' ),
		'promovads_color_accent'    => array( 'label' => esc_html__( 'Accent Color', 'promovads' ),    'default' => '#f5a623' ),
	);

	foreach ( $color_settings as $id => $config ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => $config['default'],
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, array(
			'label'   => $config['label'],
			'section' => 'promovads_colors',
		) ) );
	}

	// ── Header ────────────────────────────────────────────────────────────────
	$wp_customize->add_section(
		'promovads_header',
		array(
			'title'    => esc_html__( 'Header Settings', 'promovads' ),
			'priority' => 35,
		)
	);

	$wp_customize->add_setting( 'promovads_show_topbar',  array( 'default' => 1, 'sanitize_callback' => 'absint' ) );
	$wp_customize->add_control( 'promovads_show_topbar',  array( 'label' => esc_html__( 'Show Top Bar', 'promovads' ), 'section' => 'promovads_header', 'type' => 'checkbox' ) );

	$wp_customize->add_setting( 'promovads_show_ticker', array( 'default' => 1, 'sanitize_callback' => 'absint' ) );
	$wp_customize->add_control( 'promovads_show_ticker', array( 'label' => esc_html__( 'Show Breaking News Ticker', 'promovads' ), 'section' => 'promovads_header', 'type' => 'checkbox' ) );

	$wp_customize->add_setting( 'promovads_sticky_header', array( 'default' => 1, 'sanitize_callback' => 'absint' ) );
	$wp_customize->add_control( 'promovads_sticky_header', array( 'label' => esc_html__( 'Sticky Header', 'promovads' ), 'section' => 'promovads_header', 'type' => 'checkbox' ) );

	$wp_customize->add_setting( 'promovads_twitter_handle', array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'promovads_twitter_handle', array( 'label' => esc_html__( 'Twitter / X Handle', 'promovads' ), 'section' => 'promovads_header', 'type' => 'text', 'input_attrs' => array( 'placeholder' => '@YourHandle' ) ) );

	// ── Footer ────────────────────────────────────────────────────────────────
	$wp_customize->add_section(
		'promovads_footer',
		array(
			'title'    => esc_html__( 'Footer Settings', 'promovads' ),
			'priority' => 40,
		)
	);

	$wp_customize->add_setting( 'promovads_footer_text', array( 'default' => '', 'sanitize_callback' => 'wp_kses_post' ) );
	$wp_customize->add_control( 'promovads_footer_text', array( 'label' => esc_html__( 'Footer Copyright Text', 'promovads' ), 'section' => 'promovads_footer', 'type' => 'textarea' ) );

	$wp_customize->add_setting( 'promovads_footer_about', array( 'default' => '', 'sanitize_callback' => 'wp_kses_post' ) );
	$wp_customize->add_control( 'promovads_footer_about', array( 'label' => esc_html__( 'About Text in Footer', 'promovads' ), 'section' => 'promovads_footer', 'type' => 'textarea' ) );

	// ── Social Links ─────────────────────────────────────────────────────────
	$wp_customize->add_section(
		'promovads_social',
		array(
			'title'    => esc_html__( 'Social Media Links', 'promovads' ),
			'priority' => 45,
		)
	);

	$socials = array(
		'facebook'  => 'Facebook URL',
		'twitter'   => 'Twitter / X URL',
		'instagram' => 'Instagram URL',
		'youtube'   => 'YouTube URL',
		'telegram'  => 'Telegram URL',
		'tiktok'    => 'TikTok URL',
		'linkedin'  => 'LinkedIn URL',
		'rss'       => 'RSS Feed URL',
	);

	foreach ( $socials as $key => $label ) {
		$wp_customize->add_setting( 'promovads_social_' . $key, array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ) );
		$wp_customize->add_control( 'promovads_social_' . $key, array( 'label' => esc_html( $label ), 'section' => 'promovads_social', 'type' => 'url' ) );
	}
}
add_action( 'customize_register', 'promovads_customize_register' );

/**
 * Output dynamic CSS variables from customizer settings.
 */
function promovads_customizer_css(): void {
	$primary   = get_theme_mod( 'promovads_color_primary',   '#e63329' );
	$secondary = get_theme_mod( 'promovads_color_secondary', '#1a1a2e' );
	$accent    = get_theme_mod( 'promovads_color_accent',    '#f5a623' );

	$css = sprintf(
		':root { --color-primary: %s; --color-primary-dark: %s; --color-secondary: %s; --color-accent: %s; }',
		sanitize_hex_color( $primary ),
		sanitize_hex_color( $primary ),
		sanitize_hex_color( $secondary ),
		sanitize_hex_color( $accent )
	);

	wp_add_inline_style( 'promovads-style', $css );
}
add_action( 'wp_enqueue_scripts', 'promovads_customizer_css', 20 );

/**
 * Customizer live preview bindings.
 */
function promovads_customizer_live_preview(): void {
	wp_enqueue_script(
		'promovads-customizer',
		PROMOVADS_URI . '/js/customizer.js',
		array( 'customize-preview' ),
		PROMOVADS_VERSION,
		true
	);
}
add_action( 'customize_preview_init', 'promovads_customizer_live_preview' );
