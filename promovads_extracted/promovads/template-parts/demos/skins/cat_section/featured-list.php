<?php
/**
 * Skin: Category section — بطل + قائمة.
 *
 * @package PromovaDS_News
 */

$cat    = $args['category'] ?? null;
$featured_list_posts  = $args['posts'] ?? array();
$config = promovads_get_demo_config();

if ( ! $cat instanceof WP_Term || empty( $featured_list_posts ) || ! $config ) {
	return;
}

$main   = $featured_list_posts[0];
$rest   = array_slice( $featured_list_posts, 1 );
$color  = promovads_get_category_color( $cat->term_id, $config['primary'] ?? '#6366f1' );
$icon   = promovads_get_category_icon( $cat->term_id, 'fa-folder' );
?>
<section class="cat-section cat-section--<?php echo esc_attr( $cat->slug ); ?> pds-skin-cat pds-skin-cat--featured-list">
	<div class="cat-section__head">
		<div class="cat-section__info">
			<div class="cat-section__icon" style="background:<?php echo esc_attr( $color ); ?>"><i class="fas <?php echo esc_attr( $icon ); ?>"></i></div>
			<h2 class="cat-section__name"><?php echo esc_html( $cat->name ); ?></h2>
		</div>
		<a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" class="cat-section__btn"><?php esc_html_e( 'عرض المزيد', 'promovads' ); ?></a>
	</div>
	<div class="pds-cat-featured grid g-main" style="gap:20px">
		<a href="<?php echo esc_url( get_permalink( $main ) ); ?>" class="pds-cat-featured__lead card">
			<div class="card__thumb"><?php echo promovads_thumbnail( $main->ID, 'promovads-featured' ); ?></div>
			<div class="card__body">
				<h3 class="card__title"><?php echo esc_html( get_the_title( $main ) ); ?></h3>
				<p class="card__excerpt"><?php echo esc_html( promovads_truncate( get_the_excerpt( $main ), 100 ) ); ?></p>
			</div>
		</a>
		<div class="pds-cat-featured__list">
			<?php foreach ( $rest as $list_post ) : ?>
				<a href="<?php echo esc_url( get_permalink( $list_post ) ); ?>" class="pds-cat-featured__row">
					<?php echo promovads_thumbnail( $list_post->ID, 'promovads-thumb' ); ?>
					<span><?php echo esc_html( get_the_title( $list_post ) ); ?></span>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
