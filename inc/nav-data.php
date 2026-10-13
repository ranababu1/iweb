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
		return home_url( '/services/' . $slug . '/' );
	};
	return array(
		array(
			'key'   => 'seo',
			'label' => __( 'SEO', 'iweb' ),
			'icon'  => 'search',
			'url'   => $hub( 'get-found' ),
			'title' => __( 'Get found. Get results.', 'iweb' ),
			'copy'  => __( 'Practical SEO that grows your visibility, traffic and leads.', 'iweb' ),
			'card'  => 'leaf',
			'items' => array( 'SEO Services', 'Technical SEO', 'AEO and GEO (AI search)', 'Content and Blogging', 'Paid Ads (PPC)', 'SEO Consulting' ),
		),
		array(
			'key'   => 'ai',
			'label' => __( 'AI & Automation', 'iweb' ),
			'icon'  => 'sparkle',
			'url'   => $hub( 'automate-the-busy-work' ),
			'title' => __( 'Automate the busy work.', 'iweb' ),
			'copy'  => __( 'Chatbots, workflows and AI tools that save your team hours each week.', 'iweb' ),
			'card'  => 'bolt',
			'items' => array( 'AI Chatbots', 'Workflow Automation', 'AI Integrations', 'Custom AI Solutions' ),
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
			'key'   => 'web',
			'label' => __( 'Website & CRO', 'iweb' ),
			'icon'  => 'funnel',
			'url'   => $hub( 'turn-visitors-into-customers' ),
			'title' => __( 'Turn visitors into customers.', 'iweb' ),
			'copy'  => __( 'Fast, well designed websites built to convert more of your traffic.', 'iweb' ),
			'card'  => 'target',
			'items' => array( 'WordPress Development', 'WooCommerce', 'Site Speed', 'UX and UI Design', 'Conversion Optimization' ),
		),
		array(
			'key'   => 'dev',
			'label' => __( 'Custom Development', 'iweb' ),
			'icon'  => 'code',
			'url'   => $hub( 'custom-development' ),
			'title' => __( 'Built for how you work.', 'iweb' ),
			'copy'  => __( 'Custom apps, APIs and integrations when an off the shelf tool falls short.', 'iweb' ),
			'card'  => 'puzzle',
			'items' => array( '.NET Development', 'Java Development', 'API Development', 'Systems Integration', 'App Modernization' ),
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
		__( 'How we work', 'iweb' ) => home_url( '/how-we-work/' ),
		__( 'Work', 'iweb' )        => home_url( '/our-work/' ),
		__( 'Insights', 'iweb' )    => home_url( '/blog/' ),
		__( 'About', 'iweb' )       => home_url( '/about/' ),
		__( 'FAQs', 'iweb' )        => home_url( '/faq/' ),
	);
}

/**
 * Sends /services/seo/ to the SEO hub instead of an old attachment.
 */
function iweb_seo_alias_redirect() {
	$path = trim( (string) wp_parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH ), '/' ); // phpcs:ignore
	if ( 'services/seo' === $path ) {
		wp_safe_redirect( home_url( '/services/get-found/' ), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'iweb_seo_alias_redirect', 0 );
