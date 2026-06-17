<?php
/**
 * Skin: Hero — كبير + جانبي (default).
 *
 * @package PromovaDS_News
 */

$config = promovads_get_demo_config();
if ( $config && 'tech-ai' === promovads_active_demo() && file_exists( PROMOVADS_DIR . '/template-parts/demos/tech-ai/hero.php' ) ) {
	get_template_part( 'template-parts/demos/tech-ai/hero' );
	return;
}

get_template_part( 'template-parts/demos/_shared/hero-grid' );
