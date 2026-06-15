<?php
/**
 * List Post Card
 *
 * @package PromovaDS_News
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'pds-card pds-card--list' ); ?>>

	<?php if ( has_post_thumbnail() ) : ?>
	<a href="<?php the_permalink(); ?>" class="pds-card__thumb" tabindex="-1" aria-hidden="true">
		<?php echo promovads_thumbnail( 0, 'promovads-thumb' ); ?>
	</a>
	<?php endif; ?>

	<div class="pds-card__body">
		<div class="pds-card__meta">
			<?php echo promovads_category_badge(); ?>
			<span class="sep"></span>
			<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
				<?php echo esc_html( promovads_time_ago() ); ?>
			</time>
		</div>

		<h3 class="pds-card__title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h3>
	</div>

</article>
