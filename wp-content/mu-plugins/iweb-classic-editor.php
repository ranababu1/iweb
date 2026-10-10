<?php
/**
 * Plugin Name: iweb Classic Editor
 * Description: Replaces the block (Gutenberg) editor with the classic editor for all post types, restores the classic widgets screen, and removes the block editor frontend bloat: block library CSS, global styles, duotone SVG filters, and core block patterns.
 * Version: 1.0.0
 * Author: iweb
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Must-use plugin: loaded automatically on every request and cannot be
 * deactivated from the admin. Delete this file (or remove it from the
 * repository) to switch back to the block editor.
 *
 * @package iweb
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/*
 * 1. Classic editor everywhere.
 *
 * WordPress ships the classic (TinyMCE) editor as its fallback, so turning
 * the block editor off is all that is needed to restore the classic
 * post, page, and CPT editing screens.
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

/*
 * 3. Remove the block editor frontend bloat.
 */

/**
 * Dequeue the block library, global styles, and theme-bridge stylesheets.
 *
 * Runs late on the `wp_enqueue_scripts` hook so everything the block
 * system enqueued at the default priority is removed again.
 *
 * Note: if any existing posts or pages still contain blocks, they lose the
 * core block CSS once these stylesheets are removed. Convert such content
 * to classic HTML, or drop these dequeues.
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

// Do not print the global-styles duotone SVG filter definitions.
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