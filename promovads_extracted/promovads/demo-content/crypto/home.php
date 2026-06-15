<?php
/**
 * Crypto Demo Homepage
 * Coin tracker, market trends, news + analysis
 *
 * @package PromovaDS_News
 */
$coins = new WP_Query( array( 'post_type' => 'pds_coin', 'posts_per_page' => 10, 'post_status' => 'publish', 'meta_key' => 'pds_rank', 'orderby' => 'meta_value_num', 'order' => 'ASC' ) );
?>

<main id="primary" class="site-main pds-demo-crypto" role="main">

	<!-- Coin Tracker Table -->
	<div style="background:#0d1117;padding:2rem 0;">
		<div class="pds-container">
			<div class="pds-section-header" style="border-color:rgba(255,255,255,.1);">
				<h2 class="pds-section-title" style="color:#fff;">Top <span>Coins</span></h2>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'pds_coin' ) ); ?>" class="pds-see-all" style="color:var(--color-primary);">
					View All <i class="fas fa-arrow-right"></i>
				</a>
			</div>

			<div style="overflow-x:auto;">
				<table style="width:100%;border-collapse:collapse;">
					<thead>
						<tr style="border-bottom:1px solid rgba(255,255,255,.1);">
							<?php
							foreach ( array( '#', 'Name', 'Price', '24h %', 'Market Cap', 'Volume 24h' ) as $h ) :
								echo '<th style="padding:.75rem 1rem;text-align:left;font-size:.75rem;color:#888;text-transform:uppercase;letter-spacing:.05em;white-space:nowrap;">' . esc_html( $h ) . '</th>';
							endforeach;
							?>
						</tr>
					</thead>
					<tbody>
						<?php
						while ( $coins->have_posts() ) :
							$coins->the_post();
							$rank   = get_post_meta( get_the_ID(), 'pds_rank', true );
							$sym    = get_post_meta( get_the_ID(), 'pds_symbol', true );
							$price  = get_post_meta( get_the_ID(), 'pds_price_usd', true );
							$chg    = get_post_meta( get_the_ID(), 'pds_change_24h', true );
							$mcap   = get_post_meta( get_the_ID(), 'pds_market_cap', true );
							$vol    = get_post_meta( get_the_ID(), 'pds_volume', true );
							$chg_f  = (float) str_replace( '%', '', $chg );
							$color  = $chg_f >= 0 ? '#22c55e' : '#ef4444';
							?>
							<tr style="border-bottom:1px solid rgba(255,255,255,.05);transition:background .2s;" onmouseover="this.style.background='rgba(255,255,255,.03)'" onmouseout="this.style.background=''">
								<td style="padding:.75rem 1rem;color:#888;font-size:.85rem;"><?php echo absint( $rank ); ?></td>
								<td style="padding:.75rem 1rem;">
									<a href="<?php the_permalink(); ?>" style="color:#fff;display:flex;align-items:center;gap:.6rem;">
										<?php if ( has_post_thumbnail() ) : ?>
										<div style="width:28px;height:28px;border-radius:50%;overflow:hidden;flex-shrink:0;">
											<?php echo promovads_thumbnail( 0, 'promovads-square' ); ?>
										</div>
										<?php endif; ?>
										<div>
											<div style="font-weight:600;font-size:.9rem;"><?php the_title(); ?></div>
											<div style="color:#666;font-size:.75rem;"><?php echo esc_html( strtoupper( $sym ) ); ?></div>
										</div>
									</a>
								</td>
								<td style="padding:.75rem 1rem;color:#fff;font-weight:600;">
									<?php echo esc_html( $price ? '$' . number_format( (float) $price, 2 ) : '—' ); ?>
								</td>
								<td style="padding:.75rem 1rem;color:<?php echo esc_attr( $color ); ?>;font-weight:600;">
									<?php echo esc_html( $chg ? ( $chg_f >= 0 ? '+' : '' ) . $chg_f . '%' : '—' ); ?>
								</td>
								<td style="padding:.75rem 1rem;color:#aaa;font-size:.85rem;"><?php echo esc_html( $mcap ?: '—' ); ?></td>
								<td style="padding:.75rem 1rem;color:#aaa;font-size:.85rem;"><?php echo esc_html( $vol ?: '—' ); ?></td>
							</tr>
						<?php
						endwhile;
						wp_reset_postdata();
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- Hero Crypto News -->
	<div class="pds-container">
		<?php
		get_template_part( 'template-parts/blocks/hero-grid', null, array( 'count' => 3 ) );
		?>
	</div>

	<!-- News + Analysis Split -->
	<div style="background:var(--color-bg-alt);padding:2.5rem 0;">
		<div class="pds-container">
			<div class="pds-grid pds-grid--2">
				<div>
					<?php
					get_template_part( 'template-parts/blocks/post-grid', null, array(
						'title'   => 'Breaking News',
						'columns' => 1,
						'count'   => 5,
						'layout'  => 'list',
					) );
					?>
				</div>
				<div>
					<?php
					get_template_part( 'template-parts/blocks/post-grid', null, array(
						'title'   => 'Market Analysis',
						'tag'     => 'analysis',
						'columns' => 1,
						'count'   => 5,
						'layout'  => 'list',
					) );
					?>
				</div>
			</div>
		</div>
	</div>

	<!-- Full Grid + Sidebar -->
	<div class="pds-container pds-site-content">
		<div class="pds-grid pds-grid--main-sidebar">
			<div>
				<?php
				get_template_part( 'template-parts/blocks/post-grid', null, array(
					'title'   => 'All Crypto News',
					'columns' => 3,
					'count'   => 6,
				) );
				?>
			</div>
			<aside class="pds-sidebar" role="complementary">
				<?php get_sidebar(); ?>
			</aside>
		</div>
	</div>

</main>
