<?php
/**
 * Share Buttons
 *
 * @package PromovaDS_News
 */

$share_urls = promovads_share_urls();
$post_url   = esc_url( get_permalink() );
$post_title = esc_attr( get_the_title() );
?>

<div class="pds-share-box">
	<span class="pds-share-box__label"><?php esc_html_e( 'Share:', 'promovads' ); ?></span>

	<div class="pds-article-meta__share">
		<a href="<?php echo esc_url( $share_urls['facebook'] ); ?>" class="pds-share-fb"
		   target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Share on Facebook', 'promovads' ); ?>">
			<i class="fab fa-facebook-f" aria-hidden="true"></i>
		</a>

		<a href="<?php echo esc_url( $share_urls['twitter'] ); ?>" class="pds-share-tw"
		   target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Share on Twitter', 'promovads' ); ?>">
			<i class="fab fa-x-twitter" aria-hidden="true"></i>
		</a>

		<a href="<?php echo esc_url( $share_urls['whatsapp'] ); ?>" class="pds-share-wa"
		   target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Share on WhatsApp', 'promovads' ); ?>">
			<i class="fab fa-whatsapp" aria-hidden="true"></i>
		</a>

		<a href="<?php echo esc_url( $share_urls['linkedin'] ); ?>" class="pds-share-li"
		   target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Share on LinkedIn', 'promovads' ); ?>">
			<i class="fab fa-linkedin-in" aria-hidden="true"></i>
		</a>

		<button class="pds-share-copy pds-copy-url" data-url="<?php echo esc_url( get_permalink() ); ?>"
		        aria-label="<?php esc_attr_e( 'Copy link', 'promovads' ); ?>">
			<i class="fas fa-link" aria-hidden="true"></i>
		</button>
	</div>
</div>
