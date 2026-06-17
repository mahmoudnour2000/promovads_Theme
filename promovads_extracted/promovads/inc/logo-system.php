<?php
/**
 * PromovaDS — complete logo control system.
 *
 * @package PromovaDS_News
 */

defined( 'ABSPATH' ) || exit;

/**
 * Logo settings schema for admin UI.
 *
 * @return array<string, array{label:string, fields:array<string, array<string, mixed>>}>
 */
function promovads_logo_settings_schema(): array {
	return array(
		'header'  => array(
			'label'  => __( 'شعار الهيدر', 'promovads' ),
			'fields' => array(
				'header_logo_id'      => array( 'type' => 'image', 'label' => __( 'صورة الشعار', 'promovads' ) ),
				'header_height'       => array( 'type' => 'number', 'label' => __( 'الارتفاع (px)', 'promovads' ), 'min' => 24, 'max' => 160, 'default' => 52 ),
				'header_max_width'    => array( 'type' => 'number', 'label' => __( 'العرض الأقصى (px)', 'promovads' ), 'min' => 80, 'max' => 400, 'default' => 220 ),
				'header_show_text'    => array( 'type' => 'checkbox', 'label' => __( 'إظهار اسم الموقع بجانب الشعار', 'promovads' ) ),
			),
		),
		'footer'  => array(
			'label'  => __( 'شعار الفوتر', 'promovads' ),
			'fields' => array(
				'footer_use_same'     => array( 'type' => 'checkbox', 'label' => __( 'استخدام نفس شعار الهيدر', 'promovads' ), 'default' => 1 ),
				'footer_logo_id'      => array( 'type' => 'image', 'label' => __( 'شعار مختلف للفوتر', 'promovads' ), 'depends' => 'footer_use_same:0' ),
				'footer_height'       => array( 'type' => 'number', 'label' => __( 'الارتفاع (px)', 'promovads' ), 'min' => 20, 'max' => 120, 'default' => 44 ),
				'footer_max_width'    => array( 'type' => 'number', 'label' => __( 'العرض الأقصى (px)', 'promovads' ), 'min' => 60, 'max' => 320, 'default' => 180 ),
				'footer_show_text'    => array( 'type' => 'checkbox', 'label' => __( 'إظهار اسم الموقع في الفوتر', 'promovads' ) ),
			),
		),
		'mobile'  => array(
			'label'  => __( 'شعار الموبايل', 'promovads' ),
			'fields' => array(
				'mobile_use_same'     => array( 'type' => 'checkbox', 'label' => __( 'استخدام نفس شعار الهيدر', 'promovads' ), 'default' => 1 ),
				'mobile_logo_id'      => array( 'type' => 'image', 'label' => __( 'شعار مصغّر للموبايل', 'promovads' ), 'depends' => 'mobile_use_same:0' ),
				'mobile_height'       => array( 'type' => 'number', 'label' => __( 'الارتفاع (px)', 'promovads' ), 'min' => 20, 'max' => 100, 'default' => 40 ),
				'mobile_max_width'    => array( 'type' => 'number', 'label' => __( 'العرض الأقصى (px)', 'promovads' ), 'min' => 60, 'max' => 240, 'default' => 140 ),
			),
		),
		'favicon' => array(
			'label'  => __( 'أيقونة الموقع (Favicon)', 'promovads' ),
			'fields' => array(
				'favicon_id' => array( 'type' => 'image', 'label' => __( 'Favicon / App Icon', 'promovads' ), 'desc' => __( '512×512 px موصى به. يُستخدم في تبويب المتصفح.', 'promovads' ) ),
			),
		),
		'general' => array(
			'label'  => __( 'إعدادات عامة', 'promovads' ),
			'fields' => array(
				'link_url'     => array( 'type' => 'url', 'label' => __( 'رابط الشعار', 'promovads' ), 'placeholder' => home_url( '/' ), 'desc' => __( 'اتركه فارغاً للصفحة الرئيسية.', 'promovads' ) ),
				'alt_text'     => array( 'type' => 'text', 'label' => __( 'نص بديل (Alt)', 'promovads' ), 'placeholder' => get_bloginfo( 'name' ) ),
				'object_fit'   => array( 'type' => 'select', 'label' => __( 'طريقة عرض الصورة', 'promovads' ), 'options' => array(
					'contain' => __( 'Contain — كامل الشعار', 'promovads' ),
					'cover'   => __( 'Cover — ملء الإطار', 'promovads' ),
				), 'default' => 'contain' ),
				'open_new_tab' => array( 'type' => 'checkbox', 'label' => __( 'فتح الرابط في تبويب جديد', 'promovads' ) ),
			),
		),
	);
}

/**
 * Default logo settings.
 *
 * @return array<string, mixed>
 */
function promovads_logo_defaults(): array {
	return array(
		'header_logo_id'   => 0,
		'header_height'      => 52,
		'header_max_width'   => 220,
		'header_show_text'   => 0,
		'footer_use_same'    => 1,
		'footer_logo_id'     => 0,
		'footer_height'      => 44,
		'footer_max_width'   => 180,
		'footer_show_text'   => 0,
		'mobile_use_same'    => 1,
		'mobile_logo_id'     => 0,
		'mobile_height'      => 40,
		'mobile_max_width'   => 140,
		'favicon_id'         => 0,
		'link_url'           => '',
		'alt_text'           => '',
		'object_fit'         => 'contain',
		'open_new_tab'       => 0,
	);
}

/**
 * Get merged logo settings (with legacy migration).
 *
 * @return array<string, mixed>
 */
function promovads_get_logo_settings(): array {
	$defaults = promovads_logo_defaults();
	$saved    = get_theme_mod( 'promovads_logo_settings', array() );

	if ( ! is_array( $saved ) ) {
		$saved = array();
	}

	// Legacy theme mods.
	if ( empty( $saved['header_logo_id'] ) ) {
		$saved['header_logo_id'] = (int) get_theme_mod( 'custom_logo', 0 );
	}
	if ( empty( $saved['header_height'] ) && get_theme_mod( 'promovads_logo_height' ) ) {
		$saved['header_height'] = (int) get_theme_mod( 'promovads_logo_height' );
	}
	if ( empty( $saved['footer_height'] ) && get_theme_mod( 'promovads_logo_height_footer' ) ) {
		$saved['footer_height'] = (int) get_theme_mod( 'promovads_logo_height_footer' );
	}

	$settings = array_merge( $defaults, array_intersect_key( $saved, $defaults ) );

	$settings['header_logo_id'] = absint( $settings['header_logo_id'] );
	$settings['footer_logo_id'] = absint( $settings['footer_logo_id'] );
	$settings['mobile_logo_id'] = absint( $settings['mobile_logo_id'] );
	$settings['favicon_id']     = absint( $settings['favicon_id'] );

	foreach ( array( 'header_show_text', 'footer_show_text', 'footer_use_same', 'mobile_use_same', 'open_new_tab' ) as $flag ) {
		$settings[ $flag ] = (int) (bool) $settings[ $flag ];
	}

	$settings['header_height']    = max( 24, min( 160, (int) $settings['header_height'] ) );
	$settings['header_max_width'] = max( 80, min( 400, (int) $settings['header_max_width'] ) );
	$settings['footer_height']    = max( 20, min( 120, (int) $settings['footer_height'] ) );
	$settings['footer_max_width'] = max( 60, min( 320, (int) $settings['footer_max_width'] ) );
	$settings['mobile_height']    = max( 20, min( 100, (int) $settings['mobile_height'] ) );
	$settings['mobile_max_width'] = max( 60, min( 240, (int) $settings['mobile_max_width'] ) );

	if ( ! in_array( $settings['object_fit'], array( 'contain', 'cover' ), true ) ) {
		$settings['object_fit'] = 'contain';
	}

	return apply_filters( 'promovads_logo_settings', $settings );
}

/**
 * Attachment ID for a logo context.
 */
function promovads_get_logo_id( string $context = 'header' ): int {
	$s = promovads_get_logo_settings();

	switch ( $context ) {
		case 'footer':
			if ( $s['footer_use_same'] ) {
				return $s['header_logo_id'];
			}
			return $s['footer_logo_id'] ?: $s['header_logo_id'];

		case 'mobile':
			if ( $s['mobile_use_same'] ) {
				return $s['header_logo_id'];
			}
			return $s['mobile_logo_id'] ?: $s['header_logo_id'];

		case 'favicon':
			return $s['favicon_id'];

		default:
			return $s['header_logo_id'];
	}
}

/**
 * Whether header has a separate mobile logo.
 */
function promovads_has_mobile_logo(): bool {
	$s = promovads_get_logo_settings();
	if ( $s['mobile_use_same'] || ! $s['header_logo_id'] ) {
		return false;
	}
	$mobile_id = $s['mobile_logo_id'] ?: $s['header_logo_id'];
	return $mobile_id && $mobile_id !== $s['header_logo_id'];
}

/**
 * Logo link URL.
 */
function promovads_logo_link_url(): string {
	$url = promovads_get_logo_settings()['link_url'];
	return $url ? esc_url( $url ) : home_url( '/' );
}

/**
 * Logo alt text.
 */
function promovads_logo_alt_text(): string {
	$alt = promovads_get_logo_settings()['alt_text'];
	return $alt ? $alt : get_bloginfo( 'name' );
}

/**
 * Render logo markup for header, footer, or mobile.
 *
 * @param string               $context header|footer|mobile
 * @param array<string, mixed> $args    wrapper_class, fallback_icon, tagline, show_fallback_text
 */
function promovads_render_site_logo( string $context = 'header', array $args = array() ): void {
	$defaults = array(
		'wrapper_class'      => '',
		'fallback_icon'      => 'fa-newspaper',
		'tagline'            => '',
		'show_fallback_text' => true,
	);
	$args     = wp_parse_args( $args, $defaults );
	$settings = promovads_get_logo_settings();
	$link     = promovads_logo_link_url();
	$alt      = promovads_logo_alt_text();
	$target   = $settings['open_new_tab'] ? ' target="_blank" rel="noopener noreferrer"' : '';
	$rel      = $settings['open_new_tab'] ? '' : ' rel="home"';

	$height_key = $context . '_height';
	$width_key  = $context . '_max_width';
	if ( 'mobile' === $context ) {
		$variant = 'mobile';
	} elseif ( 'footer' === $context ) {
		$variant = 'footer';
	} else {
		$variant = 'header';
	}

	$wrapper = $args['wrapper_class'] ?: 'pds-site-logo pds-site-logo--' . $variant;

	if ( 'header' === $context && promovads_has_mobile_logo() ) {
		promovads_render_logo_link(
			$link,
			$wrapper . ' pds-site-logo--desktop',
			$settings['header_logo_id'],
			$alt,
			$target,
			$rel,
			'desktop',
			! empty( $settings['header_show_text'] )
		);
		promovads_render_logo_link(
			$link,
			$wrapper . ' pds-site-logo--mobile',
			promovads_get_logo_id( 'mobile' ),
			$alt,
			$target,
			$rel,
			'mobile',
			false
		);
		return;
	}

	$logo_id = promovads_get_logo_id( $context );

	if ( ! $logo_id ) {
		promovads_render_logo_fallback( $link, $wrapper, $args, $target, $rel );
		return;
	}

	$show_text = ! empty( $settings[ $context . '_show_text' ] ) && in_array( $context, array( 'header', 'footer' ), true );
	promovads_render_logo_link( $link, $wrapper, $logo_id, $alt, $target, $rel, $variant, $show_text );
}

/**
 * Output logo image link.
 */
function promovads_render_logo_link(
	string $link,
	string $class,
	int $logo_id,
	string $alt,
	string $target,
	string $rel,
	string $variant,
	bool $show_text = false
): void {
	if ( ! $logo_id ) {
		return;
	}

	$img_class = 'pds-site-logo__img pds-site-logo__img--' . sanitize_html_class( $variant );
	$img       = wp_get_attachment_image(
		$logo_id,
		'full',
		false,
		array(
			'class'    => $img_class,
			'alt'      => esc_attr( $alt ),
			'loading'  => 'eager',
			'decoding' => 'async',
		)
	);

	if ( ! $img ) {
		return;
	}

	printf(
		'<a href="%1$s" class="%2$s"%3$s%4$s>%5$s',
		esc_url( $link ),
		esc_attr( $class ),
		$target,
		$rel,
		$img // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	);
	if ( $show_text ) {
		echo '<span class="pds-site-logo__text">' . esc_html( get_bloginfo( 'name' ) ) . '</span>';
	}
	echo '</a>';
}

/**
 * Fallback icon + site name when no logo uploaded.
 *
 * @param array<string, mixed> $args
 */
function promovads_render_logo_fallback( string $link, string $wrapper_class, array $args, string $target, string $rel ): void {
	$config = promovads_get_demo_config();
	$icon   = $args['fallback_icon'];
	if ( $config && ! empty( $config['logo_icon'] ) ) {
		$icon = $config['logo_icon'];
	}
	$prefix = $config['prefix'] ?? 'pds';
	$icon_class = str_starts_with( $icon, 'fab' ) ? $icon : 'fas ' . $icon;

	printf( '<a href="%1$s" class="%2$s"%3$s%4$s>', esc_url( $link ), esc_attr( $wrapper_class ), $target, $rel );
	echo '<span class="' . esc_attr( $prefix ) . '-logo__icon pds-site-logo__fallback-icon"><i class="' . esc_attr( $icon_class ) . '"></i></span>';
	if ( $args['show_fallback_text'] ) {
		echo '<span class="pds-site-logo__fallback-text">';
		echo esc_html( get_bloginfo( 'name' ) );
		if ( ! empty( $args['tagline'] ) ) {
			echo '<span class="' . esc_attr( $prefix ) . '-logo__sub pds-site-logo__sub">' . esc_html( $args['tagline'] ) . '</span>';
		}
		echo '</span>';
	}
	echo '</a>';
}

/**
 * Save logo settings from admin POST.
 */
function promovads_save_logo_settings_from_post(): void {
	$defaults = promovads_logo_defaults();
	$settings = promovads_get_logo_settings();

	$image_fields = array( 'header_logo_id', 'footer_logo_id', 'mobile_logo_id', 'favicon_id' );
	foreach ( $image_fields as $field ) {
		if ( isset( $_POST[ 'pds_logo_' . $field ] ) ) {
			$settings[ $field ] = absint( $_POST[ 'pds_logo_' . $field ] );
		}
	}

	$number_fields = array(
		'header_height'      => array( 24, 160 ),
		'header_max_width'   => array( 80, 400 ),
		'footer_height'      => array( 20, 120 ),
		'footer_max_width'   => array( 60, 320 ),
		'mobile_height'      => array( 20, 100 ),
		'mobile_max_width'   => array( 60, 240 ),
	);
	foreach ( $number_fields as $field => $range ) {
		if ( isset( $_POST[ 'pds_logo_' . $field ] ) ) {
			$settings[ $field ] = max( $range[0], min( $range[1], absint( $_POST[ 'pds_logo_' . $field ] ) ) );
		}
	}

	$checkboxes = array( 'header_show_text', 'footer_show_text', 'footer_use_same', 'mobile_use_same', 'open_new_tab' );
	foreach ( $checkboxes as $field ) {
		$settings[ $field ] = isset( $_POST[ 'pds_logo_' . $field ] ) ? 1 : 0;
	}

	if ( isset( $_POST['pds_logo_link_url'] ) ) {
		$settings['link_url'] = esc_url_raw( wp_unslash( $_POST['pds_logo_link_url'] ) );
	}
	if ( isset( $_POST['pds_logo_alt_text'] ) ) {
		$settings['alt_text'] = sanitize_text_field( wp_unslash( $_POST['pds_logo_alt_text'] ) );
	}
	if ( isset( $_POST['pds_logo_object_fit'] ) ) {
		$fit = sanitize_key( wp_unslash( $_POST['pds_logo_object_fit'] ) );
		$settings['object_fit'] = in_array( $fit, array( 'contain', 'cover' ), true ) ? $fit : 'contain';
	}

	set_theme_mod( 'promovads_logo_settings', $settings );
	set_theme_mod( 'custom_logo', $settings['header_logo_id'] );
	set_theme_mod( 'promovads_logo_height', $settings['header_height'] );
	set_theme_mod( 'promovads_logo_height_footer', $settings['footer_height'] );

	if ( $settings['favicon_id'] ) {
		update_option( 'site_icon', $settings['favicon_id'] );
	}
}

/**
 * Reset logo settings.
 */
function promovads_reset_logo_settings(): void {
	$defaults = promovads_logo_defaults();
	set_theme_mod( 'promovads_logo_settings', $defaults );
	set_theme_mod( 'custom_logo', 0 );
	set_theme_mod( 'promovads_logo_height', $defaults['header_height'] );
	set_theme_mod( 'promovads_logo_height_footer', $defaults['footer_height'] );
}

/**
 * Frontend logo CSS variables.
 */
function promovads_logo_css(): void {
	$s = promovads_get_logo_settings();

	$css = sprintf(
		':root {
			--pds-logo-h-header: %1$dpx;
			--pds-logo-w-header: %2$dpx;
			--pds-logo-h-footer: %3$dpx;
			--pds-logo-w-footer: %4$dpx;
			--pds-logo-h-mobile: %5$dpx;
			--pds-logo-w-mobile: %6$dpx;
			--pds-logo-fit: %7$s;
		}
		body[class*="demo-"] .pds-site-logo__img--header,
		body[class*="demo-"] [class*="-logo"] .custom-logo-link img,
		body[class*="demo-"] .pds-site-logo--desktop .pds-site-logo__img {
			max-height: var(--pds-logo-h-header) !important;
			max-width: var(--pds-logo-w-header) !important;
			width: auto !important;
			height: auto !important;
			object-fit: var(--pds-logo-fit);
		}
		body[class*="demo-"] .pds-site-logo__img--footer,
		body[class*="demo-"] .pds-footer-logo__img {
			max-height: var(--pds-logo-h-footer) !important;
			max-width: var(--pds-logo-w-footer) !important;
			width: auto !important;
			height: auto !important;
			object-fit: var(--pds-logo-fit);
		}
		body[class*="demo-"] .pds-site-logo__img--mobile,
		body[class*="demo-"] .pds-site-logo--mobile .pds-site-logo__img {
			max-height: var(--pds-logo-h-mobile) !important;
			max-width: var(--pds-logo-w-mobile) !important;
			object-fit: var(--pds-logo-fit);
		}
		body[class*="demo-"] .pds-site-logo--desktop { display: inline-flex; align-items: center; }
		body[class*="demo-"] .pds-site-logo--mobile { display: none; align-items: center; }
		@media (max-width: 768px) {
			body[class*="demo-"] .pds-site-logo--desktop { display: none; }
			body[class*="demo-"] .pds-site-logo--mobile { display: inline-flex; }
		}
		.pds-site-logo { display: inline-flex; align-items: center; gap: 10px; text-decoration: none; color: inherit; }
		.pds-site-logo__text { font-weight: 800; font-size: 1.1rem; }
		.pds-site-logo__fallback-text { display: flex; flex-direction: column; font-weight: 900; }
		.pds-header__logo .pds-site-logo__img,
		.pds-header__logo .custom-logo-link img { max-height: var(--pds-logo-h-header); max-width: var(--pds-logo-w-header); object-fit: var(--pds-logo-fit); }',
		$s['header_height'],
		$s['header_max_width'],
		$s['footer_height'],
		$s['footer_max_width'],
		$s['mobile_height'],
		$s['mobile_max_width'],
		esc_attr( $s['object_fit'] )
	);

	$handle = 'promovads-demo-colors';
	if ( ! wp_style_is( $handle, 'enqueued' ) ) {
		$handle = wp_style_is( 'promovads-demo-fixes', 'enqueued' ) ? 'promovads-demo-fixes' : 'promovads-style';
	}
	wp_add_inline_style( $handle, $css );
}
add_action( 'wp_enqueue_scripts', 'promovads_logo_css', 31 );

/**
 * Logo admin page.
 */
function promovads_admin_logo_page(): void {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	if ( isset( $_POST['promovads_logo_save'] ) && check_admin_referer( 'promovads_logo' ) ) {
		promovads_save_logo_settings_from_post();
		echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'تم حفظ إعدادات الشعار.', 'promovads' ) . '</p></div>';
	}

	if ( isset( $_POST['promovads_logo_reset'] ) && check_admin_referer( 'promovads_logo' ) ) {
		promovads_reset_logo_settings();
		echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'تمت إعادة إعدادات الشعار للافتراضي.', 'promovads' ) . '</p></div>';
	}

	$s      = promovads_get_logo_settings();
	$schema = promovads_logo_settings_schema();
	?>
	<div class="wrap pds-admin">
		<div class="pds-admin__head">
			<h1><?php esc_html_e( 'نظام الشعار', 'promovads' ); ?></h1>
			<p><?php esc_html_e( 'تحكم كامل في شعار الهيدر، الفوتر، الموبايل، Favicon، الأبعاد، والرابط.', 'promovads' ); ?></p>
		</div>

		<form method="post" class="pds-logo-form">
			<?php wp_nonce_field( 'promovads_logo' ); ?>

			<div class="pds-branding-layout">
				<div class="pds-branding-main">
					<?php foreach ( $schema as $group_key => $group ) : ?>
						<div class="pds-branding-card pds-logo-group" data-group="<?php echo esc_attr( $group_key ); ?>">
							<h2><?php echo esc_html( $group['label'] ); ?></h2>
							<div class="pds-logo-fields">
								<?php foreach ( $group['fields'] as $field_key => $field ) :
									$val = $s[ $field_key ] ?? ( $field['default'] ?? '' );
									$depends = $field['depends'] ?? '';
									?>
									<div class="pds-logo-field" data-field="<?php echo esc_attr( $field_key ); ?>" <?php echo $depends ? 'data-depends="' . esc_attr( $depends ) . '"' : ''; ?>>
										<span class="pds-logo-field__label"><?php echo esc_html( $field['label'] ); ?></span>
										<?php if ( ! empty( $field['desc'] ) ) : ?>
											<span class="pds-color-field__desc"><?php echo esc_html( $field['desc'] ); ?></span>
										<?php endif; ?>

										<?php if ( 'image' === $field['type'] ) :
											$img_url = $val ? wp_get_attachment_image_url( (int) $val, 'medium' ) : '';
											?>
											<div class="pds-logo-preview-sm" id="preview-<?php echo esc_attr( $field_key ); ?>">
												<?php if ( $img_url ) : ?>
													<img src="<?php echo esc_url( $img_url ); ?>" alt="">
												<?php else : ?>
													<span><?php esc_html_e( 'لا توجد صورة', 'promovads' ); ?></span>
												<?php endif; ?>
											</div>
											<input type="hidden" name="pds_logo_<?php echo esc_attr( $field_key ); ?>" id="pds_logo_<?php echo esc_attr( $field_key ); ?>" value="<?php echo esc_attr( (int) $val ); ?>">
											<p>
												<button type="button" class="button pds-logo-upload" data-target="<?php echo esc_attr( $field_key ); ?>"><?php esc_html_e( 'رفع', 'promovads' ); ?></button>
												<button type="button" class="button pds-logo-remove" data-target="<?php echo esc_attr( $field_key ); ?>"><?php esc_html_e( 'إزالة', 'promovads' ); ?></button>
											</p>
										<?php elseif ( 'number' === $field['type'] ) : ?>
											<input type="number" name="pds_logo_<?php echo esc_attr( $field_key ); ?>" value="<?php echo esc_attr( (int) $val ); ?>" min="<?php echo esc_attr( $field['min'] ); ?>" max="<?php echo esc_attr( $field['max'] ); ?>" class="pds-logo-number" data-preview="<?php echo esc_attr( str_replace( array( 'header_', 'footer_', 'mobile_' ), '', $field_key ) ); ?>">
										<?php elseif ( 'checkbox' === $field['type'] ) : ?>
											<label class="pds-logo-check">
												<input type="checkbox" name="pds_logo_<?php echo esc_attr( $field_key ); ?>" value="1" <?php checked( (int) $val, 1 ); ?> class="pds-logo-toggle" data-target="<?php echo esc_attr( $field_key ); ?>">
												<?php echo esc_html( $field['label'] ); ?>
											</label>
										<?php elseif ( 'url' === $field['type'] ) : ?>
											<input type="url" name="pds_logo_<?php echo esc_attr( $field_key ); ?>" value="<?php echo esc_attr( $val ); ?>" placeholder="<?php echo esc_attr( $field['placeholder'] ?? '' ); ?>" class="regular-text">
										<?php elseif ( 'text' === $field['type'] ) : ?>
											<input type="text" name="pds_logo_<?php echo esc_attr( $field_key ); ?>" value="<?php echo esc_attr( $val ); ?>" placeholder="<?php echo esc_attr( $field['placeholder'] ?? '' ); ?>" class="regular-text">
										<?php elseif ( 'select' === $field['type'] ) : ?>
											<select name="pds_logo_<?php echo esc_attr( $field_key ); ?>">
												<?php foreach ( $field['options'] as $opt_val => $opt_label ) : ?>
													<option value="<?php echo esc_attr( $opt_val ); ?>" <?php selected( $val, $opt_val ); ?>><?php echo esc_html( $opt_label ); ?></option>
												<?php endforeach; ?>
											</select>
										<?php endif; ?>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>

				<div class="pds-branding-preview-wrap">
					<div class="pds-branding-card pds-live-preview">
						<h2><?php esc_html_e( 'معاينة الشعار', 'promovads' ); ?></h2>
						<div class="pds-logo-live-preview" id="pds-logo-live-preview">
							<div class="pds-lp-section">
								<strong><?php esc_html_e( 'الهيدر', 'promovads' ); ?></strong>
								<div class="pds-lp-header" id="pds-lp-header">
									<img src="" alt="" class="pds-lp-img pds-lp-img--header" id="pds-lp-header-img" hidden>
									<span class="pds-lp-placeholder" id="pds-lp-header-ph"><?php esc_html_e( 'شعار الهيدر', 'promovads' ); ?></span>
								</div>
							</div>
							<div class="pds-lp-section">
								<strong><?php esc_html_e( 'الفوتر', 'promovads' ); ?></strong>
								<div class="pds-lp-footer" id="pds-lp-footer">
									<img src="" alt="" class="pds-lp-img pds-lp-img--footer" id="pds-lp-footer-img" hidden>
									<span class="pds-lp-placeholder" id="pds-lp-footer-ph"><?php esc_html_e( 'شعار الفوتر', 'promovads' ); ?></span>
								</div>
							</div>
							<div class="pds-lp-section">
								<strong><?php esc_html_e( 'الموبايل', 'promovads' ); ?></strong>
								<div class="pds-lp-mobile" id="pds-lp-mobile">
									<img src="" alt="" class="pds-lp-img pds-lp-img--mobile" id="pds-lp-mobile-img" hidden>
									<span class="pds-lp-placeholder" id="pds-lp-mobile-ph"><?php esc_html_e( 'شعار الموبايل', 'promovads' ); ?></span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<p class="submit">
				<button type="submit" name="promovads_logo_save" class="button button-primary button-hero"><?php esc_html_e( 'حفظ إعدادات الشعار', 'promovads' ); ?></button>
				<button type="submit" name="promovads_logo_reset" class="button button-secondary" onclick="return confirm('<?php echo esc_js( __( 'إعادة جميع إعدادات الشعار؟', 'promovads' ) ); ?>');"><?php esc_html_e( 'إعادة للافتراضي', 'promovads' ); ?></button>
			</p>
		</form>
	</div>
	<?php
}
