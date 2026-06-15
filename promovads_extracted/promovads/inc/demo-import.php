<?php
/**
 * One-Click Demo Import
 *
 * @package PromovaDS_News
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register OCDI demo configurations.
 * Compatible with "One Click Demo Import" plugin.
 */
function promovads_ocdi_import_files(): array {

	$demos = array(
		'tech-ai'     => esc_html__( 'Tech & AI', 'promovads' ),
		'jobs'        => esc_html__( 'Jobs Portal', 'promovads' ),
		'finance'     => esc_html__( 'Finance', 'promovads' ),
		'sports'      => esc_html__( 'Sports', 'promovads' ),
		'automotive'  => esc_html__( 'Automotive', 'promovads' ),
		'real-estate' => esc_html__( 'Real Estate', 'promovads' ),
		'health'      => esc_html__( 'Health', 'promovads' ),
		'education'   => esc_html__( 'Education', 'promovads' ),
		'crypto'      => esc_html__( 'Crypto', 'promovads' ),
		'gaming'      => esc_html__( 'Gaming', 'promovads' ),
	);

	$base    = PROMOVADS_URI . '/demo-content/';
	$imports = array();

	foreach ( $demos as $slug => $label ) {
		$imports[] = array(
			'import_file_name'             => $label,
			'categories'                   => array( esc_html__( 'PromovaDS', 'promovads' ) ),
			'import_file_url'              => $base . $slug . '/content.xml',
			'import_widget_file_url'       => $base . $slug . '/widgets.wie',
			'import_customizer_file_url'   => $base . $slug . '/customizer.dat',
			'preview_url'                  => 'https://promovads.com/demos/' . $slug,
		);
	}

	return $imports;
}
add_filter( 'pt-ocdi/import_files', 'promovads_ocdi_import_files' );

/**
 * After OCDI import: set menus, homepage, etc.
 */
function promovads_ocdi_after_import( array $selected_import ): void {

	$name  = $selected_import['import_file_name'] ?? '';
	$slug  = sanitize_key( $name );

	// Assign primary menu
	$nav_menu = get_term_by( 'name', 'Primary', 'nav_menu' );
	if ( $nav_menu ) {
		set_theme_mod( 'nav_menu_locations', array( 'primary' => $nav_menu->term_id ) );
	}

	// Set static front page
	$front_page = get_page_by_title( $name . ' Home' );
	if ( ! $front_page ) {
		$front_page = get_page_by_title( 'Home' );
	}

	if ( $front_page ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $front_page->ID );
	}

	// Activate demo
	set_theme_mod( 'promovads_active_demo', $slug );

	// Flush rewrite rules
	flush_rewrite_rules();
}
add_action( 'pt-ocdi/after_import', 'promovads_ocdi_after_import' );

/**
 * Admin page: Demo Import (fallback without OCDI plugin).
 */
function promovads_demo_import_page(): void {
	add_theme_page(
		esc_html__( 'Demo Import', 'promovads' ),
		esc_html__( 'Demo Import', 'promovads' ),
		'manage_options',
		'promovads-demo-import',
		'promovads_demo_import_render'
	);
}
add_action( 'admin_menu', 'promovads_demo_import_page' );

/**
 * Render demo import admin page.
 */
function promovads_demo_import_render(): void {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'PromovaDS Demo Import', 'promovads' ); ?></h1>
		<p><?php esc_html_e( 'For full one-click demo import, please install the "One Click Demo Import" plugin.', 'promovads' ); ?></p>

		<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:1.5rem;margin-top:2rem;">
			<?php
			$demos = array(
				'tech-ai'     => array( 'name' => 'Tech & AI',    'color' => '#6366f1' ),
				'jobs'        => array( 'name' => 'Jobs Portal',  'color' => '#0ea5e9' ),
				'finance'     => array( 'name' => 'Finance',      'color' => '#22c55e' ),
				'sports'      => array( 'name' => 'Sports',       'color' => '#f97316' ),
				'automotive'  => array( 'name' => 'Automotive',   'color' => '#ef4444' ),
				'real-estate' => array( 'name' => 'Real Estate',  'color' => '#8b5cf6' ),
				'health'      => array( 'name' => 'Health',       'color' => '#14b8a6' ),
				'education'   => array( 'name' => 'Education',    'color' => '#f59e0b' ),
				'crypto'      => array( 'name' => 'Crypto',       'color' => '#f7931a' ),
				'gaming'      => array( 'name' => 'Gaming',       'color' => '#a855f7' ),
			);

			foreach ( $demos as $slug => $info ) :
				$active = ( get_theme_mod( 'promovads_active_demo' ) === $slug ) ? 'border: 3px solid #0073aa;' : '';
				?>
				<div style="background:#fff;border:1px solid #ddd;border-radius:8px;overflow:hidden;<?php echo esc_attr( $active ); ?>">
					<div style="background:<?php echo esc_attr( $info['color'] ); ?>;height:80px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.5rem;font-weight:700;">
						<?php echo esc_html( $info['name'] ); ?>
					</div>
					<div style="padding:1rem;">
						<a href="<?php echo esc_url( admin_url( 'themes.php?page=promovads-demo-import&activate=' . $slug ) ); ?>"
						   class="button button-primary" style="width:100%;text-align:center;">
							<?php esc_html_e( 'Activate Layout', 'promovads' ); ?>
						</a>
					</div>
				</div>
				<?php
			endforeach;
			?>
		</div>
	</div>
	<?php

	// Handle activation
	if ( isset( $_GET['activate'] ) && current_user_can( 'manage_options' ) ) {
		$demo = sanitize_key( wp_unslash( $_GET['activate'] ) );
		if ( $demo ) {
			set_theme_mod( 'promovads_active_demo', $demo );
			echo '<div class="notice notice-success"><p>' . esc_html__( 'Demo layout activated!', 'promovads' ) . '</p></div>';
		}
	}
}
