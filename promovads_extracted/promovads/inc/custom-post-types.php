<?php
/**
 * Custom Post Types & Taxonomies
 *
 * @package PromovaDS_News
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register all custom post types.
 */
function promovads_register_post_types() {

	// ── Jobs ──────────────────────────────────────────────────────────────────
	register_post_type(
		'pds_job',
		array(
			'labels'       => promovads_cpt_labels( 'Job', 'Jobs' ),
			'public'       => true,
			'has_archive'  => true,
			'rewrite'      => array( 'slug' => 'jobs' ),
			'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
			'menu_icon'    => 'dashicons-businessman',
			'show_in_rest' => true,
		)
	);

	// ── Reviews ───────────────────────────────────────────────────────────────
	register_post_type(
		'pds_review',
		array(
			'labels'       => promovads_cpt_labels( 'Review', 'Reviews' ),
			'public'       => true,
			'has_archive'  => true,
			'rewrite'      => array( 'slug' => 'reviews' ),
			'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'comments' ),
			'menu_icon'    => 'dashicons-star-filled',
			'show_in_rest' => true,
		)
	);

	// ── Matches (Sports) ──────────────────────────────────────────────────────
	register_post_type(
		'pds_match',
		array(
			'labels'       => promovads_cpt_labels( 'Match', 'Matches' ),
			'public'       => true,
			'has_archive'  => true,
			'rewrite'      => array( 'slug' => 'matches' ),
			'supports'     => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
			'menu_icon'    => 'dashicons-awards',
			'show_in_rest' => true,
		)
	);

	// ── Properties (Real Estate) ──────────────────────────────────────────────
	register_post_type(
		'pds_property',
		array(
			'labels'       => promovads_cpt_labels( 'Property', 'Properties' ),
			'public'       => true,
			'has_archive'  => true,
			'rewrite'      => array( 'slug' => 'properties' ),
			'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'comments' ),
			'menu_icon'    => 'dashicons-building',
			'show_in_rest' => true,
		)
	);

	// ── Courses (Education) ───────────────────────────────────────────────────
	register_post_type(
		'pds_course',
		array(
			'labels'       => promovads_cpt_labels( 'Course', 'Courses' ),
			'public'       => true,
			'has_archive'  => true,
			'rewrite'      => array( 'slug' => 'courses' ),
			'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
			'menu_icon'    => 'dashicons-graduation',
			'show_in_rest' => true,
		)
	);

	// ── Coins (Crypto) ────────────────────────────────────────────────────────
	register_post_type(
		'pds_coin',
		array(
			'labels'       => promovads_cpt_labels( 'Coin', 'Coins' ),
			'public'       => true,
			'has_archive'  => true,
			'rewrite'      => array( 'slug' => 'coins' ),
			'supports'     => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
			'menu_icon'    => 'dashicons-chart-line',
			'show_in_rest' => true,
		)
	);
}
add_action( 'init', 'promovads_register_post_types' );

/**
 * Register custom taxonomies.
 */
function promovads_register_taxonomies() {

	// Job Type
	register_taxonomy(
		'job_type',
		'pds_job',
		array(
			'labels'            => promovads_tax_labels( 'Job Type', 'Job Types' ),
			'hierarchical'      => true,
			'rewrite'           => array( 'slug' => 'job-type' ),
			'show_in_rest'      => true,
			'show_admin_column' => true,
		)
	);

	// Job Location
	register_taxonomy(
		'job_location',
		'pds_job',
		array(
			'labels'            => promovads_tax_labels( 'Location', 'Locations' ),
			'hierarchical'      => false,
			'rewrite'           => array( 'slug' => 'job-location' ),
			'show_in_rest'      => true,
			'show_admin_column' => true,
		)
	);

	// Review Category
	register_taxonomy(
		'review_cat',
		'pds_review',
		array(
			'labels'            => promovads_tax_labels( 'Review Category', 'Review Categories' ),
			'hierarchical'      => true,
			'rewrite'           => array( 'slug' => 'review-category' ),
			'show_in_rest'      => true,
			'show_admin_column' => true,
		)
	);

	// Sport
	register_taxonomy(
		'sport',
		'pds_match',
		array(
			'labels'            => promovads_tax_labels( 'Sport', 'Sports' ),
			'hierarchical'      => true,
			'rewrite'           => array( 'slug' => 'sport' ),
			'show_in_rest'      => true,
			'show_admin_column' => true,
		)
	);

	// Property Type
	register_taxonomy(
		'property_type',
		'pds_property',
		array(
			'labels'            => promovads_tax_labels( 'Property Type', 'Property Types' ),
			'hierarchical'      => true,
			'rewrite'           => array( 'slug' => 'property-type' ),
			'show_in_rest'      => true,
			'show_admin_column' => true,
		)
	);

	// Course Category
	register_taxonomy(
		'course_cat',
		'pds_course',
		array(
			'labels'            => promovads_tax_labels( 'Course Category', 'Course Categories' ),
			'hierarchical'      => true,
			'rewrite'           => array( 'slug' => 'course-category' ),
			'show_in_rest'      => true,
			'show_admin_column' => true,
		)
	);

	// Coin Category
	register_taxonomy(
		'coin_cat',
		'pds_coin',
		array(
			'labels'            => promovads_tax_labels( 'Coin Category', 'Coin Categories' ),
			'hierarchical'      => true,
			'rewrite'           => array( 'slug' => 'coin-category' ),
			'show_in_rest'      => true,
			'show_admin_column' => true,
		)
	);
}
add_action( 'init', 'promovads_register_taxonomies' );

/**
 * Generate CPT labels array.
 */
function promovads_cpt_labels( string $singular, string $plural ): array {
	return array(
		'name'               => esc_html( $plural ),
		'singular_name'      => esc_html( $singular ),
		'add_new'            => esc_html__( 'Add New', 'promovads' ),
		'add_new_item'       => sprintf( esc_html__( 'Add New %s', 'promovads' ), $singular ),
		'edit_item'          => sprintf( esc_html__( 'Edit %s', 'promovads' ), $singular ),
		'new_item'           => sprintf( esc_html__( 'New %s', 'promovads' ), $singular ),
		'view_item'          => sprintf( esc_html__( 'View %s', 'promovads' ), $singular ),
		'search_items'       => sprintf( esc_html__( 'Search %s', 'promovads' ), $plural ),
		'not_found'          => sprintf( esc_html__( 'No %s found.', 'promovads' ), strtolower( $plural ) ),
		'not_found_in_trash' => sprintf( esc_html__( 'No %s found in Trash.', 'promovads' ), strtolower( $plural ) ),
		'menu_name'          => esc_html( $plural ),
	);
}

/**
 * Generate taxonomy labels array.
 */
function promovads_tax_labels( string $singular, string $plural ): array {
	return array(
		'name'          => esc_html( $plural ),
		'singular_name' => esc_html( $singular ),
		'search_items'  => sprintf( esc_html__( 'Search %s', 'promovads' ), $plural ),
		'all_items'     => sprintf( esc_html__( 'All %s', 'promovads' ), $plural ),
		'edit_item'     => sprintf( esc_html__( 'Edit %s', 'promovads' ), $singular ),
		'update_item'   => sprintf( esc_html__( 'Update %s', 'promovads' ), $singular ),
		'add_new_item'  => sprintf( esc_html__( 'Add New %s', 'promovads' ), $singular ),
		'new_item_name' => sprintf( esc_html__( 'New %s Name', 'promovads' ), $singular ),
		'menu_name'     => esc_html( $plural ),
	);
}

/**
 * Add meta boxes for CPTs.
 */
function promovads_add_meta_boxes() {

	// Job meta
	add_meta_box( 'pds-job-details',      esc_html__( 'Job Details', 'promovads' ),      'promovads_job_meta_box',      'pds_job',      'normal', 'high' );

	// Review meta
	add_meta_box( 'pds-review-score',     esc_html__( 'Review Score', 'promovads' ),     'promovads_review_meta_box',   'pds_review',   'side',   'high' );

	// Match meta
	add_meta_box( 'pds-match-details',    esc_html__( 'Match Details', 'promovads' ),    'promovads_match_meta_box',    'pds_match',    'normal', 'high' );

	// Property meta
	add_meta_box( 'pds-property-details', esc_html__( 'Property Details', 'promovads' ), 'promovads_property_meta_box', 'pds_property', 'normal', 'high' );

	// Coin meta
	add_meta_box( 'pds-coin-details',     esc_html__( 'Coin Details', 'promovads' ),     'promovads_coin_meta_box',     'pds_coin',     'normal', 'high' );
}
add_action( 'add_meta_boxes', 'promovads_add_meta_boxes' );

/**
 * Job meta box callback.
 */
function promovads_job_meta_box( WP_Post $post ): void {
	wp_nonce_field( 'promovads_job_meta', 'pds_job_nonce' );

	$fields = array(
		'pds_company'     => esc_html__( 'Company Name', 'promovads' ),
		'pds_location'    => esc_html__( 'Location', 'promovads' ),
		'pds_salary'      => esc_html__( 'Salary Range', 'promovads' ),
		'pds_job_type'    => esc_html__( 'Job Type (Full/Part/Remote)', 'promovads' ),
		'pds_deadline'    => esc_html__( 'Application Deadline', 'promovads' ),
		'pds_apply_link'  => esc_html__( 'Application URL', 'promovads' ),
	);

	echo '<table class="form-table">';
	foreach ( $fields as $key => $label ) {
		$value = get_post_meta( $post->ID, $key, true );
		printf(
			'<tr><th><label for="%1$s">%2$s</label></th><td><input type="text" id="%1$s" name="%1$s" value="%3$s" class="regular-text" /></td></tr>',
			esc_attr( $key ),
			esc_html( $label ),
			esc_attr( $value )
		);
	}
	echo '</table>';
}

/**
 * Review meta box callback.
 */
function promovads_review_meta_box( WP_Post $post ): void {
	wp_nonce_field( 'promovads_review_meta', 'pds_review_nonce' );

	$score    = get_post_meta( $post->ID, 'pds_review_score', true );
	$verdict  = get_post_meta( $post->ID, 'pds_verdict', true );

	echo '<p><label><strong>' . esc_html__( 'Score (0-10)', 'promovads' ) . '</strong></label><br>';
	printf( '<input type="number" name="pds_review_score" value="%s" min="0" max="10" step="0.5" style="width:80px" /></p>', esc_attr( $score ) );

	echo '<p><label><strong>' . esc_html__( 'Verdict', 'promovads' ) . '</strong></label><br>';
	printf( '<input type="text" name="pds_verdict" value="%s" class="regular-text" placeholder="e.g. Excellent" /></p>', esc_attr( $verdict ) );
}

/**
 * Match meta box callback.
 */
function promovads_match_meta_box( WP_Post $post ): void {
	wp_nonce_field( 'promovads_match_meta', 'pds_match_nonce' );

	$fields = array(
		'pds_home_team'   => esc_html__( 'Home Team', 'promovads' ),
		'pds_away_team'   => esc_html__( 'Away Team', 'promovads' ),
		'pds_home_score'  => esc_html__( 'Home Score', 'promovads' ),
		'pds_away_score'  => esc_html__( 'Away Score', 'promovads' ),
		'pds_match_date'  => esc_html__( 'Match Date & Time', 'promovads' ),
		'pds_venue'       => esc_html__( 'Venue', 'promovads' ),
		'pds_league'      => esc_html__( 'League / Competition', 'promovads' ),
		'pds_status'      => esc_html__( 'Status (scheduled/live/finished)', 'promovads' ),
	);

	echo '<table class="form-table">';
	foreach ( $fields as $key => $label ) {
		$value = get_post_meta( $post->ID, $key, true );
		printf(
			'<tr><th><label for="%1$s">%2$s</label></th><td><input type="text" id="%1$s" name="%1$s" value="%3$s" class="regular-text" /></td></tr>',
			esc_attr( $key ),
			esc_html( $label ),
			esc_attr( $value )
		);
	}
	echo '</table>';
}

/**
 * Property meta box callback.
 */
function promovads_property_meta_box( WP_Post $post ): void {
	wp_nonce_field( 'promovads_property_meta', 'pds_property_nonce' );

	$fields = array(
		'pds_price'       => esc_html__( 'Price', 'promovads' ),
		'pds_area'        => esc_html__( 'Area (sqm)', 'promovads' ),
		'pds_bedrooms'    => esc_html__( 'Bedrooms', 'promovads' ),
		'pds_bathrooms'   => esc_html__( 'Bathrooms', 'promovads' ),
		'pds_address'     => esc_html__( 'Full Address', 'promovads' ),
		'pds_lat'         => esc_html__( 'Latitude', 'promovads' ),
		'pds_lng'         => esc_html__( 'Longitude', 'promovads' ),
		'pds_agent'       => esc_html__( 'Agent Name', 'promovads' ),
		'pds_agent_phone' => esc_html__( 'Agent Phone', 'promovads' ),
		'pds_listing_type'=> esc_html__( 'Listing Type (sale/rent)', 'promovads' ),
	);

	echo '<table class="form-table">';
	foreach ( $fields as $key => $label ) {
		$value = get_post_meta( $post->ID, $key, true );
		printf(
			'<tr><th><label for="%1$s">%2$s</label></th><td><input type="text" id="%1$s" name="%1$s" value="%3$s" class="regular-text" /></td></tr>',
			esc_attr( $key ),
			esc_html( $label ),
			esc_attr( $value )
		);
	}
	echo '</table>';
}

/**
 * Coin meta box callback.
 */
function promovads_coin_meta_box( WP_Post $post ): void {
	wp_nonce_field( 'promovads_coin_meta', 'pds_coin_nonce' );

	$fields = array(
		'pds_symbol'      => esc_html__( 'Symbol (e.g. BTC)', 'promovads' ),
		'pds_price_usd'   => esc_html__( 'Current Price (USD)', 'promovads' ),
		'pds_market_cap'  => esc_html__( 'Market Cap', 'promovads' ),
		'pds_change_24h'  => esc_html__( '24h Change (%)', 'promovads' ),
		'pds_volume'      => esc_html__( '24h Volume', 'promovads' ),
		'pds_rank'        => esc_html__( 'CMC Rank', 'promovads' ),
		'pds_coingecko_id'=> esc_html__( 'CoinGecko ID', 'promovads' ),
	);

	echo '<table class="form-table">';
	foreach ( $fields as $key => $label ) {
		$value = get_post_meta( $post->ID, $key, true );
		printf(
			'<tr><th><label for="%1$s">%2$s</label></th><td><input type="text" id="%1$s" name="%1$s" value="%3$s" class="regular-text" /></td></tr>',
			esc_attr( $key ),
			esc_html( $label ),
			esc_attr( $value )
		);
	}
	echo '</table>';
}

/**
 * Save all meta box data.
 */
function promovads_save_meta_boxes( int $post_id ): void {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	// Job
	if ( isset( $_POST['pds_job_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pds_job_nonce'] ) ), 'promovads_job_meta' ) ) {
		$job_fields = array( 'pds_company', 'pds_location', 'pds_salary', 'pds_job_type', 'pds_deadline', 'pds_apply_link' );
		foreach ( $job_fields as $field ) {
			if ( isset( $_POST[ $field ] ) ) {
				update_post_meta( $post_id, $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
			}
		}
	}

	// Review
	if ( isset( $_POST['pds_review_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pds_review_nonce'] ) ), 'promovads_review_meta' ) ) {
		if ( isset( $_POST['pds_review_score'] ) ) {
			update_post_meta( $post_id, 'pds_review_score', floatval( $_POST['pds_review_score'] ) );
		}
		if ( isset( $_POST['pds_verdict'] ) ) {
			update_post_meta( $post_id, 'pds_verdict', sanitize_text_field( wp_unslash( $_POST['pds_verdict'] ) ) );
		}
	}

	// Match
	if ( isset( $_POST['pds_match_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pds_match_nonce'] ) ), 'promovads_match_meta' ) ) {
		$match_fields = array( 'pds_home_team', 'pds_away_team', 'pds_home_score', 'pds_away_score', 'pds_match_date', 'pds_venue', 'pds_league', 'pds_status' );
		foreach ( $match_fields as $field ) {
			if ( isset( $_POST[ $field ] ) ) {
				update_post_meta( $post_id, $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
			}
		}
	}

	// Property
	if ( isset( $_POST['pds_property_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pds_property_nonce'] ) ), 'promovads_property_meta' ) ) {
		$prop_fields = array( 'pds_price', 'pds_area', 'pds_bedrooms', 'pds_bathrooms', 'pds_address', 'pds_lat', 'pds_lng', 'pds_agent', 'pds_agent_phone', 'pds_listing_type' );
		foreach ( $prop_fields as $field ) {
			if ( isset( $_POST[ $field ] ) ) {
				update_post_meta( $post_id, $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
			}
		}
	}

	// Coin
	if ( isset( $_POST['pds_coin_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pds_coin_nonce'] ) ), 'promovads_coin_meta' ) ) {
		$coin_fields = array( 'pds_symbol', 'pds_price_usd', 'pds_market_cap', 'pds_change_24h', 'pds_volume', 'pds_rank', 'pds_coingecko_id' );
		foreach ( $coin_fields as $field ) {
			if ( isset( $_POST[ $field ] ) ) {
				update_post_meta( $post_id, $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
			}
		}
	}
}
add_action( 'save_post', 'promovads_save_meta_boxes' );
