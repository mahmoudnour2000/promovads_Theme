<?php
/**
 * Shared hero grid fallback for demos without custom hero.
 *
 * @package PromovaDS_News
 */

$featured = promovads_get_featured_posts( 3 );
if ( empty( $featured ) ) {
	return;
}

$main  = $featured[0];
$side  = array_slice( $featured, 1 );
$cat   = promovads_get_primary_category( $main->ID );
$color = $cat ? promovads_get_category_color( $cat->term_id ) : '#6366f1';
$config = promovads_get_demo_config();
$prefix = $config['prefix'] ?? 'pds';
?>
<div class="<?php echo esc_attr( $prefix ); ?>-hero__shell">
	<div class="<?php echo esc_attr( $prefix ); ?>-hero__grid">
		<a href="<?php echo esc_url( get_permalink( $main ) ); ?>" class="<?php echo esc_attr( $prefix ); ?>-hero__lead">
			<?php echo promovads_thumbnail( $main->ID, 'promovads-hero' ); ?>
			<div class="<?php echo esc_attr( $prefix ); ?>-hero__lead-overlay">
				<?php if ( promovads_is_breaking_post( $main->ID ) ) : ?>
					<span class="<?php echo esc_attr( $prefix ); ?>-hero__live"><span class="<?php echo esc_attr( $prefix ); ?>-hero__live-dot"></span><?php esc_html_e( 'عاجل', 'promovads' ); ?></span>
				<?php else : ?>
					<span class="<?php echo esc_attr( $prefix ); ?>-hero__badge"><i class="fas fa-star"></i> <?php esc_html_e( 'خبر مميز', 'promovads' ); ?></span>
				<?php endif; ?>
				<?php if ( $cat ) : ?>
					<span class="<?php echo esc_attr( $prefix ); ?>-hero__cat" style="--cat-color:<?php echo esc_attr( $color ); ?>">
						<i class="fas <?php echo esc_attr( promovads_get_category_icon( $cat->term_id ) ); ?>"></i>
						<?php echo esc_html( $cat->name ); ?>
					</span>
				<?php endif; ?>
				<h2><?php echo esc_html( get_the_title( $main ) ); ?></h2>
				<p class="<?php echo esc_attr( $prefix ); ?>-hero__excerpt"><?php echo esc_html( promovads_truncate( get_the_excerpt( $main ), 160 ) ); ?></p>
				<div class="<?php echo esc_attr( $prefix ); ?>-hero__meta">
					<span><i class="far fa-clock"></i> <?php echo esc_html( promovads_time_ago_ar( $main->ID ) ); ?></span>
					<span><i class="far fa-bookmark"></i> <?php echo esc_html( promovads_reading_time( $main->ID ) ); ?></span>
					<span><i class="far fa-eye"></i> <?php echo esc_html( promovads_views_label( $main->ID ) ); ?></span>
				</div>
				<span class="<?php echo esc_attr( $prefix ); ?>-hero__cta"><?php esc_html_e( 'اقرأ المزيد', 'promovads' ); ?> <i class="fas fa-arrow-left"></i></span>
			</div>
		</a>
		<div class="<?php echo esc_attr( $prefix ); ?>-hero__side">
			<?php foreach ( $side as $idx => $side_post ) :
				$pcat   = promovads_get_primary_category( $side_post->ID );
				$pcolor = $pcat ? promovads_get_category_color( $pcat->term_id ) : '#6366f1';
				?>
				<a href="<?php echo esc_url( get_permalink( $side_post ) ); ?>" class="<?php echo esc_attr( $prefix ); ?>-hero__side-card">
					<span class="<?php echo esc_attr( $prefix ); ?>-hero__side-num"><?php echo esc_html( str_pad( (string) ( $idx + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
					<?php echo promovads_thumbnail( $side_post->ID, 'promovads-thumb' ); ?>
					<div class="<?php echo esc_attr( $prefix ); ?>-hero__side-body">
						<?php if ( $pcat ) : ?>
							<span class="<?php echo esc_attr( $prefix ); ?>-hero__side-cat" style="color:<?php echo esc_attr( $pcolor ); ?>">
								<i class="fas <?php echo esc_attr( promovads_get_category_icon( $pcat->term_id ) ); ?>"></i>
								<?php echo esc_html( $pcat->name ); ?>
							</span>
						<?php endif; ?>
						<h3><?php echo esc_html( get_the_title( $side_post ) ); ?></h3>
						<span class="<?php echo esc_attr( $prefix ); ?>-hero__side-meta"><?php echo esc_html( promovads_time_ago_ar( $side_post->ID ) ); ?> · <?php echo esc_html( promovads_reading_time( $side_post->ID ) ); ?></span>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</div>
