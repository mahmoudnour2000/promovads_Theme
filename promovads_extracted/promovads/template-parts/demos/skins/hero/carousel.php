<?php
/**
 * Skin: Hero — سلايدر أفقي.
 *
 * @package PromovaDS_News
 */

$featured = promovads_get_featured_posts( 6 );
if ( empty( $featured ) ) {
	return;
}

$config = promovads_get_demo_config();
$prefix = $config['prefix'] ?? 'pds';
?>
<div class="<?php echo esc_attr( $prefix ); ?>-hero__shell pds-skin-hero pds-skin-hero--carousel">
	<div class="pds-hero-carousel" tabindex="0">
		<div class="pds-hero-carousel__track">
			<?php foreach ( $featured as $feat_post ) :
				$cat   = promovads_get_primary_category( $feat_post->ID );
				$color = $cat ? promovads_get_category_color( $cat->term_id ) : ( $config['primary'] ?? '#6366f1' );
				?>
				<a href="<?php echo esc_url( get_permalink( $feat_post ) ); ?>" class="pds-hero-carousel__slide">
					<div class="pds-hero-carousel__img"><?php echo promovads_thumbnail( $feat_post->ID, 'promovads-featured' ); ?></div>
					<div class="pds-hero-carousel__body">
						<?php if ( $cat ) : ?>
							<span class="pds-hero-carousel__cat" style="color:<?php echo esc_attr( $color ); ?>"><?php echo esc_html( $cat->name ); ?></span>
						<?php endif; ?>
						<h3><?php echo esc_html( get_the_title( $feat_post ) ); ?></h3>
						<span class="pds-hero-carousel__meta"><?php echo esc_html( promovads_time_ago_ar( $feat_post->ID ) ); ?></span>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</div>
