<?php
/**
 * Header — demo-aware dispatch.
 *
 * @package PromovaDS_News
 */

$demo   = promovads_active_demo();
$config  = promovads_get_demo_config( $demo );
$is_rtl  = is_rtl() || ( $config && 'rtl' === get_theme_mod( 'promovads_rtl_mode', 'rtl' ) );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php echo $is_rtl ? 'dir="rtl"' : 'dir="ltr"'; ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="https://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>

<body <?php body_class( $config ? 'demo-' . sanitize_html_class( $demo ) : '' ); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'promovads' ); ?></a>

<?php if ( $config ) : ?>
	<?php get_template_part( 'template-parts/demos/_shared/header' ); ?>
	<div id="content" class="site-content">
<?php else : ?>

	<?php get_template_part( 'template-parts/headers/topbar' ); ?>

	<header id="masthead" class="pds-header<?php echo get_theme_mod( 'promovads_sticky_header', 1 ) ? '' : ' pds-header--static'; ?>" role="banner">
		<div class="pds-container">
			<div class="pds-header__inner">

				<div class="pds-header__logo">
					<?php
					promovads_render_site_logo(
						'header',
						array(
							'wrapper_class'      => 'pds-header__logo-link pds-site-logo pds-site-logo--header',
							'show_fallback_text' => true,
						)
					);
					?>
				</div>

				<?php if ( ! is_mobile() ) : ?>
					<?php promovads_ad( 'header', false ); ?>
				<?php endif; ?>

				<div class="pds-header__actions">
					<button class="pds-btn-icon pds-search-trigger" aria-label="<?php esc_attr_e( 'Open Search', 'promovads' ); ?>">
						<i class="fas fa-search" aria-hidden="true"></i>
					</button>
					<button class="pds-btn-icon pds-dark-mode-btn" aria-label="<?php esc_attr_e( 'Toggle Dark Mode', 'promovads' ); ?>">
						<i class="fas fa-moon" aria-hidden="true"></i>
					</button>
					<a href="#newsletter" class="pds-btn pds-btn--primary pds-d-none-sm">
						<i class="fas fa-envelope" aria-hidden="true"></i>
						<?php esc_html_e( 'Subscribe', 'promovads' ); ?>
					</a>
					<button class="pds-menu-toggle pds-d-none-lg" id="pds-menu-toggle" aria-expanded="false" aria-controls="pds-primary-nav" aria-label="<?php esc_attr_e( 'Toggle navigation', 'promovads' ); ?>">
						<span></span><span></span><span></span>
					</button>
				</div>
			</div>
		</div>
	</header>

	<nav id="pds-primary-nav" class="pds-nav" role="navigation" aria-label="<?php esc_attr_e( 'Primary Navigation', 'promovads' ); ?>">
		<div class="pds-container">
			<?php get_template_part( 'template-parts/headers/nav-primary' ); ?>
		</div>
	</nav>

	<?php if ( get_theme_mod( 'promovads_show_ticker', 1 ) ) : ?>
		<?php get_template_part( 'template-parts/headers/breaking-ticker' ); ?>
	<?php endif; ?>

	<div class="pds-search-overlay" id="pds-search-overlay" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Search', 'promovads' ); ?>">
		<button class="pds-search-overlay__close" aria-label="<?php esc_attr_e( 'Close search', 'promovads' ); ?>">
			<i class="fas fa-times" aria-hidden="true"></i>
		</button>
		<div class="pds-search-overlay__box">
			<div class="pds-search-overlay__input">
				<i class="fas fa-search" aria-hidden="true"></i>
				<input type="search" id="pds-search-input" placeholder="<?php esc_attr_e( 'Search for news, topics...', 'promovads' ); ?>" autocomplete="off" spellcheck="false">
				<kbd>ESC</kbd>
			</div>
			<div class="pds-search-results" id="pds-search-results" aria-live="polite"></div>
		</div>
	</div>

	<div id="content" class="site-content">
<?php endif; ?>
