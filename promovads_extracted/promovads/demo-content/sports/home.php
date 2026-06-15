<?php
/**
 * Sports Demo Homepage
 * Live scores, match schedule, league tables
 *
 * @package PromovaDS_News
 */

$matches = new WP_Query( array( 'post_type' => 'pds_match', 'posts_per_page' => 4, 'post_status' => 'publish', 'meta_key' => 'pds_status', 'meta_value' => 'live', 'orderby' => 'date', 'order' => 'DESC' ) );
$scheduled = new WP_Query( array( 'post_type' => 'pds_match', 'posts_per_page' => 6, 'post_status' => 'publish', 'meta_key' => 'pds_status', 'meta_value' => 'scheduled', 'orderby' => 'meta_value', 'meta_key' => 'pds_match_date', 'order' => 'ASC' ) );
?>

<main id="primary" class="site-main pds-demo-sports" role="main">

	<!-- Live Scores Banner -->
	<?php if ( $matches->have_posts() ) : ?>
	<div style="background:var(--color-primary);padding:1rem 0;">
		<div class="pds-container">
			<div style="display:flex;align-items:center;gap:1rem;overflow-x:auto;scrollbar-width:none;">
				<span style="color:#fff;font-weight:700;font-size:.75rem;text-transform:uppercase;letter-spacing:.1em;white-space:nowrap;flex-shrink:0;">
					🔴 LIVE
				</span>
				<?php
				while ( $matches->have_posts() ) :
					$matches->the_post();
					$home  = get_post_meta( get_the_ID(), 'pds_home_team', true );
					$away  = get_post_meta( get_the_ID(), 'pds_away_team', true );
					$hs    = get_post_meta( get_the_ID(), 'pds_home_score', true );
					$as    = get_post_meta( get_the_ID(), 'pds_away_score', true );
					?>
					<a href="<?php the_permalink(); ?>" style="background:rgba(0,0,0,.2);color:#fff;padding:.4rem 1rem;border-radius:6px;white-space:nowrap;font-size:.85rem;flex-shrink:0;">
						<strong><?php echo esc_html( $home ); ?></strong>
						<span style="background:rgba(255,255,255,.2);padding:.1rem .5rem;border-radius:3px;margin:0 .4rem;">
							<?php echo esc_html( $hs ); ?> - <?php echo esc_html( $as ); ?>
						</span>
						<strong><?php echo esc_html( $away ); ?></strong>
					</a>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
		</div>
	</div>
	<?php endif; ?>

	<!-- Hero + Top Sport Stories -->
	<div class="pds-container">
		<?php
		get_template_part( 'template-parts/blocks/hero-grid', null, array(
			'category' => get_cat_ID( 'Sports' ) ?: 0,
			'count'    => 3,
		) );
		?>
	</div>

	<!-- Match Schedule -->
	<?php if ( $scheduled->have_posts() ) : ?>
	<div style="background:var(--color-bg-alt);padding:2rem 0;">
		<div class="pds-container">
			<div class="pds-section-header">
				<h2 class="pds-section-title">Upcoming <span>Matches</span></h2>
			</div>
			<div style="display:flex;flex-direction:column;gap:.75rem;">
				<?php
				while ( $scheduled->have_posts() ) :
					$scheduled->the_post();
					$home   = get_post_meta( get_the_ID(), 'pds_home_team', true );
					$away   = get_post_meta( get_the_ID(), 'pds_away_team', true );
					$date   = get_post_meta( get_the_ID(), 'pds_match_date', true );
					$league = get_post_meta( get_the_ID(), 'pds_league', true );
					$venue  = get_post_meta( get_the_ID(), 'pds_venue', true );
					?>
					<div style="background:var(--color-bg);border:1px solid var(--color-border);border-radius:8px;padding:1rem 1.25rem;display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;">
						<div style="flex:1;text-align:right;">
							<strong style="font-size:1rem;"><?php echo esc_html( $home ); ?></strong>
						</div>
						<div style="text-align:center;flex-shrink:0;">
							<div style="font-size:.75rem;color:var(--color-text-muted);"><?php echo esc_html( $league ); ?></div>
							<div style="font-weight:700;font-size:.9rem;color:var(--color-primary);"><?php echo esc_html( $date ); ?></div>
							<div style="font-size:.75rem;color:var(--color-text-muted);"><?php echo esc_html( $venue ); ?></div>
						</div>
						<div style="flex:1;">
							<strong style="font-size:1rem;"><?php echo esc_html( $away ); ?></strong>
						</div>
					</div>
				<?php
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</div>
	</div>
	<?php endif; ?>

	<!-- Sports News + Sidebar -->
	<div class="pds-container pds-site-content">
		<div class="pds-grid pds-grid--main-sidebar">
			<div>
				<?php
				get_template_part( 'template-parts/blocks/post-grid', null, array(
					'title'   => 'Latest Sports News',
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
