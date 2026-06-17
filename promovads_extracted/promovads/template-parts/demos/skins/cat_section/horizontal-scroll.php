<?php
/**
 * Skin: Category section — تمرير أفقي.
 *
 * @package PromovaDS_News
 */

$cat    = $args['category'] ?? null;
$scroll_posts  = $args['posts'] ?? array();
$config = promovads_get_demo_config();

if ( ! $cat instanceof WP_Term || empty( $scroll_posts ) || ! $config ) {
	return;
}

$color = promovads_get_category_color( $cat->term_id, $config['primary'] ?? '#6366f1' );
$icon  = promovads_get_category_icon( $cat->term_id, 'fa-folder' );
?>
<section class="cat-section cat-section--<?php echo esc_attr( $cat->slug ); ?> pds-skin-cat pds-skin-cat--horizontal-scroll">
	<div class="cat-section__head">
		<div class="cat-section__info">
			<div class="cat-section__icon" style="background:<?php echo esc_attr( $color ); ?>"><i class="fas <?php echo esc_attr( $icon ); ?>"></i></div>
			<h2 class="cat-section__name"><?php echo esc_html( $cat->name ); ?></h2>
		</div>
		<a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" class="cat-section__btn"><i class="fas fa-arrow-left"></i> <?php esc_html_e( 'عرض المزيد', 'promovads' ); ?></a>
	</div>
	<div class="pds-cat-scroll">
		<?php foreach ( $scroll_posts as $scroll_post ) : ?>
			<div class="pds-cat-scroll__item">
				<?php get_template_part( 'template-parts/demos/_shared/card', null, array( 'post' => $scroll_post ) ); ?>
			</div>
		<?php endforeach; ?>
	</div>
</section>
