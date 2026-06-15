<?php
/**
 * Reusable Post Grid Block
 *
 * Usage:
 *   get_template_part( 'template-parts/blocks/post-grid', null, [
 *     'title'    => 'Latest News',
 *     'category' => 5,
 *     'columns'  => 3,
 *     'count'    => 6,
 *     'layout'   => 'standard|list|hero',
 *   ] );
 *
 * @package PromovaDS_News
 */

$args_data = isset( $args ) ? $args : array();

$title    = $args_data['title']    ?? '';
$category = $args_data['category'] ?? 0;
$tag      = $args_data['tag']      ?? '';
$columns  = $args_data['columns']  ?? 3;
$count    = $args_data['count']    ?? 6;
$layout   = $args_data['layout']   ?? 'standard';
$see_more = $args_data['see_more'] ?? '';

$query_args = array(
	'posts_per_page'      => absint( $count ),
	'post_status'         => 'publish',
	'ignore_sticky_posts' => true,
);

if ( $category ) {
	$query_args['cat'] = absint( $category );
}

if ( $tag ) {
	$query_args['tag'] = sanitize_key( $tag );
}

$posts = new WP_Query( $query_args );

if ( ! $posts->have_posts() ) {
	return;
}
?>

<section class="pds-section">

	<?php if ( $title || $see_more ) : ?>
	<div class="pds-section-header">
		<?php if ( $title ) : ?>
			<h2 class="pds-section-title"><?php echo esc_html( $title ); ?></h2>
		<?php endif; ?>
		<?php if ( $see_more ) : ?>
			<a href="<?php echo esc_url( $see_more ); ?>" class="pds-see-all">
				<?php esc_html_e( 'See All', 'promovads' ); ?>
				<i class="fas fa-arrow-right" aria-hidden="true"></i>
			</a>
		<?php endif; ?>
	</div>
	<?php endif; ?>

	<?php if ( 'list' === $layout ) : ?>
		<div class="pds-post-list">
			<?php
			while ( $posts->have_posts() ) {
				$posts->the_post();
				get_template_part( 'template-parts/blocks/card', 'list' );
			}
			?>
		</div>
	<?php else : ?>
		<div class="pds-grid pds-grid--<?php echo absint( $columns ); ?>">
			<?php
			while ( $posts->have_posts() ) {
				$posts->the_post();
				get_template_part( 'template-parts/blocks/card', $layout );
			}
			?>
		</div>
	<?php endif; ?>

</section>

<?php wp_reset_postdata(); ?>
