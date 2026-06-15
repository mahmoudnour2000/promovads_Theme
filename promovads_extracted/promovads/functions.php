<?php
/**
 * PromovaDS News - Theme Functions
 *
 * @package PromovaDS_News
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

define( 'PROMOVADS_VERSION', '1.0.0' );
define( 'PROMOVADS_DIR',     get_template_directory() );
define( 'PROMOVADS_URI',     get_template_directory_uri() );
define( 'PROMOVADS_INC',     PROMOVADS_DIR . '/inc' );

// ── Core Includes ─────────────────────────────────────────────────────────────
require PROMOVADS_INC . '/setup.php';
require PROMOVADS_INC . '/enqueue.php';
require PROMOVADS_INC . '/custom-post-types.php';
require PROMOVADS_INC . '/widgets.php';
require PROMOVADS_INC . '/helpers.php';
require PROMOVADS_INC . '/seo.php';
require PROMOVADS_INC . '/ads.php';
require PROMOVADS_INC . '/customizer.php';
require PROMOVADS_INC . '/demo-import.php';
require PROMOVADS_INC . '/template-tags.php';
require PROMOVADS_INC . '/template-functions.php';
require PROMOVADS_INC . '/ajax.php';

// ── Jetpack ───────────────────────────────────────────────────────────────────
if ( defined( 'JETPACK__VERSION' ) ) {
	require PROMOVADS_INC . '/jetpack.php';
}

// ── Elementor Compatibility ───────────────────────────────────────────────────
if ( did_action( 'elementor/loaded' ) ) {
	require PROMOVADS_INC . '/elementor.php';
}
