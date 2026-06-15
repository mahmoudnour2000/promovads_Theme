<?php
/**
 * Custom Widgets
 *
 * @package PromovaDS_News
 */

defined( 'ABSPATH' ) || exit;

// ── Breaking News / Ticker Widget ────────────────────────────────────────────
class PromovaDS_Ticker_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'promovads_ticker',
			esc_html__( 'PromovaDS: Breaking News Ticker', 'promovads' ),
			array( 'description' => esc_html__( 'Scrolling breaking news ticker.', 'promovads' ) )
		);
	}

	public function widget( $args, $instance ): void {
		$title  = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Breaking', 'promovads' );
		$count  = ! empty( $instance['count'] ) ? absint( $instance['count'] ) : 8;
		$cat    = ! empty( $instance['category'] ) ? absint( $instance['category'] ) : 0;

		$query_args = array(
			'posts_per_page'      => $count,
			'ignore_sticky_posts' => false,
			'post_status'         => 'publish',
		);
		if ( $cat ) {
			$query_args['cat'] = $cat;
		}

		$posts = new WP_Query( $query_args );
		if ( ! $posts->have_posts() ) {
			return;
		}

		get_template_part( 'template-parts/blocks/breaking-ticker', null, array(
			'title' => $title,
			'posts' => $posts,
		) );
	}

	public function form( $instance ): void {
		$title    = $instance['title']    ?? esc_html__( 'Breaking', 'promovads' );
		$count    = $instance['count']    ?? 8;
		$category = $instance['category'] ?? 0;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Label:', 'promovads' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Number of items:', 'promovads' ); ?></label>
			<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" step="1" min="1" value="<?php echo absint( $count ); ?>" size="3">
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ): array {
		return array(
			'title'    => sanitize_text_field( $new_instance['title'] ),
			'count'    => absint( $new_instance['count'] ),
			'category' => absint( $new_instance['category'] ?? 0 ),
		);
	}
}

// ── Trending Posts Widget ─────────────────────────────────────────────────────
class PromovaDS_Trending_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'promovads_trending',
			esc_html__( 'PromovaDS: Trending Posts', 'promovads' ),
			array( 'description' => esc_html__( 'Show most viewed posts.', 'promovads' ) )
		);
	}

	public function widget( $args, $instance ): void {
		echo wp_kses_post( $args['before_widget'] );

		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Trending', 'promovads' );
		echo wp_kses_post( $args['before_title'] ) . esc_html( $title ) . wp_kses_post( $args['after_title'] );

		$count = ! empty( $instance['count'] ) ? absint( $instance['count'] ) : 5;

		$posts = promovads_get_trending( $count );

		if ( $posts->have_posts() ) :
			echo '<ol class="pds-trending-list">';
			$i = 1;
			while ( $posts->have_posts() ) :
				$posts->the_post();
				?>
				<li class="pds-trending-item">
					<span class="pds-trending-item__num"><?php echo $i++; ?></span>
					<div class="pds-trending-item__content">
						<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
						<span><?php echo esc_html( promovads_time_ago() ); ?></span>
					</div>
				</li>
				<?php
			endwhile;
			wp_reset_postdata();
			echo '</ol>';
		endif;

		echo wp_kses_post( $args['after_widget'] );
	}

	public function form( $instance ): void {
		$title = $instance['title'] ?? esc_html__( 'Trending', 'promovads' );
		$count = $instance['count'] ?? 5;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'promovads' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Number of posts:', 'promovads' ); ?></label>
			<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" step="1" min="1" value="<?php echo absint( $count ); ?>" size="3">
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ): array {
		return array(
			'title' => sanitize_text_field( $new_instance['title'] ),
			'count' => absint( $new_instance['count'] ),
		);
	}
}

// ── Ad Banner Widget ──────────────────────────────────────────────────────────
class PromovaDS_Ad_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'promovads_ad',
			esc_html__( 'PromovaDS: Ad Banner', 'promovads' ),
			array( 'description' => esc_html__( 'Display an advertisement banner.', 'promovads' ) )
		);
	}

	public function widget( $args, $instance ): void {
		$image_url = ! empty( $instance['image_url'] ) ? $instance['image_url'] : '';
		$link_url  = ! empty( $instance['link_url'] )  ? $instance['link_url']  : '#';
		$alt       = ! empty( $instance['alt'] )       ? $instance['alt']       : esc_html__( 'Advertisement', 'promovads' );
		$nofollow  = ! empty( $instance['nofollow'] )  ? 'nofollow noopener' : 'noopener';

		if ( ! $image_url ) {
			return;
		}

		echo wp_kses_post( $args['before_widget'] );
		printf(
			'<p class="pds-ad-label">%s</p><a href="%s" class="pds-ad-banner" target="_blank" rel="%s"><img src="%s" alt="%s" loading="lazy"></a>',
			esc_html__( 'Advertisement', 'promovads' ),
			esc_url( $link_url ),
			esc_attr( $nofollow ),
			esc_url( $image_url ),
			esc_attr( $alt )
		);
		echo wp_kses_post( $args['after_widget'] );
	}

	public function form( $instance ): void {
		$image_url = $instance['image_url'] ?? '';
		$link_url  = $instance['link_url']  ?? '';
		$alt       = $instance['alt']       ?? '';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'image_url' ) ); ?>"><?php esc_html_e( 'Image URL:', 'promovads' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'image_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image_url' ) ); ?>" type="url" value="<?php echo esc_url( $image_url ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'link_url' ) ); ?>"><?php esc_html_e( 'Link URL:', 'promovads' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'link_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link_url' ) ); ?>" type="url" value="<?php echo esc_url( $link_url ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'alt' ) ); ?>"><?php esc_html_e( 'Alt Text:', 'promovads' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'alt' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'alt' ) ); ?>" type="text" value="<?php echo esc_attr( $alt ); ?>">
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ): array {
		return array(
			'image_url' => esc_url_raw( $new_instance['image_url'] ),
			'link_url'  => esc_url_raw( $new_instance['link_url'] ),
			'alt'       => sanitize_text_field( $new_instance['alt'] ),
			'nofollow'  => isset( $new_instance['nofollow'] ) ? 1 : 0,
		);
	}
}

// ── Social Counts Widget ──────────────────────────────────────────────────────
class PromovaDS_Social_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'promovads_social',
			esc_html__( 'PromovaDS: Social Follow', 'promovads' ),
			array( 'description' => esc_html__( 'Display social media follow buttons.', 'promovads' ) )
		);
	}

	public function widget( $args, $instance ): void {
		echo wp_kses_post( $args['before_widget'] );

		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Follow Us', 'promovads' );
		echo wp_kses_post( $args['before_title'] ) . esc_html( $title ) . wp_kses_post( $args['after_title'] );

		$networks = array(
			'facebook'  => array( 'icon' => 'fab fa-facebook-f',  'color' => '#1877f2', 'label' => 'Facebook' ),
			'twitter'   => array( 'icon' => 'fab fa-x-twitter',   'color' => '#000',    'label' => 'X (Twitter)' ),
			'instagram' => array( 'icon' => 'fab fa-instagram',   'color' => '#e1306c', 'label' => 'Instagram' ),
			'youtube'   => array( 'icon' => 'fab fa-youtube',     'color' => '#ff0000', 'label' => 'YouTube' ),
			'telegram'  => array( 'icon' => 'fab fa-telegram',    'color' => '#229ed9', 'label' => 'Telegram' ),
			'tiktok'    => array( 'icon' => 'fab fa-tiktok',      'color' => '#010101', 'label' => 'TikTok' ),
		);

		echo '<div class="pds-social-follow">';
		foreach ( $networks as $key => $net ) {
			$url     = ! empty( $instance[ $key . '_url' ] ) ? esc_url( $instance[ $key . '_url' ] ) : '';
			$count   = ! empty( $instance[ $key . '_count' ] ) ? esc_html( $instance[ $key . '_count' ] ) : '';

			if ( ! $url ) {
				continue;
			}

			printf(
				'<a href="%s" class="pds-social-follow__item" style="--net-color:%s" target="_blank" rel="noopener noreferrer" aria-label="%s">
					<span class="pds-social-follow__icon"><i class="%s"></i></span>
					<span class="pds-social-follow__info">
						<strong>%s</strong>
						<span>%s</span>
					</span>
				</a>',
				esc_url( $url ),
				esc_attr( $net['color'] ),
				esc_attr( $net['label'] ),
				esc_attr( $net['icon'] ),
				$count ? esc_html( $count ) : esc_html( $net['label'] ),
				$count ? esc_html__( 'Followers', 'promovads' ) : ''
			);
		}
		echo '</div>';

		echo wp_kses_post( $args['after_widget'] );
	}

	public function form( $instance ): void {
		$title    = $instance['title'] ?? esc_html__( 'Follow Us', 'promovads' );
		$networks = array( 'facebook', 'twitter', 'instagram', 'youtube', 'telegram', 'tiktok' );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'promovads' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php foreach ( $networks as $net ) : ?>
		<p>
			<label><?php echo esc_html( ucfirst( $net ) ) . ' URL:'; ?></label>
			<input class="widefat" name="<?php echo esc_attr( $this->get_field_name( $net . '_url' ) ); ?>" type="url" value="<?php echo esc_url( $instance[ $net . '_url' ] ?? '' ); ?>">
		</p>
		<?php endforeach; ?>
		<?php
	}

	public function update( $new_instance, $old_instance ): array {
		$result = array( 'title' => sanitize_text_field( $new_instance['title'] ) );
		$networks = array( 'facebook', 'twitter', 'instagram', 'youtube', 'telegram', 'tiktok' );
		foreach ( $networks as $net ) {
			$result[ $net . '_url' ]   = esc_url_raw( $new_instance[ $net . '_url' ] ?? '' );
			$result[ $net . '_count' ] = sanitize_text_field( $new_instance[ $net . '_count' ] ?? '' );
		}
		return $result;
	}
}

/**
 * Register all custom widgets.
 */
function promovads_register_widgets(): void {
	register_widget( 'PromovaDS_Ticker_Widget' );
	register_widget( 'PromovaDS_Trending_Widget' );
	register_widget( 'PromovaDS_Ad_Widget' );
	register_widget( 'PromovaDS_Social_Widget' );
}
add_action( 'widgets_init', 'promovads_register_widgets' );
