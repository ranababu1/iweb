<?php
/**
 * Customizer options for the iweb theme.
 *
 * Adds a "Theme Options" panel with the footer copyright text, the social
 * profile URLs, and the archive sidebar toggle. The helpers that read these
 * options from templates live here as well.
 *
 * @package iweb
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Add the theme options panel, sections, and controls to the Customizer.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager instance.
 * @return void
 */
function iweb_customize_register( $wp_customize ) {
	// Theme options panel.
	$wp_customize->add_panel(
		'iweb_theme_options',
		array(
			'title'       => __( 'Theme Options', 'iweb' ),
			'description' => __( 'Options provided by the iweb theme.', 'iweb' ),
		)
	);

	// Footer section: copyright text.
	$wp_customize->add_section(
		'iweb_footer',
		array(
			'title' => __( 'Footer', 'iweb' ),
			'panel' => 'iweb_theme_options',
		)
	);

	$wp_customize->add_setting(
		'iweb_footer_copyright',
		array(
			'default'           => iweb_copyright_default(),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'iweb_footer_copyright',
		array(
			'label'   => __( 'Footer copyright text', 'iweb' ),
			'section' => 'iweb_footer',
			'type'    => 'text',
		)
	);

	// Selective refresh partial for the copyright text (no extra JS needed).
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'iweb_footer_copyright',
			array(
				'selector'        => '.iweb-copyright',
				'render_callback' => 'iweb_the_footer_copyright',
			)
		);
	}

	// Social profiles section: one URL field per network.
	$wp_customize->add_section(
		'iweb_social',
		array(
			'title'       => __( 'Social Profiles', 'iweb' ),
			'description' => __( 'Filled profiles are shown in the footer when the social menu is not assigned.', 'iweb' ),
			'panel'       => 'iweb_theme_options',
		)
	);

	foreach ( iweb_social_networks() as $iweb_network => $iweb_label ) {
		$wp_customize->add_setting(
			'iweb_social_' . $iweb_network,
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
			)
		);

		$wp_customize->add_control(
			'iweb_social_' . $iweb_network,
			array(
				'label'   => $iweb_label,
				'section' => 'iweb_social',
				'type'    => 'url',
			)
		);
	}

	// Layout section: sidebar toggle for archive views.
	$wp_customize->add_section(
		'iweb_layout',
		array(
			'title' => __( 'Layout', 'iweb' ),
			'panel' => 'iweb_theme_options',
		)
	);

	$wp_customize->add_setting(
		'iweb_archive_sidebar',
		array(
			'default'           => false,
			'sanitize_callback' => 'iweb_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'iweb_archive_sidebar',
		array(
			'label'       => __( 'Show the sidebar on archives', 'iweb' ),
			'description' => __( 'When the sidebar contains widgets, it is shown on the blog page, archive, and search views.', 'iweb' ),
			'section'     => 'iweb_layout',
			'type'        => 'checkbox',
		)
	);
}
add_action( 'customize_register', 'iweb_customize_register' );

/**
 * Sanitize a checkbox value.
 *
 * @since 1.0.0
 *
 * @param mixed $checked The submitted value.
 * @return bool True when checked, false otherwise.
 */
function iweb_sanitize_checkbox( $checked ) {
	return ( isset( $checked ) && true === $checked );
}

/**
 * Build the default footer copyright text.
 *
 * The year is computed at runtime and the site name is filled in, so the
 * default stays current instead of being hardcoded.
 *
 * @since 1.0.0
 *
 * @return string The default copyright text.
 */
function iweb_copyright_default() {
	return sprintf(
		/* translators: 1: the current year, 2: the site name. */
		__( '© %1$s %2$s', 'iweb' ),
		wp_date( 'Y' ),
		get_bloginfo( 'name' )
	);
}

/**
 * Get the footer copyright text from the Customizer.
 *
 * @since 1.0.0
 *
 * @return string The copyright text.
 */
function iweb_get_footer_copyright() {
	return get_theme_mod( 'iweb_footer_copyright', iweb_copyright_default() );
}

/**
 * Print the escaped footer copyright text.
 *
 * Doubles as the selective refresh render callback for the copyright
 * partial, so the Customizer preview updates without a page reload.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iweb_the_footer_copyright() {
	echo esc_html( iweb_get_footer_copyright() );
}

/**
 * Get the supported social networks and their translatable labels.
 *
 * @since 1.0.0
 *
 * @return array<string, string> Network slug => label.
 */
function iweb_social_networks() {
	return apply_filters(
		'iweb_social_networks',
		array(
			'facebook'  => __( 'Facebook', 'iweb' ),
			'x'         => __( 'X', 'iweb' ),
			'instagram' => __( 'Instagram', 'iweb' ),
			'linkedin'  => __( 'LinkedIn', 'iweb' ),
			'youtube'   => __( 'YouTube', 'iweb' ),
			'github'    => __( 'GitHub', 'iweb' ),
		)
	);
}

/**
 * Get the social profiles that have a URL filled in.
 *
 * @since 1.0.0
 *
 * @return array<int, array<string, string>> Filled profiles (network, label, url).
 */
function iweb_get_social_profiles() {
	$iweb_profiles = array();

	foreach ( iweb_social_networks() as $iweb_network => $iweb_label ) {
		$iweb_url = get_theme_mod( 'iweb_social_' . $iweb_network, '' );

		if ( ! empty( $iweb_url ) ) {
			$iweb_profiles[] = array(
				'network' => $iweb_network,
				'label'   => $iweb_label,
				'url'     => $iweb_url,
			);
		}
	}

	return apply_filters( 'iweb_social_profiles', $iweb_profiles );
}