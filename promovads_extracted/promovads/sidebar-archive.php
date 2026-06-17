<?php
/**
 * Archive sidebar — demo-aware.
 *
 * @package PromovaDS_News
 */

if ( promovads_get_demo_config() ) {
	get_template_part( 'template-parts/demos/_shared/sidebar' );
	return;
}

if ( is_active_sidebar( 'sidebar-archive' ) ) {
	dynamic_sidebar( 'sidebar-archive' );
	return;
}

get_sidebar();
