<?php
/**
 * Functions and filters for the iweb theme.
 *
 * Small theme behaviors that are not template tags: excerpt filters, the
 * sidebar decision, body classes, emoji removal, and head cleanup.
 *
 * @package iweb
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Filter the default excerpt length.
 *
 * @since 1.0.0
 *
 * @param int $length Default excerpt length in words.
 * @return int Filtered excerpt length in words.
 */
function iweb_excerpt_length( $length ) {
	return 30;
}
add_filter( 'excerpt_length', 'iweb_excerpt_length' );

/**
 * Filter the excerpt "read more" string and link to the full post.
 *
 * @since 1.0.0
 *
 * @param string $more The default excerpt suffix.
 * @return string HTML for the ellipsis and the read-more link.
 */
function iweb_excerpt_more( $more ) {
	return sprintf(
		'&hellip; <a class="read-more" href="%1$s">%2$s</a>',
		esc_url( get_permalink() ),
		esc_html__( 'Read more', 'iweb' )
	);
}
add_filter( 'excerpt_more', 'iweb_excerpt_more' );

/**
 * Check whether the current view shows the sidebar.
 *
 * The sidebar appears on the blog page, archives, and search results when
 * the "Show the sidebar on archives" Customizer option is enabled and the
 * sidebar contains at least one widget. Singular views never show it.
 *
 * @since 1.0.0
 *
 * @return bool True when the sidebar should be shown.
 */
function iweb_has_sidebar() {
	$iweb_has_sidebar = false;

	if ( is_active_sidebar( 'sidebar-1' ) ) {
		if ( is_home() || is_archive() || is_search() ) {
			$iweb_has_sidebar = (bool) get_theme_mod( 'iweb_archive_sidebar', false );
		}
	}

	return (bool) apply_filters( 'iweb_has_sidebar', $iweb_has_sidebar );
}

/**
 * Add layout body classes so the CSS can react to the sidebar state.
 *
 * @since 1.0.0
 *
 * @param array $classes Body classes for the current view.
 * @return array Filtered body classes.
 */
function iweb_body_classes( $classes ) {
	if ( iweb_has_sidebar() ) {
		$classes[] = 'has-sidebar';
	} else {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'iweb_body_classes' );

/**
 * Disable WordPress emoji output.
 *
 * Removes the emoji detection scripts and styles, the TinyMCE emoji plugin,
 * and the emoji DNS prefetch hint.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iweb_disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'iweb_disable_emojis_tinymce' );
	add_filter( 'wp_resource_hints', 'iweb_disable_emojis_dns_prefetch', 10, 2 );
}
add_action( 'init', 'iweb_disable_emojis' );

/**
 * Remove the emoji plugin from the classic editor (TinyMCE).
 *
 * @since 1.0.0
 *
 * @param array $plugins TinyMCE plugins.
 * @return array Filtered list of TinyMCE plugins.
 */
function iweb_disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		$iweb_index = array_search( 'wpemoji', $plugins, true );

		if ( false !== $iweb_index ) {
			unset( $plugins[ $iweb_index ] );
		}
	}

	return $plugins;
}

/**
 * Remove the emoji DNS prefetch URL from the resource hints.
 *
 * @since 1.0.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 * @return array Filtered URLs.
 */
function iweb_disable_emojis_dns_prefetch( $urls, $relation_type ) {
	if ( 'dns-prefetch' !== $relation_type ) {
		return $urls;
	}

	$iweb_emoji_url = 'https://s.w.org/images/core/emoji/';

	foreach ( $urls as $iweb_key => $iweb_url ) {
		if ( false !== strpos( $iweb_url, $iweb_emoji_url ) ) {
			unset( $urls[ $iweb_key ] );
		}
	}

	return $urls;
}

/**
 * Clean up unnecessary items from the document head.
 *
 * Removes the RSD link, the WLW manifest link, the shortlink tag, the REST
 * API and oEmbed discovery links, and the WordPress version generator.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iweb_head_cleanup() {
	remove_action( 'wp_head', 'rsd_link' );                     // RSD link.
	remove_action( 'wp_head', 'wlwmanifest_link' );             // WLW manifest link.
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );         // Shortlink tag.
	remove_action( 'wp_head', 'rest_output_link_wp_head' );     // REST API discovery link.
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' ); // oEmbed discovery links.
	remove_action( 'wp_head', 'wp_generator' );                 // WordPress version generator.
}
add_action( 'init', 'iweb_head_cleanup' );