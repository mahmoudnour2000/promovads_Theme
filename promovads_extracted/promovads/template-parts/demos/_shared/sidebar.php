<?php
/**
 * Demo sidebar — matches home layout widget style.
 *
 * @package PromovaDS_News
 */

$config  = promovads_get_demo_config();
$primary = promovads_get_theme_colors()['primary'] ?? ( $config['primary'] ?? '#6366f1' );
$sidebar = is_archive() ? 'sidebar-archive' : 'sidebar-main';
?>
<div class="widget">
	<div class="widget__title"><?php esc_html_e( 'بحث', 'promovads' ); ?></div>
	<div class="widget__body" style="padding:14px">
		<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="pds-demo-search-form">
			<input type="search" name="s" placeholder="<?php esc_attr_e( 'ابحث في الأخبار…', 'promovads' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>">
			<button type="submit"><i class="fas fa-search"></i></button>
		</form>
	</div>
</div>

<?php get_template_part( 'template-parts/demos/_shared/widgets', 'trending-hot' ); ?>

<?php promovads_ad( 'sidebar' ); ?>

<?php if ( is_active_sidebar( $sidebar ) ) : ?>
	<?php dynamic_sidebar( $sidebar ); ?>
<?php endif; ?>
