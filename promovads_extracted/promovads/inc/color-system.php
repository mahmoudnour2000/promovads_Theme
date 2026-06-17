<?php
/**
 * PromovaDS — complete demo color token system.
 *
 * @package PromovaDS_News
 */

defined( 'ABSPATH' ) || exit;

/**
 * Color token schema grouped for admin UI.
 *
 * @return array<string, array{label:string, tokens:array<string, array{label:string, desc?:string}>}>
 */
function promovads_color_token_schema(): array {
	return array(
		'brand'      => array(
			'label'  => __( 'ألوان الهوية', 'promovads' ),
			'tokens' => array(
				'primary'      => array( 'label' => __( 'اللون الأساسي', 'promovads' ), 'desc' => __( 'الأزرار، الروابط، التمييز', 'promovads' ) ),
				'primary_dark' => array( 'label' => __( 'أساسي داكن (Hover)', 'promovads' ) ),
				'secondary'    => array( 'label' => __( 'اللون الثانوي', 'promovads' ), 'desc' => __( 'الهيدر العلوي، الأرشيف، الفوتر', 'promovads' ) ),
				'accent'       => array( 'label' => __( 'لون التمييز', 'promovads' ), 'desc' => __( 'التدرجات واللمسات', 'promovads' ) ),
			),
		),
		'surfaces'   => array(
			'label'  => __( 'الخلفيات والأسطح', 'promovads' ),
			'tokens' => array(
				'bg'          => array( 'label' => __( 'خلفية الصفحة', 'promovads' ) ),
				'surface'     => array( 'label' => __( 'خلفية البطاقات والودجات', 'promovads' ) ),
				'surface_alt' => array( 'label' => __( 'سطح بديل', 'promovads' ), 'desc' => __( 'صناديق المؤلف، خلفيات ثانوية', 'promovads' ) ),
				'border'      => array( 'label' => __( 'لون الحدود', 'promovads' ) ),
			),
		),
		'text'       => array(
			'label'  => __( 'ألوان النص', 'promovads' ),
			'tokens' => array(
				'text_heading' => array( 'label' => __( 'العناوين', 'promovads' ) ),
				'text_body'    => array( 'label' => __( 'نص المقال', 'promovads' ) ),
				'text_muted'   => array( 'label' => __( 'نص ثانوي / Meta', 'promovads' ) ),
				'text_subtle'  => array( 'label' => __( 'نص خافت / Placeholder', 'promovads' ) ),
				'text_on_dark' => array( 'label' => __( 'نص على خلفية داكنة', 'promovads' ) ),
			),
		),
		'header'     => array(
			'label'  => __( 'الهيدر والتنقل', 'promovads' ),
			'tokens' => array(
				'topbar_bg'    => array( 'label' => __( 'خلفية الشريط العلوي', 'promovads' ) ),
				'topbar_text'  => array( 'label' => __( 'نص الشريط العلوي', 'promovads' ) ),
				'header_bg'    => array( 'label' => __( 'خلفية الهيدر', 'promovads' ) ),
				'nav_active'   => array( 'label' => __( 'قسم نشط في القائمة', 'promovads' ) ),
				'nav_text'     => array( 'label' => __( 'نص القائمة', 'promovads' ) ),
				'ticker_bg'    => array( 'label' => __( 'خلفية شريط الأخبار', 'promovads' ) ),
				'ticker_text'  => array( 'label' => __( 'نص شريط الأخبار', 'promovads' ) ),
			),
		),
		'footer'     => array(
			'label'  => __( 'الفوتر', 'promovads' ),
			'tokens' => array(
				'footer_bg'         => array( 'label' => __( 'خلفية الفوتر', 'promovads' ) ),
				'footer_bottom_bg'  => array( 'label' => __( 'الشريط السفلي', 'promovads' ) ),
				'footer_text'       => array( 'label' => __( 'نص الفوتر', 'promovads' ) ),
				'footer_link'       => array( 'label' => __( 'روابط الفوتر', 'promovads' ) ),
				'footer_link_hover' => array( 'label' => __( 'روابط الفوتر (Hover)', 'promovads' ) ),
			),
		),
		'components' => array(
			'label'  => __( 'المكونات', 'promovads' ),
			'tokens' => array(
				'widget_title_bg'   => array( 'label' => __( 'عنوان الودجت — خلفية', 'promovads' ) ),
				'widget_title_text' => array( 'label' => __( 'عنوان الودجت — نص', 'promovads' ) ),
				'btn_bg'            => array( 'label' => __( 'الأزرار — خلفية', 'promovads' ) ),
				'btn_text'          => array( 'label' => __( 'الأزرار — نص', 'promovads' ) ),
				'link'              => array( 'label' => __( 'الروابط', 'promovads' ) ),
				'link_hover'        => array( 'label' => __( 'الروابط (Hover)', 'promovads' ) ),
				'archive_header_bg' => array( 'label' => __( 'رأس صفحة الأرشيف', 'promovads' ) ),
				'card_highlight'    => array( 'label' => __( 'تمييز البطاقة (Hover)', 'promovads' ) ),
				'blockquote_bg'     => array( 'label' => __( 'خلفية الاقتباس', 'promovads' ) ),
				'hero_overlay'      => array( 'label' => __( 'تدرج الهيرو', 'promovads' ), 'desc' => __( 'لون داكن فوق صورة الهيرو', 'promovads' ) ),
			),
		),
	);
}

/**
 * Flat list of all token keys.
 *
 * @return string[]
 */
function promovads_color_token_keys(): array {
	$keys = array();
	foreach ( promovads_color_token_schema() as $group ) {
		$keys = array_merge( $keys, array_keys( $group['tokens'] ) );
	}
	return $keys;
}

/**
 * Default palette derived from active demo registry colors.
 *
 * @return array<string, string>
 */
function promovads_color_defaults( ?array $config = null ): array {
	if ( null === $config ) {
		$config = promovads_get_demo_config();
	}

	$primary   = sanitize_hex_color( $config['primary'] ?? '#6366f1' ) ?: '#6366f1';
	$secondary = sanitize_hex_color( $config['secondary'] ?? '#0f172a' ) ?: '#0f172a';
	$accent    = sanitize_hex_color( $config['accent'] ?? '#06b6d4' ) ?: '#06b6d4';
	$primary_d = promovads_darken_hex( $primary, 10 );

	return array(
		'primary'           => $primary,
		'primary_dark'      => $primary_d,
		'secondary'         => $secondary,
		'accent'            => $accent,
		'bg'                => '#f4f4f8',
		'surface'           => '#ffffff',
		'surface_alt'       => '#f8f8fc',
		'border'            => '#e2e8f0',
		'text_heading'      => $secondary,
		'text_body'         => '#334155',
		'text_muted'        => '#64748b',
		'text_subtle'       => '#94a3b8',
		'text_on_dark'      => '#ffffff',
		'topbar_bg'         => $secondary,
		'topbar_text'       => '#d1d5db',
		'header_bg'         => '#ffffff',
		'nav_active'        => $primary,
		'nav_text'          => '#64748b',
		'ticker_bg'         => $secondary,
		'ticker_text'       => '#ffffff',
		'footer_bg'         => $secondary,
		'footer_bottom_bg'  => promovads_darken_hex( $secondary, 18 ),
		'footer_text'       => '#cbd5e1',
		'footer_link'       => '#e2e8f0',
		'footer_link_hover' => $primary,
		'widget_title_bg'   => $secondary,
		'widget_title_text' => '#ffffff',
		'btn_bg'            => $primary,
		'btn_text'          => '#ffffff',
		'link'              => $primary,
		'link_hover'        => $primary_d,
		'archive_header_bg' => $secondary,
		'card_highlight'    => $primary,
		'blockquote_bg'     => promovads_lighten_hex( $primary, 92 ),
		'hero_overlay'      => $secondary,
	);
}

/**
 * Saved palette merged with defaults + legacy theme_mod migration.
 *
 * @return array<string, string>
 */
function promovads_get_color_palette(): array {
	$defaults = promovads_color_defaults();
	$saved    = get_theme_mod( 'promovads_color_palette', array() );

	if ( ! is_array( $saved ) ) {
		$saved = array();
	}

	// Legacy three-color mods.
	$legacy_map = array(
		'primary'   => 'promovads_color_primary',
		'secondary' => 'promovads_color_secondary',
		'accent'    => 'promovads_color_accent',
	);
	foreach ( $legacy_map as $key => $mod ) {
		$val = get_theme_mod( $mod, '' );
		if ( $val && empty( $saved[ $key ] ) ) {
			$saved[ $key ] = $val;
		}
	}

	$palette = array_merge( $defaults, array_intersect_key( $saved, $defaults ) );

	foreach ( $palette as $key => $value ) {
		if ( 'hero_overlay' === $key ) {
			$palette[ $key ] = sanitize_hex_color( $value ) ?: ( $defaults['hero_overlay'] ?? '#0f172a' );
			continue;
		}
		if ( str_starts_with( (string) $value, 'rgba' ) || str_starts_with( (string) $value, 'rgb' ) ) {
			continue;
		}
		$palette[ $key ] = sanitize_hex_color( $value ) ?: ( $defaults[ $key ] ?? '#6366f1' );
	}

	// Recompute derived if primary changed but primary_dark wasn't saved explicitly.
	if ( ! empty( $saved['primary'] ) && empty( $saved['primary_dark'] ) ) {
		$palette['primary_dark'] = promovads_darken_hex( $palette['primary'], 10 );
	}
	if ( ! empty( $saved['primary'] ) && empty( $saved['blockquote_bg'] ) ) {
		$palette['blockquote_bg'] = promovads_lighten_hex( $palette['primary'], 92 );
	}

	return apply_filters( 'promovads_color_palette', $palette );
}

/**
 * Backward-compatible three-color API.
 *
 * @return array{primary:string, secondary:string, accent:string}
 */
function promovads_get_theme_colors(): array {
	$p = promovads_get_color_palette();
	return array(
		'primary'   => $p['primary'],
		'secondary' => $p['secondary'],
		'accent'    => $p['accent'],
	);
}

/**
 * Save palette from admin POST.
 */
function promovads_save_color_palette_from_post(): void {
	$defaults = promovads_color_defaults();
	$palette  = array();

	foreach ( promovads_color_token_keys() as $key ) {
		$field = 'pds_clr_' . $key;
		if ( ! isset( $_POST[ $field ] ) ) {
			continue;
		}
		$raw = wp_unslash( $_POST[ $field ] );
		$palette[ $key ] = sanitize_hex_color( $raw ) ?: ( $defaults[ $key ] ?? '#6366f1' );
	}

	set_theme_mod( 'promovads_color_palette', $palette );
	set_theme_mod( 'promovads_color_primary', $palette['primary'] ?? $defaults['primary'] );
	set_theme_mod( 'promovads_color_secondary', $palette['secondary'] ?? $defaults['secondary'] );
	set_theme_mod( 'promovads_color_accent', $palette['accent'] ?? $defaults['accent'] );
}

/**
 * Reset palette to current demo defaults.
 */
function promovads_reset_color_palette(): void {
	$defaults = promovads_color_defaults();
	set_theme_mod( 'promovads_color_palette', $defaults );
	set_theme_mod( 'promovads_color_primary', $defaults['primary'] );
	set_theme_mod( 'promovads_color_secondary', $defaults['secondary'] );
	set_theme_mod( 'promovads_color_accent', $defaults['accent'] );
}

/**
 * Darken hex color.
 */
function promovads_darken_hex( string $hex, int $percent = 12 ): string {
	$hex = ltrim( $hex, '#' );
	if ( 3 === strlen( $hex ) ) {
		$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
	}
	$r = max( 0, hexdec( substr( $hex, 0, 2 ) ) - (int) round( 255 * ( $percent / 100 ) ) );
	$g = max( 0, hexdec( substr( $hex, 2, 2 ) ) - (int) round( 255 * ( $percent / 100 ) ) );
	$b = max( 0, hexdec( substr( $hex, 4, 2 ) ) - (int) round( 255 * ( $percent / 100 ) ) );
	return sprintf( '#%02x%02x%02x', $r, $g, $b );
}

/**
 * Lighten toward white (percent 0–100).
 */
function promovads_lighten_hex( string $hex, int $percent = 50 ): string {
	$hex = ltrim( $hex, '#' );
	if ( 3 === strlen( $hex ) ) {
		$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
	}
	$r = hexdec( substr( $hex, 0, 2 ) );
	$g = hexdec( substr( $hex, 2, 2 ) );
	$b = hexdec( substr( $hex, 4, 2 ) );
	$p = $percent / 100;
	$r = (int) round( $r + ( 255 - $r ) * $p );
	$g = (int) round( $g + ( 255 - $g ) * $p );
	$b = (int) round( $b + ( 255 - $b ) * $p );
	return sprintf( '#%02x%02x%02x', $r, $g, $b );
}

/**
 * Hex to rgba string.
 */
function promovads_hex_to_rgba( string $hex, float $alpha = 1 ): string {
	$hex = ltrim( $hex, '#' );
	if ( 3 === strlen( $hex ) ) {
		$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
	}
	$r = hexdec( substr( $hex, 0, 2 ) );
	$g = hexdec( substr( $hex, 2, 2 ) );
	$b = hexdec( substr( $hex, 4, 2 ) );
	return sprintf( 'rgba(%d,%d,%d,%s)', $r, $g, $b, rtrim( rtrim( number_format( $alpha, 2, '.', '' ), '0' ), '.' ) );
}

/**
 * CSS var name for token.
 */
function promovads_color_var( string $key ): string {
	return '--pds-' . str_replace( '_', '-', $key );
}

/**
 * Output full color system as CSS variables on frontend.
 */
function promovads_theme_colors_css(): void {
	if ( ! promovads_active_demo() ) {
		return;
	}

	$p = promovads_get_color_palette();
	$vars = array();

	foreach ( $p as $key => $value ) {
		if ( 'hero_overlay' === $key ) {
			$vars[] = sprintf( '--pds-hero-overlay: %s', esc_attr( promovads_hex_to_rgba( $value, 0.88 ) ) );
			continue;
		}
		$vars[] = sprintf( '%s: %s', promovads_color_var( $key ), esc_attr( $value ) );
	}

	$glow = promovads_hex_to_rgba( $p['primary'], 0.15 );

	$css = ':root {' . implode( '; ', $vars ) . ';';
	$css .= sprintf(
		' --pds-glow: %1$s;
		--color-primary: var(--pds-primary);
		--color-primary-dark: var(--pds-primary-dark);
		--color-secondary: var(--pds-secondary);
		--color-accent: var(--pds-accent);
		--c-primary: var(--pds-primary);
		--c-primary-dk: var(--pds-primary-dark);
		--c-secondary: var(--pds-secondary);
		--c-accent: var(--pds-accent);
		--tech-bg: var(--pds-bg);
		--tech-surface: var(--pds-surface);
		--tech-surface-2: var(--pds-surface-alt);
		--tech-border: color-mix(in srgb, var(--pds-border) 100%%, transparent);
		--tech-glow: %1$s;
		--tech-shadow: 0 4px 24px color-mix(in srgb, var(--pds-secondary) 6%%, transparent);
		--text-head: var(--pds-text-heading);
		--text-body: var(--pds-text-body);
		--text-muted: var(--pds-text-muted);
		--text-subtle: var(--pds-text-subtle);
		--text-accent: var(--pds-primary-dark);
		--text-content: var(--pds-text-body);
	}',
		$glow
	);
	$css .= '}';

	$css .= '
		body[class*="demo-"] { background: var(--pds-bg) !important; color: var(--pds-text-body); }
		body[class*="demo-"] h1, body[class*="demo-"] h2, body[class*="demo-"] h3, body[class*="demo-"] h4 { color: var(--pds-text-heading); }
		body[class*="demo-"] a:not(.card__title a):not(.tech-btn-cta):not(.pds-site-logo) { color: var(--pds-link); }
		body[class*="demo-"] a:not(.card__title a):not(.tech-btn-cta):not(.pds-site-logo):hover { color: var(--pds-link-hover); }
		body[class*="demo-"] [class*="-topbar"] { background: var(--pds-topbar-bg) !important; color: var(--pds-topbar-text) !important; }
		body[class*="demo-"] [class*="-header"] { background: var(--pds-header-bg) !important; }
		body[class*="demo-"] [class*="-ticker"], body[class*="demo-"] .pds-demo-ticker { background: var(--pds-ticker-bg) !important; color: var(--pds-ticker-text) !important; }
		body[class*="demo-"] .footer-main, body[class*="demo-"] .pds-demo-footer { background: var(--pds-footer-bg) !important; color: var(--pds-footer-text) !important; }
		body[class*="demo-"] .footer-bottom, body[class*="demo-"] .pds-demo-footer-bottom { background: var(--pds-footer-bottom-bg) !important; }
		body[class*="demo-"] .footer-col a, body[class*="demo-"] .pds-demo-footer a:not(.pds-site-logo) { color: var(--pds-footer-link) !important; }
		body[class*="demo-"] .footer-col a:hover, body[class*="demo-"] .pds-demo-footer a:not(.pds-site-logo):hover { color: var(--pds-footer-link-hover) !important; }
		body[class*="demo-"] .widget__title { background: var(--pds-widget-title-bg) !important; color: var(--pds-widget-title-text) !important; }
		body[class*="demo-"] .widget, body[class*="demo-"] .card { background: var(--pds-surface) !important; border-color: var(--pds-border) !important; }
		body[class*="demo-"] .archive-hd { background: var(--pds-archive-header-bg) !important; }
		body[class*="demo-"] [class*="-btn-cta"], body[class*="demo-"] .cat-section__btn { background: linear-gradient(135deg, var(--pds-btn-bg), var(--pds-primary-dark)) !important; color: var(--pds-btn-text) !important; }
		body[class*="demo-"] [class*="-logo__icon"], body[class*="demo-"] .pds-site-logo__fallback-icon { background: linear-gradient(135deg, var(--pds-primary), var(--pds-accent)) !important; }
		body[class*="demo-"] .back-top, body[class*="demo-"] .progress-bar { background: linear-gradient(135deg, var(--pds-primary), var(--pds-accent)) !important; color: var(--pds-btn-text) !important; }
		body[class*="demo-"] .site-nav__item.active a, body[class*="demo-"] .site-nav__item a:hover { color: var(--pds-nav-active) !important; }
		body[class*="demo-"] .site-nav__item a { color: var(--pds-nav-text) !important; }
		body[class*="demo-"] .entry-content blockquote, body[class*="demo-"] .info-box { background: var(--pds-blockquote-bg) !important; border-right-color: var(--pds-primary) !important; }
		body[class*="demo-"] .card:hover { border-color: color-mix(in srgb, var(--pds-card-highlight) 25%, transparent) !important; box-shadow: 0 8px 28px var(--pds-glow) !important; }
		body[class*="demo-"] .pagination .page-numbers.current { background: var(--pds-primary) !important; border-color: var(--pds-primary) !important; color: var(--pds-btn-text) !important; }
	';

	$handle = 'promovads-demo-colors';
	if ( ! wp_style_is( $handle, 'enqueued' ) ) {
		$handle = wp_style_is( 'promovads-demo-fixes', 'enqueued' ) ? 'promovads-demo-fixes' : 'promovads-style';
	}
	wp_add_inline_style( $handle, $css );
}
add_action( 'wp_enqueue_scripts', 'promovads_theme_colors_css', 30 );
