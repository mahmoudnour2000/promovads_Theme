<?php
/**
 * Single Post Template
 *
 * @package PromovaDS_News
 */

get_header();

// Track views
if ( is_singular() ) {
	promovads_increment_views( get_the_ID() );
}
?>

<main id="primary" class="site-main" role="main">
<div class="pds-container">

	<?php promovads_breadcrumb(); ?>

	<div class="pds-grid pds-grid--main-sidebar pds-site-content">

		<!-- Article -->
		<div class="pds-main-content">
		<?php
		while ( have_posts() ) :
			the_post();
			?>

			<article id="post-<?php the_ID(); ?>" <?php post_class( 'pds-single' ); ?> itemscope itemtype="https://schema.org/NewsArticle">

				<!-- Article Header -->
				<header class="pds-article-header">

					<!-- Categories -->
					<div class="pds-article-cats">
						<?php
						$cats = get_the_category();
						foreach ( $cats as $cat ) :
							$color = get_term_meta( $cat->term_id, 'pds_color', true );
							$style = $color ? ' style="background-color:' . esc_attr( $color ) . '"' : '';
							printf(
								'<a href="%s"%s>%s</a>',
								esc_url( get_category_link( $cat->term_id ) ),
								$style,
								esc_html( $cat->name )
							);
						endforeach;
						?>
					</div>

					<!-- Title -->
					<h1 class="pds-article-title" itemprop="headline"><?php the_title(); ?></h1>

					<!-- Subtitle / Excerpt -->
					<?php if ( has_excerpt() ) : ?>
					<p class="pds-article-subtitle" itemprop="description"><?php the_excerpt(); ?></p>
					<?php endif; ?>

					<!-- Meta -->
					<div class="pds-article-meta">

						<!-- Author -->
						<div class="pds-article-meta__author" itemprop="author" itemscope itemtype="https://schema.org/Person">
							<?php echo get_avatar( get_the_author_meta( 'ID' ), 36, '', '', array( 'itemprop' => 'image' ) ); ?>
							<div>
								<a class="name" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" itemprop="url">
									<span itemprop="name"><?php the_author(); ?></span>
								</a>
							</div>
						</div>

						<!-- Date -->
						<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" itemprop="datePublished">
							<?php echo esc_html( get_the_date() ); ?>
						</time>

						<?php
						$modified = get_the_modified_date( 'c' );
						if ( $modified !== get_the_date( 'c' ) ) :
							?>
							<time datetime="<?php echo esc_attr( $modified ); ?>" itemprop="dateModified">
								<?php
								printf(
									/* translators: %s: modified date */
									esc_html__( 'Updated %s', 'promovads' ),
									esc_html( get_the_modified_date() )
								);
								?>
							</time>
						<?php endif; ?>

						<!-- Reading Time -->
						<span>
							<i class="far fa-clock" aria-hidden="true"></i>
							<?php echo esc_html( promovads_reading_time() ); ?>
						</span>

						<!-- Views -->
						<span>
							<i class="far fa-eye" aria-hidden="true"></i>
							<?php echo esc_html( promovads_format_number( promovads_get_views() ) ); ?>
						</span>

						<!-- Share Buttons -->
						<?php get_template_part( 'template-parts/single/share-buttons' ); ?>

					</div>
				</header>

				<!-- Featured Image -->
				<?php if ( has_post_thumbnail() ) : ?>
				<figure class="pds-article-featured" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
					<?php the_post_thumbnail( 'promovads-hero', array( 'itemprop' => 'url', 'loading' => 'eager', 'decoding' => 'async' ) ); ?>
					<?php
					$caption = get_the_post_thumbnail_caption();
					if ( $caption ) :
						?>
						<figcaption><?php echo esc_html( $caption ); ?></figcaption>
					<?php endif; ?>
				</figure>
				<?php endif; ?>

				<!-- Content -->
				<div class="entry-content" itemprop="articleBody">
					<?php
					the_content(
						sprintf(
							wp_kses(
								/* translators: %s: Post title. */
								__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'promovads' ),
								array( 'span' => array( 'class' => array() ) )
							),
							wp_kses_post( get_the_title() )
						)
					);

					wp_link_pages(
						array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'promovads' ),
							'after'  => '</div>',
						)
					);
					?>
				</div>

				<!-- Tags -->
				<?php
				$tags = get_the_tags();
				if ( $tags ) :
					?>
					<div class="pds-article-tags">
						<h4><?php esc_html_e( 'Tags:', 'promovads' ); ?></h4>
						<div class="pds-tags">
							<?php foreach ( $tags as $tag ) : ?>
								<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="pds-tag">
									<?php echo esc_html( $tag->name ); ?>
								</a>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>

				<!-- Share (bottom) -->
				<div class="pds-article-share-bottom">
					<?php get_template_part( 'template-parts/single/share-buttons' ); ?>
				</div>

				<!-- Author Box -->
				<?php get_template_part( 'template-parts/single/author-box' ); ?>

				<!-- Post Navigation -->
				<nav class="pds-post-nav" aria-label="<?php esc_attr_e( 'Post navigation', 'promovads' ); ?>">
					<?php
					the_post_navigation(
						array(
							'prev_text' => '<span class="pds-post-nav__label">' . esc_html__( '← Previous', 'promovads' ) . '</span><span class="pds-post-nav__title">%title</span>',
							'next_text' => '<span class="pds-post-nav__label">' . esc_html__( 'Next →', 'promovads' ) . '</span><span class="pds-post-nav__title">%title</span>',
						)
					);
					?>
				</nav>

				<!-- Related Posts -->
				<?php get_template_part( 'template-parts/single/related-posts' ); ?>

				<!-- Comments -->
				<?php if ( comments_open() || get_comments_number() ) : ?>
					<section class="pds-comments">
						<?php comments_template(); ?>
					</section>
				<?php endif; ?>

			</article>

		<?php endwhile; ?>
		</div><!-- .pds-main-content -->

		<!-- Sidebar -->
		<aside class="pds-sidebar" role="complementary" aria-label="<?php esc_attr_e( 'Sidebar', 'promovads' ); ?>">
			<?php get_sidebar(); ?>
		</aside>

	</div><!-- .pds-grid -->
</div><!-- .pds-container -->
</main>

<?php get_footer(); ?>
