<?php
/**
 * Contextual end-of-post call to action.
 *
 * @package iweb
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registers the per-post CTA meta fields.
 */
function iweb_register_cta_meta() {
	foreach ( array( 'iws_cta_heading', 'iws_cta_line', 'iws_cta_link' ) as $key ) {
		register_post_meta(
			'post',
			$key,
			array(
				'type'              => 'string',
				'single'            => true,
				'show_in_rest'      => true,
				'sanitize_callback' => 'iws_cta_link' === $key ? 'esc_url_raw' : 'sanitize_text_field',
				'auth_callback'     => function () {
					return current_user_can( 'edit_posts' );
				},
			)
		);
	}
}
add_action( 'init', 'iweb_register_cta_meta' );

/**
 * Primary category: Yoast primary term, else the first category.
 *
 * @param int $post_id Post ID.
 * @return WP_Term|null
 */
function iweb_cta_primary_category( $post_id ) {
	$primary = (int) get_post_meta( $post_id, '_yoast_wpseo_primary_category', true );
	if ( $primary ) {
		$term = get_term( $primary, 'category' );
		if ( $term instanceof WP_Term ) {
			return $term;
		}
	}
	$cats = get_the_category( $post_id );
	return $cats ? $cats[0] : null;
}

/**
 * Category-based CTA defaults, keyed by category slug.
 *
 * @return array
 */
function iweb_cta_defaults() {
	$s    = function ( $slug ) {
		return home_url( '/services/' . $slug );
	};
	$auto = array(
		'heading' => __( 'Too much manual work?', 'iweb' ),
		'line'    => __( 'We automate the repetitive tasks so your team can focus on customers.', 'iweb' ),
		'link'    => $s( 'automate-the-busy-work' ),
	);
	$dev  = array(
		'heading' => __( 'Need a custom app built or fixed?', 'iweb' ),
		'line'    => __( 'We build, upgrade and support business software that fits how you work.', 'iweb' ),
		'link'    => $s( 'custom-development' ),
	);
	$web  = array(
		'heading' => __( 'Want a site that brings in leads?', 'iweb' ),
		'line'    => __( 'We design and build fast websites that turn visitors into customers.', 'iweb' ),
		'link'    => $s( 'turn-visitors-into-customers' ),
	);
	$seo  = array(
		'heading' => __( 'Want more people to find you?', 'iweb' ),
		'line'    => __( 'We help your business show up in search and AI answers.', 'iweb' ),
		'link'    => $s( 'get-found' ),
	);
	$data = array(
		'heading' => __( 'Not sure what is working?', 'iweb' ),
		'line'    => __( 'We set up tracking and reports you can trust and act on.', 'iweb' ),
		'link'    => $s( 'know-whats-working' ),
	);
	$wp   = array(
		'heading' => __( 'Need help with your WordPress site?', 'iweb' ),
		'line'    => __( 'We fix, speed up and look after WordPress sites.', 'iweb' ),
		'link'    => $s( 'turn-visitors-into-customers' ),
	);
	return array(
		'ai-automation'            => $auto,
		'automation-integrations'  => $auto,
		'custom-development'       => $dev,
		'net-development'          => $dev,
		'dotnet-development'       => $dev,
		'web-development'          => $dev,
		'cro-ux'                   => $web,
		'website-design'           => $web,
		'ecommerce'                => $web,
		'performance-security'     => $web,
		'seo'                      => $seo,
		'smm'                      => $seo,
		'analytics-reporting'      => $data,
		'wordpress'                => $wp,
		'_default'                 => array(
			'heading' => __( 'Have a project in mind?', 'iweb' ),
			'line'    => __( 'Tell us what you need and we will show you how we can help.', 'iweb' ),
			'link'    => home_url( '/contact' ),
		),
	);
}

/**
 * Resolves the CTA for a post: per-post meta first, then category default.
 *
 * @param int $post_id Post ID.
 * @return array heading, line, link.
 */
function iweb_post_cta( $post_id ) {
	$defaults = iweb_cta_defaults();
	$cat      = iweb_cta_primary_category( $post_id );
	$base     = ( $cat && isset( $defaults[ $cat->slug ] ) ) ? $defaults[ $cat->slug ] : $defaults['_default'];
	$cta      = array();
	foreach ( array( 'heading', 'line', 'link' ) as $f ) {
		$v         = trim( (string) get_post_meta( $post_id, 'iws_cta_' . $f, true ) );
		$cta[ $f ] = '' !== $v ? $v : $base[ $f ];
	}
	return apply_filters( 'iweb_post_cta', $cta, $post_id );
}
