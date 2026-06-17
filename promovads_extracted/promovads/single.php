<?php
/**
 * Single Post Template
 *
 * @package PromovaDS_News
 */

get_header();

if ( is_singular() ) {
	promovads_increment_views( get_the_ID() );
}

$config  = promovads_get_demo_config();
$is_demo = (bool) $config;
?>


<main id="primary" class="site-main<?php echo $is_demo ? ' pds-demo-single' : ''; ?>" role="main">
<div class="<?php echo $is_demo ? 'wrap' : 'pds-container'; ?>" style="<?php echo $is_demo ? 'padding:24px 0 60px' : ''; ?>">

	<?php promovads_breadcrumb(); ?>

	<div class="<?php echo $is_demo ? 'grid g-main' : 'pds-grid pds-grid--main-sidebar pds-site-content'; ?>" style="<?php echo $is_demo ? 'gap:32px' : ''; ?>">
		<div class="<?php echo $is_demo ? '' : 'pds-main-content'; ?>">
		<?php
		while ( have_posts() ) :
			the_post();
			?>

			<article id="post-<?php the_ID(); ?>" <?php post_class( $is_demo ? 'entry-content-wrap' : 'pds-single' ); ?> itemscope itemtype="https://schema.org/NewsArticle">

				<header class="<?php echo $is_demo ? 'article-header' : 'pds-article-header'; ?>">

					<!-- Categories -->
					<div class="<?php echo $is_demo ? 'article-cats' : 'pds-article-cats'; ?>">
						<?php
						$cats = get_the_category();
						foreach ( $cats as $cat ) :
							$color = promovads_get_category_color( $cat->term_id, $config['primary'] ?? '#6366f1' );
							printf(
								'<a href="%s" style="background-color:%s">%s</a>',
								esc_url( get_category_link( $cat->term_id ) ),
								esc_attr( $color ),
								esc_html( $cat->name )
							);
						endforeach;
						?>
					</div>

					<!-- Title -->
					<h1 class="<?php echo $is_demo ? 'article-title' : 'pds-article-title'; ?>" itemprop="headline"><?php the_title(); ?></h1>

					<?php if ( has_excerpt() ) : ?>
					<p class="<?php echo $is_demo ? 'article-subtitle' : 'pds-article-subtitle'; ?>" itemprop="description"><?php the_excerpt(); ?></p>
					<?php endif; ?>

					<div class="<?php echo $is_demo ? 'article-meta' : 'pds-article-meta'; ?>">

						<!-- Author -->
						<div class="<?php echo $is_demo ? 'article-meta__author' : 'pds-article-meta__author'; ?>" itemprop="author" itemscope itemtype="https://schema.org/Person">
							<?php echo get_avatar( get_the_author_meta( 'ID' ), 36, '', '', array( 'itemprop' => 'image' ) ); ?>
							<div>
								<a class="name" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" itemprop="url">
									<span itemprop="name"><?php echo esc_html( promovads_author_display_name() ); ?></span>
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
									esc_html__( 'تحديث %s', 'promovads' ),
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
				<figure class="<?php echo $is_demo ? 'article-featured' : 'pds-article-featured'; ?>" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
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
					<div class="<?php echo $is_demo ? 'article-tags' : 'pds-article-tags'; ?>">
						<h4><?php esc_html_e( 'الوسوم:', 'promovads' ); ?></h4>
						<div class="<?php echo $is_demo ? 'tags' : 'pds-tags'; ?>">
							<?php foreach ( $tags as $tag ) : ?>
								<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="<?php echo $is_demo ? 'tag' : 'pds-tag'; ?>">
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
				<nav class="<?php echo $is_demo ? 'post-nav' : 'pds-post-nav'; ?>" aria-label="<?php esc_attr_e( 'Post navigation', 'promovads' ); ?>">
					<?php
					the_post_navigation(
						array(
							'prev_text' => '<span class="' . ( $is_demo ? 'post-nav__label' : 'pds-post-nav__label' ) . '"><i class="fas fa-arrow-right" aria-hidden="true"></i> ' . esc_html__( 'السابق', 'promovads' ) . '</span><span class="' . ( $is_demo ? 'post-nav__title' : 'pds-post-nav__title' ) . '">%title</span>',
							'next_text' => '<span class="' . ( $is_demo ? 'post-nav__label' : 'pds-post-nav__label' ) . '">' . esc_html__( 'التالي', 'promovads' ) . ' <i class="fas fa-arrow-left" aria-hidden="true"></i></span><span class="' . ( $is_demo ? 'post-nav__title' : 'pds-post-nav__title' ) . '">%title</span>',
						)
					);
					?>
				</nav>

				<!-- Related Posts -->
				<?php get_template_part( 'template-parts/single/related-posts' ); ?>



			</article>

		<?php endwhile; ?>
		</div><!-- .pds-main-content -->

		<!-- Sidebar -->
			<aside class="<?php echo $is_demo ? 'sidebar' : 'pds-sidebar'; ?>" role="complementary" aria-label="<?php esc_attr_e( 'Sidebar', 'promovads' ); ?>">
			<?php
			if ( $is_demo ) {
				get_template_part( 'template-parts/demos/_shared/sidebar' );
			} else {
				get_sidebar();
			}
			?>
		</aside>

	</div>
</div>
</main>

<?php get_footer(); ?>
