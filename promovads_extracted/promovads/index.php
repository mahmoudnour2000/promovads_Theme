<?php
/**
 * Homepage / Blog Index
 *
 * Dispatches to demo-specific homepage if active demo is set,
 * otherwise renders the default homepage.
 *
 * @package PromovaDS_News
 */

get_header();

$demo = promovads_active_demo();

if ( $demo ) {
	$demo_template = PROMOVADS_DIR . '/demo-content/' . $demo . '/home.php';
	if ( file_exists( $demo_template ) ) {
		include $demo_template;
		get_footer();
		return;
	}
}
?>

<!-- Default Homepage: Hero + Categories + Recent -->
<main id="primary" class="site-main" role="main">

	<!-- Hero Section -->
	<?php get_template_part( 'template-parts/blocks/hero-grid', null, array( 'count' => 3 ) ); ?>

	<!-- Ad Leaderboard -->
	<div class="pds-container">
		<?php promovads_ad( 'inline' ); ?>
	</div>

	<!-- Main Content + Sidebar -->
	<div class="pds-site-content">
		<div class="pds-container">
			<div class="pds-grid pds-grid--main-sidebar">

				<!-- Posts Column -->
				<div class="pds-main-content">

					<!-- Category Tabs -->
					<div class="pds-tabs" id="pds-category-tabs">
						<div class="pds-tabs__nav" role="tablist" aria-label="<?php esc_attr_e( 'News Categories', 'promovads' ); ?>">
							<button class="pds-tabs__btn is-active" role="tab" data-tab="latest" aria-selected="true">
								<?php esc_html_e( 'Latest', 'promovads' ); ?>
							</button>
							<?php
							$cats = get_categories( array( 'number' => 6, 'orderby' => 'count', 'order' => 'DESC', 'hide_empty' => true ) );
							foreach ( $cats as $cat ) :
								?>
								<button class="pds-tabs__btn" role="tab" data-tab="cat-<?php echo absint( $cat->term_id ); ?>" data-cat="<?php echo absint( $cat->term_id ); ?>">
									<?php echo esc_html( $cat->name ); ?>
								</button>
							<?php endforeach; ?>
						</div>

						<div class="pds-tabs__panel is-active" id="tab-latest" role="tabpanel">
							<?php
							if ( have_posts() ) :
								echo '<div class="pds-grid pds-grid--3" id="pds-posts-grid">';
								while ( have_posts() ) :
									the_post();
									get_template_part( 'template-parts/blocks/card', 'standard' );
								endwhile;
								echo '</div>';

								// Load More
								$max_pages = $GLOBALS['wp_query']->max_num_pages;
								if ( $max_pages > 1 ) :
									?>
									<div class="pds-load-more-wrap" style="text-align:center;margin-top:2rem;">
										<button class="pds-btn pds-btn--outline pds-load-more"
										        data-page="1"
										        data-max="<?php echo absint( $max_pages ); ?>"
										        data-cat="0">
											<?php esc_html_e( 'Load More', 'promovads' ); ?>
											<i class="fas fa-spinner" aria-hidden="true"></i>
										</button>
									</div>
								<?php
								endif;
							else :
								get_template_part( 'template-parts/content', 'none' );
							endif;
							?>
						</div>

						<div class="pds-tabs__panel" id="tab-dynamic" role="tabpanel" aria-live="polite">
							<!-- Loaded via JS for category tabs -->
						</div>
					</div>

				</div><!-- .pds-main-content -->

				<!-- Sidebar -->
				<aside class="pds-sidebar" role="complementary" aria-label="<?php esc_attr_e( 'Sidebar', 'promovads' ); ?>">
					<?php get_sidebar(); ?>
				</aside>

			</div>
		</div>
	</div>

</main>

<?php get_footer(); ?>
