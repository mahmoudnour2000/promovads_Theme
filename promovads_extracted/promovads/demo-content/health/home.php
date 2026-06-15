<?php
/**
 * Health Demo Homepage
 *
 * @package PromovaDS_News
 */
?>
<main id="primary" class="site-main pds-demo-health" role="main">
	<div class="pds-container">
		<?php get_template_part( 'template-parts/blocks/hero-grid', null, array( 'count' => 3 ) ); ?>
	</div>
	<div style="background:var(--color-bg-alt);padding:2.5rem 0;">
		<div class="pds-container">
			<div class="pds-grid pds-grid--3">
				<div><?php get_template_part( 'template-parts/blocks/post-grid', null, array( 'title' => 'Medical News', 'columns' => 1, 'count' => 4, 'layout' => 'list' ) ); ?></div>
				<div><?php get_template_part( 'template-parts/blocks/post-grid', null, array( 'title' => 'Nutrition', 'tag' => 'nutrition', 'columns' => 1, 'count' => 4, 'layout' => 'list' ) ); ?></div>
				<div><?php get_template_part( 'template-parts/blocks/post-grid', null, array( 'title' => 'Mental Health', 'tag' => 'mental-health', 'columns' => 1, 'count' => 4, 'layout' => 'list' ) ); ?></div>
			</div>
		</div>
	</div>
	<div class="pds-container pds-site-content">
		<div class="pds-grid pds-grid--main-sidebar">
			<div><?php get_template_part( 'template-parts/blocks/post-grid', null, array( 'title' => 'Health Tips', 'columns' => 3, 'count' => 6 ) ); ?></div>
			<aside class="pds-sidebar" role="complementary"><?php get_sidebar(); ?></aside>
		</div>
	</div>
</main>
