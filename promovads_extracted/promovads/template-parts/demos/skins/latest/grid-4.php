<?php
/**
 * Skin: Latest news — شبكة 4.
 *
 * @package PromovaDS_News
 */

$query   = $args['query'] ?? null;
$archive = $args['archive_url'] ?? promovads_posts_archive_url();

if ( ! $query instanceof WP_Query || ! $query->have_posts() ) {
	return;
}
?>
<section class="latest-block pds-skin-latest pds-skin-latest--grid-4">
	<div class="latest-block__head">
		<h2 class="latest-block__title"><?php esc_html_e( 'آخر', 'promovads' ); ?> <span><?php esc_html_e( 'الأخبار', 'promovads' ); ?></span></h2>
		<a href="<?php echo esc_url( $archive ); ?>" class="cat-section__btn"><?php esc_html_e( 'عرض الكل', 'promovads' ); ?></a>
	</div>
	<div class="grid g3 pds-latest-grid-4">
		<?php
		while ( $query->have_posts() ) :
			$query->the_post();
			get_template_part( 'template-parts/demos/_shared/card' );
		endwhile;
		wp_reset_postdata();
		?>
	</div>
</section>
