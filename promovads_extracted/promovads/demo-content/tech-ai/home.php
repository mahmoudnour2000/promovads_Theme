<?php
/**
 * Tech & AI Demo Homepage
 * Dark mode default, AI news blocks, trending tech slider
 *
 * @package PromovaDS_News
 */

// Force dark mode for this demo
if ( ! isset( $_COOKIE['pds-dark-mode'] ) ) {
	echo '<script>document.body.classList.add("dark-mode");</script>';
}
?>

<main id="primary" class="site-main pds-demo-tech" role="main">

	<!-- Hero: Featured tech posts grid -->
	<div class="pds-container">
		<?php
		get_template_part( 'template-parts/blocks/hero-grid', null, array(
			'category' => get_cat_ID( 'Technology' ) ?: 0,
			'count'    => 3,
		) );
		?>
	</div>

	<!-- Trending Slider (shows post cards in a horizontal scroll) -->
	<div class="pds-tech-trending" style="background:var(--color-bg-alt);padding:2rem 0;">
		<div class="pds-container">
			<div class="pds-section-header">
				<h2 class="pds-section-title">🔥 <span>Trending in Tech</span></h2>
				<a href="<?php echo esc_url( get_category_link( get_cat_ID( 'Technology' ) ) ); ?>" class="pds-see-all">See All <i class="fas fa-arrow-right"></i></a>
			</div>
			<div class="pds-scroll-row" style="display:flex;gap:1rem;overflow-x:auto;padding-bottom:1rem;scrollbar-width:thin;">
				<?php
				$tech = promovads_get_posts( array( 'posts_per_page' => 8, 'cat' => get_cat_ID( 'Technology' ) ?: 0 ) );
				while ( $tech->have_posts() ) :
					$tech->the_post();
					?>
					<div style="min-width:260px;flex-shrink:0;">
						<?php get_template_part( 'template-parts/blocks/card', 'standard' ); ?>
					</div>
				<?php
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</div>
	</div>

	<!-- AI News Section -->
	<div class="pds-container">
		<?php
		get_template_part( 'template-parts/blocks/post-grid', null, array(
			'title'    => 'Artificial Intelligence',
			'tag'      => 'ai',
			'columns'  => 3,
			'count'    => 6,
			'see_more' => home_url( '/tag/ai/' ),
		) );
		?>
	</div>

	<!-- Product Reviews Section -->
	<div style="background:var(--color-bg-alt);padding:2rem 0;">
		<div class="pds-container">
			<?php
			$reviews = new WP_Query( array( 'post_type' => 'pds_review', 'posts_per_page' => 4, 'post_status' => 'publish' ) );
			if ( $reviews->have_posts() ) :
				echo '<div class="pds-section-header"><h2 class="pds-section-title">Latest <span>Reviews</span></h2></div>';
				echo '<div class="pds-grid pds-grid--4">';
				while ( $reviews->have_posts() ) :
					$reviews->the_post();
					$score = get_post_meta( get_the_ID(), 'pds_review_score', true );
					?>
					<article class="pds-card">
						<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>" class="pds-card__thumb">
							<?php echo promovads_thumbnail( 0, 'promovads-card' ); ?>
							<?php if ( $score ) : ?>
							<span style="position:absolute;top:.75rem;right:.75rem;background:var(--color-accent);color:#000;font-weight:700;font-size:.75rem;padding:.2rem .5rem;border-radius:4px;">
								⭐ <?php echo esc_html( $score ); ?>/10
							</span>
							<?php endif; ?>
						</a>
						<?php endif; ?>
						<div class="pds-card__body">
							<h3 class="pds-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<?php if ( $score ) : ?>
								<?php echo promovads_review_stars( (float) $score ); ?>
							<?php endif; ?>
						</div>
					</article>
				<?php
				endwhile;
				echo '</div>';
				wp_reset_postdata();
			endif;
			?>
		</div>
	</div>

	<!-- Latest Posts + Sidebar -->
	<div class="pds-container pds-site-content">
		<div class="pds-grid pds-grid--main-sidebar">
			<div>
				<?php
				get_template_part( 'template-parts/blocks/post-grid', null, array(
					'title'   => 'All Tech News',
					'columns' => 3,
					'count'   => 9,
				) );
				?>
			</div>
			<aside class="pds-sidebar" role="complementary">
				<?php get_sidebar(); ?>
			</aside>
		</div>
	</div>

</main>
