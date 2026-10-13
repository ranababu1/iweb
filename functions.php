<?php
/**
 * iweb functions and definitions.
 *
 * This file only defines the theme version constant and loads the files in
 * the /inc/ directory. All theme logic lives in those files.
 *
 * @package iweb
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! defined( 'IWEB_VERSION' ) ) {
	define( 'IWEB_VERSION', '1.0.0' );
}

require_once get_template_directory() . '/inc/theme-setup.php';
require_once get_template_directory() . '/inc/enqueue.php';
require_once get_template_directory() . '/inc/template-tags.php';
require_once get_template_directory() . '/inc/template-functions.php';
require_once get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/classic-editor.php';
require_once get_template_directory() . '/inc/case-studies.php';
require_once get_template_directory() . '/inc/contact-form.php';

require_once get_template_directory() . '/inc/blog.php';
require_once get_template_directory() . '/inc/seo-fallback.php';
require_once get_template_directory() . '/inc/nav-data.php';
require_once get_template_directory() . '/inc/seo-extra.php';
