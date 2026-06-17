<?php
/**
 * Single post prev/next navigation.
 *
 * @package PromovaDS_News
 */

$is_demo = (bool) promovads_get_demo_config();
$prev    = promovads_get_adjacent_post_data( 'prev' );
$next    = promovads_get_adjacent_post_data( 'next' );

if ( ! $prev && ! $next ) {
	return;
}

$label_class = $is_demo ? 'post-nav__label' : 'pds-post-nav__label';
$title_class = $is_demo ? 'post-nav__title' : 'pds-post-nav__title';
?>
<div class="nav-links">
	<?php if ( $prev ) : ?>
	<div class="nav-previous">
		<a href="<?php echo esc_url( $prev['url'] ); ?>" rel="prev">
			<span class="<?php echo esc_attr( $label_class ); ?>"><i class="fas fa-arrow-right" aria-hidden="true"></i> <?php esc_html_e( 'السابق', 'promovads' ); ?></span>
			<span class="<?php echo esc_attr( $title_class ); ?>"><?php echo esc_html( $prev['title'] ); ?></span>
		</a>
	</div>
	<?php endif; ?>

	<?php if ( $next ) : ?>
	<div class="nav-next">
		<a href="<?php echo esc_url( $next['url'] ); ?>" rel="next">
			<span class="<?php echo esc_attr( $label_class ); ?>"><?php esc_html_e( 'التالي', 'promovads' ); ?> <i class="fas fa-arrow-left" aria-hidden="true"></i></span>
			<span class="<?php echo esc_attr( $title_class ); ?>"><?php echo esc_html( $next['title'] ); ?></span>
		</a>
	</div>
	<?php endif; ?>
</div>
