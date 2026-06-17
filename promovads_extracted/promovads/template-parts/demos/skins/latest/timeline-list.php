<?php
/**
 * Skin: Latest news — قائمة زمنية.
 *
 * @var WP_Query $query
 *
 * @package PromovaDS_News
 */

$query   = $args['query'] ?? null;
$archive = $args['archive_url'] ?? promovads_posts_archive_url();

if ( ! $query instanceof WP_Query || ! $query->have_posts() ) {
	return;
}
?>
<section class="latest-block pds-skin-latest pds-skin-latest--timeline-list">
	<div class="latest-block__head">
		<h2 class="latest-block__title"><?php esc_html_e( 'آخر', 'promovads' ); ?> <span><?php esc_html_e( 'الأخبار', 'promovads' ); ?></span></h2>
		<a href="<?php echo esc_url( $archive ); ?>" class="cat-section__btn"><i class="fas fa-newspaper"></i> <?php esc_html_e( 'عرض كل المقالات', 'promovads' ); ?></a>
	</div>
	<div class="latest-list">
		<?php
		while ( $query->have_posts() ) :
			$query->the_post();
			$lcat   = promovads_get_primary_category();
			$lcolor = $lcat ? promovads_get_category_color( $lcat->term_id ) : '#6366f1';
			?>
			<article class="latest-item">
				<a href="<?php the_permalink(); ?>" class="latest-item__img"><?php echo promovads_thumbnail( 0, 'promovads-thumb' ); ?></a>
				<div>
					<?php if ( $lcat ) : ?>
						<div class="latest-item__cat" style="color:<?php echo esc_attr( $lcolor ); ?>"><?php echo esc_html( $lcat->name ); ?></div>
					<?php endif; ?>
					<h3 class="latest-item__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<div class="latest-item__meta">
						<span><i class="far fa-clock"></i> <?php echo esc_html( promovads_time_ago_ar() ); ?></span>
						<span><i class="far fa-eye"></i> <?php echo esc_html( promovads_views_label() ); ?></span>
					</div>
				</div>
				<div class="latest-item__time"><?php echo esc_html( promovads_time_ago_ar() ); ?></div>
			</article>
		<?php endwhile;
		wp_reset_postdata();
		?>
	</div>
</section>
