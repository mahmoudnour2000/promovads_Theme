<?php
/**
 * Sidebar Template
 *
 * @package PromovaDS_News
 */

if ( ! is_active_sidebar( 'sidebar-main' ) ) {

	// Default sidebar content if no widgets configured
	?>
	<!-- Trending Widget (default) -->
	<div class="pds-widget">
		<h3 class="pds-widget__title"><?php esc_html_e( 'Trending Now', 'promovads' ); ?></h3>
		<div class="pds-widget__body">
			<?php
			$trending = promovads_get_trending( 5 );
			if ( $trending->have_posts() ) :
				$i = 1;
				echo '<ol class="pds-trending-list">';
				while ( $trending->have_posts() ) :
					$trending->the_post();
					?>
					<li class="pds-trending-item">
						<span class="pds-trending-item__num"><?php echo $i++; ?></span>
						<div class="pds-trending-item__content">
							<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
							<span><?php echo esc_html( promovads_time_ago() ); ?></span>
						</div>
					</li>
					<?php
				endwhile;
				echo '</ol>';
				wp_reset_postdata();
			endif;
			?>
		</div>
	</div>

	<!-- Newsletter Widget (default) -->
	<div class="pds-newsletter">
		<div class="pds-newsletter__icon">
			<i class="fas fa-envelope" aria-hidden="true"></i>
		</div>
		<h4><?php esc_html_e( 'Newsletter', 'promovads' ); ?></h4>
		<p><?php esc_html_e( 'Get the latest news in your inbox.', 'promovads' ); ?></p>
		<form class="pds-newsletter__form pds-newsletter-form" novalidate>
			<input type="email" name="email" placeholder="<?php esc_attr_e( 'Your email...', 'promovads' ); ?>" required>
			<button type="submit"><?php esc_html_e( 'Subscribe', 'promovads' ); ?></button>
		</form>
	</div>

	<!-- Ad Widget (default) -->
	<?php promovads_ad( 'sidebar' ); ?>

	<!-- Popular Tags -->
	<?php
	$tags = get_tags( array( 'number' => 15, 'orderby' => 'count', 'order' => 'DESC' ) );
	if ( $tags ) :
		?>
		<div class="pds-widget">
			<h3 class="pds-widget__title"><?php esc_html_e( 'Popular Tags', 'promovads' ); ?></h3>
			<div class="pds-widget__body">
				<div class="pds-tags">
					<?php foreach ( $tags as $tag ) : ?>
						<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="pds-tag">
							<?php echo esc_html( $tag->name ); ?>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<?php
	return;
}

dynamic_sidebar( 'sidebar-main' );
