<?php
/**
 * Homepage — demo layout from WordPress data.
 *
 * @package PromovaDS_News
 */

get_header();

$demo = promovads_active_demo();

if ( $demo && promovads_get_demo_config( $demo ) ) {
	get_template_part( 'template-parts/demos/_shared/home-layout' );
	get_footer();
	return;
}

if ( $demo ) {
	$demo_template = PROMOVADS_DIR . '/demo-content/' . $demo . '/home.php';
	if ( file_exists( $demo_template ) ) {
		include $demo_template;
		get_footer();
		return;
	}
}
?>

<main id="primary" class="site-main" role="main">
	<?php get_template_part( 'template-parts/blocks/hero-grid', null, array( 'count' => 3 ) ); ?>
	<div class="pds-container">
		<?php promovads_ad( 'inline' ); ?>
	</div>
	<div class="pds-site-content">
		<div class="pds-container">
			<div class="pds-grid pds-grid--main-sidebar">
				<div class="pds-main-content">
					<?php
					if ( have_posts() ) :
						echo '<div class="pds-grid pds-grid--3" id="pds-posts-grid">';
						while ( have_posts() ) :
							the_post();
							get_template_part( 'template-parts/blocks/card', 'standard' );
						endwhile;
						echo '</div>';
					else :
						get_template_part( 'template-parts/content', 'none' );
					endif;
					?>
				</div>
				<aside class="pds-sidebar" role="complementary">
					<?php get_sidebar(); ?>
				</aside>
			</div>
		</div>
	</div>
</main>

<?php get_footer(); ?>
