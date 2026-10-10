<?php
/**
 * Theme setup for the iweb theme.
 *
 * Theme supports, navigation menus, widget areas, content width, and the
 * text domain are registered here.
 *
 * @package iweb
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Set up the theme defaults and register support for various WordPress features.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iweb_setup() {
	/*
	 * Make the theme available for translation. Translations can be added to
	 * the /languages/ directory.
	 */
	load_theme_textdomain( 'iweb', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// Enable featured images.
	add_theme_support( 'post-thumbnails' );

	// Switch core markup to valid HTML5 for the listed outputs.
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Add theme support for a custom logo.
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 240,
			'width'       => 240,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	// Support responsive embedded content (videos, embeds).
	add_theme_support( 'responsive-embeds' );

	// Support wide and full alignment classes.
	add_theme_support( 'align-wide' );

	// Load editor styles in the block editor.
	add_theme_support( 'editor-styles' );

	// Output default block styles on the frontend.
	add_theme_support( 'wp-block-styles' );

	// Enable selective refresh for widgets in the Customizer.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add the block editor stylesheet.
	add_editor_style( 'assets/css/editor.css' );

	// Register the navigation menu locations.
	register_nav_menus(
		array(
			'primary' => __( 'Primary', 'iweb' ),
			'footer'  => __( 'Footer', 'iweb' ),
			'social'  => __( 'Social', 'iweb' ),
		)
	);
}
add_action( 'after_setup_theme', 'iweb_setup' );

/**
 * Register the widget areas.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iweb_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Sidebar', 'iweb' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Displayed in the sidebar on the blog page, archives, and search results when the sidebar is enabled in the Customizer.', 'iweb' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	for ( $iweb_i = 1; $iweb_i <= 3; $iweb_i++ ) {
		register_sidebar(
			array(
				/* translators: %d: footer widget area number. */
				'name'          => sprintf( __( 'Footer %d', 'iweb' ), $iweb_i ),
				'id'            => 'footer-' . $iweb_i,
				'description'   => __( 'Displayed in the footer widget grid.', 'iweb' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			)
		);
	}
}
add_action( 'widgets_init', 'iweb_widgets_init' );

/**
 * Set the global content width.
 *
 * This variable is used by WordPress to size uploaded images and oEmbeds.
 * It defaults to 800 pixels and can be filtered with `iweb_content_width`.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iweb_content_width() {
	$GLOBALS['content_width'] = (int) apply_filters( 'iweb_content_width', 800 );
}
add_action( 'after_setup_theme', 'iweb_content_width', 0 );