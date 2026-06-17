<?php
/**
 * The template for displaying search forms
 *
 * @package PromovaDS_News
 */

$unique_id = wp_unique_id( 'search-form-' );
$config    = promovads_get_demo_config();
$is_demo   = (bool) $config;

if ( $is_demo ) :
	$primary = $config['primary'] ?? '#6366f1';
	?>
	<form role="search" method="get" class="pds-demo-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<input type="search" id="<?php echo esc_attr( $unique_id ); ?>" placeholder="<?php echo esc_attr_x( 'ابحث في الموقع…', 'placeholder', 'promovads' ); ?>" value="<?php echo get_search_query(); ?>" name="s" required />
		<button type="submit" style="background-color: <?php echo esc_attr( $primary ); ?>" aria-label="<?php esc_attr_e( 'Search', 'promovads' ); ?>">
			<i class="fas fa-search" aria-hidden="true"></i>
		</button>
	</form>
<?php else : ?>
	<form role="search" method="get" class="pds-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<input type="search" id="<?php echo esc_attr( $unique_id ); ?>" placeholder="<?php echo esc_attr_x( 'Search...', 'placeholder', 'promovads' ); ?>" value="<?php echo get_search_query(); ?>" name="s" required />
		<button type="submit" class="pds-search-form__btn" aria-label="<?php esc_attr_e( 'Search', 'promovads' ); ?>">
			<i class="fas fa-search" aria-hidden="true"></i>
		</button>
	</form>
<?php endif; ?>
