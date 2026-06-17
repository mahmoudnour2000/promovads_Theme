<?php
/**
 * Skin variant registry — catalog of layout models per section.
 *
 * @package PromovaDS_News
 */

defined( 'ABSPATH' ) || exit;

/**
 * Skin section types.
 *
 * @return array<string, string>
 */
function promovads_skin_types(): array {
	return array(
		'hero'           => __( 'الهيرو سكشن', 'promovads' ),
		'nav'            => __( 'الناف بار', 'promovads' ),
		'cat_section'    => __( 'سكشن الأقسام', 'promovads' ),
		'latest'         => __( 'آخر الأخبار', 'promovads' ),
		'archive_header' => __( 'عنوان صفحة القسم', 'promovads' ),
	);
}

/**
 * Full variant catalog.
 *
 * status: ready | planned
 *
 * @return array<string, array<string, array<string, mixed>>>
 */
function promovads_skin_registry(): array {
	return array(
		'hero' => array(
			'grid-lead-side'  => array(
				'label'  => __( 'كبير + جانبي', 'promovads' ),
				'desc'   => __( 'خبر رئيسي كبير مع 2 خبر جانبي — الأكثر شيوعاً', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-table-columns',
			),
			'grid-3-equal'    => array(
				'label'  => __( '3 أعمدة متساوية', 'promovads' ),
				'desc'   => __( 'ثلاث بطاقات بنفس الحجم في صف واحد', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-grip',
			),
			'carousel'        => array(
				'label'  => __( 'سلايدر أفقي', 'promovads' ),
				'desc'   => __( 'تمرير أفقي للأخبار المميزة', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-images',
			),
			'full-bleed'      => array(
				'label'  => __( 'صورة كاملة', 'promovads' ),
				'desc'   => __( 'خبر واحد بعرض كامل مع overlay', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-expand',
			),
			'magazine-stack'  => array(
				'label'  => __( 'مجلة عمودية', 'promovads' ),
				'desc'   => __( 'بطاقات مكدسة بأحجام متدرجة', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-layer-group',
			),
			'mosaic-4'        => array(
				'label'  => __( 'فسيفساء 4', 'promovads' ),
				'desc'   => __( '4 بلاطات بأحجام مختلفة (Bento)', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-th-large',
			),
			'ranked-list'     => array(
				'label'  => __( 'قائمة مرقمة', 'promovads' ),
				'desc'   => __( 'أخبار مرتبة 01، 02، 03…', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-list-ol',
			),
			'video-style'     => array(
				'label'  => __( 'ستايل فيديو', 'promovads' ),
				'desc'   => __( 'صورة مع زر تشغيل ومدة القراءة', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-circle-play',
			),
			'breaking-split'  => array(
				'label'  => __( 'عاجل + عادي', 'promovads' ),
				'desc'   => __( 'عمود عاجل أحمر + عمود أخبار عادية', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-bolt',
			),
			'minimal-text'    => array(
				'label'  => __( 'نصي بسيط', 'promovads' ),
				'desc'   => __( 'عناوين فقط بدون صور كبيرة — سريع التحميل', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-align-right',
			),
			'bento-grid'      => array(
				'label'  => __( 'Bento Grid', 'promovads' ),
				'desc'   => __( 'شبكة حديثة غير متساوية', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-table-cells-large',
			),
			'dual-feature'    => array(
				'label'  => __( 'خبران متساويان', 'promovads' ),
				'desc'   => __( 'عمودين 50/50 لخبرين مميزين', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-columns',
			),
		),
		'nav' => array(
			'pills'           => array(
				'label'  => __( 'حبوب Pills', 'promovads' ),
				'desc'   => __( 'أزرار دائرية مع hover ملون', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-capsules',
			),
			'pills-solid'     => array(
				'label'  => __( 'حبوب ممتلئة', 'promovads' ),
				'desc'   => __( 'خلفية ملونة للقسم النشط', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-circle',
			),
			'underline'       => array(
				'label'  => __( 'خط سفلي', 'promovads' ),
				'desc'   => __( 'تبويبات بخط تحت العنصر النشط', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-minus',
			),
			'bar'             => array(
				'label'  => __( 'شريط كامل', 'promovads' ),
				'desc'   => __( 'خلفية شريط موحد للقائمة', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-bars',
			),
			'chips'           => array(
				'label'  => __( 'رقائق Chips', 'promovads' ),
				'desc'   => __( 'تصنيفات صغيرة مدمجة', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-tags',
			),
			'segments'        => array(
				'label'  => __( 'أقسام متصلة', 'promovads' ),
				'desc'   => __( 'تبويبات متلاصقة بدون فراغ', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-grip-lines',
			),
			'dark'            => array(
				'label'  => __( 'داكن', 'promovads' ),
				'desc'   => __( 'خلفية داكنة ونص فاتح', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-moon',
			),
			'skew'            => array(
				'label'  => __( 'مائل Skew', 'promovads' ),
				'desc'   => __( 'عناصر بزاوية مائلة — مناسب للألعاب', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-slash',
			),
			'mega-menu'       => array(
				'label'  => __( 'قائمة ضخمة', 'promovads' ),
				'desc'   => __( 'Dropdown بآخر المقالات لكل قسم', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-sitemap',
			),
			'icon-tabs'       => array(
				'label'  => __( 'أيقونات فقط', 'promovads' ),
				'desc'   => __( 'أيقونة لكل قسم بدون نص', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-icons',
			),
		),
		'cat_section' => array(
			'grid-cards'      => array(
				'label'  => __( '3 بطاقات', 'promovads' ),
				'desc'   => __( 'شبكة 3 أعمدة — الافتراضي الحالي', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-grip',
			),
			'horizontal-scroll' => array(
				'label'  => __( 'تمرير أفقي', 'promovads' ),
				'desc'   => __( 'بطاقات تتحرك يمين/يسار', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-arrows-left-right',
			),
			'featured-list'   => array(
				'label'  => __( 'بطل + قائمة', 'promovads' ),
				'desc'   => __( 'مقال كبير + قائمة جانبية', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-list',
			),
			'masonry-2'       => array(
				'label'  => __( 'عمودين Masonry', 'promovads' ),
				'desc'   => __( 'تخطيط عمودين بارتفاعات مختلفة', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-table-cells',
			),
			'timeline'        => array(
				'label'  => __( 'خط زمني', 'promovads' ),
				'desc'   => __( 'مقالات على خط عمودي', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-timeline',
			),
			'compact-list'    => array(
				'label'  => __( 'قائمة مدمجة', 'promovads' ),
				'desc'   => __( 'عناوين + صورة صغيرة فقط', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-list-ul',
			),
			'magazine-row'    => array(
				'label'  => __( 'صف مجلة', 'promovads' ),
				'desc'   => __( 'مقال عريض + مقالين صغار', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-newspaper',
			),
			'numbered'        => array(
				'label'  => __( 'مرقّم', 'promovads' ),
				'desc'   => __( 'أرقام كبيرة 01 02 03', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-hashtag',
			),
			'overlay-strip'   => array(
				'label'  => __( 'شريط صور', 'promovads' ),
				'desc'   => __( 'صور بعرض كامل مع عنوان overlay', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-panorama',
			),
			'tabbed'          => array(
				'label'  => __( 'تبويبات داخلية', 'promovads' ),
				'desc'   => __( 'تبديل بين فرعيّات القسم', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-folder-tree',
			),
		),
		'latest' => array(
			'timeline-list'   => array(
				'label'  => __( 'قائمة زمنية', 'promovads' ),
				'desc'   => __( 'صورة + عنوان + meta — الافتراضي', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-clock',
			),
			'grid-4'          => array(
				'label'  => __( 'شبكة 4', 'promovads' ),
				'desc'   => __( '4 بطاقات في صفين', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-grip',
			),
			'compact-rows'    => array(
				'label'  => __( 'صفوف مدمجة', 'promovads' ),
				'desc'   => __( 'عناوين فقط مع وقت النشر', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-bars-staggered',
			),
			'card-carousel'   => array(
				'label'  => __( 'كاروسيل', 'promovads' ),
				'desc'   => __( 'بطاقات متحركة', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-sliders',
			),
			'split-featured'  => array(
				'label'  => __( 'مميز + باقي', 'promovads' ),
				'desc'   => __( 'خبر كبير يسار + قائمة يمين', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-table-columns',
			),
			'minimal-links'   => array(
				'label'  => __( 'روابط فقط', 'promovads' ),
				'desc'   => __( 'بدون صور — خفيف جداً', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-link',
			),
			'magazine-cols'   => array(
				'label'  => __( 'عمودين مجلة', 'promovads' ),
				'desc'   => __( 'تخطيط مجلة كلاسيكي', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-columns',
			),
			'top-10'          => array(
				'label'  => __( 'توب 10', 'promovads' ),
				'desc'   => __( 'ترتيب الأكثر قراءة', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-ranking-star',
			),
		),
		'archive_header' => array(
			'dark-banner'     => array(
				'label'  => __( 'بانر داكن', 'promovads' ),
				'desc'   => __( 'خلفية داكنة + عنوان أبيض — الافتراضي', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-heading',
			),
			'minimal-line'    => array(
				'label'  => __( 'خط بسيط', 'promovads' ),
				'desc'   => __( 'عنوان مع خط ملون فقط', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-minus',
			),
			'with-cover'      => array(
				'label'  => __( 'صورة غلاف', 'promovads' ),
				'desc'   => __( 'خلفية من صورة القسم', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-image',
			),
			'gradient-wave'   => array(
				'label'  => __( 'تدرج موجة', 'promovads' ),
				'desc'   => __( 'خلفية gradient مع موجة SVG', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-water',
			),
			'breadcrumb-inline' => array(
				'label'  => __( 'مع Breadcrumb', 'promovads' ),
				'desc'   => __( 'مسار تنقل فوق العنوان', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-route',
			),
			'split-stats'     => array(
				'label'  => __( 'عنوان + إحصائيات', 'promovads' ),
				'desc'   => __( 'العنوان يسار والعدد يمين', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-chart-simple',
			),
			'glass-card'      => array(
				'label'  => __( 'بطاقة زجاجية', 'promovads' ),
				'desc'   => __( 'Glassmorphism فوق خلفية ملونة', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-wand-magic-sparkles',
			),
			'pattern-bg'      => array(
				'label'  => __( 'خلفية نمطية', 'promovads' ),
				'desc'   => __( 'Pattern هندسي خلف العنوان', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-shapes',
			),
			'author-card'     => array(
				'label'  => __( 'بطاقة كاتب', 'promovads' ),
				'desc'   => __( 'صورة وbio للكاتب في الأرشيف', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-user',
			),
			'tag-cloud'       => array(
				'label'  => __( 'وسوم سحابة', 'promovads' ),
				'desc'   => __( 'مناسب لصفحات الوسوم', 'promovads' ),
				'status' => 'ready',
				'icon'   => 'fa-cloud',
			),
		),
	);
}

/**
 * Default skin per demo slug.
 *
 * @return array<string, string>
 */
function promovads_skin_defaults( ?string $demo_slug = null ): array {
	if ( null === $demo_slug ) {
		$demo_slug = promovads_active_demo();
	}

	$config = promovads_get_demo_config( $demo_slug );
	$nav    = $config['nav_variant'] ?? 'pills';

	$defaults = array(
		'hero'           => 'grid-lead-side',
		'nav'            => in_array( $nav, array( 'pills', 'pills-solid', 'underline' ), true ) ? $nav : 'pills',
		'cat_section'    => 'grid-cards',
		'latest'         => 'timeline-list',
		'archive_header' => 'dark-banner',
	);

	// Tech-ai uses custom hero file — map to grid-lead-side skin.
	if ( 'tech-ai' === $demo_slug ) {
		$defaults['hero'] = 'grid-lead-side';
	}

	return apply_filters( 'promovads_skin_defaults', $defaults, $demo_slug );
}

/**
 * Get active skin slug for a section type.
 */
function promovads_get_skin( string $type ): string {
	$demo = promovads_active_demo();
	if ( ! $demo ) {
		return promovads_skin_defaults( $demo )[ $type ] ?? 'grid-lead-side';
	}

	$all     = get_theme_mod( 'promovads_demo_skins', array() );
	$slug    = $all[ $demo ][ $type ] ?? '';
	$registry = promovads_skin_registry();

	if ( $slug && isset( $registry[ $type ][ $slug ] ) ) {
		return $slug;
	}

	return promovads_skin_defaults( $demo )[ $type ] ?? array_key_first( $registry[ $type ] ?? array() );
}

/**
 * Get all active skins for current demo.
 *
 * @return array<string, string>
 */
function promovads_get_all_skins(): array {
	$types = array_keys( promovads_skin_types() );
	$skins = array();
	foreach ( $types as $type ) {
		$skins[ $type ] = promovads_get_skin( $type );
	}
	return $skins;
}

/**
 * Save skins for active demo.
 *
 * @param array<string, string> $skins
 */
function promovads_save_demo_skins( array $skins ): void {
	$demo = promovads_active_demo();
	if ( ! $demo ) {
		return;
	}

	$registry = promovads_skin_registry();
	$defaults = promovads_skin_defaults( $demo );
	$all      = get_theme_mod( 'promovads_demo_skins', array() );
	$clean    = array();

	foreach ( array_keys( promovads_skin_types() ) as $type ) {
		$slug = sanitize_key( $skins[ $type ] ?? '' );
		if ( isset( $registry[ $type ][ $slug ] ) ) {
			$clean[ $type ] = $slug;
		} else {
			$clean[ $type ] = $defaults[ $type ] ?? $slug;
		}
	}

	$all[ $demo ] = $clean;
	set_theme_mod( 'promovads_demo_skins', $all );
}

/**
 * Reset skins to demo defaults.
 */
function promovads_reset_demo_skins( ?string $demo_slug = null ): void {
	$demo = $demo_slug ?: promovads_active_demo();
	if ( ! $demo ) {
		return;
	}
	$all         = get_theme_mod( 'promovads_demo_skins', array() );
	$all[ $demo ] = promovads_skin_defaults( $demo );
	set_theme_mod( 'promovads_demo_skins', $all );
}

/**
 * Render a skin template part.
 *
 * @param array<string, mixed> $args Passed to template.
 */
function promovads_render_skin( string $type, array $args = array() ): void {
	$slug     = promovads_get_skin( $type );
	$registry = promovads_skin_registry();
	$variant  = $registry[ $type ][ $slug ] ?? null;

	$path = 'template-parts/demos/skins/' . $type . '/' . $slug;
	$full = PROMOVADS_DIR . '/' . $path . '.php';

	$args['skin_type'] = $type;
	$args['skin_slug'] = $slug;

	if ( file_exists( $full ) ) {
		get_template_part( $path, null, $args );
		return;
	}

	$render_fn = 'promovads_skin_render_' . $type;
	if ( function_exists( $render_fn ) ) {
		$render_fn( $slug, $args );
		return;
	}

	// Last resort: first existing template in this type folder.
	foreach ( $registry[ $type ] ?? array() as $fallback_slug => $info ) {
		$fb = PROMOVADS_DIR . '/template-parts/demos/skins/' . $type . '/' . $fallback_slug . '.php';
		if ( file_exists( $fb ) ) {
			get_template_part( 'template-parts/demos/skins/' . $type . '/' . $fallback_slug, null, $args );
			return;
		}
	}
}

/**
 * Body classes for active skins.
 *
 * @param array $classes
 * @return array
 */
function promovads_skin_body_classes( array $classes ): array {
	if ( ! promovads_active_demo() ) {
		return $classes;
	}
	foreach ( promovads_get_all_skins() as $type => $slug ) {
		$classes[] = 'pds-skin-' . sanitize_html_class( $type ) . '-' . sanitize_html_class( $slug );
	}
	return $classes;
}
add_filter( 'body_class', 'promovads_skin_body_classes', 20 );

/**
 * Shared archive header inner markup.
 */
function promovads_skin_archive_inner( string $style = 'default' ): void {
	if ( is_category() ) {
		if ( 'minimal' !== $style ) {
			echo '<span class="label">' . esc_html__( 'قسم', 'promovads' ) . '</span>';
		}
		echo '<h1>' . esc_html( single_cat_title( '', false ) ) . '</h1>';
		if ( category_description() ) {
			echo '<p>' . wp_kses_post( category_description() ) . '</p>';
		}
	} elseif ( is_tag() ) {
		echo '<span class="label">' . esc_html__( 'وسم', 'promovads' ) . '</span>';
		echo '<h1>#' . esc_html( single_tag_title( '', false ) ) . '</h1>';
	} elseif ( is_author() ) {
		echo '<span class="label">' . esc_html__( 'كاتب', 'promovads' ) . '</span>';
		echo '<h1>' . esc_html( get_the_author() ) . '</h1>';
		$bio = get_the_author_meta( 'description', get_queried_object_id() );
		if ( $bio ) {
			echo '<p>' . esc_html( $bio ) . '</p>';
		}
	} elseif ( promovads_is_news_archive() ) {
		echo '<span class="label">' . esc_html__( 'أرشيف', 'promovads' ) . '</span>';
		echo '<h1>' . esc_html__( 'كل الأخبار', 'promovads' ) . '</h1>';
	} elseif ( is_search() ) {
		echo '<span class="label">' . esc_html__( 'نتائج البحث', 'promovads' ) . '</span>';
		echo '<h1>' . sprintf( esc_html__( 'نتائج البحث عن: "%s"', 'promovads' ), esc_html( get_search_query() ) ) . '</h1>';
	} else {
		echo '<h1>';
		the_archive_title();
		echo '</h1>';
		the_archive_description( '<p>', '</p>' );
	}

	global $wp_query;
	printf(
		'<span class="count">%s</span>',
		esc_html(
			sprintf(
				/* translators: %d: post count */
				_n( '%d مقال', '%d مقال', $wp_query->found_posts, 'promovads' ),
				absint( $wp_query->found_posts )
			)
		)
	);
}

/**
 * Admin: layout skins page.
 */
function promovads_admin_skin_page(): void {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$active = promovads_active_demo();
	if ( ! $active ) {
		echo '<div class="wrap pds-admin"><div class="notice notice-warning"><p>' . esc_html__( 'فعّل ديمو أولاً من «استيراد الديمو» ثم اختر نماذج الأقسام.', 'promovads' ) . '</p></div></div>';
		return;
	}

	if ( isset( $_POST['promovads_skin_save'] ) && check_admin_referer( 'promovads_skin' ) ) {
		$posted = array();
		foreach ( array_keys( promovads_skin_types() ) as $type ) {
			if ( isset( $_POST[ 'pds_skin_' . $type ] ) ) {
				$posted[ $type ] = sanitize_key( wp_unslash( $_POST[ 'pds_skin_' . $type ] ) );
			}
		}
		promovads_save_demo_skins( $posted );
		echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'تم حفظ نماذج التصميم.', 'promovads' ) . '</p></div>';
	}

	if ( isset( $_POST['promovads_skin_reset'] ) && check_admin_referer( 'promovads_skin' ) ) {
		promovads_reset_demo_skins( $active );
		echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'تمت إعادة النماذج للافتراضي.', 'promovads' ) . '</p></div>';
	}

	$registry  = promovads_skin_registry();
	$types     = promovads_skin_types();
	$current   = promovads_get_all_skins();
	$config    = promovads_get_demo_config( $active );
	$meta      = promovads_skin_section_meta();
	$counts    = promovads_skin_registry_counts();
	$demo_clr  = $config['primary'] ?? '#6366f1';
	$type_idx  = 0;
	?>
	<div class="wrap pds-admin pds-skins-page" style="--pds-skin-accent:<?php echo esc_attr( $demo_clr ); ?>">
		<header class="pds-skins-hero">
			<div class="pds-skins-hero__main">
				<span class="pds-skins-hero__eyebrow"><?php esc_html_e( 'Layout System', 'promovads' ); ?></span>
				<h1><?php esc_html_e( 'نماذج التصميم', 'promovads' ); ?></h1>
				<p class="pds-skins-hero__lead">
					<?php
					printf(
						/* translators: %s: demo name */
						esc_html__( 'صمّم تجربة %s باختيار نموذج مستقل لكل قسم — التغييرات تظهر فوراً على الموقع.', 'promovads' ),
						esc_html( $config['label'] ?? $active )
					);
					?>
				</p>
			</div>
			<div class="pds-skins-hero__stats">
				<div class="pds-skins-stat">
					<span class="pds-skins-stat__value"><?php echo esc_html( (string) $counts['ready'] ); ?></span>
					<span class="pds-skins-stat__label"><?php esc_html_e( 'نموذج جاهز', 'promovads' ); ?></span>
				</div>
				<div class="pds-skins-stat">
					<span class="pds-skins-stat__value"><?php echo esc_html( (string) $counts['planned'] ); ?></span>
					<span class="pds-skins-stat__label"><?php esc_html_e( 'قيد التطوير', 'promovads' ); ?></span>
				</div>
				<div class="pds-skins-stat pds-skins-stat--demo">
					<span class="pds-skins-stat__dot" style="background:<?php echo esc_attr( $demo_clr ); ?>"></span>
					<span class="pds-skins-stat__label"><?php echo esc_html( $config['label'] ?? $active ); ?></span>
				</div>
			</div>
			<div class="pds-skins-hero__actions">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="button button-secondary" target="_blank" rel="noopener">
					<i class="fas fa-external-link-alt" aria-hidden="true"></i>
					<?php esc_html_e( 'معاينة الموقع', 'promovads' ); ?>
				</a>
			</div>
		</header>

		<nav class="pds-skins-jump" aria-label="<?php esc_attr_e( 'انتقال سريع', 'promovads' ); ?>">
			<?php foreach ( $types as $type_key => $type_label ) : ?>
				<a href="#pds-skin-<?php echo esc_attr( $type_key ); ?>" class="pds-skins-jump__link">
					<i class="fas <?php echo esc_attr( $meta[ $type_key ]['icon'] ?? 'fa-palette' ); ?>" aria-hidden="true"></i>
					<?php echo esc_html( $type_label ); ?>
				</a>
			<?php endforeach; ?>
		</nav>

		<form method="post" class="pds-skins-form" id="pds-skins-form">
			<?php wp_nonce_field( 'promovads_skin' ); ?>

			<?php foreach ( $types as $type_key => $type_label ) :
				++$type_idx;
				$active_slug  = $current[ $type_key ] ?? '';
				$active_label = $registry[ $type_key ][ $active_slug ]['label'] ?? '';
				$section_icon = $meta[ $type_key ]['icon'] ?? 'fa-palette';
				$section_hint = $meta[ $type_key ]['hint'] ?? '';
				$total_count = count( $registry[ $type_key ] ?? array() );
				?>
				<section class="pds-skin-section" id="pds-skin-<?php echo esc_attr( $type_key ); ?>" data-skin-section="<?php echo esc_attr( $type_key ); ?>">
					<header class="pds-skin-section__head">
						<div class="pds-skin-section__id">
							<span class="pds-skin-section__num"><?php echo esc_html( str_pad( (string) $type_idx, 2, '0', STR_PAD_LEFT ) ); ?></span>
							<span class="pds-skin-section__icon"><i class="fas <?php echo esc_attr( $section_icon ); ?>" aria-hidden="true"></i></span>
						</div>
						<div class="pds-skin-section__copy">
							<h2><?php echo esc_html( $type_label ); ?></h2>
							<?php if ( $section_hint ) : ?>
								<p><?php echo esc_html( $section_hint ); ?></p>
							<?php endif; ?>
						</div>
						<div class="pds-skin-section__meta">
							<span class="pds-skin-section__count"><?php echo esc_html( (string) $total_count ); ?> <?php esc_html_e( 'نموذج', 'promovads' ); ?></span>
							<span class="pds-skin-section__active" data-active-label>
								<?php esc_html_e( 'النشط:', 'promovads' ); ?>
								<strong><?php echo esc_html( $active_label ); ?></strong>
							</span>
						</div>
					</header>

					<div class="pds-skin-grid" role="radiogroup" aria-label="<?php echo esc_attr( $type_label ); ?>">
						<?php foreach ( $registry[ $type_key ] ?? array() as $slug => $variant ) :
							$is_checked = $active_slug === $slug;
							?>
							<label class="pds-skin-card<?php echo $is_checked ? ' is-selected' : ''; ?>" data-skin-label="<?php echo esc_attr( $variant['label'] ); ?>">
								<input type="radio" name="pds_skin_<?php echo esc_attr( $type_key ); ?>" value="<?php echo esc_attr( $slug ); ?>" <?php checked( $is_checked ); ?>>

								<div class="pds-skin-card__preview">
									<?php echo promovads_skin_mock_markup( $type_key, $slug ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</div>

								<div class="pds-skin-card__body">
									<div class="pds-skin-card__row">
										<strong class="pds-skin-card__title"><?php echo esc_html( $variant['label'] ); ?></strong>
										<span class="pds-skin-card__badge pds-skin-card__badge--ready"><?php esc_html_e( 'جاهز', 'promovads' ); ?></span>
									</div>
									<p class="pds-skin-card__desc"><?php echo esc_html( $variant['desc'] ?? '' ); ?></p>
								</div>

								<span class="pds-skin-card__check" aria-hidden="true"><i class="fas fa-check"></i></span>
							</label>
						<?php endforeach; ?>
					</div>
				</section>
			<?php endforeach; ?>

			<div class="pds-skins-sticky" id="pds-skins-sticky">
				<div class="pds-skins-sticky__inner">
					<p class="pds-skins-sticky__hint">
						<i class="fas fa-circle-info" aria-hidden="true"></i>
						<?php esc_html_e( 'احفظ التغييرات لتطبيق النماذج على الموقع', 'promovads' ); ?>
					</p>
					<div class="pds-skins-sticky__actions">
						<button type="submit" name="promovads_skin_reset" class="button button-secondary"><?php esc_html_e( 'إعادة للافتراضي', 'promovads' ); ?></button>
						<button type="submit" name="promovads_skin_save" class="button button-primary button-hero"><?php esc_html_e( 'حفظ النماذج', 'promovads' ); ?></button>
					</div>
				</div>
			</div>
		</form>
	</div>
	<?php
}
