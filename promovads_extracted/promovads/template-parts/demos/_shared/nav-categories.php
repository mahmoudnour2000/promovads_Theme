<?php
/**
 * Category-based navigation with overflow «المزيد» dropdown.
 *
 * @package PromovaDS_News
 *
 * @var array $args Template args.
 */

$config = promovads_get_demo_config();
if ( ! $config ) {
	return;
}

$prefix      = $config['prefix'];
$variant     = $config['nav_variant'];
$aria        = $config['nav_aria'];
$no_icons    = ! empty( $config['no_icons'] );
$categories  = promovads_get_nav_categories();
$archive_url = promovads_posts_archive_url();
?>
<nav class="<?php echo esc_attr( $prefix ); ?>-nav site-nav site-nav--<?php echo esc_attr( $variant ); ?> pds-cat-nav" aria-label="<?php echo esc_attr( $aria ); ?>" data-nav-overflow>
	<ul class="<?php echo esc_attr( $prefix ); ?>-nav__list site-nav__list pds-cat-nav__list" role="menubar">
		<li class="<?php echo esc_attr( $prefix ); ?>-nav__item site-nav__item pds-cat-nav__item<?php echo promovads_nav_is_active( 'home' ) ? ' active' : ''; ?>" data-nav-item>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php if ( ! $no_icons ) : ?>
					<i class="fas fa-home" aria-hidden="true"></i>
				<?php endif; ?>
				<span><?php esc_html_e( 'الرئيسية', 'promovads' ); ?></span>
			</a>
		</li>

		<?php foreach ( $categories as $cat ) :
			$color = promovads_get_category_color( $cat->term_id, $config['primary'] ?? '#6366f1' );
			$icon  = promovads_get_category_icon( $cat->term_id, 'fa-folder' );
			$active = promovads_nav_is_active( 'category', $cat ) ? ' active' : '';
			?>
			<li class="<?php echo esc_attr( $prefix ); ?>-nav__item site-nav__item pds-cat-nav__item<?php echo esc_attr( $active ); ?>" data-nav-item data-cat="<?php echo esc_attr( $cat->slug ); ?>" style="--nav-accent:<?php echo esc_attr( $color ); ?>">
				<a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>">
					<?php if ( ! $no_icons ) : ?>
						<i class="<?php echo esc_attr( str_starts_with( $icon, 'fab' ) ? $icon : 'fas ' . $icon ); ?>" aria-hidden="true"></i>
					<?php endif; ?>
					<span><?php echo esc_html( $cat->name ); ?></span>
				</a>
			</li>
		<?php endforeach; ?>

		<li class="<?php echo esc_attr( $prefix ); ?>-nav__item site-nav__item pds-cat-nav__more pds-cat-nav__item--more" data-nav-more hidden>
			<button type="button" class="pds-cat-nav__more-btn" aria-expanded="false" aria-haspopup="true">
				<span><?php esc_html_e( 'المزيد', 'promovads' ); ?></span>
				<i class="fas fa-chevron-down" aria-hidden="true"></i>
			</button>
			<ul class="pds-cat-nav__dropdown" role="menu"></ul>
		</li>
	</ul>
</nav>
