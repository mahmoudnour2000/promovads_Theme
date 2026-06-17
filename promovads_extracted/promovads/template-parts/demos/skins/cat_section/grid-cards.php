<?php
/**
 * Skin: Category section — 3 بطاقات (default).
 *
 * @var WP_Term $category
 * @var WP_Post[] $posts
 *
 * @package PromovaDS_News
 */

$cat    = $args['category'] ?? null;
$grid_cards_posts  = $args['posts'] ?? array();
$config = promovads_get_demo_config();

if ( ! $cat instanceof WP_Term || empty( $grid_cards_posts ) || ! $config ) {
	return;
}

$color = promovads_get_category_color( $cat->term_id, $config['primary'] ?? '#6366f1' );
$icon  = promovads_get_category_icon( $cat->term_id, 'fa-folder' );
$desc  = term_description( $cat->term_id, 'category' );
?>
<section class="cat-section cat-section--<?php echo esc_attr( $cat->slug ); ?> pds-skin-cat pds-skin-cat--grid-cards">
	<div class="cat-section__head">
		<div class="cat-section__info">
			<div class="cat-section__icon" style="background:<?php echo esc_attr( $color ); ?>"><i class="fas <?php echo esc_attr( $icon ); ?>"></i></div>
			<div>
				<h2 class="cat-section__name"><?php echo esc_html( $cat->name ); ?></h2>
				<?php if ( $desc ) : ?>
					<p class="cat-section__desc"><?php echo wp_kses_post( wp_strip_all_tags( $desc ) ); ?></p>
				<?php endif; ?>
			</div>
		</div>
		<a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" class="cat-section__btn"><i class="fas fa-arrow-left"></i> <?php esc_html_e( 'عرض المزيد', 'promovads' ); ?></a>
	</div>
	<div class="grid g3">
		<?php foreach ( $grid_cards_posts as $grid_post ) :
			get_template_part( 'template-parts/demos/_shared/card', null, array( 'post' => $grid_post ) );
		endforeach; ?>
	</div>
</section>
