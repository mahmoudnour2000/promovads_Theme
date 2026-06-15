<?php
/**
 * Standard Post Card
 *
 * @package PromovaDS_News
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'pds-card' ); ?>>

	<?php if ( has_post_thumbnail() ) : ?>
	<a href="<?php the_permalink(); ?>" class="pds-card__thumb" tabindex="-1" aria-hidden="true">
		<?php echo promovads_thumbnail( 0, 'promovads-card' ); ?>
		<?php echo promovads_category_badge(); ?>
	</a>
	<?php endif; ?>

	<div class="pds-card__body">

		<div class="pds-card__meta">
			<?php if ( ! has_post_thumbnail() ) : ?>
				<?php echo promovads_category_badge(); ?>
				<span class="sep"></span>
			<?php endif; ?>
			<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
				<?php echo esc_html( promovads_time_ago() ); ?>
			</time>
			<span class="sep"></span>
			<span><?php echo esc_html( promovads_reading_time() ); ?></span>
		</div>

		<h3 class="pds-card__title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h3>

		<?php if ( has_excerpt() ) : ?>
		<p class="pds-card__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
		<?php endif; ?>

		<div class="pds-card__footer">
			<div class="pds-card__author">
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 24, '', '', array( 'class' => '' ) ); ?>
				<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
					<?php the_author(); ?>
				</a>
			</div>
			<div class="pds-card__stats">
				<span>
					<i class="far fa-eye" aria-hidden="true"></i>
					<?php echo esc_html( promovads_format_number( promovads_get_views() ) ); ?>
				</span>
				<span>
					<i class="far fa-comment" aria-hidden="true"></i>
					<?php echo esc_html( get_comments_number() ); ?>
				</span>
			</div>
		</div>

	</div>

</article>
