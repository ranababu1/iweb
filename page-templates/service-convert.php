<?php
/**
 * Template Name: Service – Turn Visitors into Customers
 * Template Post Type: page
 *
 * All copy for the "Turn visitors into customers" (WordPress, WooCommerce,
 * speed, UX and CRO) service page lives in this file. Styling lives in
 * assets/css/service.css and behavior in assets/js/service.js, shared with
 * the other service templates and loaded only for them.
 *
 * @package iweb
 * @since 1.3.0
 */

/**
 * Show the featured work and client stories sections. Keep false until real
 * case studies and testimonials exist.
 *
 * @since 1.1.0
 * @param bool $show Whether to render the sections.
 */
$iweb_show_case_studies = apply_filters( 'iweb_show_case_studies', false );

$iweb_contact_url = home_url( '/contact/' );

$iweb_benefits = array(
	array( 'wordpress', __( 'WordPress Development', 'iweb' ), __( 'Flexible, scalable and easy to manage.', 'iweb' ) ),
	array( 'cart', __( 'WooCommerce', 'iweb' ), __( 'Powerful stores for real business growth.', 'iweb' ) ),
	array( 'gauge', __( 'Site Speed', 'iweb' ), __( 'Faster sites. Better user experiences.', 'iweb' ) ),
	array( 'user', __( 'UX & UI Design', 'iweb' ), __( 'Clean, modern and conversion-focused.', 'iweb' ) ),
	array( 'chart', __( 'CRO', 'iweb' ), __( 'Turn more visitors into paying customers.', 'iweb' ) ),
);

$iweb_offers = array(
	array( 'green', 'wordpress', __( 'WordPress Development', 'iweb' ), __( 'Custom themes, plugins and site optimization.', 'iweb' ) ),
	array( 'purple', 'cart', __( 'WooCommerce', 'iweb' ), __( 'Build and grow your online store with ease.', 'iweb' ) ),
	array( 'orange', 'gauge', __( 'Site Speed', 'iweb' ), __( 'Lightning-fast sites for better engagement and sales.', 'iweb' ) ),
	array( 'blue', 'user', __( 'UX & UI Design', 'iweb' ), __( 'Intuitive experiences that keep users coming back.', 'iweb' ) ),
	array( 'green', 'funnel', __( 'CRO', 'iweb' ), __( 'Data-driven improvements to maximize conversions.', 'iweb' ) ),
);

$iweb_steps = array(
	array( 'green', 'search', __( 'Discover', 'iweb' ), __( 'We learn about your goals, audience and challenges.', 'iweb' ) ),
	array( 'orange', 'doc', __( 'Plan', 'iweb' ), __( 'We create a clear strategy and roadmap.', 'iweb' ) ),
	array( 'blue', 'code', __( 'Build', 'iweb' ), __( 'We design and develop your solution.', 'iweb' ) ),
	array( 'green', 'chart', __( 'Grow', 'iweb' ), __( 'We launch, optimize and help you scale.', 'iweb' ) ),
);

$iweb_faqs = array(
	array( __( 'How long does a project take?', 'iweb' ), __( 'It depends on scope. A focused site can take a few weeks, while a larger WooCommerce build takes longer. We\'ll give you a clear timeline after the planning step.', 'iweb' ) ),
	array( __( 'Do you work with existing themes?', 'iweb' ), __( 'Yes. We can improve and extend your current theme, or build a custom one if that\'s the better fit.', 'iweb' ) ),
	array( __( 'What platforms do you support?', 'iweb' ), __( 'We specialize in WordPress and WooCommerce, and can integrate with the other tools and platforms your business relies on.', 'iweb' ) ),
	array( __( 'Do you offer ongoing support?', 'iweb' ), __( 'Yes. We offer ongoing maintenance, optimization and support after launch.', 'iweb' ) ),
);

get_header();
?>

<main id="primary" class="site-main service service--convert" tabindex="-1">

	<!-- Hero -->
	<section class="service-hero">
		<div class="container service-hero__inner">
			<div class="service-hero__copy">
				<nav class="breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'iweb' ); ?>">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'iweb' ); ?></a> ›
					<a href="<?php echo esc_url( home_url( '/services/' ) ); ?>"><?php esc_html_e( 'Services', 'iweb' ); ?></a> ›
					<span aria-current="page"><?php esc_html_e( 'Turn visitors into customers', 'iweb' ); ?></span>
				</nav>
				<p class="eyebrow"><?php esc_html_e( 'Turn visitors into customers', 'iweb' ); ?></p>
				<h1 class="service-hero__title"><?php esc_html_e( 'Build better websites. Turn more visitors', 'iweb' ); ?> <span class="accent"><?php esc_html_e( 'into customers.', 'iweb' ); ?></span></h1>
				<p class="service-hero__lead"><?php esc_html_e( 'We create high-performing WordPress sites, WooCommerce stores and digital experiences that are fast, user-friendly and built to convert. From design to checkout, we help you turn interest into revenue.', 'iweb' ); ?></p>
				<div class="cta-row">
					<a class="btn btn--primary" href="<?php echo esc_url( $iweb_contact_url ); ?>"><?php esc_html_e( 'Start a project', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
					<a class="btn btn--outline" href="<?php echo esc_url( $iweb_contact_url ); ?>"><?php echo iweb_icon( 'calendar' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'Book a free audit call', 'iweb' ); ?></a>
				</div>
				<?php /* TODO: confirm the "no long contracts" claim with Imran before publishing. */ ?>
				<p class="fine-print"><?php esc_html_e( 'No long contracts required to get started.', 'iweb' ); ?></p>
			</div>

			<div class="service-hero__visual service-hero__visual--devices" aria-hidden="true">
				<div class="device-laptop">
					<p class="device__kicker"><?php esc_html_e( 'Healthy Food.', 'iweb' ); ?></p>
					<p class="device__title"><?php esc_html_e( 'Happier You.', 'iweb' ); ?></p>
				</div>
				<div class="device-phone">
					<p class="device__kicker"><?php esc_html_e( 'Good Food', 'iweb' ); ?></p>
					<p class="device__title"><?php esc_html_e( 'Good Vibes', 'iweb' ); ?></p>
				</div>
				<p class="device-note device-note--a"><?php esc_html_e( 'Fast & reliable', 'iweb' ); ?></p>
				<p class="device-note device-note--b"><?php esc_html_e( 'Higher conversions', 'iweb' ); ?></p>
			</div>
		</div>
	</section>

	<!-- Benefits strip -->
	<section class="trust-strip trust-strip--five" aria-label="<?php esc_attr_e( 'Benefits', 'iweb' ); ?>">
		<ul class="container trust-strip__list">
			<?php foreach ( $iweb_benefits as $iweb_b ) : ?>
				<li class="trust-item">
					<?php echo iweb_icon( $iweb_b[0] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<span><strong><?php echo esc_html( $iweb_b[1] ); ?></strong> <?php echo esc_html( $iweb_b[2] ); ?></span>
				</li>
			<?php endforeach; ?>
		</ul>
	</section>

	<!-- Offer -->
	<section class="section">
		<div class="container">
			<div class="section-head section-head--split">
				<div>
					<p class="eyebrow"><?php esc_html_e( 'Our services', 'iweb' ); ?></p>
					<h2 class="section-title"><?php esc_html_e( 'Everything You Need to Convert Visitors Into Customers', 'iweb' ); ?></h2>
				</div>
				<div>
					<p><?php esc_html_e( 'From custom WordPress themes to WooCommerce stores, we build digital experiences that look great, load fast and drive real business results.', 'iweb' ); ?></p>
					<a class="link-arrow" href="<?php echo esc_url( $iweb_contact_url ); ?>"><?php esc_html_e( 'Talk to an eCommerce expert', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
				</div>
			</div>

			<div class="offer-cards offer-cards--tinted offer-cards--five">
				<?php foreach ( $iweb_offers as $iweb_offer ) : ?>
					<article class="offer-card tone-<?php echo esc_attr( $iweb_offer[0] ); ?>">
						<span class="icon-tile"><?php echo iweb_icon( $iweb_offer[1] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
						<div>
							<h3><?php echo esc_html( $iweb_offer[2] ); ?></h3>
							<p><?php echo esc_html( $iweb_offer[3] ); ?></p>
							<a class="link-arrow" href="<?php echo esc_url( $iweb_contact_url ); ?>"><?php esc_html_e( 'Learn More', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php if ( $iweb_show_case_studies ) : ?>
		<!-- Featured work (hidden until real case studies exist) -->
		<section class="container service-featured">
			<div class="service-featured__box section--dark">
				<div>
					<p class="eyebrow"><?php esc_html_e( 'Featured work', 'iweb' ); ?></p>
					<h2 class="section-title"><?php esc_html_e( 'Real Websites.', 'iweb' ); ?><br><?php esc_html_e( 'Real Business Impact.', 'iweb' ); ?></h2>
					<p><?php esc_html_e( 'We build WordPress and WooCommerce sites that are fast, beautiful and designed to convert.', 'iweb' ); ?></p>
					<a class="btn btn--outline" href="<?php echo esc_url( home_url( '/work/' ) ); ?>"><?php esc_html_e( 'View Our Work', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
				</div>
				<div class="visual-placeholder" aria-hidden="true"><?php echo iweb_icon( 'image' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
			</div>
		</section>
	<?php endif; ?>

	<!-- Process -->
	<section class="section">
		<div class="container service-process-split">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Our process', 'iweb' ); ?></p>
				<h2 class="section-title"><?php esc_html_e( 'A Focused, Collaborative Process', 'iweb' ); ?></h2>
				<p><?php esc_html_e( 'We keep things simple, transparent and focused on your goals.', 'iweb' ); ?></p>
				<a class="link-arrow" href="<?php echo esc_url( home_url( '/#process' ) ); ?>"><?php esc_html_e( 'How we work', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
			</div>
			<ol class="process-steps">
				<?php foreach ( $iweb_steps as $iweb_i => $iweb_step ) : ?>
					<li class="process-step tone-<?php echo esc_attr( $iweb_step[0] ); ?>">
						<span class="icon-tile"><?php echo iweb_icon( $iweb_step[1] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
						<span class="process-step__num"><?php echo esc_html( sprintf( '%02d', $iweb_i + 1 ) ); ?></span>
						<h3><?php echo esc_html( $iweb_step[2] ); ?></h3>
						<p><?php echo esc_html( $iweb_step[3] ); ?></p>
					</li>
				<?php endforeach; ?>
			</ol>
		</div>
	</section>

	<?php if ( $iweb_show_case_studies ) : ?>
		<!-- Client stories (hidden until real testimonials exist) -->
		<section class="section client-stories">
			<div class="container client-stories__inner">
				<div>
					<p class="eyebrow"><?php esc_html_e( 'Client stories', 'iweb' ); ?></p>
					<h2 class="section-title"><?php esc_html_e( 'Trusted by Businesses Like Yours', 'iweb' ); ?></h2>
					<p><?php esc_html_e( 'Long-term partnerships and real results are at the heart of what we do.', 'iweb' ); ?></p>
					<a class="btn btn--outline" href="<?php echo esc_url( home_url( '/work/' ) ); ?>"><?php esc_html_e( 'View More Stories', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
				</div>
				<?php /* Replace with a real client testimonial before enabling. */ ?>
				<blockquote class="testimonial visual-placeholder"><?php esc_html_e( 'Add a real client testimonial here.', 'iweb' ); ?></blockquote>
			</div>
		</section>
	<?php endif; ?>

	<!-- FAQ -->
	<section class="section faq">
		<div class="container faq__inner">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Frequently asked questions', 'iweb' ); ?></p>
				<h2 class="section-title"><?php esc_html_e( 'Your Questions, Answered.', 'iweb' ); ?></h2>
				<p><?php esc_html_e( 'Quick answers to common questions about our WordPress, WooCommerce and CRO services.', 'iweb' ); ?></p>
				<a class="link-arrow" href="<?php echo esc_url( home_url( '/faq/' ) ); ?>"><?php esc_html_e( 'View All FAQs', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
			</div>
			<div class="faq__list" data-faq>
				<?php foreach ( $iweb_faqs as $iweb_faq ) : ?>
					<details class="faq__item">
						<summary><?php echo esc_html( $iweb_faq[0] ); ?> <?php echo iweb_icon( 'plus' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></summary>
						<p><?php echo esc_html( $iweb_faq[1] ); ?></p>
					</details>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- Closing CTA -->
	<section class="service-cta">
		<div class="container">
			<div class="service-cta__box cta-band">
				<div>
					<h2><?php esc_html_e( 'Ready to turn more visitors into customers?', 'iweb' ); ?></h2>
					<p><?php esc_html_e( 'Let\'s build a high-performing website that works for your business.', 'iweb' ); ?></p>
				</div>
				<div class="cta-row">
					<a class="btn btn--light" href="<?php echo esc_url( $iweb_contact_url ); ?>"><?php esc_html_e( 'Start a project', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
					<a class="btn btn--ghost-dark" href="<?php echo esc_url( $iweb_contact_url ); ?>"><?php echo iweb_icon( 'calendar' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'Book a free audit call', 'iweb' ); ?></a>
				</div>
			</div>
		</div>
	</section>

</main><!-- #primary -->

<?php
get_footer();
