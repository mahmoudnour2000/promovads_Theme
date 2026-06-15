<?php
/**
 * Related Posts
 *
 * @package PromovaDS_News
 */

$cats    = get_the_category();
$cat_ids = wp_list_pluck( $cats, 'term_id' );
$tags    = get_the_tags();
$tag_ids = $tags ? wp_list_pluck( $tags, 'term_id' ) : array();

$related = new WP_Query(
	array(
		'posts_per_page'      => 3,
		'post_status'         => 'publish',
		'post__not_in'        => array( get_the_ID() ),
		'ignore_sticky_posts' => true,
		'tax_query'           => array(
			'relation' => 'OR',
			array(
				'taxonomy' => 'category',
				'field'    => 'term_id',
				'terms'    => $cat_ids,
			),
			array(
				'taxonomy' => 'post_tag',
				'field'    => 'term_id',
				'terms'    => $tag_ids,
			),
		),
		'orderby'             => 'rand',
	)
);

if ( ! $related->have_posts() ) {
	return;
}
?>

<section class="pds-related">
	<h3 class="pds-related__title"><?php esc_html_e( 'Related Stories', 'promovads' ); ?></h3>

	<div class="pds-grid pds-grid--3">
		<?php
		while ( $related->have_posts() ) {
			$related->the_post();
			get_template_part( 'template-parts/blocks/card', 'standard' );
		}
		wp_reset_postdata();
		?>
	</div>
</section>
