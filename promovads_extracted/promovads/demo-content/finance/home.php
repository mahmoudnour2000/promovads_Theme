<?php
/**
 * Finance Demo Homepage
 * Stock ticker, market news, crypto + forex sections
 *
 * @package PromovaDS_News
 */
?>

<main id="primary" class="site-main pds-demo-finance" role="main">

	<!-- Market Ticker Bar -->
	<div style="background:#0d1117;color:#fff;padding:.6rem 0;overflow:hidden;border-bottom:2px solid #22c55e;">
		<div class="pds-container">
			<div style="display:flex;gap:2.5rem;overflow-x:auto;scrollbar-width:none;" id="pds-market-ticker">
				<?php
				$symbols = array(
					array( 'sym' => 'S&P 500',   'val' => '4,927.93',  'chg' => '+0.52%',  'up' => true  ),
					array( 'sym' => 'NASDAQ',    'val' => '15,628.04', 'chg' => '+0.74%',  'up' => true  ),
					array( 'sym' => 'DOW',       'val' => '38,654.42', 'chg' => '-0.11%',  'up' => false ),
					array( 'sym' => 'GOLD',      'val' => '$2,041.20', 'chg' => '+0.29%',  'up' => true  ),
					array( 'sym' => 'OIL',       'val' => '$82.45',    'chg' => '-0.87%',  'up' => false ),
					array( 'sym' => 'BTC/USD',   'val' => '$67,234',   'chg' => '+2.14%',  'up' => true  ),
					array( 'sym' => 'EUR/USD',   'val' => '1.0845',    'chg' => '+0.05%',  'up' => true  ),
					array( 'sym' => 'USD/JPY',   'val' => '149.82',    'chg' => '-0.22%',  'up' => false ),
				);
				foreach ( $symbols as $s ) :
					$color = $s['up'] ? '#22c55e' : '#ef4444';
					$icon  = $s['up'] ? '▲' : '▼';
					?>
					<div style="white-space:nowrap;flex-shrink:0;">
						<span style="font-size:.75rem;color:#888;"><?php echo esc_html( $s['sym'] ); ?></span>
						<span style="font-size:.9rem;font-weight:600;margin:0 .4rem;"><?php echo esc_html( $s['val'] ); ?></span>
						<span style="font-size:.75rem;color:<?php echo esc_attr( $color ); ?>;"><?php echo esc_html( $icon . ' ' . $s['chg'] ); ?></span>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

	<!-- Hero + Top Stories -->
	<div class="pds-container">
		<?php
		get_template_part( 'template-parts/blocks/hero-grid', null, array(
			'category' => get_cat_ID( 'Finance' ) ?: 0,
			'count'    => 3,
		) );
		?>
	</div>

	<!-- Market News Sections -->
	<div style="background:var(--color-bg-alt);padding:2.5rem 0;">
		<div class="pds-container">
			<div class="pds-grid pds-grid--3">

				<!-- Stocks -->
				<div>
					<?php
					get_template_part( 'template-parts/blocks/post-grid', null, array(
						'title'   => 'Stocks',
						'tag'     => 'stocks',
						'columns' => 1,
						'count'   => 4,
						'layout'  => 'list',
					) );
					?>
				</div>

				<!-- Crypto -->
				<div>
					<?php
					get_template_part( 'template-parts/blocks/post-grid', null, array(
						'title'   => 'Crypto',
						'tag'     => 'crypto',
						'columns' => 1,
						'count'   => 4,
						'layout'  => 'list',
					) );
					?>
				</div>

				<!-- Forex -->
				<div>
					<?php
					get_template_part( 'template-parts/blocks/post-grid', null, array(
						'title'   => 'Forex',
						'tag'     => 'forex',
						'columns' => 1,
						'count'   => 4,
						'layout'  => 'list',
					) );
					?>
				</div>

			</div>
		</div>
	</div>

	<!-- Latest Finance News + Sidebar -->
	<div class="pds-container pds-site-content">
		<div class="pds-grid pds-grid--main-sidebar">
			<div>
				<?php
				get_template_part( 'template-parts/blocks/post-grid', null, array(
					'title'   => 'Market Analysis',
					'columns' => 2,
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
