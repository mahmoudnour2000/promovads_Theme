<?php
/**
 * Theme Setup
 *
 * @package PromovaDS_News
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'promovads_setup' ) ) :
	function promovads_setup() {

		load_theme_textdomain( 'promovads', PROMOVADS_DIR . '/languages' );

		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'editor-styles' );

		add_theme_support(
			'html5',
			array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
		);

		add_theme_support(
			'custom-logo',
			array(
				'height'      => 60,
				'width'       => 200,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		add_theme_support(
			'custom-background',
			apply_filters(
				'promovads_custom_background_args',
				array( 'default-color' => 'ffffff', 'default-image' => '' )
			)
		);

		// ── Image Sizes ────────────────────────────────────────────────────────
		add_image_size( 'promovads-hero',     1200, 630, true );
		add_image_size( 'promovads-featured', 800,  450, true );
		add_image_size( 'promovads-card',     600,  338, true );
		add_image_size( 'promovads-thumb',    400,  225, true );
		add_image_size( 'promovads-square',   300,  300, true );
		add_image_size( 'promovads-wide',     1600, 600, true );
		add_image_size( 'promovads-small',    150,  100, true );

		// ── Navigation Menus ───────────────────────────────────────────────────
		register_nav_menus(
			array(
				'primary'   => esc_html__( 'Primary Navigation', 'promovads' ),
				'secondary' => esc_html__( 'Secondary Navigation', 'promovads' ),
				'footer-1'  => esc_html__( 'Footer Column 1', 'promovads' ),
				'footer-2'  => esc_html__( 'Footer Column 2', 'promovads' ),
				'footer-3'  => esc_html__( 'Footer Column 3', 'promovads' ),
				'mobile'    => esc_html__( 'Mobile Menu', 'promovads' ),
				'social'    => esc_html__( 'Social Links', 'promovads' ),
			)
		);

		add_theme_support( 'customize-selective-refresh-widgets' );

		// Gutenberg color palette
		add_theme_support(
			'editor-color-palette',
			array(
				array( 'name' => esc_html__( 'Primary Red', 'promovads' ),    'slug' => 'primary',   'color' => '#e63329' ),
				array( 'name' => esc_html__( 'Dark Navy', 'promovads' ),      'slug' => 'secondary', 'color' => '#1a1a2e' ),
				array( 'name' => esc_html__( 'Accent Gold', 'promovads' ),    'slug' => 'accent',    'color' => '#f5a623' ),
				array( 'name' => esc_html__( 'Light Gray', 'promovads' ),     'slug' => 'light',     'color' => '#f7f7f7' ),
				array( 'name' => esc_html__( 'Dark Background', 'promovads' ), 'slug' => 'dark',     'color' => '#0f0f0f' ),
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'promovads_setup' );

/**
 * Set content width.
 */
function promovads_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'promovads_content_width', 800 );
}
add_action( 'after_setup_theme', 'promovads_content_width', 0 );

/**
 * Register widget areas.
 */
function promovads_widgets_init() {
	$sidebars = array(
		array(
			'name' => esc_html__( 'Main Sidebar', 'promovads' ),
			'id'   => 'sidebar-main',
			'desc' => esc_html__( 'Appears on posts and pages.', 'promovads' ),
		),
		array(
			'name' => esc_html__( 'Footer Column 1', 'promovads' ),
			'id'   => 'footer-1',
			'desc' => esc_html__( 'Footer first column.', 'promovads' ),
		),
		array(
			'name' => esc_html__( 'Footer Column 2', 'promovads' ),
			'id'   => 'footer-2',
			'desc' => esc_html__( 'Footer second column.', 'promovads' ),
		),
		array(
			'name' => esc_html__( 'Footer Column 3', 'promovads' ),
			'id'   => 'footer-3',
			'desc' => esc_html__( 'Footer third column.', 'promovads' ),
		),
		array(
			'name' => esc_html__( 'Archive Sidebar', 'promovads' ),
			'id'   => 'sidebar-archive',
			'desc' => esc_html__( 'Appears on archive and category pages.', 'promovads' ),
		),
		array(
			'name' => esc_html__( 'Shop Sidebar', 'promovads' ),
			'id'   => 'sidebar-shop',
			'desc' => esc_html__( 'Appears on WooCommerce pages.', 'promovads' ),
		),
	);

	foreach ( $sidebars as $sidebar ) {
		register_sidebar(
			array(
				'name'          => $sidebar['name'],
				'id'            => $sidebar['id'],
				'description'   => $sidebar['desc'],
				'before_widget' => '<div id="%1$s" class="pds-widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="pds-widget__title">',
				'after_title'   => '</h3><div class="pds-widget__body">',
			)
		);
	}
}
add_action( 'widgets_init', 'promovads_widgets_init' );
