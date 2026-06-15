<?php
/**
 * Theme Helper Functions
 *
 * @package PromovaDS_News
 */

defined( 'ABSPATH' ) || exit;

/**
 * Get post thumbnail with lazy loading.
 */
function promovads_thumbnail( int $post_id = 0, string $size = 'promovads-card', string $class = '' ): string {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	if ( has_post_thumbnail( $post_id ) ) {
		$html = get_the_post_thumbnail(
			$post_id,
			$size,
			array(
				'class'   => 'pds-img-cover ' . esc_attr( $class ),
				'loading' => 'lazy',
				'decoding' => 'async',
			)
		);
		return $html;
	}

	$placeholder = PROMOVADS_URI . '/assets/images/placeholder.jpg';
	return sprintf(
		'<img src="%s" alt="%s" class="pds-img-cover %s" loading="lazy" decoding="async">',
		esc_url( $placeholder ),
		esc_attr( get_the_title( $post_id ) ),
		esc_attr( $class )
	);
}

/**
 * Get category badge HTML.
 */
function promovads_category_badge( int $post_id = 0, bool $link = true ): string {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$cats = get_the_category( $post_id );
	if ( empty( $cats ) ) {
		return '';
	}

	$cat   = $cats[0];
	$color = get_term_meta( $cat->term_id, 'pds_color', true );
	$style = $color ? ' style="background-color:' . esc_attr( $color ) . '"' : '';

	if ( $link ) {
		return sprintf(
			'<a href="%s" class="pds-card__cat"%s>%s</a>',
			esc_url( get_category_link( $cat->term_id ) ),
			$style,
			esc_html( $cat->name )
		);
	}

	return sprintf(
		'<span class="pds-card__cat"%s>%s</span>',
		$style,
		esc_html( $cat->name )
	);
}

/**
 * Get reading time estimate.
 */
function promovads_reading_time( int $post_id = 0 ): string {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$content    = get_post_field( 'post_content', $post_id );
	$word_count = str_word_count( wp_strip_all_tags( $content ) );
	$minutes    = (int) ceil( $word_count / 200 );

	return sprintf(
		/* translators: %d: number of minutes */
		esc_html( _n( '%d min read', '%d min read', $minutes, 'promovads' ) ),
		$minutes
	);
}

/**
 * Get post views count.
 */
function promovads_get_views( int $post_id = 0 ): int {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}
	return (int) get_post_meta( $post_id, 'pds_views', true );
}

/**
 * Increment post views.
 */
function promovads_increment_views( int $post_id ): void {
	$views = promovads_get_views( $post_id );
	update_post_meta( $post_id, 'pds_views', $views + 1 );
}

/**
 * Format large numbers for display.
 */
function promovads_format_number( int $number ): string {
	if ( $number >= 1000000 ) {
		return round( $number / 1000000, 1 ) . 'M';
	}
	if ( $number >= 1000 ) {
		return round( $number / 1000, 1 ) . 'K';
	}
	return (string) $number;
}

/**
 * Get human-friendly time ago.
 */
function promovads_time_ago( int $post_id = 0 ): string {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$timestamp = get_post_timestamp( $post_id );
	$diff      = time() - $timestamp;

	if ( $diff < 3600 ) {
		$mins = (int) floor( $diff / 60 );
		return sprintf( esc_html__( '%d min ago', 'promovads' ), max( 1, $mins ) );
	}
	if ( $diff < 86400 ) {
		$hours = (int) floor( $diff / 3600 );
		return sprintf( esc_html__( '%dh ago', 'promovads' ), $hours );
	}
	if ( $diff < 604800 ) {
		$days = (int) floor( $diff / 86400 );
		return sprintf( esc_html__( '%dd ago', 'promovads' ), $days );
	}

	return get_the_date( '', $post_id );
}

/**
 * Get trending posts.
 */
function promovads_get_trending( int $count = 5, array $args = array() ): WP_Query {
	$default = array(
		'posts_per_page'      => $count,
		'ignore_sticky_posts' => true,
		'meta_key'            => 'pds_views',
		'orderby'             => 'meta_value_num',
		'order'               => 'DESC',
		'post_status'         => 'publish',
	);

	return new WP_Query( array_merge( $default, $args ) );
}

/**
 * Get posts for a specific demo/section.
 */
function promovads_get_posts( array $args = array() ): WP_Query {
	$default = array(
		'posts_per_page'      => 6,
		'ignore_sticky_posts' => true,
		'post_status'         => 'publish',
	);
	return new WP_Query( array_merge( $default, $args ) );
}

/**
 * Get author social links.
 */
function promovads_author_social( int $user_id = 0 ): array {
	if ( ! $user_id ) {
		$user_id = get_the_author_meta( 'ID' );
	}

	$networks = array( 'twitter', 'facebook', 'instagram', 'linkedin', 'youtube', 'website' );
	$links    = array();

	foreach ( $networks as $net ) {
		$val = get_user_meta( $user_id, 'pds_social_' . $net, true );
		if ( $val ) {
			$links[ $net ] = esc_url( $val );
		}
	}

	return $links;
}

/**
 * Get review score stars HTML.
 */
function promovads_review_stars( float $score, float $max = 10 ): string {
	$percent = ( $score / $max ) * 100;
	$stars   = array();

	for ( $i = 1; $i <= 5; $i++ ) {
		$fill = min( 100, max( 0, ( $percent - ( ( $i - 1 ) * 20 ) ) * 5 ) );
		if ( $fill >= 100 ) {
			$stars[] = '<i class="fas fa-star pds-star--full"></i>';
		} elseif ( $fill >= 50 ) {
			$stars[] = '<i class="fas fa-star-half-alt pds-star--half"></i>';
		} else {
			$stars[] = '<i class="far fa-star pds-star--empty"></i>';
		}
	}

	return sprintf(
		'<span class="pds-stars" aria-label="%s/10">%s</span>',
		esc_attr( $score ),
		implode( '', $stars )
	);
}

/**
 * Truncate text safely.
 */
function promovads_truncate( string $text, int $length = 120, string $suffix = '...' ): string {
	$text = wp_strip_all_tags( $text );
	if ( mb_strlen( $text ) <= $length ) {
		return $text;
	}
	return mb_substr( $text, 0, $length ) . $suffix;
}

/**
 * Get post share URLs.
 */
function promovads_share_urls( int $post_id = 0 ): array {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$url   = rawurlencode( get_permalink( $post_id ) );
	$title = rawurlencode( get_the_title( $post_id ) );

	return array(
		'facebook'  => 'https://www.facebook.com/sharer/sharer.php?u=' . $url,
		'twitter'   => 'https://twitter.com/intent/tweet?url=' . $url . '&text=' . $title,
		'whatsapp'  => 'https://wa.me/?text=' . $title . '%20' . $url,
		'linkedin'  => 'https://www.linkedin.com/shareArticle?mini=true&url=' . $url . '&title=' . $title,
		'telegram'  => 'https://t.me/share/url?url=' . $url . '&text=' . $title,
		'email'     => 'mailto:?subject=' . $title . '&body=' . $url,
	);
}

/**
 * Breadcrumb trail.
 */
function promovads_breadcrumb(): void {
	$separator = '<span class="pds-bc__sep" aria-hidden="true">›</span>';
	$items     = array();

	$items[] = sprintf(
		'<li class="pds-bc__item"><a href="%s">%s</a></li>',
		esc_url( home_url( '/' ) ),
		esc_html__( 'Home', 'promovads' )
	);

	if ( is_category() ) {
		$items[] = sprintf( '<li class="pds-bc__item">%s</li>', esc_html( single_cat_title( '', false ) ) );
	} elseif ( is_single() ) {
		$cats = get_the_category();
		if ( $cats ) {
			$items[] = sprintf(
				'<li class="pds-bc__item"><a href="%s">%s</a></li>',
				esc_url( get_category_link( $cats[0]->term_id ) ),
				esc_html( $cats[0]->name )
			);
		}
		$items[] = sprintf( '<li class="pds-bc__item" aria-current="page">%s</li>', esc_html( get_the_title() ) );
	} elseif ( is_page() ) {
		if ( wp_get_post_parent_id( get_the_ID() ) ) {
			$parent  = get_post( wp_get_post_parent_id( get_the_ID() ) );
			$items[] = sprintf(
				'<li class="pds-bc__item"><a href="%s">%s</a></li>',
				esc_url( get_permalink( $parent ) ),
				esc_html( get_the_title( $parent ) )
			);
		}
		$items[] = sprintf( '<li class="pds-bc__item" aria-current="page">%s</li>', esc_html( get_the_title() ) );
	} elseif ( is_search() ) {
		$items[] = sprintf(
			'<li class="pds-bc__item">%s</li>',
			sprintf( esc_html__( 'Search: %s', 'promovads' ), esc_html( get_search_query() ) )
		);
	} elseif ( is_404() ) {
		$items[] = '<li class="pds-bc__item">404</li>';
	} elseif ( is_tag() ) {
		$items[] = sprintf( '<li class="pds-bc__item">%s</li>', esc_html( single_tag_title( '', false ) ) );
	}

	printf(
		'<nav class="pds-breadcrumb" aria-label="%s"><ol class="pds-bc__list">%s</ol></nav>',
		esc_attr__( 'Breadcrumb', 'promovads' ),
		implode( $separator, $items )
	);
}

/**
 * Return placeholder image URL for the given size.
 */
function promovads_placeholder_url( string $size = 'promovads-card' ): string {
	return esc_url( PROMOVADS_URI . '/assets/images/placeholder.jpg' );
}

/**
 * Get active demo name.
 */
function promovads_active_demo(): string {
	return sanitize_key( get_theme_mod( 'promovads_active_demo', '' ) );
}
