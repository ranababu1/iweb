<?php
/**
 * Template Name: Service – Know What's Working
 * Template Post Type: page
 *
 * All copy for the "Know what's working" (analytics and tracking) service
 * page lives in this file. Styling lives in assets/css/service.css and
 * behavior in assets/js/service.js, shared with the other service templates
 * and loaded only for them.
 *
 * @package iweb
 * @since 1.5.0
 */

/**
 * Show the results section. Keep false until real case studies exist.
 *
 * @since 1.1.0
 * @param bool $show Whether to render the section.
 */
$iweb_show_case_studies = apply_filters( 'iweb_show_case_studies', false );

$iweb_contact_url = home_url( '/contact/' );

$iweb_benefits = array(
	array( 'chart', __( 'Reliable Data', 'iweb' ), __( 'Accurate tracking you can trust.', 'iweb' ) ),
	array( 'target', __( 'Clear Insights', 'iweb' ), __( 'Understand what drives results.', 'iweb' ) ),
	array( 'users', __( 'Better Decisions', 'iweb' ), __( 'Focus on what really works.', 'iweb' ) ),
	array( 'rocket', __( 'Long-Term Growth', 'iweb' ), __( 'Turn data into a growth strategy.', 'iweb' ) ),
);

$iweb_chips = array(
	array( 'orange', 'chart', __( 'GA4 Tracking', 'iweb' ) ),
	array( 'green', 'check', __( 'Conversion Events', 'iweb' ) ),
	array( 'purple', 'chart', __( 'Custom Dashboards', 'iweb' ) ),
);

$iweb_offers = array(
	array( 'orange', 'chart', __( 'GA4 Setup & Configuration', 'iweb' ), __( 'Complete GA4 setup with events, audiences and goals tailored to your business.', 'iweb' ) ),
	array( 'blue', 'tag', __( 'Google Tag Manager', 'iweb' ), __( 'Flexible tracking setup for marketing tags, conversion events and custom tracking.', 'iweb' ) ),
	array( 'green', 'target', __( 'Conversion Tracking', 'iweb' ), __( 'Track leads, form submissions, purchases and key business actions.', 'iweb' ) ),
	array( 'purple', 'chart', __( 'Custom Dashboards', 'iweb' ), __( 'Easy-to-read dashboards with the metrics that matter.', 'iweb' ) ),
	array( 'orange', 'database', __( 'Data & Reporting', 'iweb' ), __( 'Reliable reports, clean data and actionable insights.', 'iweb' ) ),
	array( 'red', 'gear', __( 'Ongoing Support', 'iweb' ), __( 'Continuous monitoring, updates and support as your business grows.', 'iweb' ) ),
);

$iweb_steps = array(
	array( 'green', 'search', __( 'Understand', 'iweb' ), __( 'We learn about your goals, current setup and key metrics.', 'iweb' ) ),
	array( 'orange', 'doc', __( 'Plan', 'iweb' ), __( 'We define your tracking strategy and event map.', 'iweb' ) ),
	array( 'blue', 'code', __( 'Implement', 'iweb' ), __( 'We set up tracking, dashboards and reporting.', 'iweb' ) ),
	array( 'purple', 'chart', __( 'Measure & Improve', 'iweb' ), __( 'We analyze results and keep optimizing.', 'iweb' ) ),
);

$iweb_faqs = array(
	array( __( 'We already have Google Analytics. Why would we need help?', 'iweb' ), __( 'Installed isn\'t the same as set up correctly. Common issues include missing conversions, spam traffic, duplicate events and broken cross-domain tracking. An audit shows what\'s reliable and what isn\'t.', 'iweb' ) ),
	array( __( 'What\'s the difference between GA4 and Google Tag Manager?', 'iweb' ), __( 'GA4 stores and reports your data. Tag Manager is the tool that sends data to GA4 and other platforms. Using both keeps tracking organised and easier to change.', 'iweb' ) ),
	array( __( 'Can you track phone calls and form submissions?', 'iweb' ), __( 'Yes. We track form submissions, clicks on phone numbers and email links, bookings and, with call tracking tools, actual phone calls.', 'iweb' ) ),
	array( __( 'Why don\'t GA4 and my ad platform numbers match?', 'iweb' ), __( 'They count things differently, use different attribution models and are affected by consent choices and ad blockers. We set them up consistently and explain the gaps so you know which numbers to trust for which decision.', 'iweb' ) ),
	array( __( 'Do you handle cookie consent?', 'iweb' ), __( 'Yes. We set up a consent banner and Google Consent Mode so tracking follows user choices. You should still check legal requirements with your own advisor.', 'iweb' ) ),
	array( __( 'What will our reports look like?', 'iweb' ), __( 'A short dashboard focused on the numbers you care about, usually leads, sales, cost per lead and top pages, plus a plain-language summary of what changed and what to do next.', 'iweb' ) ),
);

get_header();
?>

<main id="primary" class="site-main service service--analytics" tabindex="-1">

	<!-- Hero -->
	<?php
	get_template_part(
		'template-parts/service-hero',
		null,
		array(
			'label'       => __( 'Know what\'s working', 'iweb' ),
			'lines'       => array( __( 'Clean data.', 'iweb' ), __( 'Clear reports.', 'iweb' ), __( 'Better decisions.', 'iweb' ) ),
			'highlight'   => __( 'Know what drives growth.', 'iweb' ),
			'lead'        => __( 'We set up tracking you can trust and dashboards that use AI to point out what changed, so you can see where your leads and sales come from.', 'iweb' ),
			'steps'       => array(
				array( 'search', __( 'Tracking audit', 'iweb' ), __( 'Find gaps and broken tags', 'iweb' ) ),
				array( 'tag', __( 'GA4 and Tag Manager setup', 'iweb' ), __( 'Clean, consistent tracking', 'iweb' ) ),
				array( 'target', __( 'Conversion events', 'iweb' ), __( 'Measure the actions that matter', 'iweb' ) ),
				array( 'link', __( 'Connect ad and CRM data', 'iweb' ), __( 'See the full picture in one place', 'iweb' ) ),
				array( 'gauge', __( 'Live dashboards', 'iweb' ), __( 'Key numbers at a glance', 'iweb' ) ),
				array( 'bulb', __( 'Monthly insights', 'iweb' ), __( 'Plain-English notes on what to do next', 'iweb' ) ),
			),
			'result_icon' => 'chart',
			'result'      => __( 'Decisions backed by data', 'iweb' ),
		)
	);
	?>

	<!-- Benefits strip -->
	<section class="trust-strip" aria-label="<?php esc_attr_e( 'Benefits', 'iweb' ); ?>">
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
					<p class="eyebrow"><?php esc_html_e( 'Our analytics & tracking services', 'iweb' ); ?></p>
					<h2 class="section-title"><?php esc_html_e( 'From Setup to Insights, Everything You Need', 'iweb' ); ?></h2>
				</div>
				<div>
					<p><?php esc_html_e( 'We help you set up and make the most of modern analytics and tracking tools. From accurate event tracking to custom dashboards, we give you the data and insights you need to grow your business.', 'iweb' ); ?></p>
					<a class="link-arrow" href="<?php echo esc_url( $iweb_contact_url ); ?>"><?php esc_html_e( 'Talk to an analytics expert', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
				</div>
			</div>

			<div class="offer-cards">
				<?php foreach ( $iweb_offers as $iweb_offer ) : ?>
					<article class="offer-card tone-<?php echo esc_attr( $iweb_offer[0] ); ?>">
						<span class="icon-tile icon-tile--lg"><?php echo iweb_icon( $iweb_offer[1] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
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
		<!-- Results (hidden until real case studies exist) -->
		<section class="section section--dark service-results">
			<div class="container service-results__inner">
				<div>
					<p class="eyebrow"><?php esc_html_e( 'Turn data into growth', 'iweb' ); ?></p>
					<h2 class="section-title"><?php esc_html_e( 'Real Insights.', 'iweb' ); ?><br><?php esc_html_e( 'Real Business Impact.', 'iweb' ); ?></h2>
					<p><?php esc_html_e( 'We help businesses track the right metrics, understand their customers and make data-driven decisions that lead to more traffic, leads and revenue.', 'iweb' ); ?></p>
					<a class="btn btn--light" href="<?php echo esc_url( home_url( '/our-work/' ) ); ?>"><?php esc_html_e( 'View Our Work', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
				</div>
				<?php /* Replace with real client figures before enabling. */ ?>
				<ul class="results-list">
					<li><?php echo iweb_icon( 'check' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'More traffic', 'iweb' ); ?></li>
					<li><?php echo iweb_icon( 'check' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'Better conversions', 'iweb' ); ?></li>
					<li><?php echo iweb_icon( 'check' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'Higher revenue', 'iweb' ); ?></li>
					<li><?php echo iweb_icon( 'check' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'Clearer insights', 'iweb' ); ?></li>
				</ul>
			</div>
		</section>
	<?php endif; ?>

	<!-- Process -->
	<section class="section">
		<div class="container">
			<p class="eyebrow"><?php esc_html_e( 'Our process', 'iweb' ); ?></p>
			<h2 class="section-title service-process-title"><?php esc_html_e( 'A Simple, Transparent Process', 'iweb' ); ?></h2>
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

	<!-- FAQ -->
	<section class="section faq">
		<div class="container faq__inner faq__inner--three">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Frequently asked questions', 'iweb' ); ?></p>
				<h2 class="section-title"><?php esc_html_e( 'Your Questions, Answered.', 'iweb' ); ?></h2>
				<p><?php esc_html_e( 'Quick answers to common questions about analytics and tracking services.', 'iweb' ); ?></p>
				<?php if ( get_page_by_path( 'faq' ) ) : ?>
				<a class="link-arrow" href="<?php echo esc_url( home_url( '/faq/' ) ); ?>"><?php esc_html_e( 'View All FAQs', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
				<?php endif; ?>
			</div>
			<div class="faq__list" data-faq>
				<?php foreach ( $iweb_faqs as $iweb_faq ) : ?>
					<details class="faq__item">
						<summary><?php echo esc_html( $iweb_faq[0] ); ?> <?php echo iweb_icon( 'plus' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></summary>
						<p><?php echo esc_html( $iweb_faq[1] ); ?></p>
					</details>
				<?php endforeach; ?>
			</div>
			<aside class="faq__aside tone-green">
				<h3><?php esc_html_e( 'Not sure where to start?', 'iweb' ); ?></h3>
				<p><?php esc_html_e( 'Book a free audit call and we\'ll review your current analytics setup and suggest the best way forward.', 'iweb' ); ?></p>
				<a class="btn btn--primary" href="<?php echo esc_url( iweb_audit_url() ); ?>"><?php echo iweb_icon( 'calendar' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'Book a free audit call', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
			</aside>
		</div>
	</section>

	<!-- Closing CTA -->
	<section class="section section--dark cta-band service-cta-band">
		<div class="container service-cta-band__inner">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Ready to make data-driven decisions?', 'iweb' ); ?></p>
				<h2><?php esc_html_e( 'Let\'s Set Up Your Analytics and Tracking.', 'iweb' ); ?></h2>
				<p><?php esc_html_e( 'Get a clear strategy and setup tailored to your business.', 'iweb' ); ?></p>
			</div>
			<div class="cta-row">
				<a class="btn btn--light" href="<?php echo esc_url( $iweb_contact_url ); ?>"><?php esc_html_e( 'Start a project', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
				<a class="btn btn--ghost-dark" href="<?php echo esc_url( iweb_audit_url() ); ?>"><?php echo iweb_icon( 'calendar' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'Book a free audit call', 'iweb' ); ?></a>
			</div>
		</div>
	</section>

</main><!-- #primary -->

<?php
get_footer();
