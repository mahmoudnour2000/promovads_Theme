<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php echo is_rtl() ? 'dir="rtl"' : 'dir="ltr"'; ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="https://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'promovads' ); ?></a>

	<?php get_template_part( 'template-parts/headers/topbar' ); ?>

	<header id="masthead" class="pds-header<?php echo get_theme_mod( 'promovads_sticky_header', 1 ) ? '' : ' pds-header--static'; ?>" role="banner">
		<div class="pds-container">
			<div class="pds-header__inner">

				<!-- Logo -->
				<div class="pds-header__logo">
					<?php if ( has_custom_logo() ) : ?>
						<?php the_custom_logo(); ?>
					<?php else : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="pds-header__logo-text" rel="home">
							<?php
							$name  = get_bloginfo( 'name' );
							$parts = explode( ' ', $name, 2 );
							echo esc_html( $parts[0] );
							if ( isset( $parts[1] ) ) {
								echo '<span> ' . esc_html( $parts[1] ) . '</span>';
							}
							?>
						</a>
					<?php endif; ?>
				</div>

				<!-- Header Ad (728x90 leaderboard) - only on wide screens -->
				<?php if ( ! is_mobile() ) : ?>
					<?php promovads_ad( 'header', false ); ?>
				<?php endif; ?>

				<!-- Header Actions -->
				<div class="pds-header__actions">

					<!-- Search Toggle -->
					<button class="pds-btn-icon pds-search-trigger" aria-label="<?php esc_attr_e( 'Open Search', 'promovads' ); ?>">
						<i class="fas fa-search" aria-hidden="true"></i>
					</button>

					<!-- Dark Mode Toggle -->
					<button class="pds-btn-icon pds-dark-mode-btn" aria-label="<?php esc_attr_e( 'Toggle Dark Mode', 'promovads' ); ?>" title="<?php esc_attr_e( 'Toggle Dark Mode', 'promovads' ); ?>">
						<i class="fas fa-moon" aria-hidden="true"></i>
					</button>

					<!-- Subscribe -->
					<a href="#newsletter" class="pds-btn pds-btn--primary pds-d-none-sm">
						<i class="fas fa-envelope" aria-hidden="true"></i>
						<?php esc_html_e( 'Subscribe', 'promovads' ); ?>
					</a>

					<!-- Mobile Menu Toggle -->
					<button class="pds-menu-toggle pds-d-none-lg" id="pds-menu-toggle" aria-expanded="false" aria-controls="pds-primary-nav" aria-label="<?php esc_attr_e( 'Toggle navigation', 'promovads' ); ?>">
						<span></span>
						<span></span>
						<span></span>
					</button>
				</div>

			</div><!-- .pds-header__inner -->
		</div>
	</header>

	<!-- Primary Navigation -->
	<nav id="pds-primary-nav" class="pds-nav" role="navigation" aria-label="<?php esc_attr_e( 'Primary Navigation', 'promovads' ); ?>">
		<div class="pds-container">
			<?php get_template_part( 'template-parts/headers/nav-primary' ); ?>
		</div>
	</nav>

	<!-- Breaking News Ticker -->
	<?php if ( get_theme_mod( 'promovads_show_ticker', 1 ) ) : ?>
		<?php get_template_part( 'template-parts/headers/breaking-ticker' ); ?>
	<?php endif; ?>

	<!-- Ajax Search Overlay -->
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
