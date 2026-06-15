<?php
/**
 * AJAX Handlers
 *
 * @package PromovaDS_News
 */

defined( 'ABSPATH' ) || exit;

/**
 * Ajax live search.
 */
function promovads_ajax_search(): void {
	check_ajax_referer( 'promovads_nonce', 'nonce' );

	$query = isset( $_POST['query'] ) ? sanitize_text_field( wp_unslash( $_POST['query'] ) ) : '';

	if ( strlen( $query ) < 2 ) {
		wp_send_json_success( array( 'results' => array() ) );
	}

	$posts = new WP_Query(
		array(
			's'                   => $query,
			'posts_per_page'      => 6,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
		)
	);

	$results = array();

	if ( $posts->have_posts() ) {
		while ( $posts->have_posts() ) {
			$posts->the_post();

			$thumb = '';
			if ( has_post_thumbnail() ) {
				$img   = wp_get_attachment_image_src( get_post_thumbnail_id(), 'promovads-small' );
				$thumb = $img ? $img[0] : '';
			}

			$results[] = array(
				'id'        => get_the_ID(),
				'title'     => get_the_title(),
				'url'       => get_permalink(),
				'date'      => get_the_date(),
				'category'  => get_the_category()[0]->name ?? '',
				'thumbnail' => $thumb,
				'excerpt'   => promovads_truncate( get_the_excerpt(), 80 ),
			);
		}
		wp_reset_postdata();
	}

	wp_send_json_success( array( 'results' => $results ) );
}
add_action( 'wp_ajax_promovads_search',        'promovads_ajax_search' );
add_action( 'wp_ajax_nopriv_promovads_search', 'promovads_ajax_search' );

/**
 * Ajax load more posts.
 */
function promovads_ajax_load_more(): void {
	check_ajax_referer( 'promovads_nonce', 'nonce' );

	$page     = isset( $_POST['page'] )     ? absint( $_POST['page'] )                         : 1;
	$per_page = isset( $_POST['per_page'] ) ? absint( $_POST['per_page'] )                     : 6;
	$cat      = isset( $_POST['cat'] )      ? absint( $_POST['cat'] )                          : 0;
	$tag      = isset( $_POST['tag'] )      ? sanitize_text_field( wp_unslash( $_POST['tag'] ) ) : '';

	$args = array(
		'posts_per_page'      => $per_page,
		'paged'               => $page,
		'post_status'         => 'publish',
		'ignore_sticky_posts' => true,
	);

	if ( $cat ) {
		$args['cat'] = $cat;
	}
	if ( $tag ) {
		$args['tag'] = $tag;
	}

	$posts = new WP_Query( $args );

	$html = '';

	if ( $posts->have_posts() ) {
		ob_start();
		while ( $posts->have_posts() ) {
			$posts->the_post();
			get_template_part( 'template-parts/blocks/card', 'standard' );
		}
		wp_reset_postdata();
		$html = ob_get_clean();
	}

	wp_send_json_success(
		array(
			'html'       => $html,
			'max_pages'  => $posts->max_num_pages,
			'found'      => $posts->found_posts,
			'has_more'   => $page < $posts->max_num_pages,
		)
	);
}
add_action( 'wp_ajax_promovads_load_more',        'promovads_ajax_load_more' );
add_action( 'wp_ajax_nopriv_promovads_load_more', 'promovads_ajax_load_more' );

/**
 * Track post view via Ajax.
 */
function promovads_ajax_track_view(): void {
	$post_id = isset( $_POST['post_id'] ) ? absint( $_POST['post_id'] ) : 0;
	if ( $post_id && get_post( $post_id ) ) {
		promovads_increment_views( $post_id );
	}
	wp_send_json_success();
}
add_action( 'wp_ajax_promovads_track_view',        'promovads_ajax_track_view' );
add_action( 'wp_ajax_nopriv_promovads_track_view', 'promovads_ajax_track_view' );

/**
 * Newsletter subscribe (demo handler - replace with real provider).
 */
function promovads_ajax_newsletter(): void {
	check_ajax_referer( 'promovads_nonce', 'nonce' );

	$email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';

	if ( ! is_email( $email ) ) {
		wp_send_json_error( array( 'message' => esc_html__( 'Please enter a valid email address.', 'promovads' ) ) );
	}

	// Hook for mail provider integration (Mailchimp, ConvertKit, etc.)
	do_action( 'promovads_newsletter_subscribe', $email );

	wp_send_json_success( array( 'message' => esc_html__( 'Thank you for subscribing!', 'promovads' ) ) );
}
add_action( 'wp_ajax_promovads_newsletter',        'promovads_ajax_newsletter' );
add_action( 'wp_ajax_nopriv_promovads_newsletter', 'promovads_ajax_newsletter' );
