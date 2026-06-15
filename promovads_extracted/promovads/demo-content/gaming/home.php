<?php
/**
 * Gaming Demo Homepage
 *
 * @package PromovaDS_News
 */
?>
<main id="primary" class="site-main pds-demo-gaming" role="main">

	<!-- Hero with dark gradient -->
	<div class="pds-container">
		<?php get_template_part( 'template-parts/blocks/hero-grid', null, array( 'count' => 3 ) ); ?>
	</div>

	<!-- Game Reviews -->
	<div style="background:var(--color-secondary);padding:2.5rem 0;">
		<div class="pds-container">
			<div class="pds-section-header" style="border-color:rgba(255,255,255,.1);">
				<h2 class="pds-section-title" style="color:#fff;">Latest <span>Game Reviews</span></h2>
			</div>
			<div class="pds-grid pds-grid--4">
				<?php
				$reviews = new WP_Query( array( 'post_type' => 'pds_review', 'tax_query' => array( array( 'taxonomy' => 'review_cat', 'field' => 'slug', 'terms' => 'gaming' ) ), 'posts_per_page' => 4, 'post_status' => 'publish' ) );
				if ( $reviews->have_posts() ) :
					while ( $reviews->have_posts() ) :
						$reviews->the_post();
						$score = get_post_meta( get_the_ID(), 'pds_review_score', true );
						?>
						<article class="pds-card" style="background:rgba(255,255,255,.05);border-color:rgba(255,255,255,.1);">
							<a href="<?php the_permalink(); ?>" class="pds-card__thumb">
								<?php echo promovads_thumbnail( 0, 'promovads-card' ); ?>
								<?php if ( $score ) : ?>
								<span style="position:absolute;bottom:.75rem;right:.75rem;background:var(--color-primary);color:#fff;font-size:1rem;font-weight:700;width:40px;height:40px;border-radius:50%;display:flex;align-items:center;justify-content:center;">
									<?php echo esc_html( number_format( (float) $score, 1 ) ); ?>
								</span>
								<?php endif; ?>
							</a>
							<div class="pds-card__body">
								<h3 class="pds-card__title" style="color:#fff;-webkit-line-clamp:2;">
									<a href="<?php the_permalink(); ?>" style="color:#fff;"><?php the_title(); ?></a>
								</h3>
								<?php if ( $score ) : echo promovads_review_stars( (float) $score ); endif; ?>
							</div>
						</article>
					<?php endwhile; wp_reset_postdata();
				else :
					get_template_part( 'template-parts/blocks/post-grid', null, array( 'count' => 4, 'columns' => 4 ) );
				endif;
				?>
			</div>
		</div>
	</div>

	<!-- Esports + Release Calendar -->
	<div class="pds-container pds-site-content">
		<div class="pds-grid pds-grid--2" style="margin-bottom:2rem;">
			<div>
				<?php get_template_part( 'template-parts/blocks/post-grid', null, array( 'title' => 'Esports', 'tag' => 'esports', 'columns' => 1, 'count' => 5, 'layout' => 'list' ) ); ?>
			</div>
			<div>
				<?php get_template_part( 'template-parts/blocks/post-grid', null, array( 'title' => 'New Releases', 'tag' => 'releases', 'columns' => 1, 'count' => 5, 'layout' => 'list' ) ); ?>
			</div>
		</div>
		<div class="pds-grid pds-grid--main-sidebar">
			<div>
				<?php get_template_part( 'template-parts/blocks/post-grid', null, array( 'title' => 'Gaming News', 'columns' => 3, 'count' => 6 ) ); ?>
			</div>
			<aside class="pds-sidebar" role="complementary"><?php get_sidebar(); ?></aside>
		</div>
	</div>
</main>
