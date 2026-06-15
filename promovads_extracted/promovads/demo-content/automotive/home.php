<?php
/**
 * Automotive Demo Homepage
 *
 * @package PromovaDS_News
 */
?>
<main id="primary" class="site-main pds-demo-automotive" role="main">
	<div class="pds-container">
		<?php get_template_part( 'template-parts/blocks/hero-grid', null, array( 'count' => 3 ) ); ?>
	</div>
	<div style="background:var(--color-bg-alt);padding:2.5rem 0;">
		<div class="pds-container">
			<div class="pds-grid pds-grid--3">
				<div><?php get_template_part( 'template-parts/blocks/post-grid', null, array( 'title' => 'Car Reviews', 'columns' => 1, 'count' => 4, 'layout' => 'list' ) ); ?></div>
				<div><?php get_template_part( 'template-parts/blocks/post-grid', null, array( 'title' => 'Electric Cars', 'tag' => 'electric', 'columns' => 1, 'count' => 4, 'layout' => 'list' ) ); ?></div>
				<div><?php get_template_part( 'template-parts/blocks/post-grid', null, array( 'title' => 'Auto News', 'columns' => 1, 'count' => 4, 'layout' => 'list' ) ); ?></div>
			</div>
		</div>
	</div>
	<div class="pds-container pds-site-content">
		<div class="pds-grid pds-grid--main-sidebar">
			<div>
				<?php
				$reviews = new WP_Query( array( 'post_type' => 'pds_review', 'posts_per_page' => 6, 'post_status' => 'publish' ) );
				if ( $reviews->have_posts() ) :
					echo '<div class="pds-section-header"><h2 class="pds-section-title">Latest <span>Reviews</span></h2></div>';
					echo '<div class="pds-grid pds-grid--3">';
					while ( $reviews->have_posts() ) :
						$reviews->the_post();
						$score = get_post_meta( get_the_ID(), 'pds_review_score', true );
						?>
						<article class="pds-card">
							<a href="<?php the_permalink(); ?>" class="pds-card__thumb"><?php echo promovads_thumbnail( 0, 'promovads-card' ); ?></a>
							<div class="pds-card__body">
								<h3 class="pds-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<?php if ( $score ) : echo promovads_review_stars( (float) $score ); endif; ?>
							</div>
						</article>
					<?php endwhile; wp_reset_postdata();
					echo '</div>';
				else :
					get_template_part( 'template-parts/blocks/post-grid', null, array( 'title' => 'Auto News', 'columns' => 3, 'count' => 6 ) );
				endif;
				?>
			</div>
			<aside class="pds-sidebar" role="complementary"><?php get_sidebar(); ?></aside>
		</div>
	</div>
</main>
