<?php
/**
 * Search Results Template
 *
 * @package PromovaDS_News
 */

get_header();

$config  = promovads_get_demo_config();
$is_demo = (bool) $config;
?>

<main id="primary" class="site-main<?php echo $is_demo ? ' pds-demo-archive' : ''; ?>" role="main">

	<?php if ( $is_demo ) : ?>
		<?php promovads_render_skin( 'archive_header' ); ?>
	<?php else : ?>
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
	<?php endif; ?>

	<div class="<?php echo $is_demo ? 'wrap' : 'pds-container pds-site-content'; ?>" style="<?php echo $is_demo ? 'padding:36px 0 60px' : ''; ?>">
		<div class="<?php echo $is_demo ? 'grid g-main' : 'pds-grid pds-grid--main-sidebar'; ?>" style="<?php echo $is_demo ? 'gap:32px' : ''; ?>">
			
			<div class="<?php echo $is_demo ? '' : 'pds-main-content'; ?>">

				<!-- Search Form -->
				<div class="pds-search-form-box" style="margin-bottom:2.5rem;">
					<?php get_search_form(); ?>
				</div>

				<?php if ( have_posts() ) : ?>
					<div class="<?php echo $is_demo ? 'grid g3' : 'pds-grid pds-grid--3'; ?>">
						<?php
						while ( have_posts() ) :
							the_post();
							if ( $is_demo ) {
								get_template_part( 'template-parts/demos/_shared/card' );
							} else {
								get_template_part( 'template-parts/blocks/card', 'standard' );
							}
						endwhile;
						?>
					</div>

					<nav class="<?php echo $is_demo ? 'pagination' : 'pds-pagination'; ?>" aria-label="<?php esc_attr_e( 'Pagination', 'promovads' ); ?>" style="margin-top:2rem">
						<?php
						the_posts_pagination(
							array(
								'mid_size'  => 2,
								'prev_text' => '<i class="fas fa-chevron-right" aria-hidden="true"></i>',
								'next_text' => '<i class="fas fa-chevron-left" aria-hidden="true"></i>',
							)
						);
						?>
					</nav>

				<?php else : ?>
					<div class="pds-no-results" style="padding:48px 24px;text-align:center;background:var(--tech-surface,var(--color-bg-alt));border:1px solid var(--tech-border,var(--color-border));border-radius:12px">
						<p style="margin-bottom:0;color:var(--text-muted,#999);font-size:1.1rem"><?php esc_html_e( 'لم يتم العثور على نتائج. جرب كلمات مفتاحية أخرى.', 'promovads' ); ?></p>
					</div>
				<?php endif; ?>
			</div>

			<aside class="<?php echo $is_demo ? 'sidebar' : 'pds-sidebar'; ?>" role="complementary">
				<?php
				if ( $is_demo ) {
					get_template_part( 'template-parts/demos/_shared/sidebar' );
				} else {
					get_sidebar();
				}
				?>
			</aside>

		</div>
	</div>

</main>

<?php get_footer(); ?>
