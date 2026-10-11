<?php
/**
 * Classic editor support for the iweb theme.
 *
 * The theme is built for the classic editor. This file turns the block
 * (Gutenberg) editor off for all post types, restores the classic widgets
 * screen, and removes the block editor frontend bloat: the block library
 * stylesheets, global styles, the duotone SVG filters, and the core block
 * patterns.
 *
 * To switch back to the block editor, remove the require line for this
 * file in functions.php.
 *
 * @package iweb
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/*
 * 1. Classic editor everywhere.
 *
 * WordPress ships the classic (TinyMCE) editor as its fallback, so turning
 * the block editor off is all that is needed to restore the classic post,
 * page, and custom post type editing screens.
 */
add_filter( 'use_block_editor_for_post_type', '__return_false', 100 );
add_filter( 'use_block_editor_for_post', '__return_false', 100 );

/*
 * 2. Classic widgets.
 *
 * Restores the classic Widgets screen under Appearance and the classic
 * widget controls in the Customizer instead of the block-based editor.
 */
add_filter( 'gutenberg_use_widgets_block_editor', '__return_false', 100 );
add_filter( 'use_widgets_block_editor', '__return_false', 100 );

/**
 * Remove the block editor stylesheets from the frontend.
 *
 * Runs late on the `wp_enqueue_scripts` hook so everything the block
 * system enqueued at the default priority is dequeued again.
 *
 * Note: if any existing posts or pages still contain blocks, they lose
 * the core block CSS once these stylesheets are removed. Convert such
 * content to classic HTML, or remove this function.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iweb_dequeue_block_styles() {
	wp_dequeue_style( 'wp-block-library' );        // Core block CSS.
	wp_dequeue_style( 'wp-block-library-theme' ); // Block/theme bridge CSS.
	wp_dequeue_style( 'classic-theme-styles' );   // Layout (container) CSS.
	wp_dequeue_style( 'global-styles' );          // theme.json/global styles CSS.
}
add_action( 'wp_enqueue_scripts', 'iweb_dequeue_block_styles', 100 );

// Do not print the global styles duotone SVG filter definitions.
remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );

/**
 * Stop WordPress from registering the block patterns it ships with.
 *
 * Runs after the theme has set up its supports, and before core registers
 * its patterns on `init`.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iweb_remove_core_block_patterns() {
	remove_theme_support( 'core-block-patterns' );
}
add_action( 'after_setup_theme', 'iweb_remove_core_block_patterns', 100 );