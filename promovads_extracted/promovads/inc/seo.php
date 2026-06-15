<?php
/**
 * SEO - Schema.org, OpenGraph, Twitter Cards
 *
 * @package PromovaDS_News
 */

defined( 'ABSPATH' ) || exit;

/**
 * Inject all meta tags into <head>.
 */
function promovads_head_meta(): void {

	if ( is_singular() ) {
		promovads_og_tags();
		promovads_twitter_card();
		promovads_schema_newsarticle();
	} elseif ( is_home() || is_front_page() ) {
		promovads_og_site();
		promovads_schema_website();
	} elseif ( is_category() || is_tag() || is_tax() ) {
		promovads_og_archive();
	}
}
add_action( 'wp_head', 'promovads_head_meta', 5 );

/**
 * OpenGraph tags for single posts.
 */
function promovads_og_tags(): void {
	$post      = get_queried_object();
	$image_url = '';

	if ( has_post_thumbnail( $post->ID ) ) {
		$img       = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'promovads-hero' );
		$image_url = $img ? $img[0] : '';
	}

	$description = $post->post_excerpt
		? wp_strip_all_tags( $post->post_excerpt )
		: promovads_truncate( wp_strip_all_tags( $post->post_content ), 160 );
	?>
	<meta property="og:type"        content="article">
	<meta property="og:title"       content="<?php echo esc_attr( get_the_title( $post->ID ) ); ?>">
	<meta property="og:description" content="<?php echo esc_attr( $description ); ?>">
	<meta property="og:url"         content="<?php echo esc_url( get_permalink( $post->ID ) ); ?>">
	<meta property="og:site_name"   content="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
	<?php if ( $image_url ) : ?>
	<meta property="og:image"       content="<?php echo esc_url( $image_url ); ?>">
	<meta property="og:image:width" content="1200">
	<meta property="og:image:height" content="630">
	<?php endif; ?>
	<meta property="article:published_time" content="<?php echo esc_attr( get_the_date( 'c', $post->ID ) ); ?>">
	<meta property="article:modified_time"  content="<?php echo esc_attr( get_the_modified_date( 'c', $post->ID ) ); ?>">
	<meta property="article:author"         content="<?php echo esc_attr( get_the_author_meta( 'display_name', $post->post_author ) ); ?>">
	<?php

	$cats = get_the_category( $post->ID );
	if ( $cats ) {
		echo '<meta property="article:section" content="' . esc_attr( $cats[0]->name ) . '">' . "\n";
	}

	$tags = get_the_tags( $post->ID );
	if ( $tags ) {
		foreach ( $tags as $tag ) {
			echo '<meta property="article:tag" content="' . esc_attr( $tag->name ) . '">' . "\n";
		}
	}
}

/**
 * Twitter card for single posts.
 */
function promovads_twitter_card(): void {
	$post      = get_queried_object();
	$image_url = '';
	$twitter   = get_theme_mod( 'promovads_twitter_handle', '' );

	if ( has_post_thumbnail( $post->ID ) ) {
		$img       = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'promovads-hero' );
		$image_url = $img ? $img[0] : '';
	}

	$description = $post->post_excerpt
		? wp_strip_all_tags( $post->post_excerpt )
		: promovads_truncate( wp_strip_all_tags( $post->post_content ), 200 );
	?>
	<meta name="twitter:card"        content="summary_large_image">
	<meta name="twitter:title"       content="<?php echo esc_attr( get_the_title( $post->ID ) ); ?>">
	<meta name="twitter:description" content="<?php echo esc_attr( $description ); ?>">
	<?php if ( $image_url ) : ?>
	<meta name="twitter:image"       content="<?php echo esc_url( $image_url ); ?>">
	<?php endif; ?>
	<?php if ( $twitter ) : ?>
	<meta name="twitter:site"        content="@<?php echo esc_attr( ltrim( $twitter, '@' ) ); ?>">
	<?php endif; ?>
	<?php
}

/**
 * Schema.org NewsArticle JSON-LD.
 */
function promovads_schema_newsarticle(): void {
	$post    = get_queried_object();
	$img_url = '';

	if ( has_post_thumbnail( $post->ID ) ) {
		$img     = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'promovads-hero' );
		$img_url = $img ? $img[0] : '';
	}

	$description = $post->post_excerpt
		? wp_strip_all_tags( $post->post_excerpt )
		: promovads_truncate( wp_strip_all_tags( $post->post_content ), 250 );

	$logo_id  = get_theme_mod( 'custom_logo' );
	$logo_url = $logo_id ? wp_get_attachment_image_url( $logo_id, 'full' ) : '';

	$schema = array(
		'@context'         => 'https://schema.org',
		'@type'            => 'NewsArticle',
		'headline'         => get_the_title( $post->ID ),
		'description'      => $description,
		'url'              => get_permalink( $post->ID ),
		'datePublished'    => get_the_date( 'c', $post->ID ),
		'dateModified'     => get_the_modified_date( 'c', $post->ID ),
		'author'           => array(
			'@type' => 'Person',
			'name'  => get_the_author_meta( 'display_name', $post->post_author ),
			'url'   => get_author_posts_url( $post->post_author ),
		),
		'publisher'        => array(
			'@type' => 'Organization',
			'name'  => get_bloginfo( 'name' ),
			'logo'  => array(
				'@type' => 'ImageObject',
				'url'   => $logo_url ?: esc_url( home_url( '/' ) ),
			),
		),
		'mainEntityOfPage' => array(
			'@type' => 'WebPage',
			'@id'   => get_permalink( $post->ID ),
		),
	);

	if ( $img_url ) {
		$schema['image'] = array(
			'@type' => 'ImageObject',
			'url'   => $img_url,
		);
	}

	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}

/**
 * Schema.org WebSite with SearchAction.
 */
function promovads_schema_website(): void {
	$schema = array(
		'@context'        => 'https://schema.org',
		'@type'           => 'WebSite',
		'name'            => get_bloginfo( 'name' ),
		'url'             => home_url( '/' ),
		'potentialAction' => array(
			'@type'       => 'SearchAction',
			'target'      => array(
				'@type'       => 'EntryPoint',
				'urlTemplate' => home_url( '/?s={search_term_string}' ),
			),
			'query-input' => 'required name=search_term_string',
		),
	);

	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}

/**
 * OpenGraph for site homepage.
 */
function promovads_og_site(): void {
	$logo_id  = get_theme_mod( 'custom_logo' );
	$logo_url = $logo_id ? wp_get_attachment_image_url( $logo_id, 'full' ) : '';
	?>
	<meta property="og:type"        content="website">
	<meta property="og:title"       content="<?php bloginfo( 'name' ); ?>">
	<meta property="og:description" content="<?php bloginfo( 'description' ); ?>">
	<meta property="og:url"         content="<?php echo esc_url( home_url( '/' ) ); ?>">
	<meta property="og:site_name"   content="<?php bloginfo( 'name' ); ?>">
	<?php if ( $logo_url ) : ?>
	<meta property="og:image"       content="<?php echo esc_url( $logo_url ); ?>">
	<?php endif;
}

/**
 * OpenGraph for archive / category.
 */
function promovads_og_archive(): void {
	$term = get_queried_object();
	?>
	<meta property="og:type"        content="website">
	<meta property="og:title"       content="<?php echo esc_attr( $term->name ); ?> - <?php bloginfo( 'name' ); ?>">
	<meta property="og:description" content="<?php echo esc_attr( wp_strip_all_tags( term_description() ) ); ?>">
	<meta property="og:url"         content="<?php echo esc_url( get_term_link( $term ) ); ?>">
	<meta property="og:site_name"   content="<?php bloginfo( 'name' ); ?>">
	<?php
}

/**
 * Breadcrumb Schema.
 */
function promovads_schema_breadcrumb( array $items ): void {
	if ( empty( $items ) ) {
		return;
	}

	$list = array();
	foreach ( $items as $position => $item ) {
		$list[] = array(
			'@type'    => 'ListItem',
			'position' => $position + 1,
			'name'     => $item['name'],
			'item'     => $item['url'],
		);
	}

	$schema = array(
		'@context'        => 'https://schema.org',
		'@type'           => 'BreadcrumbList',
		'itemListElement' => $list,
	);

	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}
