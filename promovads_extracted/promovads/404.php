<?php
/**
 * 404 Template
 *
 * @package PromovaDS_News
 */

get_header();
?>

<main id="primary" class="site-main" role="main">
<div class="pds-container">

	<div class="pds-404">
		<div class="pds-404__code">4<span>0</span>4</div>
		<h2><?php esc_html_e( 'Page Not Found', 'promovads' ); ?></h2>
		<p><?php esc_html_e( "Oops! The page you're looking for doesn't exist. It might have been moved, deleted, or you may have mistyped the URL.", 'promovads' ); ?></p>

		<div class="pds-404__actions" style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="pds-btn pds-btn--primary">
				<i class="fas fa-home" aria-hidden="true"></i>
				<?php esc_html_e( 'Go Home', 'promovads' ); ?>
			</a>
			<button class="pds-btn pds-btn--outline pds-search-trigger">
				<i class="fas fa-search" aria-hidden="true"></i>
				<?php esc_html_e( 'Search', 'promovads' ); ?>
			</button>
		</div>

		<!-- Popular Posts on 404 -->
		<div style="margin-top:4rem;max-width:900px;margin-inline:auto;">
			<h3 style="margin-bottom:1.5rem;"><?php esc_html_e( 'Popular Articles', 'promovads' ); ?></h3>
			<div class="pds-grid pds-grid--3">
				<?php
				$popular = promovads_get_trending( 3 );
				while ( $popular->have_posts() ) {
					$popular->the_post();
					get_template_part( 'template-parts/blocks/card', 'standard' );
				}
				wp_reset_postdata();
				?>
			</div>
		</div>
	</div>

</div>
</main>

<?php get_footer(); ?>
