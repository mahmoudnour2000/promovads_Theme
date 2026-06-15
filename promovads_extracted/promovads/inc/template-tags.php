<?php
/**
 * Template Tags & Nav Walker
 *
 * @package PromovaDS_News
 */

defined( 'ABSPATH' ) || exit;

/**
 * Primary Nav Walker - outputs pds-nav__* classes with mega menu support.
 */
class PromovaDS_Nav_Walker extends Walker_Nav_Menu {

	public function start_lvl( &$output, $depth = 0, $args = null ) {
		if ( $depth === 0 ) {
			$has_mega = isset( $this->current_item ) && get_post_meta( $this->current_item, '_pds_mega_menu', true );
			if ( $has_mega ) {
				$output .= '<div class="pds-mega pds-mega--wide">';
				return;
			}
			$output .= '<ul class="pds-dropdown">';
		}
	}

	public function end_lvl( &$output, $depth = 0, $args = null ) {
		if ( $depth === 0 ) {
			$output .= '</ul>';
		}
	}

	public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
		$item   = $data_object;
		$indent = str_repeat( "\t", $depth );

		$classes     = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[]   = 'menu-item-' . $item->ID;
		$class_names = implode( ' ', array_filter( $classes ) );

		$hot = in_array( 'hot', $classes, true );

		$li_class = 'pds-nav__item';
		if ( $depth > 0 ) {
			$li_class = 'pds-dropdown__item';
		}
		if ( $hot ) {
			$li_class .= ' pds-nav__item--hot';
		}
		if ( in_array( 'current-menu-item', $classes, true ) || in_array( 'current-menu-parent', $classes, true ) ) {
			$li_class .= ' current-menu-item';
		}

		$output .= $indent . '<li class="' . esc_attr( $li_class ) . '">';

		$atts = array(
			'title'  => ! empty( $item->attr_title ) ? $item->attr_title : '',
			'target' => ! empty( $item->target )     ? $item->target     : '',
			'rel'    => ! empty( $item->xfn )        ? $item->xfn        : '',
			'href'   => ! empty( $item->url )        ? $item->url        : '',
		);

		if ( $depth === 0 ) {
			$atts['class'] = 'pds-nav__link';
			if ( $item->menu_item_parent == 0 && $item->object_id ) {
				$atts['aria-haspopup'] = 'true';
			}
		}

		$link_atts = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$link_atts .= ' ' . $attr . '="' . esc_attr( $value ) . '"';
			}
		}

		$badge = get_post_meta( $item->ID, '_pds_badge', true );

		$output .= '<a' . $link_atts . '>';
		$output .= apply_filters( 'the_title', $item->title, $item->ID );
		if ( $badge ) {
			$output .= '<span class="pds-nav__badge">' . esc_html( $badge ) . '</span>';
		}
		if ( $depth === 0 && $item->menu_item_parent == 0 ) {
			$output .= '<i class="fas fa-chevron-down pds-nav__arrow" style="font-size:.65em;margin-left:.3rem;" aria-hidden="true"></i>';
		}
		$output .= '</a>';
	}
}

/**
 * Fallback primary nav.
 */
function promovads_primary_nav_fallback(): void {
	wp_page_menu(
		array(
			'menu_class'  => 'pds-nav__menu',
			'echo'        => true,
			'show_home'   => true,
			'link_before' => '<span class="pds-nav__link">',
			'link_after'  => '</span>',
		)
	);
}

/**
 * Display post meta (for template tags compatibility).
 */
function promovads_posted_on(): void {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	printf(
		esc_html( $time_string ),
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( DATE_W3C ) ),
		esc_html( get_the_modified_date() )
	);
}

/**
 * Posted by.
 */
function promovads_posted_by(): void {
	printf(
		'<span class="byline"><span class="author vcard"><a class="url fn n" href="%1$s">%2$s</a></span></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_html( get_the_author() )
	);
}

/**
 * Simple is_mobile helper.
 */
if ( ! function_exists( 'is_mobile' ) ) {
	function is_mobile(): bool {
		return wp_is_mobile();
	}
}
