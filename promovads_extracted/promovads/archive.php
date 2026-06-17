<?php
/**
 * Archive — demo-aware layout.
 *
 * @package PromovaDS_News
 */

get_header();

$config = promovads_get_demo_config();
$is_demo = (bool) $config;
?>

<main id="primary" class="site-main<?php echo $is_demo ? ' pds-demo-archive' : ''; ?>" role="main">

	<?php if ( $is_demo ) : ?>
		<?php promovads_render_skin( 'archive_header' ); ?>
	<?php else : ?>
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
			<?php else : ?>
				<h1><?php the_archive_title(); ?></h1>
				<?php the_archive_description( '<p>', '</p>' ); ?>
			<?php endif; ?>

			<span class="pds-archive-header__count">
				<?php
				global $wp_query;
				printf(
					esc_html( _n( '%d post', '%d posts', $wp_query->found_posts, 'promovads' ) ),
					absint( $wp_query->found_posts )
				);
				?>
			</span>
		</div>
	</div>
	<?php endif; ?>

	<div class="<?php echo $is_demo ? 'wrap' : 'pds-container pds-site-content'; ?>" style="<?php echo $is_demo ? 'padding:36px 0 60px' : ''; ?>">
		<div class="<?php echo $is_demo ? 'grid g-main' : 'pds-grid pds-grid--main-sidebar'; ?>" style="<?php echo $is_demo ? 'gap:32px' : ''; ?>">
			<div class="<?php echo $is_demo ? '' : 'pds-main-content'; ?>">
				<?php if ( have_posts() ) : ?>
					<div class="<?php echo $is_demo ? 'grid g3' : 'pds-grid pds-grid--3'; ?>">
						<?php
						while ( have_posts() ) :
							the_post();
							if ( $is_demo ) {
								get_template_part( 'template-parts/demos/_shared/card' );
							} else {
								get_template_part( 'template-parts/blocks/card', 'standard' );
							}
						endwhile;
						?>
					</div>
					<nav class="<?php echo $is_demo ? 'pagination' : 'pds-pagination'; ?>" aria-label="<?php esc_attr_e( 'Pagination', 'promovads' ); ?>" style="margin-top:2rem">
						<?php
						the_posts_pagination(
							array(
								'mid_size'  => 2,
								'prev_text' => '<i class="fas fa-chevron-right" aria-hidden="true"></i>',
								'next_text' => '<i class="fas fa-chevron-left" aria-hidden="true"></i>',
							)
						);
						?>
					</nav>
				<?php else : ?>
					<?php get_template_part( 'template-parts/content', 'none' ); ?>
				<?php endif; ?>
			</div>

			<aside class="<?php echo $is_demo ? 'sidebar' : 'pds-sidebar'; ?>" role="complementary">
				<?php get_sidebar( $is_demo ? 'archive' : 'archive' ); ?>
			</aside>
		</div>
	</div>
</main>

<?php get_footer(); ?>
