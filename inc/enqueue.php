<?php
/**
 * Scripts and styles for the iweb theme.
 *
 * style.css is the only stylesheet loaded globally. Stylesheets inside
 * assets/css/ are loaded conditionally through the map returned by
 * iweb_conditional_stylesheets().
 *
 * @package iweb
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Enqueue the global stylesheet and scripts on the frontend.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iweb_scripts() {
	// The only stylesheet loaded on every page.
	$iweb_style_version = filemtime( get_stylesheet_directory() . '/style.css' );

	if ( false === $iweb_style_version ) {
		$iweb_style_version = IWEB_VERSION;
	}

	wp_enqueue_style( 'iweb-style', get_stylesheet_uri(), array(), $iweb_style_version );

	// Global scripts, loaded deferred in the footer.
	wp_enqueue_script(
		'iweb-main',
		get_template_directory_uri() . '/assets/js/main.js',
		array(),
		iweb_asset_version( 'assets/js/main.js' ),
		array(
			'strategy'   => 'defer',
			'in_footer' => true,
		)
	);

	wp_enqueue_script(
		'iweb-navigation',
		get_template_directory_uri() . '/assets/js/navigation.js',
		array(),
		iweb_asset_version( 'assets/js/navigation.js' ),
		array(
			'strategy'   => 'defer',
			'in_footer' => true,
		)
	);

	// Translatable strings used by navigation.js.
	wp_localize_script(
		'iweb-navigation',
		'iwebNav',
		array(
			'openLabel'  => esc_html__( 'Menu', 'iweb' ),
			'closeLabel' => esc_html__( 'Close menu', 'iweb' ),
		)
	);

	// Conditionally load the view-specific stylesheets.
	$iweb_stylesheets = iweb_conditional_stylesheets();

	foreach ( $iweb_stylesheets as $iweb_handle => $iweb_stylesheet ) {
		if ( is_callable( $iweb_stylesheet['conditional'] ) && call_user_func( $iweb_stylesheet['conditional'] ) ) {
			wp_enqueue_style(
				$iweb_handle,
				get_template_directory_uri() . '/' . $iweb_stylesheet['file'],
				array( 'iweb-style' ),
				iweb_asset_version( $iweb_stylesheet['file'] )
			);

			// Optional script that travels with the stylesheet.
			if ( ! empty( $iweb_stylesheet['script'] ) ) {
				wp_enqueue_script(
					$iweb_handle,
					get_template_directory_uri() . '/' . $iweb_stylesheet['script'],
					array(),
					iweb_asset_version( $iweb_stylesheet['script'] ),
					array(
						'strategy'  => 'defer',
						'in_footer' => true,
					)
				);
			}
		}
	}

	// Threaded comments.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'iweb_scripts' );

/**
 * Map conditional callbacks to the stylesheets they unlock.
 *
 * Each entry maps a stylesheet to a callback that is evaluated on every
 * request. To add another view-specific stylesheet, add one entry to this
 * array (or filter it from a child theme); nothing else needs to change.
 * Stylesheets here always load after the global stylesheet.
 *
 * @since 1.0.0
 *
 * @return array<string, array{conditional: callable, file: string, script?: string}>
 */
function iweb_conditional_stylesheets() {
	return apply_filters(
		'iweb_conditional_stylesheets',
		array(
			'iweb-blog' => array(
				'conditional' => 'iweb_is_blog_view',
				'file'       => 'assets/css/blog.css',
			),
			'iweb-home' => array(
				'conditional' => 'is_front_page',
				'file'       => 'assets/css/home.css',
				'script'     => 'assets/js/home.js',
			),
			'iweb-service' => array(
				'conditional' => 'iweb_is_service_view',
				'file'       => 'assets/css/service.css',
				'script'     => 'assets/js/service.js',
			),
		)
	);
}

/**
 * Check whether the current view is a blog view.
 *
 * blog.css loads on the blog page, archives, search results, and single
 * posts.
 *
 * @since 1.0.0
 *
 * @return bool True when the current view needs blog styles.
 */
function iweb_is_blog_view() {
	return is_home() || is_archive() || is_search() || is_singular( 'post' );
}

/**
 * Check whether the current view uses the service page template.
 *
 * @since 1.1.0
 *
 * @return bool True on pages using the Service template.
 */
function iweb_is_service_view() {
	return is_page_template( 'page-templates/service-get-found.php' );
}

/**
 * Build a cache-busting version for an asset from its modification time.
 *
 * Falls back to the theme version when the file is not readable.
 *
 * @since 1.0.0
 *
 * @param string $file Path of the asset, relative to the theme directory.
 * @return string|int The file modification time or the theme version.
 */
function iweb_asset_version( $file ) {
	$iweb_path    = get_template_directory() . '/' . $file;
	$iweb_version = file_exists( $iweb_path ) ? filemtime( $iweb_path ) : false;

	if ( false === $iweb_version ) {
		$iweb_version = IWEB_VERSION;
	}

	return $iweb_version;
}

/*
 * Admin styles are intentionally not loaded: this theme ships nothing that
 * needs styling in wp-admin. If you add an assets/css/admin.css file,
 * enqueue it here with an `admin_enqueue_scripts` hook:
 *
 * function iweb_admin_scripts() {
 *     wp_enqueue_style( 'iweb-admin', get_template_directory_uri() . '/assets/css/admin.css', array(), iweb_asset_version( 'assets/css/admin.css' ) );
 * }
 * add_action( 'admin_enqueue_scripts', 'iweb_admin_scripts' );
 */