<?php
/**
 * Demo breaking ticker from WordPress posts.
 *
 * @package PromovaDS_News
 */

$config = promovads_get_demo_config();
if ( ! $config || ! get_theme_mod( 'promovads_show_ticker', 1 ) ) {
	return;
}

$prefix = $config['prefix'];
$ticker_posts  = promovads_get_breaking_posts( 10 );

if ( empty( $ticker_posts ) ) {
	return;
}
?>
<div class="<?php echo esc_attr( $prefix ); ?>-ticker tech-ticker pds-demo-ticker">
	<div class="<?php echo esc_attr( $prefix ); ?>-ticker__label tech-ticker__label">
		<span class="<?php echo esc_attr( $prefix ); ?>-ticker__dot tech-ticker__dot"></span>
		<?php echo esc_html( get_theme_mod( 'promovads_ticker_label', __( 'عاجل', 'promovads' ) ) ); ?>
	</div>
	<div class="<?php echo esc_attr( $prefix ); ?>-ticker__track tech-ticker__track">
		<div class="<?php echo esc_attr( $prefix ); ?>-ticker__inner tech-ticker__inner ticker__inner" id="tickerInner">
			<?php for ( $loop = 0; $loop < 2; $loop++ ) : ?>
				<?php foreach ( $ticker_posts as $ticker_post ) : ?>
					<span class="<?php echo esc_attr( $prefix ); ?>-ticker__item tech-ticker__item">
						<a href="<?php echo esc_url( get_permalink( $ticker_post ) ); ?>"><?php echo esc_html( get_the_title( $ticker_post ) ); ?></a>
					</span>
				<?php endforeach; ?>
			<?php endfor; ?>
		</div>
	</div>
	<button class="ticker__pause" type="button" style="padding:0 12px;color:#a5b4fc;font-size:12px;background:none;border:none;cursor:pointer" title="<?php esc_attr_e( 'إيقاف', 'promovads' ); ?>"><i class="fas fa-pause"></i></button>
</div>
