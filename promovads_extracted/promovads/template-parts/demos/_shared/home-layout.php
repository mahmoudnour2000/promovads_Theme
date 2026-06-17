<?php
/**
 * Shared demo homepage layout — all content from WordPress.
 *
 * @package PromovaDS_News
 */

$config     = promovads_get_demo_config();
$prefix     = $config['prefix'] ?? 'pds';
$categories = promovads_get_nav_categories( array( 'number' => 6 ) );
$latest     = promovads_get_posts( array( 'posts_per_page' => 8 ) );
$archive    = promovads_posts_archive_url();
?>
<main id="primary" class="site-main pds-demo-home" role="main" style="padding:36px 0 60px">
	<div class="wrap">
		<div class="grid g-main" style="gap:32px">
			<div>
				<?php if ( empty( $categories ) && ! $latest->have_posts() ) : ?>
					<div class="latest-block" style="text-align:center;padding:48px 24px">
						<h2><?php esc_html_e( 'ابدأ بإضافة محتوى', 'promovads' ); ?></h2>
						<p style="color:var(--text-muted,#64748b);margin:12px 0 20px"><?php esc_html_e( 'أضف تصنيفات ومقالات من لوحة التحكم — ستظهر تلقائياً في الصفحة الرئيسية.', 'promovads' ); ?></p>
						<a href="<?php echo esc_url( admin_url( 'post-new.php' ) ); ?>" class="cat-section__btn"><?php esc_html_e( 'إضافة مقال', 'promovads' ); ?></a>
						<a href="<?php echo esc_url( admin_url( 'edit-tags.php?taxonomy=category' ) ); ?>" class="cat-section__btn" style="margin-inline-start:8px"><?php esc_html_e( 'إدارة التصنيفات', 'promovads' ); ?></a>
					</div>
				<?php endif; ?>

				<?php foreach ( $categories as $index => $cat ) :
					$cat_posts = promovads_get_category_posts( (int) $cat->term_id, 3 );
					if ( empty( $cat_posts ) ) {
						continue;
					}
					promovads_render_skin(
						'cat_section',
						array(
							'category' => $cat,
							'posts'    => $cat_posts,
						)
					);
				endforeach; ?>

				<?php if ( $latest->have_posts() ) :
					promovads_render_skin(
						'latest',
						array(
							'query'       => $latest,
							'archive_url' => $archive,
						)
					);
				endif; ?>
			</div>

			<aside class="sidebar" role="complementary">
				<div class="widget">
					<div class="widget__title"><?php esc_html_e( 'بحث', 'promovads' ); ?></div>
					<div class="widget__body" style="padding:14px">
						<?php get_search_form(); ?>
					</div>
				</div>

				<?php get_template_part( 'template-parts/demos/_shared/widgets', 'trending-hot' ); ?>

				<?php if ( is_active_sidebar( 'sidebar-main' ) ) : ?>
					<?php dynamic_sidebar( 'sidebar-main' ); ?>
				<?php endif; ?>
			</aside>
		</div>
	</div>
</main>
