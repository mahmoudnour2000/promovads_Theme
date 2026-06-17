<?php
/**
 * Tech AI hero — WordPress data.
 *
 * @package PromovaDS_News
 */

$featured = promovads_get_featured_posts( 3 );
if ( empty( $featured ) ) {
	get_template_part( 'template-parts/demos/_shared/hero-grid' );
	return;
}

$main   = $featured[0];
$side   = array_slice( $featured, 1, 2 );
$cat    = promovads_get_primary_category( $main->ID );
$color  = $cat ? promovads_get_category_color( $cat->term_id ) : '#6366f1';
$pulse  = promovads_get_breaking_posts( 3 );
?>
<div class="tech-hero__shell">
	<div class="tech-hero__grid">
		<a href="<?php echo esc_url( get_permalink( $main ) ); ?>" class="tech-hero__lead">
			<?php echo promovads_thumbnail( $main->ID, 'promovads-hero' ); ?>
			<div class="tech-hero__lead-overlay">
				<?php if ( promovads_is_breaking_post( $main->ID ) ) : ?>
					<span class="tech-hero__live"><span class="tech-hero__live-dot"></span><?php esc_html_e( 'عاجل', 'promovads' ); ?></span>
				<?php else : ?>
					<span class="tech-hero__badge"><i class="fas fa-microchip"></i> <?php esc_html_e( 'خبر مميز', 'promovads' ); ?></span>
				<?php endif; ?>
				<?php if ( $cat ) : ?>
					<span class="tech-hero__cat" style="--cat-color:<?php echo esc_attr( $color ); ?>">
						<i class="fas <?php echo esc_attr( promovads_get_category_icon( $cat->term_id, 'fa-brain' ) ); ?>"></i>
						<?php echo esc_html( $cat->name ); ?>
					</span>
				<?php endif; ?>
				<h2><?php echo esc_html( get_the_title( $main ) ); ?></h2>
				<p class="tech-hero__excerpt"><?php echo esc_html( promovads_truncate( get_the_excerpt( $main ), 160 ) ); ?></p>
				<div class="tech-hero__meta">
					<span><i class="far fa-clock"></i> <?php echo esc_html( promovads_time_ago_ar( $main->ID ) ); ?></span>
					<span><i class="far fa-bookmark"></i> <?php echo esc_html( promovads_reading_time( $main->ID ) ); ?></span>
					<span><i class="far fa-eye"></i> <?php echo esc_html( promovads_views_label( $main->ID ) ); ?></span>
				</div>
				<span class="tech-hero__cta"><?php esc_html_e( 'اقرأ المزيد', 'promovads' ); ?> <i class="fas fa-arrow-left"></i></span>
			</div>
		</a>
		<div class="tech-hero__side">
			<?php foreach ( $side as $idx => $post ) :
				$pcat   = promovads_get_primary_category( $post->ID );
				$pcolor = $pcat ? promovads_get_category_color( $pcat->term_id ) : '#6366f1';
				?>
				<a href="<?php echo esc_url( get_permalink( $post ) ); ?>" class="tech-hero__side-card">
					<span class="tech-hero__side-num"><?php echo esc_html( str_pad( (string) ( $idx + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
					<?php echo promovads_thumbnail( $post->ID, 'promovads-thumb' ); ?>
					<div class="tech-hero__side-body">
						<?php if ( $pcat ) : ?>
							<span class="tech-hero__side-cat" style="color:<?php echo esc_attr( $pcolor ); ?>">
								<i class="fas <?php echo esc_attr( promovads_get_category_icon( $pcat->term_id ) ); ?>"></i>
								<?php echo esc_html( $pcat->name ); ?>
							</span>
						<?php endif; ?>
						<h3><?php echo esc_html( get_the_title( $post ) ); ?></h3>
						<span class="tech-hero__side-meta"><?php echo esc_html( promovads_time_ago_ar( $post->ID ) ); ?> · <?php echo esc_html( promovads_reading_time( $post->ID ) ); ?></span>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>

	<?php if ( ! empty( $pulse ) ) : ?>
	<div class="tech-hero__pulse">
		<span class="tech-hero__pulse-label"><i class="fas fa-bolt"></i> <?php esc_html_e( 'الآن', 'promovads' ); ?></span>
		<div class="tech-hero__pulse-track">
			<?php foreach ( $pulse as $pp ) :
				$pcat   = promovads_get_primary_category( $pp->ID );
				$pcolor = $pcat ? promovads_get_category_color( $pcat->term_id ) : '#6366f1';
				?>
				<a href="<?php echo esc_url( get_permalink( $pp ) ); ?>" class="tech-hero__pulse-item" style="--pulse-color:<?php echo esc_attr( $pcolor ); ?>">
					<?php if ( $pcat ) : ?>
						<span class="tech-hero__pulse-cat"><?php echo esc_html( $pcat->name ); ?></span>
					<?php endif; ?>
					<span class="tech-hero__pulse-title"><?php echo esc_html( get_the_title( $pp ) ); ?></span>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
	<?php endif; ?>
</div>
