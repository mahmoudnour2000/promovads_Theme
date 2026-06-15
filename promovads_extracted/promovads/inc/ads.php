<?php
/**
 * Ad Management System
 *
 * @package PromovaDS_News
 */

defined( 'ABSPATH' ) || exit;

/**
 * Get ad code for a given slot.
 */
function promovads_get_ad( string $slot ): string {
	$ad = get_theme_mod( 'promovads_ad_' . $slot, '' );
	if ( $ad ) {
		return wp_kses_post( $ad );
	}
	return '';
}

/**
 * Display ad slot.
 */
function promovads_ad( string $slot, bool $show_label = true ): void {
	$ad = promovads_get_ad( $slot );
	if ( ! $ad ) {
		return;
	}

	$label = $show_label ? '<p class="pds-ad-label">' . esc_html__( 'Advertisement', 'promovads' ) . '</p>' : '';

	printf(
		'<div class="pds-ad pds-ad--%s">%s%s</div>',
		esc_attr( $slot ),
		wp_kses_post( $label ),
		wp_kses_post( $ad )
	);
}

/**
 * Inject ad after N paragraphs in content.
 */
function promovads_inject_inline_ad( string $content ): string {
	if ( ! is_single() || is_admin() ) {
		return $content;
	}

	$ad = promovads_get_ad( 'inline' );
	if ( ! $ad ) {
		return $content;
	}

	$inject_after = (int) get_theme_mod( 'promovads_ad_inline_after', 3 );

	$paragraphs = explode( '</p>', $content );
	if ( count( $paragraphs ) < $inject_after + 1 ) {
		return $content;
	}

	$ad_html = '<div class="pds-ad-inline pds-ad--inline"><p class="pds-ad-label">' . esc_html__( 'Advertisement', 'promovads' ) . '</p>' . wp_kses_post( $ad ) . '</div>';

	array_splice( $paragraphs, $inject_after, 0, array( $ad_html ) );

	return implode( '</p>', $paragraphs );
}
add_filter( 'the_content', 'promovads_inject_inline_ad' );

/**
 * Ad slot shortcode: [pds_ad slot="header"]
 */
function promovads_ad_shortcode( array $atts ): string {
	$atts = shortcode_atts( array( 'slot' => 'inline' ), $atts, 'pds_ad' );
	ob_start();
	promovads_ad( sanitize_key( $atts['slot'] ) );
	return ob_get_clean();
}
add_shortcode( 'pds_ad', 'promovads_ad_shortcode' );

/**
 * Register ad customizer settings.
 */
function promovads_ads_customizer( WP_Customize_Manager $wp_customize ): void {

	$wp_customize->add_section(
		'promovads_ads',
		array(
			'title'    => esc_html__( 'Advertisement Slots', 'promovads' ),
			'priority' => 60,
		)
	);

	$slots = array(
		'header'   => esc_html__( 'Header Ad (728x90)', 'promovads' ),
		'inline'   => esc_html__( 'Inline Content Ad', 'promovads' ),
		'sidebar'  => esc_html__( 'Sidebar Ad (300x250)', 'promovads' ),
		'footer'   => esc_html__( 'Footer Ad (728x90)', 'promovads' ),
		'popup'    => esc_html__( 'Popup / Interstitial Ad', 'promovads' ),
	);

	foreach ( $slots as $slot => $label ) {
		$wp_customize->add_setting(
			'promovads_ad_' . $slot,
			array(
				'default'           => '',
				'sanitize_callback' => 'wp_kses_post',
				'transport'         => 'refresh',
			)
		);

		$wp_customize->add_control(
			'promovads_ad_' . $slot,
			array(
				'label'    => $label,
				'section'  => 'promovads_ads',
				'type'     => 'textarea',
				'description' => esc_html__( 'Paste Google AdSense or custom HTML/JS code.', 'promovads' ),
			)
		);
	}

	$wp_customize->add_setting(
		'promovads_ad_inline_after',
		array(
			'default'           => 3,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'promovads_ad_inline_after',
		array(
			'label'       => esc_html__( 'Inject inline ad after N paragraphs', 'promovads' ),
			'section'     => 'promovads_ads',
			'type'        => 'number',
			'input_attrs' => array( 'min' => 1, 'max' => 20 ),
		)
	);
}
add_action( 'customize_register', 'promovads_ads_customizer' );
