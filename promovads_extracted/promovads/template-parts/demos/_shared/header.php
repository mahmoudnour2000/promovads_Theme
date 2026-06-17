<?php
/**
 * Demo header shell — shared structure for all تمblit demos.
 *
 * @package PromovaDS_News
 */

$config = promovads_get_demo_config();
if ( ! $config ) {
	return;
}

$prefix       = $config['prefix'];
$compact      = ! is_front_page() && ! is_home();
$archive_url  = promovads_posts_archive_url();
$site_name    = get_bloginfo( 'name' );
$description  = get_bloginfo( 'description' );
$tagline      = $description ?: ( $config['tagline'] ?? '' );
$sticky       = (int) get_theme_mod( 'promovads_sticky_header', 0 );
$header_class = esc_attr( $prefix ) . '-header';
if ( $compact ) {
	$header_class .= ' ' . esc_attr( $prefix ) . '-header--compact';
}
if ( $sticky ) {
	$header_class .= ' ' . esc_attr( $prefix ) . '-header--sticky';
}
?>
<div class="<?php echo esc_attr( $prefix ); ?>-topbar">
	<div class="wrap">
		<div class="<?php echo esc_attr( $prefix ); ?>-topbar__left">
			<span class="<?php echo esc_attr( $prefix ); ?>-topbar__badge"><i class="fas fa-newspaper"></i> <?php echo esc_html( $config['topbar_badge'] ?? $config['label'] ); ?></span>
			<span><i class="fas fa-calendar-alt" style="color:<?php echo esc_attr( $config['primary'] ); ?>;margin-inline-start:5px"></i> <?php echo esc_html( wp_date( 'l، j F Y' ) ); ?></span>
		</div>
		<div class="<?php echo esc_attr( $prefix ); ?>-topbar__social">
			<?php
			$networks = array(
				'twitter'   => 'fab fa-x-twitter',
				'youtube'   => 'fab fa-youtube',
				'linkedin'  => 'fab fa-linkedin-in',
				'facebook'  => 'fab fa-facebook-f',
				'instagram' => 'fab fa-instagram',
			);
			foreach ( $networks as $key => $icon ) :
				$url = get_theme_mod( 'promovads_social_' . $key, '' );
				if ( ! $url ) {
					continue;
				}
				?>
				<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( ucfirst( $key ) ); ?>">
					<i class="<?php echo esc_attr( $icon ); ?>"></i>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</div>

<header class="<?php echo esc_attr( $header_class ); ?>">
	<div class="wrap">
		<div class="<?php echo esc_attr( $prefix ); ?>-header__bar">
			<?php
			promovads_render_site_logo(
				'header',
				array(
					'wrapper_class'      => $prefix . '-logo pds-site-logo pds-site-logo--header',
					'fallback_icon'      => $config['logo_icon'] ?? 'fa-newspaper',
					'tagline'            => $tagline,
					'show_fallback_text' => true,
				)
			);
			?>

			<button type="button" class="<?php echo esc_attr( $prefix ); ?>-search pds-search-trigger" aria-label="<?php esc_attr_e( 'بحث', 'promovads' ); ?>">
				<i class="fas fa-search" aria-hidden="true"></i>
				<span class="<?php echo esc_attr( $prefix ); ?>-search__text"><?php esc_html_e( 'ابحث في الأخبار…', 'promovads' ); ?></span>
			</button>

			<div class="<?php echo esc_attr( $prefix ); ?>-header__actions">
				<button class="<?php echo esc_attr( $prefix ); ?>-btn-icon pds-search-trigger" type="button" title="<?php esc_attr_e( 'بحث', 'promovads' ); ?>"><i class="fas fa-search"></i></button>
				<a href="<?php echo esc_url( $archive_url ); ?>" class="<?php echo esc_attr( $prefix ); ?>-btn-cta"><i class="fas fa-newspaper"></i> <?php esc_html_e( 'كل الأخبار', 'promovads' ); ?></a>
			</div>
		</div>

		<?php promovads_render_skin( 'nav' ); ?>
	</div>
</header>

<?php if ( is_front_page() || is_home() ) : ?>
	<?php
	$hero_part = $config['hero_part'] ?? '_shared/hero-grid';
	if ( ! empty( $config['has_hero'] ) ) :
		?>
	<section class="<?php echo esc_attr( $prefix ); ?>-hero-zone">
		<div class="wrap">
			<div class="<?php echo esc_attr( $prefix ); ?>-hero-zone__head">
				<div class="<?php echo esc_attr( $prefix ); ?>-hero-zone__title">
					<span class="<?php echo esc_attr( $prefix ); ?>-hero-zone__live" aria-hidden="true"></span>
					<i class="<?php echo esc_attr( str_starts_with( $config['logo_icon'], 'fab' ) ? $config['logo_icon'] : 'fas ' . $config['logo_icon'] ); ?>"></i>
					<?php
					printf(
						/* translators: %s: demo label */
						esc_html__( 'أبرز أخبار %s', 'promovads' ),
						esc_html( $config['label'] )
					);
					?>
				</div>
				<a href="<?php echo esc_url( $archive_url ); ?>" class="<?php echo esc_attr( $prefix ); ?>-hero-zone__link"><?php esc_html_e( 'عرض الكل', 'promovads' ); ?> <i class="fas fa-arrow-left"></i></a>
			</div>
			<div class="<?php echo esc_attr( $prefix ); ?>-hero" id="headerHero">
				<?php promovads_render_skin( 'hero' ); ?>
			</div>
		</div>
	</section>
	<?php endif; ?>
<?php endif; ?>

<?php get_template_part( 'template-parts/demos/_shared/ticker' ); ?>
