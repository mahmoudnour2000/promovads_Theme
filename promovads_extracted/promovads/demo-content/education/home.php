<?php
/**
 * Education Demo Homepage
 *
 * @package PromovaDS_News
 */
?>
<main id="primary" class="site-main pds-demo-education" role="main">
	<div class="pds-container">
		<?php get_template_part( 'template-parts/blocks/hero-grid', null, array( 'count' => 3 ) ); ?>
	</div>

	<!-- Courses Listing -->
	<div style="background:var(--color-bg-alt);padding:2.5rem 0;">
		<div class="pds-container">
			<div class="pds-section-header">
				<h2 class="pds-section-title">Featured <span>Courses</span></h2>
			</div>
			<div class="pds-grid pds-grid--4">
				<?php
				$courses = new WP_Query( array( 'post_type' => 'pds_course', 'posts_per_page' => 4, 'post_status' => 'publish' ) );
				if ( $courses->have_posts() ) :
					while ( $courses->have_posts() ) :
						$courses->the_post();
						?>
						<article class="pds-card">
							<a href="<?php the_permalink(); ?>" class="pds-card__thumb">
								<?php echo promovads_thumbnail( 0, 'promovads-card' ); ?>
							</a>
							<div class="pds-card__body">
								<h3 class="pds-card__title" style="-webkit-line-clamp:2;"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<p class="pds-card__excerpt"><?php echo esc_html( promovads_truncate( get_the_excerpt(), 80 ) ); ?></p>
							</div>
						</article>
					<?php endwhile; wp_reset_postdata();
				else :
					get_template_part( 'template-parts/blocks/post-grid', null, array( 'columns' => 4, 'count' => 4 ) );
				endif;
				?>
			</div>
		</div>
	</div>

	<div class="pds-container pds-site-content">
		<div class="pds-grid pds-grid--3" style="margin-bottom:2rem;">
			<div><?php get_template_part( 'template-parts/blocks/post-grid', null, array( 'title' => 'Scholarships', 'tag' => 'scholarships', 'columns' => 1, 'count' => 4, 'layout' => 'list' ) ); ?></div>
			<div><?php get_template_part( 'template-parts/blocks/post-grid', null, array( 'title' => 'Exams', 'tag' => 'exams', 'columns' => 1, 'count' => 4, 'layout' => 'list' ) ); ?></div>
			<div><?php get_template_part( 'template-parts/blocks/post-grid', null, array( 'title' => 'Universities', 'tag' => 'universities', 'columns' => 1, 'count' => 4, 'layout' => 'list' ) ); ?></div>
		</div>
		<div class="pds-grid pds-grid--main-sidebar">
			<div><?php get_template_part( 'template-parts/blocks/post-grid', null, array( 'title' => 'Education News', 'columns' => 3, 'count' => 6 ) ); ?></div>
			<aside class="pds-sidebar" role="complementary"><?php get_sidebar(); ?></aside>
		</div>
	</div>
</main>
