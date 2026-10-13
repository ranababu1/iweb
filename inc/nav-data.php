<?php
/**
 * Service data used by the header mega menu and the mobile menu.
 *
 * @package iweb
 */

/**
 * Returns the service categories shown in the header.
 *
 * @return array
 */
function iweb_nav_services() {
	$hub = function ( $slug ) {
		return home_url( '/services/' . $slug );
	};
	return array(
		array(
			'key'   => 'ai',
			'label' => __( 'AI & Automation', 'iweb' ),
			'icon'  => 'sparkle',
			'url'   => $hub( 'automate-the-busy-work' ),
			'title' => __( 'Put AI to work in your business.', 'iweb' ),
			'copy'  => __( 'Chatbots and automated workflows that take repetitive tasks off your team.', 'iweb' ),
			'card'  => 'bolt',
			'items' => array( 'AI Chatbots', 'Workflow Automation', 'AI Integrations', 'Custom AI Solutions' ),
		),
		array(
			'key'   => 'web',
			'label' => __( 'Website & CRO', 'iweb' ),
			'icon'  => 'funnel',
			'url'   => $hub( 'turn-visitors-into-customers' ),
			'title' => __( 'Turn visitors into customers.', 'iweb' ),
			'copy'  => __( 'Fast, clear websites and stores that turn more visits into sales.', 'iweb' ),
			'card'  => 'target',
			'items' => array( 'WordPress Development', 'WooCommerce', 'Site Speed', 'UX and UI Design', 'Conversion Optimization' ),
		),
		array(
			'key'   => 'dev',
			'label' => __( 'Enterprise Solutions', 'iweb' ),
			'icon'  => 'code',
			'url'   => $hub( 'custom-development' ),
			'title' => __( 'Software built around your business.', 'iweb' ),
			'copy'  => __( 'Custom builds in .NET and Java, plus APIs that connect the systems you already use.', 'iweb' ),
			'card'  => 'puzzle',
			'items' => array( '.NET Development', 'Java Development', 'API Development', 'Systems Integration', 'App Modernization', 'Custom Builds' ),
		),
		array(
			'key'   => 'analytics',
			'label' => __( 'Analytics & Tracking', 'iweb' ),
			'icon'  => 'chart',
			'url'   => $hub( 'know-whats-working' ),
			'title' => __( 'Know what is working.', 'iweb' ),
			'copy'  => __( 'Clean tracking and clear reports so every decision has data behind it.', 'iweb' ),
			'card'  => 'gauge',
			'items' => array( 'GA4 Setup', 'Google Tag Manager', 'Conversion Tracking', 'Custom Dashboards', 'Data and Reporting' ),
		),
		array(
			'key'   => 'seo',
			'label' => __( 'GEO / AEO / SEO', 'iweb' ),
			'icon'  => 'search',
			'url'   => $hub( 'get-found' ),
			'title' => __( 'Get found in AI answers and search.', 'iweb' ),
			'copy'  => __( 'Help ChatGPT, Google AI answers and regular search pick your business when buyers ask.', 'iweb' ),
			'card'  => 'leaf',
			'items' => array( 'SEO Services', 'Technical SEO', 'AEO and GEO (AI search)', 'Content and Blogging', 'Paid Ads (PPC)', 'SEO Consulting' ),
		),
	);
}

/**
 * Top level links shown after Services.
 *
 * @return array
 */
function iweb_nav_links() {
	return array(
		__( 'How we work', 'iweb' ) => home_url( '/how-we-work' ),
		__( 'Work', 'iweb' )        => home_url( '/our-work' ),
		__( 'Insights', 'iweb' )    => home_url( '/blog' ),
		__( 'About', 'iweb' )       => home_url( '/about' ),
		__( 'FAQs', 'iweb' )        => home_url( '/faq' ),
	);
}

/**
 * Sends /services/seo/ to the SEO hub instead of an old attachment.
 */
function iweb_seo_alias_redirect() {
	$path = trim( (string) wp_parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH ), '/' ); // phpcs:ignore
	if ( 'services/seo' === $path ) {
		wp_safe_redirect( home_url( '/services/get-found' ), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'iweb_seo_alias_redirect', 0 );
