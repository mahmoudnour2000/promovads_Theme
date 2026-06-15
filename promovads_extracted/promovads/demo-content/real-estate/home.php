<?php
/**
 * Real Estate Demo Homepage
 *
 * @package PromovaDS_News
 */
?>
<main id="primary" class="site-main pds-demo-realestate" role="main">

	<!-- Search Hero -->
	<section style="background:linear-gradient(135deg,#8b5cf6 0%,#6d28d9 100%);padding:4rem 0;text-align:center;color:#fff;">
		<div class="pds-container">
			<h1 style="color:#fff;font-size:2.5rem;margin-bottom:.5rem;"><?php esc_html_e( 'Find Your Perfect Property', 'promovads' ); ?></h1>
			<p style="opacity:.85;margin-bottom:2rem;"><?php esc_html_e( 'Browse thousands of listings updated daily', 'promovads' ); ?></p>

			<div style="background:#fff;border-radius:12px;padding:1.5rem;max-width:800px;margin:0 auto;display:flex;gap:1rem;flex-wrap:wrap;">
				<select style="flex:1;min-width:140px;padding:.7rem 1rem;border:1px solid #e5e5e5;border-radius:8px;">
					<option><?php esc_html_e( 'Buy', 'promovads' ); ?></option>
					<option><?php esc_html_e( 'Rent', 'promovads' ); ?></option>
				</select>
				<input type="text" placeholder="<?php esc_attr_e( 'City, area or address...', 'promovads' ); ?>" style="flex:2;min-width:200px;padding:.7rem 1rem;border:1px solid #e5e5e5;border-radius:8px;">
				<select style="flex:1;min-width:120px;padding:.7rem 1rem;border:1px solid #e5e5e5;border-radius:8px;">
					<option><?php esc_html_e( 'All Types', 'promovads' ); ?></option>
					<option><?php esc_html_e( 'Apartment', 'promovads' ); ?></option>
					<option><?php esc_html_e( 'Villa', 'promovads' ); ?></option>
					<option><?php esc_html_e( 'Office', 'promovads' ); ?></option>
				</select>
				<button class="pds-btn pds-btn--primary" style="padding:.7rem 1.5rem;">
					<i class="fas fa-search"></i> <?php esc_html_e( 'Search', 'promovads' ); ?>
				</button>
			</div>
		</div>
	</section>

	<!-- Featured Properties -->
	<div class="pds-container pds-site-content">
		<div class="pds-section-header">
			<h2 class="pds-section-title">Featured <span>Properties</span></h2>
		</div>
		<div class="pds-grid pds-grid--3" style="margin-bottom:3rem;">
			<?php
			$props = new WP_Query( array( 'post_type' => 'pds_property', 'posts_per_page' => 6, 'post_status' => 'publish' ) );
			while ( $props->have_posts() ) :
				$props->the_post();
				$price   = get_post_meta( get_the_ID(), 'pds_price', true );
				$beds    = get_post_meta( get_the_ID(), 'pds_bedrooms', true );
				$baths   = get_post_meta( get_the_ID(), 'pds_bathrooms', true );
				$area    = get_post_meta( get_the_ID(), 'pds_area', true );
				$address = get_post_meta( get_the_ID(), 'pds_address', true );
				$type    = get_post_meta( get_the_ID(), 'pds_listing_type', true );
				?>
				<article class="pds-card">
					<a href="<?php the_permalink(); ?>" class="pds-card__thumb">
						<?php echo promovads_thumbnail( 0, 'promovads-card' ); ?>
						<?php if ( $type ) : ?>
						<span class="pds-card__cat" style="<?php echo strtolower( $type ) === 'rent' ? 'background:#0ea5e9' : ''; ?>">
							<?php echo esc_html( ucfirst( $type ) ); ?>
						</span>
						<?php endif; ?>
					</a>
					<div class="pds-card__body">
						<?php if ( $price ) : ?>
						<div style="font-size:1.25rem;font-weight:700;color:var(--color-primary);margin-bottom:.5rem;">
							<?php echo esc_html( $price ); ?>
						</div>
						<?php endif; ?>
						<h3 class="pds-card__title" style="-webkit-line-clamp:2;">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h3>
						<?php if ( $address ) : ?>
						<p style="font-size:.8rem;color:var(--color-text-muted);margin-bottom:.75rem;">
							<i class="fas fa-map-marker-alt" style="color:var(--color-primary);"></i> <?php echo esc_html( $address ); ?>
						</p>
						<?php endif; ?>
						<div style="display:flex;gap:1rem;font-size:.8rem;color:var(--color-text-muted);padding-top:.75rem;border-top:1px solid var(--color-border);">
							<?php if ( $beds ) : ?><span><i class="fas fa-bed"></i> <?php echo esc_html( $beds ); ?></span><?php endif; ?>
							<?php if ( $baths ) : ?><span><i class="fas fa-bath"></i> <?php echo esc_html( $baths ); ?></span><?php endif; ?>
							<?php if ( $area ) : ?><span><i class="fas fa-ruler-combined"></i> <?php echo esc_html( $area ); ?> m²</span><?php endif; ?>
						</div>
					</div>
				</article>
			<?php endwhile; wp_reset_postdata(); ?>
		</div>

		<!-- Real Estate News + Sidebar -->
		<div class="pds-grid pds-grid--main-sidebar">
			<div>
				<?php get_template_part( 'template-parts/blocks/post-grid', null, array( 'title' => 'Real Estate News', 'columns' => 3, 'count' => 6 ) ); ?>
			</div>
			<aside class="pds-sidebar" role="complementary"><?php get_sidebar(); ?></aside>
		</div>
	</div>
</main>
