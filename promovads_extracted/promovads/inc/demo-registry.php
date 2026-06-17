<?php
/**
 * Demo registry — layout/skin config only (no static content).
 *
 * @package PromovaDS_News
 */

defined( 'ABSPATH' ) || exit;

/**
 * All available demo definitions keyed by slug.
 *
 * @return array<string, array<string, mixed>>
 */
function promovads_get_demo_registry(): array {
	static $registry = null;

	if ( null !== $registry ) {
		return $registry;
	}

	$registry = array(
		'tech-ai'     => array(
			'label'        => __( 'Tech & AI', 'promovads' ),
			'prefix'       => 'tech',
			'nav_variant'  => 'pills',
			'nav_aria'     => __( 'أقسام التقنية', 'promovads' ),
			'no_icons'     => false,
			'logo_icon'    => 'fa-microchip',
			'tagline'      => __( 'أخبار التقنية والذكاء الاصطناعي', 'promovads' ),
			'topbar_badge' => __( 'أخبار التقنية', 'promovads' ),
			'primary'      => '#6366f1',
			'secondary'    => '#0f172a',
			'accent'       => '#06b6d4',
			'fonts'        => 'https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&family=Tajawal:wght@400;500;700;800&display=swap',
			'has_hero'     => true,
			'hero_part'    => 'tech-ai/hero',
			'cpt'          => array( 'pds_review' ),
		),
		'jobs'        => array(
			'label'        => __( 'Cooking & Jobs', 'promovads' ),
			'prefix'       => 'cook',
			'nav_variant'  => 'pills-solid',
			'nav_aria'     => __( 'أقسام الطبخ', 'promovads' ),
			'no_icons'     => true,
			'logo_icon'    => 'fa-utensils',
			'tagline'      => __( 'وصفات وأخبار المطبخ', 'promovads' ),
			'topbar_badge' => __( 'أخبار المطبخ', 'promovads' ),
			'primary'      => '#e63329',
			'secondary'    => '#1a1a2e',
			'accent'       => '#f59e0b',
			'fonts'        => 'https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&family=Tajawal:wght@400;500;700&display=swap',
			'has_hero'     => true,
			'hero_part'    => '_shared/hero-grid',
			'cpt'          => array( 'pds_job' ),
		),
		'finance'     => array(
			'label'        => __( 'Finance', 'promovads' ),
			'prefix'       => 'fin',
			'nav_variant'  => 'pills-solid',
			'nav_aria'     => __( 'أقسام مالية', 'promovads' ),
			'no_icons'     => false,
			'logo_icon'    => 'fa-chart-line',
			'tagline'      => __( 'أخبار الاقتصاد والأسواق', 'promovads' ),
			'topbar_badge' => __( 'أخبار مالية', 'promovads' ),
			'primary'      => '#22c55e',
			'secondary'    => '#14532d',
			'accent'       => '#eab308',
			'fonts'        => 'https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&family=Tajawal:wght@400;500;700&display=swap',
			'has_hero'     => true,
			'hero_part'    => '_shared/hero-grid',
			'cpt'          => array(),
		),
		'sports'      => array(
			'label'        => __( 'Sports', 'promovads' ),
			'prefix'       => 'sport',
			'nav_variant'  => 'underline',
			'nav_aria'     => __( 'الرياضات', 'promovads' ),
			'no_icons'     => true,
			'logo_icon'    => 'fa-futbol',
			'tagline'      => __( 'أخبار رياضية وتحليلات', 'promovads' ),
			'topbar_badge' => __( 'أخبار رياضية', 'promovads' ),
			'primary'      => '#e63329',
			'secondary'    => '#1a1a2e',
			'accent'       => '#fbbf24',
			'fonts'        => 'https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&family=Tajawal:wght@400;500;700&display=swap',
			'has_hero'     => true,
			'hero_part'    => '_shared/hero-grid',
			'cpt'          => array( 'pds_match' ),
		),
		'automotive'  => array(
			'label'        => __( 'Automotive', 'promovads' ),
			'prefix'       => 'auto',
			'nav_variant'  => 'underline',
			'nav_aria'     => __( 'أقسام السيارات', 'promovads' ),
			'no_icons'     => false,
			'logo_icon'    => 'fa-car',
			'tagline'      => __( 'أخبار السيارات والمراجعات', 'promovads' ),
			'topbar_badge' => __( 'أخبار السيارات', 'promovads' ),
			'primary'      => '#ef4444',
			'secondary'    => '#18181b',
			'accent'       => '#f97316',
			'fonts'        => 'https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&family=Tajawal:wght@400;500;700&display=swap',
			'has_hero'     => true,
			'hero_part'    => '_shared/hero-grid',
			'cpt'          => array( 'pds_review' ),
		),
		'real-estate' => array(
			'label'        => __( 'Real Estate', 'promovads' ),
			'prefix'       => 're',
			'nav_variant'  => 'bar',
			'nav_aria'     => __( 'أقسام العقار', 'promovads' ),
			'no_icons'     => false,
			'logo_icon'    => 'fa-building',
			'tagline'      => __( 'عقارات واستثمار', 'promovads' ),
			'topbar_badge' => __( 'أخبار العقار', 'promovads' ),
			'primary'      => '#8b5cf6',
			'secondary'    => '#1e1b4b',
			'accent'       => '#a78bfa',
			'fonts'        => 'https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&family=Tajawal:wght@400;500;700&display=swap',
			'has_hero'     => true,
			'hero_part'    => '_shared/hero-grid',
			'cpt'          => array( 'pds_property' ),
		),
		'health'      => array(
			'label'        => __( 'Health', 'promovads' ),
			'prefix'       => 'health',
			'nav_variant'  => 'chips',
			'nav_aria'     => __( 'الأقسام الصحية', 'promovads' ),
			'no_icons'     => false,
			'logo_icon'    => 'fa-heartbeat',
			'tagline'      => __( 'صحة وعافية', 'promovads' ),
			'topbar_badge' => __( 'أخبار صحية', 'promovads' ),
			'primary'      => '#14b8a6',
			'secondary'    => '#134e4a',
			'accent'       => '#2dd4bf',
			'fonts'        => 'https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&family=Tajawal:wght@400;500;700&display=swap',
			'has_hero'     => true,
			'hero_part'    => '_shared/hero-grid',
			'cpt'          => array(),
		),
		'education'   => array(
			'label'        => __( 'Education', 'promovads' ),
			'prefix'       => 'edu',
			'nav_variant'  => 'segments',
			'nav_aria'     => __( 'أقسام التعليم', 'promovads' ),
			'no_icons'     => false,
			'logo_icon'    => 'fa-graduation-cap',
			'tagline'      => __( 'تعليم ومنح', 'promovads' ),
			'topbar_badge' => __( 'أخبار تعليمية', 'promovads' ),
			'primary'      => '#f59e0b',
			'secondary'    => '#78350f',
			'accent'       => '#fbbf24',
			'fonts'        => 'https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&family=Tajawal:wght@400;500;700&display=swap',
			'has_hero'     => true,
			'hero_part'    => '_shared/hero-grid',
			'cpt'          => array( 'pds_course' ),
		),
		'crypto'      => array(
			'label'        => __( 'Crypto', 'promovads' ),
			'prefix'       => 'crypto',
			'nav_variant'  => 'dark',
			'nav_aria'     => __( 'أقسام الكريبتو', 'promovads' ),
			'no_icons'     => false,
			'logo_icon'    => 'fab fa-bitcoin',
			'tagline'      => __( 'بلوكشين وعملات رقمية', 'promovads' ),
			'topbar_badge' => __( 'أخبار الكريبتو', 'promovads' ),
			'primary'      => '#f7931a',
			'secondary'    => '#1a1a2e',
			'accent'       => '#ffd700',
			'fonts'        => 'https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&family=Tajawal:wght@400;500;700&display=swap',
			'has_hero'     => true,
			'hero_part'    => '_shared/hero-grid',
			'cpt'          => array( 'pds_coin' ),
		),
		'gaming'      => array(
			'label'        => __( 'Gaming', 'promovads' ),
			'prefix'       => 'game',
			'nav_variant'  => 'skew',
			'nav_aria'     => __( 'أقسام الألعاب', 'promovads' ),
			'no_icons'     => false,
			'logo_icon'    => 'fa-gamepad',
			'tagline'      => __( 'ألعاب وeSports', 'promovads' ),
			'topbar_badge' => __( 'أخبار الألعاب', 'promovads' ),
			'primary'      => '#a855f7',
			'secondary'    => '#2e1065',
			'accent'       => '#c084fc',
			'fonts'        => 'https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&family=Tajawal:wght@400;500;700&display=swap',
			'has_hero'     => true,
			'hero_part'    => '_shared/hero-grid',
			'cpt'          => array(),
		),
	);

	$registry['cooking'] = $registry['jobs'];
	$registry['cooking']['label'] = __( 'Cooking', 'promovads' );

	return apply_filters( 'promovads_demo_registry', $registry );
}

/**
 * Get single demo config.
 */
function promovads_get_demo_config( ?string $slug = null ): ?array {
	if ( null === $slug ) {
		$slug = promovads_active_demo();
	}

	if ( ! $slug ) {
		return null;
	}

	$slug     = sanitize_key( $slug );
	$registry = promovads_get_demo_registry();

	return $registry[ $slug ] ?? null;
}

/**
 * Demo CSS file slug (handles cooking/jobs alias).
 */
function promovads_demo_css_slug( ?string $slug = null ): string {
	if ( null === $slug ) {
		$slug = promovads_active_demo();
	}

	$slug = sanitize_key( $slug );

	if ( 'cooking' === $slug ) {
		return 'jobs';
	}

	return $slug;
}
