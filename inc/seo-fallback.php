<?php
/**
 * Fallback SEO titles and meta descriptions for the core pages.
 *
 * Only runs when no SEO plugin (Yoast, Rank Math, AIOSEO, SEOPress) is active,
 * so an SEO plugin always takes over once it is switched on.
 *
 * @package iweb
 */

/**
 * Whether a dedicated SEO plugin is active.
 *
 * @return bool
 */
function iweb_seo_plugin_active() {
	return defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' ) || defined( 'SEOPRESS_VERSION' );
}

/**
 * Title and description for the current view, keyed by page slug.
 *
 * @return array{0:string,1:string}|null
 */
function iweb_seo_fallback_meta() {
	$map = array(
		'home'                          => array( 'iWebAndSEO | WordPress, SEO and AI Automation for Growing Businesses', 'We build fast WordPress sites, get them found on Google and AI search, turn visitors into customers and automate the busywork. Start with a free audit call.' ),
		'services'                      => array( 'Services: WordPress, SEO, CRO, Automation and Analytics | iWebAndSEO', 'Four ways we help you grow: get found on Google and AI search, turn visitors into customers, automate the busywork and know what\'s working. Plus custom .NET builds.' ),
		'get-found'                     => array( 'SEO, AEO and GEO Services: Get Found on Google and AI | iWebAndSEO', 'Technical SEO, content, answer engine optimization and AI search visibility for growing businesses. Show up on Google, in AI answers and in paid search.' ),
		'turn-visitors-into-customers'  => array( 'WordPress and WooCommerce Development, Speed and CRO | iWebAndSEO', 'Fast WordPress and WooCommerce sites built to convert. Custom design, site speed optimization, UX and conversion rate optimization for growing businesses.' ),
		'automate-the-busy-work'        => array( 'AI Chatbots, Workflow Automation and AI Integration | iWebAndSEO', 'Practical AI for small and mid-size businesses. Website chatbots, workflow automation and AI integrations that cut repetitive work and respond to leads faster.' ),
		'know-whats-working'            => array( 'GA4, Tag Manager and Conversion Tracking Setup | iWebAndSEO', 'Accurate GA4, Google Tag Manager and conversion tracking, plus clear dashboards and reports. Know which pages, channels and campaigns bring in leads and sales.' ),
		'contact'                       => array( 'Start a Project | iWebAndSEO', 'Tell us about your website, SEO, AI automation or development project. We\'ll reply with next steps and a time for a free audit call.' ),
		'about'                         => array( 'About Us | iWebAndSEO', 'iWebAndSEO helps businesses grow with fast WordPress sites, SEO, AI automation and custom development. Learn who we are and how we approach the work.' ),
		'how-we-work'                   => array( 'How We Work: Our Process from Plan to Launch | iWebAndSEO', 'A clear, simple process: we plan, build, review and launch with you, then keep improving. See what to expect at each step of a project.' ),
		'our-work'                      => array( 'Our Work | iWebAndSEO', 'WordPress builds, SEO and automation projects from iWebAndSEO. See the kind of work we do and the problems we help businesses solve.' ),
		'faq'                           => array( 'FAQs | iWebAndSEO', 'Answers to common questions about our WordPress, SEO, AI automation and analytics services, pricing, timelines and support.' ),
	);

	if ( is_home() && ! is_front_page() ) {
		return array( 'Insights: WordPress, SEO and AI Automation Tips | iWebAndSEO', 'Practical guides on WordPress, SEO, AI search, conversion and automation. Plain advice you can use to grow your business online.' );
	}

	if ( is_front_page() ) {
		return $map['home'];
	}

	if ( is_page() ) {
		$slug = get_post_field( 'post_name', get_queried_object_id() );
		return isset( $map[ $slug ] ) ? $map[ $slug ] : null;
	}

	return null;
}

/**
 * Override the document title for mapped pages.
 *
 * @param string $title Title.
 * @return string
 */
function iweb_seo_fallback_title( $title ) {
	if ( iweb_seo_plugin_active() ) {
		return $title;
	}
	$meta = iweb_seo_fallback_meta();
	return $meta ? $meta[0] : $title;
}
add_filter( 'pre_get_document_title', 'iweb_seo_fallback_title', 20 );

/**
 * Print the meta description for mapped pages, or an excerpt on single posts.
 *
 * @return void
 */
function iweb_seo_fallback_description() {
	if ( iweb_seo_plugin_active() ) {
		return;
	}
	$meta = iweb_seo_fallback_meta();
	$desc = $meta ? $meta[1] : '';

	if ( ! $desc && is_singular( 'post' ) ) {
		$desc = wp_trim_words( wp_strip_all_tags( get_the_excerpt( get_queried_object_id() ) ), 28, '' );
	}

	if ( $desc ) {
		printf( '<meta name="description" content="%s">' . "\n", esc_attr( $desc ) );
	}
}
add_action( 'wp_head', 'iweb_seo_fallback_description', 1 );
