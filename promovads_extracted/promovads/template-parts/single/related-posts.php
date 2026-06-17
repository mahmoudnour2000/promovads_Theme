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

$query_args = array(
	'posts_per_page'      => 3,
	'post_status'         => 'publish',
	'post__not_in'        => array( get_the_ID() ),
	'ignore_sticky_posts' => true,
	'orderby'             => 'date',
	'order'               => 'DESC',
);

$tax_query = array( 'relation' => 'OR' );

if ( ! empty( $cat_ids ) ) {
	$tax_query[] = array(
		'taxonomy' => 'category',
		'field'    => 'term_id',
		'terms'    => $cat_ids,
	);
}

if ( ! empty( $tag_ids ) ) {
	$tax_query[] = array(
		'taxonomy' => 'post_tag',
		'field'    => 'term_id',
		'terms'    => $tag_ids,
	);
}

if ( count( $tax_query ) > 1 ) {
	$query_args['tax_query'] = $tax_query;
}

$related = new WP_Query( $query_args );

	if ( ! $related->have_posts() && isset( $query_args['tax_query'] ) ) {
		unset( $query_args['tax_query'] );
		$related = new WP_Query( $query_args );
	}

	if ( ! $related->have_posts() ) {
		return;
	}
?>

<section class="pds-related">
	<h3 class="pds-related__title"><?php echo esc_html( promovads_active_demo() ? __( 'مقالات ذات صلة', 'promovads' ) : __( 'Related Stories', 'promovads' ) ); ?></h3>

	<div class="<?php echo promovads_active_demo() ? 'grid g3 pds-related__grid' : 'pds-grid pds-grid--3'; ?>">
		<?php
		while ( $related->have_posts() ) {
			$related->the_post();
			if ( promovads_active_demo() ) {
				get_template_part( 'template-parts/demos/_shared/card' );
			} else {
				get_template_part( 'template-parts/blocks/card', 'standard' );
			}
		}
		wp_reset_postdata();
		?>
	</div>
</section>
