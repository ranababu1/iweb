<?php
/**
 * Case studies.
 *
 * Registers the case_study post type and helpers to read its fields. Fields
 * are plain custom fields (use the "Custom Fields" box on the edit screen):
 *
 *  cs_category   Card label, e.g. "Website & SEO".
 *  cs_client     Client description.
 *  cs_industry   Industry.
 *  cs_services   Services delivered.
 *  cs_platform   Platform.
 *  cs_duration   Project duration.
 *  cs_stats      One per line: "3.5x | Organic traffic | Increase in organic traffic".
 *  cs_challenge  The challenge.
 *  cs_solution   Our solution.
 *  cs_delivered  What we delivered, one item per line.
 *  cs_quote, cs_quote_name, cs_quote_role   Optional client feedback.
 *
 * The excerpt is the intro paragraph, the featured image is the hero image,
 * and the editor content (for example a gallery) is the project gallery.
 *
 * @package iweb
 * @since 1.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register the case study post type.
 *
 * @since 1.8.0
 *
 * @return void
 */
function iweb_register_case_study() {
	register_post_type(
		'case_study',
		array(
			'labels'       => array(
				'name'          => __( 'Case studies', 'iweb' ),
				'singular_name' => __( 'Case study', 'iweb' ),
				'add_new_item'  => __( 'Add new case study', 'iweb' ),
				'edit_item'     => __( 'Edit case study', 'iweb' ),
			),
			'public'       => true,
			'has_archive'  => false,
			'menu_icon'    => 'dashicons-portfolio',
			'rewrite'      => array( 'slug' => 'work', 'with_front' => false ),
			'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'page-attributes' ),
			'show_in_rest' => false,
		)
	);
}
add_action( 'init', 'iweb_register_case_study' );

/**
 * Get a case study field.
 *
 * @since 1.8.0
 *
 * @param string   $key     Field name without checking the prefix.
 * @param int|null $post_id Post ID, defaults to the current post.
 * @return string Field value, or an empty string.
 */
function iweb_cs_field( $key, $post_id = null ) {
	return trim( (string) get_post_meta( $post_id ? $post_id : get_the_ID(), $key, true ) );
}

/**
 * Split a multi-line field into non-empty trimmed lines.
 *
 * @since 1.8.0
 *
 * @param string $value Field value.
 * @return string[] Lines.
 */
function iweb_cs_lines( $value ) {
	return array_values( array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) $value ) ) ) );
}

/**
 * Parse the cs_stats field into value, short label and long label.
 *
 * @since 1.8.0
 *
 * @param int|null $post_id Post ID.
 * @return array<int, array{value: string, short: string, long: string}>
 */
function iweb_cs_stats( $post_id = null ) {
	$stats = array();

	foreach ( iweb_cs_lines( iweb_cs_field( 'cs_stats', $post_id ) ) as $line ) {
		$parts   = array_map( 'trim', explode( '|', $line ) );
		$stats[] = array(
			'value' => $parts[0],
			'short' => isset( $parts[1] ) ? $parts[1] : '',
			'long'  => isset( $parts[2] ) ? $parts[2] : ( isset( $parts[1] ) ? $parts[1] : '' ),
		);
	}

	return $stats;
}

/**
 * Feed real case studies to the Our Work template.
 *
 * @since 1.8.0
 *
 * @param array $projects Projects supplied by other filters.
 * @return array
 */
function iweb_work_projects_from_case_studies( $projects ) {
	if ( $projects ) {
		return $projects;
	}

	$query = new WP_Query(
		array(
			'post_type'      => 'case_study',
			'posts_per_page' => 12,
			'orderby'        => 'menu_order date',
			'order'          => 'ASC',
			'no_found_rows'  => true,
		)
	);

	foreach ( $query->posts as $post ) {
		$projects[] = array(
			'category' => iweb_cs_field( 'cs_category', $post->ID ),
			'title'    => get_the_title( $post ),
			'excerpt'  => get_the_excerpt( $post ),
			'url'      => get_permalink( $post ),
			'image'    => (string) get_the_post_thumbnail_url( $post, 'medium_large' ),
		);
	}

	return $projects;
}
add_filter( 'iweb_work_projects', 'iweb_work_projects_from_case_studies' );

/**
 * Whether the current view is a single case study.
 *
 * @since 1.8.0
 *
 * @return bool
 */
function iweb_is_case_study_view() {
	return is_singular( 'case_study' );
}
