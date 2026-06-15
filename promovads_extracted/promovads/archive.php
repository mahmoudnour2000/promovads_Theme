<?php
/**
 * Archive / Category / Tag Template
 *
 * @package PromovaDS_News
 */

get_header();
?>

<main id="primary" class="site-main" role="main">

	<!-- Archive Header -->
	<div class="pds-archive-header">
		<div class="pds-container">
			<?php if ( is_category() ) : ?>
				<span class="pds-archive-header__cat"><?php esc_html_e( 'Category', 'promovads' ); ?></span>
				<h1><?php single_cat_title(); ?></h1>
				<?php if ( category_description() ) : ?>
					<p><?php echo wp_kses_post( category_description() ); ?></p>
				<?php endif; ?>

			<?php elseif ( is_tag() ) : ?>
				<span class="pds-archive-header__cat"><?php esc_html_e( 'Tag', 'promovads' ); ?></span>
				<h1>#<?php single_tag_title(); ?></h1>

			<?php elseif ( is_author() ) : ?>
				<span class="pds-archive-header__cat"><?php esc_html_e( 'Author', 'promovads' ); ?></span>
				<h1><?php echo esc_html( get_the_author() ); ?></h1>
				<?php
				$author_id  = get_queried_object_id();
				$author_bio = get_the_author_meta( 'description', $author_id );
				if ( $author_bio ) :
					?>
					<p><?php echo esc_html( $author_bio ); ?></p>
				<?php endif; ?>

			<?php elseif ( is_date() ) : ?>
				<span class="pds-archive-header__cat"><?php esc_html_e( 'Archive', 'promovads' ); ?></span>
				<h1>
					<?php
					if ( is_year() ) {
						echo esc_html( get_the_date( 'Y' ) );
					} elseif ( is_month() ) {
						echo esc_html( get_the_date( 'F Y' ) );
					} else {
						echo esc_html( get_the_date() );
					}
					?>
				</h1>

			<?php else : ?>
				<h1><?php the_archive_title(); ?></h1>
				<?php the_archive_description( '<p>', '</p>' ); ?>
			<?php endif; ?>

			<span class="pds-archive-header__count">
				<?php
				global $wp_query;
				printf(
					/* translators: %d: post count */
					esc_html( _n( '%d Article', '%d Articles', $wp_query->found_posts, 'promovads' ) ),
					absint( $wp_query->found_posts )
				);
				?>
			</span>
		</div>
	</div>

	<div class="pds-container pds-site-content">
		<div class="pds-grid pds-grid--main-sidebar">

			<div class="pds-main-content">
				<?php if ( have_posts() ) : ?>

					<div class="pds-grid pds-grid--3">
						<?php
						while ( have_posts() ) :
							the_post();
							get_template_part( 'template-parts/blocks/card', 'standard' );
						endwhile;
						?>
					</div>

					<nav class="pds-pagination" aria-label="<?php esc_attr_e( 'Pagination', 'promovads' ); ?>">
						<?php
						the_posts_pagination(
							array(
								'mid_size'  => 2,
								'prev_text' => '<i class="fas fa-chevron-left" aria-hidden="true"></i>',
								'next_text' => '<i class="fas fa-chevron-right" aria-hidden="true"></i>',
							)
						);
						?>
					</nav>

				<?php else : ?>
					<?php get_template_part( 'template-parts/content', 'none' ); ?>
				<?php endif; ?>
			</div>

			<aside class="pds-sidebar" role="complementary">
				<?php get_sidebar( 'archive' ); ?>
			</aside>

		</div>
	</div>

</main>

<?php get_footer(); ?>
