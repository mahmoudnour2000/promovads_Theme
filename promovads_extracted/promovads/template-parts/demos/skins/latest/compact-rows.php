<?php
/**
 * Skin: Latest news — صفوف مدمجة.
 *
 * @package PromovaDS_News
 */

$query   = $args['query'] ?? null;
$archive = $args['archive_url'] ?? promovads_posts_archive_url();

if ( ! $query instanceof WP_Query || ! $query->have_posts() ) {
	return;
}
?>
<section class="latest-block pds-skin-latest pds-skin-latest--compact-rows">
	<div class="latest-block__head">
		<h2 class="latest-block__title"><?php esc_html_e( 'آخر', 'promovads' ); ?> <span><?php esc_html_e( 'الأخبار', 'promovads' ); ?></span></h2>
		<a href="<?php echo esc_url( $archive ); ?>" class="cat-section__btn"><?php esc_html_e( 'عرض الكل', 'promovads' ); ?></a>
	</div>
	<ul class="pds-latest-compact">
		<?php
		while ( $query->have_posts() ) :
			$query->the_post();
			?>
			<li>
				<a href="<?php the_permalink(); ?>">
					<span class="pds-latest-compact__title"><?php the_title(); ?></span>
					<span class="pds-latest-compact__time"><?php echo esc_html( promovads_time_ago_ar() ); ?></span>
				</a>
			</li>
		<?php endwhile;
		wp_reset_postdata();
		?>
	</ul>
</section>
