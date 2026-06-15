<?php
/**
 * Jobs Portal Demo Homepage
 * Search-first, job cards layout, filters
 *
 * @package PromovaDS_News
 */
?>

<main id="primary" class="site-main pds-demo-jobs" role="main">

	<!-- Hero Search Banner -->
	<section style="background:linear-gradient(135deg,#0ea5e9 0%,#0284c7 100%);padding:4rem 0;text-align:center;color:#fff;">
		<div class="pds-container">
			<h1 style="font-size:2.5rem;color:#fff;margin-bottom:.5rem;"><?php esc_html_e( 'Find Your Dream Job', 'promovads' ); ?></h1>
			<p style="font-size:1.125rem;opacity:.85;margin-bottom:2rem;"><?php esc_html_e( 'Thousands of opportunities updated daily', 'promovads' ); ?></p>

			<form class="pds-jobs-search" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" style="display:flex;gap:.75rem;max-width:700px;margin:0 auto;flex-wrap:wrap;">
				<input type="hidden" name="post_type" value="pds_job">
				<input type="search" name="s" placeholder="<?php esc_attr_e( 'Job title, keyword...', 'promovads' ); ?>"
					   style="flex:1;min-width:200px;padding:.85rem 1.25rem;border:none;border-radius:8px;font-size:1rem;">
				<input type="text" name="location" placeholder="<?php esc_attr_e( 'Location...', 'promovads' ); ?>"
					   style="flex:1;min-width:150px;padding:.85rem 1.25rem;border:none;border-radius:8px;font-size:1rem;">
				<button type="submit" class="pds-btn pds-btn--primary" style="background:#1a1a2e;padding:.85rem 1.75rem;font-size:1rem;">
					<i class="fas fa-search"></i> <?php esc_html_e( 'Search', 'promovads' ); ?>
				</button>
			</form>

			<!-- Quick Filters -->
			<div style="margin-top:1.5rem;display:flex;gap:.5rem;justify-content:center;flex-wrap:wrap;">
				<?php
				$job_types = get_terms( array( 'taxonomy' => 'job_type', 'hide_empty' => true, 'number' => 6 ) );
				if ( ! is_wp_error( $job_types ) ) :
					foreach ( $job_types as $type ) :
						?>
						<a href="<?php echo esc_url( get_term_link( $type ) ); ?>"
						   style="background:rgba(255,255,255,.15);color:#fff;padding:.4rem .9rem;border-radius:20px;font-size:.85rem;border:1px solid rgba(255,255,255,.3);transition:background .2s;">
							<?php echo esc_html( $type->name ); ?>
						</a>
					<?php
					endforeach;
				endif;
				?>
			</div>
		</div>
	</section>

	<!-- Job Stats Bar -->
	<div style="background:var(--color-secondary);padding:1.25rem 0;color:#fff;">
		<div class="pds-container">
			<div style="display:flex;gap:3rem;justify-content:center;flex-wrap:wrap;text-align:center;">
				<?php
				$total_jobs = wp_count_posts( 'pds_job' )->publish ?? 0;
				$stats      = array(
					esc_html__( 'Open Positions', 'promovads' ) => promovads_format_number( (int) $total_jobs ),
					esc_html__( 'Companies', 'promovads' )      => '500+',
					esc_html__( 'New Today', 'promovads' )      => '24+',
					esc_html__( 'Remote Jobs', 'promovads' )    => '180+',
				);
				foreach ( $stats as $label => $value ) :
					?>
					<div>
						<div style="font-size:1.5rem;font-weight:700;color:var(--color-accent);"><?php echo esc_html( $value ); ?></div>
						<div style="font-size:.8rem;opacity:.6;text-transform:uppercase;letter-spacing:.05em;"><?php echo esc_html( $label ); ?></div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

	<!-- Latest Jobs Grid -->
	<div class="pds-container pds-site-content">
		<div class="pds-section-header">
			<h2 class="pds-section-title"><?php esc_html_e( 'Latest', 'promovads' ); ?> <span><?php esc_html_e( 'Job Openings', 'promovads' ); ?></span></h2>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'pds_job' ) ); ?>" class="pds-see-all">
				<?php esc_html_e( 'View All Jobs', 'promovads' ); ?> <i class="fas fa-arrow-right"></i>
			</a>
		</div>

		<div class="pds-grid pds-grid--2" style="margin-bottom:3rem;">
			<?php
			$jobs = new WP_Query( array( 'post_type' => 'pds_job', 'posts_per_page' => 6, 'post_status' => 'publish' ) );
			while ( $jobs->have_posts() ) :
				$jobs->the_post();
				$company   = get_post_meta( get_the_ID(), 'pds_company', true );
				$location  = get_post_meta( get_the_ID(), 'pds_location', true );
				$salary    = get_post_meta( get_the_ID(), 'pds_salary', true );
				$job_type  = get_post_meta( get_the_ID(), 'pds_job_type', true );
				$deadline  = get_post_meta( get_the_ID(), 'pds_deadline', true );
				?>
				<article class="pds-card" style="display:flex;gap:1rem;align-items:flex-start;padding:1.25rem;">
					<?php if ( has_post_thumbnail() ) : ?>
					<div style="width:56px;height:56px;flex-shrink:0;border-radius:8px;overflow:hidden;">
						<?php echo promovads_thumbnail( 0, 'promovads-square' ); ?>
					</div>
					<?php else : ?>
					<div style="width:56px;height:56px;flex-shrink:0;border-radius:8px;background:var(--color-bg-alt);display:flex;align-items:center;justify-content:center;">
						<i class="fas fa-building" style="font-size:1.5rem;color:var(--color-text-muted);"></i>
					</div>
					<?php endif; ?>

					<div style="flex:1;">
						<div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;">
							<div>
								<h3 style="font-size:1rem;margin-bottom:.25rem;"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<?php if ( $company ) : ?>
								<span style="font-size:.875rem;color:var(--color-text-muted);"><?php echo esc_html( $company ); ?></span>
								<?php endif; ?>
							</div>
							<?php if ( $job_type ) : ?>
							<span style="background:rgba(14,165,233,.1);color:#0ea5e9;font-size:.75rem;font-weight:600;padding:.25rem .6rem;border-radius:20px;white-space:nowrap;">
								<?php echo esc_html( $job_type ); ?>
							</span>
							<?php endif; ?>
						</div>

						<div style="display:flex;gap:1rem;margin-top:.75rem;font-size:.8rem;color:var(--color-text-muted);flex-wrap:wrap;">
							<?php if ( $location ) : ?>
							<span><i class="fas fa-map-marker-alt" style="color:var(--color-primary);margin-right:.3rem;"></i><?php echo esc_html( $location ); ?></span>
							<?php endif; ?>
							<?php if ( $salary ) : ?>
							<span><i class="fas fa-money-bill-wave" style="color:#22c55e;margin-right:.3rem;"></i><?php echo esc_html( $salary ); ?></span>
							<?php endif; ?>
							<?php if ( $deadline ) : ?>
							<span><i class="fas fa-calendar" style="color:var(--color-accent);margin-right:.3rem;"></i><?php echo esc_html( $deadline ); ?></span>
							<?php endif; ?>
						</div>
					</div>
				</article>
			<?php
			endwhile;
			wp_reset_postdata();
			?>
		</div>

		<!-- Job News Section -->
		<?php
		get_template_part( 'template-parts/blocks/post-grid', null, array(
			'title'   => 'Career News & Tips',
			'columns' => 3,
			'count'   => 3,
		) );
		?>
	</div>

</main>
