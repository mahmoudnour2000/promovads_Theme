<?php
/**
 * Author Box
 *
 * @package PromovaDS_News
 */

$author_id  = get_the_author_meta( 'ID' );
$author_bio = get_the_author_meta( 'description' );
$author_url = get_author_posts_url( $author_id );
$socials    = promovads_author_social( $author_id );
$post_count = count_user_posts( $author_id );
?>

<div class="pds-author-box" itemscope itemtype="https://schema.org/Person">

	<?php echo get_avatar( $author_id, 90, '', '', array( 'class' => 'pds-author-box__avatar', 'itemprop' => 'image' ) ); ?>

	<div class="pds-author-box__info">

		<h3 class="pds-author-box__name" itemprop="name">
			<a href="<?php echo esc_url( $author_url ); ?>" itemprop="url">
				<?php echo esc_html( promovads_author_display_name( $author_id ) ); ?>
			</a>
		</h3>

		<?php
		$role = get_user_meta( $author_id, 'pds_author_role', true );
		if ( $role ) :
			?>
			<span class="pds-author-box__role"><?php echo esc_html( $role ); ?></span>
		<?php endif; ?>

		<?php if ( $author_bio ) : ?>
		<p class="pds-author-box__bio" itemprop="description">
			<?php echo esc_html( $author_bio ); ?>
		</p>
		<?php endif; ?>

		<p class="pds-author-box__posts">
			<a href="<?php echo esc_url( $author_url ); ?>">
				<?php
				printf(
					/* translators: %d: post count */
					esc_html( _n( '%d مقال', '%d مقال', $post_count, 'promovads' ) ),
					absint( $post_count )
				);
				?>
			</a>
		</p>

		<?php if ( $socials ) : ?>
		<div class="pds-author-box__social">
			<?php
			$icons = array(
				'twitter'   => 'fab fa-x-twitter',
				'facebook'  => 'fab fa-facebook-f',
				'instagram' => 'fab fa-instagram',
				'linkedin'  => 'fab fa-linkedin-in',
				'youtube'   => 'fab fa-youtube',
				'website'   => 'fas fa-globe',
			);

			foreach ( $socials as $net => $url ) :
				$icon = $icons[ $net ] ?? 'fas fa-link';
				?>
				<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( ucfirst( $net ) ); ?>">
					<i class="<?php echo esc_attr( $icon ); ?>" aria-hidden="true"></i>
				</a>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>

	</div>

</div>
