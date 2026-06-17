<?php
/**
 * Demo Import — layout only, no static content.
 *
 * @package PromovaDS_News
 */

defined( 'ABSPATH' ) || exit;

function promovads_ocdi_import_files(): array {
	$registry = promovads_get_demo_registry();
	$imports  = array();

	foreach ( $registry as $slug => $info ) {
		if ( empty( $info['label'] ) || 'cooking' === $slug ) {
			continue;
		}

		$imports[] = array(
			'import_file_name'           => $info['label'],
			'categories'                 => array( esc_html__( 'PromovaDS', 'promovads' ) ),
			'import_preview_image_url'   => PROMOVADS_URI . '/assets/images/placeholder.jpg',
			'preview_url'                => home_url( '/' ),
		);
	}

	return $imports;
}
add_filter( 'pt-ocdi/import_files', 'promovads_ocdi_import_files' );

function promovads_ocdi_disable_content_import( $default ) {
	return 'no';
}
add_filter( 'pt-ocdi/disable_content_import', 'promovads_ocdi_disable_content_import' );

function promovads_ocdi_after_import( array $selected_import ): void {
	$name = $selected_import['import_file_name'] ?? '';
	$slug = '';

	foreach ( promovads_get_demo_registry() as $key => $info ) {
		if ( ( $info['label'] ?? '' ) === $name ) {
			$slug = $key;
			break;
		}
	}

	if ( $slug ) {
		promovads_activate_demo_layout( $slug );
	}
}
add_action( 'pt-ocdi/after_import', 'promovads_ocdi_after_import' );

/**
 * Activate / switch demo — purges old demo data then installs new demo files.
 *
 * @return array Switch result from promovads_switch_demo().
 */
function promovads_activate_demo_layout( string $slug ): array {
	return promovads_switch_demo( $slug );
}

/**
 * Store last switch result for admin notice.
 */
function promovads_set_last_switch_result( array $result ): void {
	set_transient( 'promovads_last_switch_' . get_current_user_id(), $result, 60 );
}

function promovads_get_last_switch_result(): ?array {
	$result = get_transient( 'promovads_last_switch_' . get_current_user_id() );
	return is_array( $result ) ? $result : null;
}

function promovads_clear_last_switch_result(): void {
	delete_transient( 'promovads_last_switch_' . get_current_user_id() );
}
