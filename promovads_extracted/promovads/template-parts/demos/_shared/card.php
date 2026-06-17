<?php
/**
 * Demo card — WordPress post card matching تمblit markup.
 *
 * @package PromovaDS_News
 *
 * @var WP_Post $post Post object (optional via args).
 */

$post = $args['post'] ?? get_post();
if ( ! $post instanceof WP_Post ) {
	return;
}

setup_postdata( $post );
$cat   = promovads_get_primary_category( $post->ID );
$color = $cat ? promovads_get_category_color( $cat->term_id ) : '#6366f1';
?>
<article class="card">
	<a href="<?php echo esc_url( get_permalink( $post ) ); ?>" class="card__thumb">
		<?php echo promovads_thumbnail( $post->ID, 'promovads-card' ); ?>
		<?php if ( $cat ) : ?>
			<span class="card__cat" style="background:<?php echo esc_attr( $color ); ?>;color:#fff"><?php echo esc_html( $cat->name ); ?></span>
		<?php endif; ?>
	</a>
	<div class="card__body">
		<div class="card__meta">
			<span><?php echo esc_html( promovads_time_ago_ar( $post->ID ) ); ?></span>
			<span class="dot"><?php echo esc_html( promovads_reading_time( $post->ID ) ); ?></span>
		</div>
		<h3 class="card__title"><a href="<?php echo esc_url( get_permalink( $post ) ); ?>"><?php echo esc_html( get_the_title( $post ) ); ?></a></h3>
		<p class="card__excerpt"><?php echo esc_html( promovads_truncate( get_the_excerpt( $post ), 120 ) ); ?></p>
		<div class="card__foot">
			<div class="card__author">
				<?php echo get_avatar( (int) $post->post_author, 40 ); ?>
				<?php echo esc_html( promovads_author_display_name( (int) $post->post_author ) ); ?>
			</div>
			<div class="card__stats">
				<span><i class="far fa-eye"></i> <?php echo esc_html( promovads_views_label( $post->ID ) ); ?></span>
			</div>
		</div>
	</div>
</article>
<?php
wp_reset_postdata();
