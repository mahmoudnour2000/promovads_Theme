<?php
/**
 * Search Results Template
 *
 * @package PromovaDS_News
 */

get_header();
?>

<main id="primary" class="site-main" role="main">

	<div class="pds-archive-header">
		<div class="pds-container">
			<span class="pds-archive-header__cat"><?php esc_html_e( 'Search Results', 'promovads' ); ?></span>
			<h1>
				<?php
				printf(
					/* translators: %s: search query */
					esc_html__( 'Results for: %s', 'promovads' ),
					'<span>' . esc_html( get_search_query() ) . '</span>'
				);
				?>
			</h1>
			<?php if ( have_posts() ) : ?>
				<span class="pds-archive-header__count">
					<?php
					global $wp_query;
					printf(
						/* translators: %d: post count */
						esc_html( _n( '%d result found', '%d results found', $wp_query->found_posts, 'promovads' ) ),
						absint( $wp_query->found_posts )
					);
					?>
				</span>
			<?php endif; ?>
		</div>
	</div>

	<div class="pds-container pds-site-content">
		<div class="pds-grid pds-grid--main-sidebar">

			<div class="pds-main-content">

				<!-- Search Form -->
				<div class="pds-search-form-box" style="margin-bottom:2rem;">
					<?php get_search_form(); ?>
				</div>

				<?php if ( have_posts() ) : ?>
					<div class="pds-grid pds-grid--3">
						<?php
						while ( have_posts() ) :
							the_post();
							get_template_part( 'template-parts/blocks/card', 'standard' );
						endwhile;
						?>
					</div>

					<nav class="pds-pagination" aria-label="<?php esc_attr_e( 'Pagination', 'promovads' ); ?>">
						<?php
						the_posts_pagination(
							array(
								'mid_size'  => 2,
								'prev_text' => '<i class="fas fa-chevron-left" aria-hidden="true"></i>',
								'next_text' => '<i class="fas fa-chevron-right" aria-hidden="true"></i>',
							)
						);
						?>
					</nav>

				<?php else : ?>
					<div class="pds-no-results">
						<p><?php esc_html_e( 'No results found. Try different keywords.', 'promovads' ); ?></p>
					</div>
				<?php endif; ?>
			</div>

			<aside class="pds-sidebar" role="complementary">
				<?php get_sidebar(); ?>
			</aside>

		</div>
	</div>

</main>

<?php get_footer(); ?>
