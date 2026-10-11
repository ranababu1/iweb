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

/**
 * Return an inline SVG icon.
 *
 * Icons are 24x24 line icons that inherit the current text color.
 *
 * @since 1.1.0
 *
 * @param string $name Icon name.
 * @return string SVG markup, or an empty string for an unknown icon.
 */
function iweb_icon( $name ) {
	$paths = array(
		'search'    => '<circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/>',
		'cursor'    => '<path d="M5 3l14 7-6 2-2 6z"/>',
		'gear'      => '<circle cx="12" cy="12" r="3"/><path d="M12 2v3M12 19v3M4.2 4.2l2.1 2.1M17.7 17.7l2.1 2.1M2 12h3M19 12h3M4.2 19.8l2.1-2.1M17.7 6.3l2.1-2.1"/>',
		'chart'     => '<path d="M4 20V10M10 20V4M16 20v-8M22 20H2"/>',
		'code'      => '<path d="m8 8-5 4 5 4M16 8l5 4-5 4M14 5l-4 14"/>',
		'clock'     => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
		'users'     => '<circle cx="9" cy="8" r="3.5"/><path d="M2.5 20c0-3.6 2.9-6 6.5-6s6.5 2.4 6.5 6M16 4.5a3.5 3.5 0 0 1 0 7M18 14.3c2 .7 3.5 2.6 3.5 5.7"/>',
		'globe'     => '<circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c3 3 3 15 0 18M12 3c-3 3-3 15 0 18"/>',
		'layers'    => '<path d="m12 3 9 5-9 5-9-5zM3 13l9 5 9-5"/>',
		'arrow'     => '<path d="M5 12h14M13 6l6 6-6 6"/>',
		'calendar'  => '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/>',
		'bulb'      => '<path d="M9 18h6M10 21h4M12 3a6 6 0 0 0-3.5 10.9c.6.5 1 1.2 1 2.1h5c0-.9.4-1.6 1-2.1A6 6 0 0 0 12 3z"/>',
		'doc'       => '<path d="M6 3h8l4 4v14H6zM14 3v4h4M9 12h6M9 16h6"/>',
		'sparkle'   => '<path d="M12 3c.7 4.5 2.5 6.3 7 7-4.5.7-6.3 2.5-7 7-.7-4.5-2.5-6.3-7-7 4.5-.7 6.3-2.5 7-7z"/>',
		'funnel'    => '<path d="M3 4h18l-7 8v7l-4 2v-9z"/>',
		'leaf'      => '<path d="M5 19C5 10 10 5 20 4c0 10-5 15-14 15zM5 19l8-8"/>',
		'megaphone' => '<path d="M3 10v4h4l9 5V5l-9 5zM19 9a4 4 0 0 1 0 6"/>',
		'check'     => '<path d="m5 12 5 5 9-10"/>',
		'plus'      => '<path d="M12 5v14M5 12h14"/>',
		'linkedin'  => '<rect x="3" y="3" width="18" height="18" rx="2"/><path d="M8 11v6M8 8v.01M12 17v-6M12 13c0-3 5-3 5 0v4"/>',
		'x'         => '<path d="M4 4l16 16M20 4 4 20"/>',
		'github'    => '<path d="M9 19c-4 1.5-4-2-6-2m12 4v-3.5c0-1 .1-1.4-.5-2 3-.3 6-1.500 6-6.500a5 5 0 0 0-1.400-3.500 4.700 4.700 0 0 0-.1-3.500s-1.100-.3-3.500 1.300a12 12 0 0 0-6.200 0C6.900 2.900 5.800 3.200 5.800 3.200a4.700 4.700 0 0 0-.1 3.500A5 5 0 0 0 4.300 10.200c0 5 3 6.200 6 6.500-.6.600-.6 1.200-.5 2V21"/>',
		'youtube'   => '<rect x="2.500" y="5" width="19" height="14" rx="4"/><path d="m10 9.500 5 2.500-5 2.500z"/>',
		'bolt'      => '<path d="M13 2 4 14h7l-1 8 9-12h-7z"/>',
		'shield'    => '<path d="M12 3 4 6v6c0 5 3.500 8 8 9 4.500-1 8-4 8-9V6z"/>',
		'puzzle'    => '<path d="M10 4a2 2 0 1 1 4 0v2h4v4h-2a2 2 0 1 0 0 4h2v4h-4v-2a2 2 0 1 0-4 0v2H6v-4h2a2 2 0 1 0 0-4H6V6h4z"/>',
		'chat'      => '<path d="M4 5h16v11H9l-5 4zM8 9h8M8 12h5"/>',
		'wordpress' => '<circle cx="12" cy="12" r="9"/><path d="M6 8l4 10 2.500-7M10 8h6M14.500 18 18 8"/>',
		'cart'      => '<path d="M3 4h2l2.500 11h10L20 7H6.500"/><circle cx="9" cy="19" r="1.300"/><circle cx="17" cy="19" r="1.300"/>',
		'gauge'     => '<path d="M4 17a9 9 0 1 1 16 0M12 13l4-5"/>',
		'user'      => '<circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.500 3.600-7 8-7s8 2.500 8 7z"/>',
		'chevron'   => '<path d="m9 6 6 6-6 6"/>',
		'tag'       => '<path d="M3 12V4h8l10 10-8 8zM7.500 8.500h.01"/>',
		'target'    => '<circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="5"/><circle cx="12" cy="12" r="1"/>',
		'rocket'    => '<path d="M5 19c0-3 1-4 3-5m-3 5c3 0 4-1 5-3M14 10l-4 4 2 2 4-4M20 4c-6 0-10 4-11 9l2 2c5-1 9-5 9-11z"/>',
		'database'  => '<ellipse cx="12" cy="6" rx="8" ry="3"/><path d="M4 6v12c0 1.700 3.600 3 8 3s8-1.300 8-3V6M4 12c0 1.700 3.600 3 8 3s8-1.300 8-3"/>',
		'cloud'     => '<path d="M7 18a4 4 0 0 1-.5-8 5.500 5.500 0 0 1 10.600 1A3.500 3.500 0 0 1 17 18z"/>',
		'trophy'    => '<path d="M8 4h8v6a4 4 0 0 1-8 0zM8 6H4c0 3 1.500 4 4 4M16 6h4c0 3-1.500 4-4 4M12 14v4M8 21h8M9 18h6"/>',
		'mail'      => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/>',
		'clip'      => '<path d="m20 11-8.500 8.500a5 5 0 0 1-7-7L13 4a3.500 3.500 0 0 1 5 5l-8.500 8.500a2 2 0 0 1-3-3L14 7"/>',
		'facebook'  => '<path d="M14 8h3V4h-3a4 4 0 0 0-4 4v3H7v4h3v6h4v-6h3l1-4h-4V8z"/>',
		'link'      => '<path d="M10 14a4 4 0 0 0 5.700 0l3-3a4 4 0 0 0-5.700-5.700l-1 1M14 10a4 4 0 0 0-5.700 0l-3 3a4 4 0 0 0 5.700 5.700l1-1"/>',
		'folder'    => '<path d="M3 6h6l2 2h10v11H3z"/>',
		'copy'      => '<rect x="8" y="8" width="12" height="12" rx="2"/><path d="M16 8V5a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h3"/>',
		'coins'     => '<ellipse cx="12" cy="6" rx="7" ry="3"/><path d="M5 6v6c0 1.700 3.100 3 7 3s7-1.300 7-3V6M5 12v6c0 1.700 3.100 3 7 3s7-1.300 7-3v-6"/>',
		'headset'   => '<path d="M4 14v-2a8 8 0 0 1 16 0v2M4 14h3v5H4zM17 14h3v5h-3zM20 19c0 2-2 3-5 3"/>',
		'book'      => '<path d="M3 5c3-1 6-1 9 1 3-2 6-2 9-1v14c-3-1-6-1-9 1-3-2-6-2-9-1z"/><path d="M12 6v14"/>',
		'question'  => '<circle cx="12" cy="12" r="9"/><path d="M9.500 9.500a2.500 2.500 0 1 1 3.500 2.300c-.7.400-1 1-1 1.700M12 17v.01"/>',
		'image'     => '<rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="9" cy="10" r="1.500"/><path d="m4 18 5-5 4 4 3-3 4 4"/>',
	);

	if ( ! isset( $paths[ $name ] ) ) {
		return '';
	}

	return '<svg class="icon icon-' . esc_attr( $name ) . '" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $paths[ $name ] . '</svg>';
}

/**
 * Default primary navigation, used until a menu is assigned.
 *
 * @since 1.1.0
 *
 * @return void
 */
function iweb_fallback_menu() {
	$items = array(
		__( 'Services', 'iweb' )     => home_url( '/#services' ),
		__( 'How we work', 'iweb' )  => home_url( '/#process' ),
		__( 'Work', 'iweb' )         => home_url( '/work/' ),
		__( 'Insights', 'iweb' )     => home_url( '/blog/' ),
		__( 'About', 'iweb' )        => home_url( '/about/' ),
	);

	echo '<ul class="nav-menu">';
	foreach ( $items as $label => $url ) {
		printf( '<li><a href="%s">%s</a></li>', esc_url( $url ), esc_html( $label ) );
	}
	echo '</ul>';
}

/**
 * Whether the current view is a full-width marketing template.
 *
 * @since 1.1.0
 *
 * @return bool
 */
function iweb_is_marketing_view() {
	return is_page_template( array( 'page-templates/home.php', 'page-templates/service-get-found.php', 'page-templates/service-automate.php', 'page-templates/service-convert.php', 'page-templates/services.php', 'page-templates/service-analytics.php', 'page-templates/how-we-work.php', 'page-templates/our-work.php', 'page-templates/about.php', 'page-templates/start-project.php', 'page-templates/faq.php' ) );
}

/**
 * Add a body class for full-width marketing templates.
 *
 * @since 1.1.0
 *
 * @param string[] $classes Body classes.
 * @return string[]
 */
function iweb_marketing_body_class( $classes ) {
	if ( iweb_is_marketing_view() || is_singular( 'case_study' ) || iweb_is_blog_view() ) {
		$classes[] = 'is-marketing';
	}

	return $classes;
}
add_filter( 'body_class', 'iweb_marketing_body_class' );

/**
 * The text wordmark: a green "i" followed by the rest of the name.
 *
 * @since 1.1.0
 *
 * @return string Markup using span.logo-i; pass through wp_kses().
 */
function iweb_wordmark() {
	return '<span class="logo-i">i</span>WebAndSEO';
}
