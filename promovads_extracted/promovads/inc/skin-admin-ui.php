<?php
/**
 * Admin UI helpers — skin picker wireframes & section meta.
 *
 * @package PromovaDS_News
 */

defined( 'ABSPATH' ) || exit;

/**
 * Section metadata for the skins admin page.
 *
 * @return array<string, array{icon: string, hint: string}>
 */
function promovads_skin_section_meta(): array {
	return array(
		'hero'           => array(
			'icon' => 'fa-wand-magic-sparkles',
			'hint' => __( 'المنطقة البارزة أعلى الصفحة الرئيسية — أول ما يراه الزائر', 'promovads' ),
		),
		'nav'            => array(
			'icon' => 'fa-compass',
			'hint' => __( 'شريط التصنيفات تحت الهيدر — يوجّه الزائر بين الأقسام', 'promovads' ),
		),
		'cat_section'    => array(
			'icon' => 'fa-table-cells-large',
			'hint' => __( 'عرض مقالات كل تصنيف في الصفحة الرئيسية', 'promovads' ),
		),
		'latest'         => array(
			'icon' => 'fa-clock-rotate-left',
			'hint' => __( 'قسم «آخر الأخبار» قبل الفوتر في الصفحة الرئيسية', 'promovads' ),
		),
		'archive_header' => array(
			'icon' => 'fa-heading',
			'hint' => __( 'عنوان وبيانات صفحات الأقسام والأرشيف', 'promovads' ),
		),
	);
}

/**
 * Count ready vs total variants.
 *
 * @return array{ready: int, total: int, planned: int}
 */
function promovads_skin_registry_counts(): array {
	$ready   = 0;
	$total   = 0;
	$registry = promovads_skin_registry();

	foreach ( $registry as $variants ) {
		foreach ( $variants as $variant ) {
			++$total;
			if ( 'ready' === ( $variant['status'] ?? '' ) ) {
				++$ready;
			}
		}
	}

	return array(
		'ready'   => $ready,
		'total'   => $total,
		'planned' => $total - $ready,
	);
}

/**
 * Mini wireframe markup for a skin variant card.
 */
function promovads_skin_mock_markup( string $type, string $slug ): string {
	$type = sanitize_key( $type );
	$slug = sanitize_key( $slug );

	$blocks = promovads_skin_mock_blocks( $type, $slug );

	$html  = '<div class="pds-skin-mock" data-type="' . esc_attr( $type ) . '" data-variant="' . esc_attr( $slug ) . '">';
	$html .= '<div class="pds-skin-mock__chrome"><span></span><span></span><span></span></div>';
	$html .= '<div class="pds-skin-mock__canvas">';

	foreach ( $blocks as $block ) {
		$class = 'pds-skin-mock__block';
		if ( ! empty( $block['mod'] ) ) {
			$class .= ' pds-skin-mock__block--' . sanitize_html_class( $block['mod'] );
		}
		$html .= '<span class="' . esc_attr( $class ) . '"></span>';
	}

	$html .= '</div></div>';

	return $html;
}

/**
 * Block definitions per variant for wireframe previews.
 *
 * @return list<array{mod?: string}>
 */
function promovads_skin_mock_blocks( string $type, string $slug ): array {
	$key = $type . ':' . $slug;

	$map = array(
		// Hero.
		'hero:grid-lead-side'  => array( array( 'mod' => 'hero-main' ), array( 'mod' => 'hero-side' ), array( 'mod' => 'hero-side' ) ),
		'hero:grid-3-equal'    => array( array( 'mod' => 'card' ), array( 'mod' => 'card' ), array( 'mod' => 'card' ) ),
		'hero:carousel'        => array( array( 'mod' => 'slide' ), array( 'mod' => 'slide' ), array( 'mod' => 'slide-peek' ) ),
		'hero:full-bleed'      => array( array( 'mod' => 'bleed' ) ),
		'hero:magazine-stack'  => array( array( 'mod' => 'stack-lg' ), array( 'mod' => 'stack-md' ), array( 'mod' => 'stack-sm' ) ),
		'hero:mosaic-4'        => array( array( 'mod' => 'tile-lg' ), array( 'mod' => 'tile-sm' ), array( 'mod' => 'tile-sm' ), array( 'mod' => 'tile-wide' ) ),
		'hero:ranked-list'     => array( array( 'mod' => 'rank' ), array( 'mod' => 'rank' ), array( 'mod' => 'rank' ) ),
		'hero:video-style'     => array( array( 'mod' => 'video' ) ),
		'hero:breaking-split'  => array( array( 'mod' => 'break' ), array( 'mod' => 'card' ), array( 'mod' => 'card' ) ),
		'hero:minimal-text'    => array( array( 'mod' => 'line' ), array( 'mod' => 'line' ), array( 'mod' => 'line-short' ) ),
		'hero:bento-grid'      => array( array( 'mod' => 'bento-a' ), array( 'mod' => 'bento-b' ), array( 'mod' => 'bento-c' ) ),
		'hero:dual-feature'    => array( array( 'mod' => 'half' ), array( 'mod' => 'half' ) ),

		// Nav.
		'nav:pills'            => array( array( 'mod' => 'pill' ), array( 'mod' => 'pill-active' ), array( 'mod' => 'pill' ), array( 'mod' => 'pill' ) ),
		'nav:pills-solid'      => array( array( 'mod' => 'pill' ), array( 'mod' => 'pill-solid' ), array( 'mod' => 'pill' ) ),
		'nav:underline'        => array( array( 'mod' => 'tab' ), array( 'mod' => 'tab-under' ), array( 'mod' => 'tab' ) ),
		'nav:bar'              => array( array( 'mod' => 'bar-item' ), array( 'mod' => 'bar-item' ), array( 'mod' => 'bar-item' ) ),
		'nav:chips'            => array( array( 'mod' => 'chip' ), array( 'mod' => 'chip' ), array( 'mod' => 'chip' ), array( 'mod' => 'chip' ) ),
		'nav:segments'         => array( array( 'mod' => 'seg' ), array( 'mod' => 'seg-on' ), array( 'mod' => 'seg' ) ),
		'nav:dark'             => array( array( 'mod' => 'dark-nav' ) ),
		'nav:skew'             => array( array( 'mod' => 'skew' ), array( 'mod' => 'skew' ) ),
		'nav:mega-menu'        => array( array( 'mod' => 'mega' ) ),
		'nav:icon-tabs'        => array( array( 'mod' => 'icon' ), array( 'mod' => 'icon-on' ), array( 'mod' => 'icon' ) ),

		// Category sections.
		'cat_section:grid-cards'         => array( array( 'mod' => 'card' ), array( 'mod' => 'card' ), array( 'mod' => 'card' ) ),
		'cat_section:horizontal-scroll'  => array( array( 'mod' => 'hcard' ), array( 'mod' => 'hcard' ), array( 'mod' => 'hcard-peek' ) ),
		'cat_section:featured-list'      => array( array( 'mod' => 'feat' ), array( 'mod' => 'list' ), array( 'mod' => 'list' ) ),
		'cat_section:masonry-2'          => array( array( 'mod' => 'masonry-tall' ), array( 'mod' => 'masonry-short' ) ),
		'cat_section:timeline'           => array( array( 'mod' => 'tl' ), array( 'mod' => 'tl' ), array( 'mod' => 'tl' ) ),
		'cat_section:compact-list'       => array( array( 'mod' => 'compact' ), array( 'mod' => 'compact' ), array( 'mod' => 'compact' ) ),
		'cat_section:magazine-row'       => array( array( 'mod' => 'mag-wide' ), array( 'mod' => 'mag-sm' ), array( 'mod' => 'mag-sm' ) ),
		'cat_section:numbered'           => array( array( 'mod' => 'num' ), array( 'mod' => 'num' ), array( 'mod' => 'num' ) ),
		'cat_section:overlay-strip'      => array( array( 'mod' => 'strip' ), array( 'mod' => 'strip' ), array( 'mod' => 'strip' ) ),
		'cat_section:tabbed'             => array( array( 'mod' => 'tabs' ), array( 'mod' => 'card' ), array( 'mod' => 'card' ) ),

		// Latest.
		'latest:timeline-list'   => array( array( 'mod' => 'row' ), array( 'mod' => 'row' ), array( 'mod' => 'row' ) ),
		'latest:grid-4'          => array( array( 'mod' => 'sq' ), array( 'mod' => 'sq' ), array( 'mod' => 'sq' ), array( 'mod' => 'sq' ) ),
		'latest:compact-rows'    => array( array( 'mod' => 'cline' ), array( 'mod' => 'cline' ), array( 'mod' => 'cline' ) ),
		'latest:card-carousel'   => array( array( 'mod' => 'cslide' ), array( 'mod' => 'cslide' ), array( 'mod' => 'cslide-peek' ) ),
		'latest:split-featured'  => array( array( 'mod' => 'split-lg' ), array( 'mod' => 'split-list' ) ),
		'latest:minimal-links'   => array( array( 'mod' => 'link' ), array( 'mod' => 'link' ), array( 'mod' => 'link' ) ),
		'latest:magazine-cols'   => array( array( 'mod' => 'col' ), array( 'mod' => 'col' ) ),
		'latest:top-10'          => array( array( 'mod' => 'top' ), array( 'mod' => 'top' ), array( 'mod' => 'top' ) ),

		// Archive header.
		'archive_header:dark-banner'      => array( array( 'mod' => 'banner-dark' ) ),
		'archive_header:minimal-line'     => array( array( 'mod' => 'banner-line' ) ),
		'archive_header:with-cover'       => array( array( 'mod' => 'banner-cover' ) ),
		'archive_header:gradient-wave'    => array( array( 'mod' => 'banner-wave' ) ),
		'archive_header:breadcrumb-inline'=> array( array( 'mod' => 'crumb' ), array( 'mod' => 'banner-line' ) ),
		'archive_header:split-stats'      => array( array( 'mod' => 'split-l' ), array( 'mod' => 'split-r' ) ),
		'archive_header:glass-card'       => array( array( 'mod' => 'glass' ) ),
		'archive_header:pattern-bg'       => array( array( 'mod' => 'pattern' ) ),
		'archive_header:author-card'      => array( array( 'mod' => 'author' ) ),
		'archive_header:tag-cloud'        => array( array( 'mod' => 'cloud' ) ),
	);

	if ( isset( $map[ $key ] ) ) {
		return $map[ $key ];
	}

	// Generic fallback.
	return array( array( 'mod' => 'card' ), array( 'mod' => 'card' ) );
}
