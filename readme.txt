=== iweb ===
Contributors: iweb
Requires at least: 6.3
Tested up to: 6.8
Requires PHP: 7.4
Stable tag: 1.0.0
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A minimal, design-agnostic classic WordPress starter theme.

== Description ==

iweb is a classic (PHP template) WordPress starter theme built to be replaced: it ships all the required WordPress plumbing, semantic templates, accessible navigation, and a deliberately basic, token-based stylesheet, so you can drop your own HTML and CSS on top of it.

Features:

* Classic PHP templates; no block theme features and no theme.json required.
* Classic editor: the block (Gutenberg) editor and the block-based widgets screen are disabled, and the block library styles are removed from the frontend (see inc/classic-editor.php).
* Accessible mobile navigation with keyboard support (toggle, dropdowns, focus trap, Escape to close) and a no-JavaScript fallback that stays visible and expanded.
* One global stylesheet (style.css) plus conditional view-specific stylesheets loaded from assets/css/.
* Customizer options for the footer copyright text, social profile URLs, and the sidebar on archives.
* Three menu locations (primary, footer, social) and four widget areas (sidebar, footer 1-3).
* Translation ready; text domain: iweb.

== Installation ==

1. In your administration panel, go to Appearance -> Themes and click the Add New button.
2. Click Upload Theme and Choose File, then select the iweb theme archive. Click Install Now.
3. Click Activate to use the theme right away.

== Frequently Asked Questions ==

= Where do I change the styles? =

All global styles live in style.css, below the theme header. Design tokens are defined as CSS custom properties on :root. View-specific styles live in assets/css/ (for example assets/css/blog.css, which loads on blog, archive, search, and single post views).

= How do I add another conditional stylesheet? =

Add one entry to the array returned by iweb_conditional_stylesheets() in inc/enqueue.php (an optional `script` key loads a matching JS file, as home.css/home.js and service.css/service.js do), or filter `iweb_conditional_stylesheets` from a child theme.

= How do I show the sidebar? =

Add widgets to the "Sidebar" widget area, then enable "Show the sidebar on archives" under Appearance -> Customize -> Theme Options -> Layout.

= Does the theme require any plugins? =

No. The theme includes no plugin-territory features such as custom post types, shortcodes, SEO, or analytics code.

= Why is the block (Gutenberg) editor disabled? =

The theme is built for the classic editor: posts and pages use the classic editor, the Widgets screen is the classic one, and the block library and global styles are removed from the frontend. This lives in inc/classic-editor.php. To switch back to the block editor, remove the require line for that file in functions.php.

== Changelog ==

= 1.0.0 =
* Initial release.

== Credits ==

* None. The theme uses only WordPress core APIs; no third-party resources, libraries, or frameworks are bundled.

== License ==

iweb is licensed under the GNU General Public License v2 or later.

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.