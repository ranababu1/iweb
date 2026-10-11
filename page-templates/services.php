<?php
/**
 * Template Name: Services
 * Template Post Type: page
 *
 * All copy for the services overview page lives in this file. Styling lives
 * in assets/css/services.css, loaded only for this template.
 *
 * @package iweb
 * @since 1.4.0
 */

$iweb_contact_url = home_url( '/contact/' );

$iweb_cards = array(
	array(
		'tone'  => 'green',
		'icon'  => 'search',
		'title' => __( 'Get found', 'iweb' ),
		'sub'   => __( 'SEO, AEO, GEO and paid ads.', 'iweb' ),
		'text'  => __( 'Show up on Google and in AI search. Drive the right traffic with technical SEO, content and paid campaigns.', 'iweb' ),
		'items' => array( __( 'Technical SEO', 'iweb' ), __( 'Content & AEO / GEO', 'iweb' ), __( 'Paid ads (PPC)', 'iweb' ), __( 'Local SEO', 'iweb' ) ),
		'cta'   => __( 'Explore Get found', 'iweb' ),
		'url'   => home_url( '/services/get-found/' ),
	),
	array(
		'tone'  => 'orange',
		'icon'  => 'chart',
		'title' => __( 'Turn visitors into customers', 'iweb' ),
		'sub'   => __( 'WordPress, speed, UX and CRO.', 'iweb' ),
		'text'  => __( 'Fast, conversion-focused websites that turn traffic into leads and revenue.', 'iweb' ),
		'items' => array( __( 'WordPress development', 'iweb' ), __( 'WooCommerce', 'iweb' ), __( 'Site speed optimization', 'iweb' ), __( 'UX & CRO', 'iweb' ) ),
		'cta'   => __( 'Explore turn visitors into customers', 'iweb' ),
		'url'   => home_url( '/services/turn-visitors-into-customers/' ),
	),
	array(
		'tone'  => 'green',
		'icon'  => 'gear',
		'title' => __( 'Automate the busywork', 'iweb' ),
		'sub'   => __( 'AI chatbots and workflow automation.', 'iweb' ),
		'text'  => __( 'Save your team hours with practical AI automation and integrations.', 'iweb' ),
		'items' => array( __( 'AI chatbots', 'iweb' ), __( 'Workflow automation', 'iweb' ), __( 'AI integrations', 'iweb' ), __( 'Internal tools', 'iweb' ) ),
		'cta'   => __( 'Explore automate the busywork', 'iweb' ),
		'url'   => home_url( '/services/automate-the-busy-work/' ),
	),
	array(
		'tone'  => 'orange',
		'icon'  => 'chart',
		'title' => __( 'Know what\'s working', 'iweb' ),
		'sub'   => __( 'Analytics and tracking.', 'iweb' ),
		'text'  => __( 'Get clear insights with reliable tracking, dashboards and reports.', 'iweb' ),
		'items' => array( __( 'GA4 & Tag Manager', 'iweb' ), __( 'Conversion tracking', 'iweb' ), __( 'Dashboards & reporting', 'iweb' ), __( 'Data audits', 'iweb' ) ),
		'cta'   => __( 'Explore analytics and tracking', 'iweb' ),
		'url'   => home_url( '/services/know-whats-working/' ),
	),
);

$iweb_custom_items = array(
	__( '.NET development', 'iweb' ),
	__( 'API development & integrations', 'iweb' ),
	__( 'Database design', 'iweb' ),
	__( 'Cloud deployment', 'iweb' ),
);

$iweb_steps = array(
	array( __( 'Understand your goals', 'iweb' ), __( 'We learn about your business, challenges and growth goals.', 'iweb' ) ),
	array( __( 'Plan the right solution', 'iweb' ), __( 'We propose a focused plan with clear milestones.', 'iweb' ) ),
	array( __( 'Build and optimize', 'iweb' ), __( 'We execute, test and iterate for best results.', 'iweb' ) ),
	array( __( 'Measure and scale', 'iweb' ), __( 'We track performance and help you scale what works.', 'iweb' ) ),
);

get_header();
?>

<main id="primary" class="site-main services-page" tabindex="-1">

	<!-- Hero -->
	<section class="services-hero">
		<div class="container services-hero__inner">
			<div>
				<nav class="breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'iweb' ); ?>">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'iweb' ); ?></a> ›
					<span aria-current="page"><?php esc_html_e( 'Services', 'iweb' ); ?></span>
				</nav>
				<p class="eyebrow"><?php esc_html_e( 'Our services', 'iweb' ); ?></p>
				<h1 class="services-hero__title"><?php esc_html_e( 'Digital solutions for real business growth.', 'iweb' ); ?></h1>
				<p class="services-hero__lead"><?php esc_html_e( 'From high-performance websites to SEO, AI automation and custom development, we help growing businesses get found, win customers and scale without the busywork.', 'iweb' ); ?></p>
				<div class="cta-row">
					<a class="btn btn--light" href="<?php echo esc_url( $iweb_contact_url ); ?>"><?php esc_html_e( 'Start a project', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
					<a class="btn btn--outline" href="<?php echo esc_url( iweb_audit_url() ); ?>"><?php esc_html_e( 'Book a free audit call', 'iweb' ); ?></a>
				</div>
			</div>

			<div class="services-hero__visual has-mock">
				<?php get_template_part( 'template-parts/ui-mock', null, array( 'variant' => 'stack' ) ); ?>
			</div>
		</div>
	</section>

	<!-- Core services -->
	<section class="section">
		<div class="container">
			<div class="section-head section-head--split">
				<div>
					<p class="eyebrow"><?php esc_html_e( 'Our core services', 'iweb' ); ?></p>
					<h2 class="section-title"><?php esc_html_e( 'Four ways we help you grow, plus custom builds.', 'iweb' ); ?></h2>
				</div>
				<p><?php esc_html_e( 'Choose the area you want to focus on, or talk to us for a recommendation based on your goals.', 'iweb' ); ?></p>
			</div>

			<div class="core-cards">
				<?php foreach ( $iweb_cards as $iweb_card ) : ?>
					<article class="core-card core-card--<?php echo esc_attr( $iweb_card['tone'] ); ?>">
						<div class="core-card__top">
							<span class="core-card__icon"><?php echo iweb_icon( $iweb_card['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
						</div>
						<h3><a href="<?php echo esc_url( $iweb_card['url'] ); ?>"><?php echo esc_html( $iweb_card['title'] ); ?></a></h3>
						<p class="core-card__sub"><?php echo esc_html( $iweb_card['sub'] ); ?></p>
						<p class="core-card__text"><?php echo esc_html( $iweb_card['text'] ); ?></p>
						<ul class="core-card__list">
							<?php foreach ( $iweb_card['items'] as $iweb_item ) : ?>
								<li><?php echo iweb_icon( 'chevron' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php echo esc_html( $iweb_item ); ?></li>
							<?php endforeach; ?>
						</ul>
						<a class="core-card__cta" href="<?php echo esc_url( $iweb_card['url'] ); ?>"><?php echo esc_html( $iweb_card['cta'] ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
					</article>
				<?php endforeach; ?>
			</div>

			<div class="custom-bar" id="custom-development">
				<span class="core-card__icon core-card__icon--dark"><?php echo iweb_icon( 'code' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
				<div class="custom-bar__copy">
					<h3><?php esc_html_e( 'Custom development', 'iweb' ); ?></h3>
					<p class="custom-bar__sub"><?php esc_html_e( '.NET, APIs and integrations.', 'iweb' ); ?></p>
					<p><?php esc_html_e( 'When off-the-shelf solutions are not enough, we build custom web applications, APIs and integrations to fit your business.', 'iweb' ); ?></p>
				</div>
				<ul class="custom-bar__list">
					<?php foreach ( $iweb_custom_items as $iweb_item ) : ?>
						<li><?php echo iweb_icon( 'chevron' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php echo esc_html( $iweb_item ); ?></li>
					<?php endforeach; ?>
				</ul>
				<a class="core-card__cta" href="<?php echo esc_url( home_url( '/services/custom-development/' ) ); ?>"><?php esc_html_e( 'Explore custom development', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
			</div>
		</div>
	</section>

	<!-- Approach -->
	<section class="section approach">
		<div class="container">
			<div class="section-head section-head--split">
				<div>
					<p class="eyebrow"><?php esc_html_e( 'Our approach', 'iweb' ); ?></p>
					<h2 class="section-title"><?php esc_html_e( 'Strategy. Execution. Results.', 'iweb' ); ?></h2>
				</div>
				<p><?php esc_html_e( 'No matter which service you choose, we follow the same simple approach to keep things focused and effective.', 'iweb' ); ?></p>
			</div>

			<ol class="approach__steps">
				<?php foreach ( $iweb_steps as $iweb_i => $iweb_step ) : ?>
					<li>
						<span class="approach__num"><?php echo esc_html( $iweb_i + 1 ); ?></span>
						<h3><?php echo esc_html( $iweb_step[0] ); ?></h3>
						<p><?php echo esc_html( $iweb_step[1] ); ?></p>
					</li>
				<?php endforeach; ?>
			</ol>
		</div>
	</section>

	<!-- Closing CTA -->
	<section class="section section--dark cta-band services-cta">
		<div class="container services-cta__inner">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Ready to get started?', 'iweb' ); ?></p>
				<h2><?php esc_html_e( 'Let\'s build your next growth engine.', 'iweb' ); ?></h2>
			</div>
			<div>
				<p><?php esc_html_e( 'Tell us about your goals and we\'ll help you choose the right starting point.', 'iweb' ); ?></p>
				<div class="cta-row">
					<a class="btn btn--light" href="<?php echo esc_url( $iweb_contact_url ); ?>"><?php esc_html_e( 'Start a project', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
					<a class="btn btn--ghost-dark" href="<?php echo esc_url( iweb_audit_url() ); ?>"><?php esc_html_e( 'Book a free audit call', 'iweb' ); ?></a>
				</div>
			</div>
		</div>
	</section>

</main><!-- #primary -->

<?php
get_footer();
