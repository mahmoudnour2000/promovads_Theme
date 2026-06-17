<?php
/**
 * PromovaDS Theme Admin Panel
 *
 * @package PromovaDS_News
 */

defined( 'ABSPATH' ) || exit;

define( 'PROMOVADS_ADMIN_SLUG', 'promovads-theme' );

/**
 * Register top-level admin menu.
 */
function promovads_admin_menu(): void {
	add_menu_page(
		esc_html__( 'PromovaDS', 'promovads' ),
		esc_html__( 'PromovaDS', 'promovads' ),
		'manage_options',
		PROMOVADS_ADMIN_SLUG,
		'promovads_admin_demo_page',
		'dashicons-layout',
		59
	);

	add_submenu_page(
		PROMOVADS_ADMIN_SLUG,
		esc_html__( 'استيراد الديمو', 'promovads' ),
		esc_html__( 'استيراد الديمو', 'promovads' ),
		'manage_options',
		PROMOVADS_ADMIN_SLUG,
		'promovads_admin_demo_page'
	);

	add_submenu_page(
		PROMOVADS_ADMIN_SLUG,
		esc_html__( 'نماذج التصميم', 'promovads' ),
		esc_html__( 'نماذج التصميم', 'promovads' ),
		'manage_options',
		PROMOVADS_ADMIN_SLUG . '-skins',
		'promovads_admin_skin_page'
	);

	add_submenu_page(
		PROMOVADS_ADMIN_SLUG,
		esc_html__( 'الشعار', 'promovads' ),
		esc_html__( 'الشعار', 'promovads' ),
		'manage_options',
		PROMOVADS_ADMIN_SLUG . '-logo',
		'promovads_admin_logo_page'
	);

	add_submenu_page(
		PROMOVADS_ADMIN_SLUG,
		esc_html__( 'الألوان', 'promovads' ),
		esc_html__( 'الألوان', 'promovads' ),
		'manage_options',
		PROMOVADS_ADMIN_SLUG . '-branding',
		'promovads_admin_branding_page'
	);
}
add_action( 'admin_menu', 'promovads_admin_menu' );

/**
 * Admin assets.
 */
function promovads_admin_panel_assets( string $hook ): void {
	if ( ! str_contains( $hook, PROMOVADS_ADMIN_SLUG ) ) {
		return;
	}

	wp_enqueue_media();
	wp_enqueue_style(
		'promovads-admin-icons',
		'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css',
		array(),
		'6.5.0'
	);
	wp_enqueue_style(
		'promovads-admin-panel',
		PROMOVADS_URI . '/assets/css/admin-panel.css',
		array(),
		PROMOVADS_VERSION
	);

	if ( str_contains( $hook, PROMOVADS_ADMIN_SLUG . '-skins' ) ) {
		wp_enqueue_style(
			'promovads-admin-skins',
			PROMOVADS_URI . '/assets/css/admin-skins.css',
			array( 'promovads-admin-panel' ),
			PROMOVADS_VERSION
		);
	}
	wp_enqueue_script(
		'promovads-admin-panel',
		PROMOVADS_URI . '/assets/js/admin-panel.js',
		array( 'jquery' ),
		PROMOVADS_VERSION,
		true
	);
	wp_localize_script(
		'promovads-admin-panel',
		'promovadsAdmin',
		array(
			'confirmSwitch' => __( 'سيتم حذف جميع إعدادات وملفات الديمو الحالي ثم تثبيت الديمو الجديد من جديد. هل تريد المتابعة؟', 'promovads' ),
			'confirmReinstall' => __( 'سيتم حذف ملفات الديمو الحالي وإعادة تثبيته من جديد. هل تريد المتابعة؟', 'promovads' ),
		)
	);
}
add_action( 'admin_enqueue_scripts', 'promovads_admin_panel_assets' );

/**
 * Render admin notice after demo switch.
 */
function promovads_render_switch_notice( array $result ): void {
	if ( empty( $result['ok'] ) ) {
		$errors = $result['install']['errors'] ?? array( __( 'فشل تثبيت الديمو.', 'promovads' ) );
		echo '<div class="notice notice-error is-dismissible"><p><strong>' . esc_html__( 'فشل تبديل الديمو', 'promovads' ) . '</strong></p><ul>';
		foreach ( (array) $errors as $err ) {
			echo '<li>' . esc_html( $err ) . '</li>';
		}
		echo '</ul></div>';
		return;
	}

	$new_config = promovads_get_demo_config( $result['new'] ?? '' );
	$label      = $new_config['label'] ?? ( $result['new'] ?? '' );
	$file_count = count( $result['install']['files'] ?? array() );
	$purge      = $result['purge'] ?? array();

	echo '<div class="notice notice-success is-dismissible">';
	echo '<p><strong>' . esc_html__( 'تم تبديل الديمو بنجاح!', 'promovads' ) . '</strong> ';
	echo esc_html(
		sprintf(
			/* translators: %s: demo name */
			__( 'الديمو النشط الآن: %s', 'promovads' ),
			$label
		)
	);
	echo '</p><ul>';
	echo '<li>' . esc_html(
		sprintf(
			/* translators: %d: number of deleted cache folders */
			__( 'تم حذف ملفات الديمو القديم (%d مجلد).', 'promovads' ),
			(int) ( $purge['removed_dirs'] ?? 0 )
		)
	) . '</li>';
	echo '<li>' . esc_html(
		sprintf(
			/* translators: %d: number of cleared theme mods */
			__( 'تم مسح إعدادات الديمو السابق (%d إعداد).', 'promovads' ),
			(int) ( $purge['cleared_mods'] ?? 0 )
		)
	) . '</li>';
	echo '<li>' . esc_html(
		sprintf(
			/* translators: %d: number of installed files */
			__( 'تم تنزيل وتثبيت %d ملف للديمو الجديد.', 'promovads' ),
			$file_count
		)
	) . '</li>';
	echo '<li>' . esc_html__( 'المحتوى يُعرض من مقالات وتصنيفات WordPress — لم تُحذف أي مقالات.', 'promovads' ) . '</li>';
	echo '</ul></div>';
}

/**
 * Demo import page.
 */
function promovads_admin_demo_page(): void {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	if ( isset( $_GET['activate'] ) && check_admin_referer( 'promovads_activate_demo' ) ) {
		$demo = sanitize_key( wp_unslash( $_GET['activate'] ) );
		if ( $demo ) {
			$result = promovads_activate_demo_layout( $demo );
			promovads_set_last_switch_result( $result );
			wp_safe_redirect( admin_url( 'admin.php?page=' . PROMOVADS_ADMIN_SLUG . '&switched=1' ) );
			exit;
		}
	}

	if ( isset( $_GET['switched'] ) ) {
		$result = promovads_get_last_switch_result();
		if ( $result ) {
			promovads_render_switch_notice( $result );
			promovads_clear_last_switch_result();
		}
	}

	$active = promovads_active_demo();
	?>
	<div class="wrap pds-admin">
		<div class="pds-admin__head">
			<h1><?php esc_html_e( 'استيراد الديمو', 'promovads' ); ?></h1>
			<p><?php esc_html_e( 'اختر تصميم الديمو — عند التبديل يُحذف الديمو القديم بالكامل (الإعدادات والملفات) ويُثبّت الديمو الجديد. المحتوى من مقالات WordPress لا يُحذف.', 'promovads' ); ?></p>
		</div>

		<?php if ( $active ) :
			$config = promovads_get_demo_config( $active );
			?>
			<div class="pds-admin__active">
				<strong><?php esc_html_e( 'الديمو النشط:', 'promovads' ); ?></strong>
				<?php echo esc_html( $config['label'] ?? $active ); ?>
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=' . PROMOVADS_ADMIN_SLUG . '-skins' ) ); ?>" class="button"><?php esc_html_e( 'نماذج التصميم', 'promovads' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="button" target="_blank"><?php esc_html_e( 'معاينة الموقع', 'promovads' ); ?></a>
			</div>
		<?php endif; ?>

		<div class="pds-admin__demos">
			<?php
			foreach ( promovads_get_demo_registry() as $slug => $info ) :
				if ( empty( $info['label'] ) || 'cooking' === $slug ) {
					continue;
				}
				$is_active = ( $active === $slug );
				$color     = $info['primary'] ?? '#6366f1';
				$url       = wp_nonce_url( admin_url( 'admin.php?page=' . PROMOVADS_ADMIN_SLUG . '&activate=' . $slug ), 'promovads_activate_demo' );
				?>
				<div class="pds-demo-card<?php echo $is_active ? ' is-active' : ''; ?>">
					<div class="pds-demo-card__banner" style="background:<?php echo esc_attr( $color ); ?>">
						<i class="<?php echo esc_attr( str_starts_with( $info['logo_icon'] ?? '', 'fab' ) ? esc_attr( $info['logo_icon'] ) : 'fas ' . esc_attr( $info['logo_icon'] ?? 'fa-newspaper' ) ); ?>"></i>
						<span><?php echo esc_html( $info['label'] ); ?></span>
					</div>
					<div class="pds-demo-card__body">
						<p class="pds-demo-card__desc"><?php echo esc_html( $info['tagline'] ?? '' ); ?></p>
						<?php if ( $is_active ) : ?>
							<a href="<?php echo esc_url( $url ); ?>" class="button pds-demo-reinstall" style="width:100%;text-align:center" data-reinstall="1"><?php esc_html_e( 'إعادة تثبيت الديمو', 'promovads' ); ?></a>
						<?php else : ?>
							<a href="<?php echo esc_url( $url ); ?>" class="button button-primary pds-demo-switch" style="width:100%;text-align:center"><?php esc_html_e( 'تفعيل الديمو', 'promovads' ); ?></a>
						<?php endif; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
}

/**
 * Branding page — logo + colors.
 */
function promovads_admin_branding_page(): void {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	if ( isset( $_POST['promovads_branding_save'] ) && check_admin_referer( 'promovads_branding' ) ) {
		promovads_save_branding_settings();
		echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'تم حفظ الإعدادات بنجاح.', 'promovads' ) . '</p></div>';
	}

	if ( isset( $_POST['promovads_reset_colors'] ) && check_admin_referer( 'promovads_branding' ) ) {
		promovads_reset_color_palette();
		echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'تمت إعادة الألوان إلى إعدادات الديمو الافتراضية.', 'promovads' ) . '</p></div>';
	}

	$palette  = promovads_get_color_palette();
	$schema   = promovads_color_token_schema();
	?>
	<div class="wrap pds-admin">
		<div class="pds-admin__head">
			<h1><?php esc_html_e( 'نظام الألوان', 'promovads' ); ?></h1>
			<p><?php esc_html_e( 'تحكم في ألوان كل جزء من الديمو. لإعدادات الشعار انتقل إلى «الشعار».', 'promovads' ); ?> <a href="<?php echo esc_url( admin_url( 'admin.php?page=' . PROMOVADS_ADMIN_SLUG . '-logo' ) ); ?>"><?php esc_html_e( 'فتح إعدادات الشعار', 'promovads' ); ?></a></p>
		</div>

		<form method="post" class="pds-branding-form">
			<?php wp_nonce_field( 'promovads_branding' ); ?>

			<div class="pds-branding-layout">
				<div class="pds-branding-main">
					<?php foreach ( $schema as $group_key => $group ) : ?>
						<div class="pds-branding-card pds-color-group">
							<h2><?php echo esc_html( $group['label'] ); ?></h2>
							<div class="pds-color-grid">
								<?php foreach ( $group['tokens'] as $token_key => $token ) :
									$val = $palette[ $token_key ] ?? '#6366f1';
									$is_rgba = str_starts_with( (string) $val, 'rgba' );
									?>
									<label class="pds-color-field" data-token="<?php echo esc_attr( $token_key ); ?>">
										<span class="pds-color-field__label"><?php echo esc_html( $token['label'] ); ?></span>
										<?php if ( ! empty( $token['desc'] ) ) : ?>
											<span class="pds-color-field__desc"><?php echo esc_html( $token['desc'] ); ?></span>
										<?php endif; ?>
										<input type="color" name="pds_clr_<?php echo esc_attr( $token_key ); ?>" value="<?php echo esc_attr( $is_rgba ? '#0f172a' : $val ); ?>" class="pds-clr-input">
									</label>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>

				<div class="pds-branding-preview-wrap">
					<div class="pds-branding-card pds-live-preview" id="pds-live-preview">
						<h2><?php esc_html_e( 'معاينة مباشرة', 'promovads' ); ?></h2>
						<div class="pds-preview-site" id="pds-preview-site">
							<div class="pds-preview-topbar"><?php esc_html_e( 'شريط علوي', 'promovads' ); ?></div>
							<div class="pds-preview-header">
								<span class="pds-preview-logo"></span>
								<span class="pds-preview-nav"><?php esc_html_e( 'قائمة', 'promovads' ); ?></span>
								<span class="pds-preview-btn"><?php esc_html_e( 'زر', 'promovads' ); ?></span>
							</div>
							<div class="pds-preview-body">
								<div class="pds-preview-card">
									<div class="pds-preview-card__img"></div>
									<div class="pds-preview-card__title"><?php esc_html_e( 'عنوان مقال', 'promovads' ); ?></div>
									<div class="pds-preview-card__meta"><?php esc_html_e( 'نص ثانوي', 'promovads' ); ?></div>
								</div>
								<div class="pds-preview-widget">
									<div class="pds-preview-widget__title"><?php esc_html_e( 'ودجت', 'promovads' ); ?></div>
									<div class="pds-preview-widget__body"><?php esc_html_e( 'محتوى', 'promovads' ); ?></div>
								</div>
							</div>
							<div class="pds-preview-footer"><?php esc_html_e( 'فوتر', 'promovads' ); ?></div>
						</div>
					</div>
				</div>
			</div>

			<p class="submit">
				<button type="submit" name="promovads_branding_save" class="button button-primary button-hero"><?php esc_html_e( 'حفظ جميع الألوان', 'promovads' ); ?></button>
				<button type="submit" name="promovads_reset_colors" class="button button-secondary" onclick="return confirm('<?php echo esc_js( __( 'إعادة جميع الألوان إلى إعدادات الديمو؟', 'promovads' ) ); ?>');"><?php esc_html_e( 'إعادة للافتراضي', 'promovads' ); ?></button>
			</p>
		</form>
	</div>
	<?php
}

/**
 * Save branding from admin form.
 */
function promovads_save_branding_settings(): void {
	promovads_save_color_palette_from_post();
}

/**
 * Default primary color from active demo or fallback.
 */
function promovads_get_default_primary_color(): string {
	$config = promovads_get_demo_config();
	return $config['primary'] ?? '#6366f1';
}

/**
 * Remove old theme submenu under Appearance.
 */
function promovads_remove_old_demo_page(): void {
	remove_submenu_page( 'themes.php', 'promovads-demo-import' );
}
add_action( 'admin_menu', 'promovads_remove_old_demo_page', 999 );
