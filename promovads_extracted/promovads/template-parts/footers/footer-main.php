<?php
/**
 * Main Footer Template
 *
 * @package PromovaDS_News
 */

$about_text   = get_theme_mod( 'promovads_footer_about', '' );
$footer_copy  = get_theme_mod( 'promovads_footer_text', '' );
$current_year = date( 'Y' );

$socials = array(
	'facebook'  => array( 'icon' => 'fab fa-facebook-f',  'label' => 'Facebook' ),
	'twitter'   => array( 'icon' => 'fab fa-x-twitter',   'label' => 'Twitter' ),
	'instagram' => array( 'icon' => 'fab fa-instagram',   'label' => 'Instagram' ),
	'youtube'   => array( 'icon' => 'fab fa-youtube',     'label' => 'YouTube' ),
	'telegram'  => array( 'icon' => 'fab fa-telegram',    'label' => 'Telegram' ),
	'tiktok'    => array( 'icon' => 'fab fa-tiktok',      'label' => 'TikTok' ),
	'linkedin'  => array( 'icon' => 'fab fa-linkedin-in', 'label' => 'LinkedIn' ),
	'rss'       => array( 'icon' => 'fas fa-rss',         'label' => 'RSS' ),
);
?>

<!-- Newsletter CTA Bar -->
<div class="pds-footer-newsletter" id="newsletter">
	<div class="pds-container">
		<div class="pds-footer-newsletter__inner">
			<div>
				<h3><?php esc_html_e( 'Stay Informed, Stay Ahead', 'promovads' ); ?></h3>
				<p><?php esc_html_e( 'Get the latest news delivered to your inbox daily.', 'promovads' ); ?></p>
			</div>
			<form class="pds-footer-newsletter__form pds-newsletter-form" novalidate>
				<input type="email" name="email" placeholder="<?php esc_attr_e( 'Enter your email address', 'promovads' ); ?>" required aria-label="<?php esc_attr_e( 'Email address', 'promovads' ); ?>">
				<button type="submit">
					<?php esc_html_e( 'Subscribe Free', 'promovads' ); ?>
					<i class="fas fa-arrow-right" aria-hidden="true"></i>
				</button>
			</form>
		</div>
	</div>
</div>

<!-- Footer Main -->
<footer id="colophon" class="pds-footer-main" role="contentinfo">
	<div class="pds-container">
		<div class="pds-footer-grid">

			<!-- Brand Column -->
			<div class="pds-footer-brand">
				<?php
				promovads_render_site_logo(
					'footer',
					array(
						'wrapper_class'      => 'pds-footer-brand__logo pds-site-logo pds-site-logo--footer',
						'show_fallback_text' => true,
					)
				);
				?>

				<p>
					<?php
					if ( $about_text ) {
						echo wp_kses_post( $about_text );
					} else {
						bloginfo( 'description' );
					}
					?>
				</p>

				<!-- Social Icons -->
				<div class="pds-footer-social">
					<?php foreach ( $socials as $key => $net ) : ?>
						<?php $url = get_theme_mod( 'promovads_social_' . $key, '' ); ?>
						<?php if ( $url ) : ?>
							<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $net['label'] ); ?>">
								<i class="<?php echo esc_attr( $net['icon'] ); ?>" aria-hidden="true"></i>
							</a>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			</div>

			<!-- Footer Column 1 -->
			<div class="pds-footer-col">
				<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
					<?php dynamic_sidebar( 'footer-1' ); ?>
				<?php else : ?>
					<h4><?php esc_html_e( 'Quick Links', 'promovads' ); ?></h4>
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer-1',
							'menu_class'     => 'pds-footer-links',
							'container'      => false,
							'depth'          => 1,
						)
					);
					?>
				<?php endif; ?>
			</div>

			<!-- Footer Column 2 -->
			<div class="pds-footer-col">
				<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
					<?php dynamic_sidebar( 'footer-2' ); ?>
				<?php else : ?>
					<h4><?php esc_html_e( 'Categories', 'promovads' ); ?></h4>
					<ul>
						<?php
						$categories = get_categories( array( 'number' => 8, 'orderby' => 'count', 'order' => 'DESC' ) );
						foreach ( $categories as $cat ) :
							?>
							<li>
								<a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>">
									<?php echo esc_html( $cat->name ); ?>
									<span>(<?php echo absint( $cat->count ); ?>)</span>
								</a>
							</li>
							<?php
						endforeach;
						?>
					</ul>
				<?php endif; ?>
			</div>

			<!-- Footer Column 3 -->
			<div class="pds-footer-col">
				<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
					<?php dynamic_sidebar( 'footer-3' ); ?>
				<?php else : ?>
					<h4><?php esc_html_e( 'Recent Posts', 'promovads' ); ?></h4>
					<?php
					$recent = new WP_Query( array( 'posts_per_page' => 4, 'post_status' => 'publish' ) );
					while ( $recent->have_posts() ) :
						$recent->the_post();
						?>
						<div class="pds-footer-recent-post">
							<?php if ( has_post_thumbnail() ) : ?>
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail( 'promovads-small', array( 'loading' => 'lazy' ) ); ?>
								</a>
							<?php endif; ?>
							<div>
								<h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
								<span><?php echo esc_html( promovads_time_ago() ); ?></span>
							</div>
						</div>
						<?php
					endwhile;
					wp_reset_postdata();
					?>
				<?php endif; ?>
			</div>

		</div><!-- .pds-footer-grid -->
	</div>
</footer>

<!-- Footer Bottom Bar -->
<div class="pds-footer-bottom">
	<div class="pds-container">
		<div class="pds-footer-bottom__inner">
			<p>
				<?php
				if ( $footer_copy ) {
					echo wp_kses_post( $footer_copy );
				} else {
					printf(
						/* translators: %1$s: year, %2$s: site name */
						esc_html__( '&copy; %1$s %2$s. All rights reserved.', 'promovads' ),
						esc_html( $current_year ),
						esc_html( get_bloginfo( 'name' ) )
					);
				}
				?>
			</p>
			<div class="pds-footer-bottom__links">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer-2',
						'menu_class'     => 'pds-footer-bottom__menu',
						'container'      => false,
						'depth'          => 1,
						'fallback_cb'    => false,
					)
				);
				?>
				<span><?php esc_html_e( 'Privacy Policy', 'promovads' ); ?></span>
				<span><?php esc_html_e( 'Terms of Use', 'promovads' ); ?></span>
				<span><?php esc_html_e( 'Advertise', 'promovads' ); ?></span>
			</div>
		</div>
	</div>
</div>
