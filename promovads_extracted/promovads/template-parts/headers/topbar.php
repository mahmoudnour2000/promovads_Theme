<?php
/**
 * Top Bar Template
 *
 * @package PromovaDS_News
 */

if ( ! get_theme_mod( 'promovads_show_topbar', 1 ) ) {
	return;
}
?>
<div class="pds-topbar" role="complementary">
	<div class="pds-container">
		<div class="pds-topbar__inner">

			<!-- Date + Weather -->
			<div class="pds-topbar__left">
				<span class="pds-topbar__date">
					<?php
					echo esc_html( wp_date( get_option( 'date_format' ) ) );
					?>
				</span>
			</div>

			<!-- Social Links -->
			<div class="pds-topbar__social">
				<?php
				$networks = array(
					'facebook'  => array( 'icon' => 'fab fa-facebook-f',  'label' => 'Facebook' ),
					'twitter'   => array( 'icon' => 'fab fa-x-twitter',   'label' => 'Twitter / X' ),
					'instagram' => array( 'icon' => 'fab fa-instagram',   'label' => 'Instagram' ),
					'youtube'   => array( 'icon' => 'fab fa-youtube',     'label' => 'YouTube' ),
					'telegram'  => array( 'icon' => 'fab fa-telegram',    'label' => 'Telegram' ),
				);

				foreach ( $networks as $key => $net ) :
					$url = get_theme_mod( 'promovads_social_' . $key, '' );
					if ( $url ) :
						?>
						<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $net['label'] ); ?>">
							<i class="<?php echo esc_attr( $net['icon'] ); ?>" aria-hidden="true"></i>
						</a>
						<?php
					endif;
				endforeach;
				?>
			</div>

			<!-- Right Actions -->
			<div class="pds-topbar__actions">
				<?php
				$edition = get_theme_mod( 'promovads_edition_badge', '' );
				if ( $edition ) :
					?>
					<span class="pds-topbar__edition"><?php echo esc_html( $edition ); ?></span>
					<?php
				endif;
				?>
				<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url( admin_url() ); ?>" class="pds-topbar__link">
						<?php esc_html_e( 'Dashboard', 'promovads' ); ?>
					</a>
				<?php else : ?>
					<a href="<?php echo esc_url( wp_login_url() ); ?>" class="pds-topbar__link">
						<?php esc_html_e( 'Login', 'promovads' ); ?>
					</a>
				<?php endif; ?>
			</div>

		</div>
	</div>
</div>
