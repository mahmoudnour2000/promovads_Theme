<?php
/**
 * Skin: Archive header — صورة غلاف.
 *
 * @package PromovaDS_News
 */

$bg_style = '';
if ( is_category() ) {
	$term_id = get_queried_object_id();
	$thumb   = get_term_meta( $term_id, 'pds_cover', true );
	if ( $thumb ) {
		$url = wp_get_attachment_image_url( (int) $thumb, 'promovads-hero' );
		if ( $url ) {
			$bg_style = 'background-image:linear-gradient(rgba(15,23,42,.75),rgba(15,23,42,.75)),url(' . esc_url( $url ) . ');background-size:cover;background-position:center;';
		}
	}
}
?>
<div class="archive-hd pds-skin-archive pds-skin-archive--with-cover" style="<?php echo esc_attr( $bg_style ); ?>">
	<div class="wrap">
		<?php promovads_skin_archive_inner(); ?>
	</div>
</div>
