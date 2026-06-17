<?php
/**
 * Dynamic skin renderers — templates without dedicated PHP files.
 *
 * @package PromovaDS_News
 */

defined( 'ABSPATH' ) || exit;

/**
 * Nav: all variants share one markup file.
 */
function promovads_skin_render_nav( string $slug, array $args = array() ): void {
	get_template_part( 'template-parts/demos/skins/nav/pills', null, $args );
}

/**
 * Hero variants.
 */
function promovads_skin_render_hero( string $slug, array $args = array() ): void {
	$config = promovads_get_demo_config();
	$prefix = $config['prefix'] ?? 'pds';

	switch ( $slug ) {
		case 'full-bleed':
			$posts = promovads_get_featured_posts( 1 );
			if ( empty( $posts ) ) {
				return;
			}
			$post = $posts[0];
			$cat  = promovads_get_primary_category( $post->ID );
			?>
			<div class="<?php echo esc_attr( $prefix ); ?>-hero__shell pds-skin-hero pds-skin-hero--full-bleed">
				<a href="<?php echo esc_url( get_permalink( $post ) ); ?>" class="pds-hero-bleed">
					<?php echo promovads_thumbnail( $post->ID, 'promovads-hero' ); ?>
					<div class="pds-hero-bleed__overlay">
						<?php if ( $cat ) : ?>
							<span class="pds-hero-bleed__cat"><?php echo esc_html( $cat->name ); ?></span>
						<?php endif; ?>
						<h2><?php echo esc_html( get_the_title( $post ) ); ?></h2>
						<p><?php echo esc_html( promovads_truncate( get_the_excerpt( $post ), 140 ) ); ?></p>
					</div>
				</a>
			</div>
			<?php
			break;

		case 'magazine-stack':
			$posts = promovads_get_featured_posts( 4 );
			if ( empty( $posts ) ) {
				return;
			}
			?>
			<div class="<?php echo esc_attr( $prefix ); ?>-hero__shell pds-skin-hero pds-skin-hero--magazine-stack">
				<div class="pds-hero-stack">
					<?php foreach ( $posts as $i => $post ) : ?>
						<a href="<?php echo esc_url( get_permalink( $post ) ); ?>" class="pds-hero-stack__item pds-hero-stack__item--<?php echo esc_attr( (string) ( $i + 1 ) ); ?>">
							<?php echo promovads_thumbnail( $post->ID, 'promovads-card' ); ?>
							<h3><?php echo esc_html( get_the_title( $post ) ); ?></h3>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
			<?php
			break;

		case 'mosaic-4':
		case 'bento-grid':
			$posts = promovads_get_featured_posts( 4 );
			if ( empty( $posts ) ) {
				return;
			}
			?>
			<div class="<?php echo esc_attr( $prefix ); ?>-hero__shell pds-skin-hero pds-skin-hero--<?php echo esc_attr( $slug ); ?>">
				<div class="pds-hero-mosaic">
					<?php foreach ( $posts as $i => $post ) : ?>
						<a href="<?php echo esc_url( get_permalink( $post ) ); ?>" class="pds-hero-mosaic__cell pds-hero-mosaic__cell--<?php echo esc_attr( (string) ( $i + 1 ) ); ?>">
							<?php echo promovads_thumbnail( $post->ID, 'promovads-card' ); ?>
							<span><?php echo esc_html( get_the_title( $post ) ); ?></span>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
			<?php
			break;

		case 'ranked-list':
			$posts = promovads_get_featured_posts( 5 );
			if ( empty( $posts ) ) {
				return;
			}
			?>
			<div class="<?php echo esc_attr( $prefix ); ?>-hero__shell pds-skin-hero pds-skin-hero--ranked-list">
				<ol class="pds-hero-ranked">
					<?php foreach ( $posts as $i => $post ) : ?>
						<li>
							<a href="<?php echo esc_url( get_permalink( $post ) ); ?>">
								<span class="pds-hero-ranked__n"><?php echo esc_html( str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
								<span class="pds-hero-ranked__title"><?php echo esc_html( get_the_title( $post ) ); ?></span>
								<span class="pds-hero-ranked__meta"><?php echo esc_html( promovads_time_ago_ar( $post->ID ) ); ?></span>
							</a>
						</li>
					<?php endforeach; ?>
				</ol>
			</div>
			<?php
			break;

		case 'video-style':
			$posts = promovads_get_featured_posts( 1 );
			if ( empty( $posts ) ) {
				return;
			}
			$post = $posts[0];
			?>
			<div class="<?php echo esc_attr( $prefix ); ?>-hero__shell pds-skin-hero pds-skin-hero--video-style">
				<a href="<?php echo esc_url( get_permalink( $post ) ); ?>" class="pds-hero-video">
					<?php echo promovads_thumbnail( $post->ID, 'promovads-hero' ); ?>
					<span class="pds-hero-video__play" aria-hidden="true"><i class="fas fa-play"></i></span>
					<div class="pds-hero-video__body">
						<h2><?php echo esc_html( get_the_title( $post ) ); ?></h2>
						<span><?php echo esc_html( promovads_reading_time( $post->ID ) ); ?></span>
					</div>
				</a>
			</div>
			<?php
			break;

		case 'breaking-split':
			$posts = promovads_get_featured_posts( 4 );
			if ( empty( $posts ) ) {
				return;
			}
			$break = array_shift( $posts );
			?>
			<div class="<?php echo esc_attr( $prefix ); ?>-hero__shell pds-skin-hero pds-skin-hero--breaking-split">
				<div class="pds-hero-breaking grid g-main" style="gap:16px">
					<a href="<?php echo esc_url( get_permalink( $break ) ); ?>" class="pds-hero-breaking__main">
						<span class="pds-hero-breaking__label"><?php esc_html_e( 'عاجل', 'promovads' ); ?></span>
						<h2><?php echo esc_html( get_the_title( $break ) ); ?></h2>
					</a>
					<div class="pds-hero-breaking__list">
						<?php foreach ( $posts as $post ) : ?>
							<a href="<?php echo esc_url( get_permalink( $post ) ); ?>"><?php echo esc_html( get_the_title( $post ) ); ?></a>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
			<?php
			break;

		case 'minimal-text':
			$posts = promovads_get_featured_posts( 6 );
			if ( empty( $posts ) ) {
				return;
			}
			?>
			<div class="<?php echo esc_attr( $prefix ); ?>-hero__shell pds-skin-hero pds-skin-hero--minimal-text">
				<ul class="pds-hero-minimal">
					<?php foreach ( $posts as $post ) : ?>
						<li><a href="<?php echo esc_url( get_permalink( $post ) ); ?>"><?php echo esc_html( get_the_title( $post ) ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<?php
			break;

		case 'dual-feature':
			$posts = promovads_get_featured_posts( 2 );
			if ( count( $posts ) < 2 ) {
				return;
			}
			?>
			<div class="<?php echo esc_attr( $prefix ); ?>-hero__shell pds-skin-hero pds-skin-hero--dual-feature">
				<div class="pds-hero-dual grid g2" style="gap:16px">
					<?php foreach ( $posts as $post ) : ?>
						<a href="<?php echo esc_url( get_permalink( $post ) ); ?>" class="pds-hero-dual__card">
							<?php echo promovads_thumbnail( $post->ID, 'promovads-featured' ); ?>
							<h3><?php echo esc_html( get_the_title( $post ) ); ?></h3>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
			<?php
			break;

		default:
			get_template_part( 'template-parts/demos/_shared/hero-grid' );
	}
}

/**
 * Category section variants.
 *
 * @param array<string, mixed> $args
 */
function promovads_skin_render_cat_section( string $slug, array $args = array() ): void {
	$cat    = $args['category'] ?? null;
	$posts  = $args['posts'] ?? array();
	$config = promovads_get_demo_config();

	if ( ! $cat instanceof WP_Term || empty( $posts ) || ! $config ) {
		return;
	}

	$color = promovads_get_category_color( $cat->term_id, $config['primary'] ?? '#6366f1' );
	$icon  = promovads_get_category_icon( $cat->term_id, 'fa-folder' );
	$desc  = term_description( $cat->term_id, 'category' );

	promovads_skin_cat_section_open( $cat, $color, $icon, $desc, $slug );

	switch ( $slug ) {
		case 'masonry-2':
			echo '<div class="pds-cat-masonry grid g2" style="gap:16px">';
			foreach ( $posts as $i => $post ) {
				echo '<div class="pds-cat-masonry__item' . ( 0 === $i % 2 ? ' is-tall' : '' ) . '">';
				get_template_part( 'template-parts/demos/_shared/card', null, array( 'post' => $post ) );
				echo '</div>';
			}
			echo '</div>';
			break;

		case 'timeline':
			echo '<div class="pds-cat-timeline">';
			foreach ( $posts as $post ) {
				echo '<a href="' . esc_url( get_permalink( $post ) ) . '" class="pds-cat-timeline__row">';
				echo '<span class="pds-cat-timeline__dot"></span>';
				echo '<span>' . esc_html( get_the_title( $post ) ) . '</span>';
				echo '<time>' . esc_html( promovads_time_ago_ar( $post->ID ) ) . '</time>';
				echo '</a>';
			}
			echo '</div>';
			break;

		case 'compact-list':
			echo '<div class="pds-cat-compact">';
			foreach ( $posts as $post ) {
				echo '<a href="' . esc_url( get_permalink( $post ) ) . '" class="pds-cat-compact__row">';
				echo promovads_thumbnail( $post->ID, 'thumbnail' );
				echo '<span>' . esc_html( get_the_title( $post ) ) . '</span>';
				echo '</a>';
			}
			echo '</div>';
			break;

		case 'magazine-row':
			$main = $posts[0];
			$rest = array_slice( $posts, 1 );
			echo '<div class="pds-cat-magazine">';
			echo '<a href="' . esc_url( get_permalink( $main ) ) . '" class="pds-cat-magazine__wide">';
			echo promovads_thumbnail( $main->ID, 'promovads-featured' );
			echo '<h3>' . esc_html( get_the_title( $main ) ) . '</h3></a>';
			echo '<div class="pds-cat-magazine__sm grid g2" style="gap:12px">';
			foreach ( $rest as $post ) {
				get_template_part( 'template-parts/demos/_shared/card', null, array( 'post' => $post ) );
			}
			echo '</div></div>';
			break;

		case 'numbered':
			echo '<div class="pds-cat-numbered">';
			foreach ( $posts as $i => $post ) {
				printf(
					'<a href="%s" class="pds-cat-numbered__row"><span class="pds-cat-numbered__n">%s</span><span>%s</span></a>',
					esc_url( get_permalink( $post ) ),
					esc_html( str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ) ),
					esc_html( get_the_title( $post ) )
				);
			}
			echo '</div>';
			break;

		case 'overlay-strip':
			echo '<div class="pds-cat-strip">';
			foreach ( $posts as $post ) {
				echo '<a href="' . esc_url( get_permalink( $post ) ) . '" class="pds-cat-strip__item">';
				echo promovads_thumbnail( $post->ID, 'promovads-card' );
				echo '<span>' . esc_html( get_the_title( $post ) ) . '</span></a>';
			}
			echo '</div>';
			break;

		case 'tabbed':
			echo '<div class="pds-cat-tabbed"><div class="pds-cat-tabbed__tabs"><span class="is-active">' . esc_html( $cat->name ) . '</span></div>';
			echo '<div class="grid g3">';
			foreach ( $posts as $post ) {
				get_template_part( 'template-parts/demos/_shared/card', null, array( 'post' => $post ) );
			}
			echo '</div></div>';
			break;

		default:
			echo '<div class="grid g3">';
			foreach ( $posts as $post ) {
				get_template_part( 'template-parts/demos/_shared/card', null, array( 'post' => $post ) );
			}
			echo '</div>';
	}

	echo '</section>';
}

/**
 * Latest news variants.
 *
 * @param array<string, mixed> $args
 */
function promovads_skin_render_latest( string $slug, array $args = array() ): void {
	$query   = $args['query'] ?? promovads_get_posts( array( 'posts_per_page' => 8 ) );
	$archive = $args['archive_url'] ?? promovads_posts_archive_url();

	if ( ! $query instanceof WP_Query || ! $query->have_posts() ) {
		return;
	}
	?>
	<section class="latest-block pds-skin-latest pds-skin-latest--<?php echo esc_attr( $slug ); ?>">
		<div class="latest-block__head">
			<h2 class="latest-block__title"><?php esc_html_e( 'آخر', 'promovads' ); ?> <span><?php esc_html_e( 'الأخبار', 'promovads' ); ?></span></h2>
			<a href="<?php echo esc_url( $archive ); ?>" class="cat-section__btn"><i class="fas fa-newspaper"></i> <?php esc_html_e( 'عرض كل المقالات', 'promovads' ); ?></a>
		</div>
		<?php
		switch ( $slug ) {
			case 'card-carousel':
				echo '<div class="pds-latest-carousel"><div class="pds-latest-carousel__track">';
				while ( $query->have_posts() ) {
					$query->the_post();
					echo '<div class="pds-latest-carousel__slide">';
					get_template_part( 'template-parts/demos/_shared/card' );
					echo '</div>';
				}
				echo '</div></div>';
				break;

			case 'split-featured':
				$first = true;
				echo '<div class="pds-latest-split grid g-main" style="gap:20px"><div class="pds-latest-split__main">';
				while ( $query->have_posts() ) {
					$query->the_post();
					if ( $first ) {
						echo '<a href="' . esc_url( get_permalink() ) . '" class="pds-latest-split__lead">';
						echo promovads_thumbnail( 0, 'promovads-featured' );
						echo '<h3>' . esc_html( get_the_title() ) . '</h3></a></div><div class="pds-latest-split__list">';
						$first = false;
						continue;
					}
					echo '<a href="' . esc_url( get_permalink() ) . '" class="pds-latest-split__row">' . esc_html( get_the_title() ) . '</a>';
				}
				echo '</div></div>';
				break;

			case 'minimal-links':
				echo '<ul class="pds-latest-links">';
				while ( $query->have_posts() ) {
					$query->the_post();
					echo '<li><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . ' <time>' . esc_html( promovads_time_ago_ar() ) . '</time></a></li>';
				}
				echo '</ul>';
				break;

			case 'magazine-cols':
				echo '<div class="pds-latest-mag-cols grid g2" style="gap:16px">';
				while ( $query->have_posts() ) {
					$query->the_post();
					get_template_part( 'template-parts/demos/_shared/card' );
				}
				echo '</div>';
				break;

			case 'top-10':
				$trending = promovads_get_trending( 10 );
				echo '<ol class="pds-latest-top10">';
				$n = 0;
				while ( $trending->have_posts() ) {
					$trending->the_post();
					++$n;
					printf(
						'<li><a href="%s"><span class="pds-latest-top10__n">%s</span><span>%s</span></a></li>',
						esc_url( get_permalink() ),
						esc_html( (string) $n ),
						esc_html( get_the_title() )
					);
				}
				wp_reset_postdata();
				echo '</ol>';
				break;

			default:
				echo '<div class="latest-list">';
				while ( $query->have_posts() ) {
					$query->the_post();
					$lcat   = promovads_get_primary_category();
					$lcolor = $lcat ? promovads_get_category_color( $lcat->term_id ) : '#6366f1';
					?>
					<article class="latest-item">
						<a href="<?php the_permalink(); ?>" class="latest-item__img"><?php echo promovads_thumbnail( 0, 'promovads-thumb' ); ?></a>
						<div>
							<?php if ( $lcat ) : ?>
								<div class="latest-item__cat" style="color:<?php echo esc_attr( $lcolor ); ?>"><?php echo esc_html( $lcat->name ); ?></div>
							<?php endif; ?>
							<h3 class="latest-item__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						</div>
					</article>
					<?php
				}
				echo '</div>';
		}
		wp_reset_postdata();
		?>
	</section>
	<?php
}

/**
 * Archive header variants.
 */
function promovads_skin_render_archive_header( string $slug, array $args = array() ): void {
	$extra_class = 'pds-skin-archive--' . sanitize_html_class( $slug );

	switch ( $slug ) {
		case 'gradient-wave':
			?>
			<div class="archive-hd pds-skin-archive <?php echo esc_attr( $extra_class ); ?>">
				<div class="pds-archive-wave" aria-hidden="true"></div>
				<div class="wrap"><?php promovads_skin_archive_inner(); ?></div>
			</div>
			<?php
			break;

		case 'breadcrumb-inline':
			?>
			<div class="archive-hd pds-skin-archive <?php echo esc_attr( $extra_class ); ?>" style="background:var(--pds-surface);padding:24px 0">
				<div class="wrap">
					<nav class="pds-archive-crumb" aria-label="<?php esc_attr_e( 'مسار التنقل', 'promovads' ); ?>">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'الرئيسية', 'promovads' ); ?></a>
						<span>/</span>
						<span><?php echo esc_html( wp_get_document_title() ); ?></span>
					</nav>
					<?php promovads_skin_archive_inner( 'minimal' ); ?>
				</div>
			</div>
			<?php
			break;

		case 'split-stats':
			?>
			<div class="archive-hd pds-skin-archive <?php echo esc_attr( $extra_class ); ?>">
				<div class="wrap pds-archive-split-hd">
					<div class="pds-archive-split-hd__title"><?php promovads_skin_archive_inner( 'minimal' ); ?></div>
				</div>
			</div>
			<?php
			break;

		case 'glass-card':
			?>
			<div class="archive-hd pds-skin-archive <?php echo esc_attr( $extra_class ); ?>">
				<div class="wrap">
					<div class="pds-archive-glass"><?php promovads_skin_archive_inner(); ?></div>
				</div>
			</div>
			<?php
			break;

		case 'pattern-bg':
			?>
			<div class="archive-hd pds-skin-archive <?php echo esc_attr( $extra_class ); ?>">
				<div class="wrap"><?php promovads_skin_archive_inner(); ?></div>
			</div>
			<?php
			break;

		case 'author-card':
			?>
			<div class="archive-hd pds-skin-archive <?php echo esc_attr( $extra_class ); ?>" style="background:var(--pds-surface);padding:28px 0">
				<div class="wrap">
					<?php if ( is_author() ) : ?>
						<div class="pds-archive-author">
							<?php echo get_avatar( get_queried_object_id(), 80 ); ?>
							<div><?php promovads_skin_archive_inner(); ?></div>
						</div>
					<?php else : ?>
						<?php promovads_skin_archive_inner(); ?>
					<?php endif; ?>
				</div>
			</div>
			<?php
			break;

		case 'tag-cloud':
			?>
			<div class="archive-hd pds-skin-archive <?php echo esc_attr( $extra_class ); ?>" style="background:var(--pds-surface);padding:28px 0">
				<div class="wrap">
					<?php promovads_skin_archive_inner(); ?>
					<?php if ( is_tag() ) :
						$related = get_tags( array( 'number' => 8, 'orderby' => 'count', 'order' => 'DESC' ) );
						if ( $related ) :
							echo '<div class="pds-archive-tags">';
							foreach ( $related as $tag ) {
								echo '<a href="' . esc_url( get_tag_link( $tag ) ) . '">#' . esc_html( $tag->name ) . '</a>';
							}
							echo '</div>';
						endif;
					endif; ?>
				</div>
			</div>
			<?php
			break;

		default:
			?>
			<div class="archive-hd pds-skin-archive <?php echo esc_attr( $extra_class ); ?>">
				<div class="wrap"><?php promovads_skin_archive_inner(); ?></div>
			</div>
			<?php
	}
}

/**
 * Open category section wrapper.
 */
function promovads_skin_cat_section_open( WP_Term $cat, string $color, string $icon, string $desc, string $slug ): void {
	?>
	<section class="cat-section cat-section--<?php echo esc_attr( $cat->slug ); ?> pds-skin-cat pds-skin-cat--<?php echo esc_attr( $slug ); ?>">
		<div class="cat-section__head">
			<div class="cat-section__info">
				<div class="cat-section__icon" style="background:<?php echo esc_attr( $color ); ?>"><i class="fas <?php echo esc_attr( $icon ); ?>"></i></div>
				<div>
					<h2 class="cat-section__name"><?php echo esc_html( $cat->name ); ?></h2>
					<?php if ( $desc ) : ?>
						<p class="cat-section__desc"><?php echo wp_kses_post( wp_strip_all_tags( $desc ) ); ?></p>
					<?php endif; ?>
				</div>
			</div>
			<a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" class="cat-section__btn"><i class="fas fa-arrow-left"></i> <?php esc_html_e( 'عرض المزيد', 'promovads' ); ?></a>
		</div>
	<?php
}
