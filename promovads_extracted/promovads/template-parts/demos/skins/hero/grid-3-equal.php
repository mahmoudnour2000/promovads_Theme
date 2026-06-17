<?php
/**
 * Skin: Hero — 3 أعمدة متساوية.
 *
 * @package PromovaDS_News
 */

$featured = promovads_get_featured_posts( 3 );
if ( empty( $featured ) ) {
	return;
}

$config = promovads_get_demo_config();
$prefix = $config['prefix'] ?? 'pds';
?>
<div class="<?php echo esc_attr( $prefix ); ?>-hero__shell pds-skin-hero pds-skin-hero--grid-3">
	<div class="pds-hero-equal grid g3">
		<?php foreach ( $featured as $feat_post ) :
			$cat   = promovads_get_primary_category( $feat_post->ID );
			$color = $cat ? promovads_get_category_color( $cat->term_id ) : ( $config['primary'] ?? '#6366f1' );
			?>
			<a href="<?php echo esc_url( get_permalink( $feat_post ) ); ?>" class="pds-hero-equal__card card">
				<div class="card__thumb">
					<?php echo promovads_thumbnail( $feat_post->ID, 'promovads-card' ); ?>
					<?php if ( $cat ) : ?>
						<span class="card__cat" style="background:<?php echo esc_attr( $color ); ?>"><?php echo esc_html( $cat->name ); ?></span>
					<?php endif; ?>
				</div>
				<div class="card__body">
					<h3 class="card__title"><?php echo esc_html( get_the_title( $feat_post ) ); ?></h3>
					<div class="card__meta">
						<span><i class="far fa-clock"></i> <?php echo esc_html( promovads_time_ago_ar( $feat_post->ID ) ); ?></span>
					</div>
				</div>
			</a>
		<?php endforeach; ?>
	</div>
</div>
