<?php
/**
 * WordPress data layer — replaces static demo JS/articles data.
 *
 * @package PromovaDS_News
 */

defined( 'ABSPATH' ) || exit;

/**
 * Categories for navigation and sections.
 *
 * @return WP_Term[]
 */
function promovads_get_nav_categories( array $args = array() ): array {
	$defaults = array(
		'taxonomy'   => 'category',
		'hide_empty' => true,
		'orderby'    => 'count',
		'order'      => 'DESC',
		'number'     => 0,
	);

	$terms = get_terms( array_merge( $defaults, $args ) );

	if ( is_wp_error( $terms ) || empty( $terms ) ) {
		return array();
	}

	return array_values(
		array_filter(
			$terms,
			static function ( WP_Term $term ): bool {
				$hide = get_term_meta( $term->term_id, 'pds_hide_nav', true );
				return '1' !== (string) $hide;
			}
		)
	);
}

/**
 * Category color with demo fallback.
 */
function promovads_get_category_color( int $term_id, string $fallback = '#6366f1' ): string {
	$color = get_term_meta( $term_id, 'pds_color', true );
	return $color ? sanitize_hex_color( $color ) : $fallback;
}

/**
 * Category icon class.
 */
function promovads_get_category_icon( int $term_id, string $fallback = 'fa-folder' ): string {
	$icon = get_term_meta( $term_id, 'pds_icon', true );
	return $icon ? sanitize_html_class( $icon ) : $fallback;
}

/**
 * Is post marked breaking?
 */
function promovads_is_breaking_post( int $post_id = 0 ): bool {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	if ( get_post_meta( $post_id, 'pds_breaking', true ) ) {
		return true;
	}

	return has_tag( array( 'breaking', 'عاجل', 'breaking-news' ), $post_id );
}

/**
 * Is post marked featured?
 */
function promovads_is_featured_post( int $post_id = 0 ): bool {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	if ( get_post_meta( $post_id, 'pds_featured', true ) ) {
		return true;
	}

	return is_sticky( $post_id );
}

/**
 * Featured posts query.
 */
function promovads_get_featured_posts( int $count = 3, array $args = array() ): array {
	$sticky = get_option( 'sticky_posts', array() );
	$posts  = array();

	if ( ! empty( $sticky ) ) {
		$q = new WP_Query(
			array_merge(
				array(
					'post__in'            => $sticky,
					'posts_per_page'      => $count,
					'ignore_sticky_posts' => 1,
					'post_status'         => 'publish',
					'orderby'             => 'post__in',
				),
				$args
			)
		);
		$posts = $q->posts;
		wp_reset_postdata();
	}

	if ( count( $posts ) < $count ) {
		$meta_q = new WP_Query(
			array_merge(
				array(
					'posts_per_page'      => $count - count( $posts ),
					'post_status'         => 'publish',
					'ignore_sticky_posts' => true,
					'post__not_in'        => wp_list_pluck( $posts, 'ID' ),
					'meta_key'            => 'pds_featured',
					'meta_value'          => '1',
					'orderby'             => 'date',
					'order'               => 'DESC',
				),
				$args
			)
		);
		$posts = array_merge( $posts, $meta_q->posts );
		wp_reset_postdata();
	}

	if ( count( $posts ) < $count ) {
		$latest = promovads_get_posts(
			array_merge(
				array(
					'posts_per_page' => $count - count( $posts ),
					'post__not_in'   => wp_list_pluck( $posts, 'ID' ),
				),
				$args
			)
		);
		$posts = array_merge( $posts, $latest->posts );
		wp_reset_postdata();
	}

	return array_slice( $posts, 0, $count );
}

/**
 * Breaking posts for ticker / pulse bar.
 */
function promovads_get_breaking_posts( int $count = 10, array $args = array() ): array {
	$q = new WP_Query(
		array_merge(
			array(
				'posts_per_page'      => $count,
				'post_status'         => 'publish',
				'ignore_sticky_posts' => true,
				'meta_key'            => 'pds_breaking',
				'meta_value'          => '1',
				'orderby'             => 'date',
				'order'               => 'DESC',
			),
			$args
		)
	);

	$posts = $q->posts;
	wp_reset_postdata();

	if ( count( $posts ) < $count ) {
		$tag_q = new WP_Query(
			array_merge(
				array(
					'posts_per_page'      => $count - count( $posts ),
					'post_status'         => 'publish',
					'post__not_in'        => wp_list_pluck( $posts, 'ID' ),
					'tag_slug__in'        => array( 'breaking', 'عاجل' ),
					'orderby'             => 'date',
					'order'               => 'DESC',
				),
				$args
			)
		);
		$posts = array_merge( $posts, $tag_q->posts );
		wp_reset_postdata();
	}

	if ( empty( $posts ) ) {
		$latest = promovads_get_posts(
			array_merge(
				array(
					'posts_per_page' => $count,
					'orderby'        => 'date',
					'order'          => 'DESC',
				),
				$args
			)
		);
		$posts = $latest->posts;
		wp_reset_postdata();
	}

	return array_slice( $posts, 0, $count );
}

/**
 * Posts in category excluding featured IDs.
 */
function promovads_get_category_posts( int $cat_id, int $limit = 3, array $exclude = array() ): array {
	$q = promovads_get_posts(
		array(
			'cat'                 => $cat_id,
			'posts_per_page'      => $limit,
			'post__not_in'        => $exclude,
			'ignore_sticky_posts' => true,
		)
	);

	$posts = $q->posts;
	wp_reset_postdata();
	return $posts;
}

/**
 * Primary category for a post.
 */
function promovads_get_primary_category( int $post_id = 0 ): ?WP_Term {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$cats = get_the_category( $post_id );
	return ! empty( $cats ) ? $cats[0] : null;
}

/**
 * Arabic-friendly time ago.
 */
function promovads_time_ago_ar( int $post_id = 0 ): string {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	return sprintf(
		/* translators: %s: human time diff */
		__( 'منذ %s', 'promovads' ),
		human_time_diff( get_post_timestamp( $post_id ), current_time( 'timestamp' ) )
	);
}

/**
 * Formatted views with Arabic suffix.
 */
function promovads_views_label( int $post_id = 0 ): string {
	$views = promovads_get_views( $post_id );
	if ( $views >= 1000 ) {
		return promovads_format_number( $views );
	}
	return number_format_i18n( $views );
}

/**
 * Archive link for posts index.
 */
function promovads_posts_archive_url(): string {
	$posts_page = (int) get_option( 'page_for_posts' );
	if ( $posts_page ) {
		return get_permalink( $posts_page );
	}
	return home_url( '/news/' );
}

/**
 * Is the current request the all-news archive?
 */
function promovads_is_news_archive(): bool {
	return '1' === get_query_var( 'promovads_news', '' );
}

/**
 * Is current nav item active?
 */
function promovads_nav_is_active( string $type, $object = null ): bool {
	if ( 'home' === $type ) {
		return is_front_page() || is_home();
	}

	if ( 'category' === $type && $object instanceof WP_Term ) {
		return is_category( $object->term_id );
	}

	return false;
}

/**
 * Hot topics from tags, or popular categories when tags are empty.
 *
 * @return array<int, array{type:string, term:WP_Term}>
 */
function promovads_get_hot_topics( int $count = 12 ): array {
	$topics = array();

	$tags = get_tags(
		array(
			'number'     => $count,
			'orderby'    => 'count',
			'order'      => 'DESC',
			'hide_empty' => true,
		)
	);

	if ( ! empty( $tags ) && ! is_wp_error( $tags ) ) {
		foreach ( $tags as $tag ) {
			$topics[] = array(
				'type' => 'tag',
				'term' => $tag,
			);
		}
		return $topics;
	}

	$categories = get_categories(
		array(
			'number'     => $count,
			'orderby'    => 'count',
			'order'      => 'DESC',
			'hide_empty' => true,
		)
	);

	if ( empty( $categories ) || is_wp_error( $categories ) ) {
		return array();
	}

	foreach ( $categories as $cat ) {
		$topics[] = array(
			'type' => 'category',
			'term' => $cat,
		);
	}

	return $topics;
}
