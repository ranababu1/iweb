<?php
/**
 * Extra SEO and performance tweaks found in the sitewide audit.
 *
 * @package iweb
 */

/**
 * Keep author and date archives out of the index. The site has one author,
 * so these pages only repeat the blog listing.
 *
 * @param string $robots Robots value.
 * @return string
 */
function iweb_noindex_thin_archives( $robots ) {
	if ( is_author() || is_date() || is_tag() || is_search() ) {
		return 'noindex, follow';
	}
	return $robots;
}
add_filter( 'wpseo_robots', 'iweb_noindex_thin_archives', 20 );

/* Drop the author sitemap that only lists the single author archive. */
add_filter( 'wpseo_sitemap_exclude_author', '__return_empty_array' );

/**
 * Meta descriptions for category archives.
 *
 * @param string $desc Description.
 * @return string
 */
function iweb_category_metadesc( $desc ) {
	if ( ! is_category() ) {
		return $desc;
	}
	$map  = array(
		'ai-automation'          => 'Guides on putting AI to work in a business: chatbots, AI search, content tools and practical ways to save time and cost.',
		'analytics-reporting'    => 'Articles on GA4, Tag Manager, conversion tracking and reporting, so you can see which pages and campaigns bring in leads.',
		'automation-integrations' => 'How to connect your apps and automate repetitive work, from forms and CRMs to Zapier style workflows and custom integrations.',
		'cro-ux'                 => 'Practical advice on conversion rate optimization and UX: forms, landing pages, testing and turning more visitors into customers.',
		'ecommerce'              => 'Guides for online stores: product pages, checkout, payments, shipping and the setup that helps an ecommerce site sell more.',
		'net-development'        => 'Articles on .NET and ASP.NET Core development, APIs, performance and moving older applications to modern .NET.',
		'performance-security'   => 'How to keep a website fast and secure: caching, Core Web Vitals, SSL, backups, firewalls and hardening.',
		'seo'                    => 'Search guides covering technical SEO, content, local search and showing up in AI answers, written in plain language.',
		'web-development'        => 'Web and API development articles: building sites and apps, front end basics, APIs, hosting and choosing the right stack.',
		'wordpress'              => 'WordPress guides for business owners and developers: themes, plugins, speed, security, maintenance and custom builds.',
	);
	$term = get_queried_object();
	if ( $term && isset( $map[ $term->slug ] ) ) {
		return $map[ $term->slug ];
	}
	if ( '' === trim( (string) $desc ) && $term ) {
		return wp_strip_all_tags( term_description( $term ) ) ?: sprintf( 'Articles from IWS about %s.', $term->name );
	}
	return $desc;
}
add_filter( 'wpseo_metadesc', 'iweb_category_metadesc', 30 );
add_filter( 'wpseo_opengraph_desc', 'iweb_category_metadesc', 30 );

/**
 * Default social image when a page has no image of its own.
 *
 * @param object $container Yoast image container.
 * @return void
 */
function iweb_default_og_image( $container ) {
	if ( is_object( $container ) && method_exists( $container, 'has_images' ) && ! $container->has_images() ) {
		$container->add_image(
			array(
				'url'    => get_template_directory_uri() . '/assets/images/og-default.jpg',
				'width'  => 1200,
				'height' => 630,
				'type'   => 'image/jpeg',
			)
		);
	}
}
add_action( 'wpseo_add_opengraph_additional_images', 'iweb_default_og_image' );

/**
 * Favicon links when no Site Icon is set in the Customizer.
 *
 * @return void
 */
function iweb_favicon_links() {
	if ( has_site_icon() ) {
		return;
	}
	$base = get_template_directory_uri() . '/assets/images/';
	echo '<link rel="icon" href="' . esc_url( $base . 'icon-32.png' ) . '" sizes="32x32">' . "\n";
	echo '<link rel="icon" href="' . esc_url( $base . 'icon-512.png' ) . '" sizes="512x512">' . "\n";
	echo '<link rel="apple-touch-icon" href="' . esc_url( $base . 'icon-180.png' ) . '">' . "\n";
}
add_action( 'wp_head', 'iweb_favicon_links', 2 );

/**
 * Serve /favicon.ico from the theme instead of a 404.
 *
 * @return void
 */
function iweb_favicon_ico() {
	if ( has_site_icon() ) {
		return;
	}
	wp_safe_redirect( get_template_directory_uri() . '/assets/images/favicon.ico', 301 );
	exit;
}
add_action( 'do_faviconico', 'iweb_favicon_ico', 5 );

/**
 * Load Google Fonts without blocking the first paint.
 *
 * @param string $tag    Link tag.
 * @param string $handle Handle.
 * @return string
 */
function iweb_async_fonts( $tag, $handle ) {
	if ( 'iweb-fonts' !== $handle ) {
		return $tag;
	}
	$async = str_replace( "media='all'", "media='print' onload=\"this.media='all'\"", $tag );
	return $async . '<noscript>' . $tag . '</noscript>' . "\n";
}
add_filter( 'style_loader_tag', 'iweb_async_fonts', 10, 2 );
