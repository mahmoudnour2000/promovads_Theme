<?php
/**
 * Hero Post Card (full overlay)
 *
 * @package PromovaDS_News
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'pds-card pds-card--hero' ); ?>>

	<div class="pds-card__thumb">
		<?php echo promovads_thumbnail( 0, 'promovads-hero' ); ?>
	</div>

	<div class="pds-card__body">
		<?php echo promovads_category_badge(); ?>

		<h2 class="pds-card__title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h2>

		<?php if ( has_excerpt() ) : ?>
		<p class="pds-card__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
		<?php endif; ?>

		<div class="pds-card__meta">
			<div class="pds-card__author">
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 24 ); ?>
				<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
					<?php the_author(); ?>
				</a>
			</div>
			<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
				<?php echo esc_html( promovads_time_ago() ); ?>
			</time>
			<span><?php echo esc_html( promovads_reading_time() ); ?></span>
		</div>
	</div>

</article>
