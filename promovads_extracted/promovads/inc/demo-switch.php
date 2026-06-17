<?php
/**
 * Demo switch — purge old demo data + install new demo assets.
 *
 * @package PromovaDS_News
 */

defined( 'ABSPATH' ) || exit;

/**
 * Uploads subdirectory for installed demo cache.
 */
function promovads_demo_uploads_base(): string {
	$upload = wp_upload_dir();
	return trailingslashit( $upload['basedir'] ) . 'promovads-demos';
}

/**
 * Theme mods cleared when switching demos (logo is kept).
 *
 * @return string[]
 */
function promovads_demo_switch_theme_mods(): array {
	return array(
		'promovads_active_demo',
		'promovads_nav_source',
		'promovads_color_primary',
		'promovads_color_secondary',
		'promovads_color_accent',
		'promovads_use_custom_colors',
		'promovads_rtl_mode',
		'promovads_show_ticker',
		'promovads_show_topbar',
		'promovads_sticky_header',
		'promovads_ticker_label',
		'promovads_ticker_category',
		'promovads_dark_mode_default',
		'promovads_edition_badge',
	);
}

/**
 * Sidebar IDs reset on demo switch.
 *
 * @return string[]
 */
function promovads_demo_sidebar_ids(): array {
	return array(
		'sidebar-main',
		'sidebar-archive',
		'sidebar-shop',
		'footer-1',
		'footer-2',
		'footer-3',
	);
}

/**
 * Recursively delete a directory.
 */
function promovads_delete_directory( string $dir ): bool {
	if ( ! is_dir( $dir ) ) {
		return true;
	}

	$items = scandir( $dir );
	if ( false === $items ) {
		return false;
	}

	foreach ( $items as $item ) {
		if ( in_array( $item, array( '.', '..' ), true ) ) {
			continue;
		}
		$path = $dir . DIRECTORY_SEPARATOR . $item;
		if ( is_dir( $path ) ) {
			promovads_delete_directory( $path );
		} else {
			wp_delete_file( $path );
		}
	}

	return rmdir( $dir );
}

/**
 * Clear all stored demo install options/transients.
 */
function promovads_clear_all_demo_options(): int {
	global $wpdb;

	$cleared = 0;

	$options = $wpdb->get_col(
		"SELECT option_name FROM {$wpdb->options}
		WHERE option_name LIKE 'promovads_demo_%'
		OR option_name LIKE '_transient_promovads_demo_%'
		OR option_name LIKE '_transient_timeout_promovads_demo_%'"
	);

	if ( is_array( $options ) ) {
		foreach ( $options as $option_name ) {
			if ( delete_option( $option_name ) ) {
				$cleared++;
			}
		}
	}

	return $cleared;
}

/**
 * Remove all data related to a demo slug.
 *
 * Does NOT delete WordPress posts, pages, or categories — only demo/theme state.
 *
 * @return array{removed_dirs:int, cleared_mods:int, cleared_widgets:bool, cleared_options:int}
 */
function promovads_purge_old_demo( string $old_slug ): array {
	$old_slug = sanitize_key( $old_slug );
	$result   = array(
		'removed_dirs'    => 0,
		'cleared_mods'    => 0,
		'cleared_widgets' => false,
		'cleared_options' => 0,
	);

	// Remove entire cached demos folder (all old demo files).
	$base_dir = promovads_demo_uploads_base();
	if ( is_dir( $base_dir ) ) {
		promovads_delete_directory( $base_dir );
		$result['removed_dirs'] = 1;
	}

	$result['cleared_options'] = promovads_clear_all_demo_options();

	// Demo-specific theme mods.
	foreach ( promovads_demo_switch_theme_mods() as $mod ) {
		remove_theme_mod( $mod );
		$result['cleared_mods']++;
	}

	// Nav menu locations (demo menus from OCDI).
	$locations = get_theme_mod( 'nav_menu_locations', array() );
	if ( ! empty( $locations ) ) {
		set_theme_mod( 'nav_menu_locations', array() );
	}

	// Widgets in theme sidebars.
	$all_widgets = wp_get_sidebars_widgets();
	if ( is_array( $all_widgets ) ) {
		foreach ( promovads_demo_sidebar_ids() as $sidebar_id ) {
			if ( isset( $all_widgets[ $sidebar_id ] ) ) {
				$all_widgets[ $sidebar_id ] = array();
			}
		}
		wp_set_sidebars_widgets( $all_widgets );
		$result['cleared_widgets'] = true;
	}

	// Homepage reading settings tied to old demo import.
	update_option( 'show_on_front', 'posts' );
	update_option( 'page_on_front', 0 );
	update_option( 'page_for_posts', 0 );

	/**
	 * Fires after old demo data is purged.
	 *
	 * @param string $old_slug Previous demo slug.
	 * @param array  $result   Purge summary.
	 */
	do_action( 'promovads_after_demo_purge', $old_slug, $result );

	return $result;
}

/**
 * Copy demo asset files from theme into uploads cache (installed manifest).
 *
 * @return array{success:bool, slug:string, files:array, errors:array}
 */
function promovads_install_demo_assets( string $slug ): array {
	$slug   = sanitize_key( $slug );
	$config = promovads_get_demo_config( $slug );

	$result = array(
		'success' => false,
		'slug'    => $slug,
		'files'   => array(),
		'errors'  => array(),
	);

	if ( ! $config ) {
		$result['errors'][] = __( 'Demo not found in registry.', 'promovads' );
		return $result;
	}

	$css_slug = promovads_demo_css_slug( $slug );

	$theme_files = array(
		'demo.css'            => PROMOVADS_DIR . '/assets/css/demos/' . $css_slug . '.css',
		'pds-core.css'        => PROMOVADS_DIR . '/assets/css/pds-core.css',
		'demo-shared.css'     => PROMOVADS_DIR . '/assets/css/demo-shared.css',
		'demo-front-fixes.css'=> PROMOVADS_DIR . '/assets/css/demo-front-fixes.css',
		'nav-overflow.js'     => PROMOVADS_DIR . '/assets/js/nav-overflow.js',
		'demo-ui.js'          => PROMOVADS_DIR . '/assets/js/demo-ui.js',
	);

	$template_files = array(
		'home.php' => PROMOVADS_DIR . '/demo-content/' . $slug . '/home.php',
	);

	foreach ( $theme_files as $name => $path ) {
		if ( ! file_exists( $path ) ) {
			$result['errors'][] = sprintf(
				/* translators: %s: file path */
				__( 'Missing theme file: %s', 'promovads' ),
				$name
			);
		}
	}

	if ( ! empty( $result['errors'] ) ) {
		return $result;
	}

	$dest_dir = promovads_demo_uploads_base() . '/' . $slug;
	wp_mkdir_p( $dest_dir );

	$copied = array();
	foreach ( $theme_files as $name => $path ) {
		$dest = $dest_dir . '/' . $name;
		if ( copy( $path, $dest ) ) {
			$copied[] = $name;
		} else {
			$result['errors'][] = sprintf(
				__( 'Could not copy: %s', 'promovads' ),
				$name
			);
		}
	}

	// Copy home template if exists.
	foreach ( $template_files as $name => $path ) {
		if ( file_exists( $path ) ) {
			$dest = $dest_dir . '/templates/' . $name;
			wp_mkdir_p( dirname( $dest ) );
			if ( copy( $path, $dest ) ) {
				$copied[] = 'templates/' . $name;
			}
		}
	}

	$manifest = array(
		'slug'         => $slug,
		'label'        => $config['label'] ?? $slug,
		'prefix'       => $config['prefix'] ?? '',
		'installed_at' => current_time( 'mysql' ),
		'theme_version'=> PROMOVADS_VERSION,
		'files'        => $copied,
	);

	file_put_contents( $dest_dir . '/manifest.json', wp_json_encode( $manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE ) );

	update_option( 'promovads_demo_installed_' . $slug, time() );
	update_option( 'promovads_demo_manifest_' . $slug, $manifest );
	set_transient( 'promovads_demo_assets_' . $slug, $manifest, WEEK_IN_SECONDS );

	$result['files']   = $copied;
	$result['success'] = empty( $result['errors'] );

	/**
	 * Fires after new demo assets are installed to uploads cache.
	 *
	 * @param string $slug     Demo slug.
	 * @param array  $manifest Install manifest.
	 */
	do_action( 'promovads_after_demo_install', $slug, $manifest );

	return $result;
}

/**
 * Apply default settings for a demo from registry.
 */
function promovads_apply_demo_defaults( string $slug ): void {
	$config = promovads_get_demo_config( $slug );
	if ( ! $config ) {
		return;
	}

	set_theme_mod( 'promovads_active_demo', $slug );
	set_theme_mod( 'promovads_nav_source', 'categories' );
	set_theme_mod( 'promovads_rtl_mode', 'rtl' );
	set_theme_mod( 'promovads_show_ticker', 1 );
	set_theme_mod( 'promovads_show_topbar', 1 );
	set_theme_mod( 'promovads_sticky_header', 0 );
	set_theme_mod( 'promovads_ticker_label', __( 'عاجل', 'promovads' ) );
	set_theme_mod( 'promovads_color_primary', $config['primary'] ?? '#6366f1' );
	set_theme_mod( 'promovads_color_secondary', $config['secondary'] ?? '#0f172a' );
	set_theme_mod( 'promovads_color_accent', $config['accent'] ?? '#06b6d4' );
	promovads_reset_color_palette();
	promovads_reset_demo_skins( $slug );

	update_option( 'show_on_front', 'posts' );
	update_option( 'page_on_front', 0 );
	update_option( 'page_for_posts', 0 );
}

/**
 * Full demo switch: purge old → install new → apply defaults.
 *
 * @return array{ok:bool, old:string, new:string, purge:array, install:array}
 */
function promovads_switch_demo( string $new_slug ): array {
	$new_slug = sanitize_key( $new_slug );
	$old_slug = promovads_active_demo();

	if ( ! promovads_get_demo_config( $new_slug ) ) {
		return array(
			'ok'      => false,
			'old'     => $old_slug,
			'new'     => $new_slug,
			'purge'   => array(),
			'install' => array( 'success' => false, 'errors' => array( __( 'Invalid demo.', 'promovads' ) ) ),
		);
	}

	$purge = promovads_purge_old_demo( $old_slug ?: $new_slug );

	$install = promovads_install_demo_assets( $new_slug );

	if ( $install['success'] ) {
		promovads_apply_demo_defaults( $new_slug );
		flush_rewrite_rules();
		wp_cache_flush();
	}

	return array(
		'ok'      => $install['success'],
		'old'     => $old_slug,
		'new'     => $new_slug,
		'purge'   => $purge,
		'install' => $install,
	);
}
