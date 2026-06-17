<?php
/**
 * Hero Grid Block (big left + 2 small right)
 *
 * @package PromovaDS_News
 */

$args_data = isset( $args ) ? $args : array();
$category  = $args_data['category'] ?? 0;
$count     = $args_data['count']    ?? 3;

$query_args = array(
	'posts_per_page'      => absint( $count ),
	'post_status'         => 'publish',
	'ignore_sticky_posts' => false,
);

if ( $category ) {
	$query_args['cat'] = absint( $category );
}

$hero_query = new WP_Query( $query_args );

if ( ! $hero_query->have_posts() ) {
	return;
}

$all_posts = $hero_query->posts;
wp_reset_postdata();

$main  = $all_posts[0]  ?? null;
$side  = array_slice( $all_posts, 1 );
?>

<section class="pds-hero-grid">

	<!-- Main Hero Post -->
	<?php if ( $main ) : ?>
		<article class="pds-card pds-card--hero">
			<div class="pds-card__thumb">
				<?php echo promovads_thumbnail( $main->ID, 'promovads-hero' ); ?>
			</div>
			<div class="pds-card__body">
				<?php echo promovads_category_badge( $main->ID ); ?>
				<h2 class="pds-card__title">
					<a href="<?php echo esc_url( get_permalink( $main->ID ) ); ?>">
						<?php echo esc_html( get_the_title( $main->ID ) ); ?>
					</a>
				</h2>
				<p class="pds-card__excerpt">
					<?php echo esc_html( promovads_truncate( get_the_excerpt( $main->ID ), 140 ) ); ?>
				</p>
				<div class="pds-card__meta">
					<time datetime="<?php echo esc_attr( get_the_date( 'c', $main->ID ) ); ?>">
						<?php echo esc_html( promovads_time_ago( $main->ID ) ); ?>
					</time>
					<span><?php echo esc_html( promovads_reading_time( $main->ID ) ); ?></span>
				</div>
			</div>
		</article>
	<?php endif; ?>

	<!-- Side Posts -->
	<?php if ( $side ) : ?>
	<div class="pds-hero-grid__side">
		<?php foreach ( $side as $side_post ) : ?>
			<article class="pds-card pds-card--hero">
				<div class="pds-card__thumb">
					<?php echo promovads_thumbnail( $side_post->ID, 'promovads-featured' ); ?>
				</div>
				<div class="pds-card__body">
					<?php echo promovads_category_badge( $side_post->ID ); ?>
					<h3 class="pds-card__title">
						<a href="<?php echo esc_url( get_permalink( $side_post->ID ) ); ?>">
							<?php echo esc_html( get_the_title( $side_post->ID ) ); ?>
						</a>
					</h3>
					<div class="pds-card__meta">
						<time datetime="<?php echo esc_attr( get_the_date( 'c', $side_post->ID ) ); ?>">
							<?php echo esc_html( promovads_time_ago( $side_post->ID ) ); ?>
						</time>
					</div>
				</div>
			</article>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>

</section>
