<?php
/**
 * Theme Template Functions
 *
 * @package PromovaDS_News
 */

defined( 'ABSPATH' ) || exit;

/**
 * Add body classes.
 */
function promovads_body_classes( array $classes ): array {

	if ( is_singular() ) {
		$classes[] = 'pds-single-post';
	}

	$demo = promovads_active_demo();
	if ( $demo ) {
		$classes[] = 'pds-demo-' . $demo;
	}

	if ( get_theme_mod( 'promovads_dark_mode_default', 0 ) ) {
		$classes[] = 'dark-mode';
	}

	if ( is_singular() ) {
		$classes[] = 'singular';
	}

	// RTL class for JS
	if ( is_rtl() ) {
		$classes[] = 'rtl-mode';
	}

	return $classes;
}
add_filter( 'body_class', 'promovads_body_classes' );

/**
 * Add post ID to body for JS view tracking.
 */
function promovads_body_attributes(): void {
	if ( is_singular() ) {
		echo ' data-post-id="' . esc_attr( get_the_ID() ) . '"';
	}
}
add_action( 'wp_body_open', function() {
	// handled via body_class filter above
} );

/**
 * Enhance wp_head: preload hero image.
 */
function promovads_preload_hero(): void {
	if ( ! is_singular() || ! has_post_thumbnail() ) {
		return;
	}

	$img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'promovads-hero' );
	if ( $img ) {
		printf(
			'<link rel="preload" as="image" href="%s" imagesrcset="" fetchpriority="high">%s',
			esc_url( $img[0] ),
			"\n"
		);
	}
}
add_action( 'wp_head', 'promovads_preload_hero', 2 );

/**
 * Category color meta in term edit screen.
 */
function promovads_category_color_field( WP_Term $term ): void {
	$color = get_term_meta( $term->term_id, 'pds_color', true );
	?>
	<tr class="form-field">
		<th scope="row"><label for="pds_color"><?php esc_html_e( 'Category Color', 'promovads' ); ?></label></th>
		<td>
			<input type="color" id="pds_color" name="pds_color" value="<?php echo esc_attr( $color ?: '#e63329' ); ?>">
			<p class="description"><?php esc_html_e( 'Used for category badge background.', 'promovads' ); ?></p>
		</td>
	</tr>
	<?php
}
add_action( 'category_edit_form_fields', 'promovads_category_color_field' );

/**
 * Save category color.
 */
function promovads_save_category_color( int $term_id ): void {
	if ( isset( $_POST['pds_color'] ) ) {
		update_term_meta( $term_id, 'pds_color', sanitize_hex_color( wp_unslash( $_POST['pds_color'] ) ) );
	}
}
add_action( 'edited_category', 'promovads_save_category_color' );

/**
 * Custom excerpt length.
 */
function promovads_excerpt_length( int $length ): int {
	return 20;
}
add_filter( 'excerpt_length', 'promovads_excerpt_length', 999 );

/**
 * Custom excerpt more.
 */
function promovads_excerpt_more( string $more ): string {
	return '...';
}
add_filter( 'excerpt_more', 'promovads_excerpt_more' );

/**
 * Modify search query to include CPTs.
 */
function promovads_search_query( WP_Query $query ): void {
	if ( ! is_admin() && $query->is_main_query() && $query->is_search() ) {
		$query->set(
			'post_type',
			array( 'post', 'pds_job', 'pds_review', 'pds_property', 'pds_course', 'pds_coin' )
		);
	}
}
add_action( 'pre_get_posts', 'promovads_search_query' );

/**
 * Allow SVG uploads for admins.
 */
function promovads_mime_types( array $mimes ): array {
	if ( current_user_can( 'manage_options' ) ) {
		$mimes['svg'] = 'image/svg+xml';
	}
	return $mimes;
}
add_filter( 'upload_mimes', 'promovads_mime_types' );

/**
 * Remove WordPress emoji scripts for performance.
 */
function promovads_disable_emojis(): void {
	remove_action( 'wp_head',             'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles',     'print_emoji_styles' );
	remove_action( 'admin_print_styles',  'print_emoji_styles' );
	remove_filter( 'the_content_feed',    'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss',    'wp_staticize_emoji' );
	remove_filter( 'wp_mail',            'wp_staticize_emoji_for_email' );
}
add_action( 'init', 'promovads_disable_emojis' );

/**
 * Remove query strings from static resources.
 */
function promovads_remove_script_version( string $src ): string {
	if ( strpos( $src, '?ver=' ) ) {
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
}
add_filter( 'style_loader_src',  'promovads_remove_script_version', 10 );
add_filter( 'script_loader_src', 'promovads_remove_script_version', 10 );
