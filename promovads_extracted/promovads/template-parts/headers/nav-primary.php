<?php
/**
 * Primary Navigation
 *
 * @package PromovaDS_News
 */
?>
<nav class="pds-nav__inner" aria-label="<?php esc_attr_e( 'Main Navigation', 'promovads' ); ?>">
	<?php
	wp_nav_menu(
		array(
			'theme_location'  => 'primary',
			'menu_id'         => 'primary-menu',
			'menu_class'      => 'pds-nav__menu',
			'container'       => false,
			'fallback_cb'     => 'promovads_primary_nav_fallback',
			'walker'          => new PromovaDS_Nav_Walker(),
			'items_wrap'      => '<ul id="%1$s" class="%2$s" role="menubar">%3$s</ul>',
		)
	);
	?>
</nav>
