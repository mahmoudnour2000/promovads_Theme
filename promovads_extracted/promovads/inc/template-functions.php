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
		$classes[] = 'pds-demo-active';
		$classes[] = 'pds-demo-' . $demo;
		$classes[] = 'demo-' . $demo;
		$classes[] = 'rtl-mode';
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
 * Category meta fields.
 */
function promovads_category_color_field( WP_Term $term ): void {
	$color    = get_term_meta( $term->term_id, 'pds_color', true );
	$icon     = get_term_meta( $term->term_id, 'pds_icon', true );
	$hide_nav = get_term_meta( $term->term_id, 'pds_hide_nav', true );
	?>
	<tr class="form-field">
		<th scope="row"><label for="pds_color"><?php esc_html_e( 'Category Color', 'promovads' ); ?></label></th>
		<td>
			<input type="color" id="pds_color" name="pds_color" value="<?php echo esc_attr( $color ?: '#6366f1' ); ?>">
			<p class="description"><?php esc_html_e( 'Used for badges and nav accent.', 'promovads' ); ?></p>
		</td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="pds_icon"><?php esc_html_e( 'Icon Class', 'promovads' ); ?></label></th>
		<td>
			<input type="text" id="pds_icon" name="pds_icon" value="<?php echo esc_attr( $icon ); ?>" class="regular-text" placeholder="fa-brain">
			<p class="description"><?php esc_html_e( 'Font Awesome class without fas prefix (e.g. fa-brain).', 'promovads' ); ?></p>
		</td>
	</tr>
	<tr class="form-field">
		<th scope="row"><?php esc_html_e( 'Navigation', 'promovads' ); ?></th>
		<td>
			<label><input type="checkbox" name="pds_hide_nav" value="1" <?php checked( $hide_nav, '1' ); ?>> <?php esc_html_e( 'Hide from demo navigation', 'promovads' ); ?></label>
		</td>
	</tr>
	<?php
}
add_action( 'category_edit_form_fields', 'promovads_category_color_field' );

function promovads_category_add_fields(): void {
	?>
	<div class="form-field">
		<label for="pds_color"><?php esc_html_e( 'Category Color', 'promovads' ); ?></label>
		<input type="color" id="pds_color" name="pds_color" value="#6366f1">
	</div>
	<div class="form-field">
		<label for="pds_icon"><?php esc_html_e( 'Icon Class', 'promovads' ); ?></label>
		<input type="text" id="pds_icon" name="pds_icon" value="" placeholder="fa-folder">
	</div>
	<?php
}
add_action( 'category_add_form_fields', 'promovads_category_add_fields' );

function promovads_save_category_color( int $term_id ): void {
	if ( isset( $_POST['pds_color'] ) ) {
		update_term_meta( $term_id, 'pds_color', sanitize_hex_color( wp_unslash( $_POST['pds_color'] ) ) );
	}
	if ( isset( $_POST['pds_icon'] ) ) {
		update_term_meta( $term_id, 'pds_icon', sanitize_text_field( wp_unslash( $_POST['pds_icon'] ) ) );
	}
	$hide = isset( $_POST['pds_hide_nav'] ) ? '1' : '';
	update_term_meta( $term_id, 'pds_hide_nav', $hide );
}
add_action( 'edited_category', 'promovads_save_category_color' );
add_action( 'created_category', 'promovads_save_category_color' );

/**
 * Post meta: featured / breaking flags.
 */
function promovads_post_flags_meta_box(): void {
	add_meta_box(
		'pds-post-flags',
		esc_html__( 'PromovaDS Flags', 'promovads' ),
		'promovads_post_flags_meta_box_render',
		'post',
		'side',
		'high'
	);
}
add_action( 'add_meta_boxes', 'promovads_post_flags_meta_box' );

function promovads_post_flags_meta_box_render( WP_Post $post ): void {
	wp_nonce_field( 'promovads_post_flags', 'pds_post_flags_nonce' );
	$featured = get_post_meta( $post->ID, 'pds_featured', true );
	$breaking = get_post_meta( $post->ID, 'pds_breaking', true );
	?>
	<p><label><input type="checkbox" name="pds_featured" value="1" <?php checked( $featured, '1' ); ?>> <?php esc_html_e( 'Featured (Hero)', 'promovads' ); ?></label></p>
	<p><label><input type="checkbox" name="pds_breaking" value="1" <?php checked( $breaking, '1' ); ?>> <?php esc_html_e( 'Breaking / Ticker', 'promovads' ); ?></label></p>
	<?php
}

function promovads_save_post_flags( int $post_id ): void {
	if ( ! isset( $_POST['pds_post_flags_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pds_post_flags_nonce'] ) ), 'promovads_post_flags' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	update_post_meta( $post_id, 'pds_featured', isset( $_POST['pds_featured'] ) ? '1' : '' );
	update_post_meta( $post_id, 'pds_breaking', isset( $_POST['pds_breaking'] ) ? '1' : '' );
}
add_action( 'save_post_post', 'promovads_save_post_flags' );


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
		$query->set( 'post_type', array( 'post' ) );
	}
}
add_action( 'pre_get_posts', 'promovads_search_query' );

/**
 * Virtual /news/ archive for all posts.
 */
function promovads_register_news_archive_route(): void {
	add_rewrite_rule( '^news/?$', 'index.php?promovads_news=1', 'top' );
}
add_action( 'init', 'promovads_register_news_archive_route' );

function promovads_news_query_var( array $vars ): array {
	$vars[] = 'promovads_news';
	return $vars;
}
add_filter( 'query_vars', 'promovads_news_query_var' );

function promovads_news_archive_query( WP_Query $query ): void {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}
	if ( '1' !== get_query_var( 'promovads_news', '' ) ) {
		return;
	}
	$query->set( 'post_type', 'post' );
	$query->set( 'posts_per_page', 12 );
}
add_action( 'pre_get_posts', 'promovads_news_archive_query' );

function promovads_news_archive_template( string $template ): string {
	if ( '1' === get_query_var( 'promovads_news', '' ) ) {
		$archive = locate_template( 'archive.php' );
		if ( $archive ) {
			return $archive;
		}
	}
	return $template;
}
add_filter( 'template_include', 'promovads_news_archive_template' );

function promovads_flush_rewrite_on_setup(): void {
	promovads_register_news_archive_route();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'promovads_flush_rewrite_on_setup' );

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

/**
 * Strip Table of Contents plugin debug output from post content.
 */
function promovads_strip_toc_debug_output( string $content ): string {
	if ( is_admin() || ! is_singular() ) {
		return $content;
	}

	// Easy Table of Contents debug block (shown to admins when WP_DEBUG_DISPLAY is on).
	$content = preg_replace( '/<div class=[\'"]ez-toc-debug-messages[\'"]>[\s\S]*?<\/div>/iu', '', $content );
	$content = preg_replace( '/<div class=[\'"]ez-toc-debug-message[\'"]>[\s\S]*?<\/div>/iu', '', $content );

	$markers = array(
		'You are seeing the following because WP_DEBUG',
		'Found headings',
		'Replace found headings with',
		'Insert TOC at position',
		'Insert TOC before first eligible heading',
		"The 'the_content' filter applied",
		'Auto insert enabled and disable TOC',
		'Is auto insert for post types',
		'Is supported post type',
	);

	$hits = 0;
	foreach ( $markers as $marker ) {
		if ( str_contains( $content, $marker ) ) {
			++$hits;
		}
	}

	if ( $hits < 2 ) {
		return $content;
	}

	$content = preg_replace( '/<div[^>]*\bez-toc-debug\b[^>]*>.*?<\/div>/is', '', $content );
	$content = preg_replace( '/<pre[^>]*>[\s\S]*?WP_DEBUG[\s\S]*?<\/pre>/iu', '', $content );

	foreach ( $markers as $marker ) {
		$content = preg_replace(
			'/<(p|div|pre|span|li|table|tr|td|blockquote|section)[^>]*>[\s\S]*?' . preg_quote( $marker, '/' ) . '[\s\S]*?<\/\1>/iu',
			'',
			$content
		);
	}

	// Remove leftover plain debug lines (with optional leading . or :).
	foreach ( $markers as $marker ) {
		$content = preg_replace( '/^[.:]?\s*' . preg_quote( $marker, '/' ) . '[^\n<]*\n?/imu', '', $content );
	}

	return trim( $content );
}
add_filter( 'the_content', 'promovads_strip_toc_debug_output', 99999 );

/**
 * Disable EZ TOC debug mode when supported by the plugin.
 */
function promovads_disable_ez_toc_debug( $value ) {
	return false;
}
add_filter( 'ez_toc_debug', 'promovads_disable_ez_toc_debug', 99 );
add_filter( 'ez_toc_get_option_debug', 'promovads_disable_ez_toc_debug', 99 );
add_filter( 'Eztoc/Table_Of_Contents/Debug/Display', 'promovads_disable_ez_toc_debug', 99 );
add_filter( 'Eztoc/Table_Of_Contents/Debug/Enabled', 'promovads_disable_ez_toc_debug', 99 );
