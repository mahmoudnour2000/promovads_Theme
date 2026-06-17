<?php
/**
 * Trending + hot topics widgets — live WordPress data.
 *
 * @package PromovaDS_News
 */

$trending_args = array();
if ( is_singular( 'post' ) ) {
	$trending_args['post__not_in'] = array( (int) get_queried_object_id() );
}

$trending = promovads_get_trending( 5, $trending_args );
$topics   = get_tags(
	array(
		'number'     => 12,
		'orderby'    => 'count',
		'order'      => 'DESC',
		'hide_empty' => true,
	)
);
?>

<?php if ( $trending->have_posts() ) : ?>
<div class="widget">
	<div class="widget__title">🔥 <?php esc_html_e( 'الأكثر قراءة', 'promovads' ); ?></div>
	<div class="widget__body" style="padding:8px 16px">
		<div class="trending-list">
			<?php
			$n = 0;
			while ( $trending->have_posts() ) :
				$trending->the_post();
				++$n;
				?>
				<div class="trending-item">
					<span class="n"><?php echo esc_html( str_pad( (string) $n, 2, '0', STR_PAD_LEFT ) ); ?></span>
					<div>
						<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
						<span><?php echo esc_html( promovads_views_label() ); ?> <?php esc_html_e( 'مشاهدة', 'promovads' ); ?> · <?php echo esc_html( promovads_time_ago_ar() ); ?></span>
					</div>
				</div>
			<?php endwhile; wp_reset_postdata(); ?>
		</div>
	</div>
</div>
<?php endif; ?>

<?php if ( ! empty( $topics ) && ! is_wp_error( $topics ) ) : ?>
<div class="widget">
	<div class="widget__title"><?php esc_html_e( 'موضوعات ساخنة', 'promovads' ); ?></div>
	<div class="widget__body" style="padding:12px 16px">
		<div class="tags">
			<?php foreach ( $topics as $tag ) : ?>
				<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="tag"><?php echo esc_html( $tag->name ); ?></a>
			<?php endforeach; ?>
		</div>
	</div>
</div>
<?php endif; ?>
