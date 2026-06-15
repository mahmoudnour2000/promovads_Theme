<?php
/**
 * Page Template
 *
 * @package PromovaDS_News
 */

get_header();
?>

<main id="primary" class="site-main" role="main">
<div class="pds-container pds-site-content">
	<?php promovads_breadcrumb(); ?>

	<div class="pds-grid pds-grid--main-sidebar">

		<div class="pds-main-content">
			<?php
			while ( have_posts() ) :
				the_post();
				?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'pds-page' ); ?>>
					<header>
						<h1 class="pds-article-title"><?php the_title(); ?></h1>
					</header>

					<?php if ( has_post_thumbnail() ) : ?>
					<figure class="pds-article-featured">
						<?php the_post_thumbnail( 'promovads-hero', array( 'loading' => 'lazy' ) ); ?>
					</figure>
					<?php endif; ?>

					<div class="entry-content">
						<?php the_content(); ?>
						<?php
						wp_link_pages(
							array(
								'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'promovads' ),
								'after'  => '</div>',
							)
						);
						?>
					</div>
				</article>

				<?php if ( comments_open() || get_comments_number() ) : ?>
					<section class="pds-comments">
						<?php comments_template(); ?>
					</section>
				<?php endif; ?>

			<?php endwhile; ?>
		</div>

		<aside class="pds-sidebar" role="complementary">
			<?php get_sidebar(); ?>
		</aside>

	</div>
</div>
</main>

<?php get_footer(); ?>
