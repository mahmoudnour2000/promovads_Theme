<?php
/**
 * Demo footer from WordPress data.
 *
 * @package PromovaDS_News
 */

$config      = promovads_get_demo_config();
if ( ! $config ) {
	return;
}

$prefix      = $config['prefix'];
$site_name   = get_bloginfo( 'name' );
$description = get_bloginfo( 'description' ) ?: ( $config['tagline'] ?? '' );
$categories  = promovads_get_nav_categories( array( 'number' => 8 ) );
$icon        = $config['logo_icon'] ?? 'fa-newspaper';
?>
<footer class="footer-main pds-demo-footer">
	<div class="wrap">
		<div class="footer-grid">
			<div class="footer-brand">
				<?php
				promovads_render_site_logo(
					'footer',
					array(
						'wrapper_class'      => 'logo pds-footer-logo pds-site-logo pds-site-logo--footer',
						'fallback_icon'      => $icon,
						'show_fallback_text' => true,
					)
				);
				?>
				<?php if ( $description ) : ?>
					<p><?php echo esc_html( $description ); ?></p>
				<?php endif; ?>
			</div>
			<?php if ( ! empty( $categories ) ) : ?>
			<div class="footer-col">
				<h4><?php esc_html_e( 'الأقسام', 'promovads' ); ?></h4>
				<ul>
					<?php foreach ( $categories as $cat ) : ?>
						<li><a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>"><?php echo esc_html( $cat->name ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<?php endif; ?>
			<div class="footer-col">
				<h4><?php esc_html_e( 'الموقع', 'promovads' ); ?></h4>
				<ul>
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer-1',
							'container'      => false,
							'items_wrap'     => '%3$s',
							'fallback_cb'    => static function () {
								echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'الرئيسية', 'promovads' ) . '</a></li>';
								echo '<li><a href="' . esc_url( promovads_posts_archive_url() ) . '">' . esc_html__( 'كل الأخبار', 'promovads' ) . '</a></li>';
							},
						)
					);
					?>
				</ul>
			</div>
		</div>
	</div>
</footer>
<div class="footer-bottom pds-demo-footer-bottom">
	<div class="wrap">
		<span>
			<?php
			$copy = get_theme_mod( 'promovads_footer_text', '' );
			echo $copy ? wp_kses_post( $copy ) : '&copy; ' . esc_html( gmdate( 'Y' ) ) . ' ' . esc_html( $site_name ) . '. ' . esc_html__( 'جميع الحقوق محفوظة.', 'promovads' );
			?>
		</span>
	</div>
</div>

<button class="back-top" id="backTop" type="button" aria-label="<?php esc_attr_e( 'Back to top', 'promovads' ); ?>"><i class="fas fa-chevron-up"></i></button>

<div class="search-overlay pds-search-overlay" id="searchOverlay" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'بحث', 'promovads' ); ?>" aria-hidden="true">
	<button class="search-close pds-search-overlay__close" type="button" aria-label="<?php esc_attr_e( 'إغلاق', 'promovads' ); ?>"><i class="fas fa-times"></i></button>
	<div class="search-box pds-search-overlay__box">
		<form class="search-input-wrap pds-search-overlay__input" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<i class="fas fa-search" aria-hidden="true"></i>
			<input type="search" name="s" id="pds-search-input-demo" placeholder="<?php esc_attr_e( 'ابحث في الأخبار…', 'promovads' ); ?>" autocomplete="off" value="<?php echo esc_attr( get_search_query() ); ?>">
			<button type="submit" class="pds-search-submit" aria-label="<?php esc_attr_e( 'بحث', 'promovads' ); ?>"><i class="fas fa-arrow-left" aria-hidden="true"></i></button>
		</form>
		<div class="search-results pds-search-results" id="searchPreview" aria-live="polite"></div>
	</div>
</div>

<div class="progress-bar" id="progress"></div>
