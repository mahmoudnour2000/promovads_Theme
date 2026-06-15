<?php
/**
 * Breaking News Ticker
 *
 * @package PromovaDS_News
 */

$ticker_label = get_theme_mod( 'promovads_ticker_label', esc_html__( 'Breaking', 'promovads' ) );
$ticker_cat   = get_theme_mod( 'promovads_ticker_category', 0 );

$args = array(
	'posts_per_page'      => 10,
	'post_status'         => 'publish',
	'ignore_sticky_posts' => false,
	'orderby'             => 'date',
	'order'               => 'DESC',
);

if ( $ticker_cat ) {
	$args['cat'] = absint( $ticker_cat );
}

$ticker_posts = new WP_Query( $args );

if ( ! $ticker_posts->have_posts() ) {
	return;
}
?>

<div class="pds-ticker" role="marquee" aria-label="<?php esc_attr_e( 'Breaking News', 'promovads' ); ?>">

	<div class="pds-ticker__label">
		<span class="pds-ticker__dot" aria-hidden="true"></span>
		<?php echo esc_html( $ticker_label ); ?>
	</div>

	<div class="pds-ticker__track">
		<div class="pds-ticker__inner" id="pds-ticker-inner">
			<?php
			// Output items twice for seamless loop
			for ( $i = 0; $i < 2; $i++ ) :
				$ticker_posts->rewind_posts();
				while ( $ticker_posts->have_posts() ) :
					$ticker_posts->the_post();
					?>
					<span class="pds-ticker__item">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</span>
					<?php
				endwhile;
			endfor;
			wp_reset_postdata();
			?>
		</div>
	</div>

	<div class="pds-ticker__controls" aria-label="<?php esc_attr_e( 'Ticker controls', 'promovads' ); ?>">
		<button class="pds-ticker__btn pds-ticker__pause" aria-label="<?php esc_attr_e( 'Pause ticker', 'promovads' ); ?>">
			<i class="fas fa-pause" aria-hidden="true"></i>
		</button>
		<button class="pds-ticker__btn pds-ticker__play pds-hidden" aria-label="<?php esc_attr_e( 'Play ticker', 'promovads' ); ?>">
			<i class="fas fa-play" aria-hidden="true"></i>
		</button>
	</div>

</div>
