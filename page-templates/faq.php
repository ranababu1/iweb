<?php
/**
 * Template Name: FAQ
 * Template Post Type: page
 *
 * All FAQ copy lives in this file. Styling lives in assets/css/faq.css and
 * behavior (category tabs, deep links to a question) in assets/js/faq.js.
 * Without JavaScript every category is shown as one long list.
 *
 * @package iweb
 * @since 1.12.0
 */

$iweb_contact_url = home_url( '/contact/' );

$iweb_groups = array(
	'general'    => array(
		'icon'  => 'chat',
		'title' => __( 'General', 'iweb' ),
		'blurb' => __( 'Common questions about iWebAndSEO, our approach and how we work.', 'iweb' ),
		'items' => array(
			array( 'what-does-iwebandseo-do', __( 'What does iWebAndSEO do?', 'iweb' ), __( 'We help businesses grow with high-performance websites, SEO (including AEO and GEO), AI automation and custom development. Our focus is on practical solutions that bring measurable results, combining strategy, design, technology and ongoing support.', 'iweb' ) ),
			array( 'who-do-you-work-with', __( 'Who do you work with?', 'iweb' ), __( 'We work with startups, small and mid-sized businesses and enterprise teams across a range of industries.', 'iweb' ) ),
			array( 'international-clients', __( 'Do you work with international clients?', 'iweb' ), __( 'Yes. We work with clients across the globe and are fully remote-friendly.', 'iweb' ) ),
			array( 'what-makes-us-different', __( 'What makes iWebAndSEO different?', 'iweb' ), __( 'We combine hands-on technical expertise with an understanding of business goals. You work directly with people who build and optimize, and we measure success by your results.', 'iweb' ) ),
			array( 'how-do-we-get-started', __( 'How do we get started?', 'iweb' ), __( 'Tell us about your project through the Start a project form. We\'ll review it, set up a short discovery call and follow up with a clear proposal.', 'iweb' ) ),
			array( 'ongoing-support-general', __( 'Do you offer ongoing support?', 'iweb' ), __( 'Yes. We offer ongoing maintenance, optimization and support after launch.', 'iweb' ) ),
		),
	),
	'services'   => array(
		'icon'  => 'gear',
		'title' => __( 'Services', 'iweb' ),
		'blurb' => __( 'Questions about our website, SEO, automation and development services.', 'iweb' ),
		'items' => array(
			array( 'what-services-do-you-offer', __( 'What services do you offer?', 'iweb' ), __( 'Four areas: getting found (SEO, AEO, GEO and paid ads), turning visitors into customers (WordPress, WooCommerce, speed, UX and CRO), automating the busywork (AI and workflow automation) and knowing what\'s working (analytics and tracking). We also build custom software.', 'iweb' ) ),
			array( 'new-website-and-seo', __( 'Can you help with both a new website and SEO?', 'iweb' ), __( 'Yes. Building the site with SEO in mind from the start is usually faster and cheaper than fixing it later.', 'iweb' ) ),
			array( 'ai-automation', __( 'Do you offer AI automation services?', 'iweb' ), __( 'Yes. We build AI chatbots, workflow automations and integrations that remove repetitive manual work.', 'iweb' ) ),
			array( 'existing-website', __( 'Can you work with our existing website or platform?', 'iweb' ), __( 'Absolutely. We can audit, optimize or extend your existing website or application.', 'iweb' ) ),
			array( 'custom-web-applications', __( 'Do you build custom web applications?', 'iweb' ), __( 'Yes. We build custom applications, APIs and integrations on .NET, Java and other stacks when off-the-shelf tools aren\'t enough.', 'iweb' ) ),
			array( 'seo-writing', __( 'Do you offer SEO and content writing?', 'iweb' ), __( 'Yes. We plan and produce SEO-friendly content as part of our Get found service.', 'iweb' ) ),
			array( 'integrate-tools', __( 'Can you integrate with our existing tools?', 'iweb' ), __( 'Usually, yes. If a tool offers an API or a connector, we can integrate it. Tell us what you use and we\'ll confirm.', 'iweb' ) ),
			array( 'analytics-tracking', __( 'Do you set up analytics and tracking?', 'iweb' ), __( 'Yes. We set up GA4, Tag Manager, conversion tracking and dashboards so you can see what\'s working.', 'iweb' ) ),
		),
	),
	'process'    => array(
		'icon'  => 'clock',
		'title' => __( 'Process & Timeline', 'iweb' ),
		'blurb' => __( 'How projects run and how long they take.', 'iweb' ),
		'items' => array(
			array( 'how-long-does-a-project-take', __( 'How long does a typical project take?', 'iweb' ), __( 'It depends on scope. A focused website can take a few weeks, while larger builds take longer. You\'ll get a clear timeline in your proposal.', 'iweb' ) ),
			array( 'how-soon-can-you-start', __( 'How soon can you start?', 'iweb' ), __( 'We typically start new projects within 1–2 weeks, depending on scope and requirements.', 'iweb' ) ),
			array( 'what-is-your-process', __( 'What is your process?', 'iweb' ), __( 'Understand your goals, plan the solution, build and test it, then launch and keep improving. See our How we work page for the detail.', 'iweb' ) ),
			array( 'how-do-you-communicate', __( 'How do you keep me updated?', 'iweb' ), __( 'You get a dedicated point of contact, regular updates and demos, and clear milestones.', 'iweb' ) ),
			array( 'seo-results-time', __( 'How long does SEO take to show results?', 'iweb' ), __( 'Early movement is often visible within a few months, but compounding growth usually takes six months or more.', 'iweb' ) ),
			array( 'revisions', __( 'Can I request changes during the project?', 'iweb' ), __( 'Yes. We work collaboratively and share progress along the way so feedback is built in.', 'iweb' ) ),
		),
	),
	'pricing'    => array(
		'icon'  => 'coins',
		'title' => __( 'Pricing', 'iweb' ),
		'blurb' => __( 'How we price and what influences cost.', 'iweb' ),
		'items' => array(
			array( 'how-much-does-a-website-cost', __( 'How much does a website cost?', 'iweb' ), __( 'It depends on the scope, features and integrations. We\'ll give you a clear estimate after learning about your goals. See our website cost guide for what influences the price.', 'iweb' ) ),
			array( 'how-do-you-price', __( 'How do you price projects?', 'iweb' ), __( 'Projects are quoted from a defined scope, with a transparent breakdown. Ongoing work such as SEO or support is scoped separately.', 'iweb' ) ),
			array( 'long-contracts', __( 'Do I have to sign a long contract?', 'iweb' ), __( 'No long contracts are required to get started.', 'iweb' ) ),
			array( 'free-audit', __( 'Is the audit call free?', 'iweb' ), __( 'Yes. The free audit call is a no-obligation conversation about your goals and the best way forward.', 'iweb' ) ),
			array( 'payment-terms', __( 'What are your payment terms?', 'iweb' ), __( 'Payment terms are agreed in your proposal before work begins.', 'iweb' ) ),
		),
	),
	'technology' => array(
		'icon'  => 'code',
		'title' => __( 'Technology', 'iweb' ),
		'blurb' => __( 'The tools and platforms we use.', 'iweb' ),
		'items' => array(
			array( 'which-platforms', __( 'Which platforms do you work with?', 'iweb' ), __( 'We specialize in WordPress and WooCommerce, and also build on .NET, Java, PHP, Node.js and Python.', 'iweb' ) ),
			array( 'custom-theme', __( 'Do you build custom themes and plugins?', 'iweb' ), __( 'Yes. We build custom WordPress themes and plugins when they\'re the better fit.', 'iweb' ) ),
			array( 'hosting', __( 'Can you help with hosting and deployment?', 'iweb' ), __( 'Yes. We can advise on hosting, set up deployment and take care of performance and security.', 'iweb' ) ),
			array( 'integrate-existing-tools', __( 'Can you integrate with our existing tools?', 'iweb' ), __( 'Usually, yes. If a tool has an API or a connector, we can integrate it.', 'iweb' ) ),
			array( 'security', __( 'How do you handle security?', 'iweb' ), __( 'We follow security best practices, keep software updated and can provide ongoing monitoring.', 'iweb' ) ),
		),
	),
	'support'    => array(
		'icon'  => 'headset',
		'title' => __( 'Support', 'iweb' ),
		'blurb' => __( 'Help after your project goes live.', 'iweb' ),
		'items' => array(
			array( 'ongoing-support', __( 'What kind of ongoing support do you provide?', 'iweb' ), __( 'Maintenance, updates, monitoring, performance work and ongoing optimization, depending on what your project needs.', 'iweb' ) ),
			array( 'after-launch', __( 'What happens after launch?', 'iweb' ), __( 'We monitor results, fix issues and keep improving. You can continue with a support plan or manage things yourself.', 'iweb' ) ),
			array( 'training', __( 'Will my team be trained to use it?', 'iweb' ), __( 'Yes. We walk your team through how everything works so you can manage it day to day.', 'iweb' ) ),
			array( 'how-to-contact', __( 'How do I contact you for support?', 'iweb' ), __( 'Email us or use the Start a project form. Clients get a dedicated point of contact.', 'iweb' ) ),
		),
	),
);

$iweb_quick = array(
	array( 'doc', __( 'Website cost guide', 'iweb' ), __( 'Get an idea of typical costs and what influences the pricing.', 'iweb' ), home_url( '/website-cost-guide/' ) ),
	array( 'clock', __( 'Project timeline', 'iweb' ), __( 'Learn about our typical project phases and timelines.', 'iweb' ), home_url( '/how-we-work/' ) ),
	array( 'gear', __( 'Our process', 'iweb' ), __( 'Understand how we work from discovery to launch and beyond.', 'iweb' ), home_url( '/how-we-work/' ) ),
	array( 'shield', __( 'Ongoing support', 'iweb' ), __( 'Details about maintenance, updates and support plans.', 'iweb' ), home_url( '/contact/' ) ),
);

$iweb_popular = array(
	'how-much-does-a-website-cost',
	'how-long-does-a-project-take',
	'seo-writing',
	'integrate-tools',
	'ongoing-support',
);

// Index every question by anchor for the popular list and the schema.
$iweb_index = array();
$iweb_schema = array();

foreach ( $iweb_groups as $iweb_gkey => $iweb_group ) {
	foreach ( $iweb_group['items'] as $iweb_item ) {
		$iweb_index[ $iweb_item[0] ] = array( $iweb_gkey, $iweb_item[1] );
		$iweb_schema[]               = array(
			'@type'          => 'Question',
			'name'           => $iweb_item[1],
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text'  => $iweb_item[2],
			),
		);
	}
}

get_header();
?>

<main id="primary" class="site-main faq-page" tabindex="-1">

	<script type="application/ld+json"><?php echo wp_json_encode( array( '@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => $iweb_schema ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></script>

	<!-- Hero -->
	<section class="faq-hero">
		<div class="container faq-hero__inner">
			<div>
				<nav class="breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'iweb' ); ?>">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'iweb' ); ?></a> ›
					<span aria-current="page"><?php esc_html_e( 'FAQ', 'iweb' ); ?></span>
				</nav>
				<p class="eyebrow"><?php esc_html_e( 'FAQ / Knowledge hub', 'iweb' ); ?></p>
				<h1 class="faq-hero__title"><?php esc_html_e( 'Your questions,', 'iweb' ); ?> <span class="accent"><?php esc_html_e( 'answered.', 'iweb' ); ?></span></h1>
				<p class="faq-hero__lead"><?php esc_html_e( 'Find clear answers about our services, process, pricing, technology and support. If you don\'t see your question here, feel free to reach out — we\'re happy to help.', 'iweb' ); ?></p>
			</div>
			<div class="faq-hero__visual" aria-hidden="true"><span><?php esc_html_e( 'Questions', 'iweb' ); ?></span><span><?php esc_html_e( 'Ideas', 'iweb' ); ?></span><span><?php esc_html_e( 'Answers', 'iweb' ); ?></span></div>
		</div>
	</section>

	<div class="container">

		<!-- Category tabs -->
		<ul class="faq-tabs" role="tablist" aria-label="<?php esc_attr_e( 'FAQ categories', 'iweb' ); ?>" data-faq-tabs>
			<?php
			$iweb_first = true;

			foreach ( $iweb_groups as $iweb_gkey => $iweb_group ) :
				?>
				<li role="presentation">
					<a class="faq-tab<?php echo $iweb_first ? ' is-active' : ''; ?>" role="tab" href="#faq-<?php echo esc_attr( $iweb_gkey ); ?>" data-group="<?php echo esc_attr( $iweb_gkey ); ?>" aria-selected="<?php echo $iweb_first ? 'true' : 'false'; ?>">
						<?php echo iweb_icon( $iweb_group['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<span>
							<strong><?php echo esc_html( $iweb_group['title'] ); ?></strong>
							<small>
								<?php
								/* translators: %d: number of questions. */
								echo esc_html( sprintf( _n( '%d question', '%d questions', count( $iweb_group['items'] ), 'iweb' ), count( $iweb_group['items'] ) ) );
								?>
							</small>
						</span>
					</a>
				</li>
				<?php
				$iweb_first = false;
			endforeach;
			?>
		</ul>

		<div class="faq-layout">
			<div class="faq-main" data-faq-groups>
				<?php
				$iweb_first = true;

				foreach ( $iweb_groups as $iweb_gkey => $iweb_group ) :
					?>
					<section id="faq-<?php echo esc_attr( $iweb_gkey ); ?>" class="faq-group<?php echo $iweb_first ? ' is-active' : ''; ?>" data-group="<?php echo esc_attr( $iweb_gkey ); ?>">
						<h2><?php echo esc_html( $iweb_group['title'] ); ?></h2>
						<p class="faq-group__blurb"><?php echo esc_html( $iweb_group['blurb'] ); ?></p>

						<div class="faq-items">
							<?php foreach ( $iweb_group['items'] as $iweb_item ) : ?>
								<details id="<?php echo esc_attr( $iweb_item[0] ); ?>" class="faq-item"<?php echo $iweb_first && $iweb_item === $iweb_group['items'][0] ? ' open' : ''; ?>>
									<summary><?php echo esc_html( $iweb_item[1] ); ?> <?php echo iweb_icon( 'chevron' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></summary>
									<p><?php echo esc_html( $iweb_item[2] ); ?></p>
								</details>
							<?php endforeach; ?>
						</div>
					</section>
					<?php
					$iweb_first = false;
				endforeach;
				?>
			</div>

			<aside class="faq-side">
				<div class="side-card side-card--green">
					<span class="faq-badge"><?php echo iweb_icon( 'chat' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<h2><?php esc_html_e( 'Still have a question?', 'iweb' ); ?></h2>
					<p><?php esc_html_e( 'We\'re happy to help. Get in touch and we\'ll get back to you within 1 business day.', 'iweb' ); ?></p>
					<a class="btn btn--light" href="<?php echo esc_url( $iweb_contact_url ); ?>"><?php esc_html_e( 'Start a project', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
					<a class="btn btn--outline" href="<?php echo esc_url( $iweb_contact_url ); ?>"><?php echo iweb_icon( 'calendar' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'Book a free audit call', 'iweb' ); ?></a>
				</div>

				<div class="side-card side-card--white">
					<h2 class="faq-side__title"><?php echo iweb_icon( 'bulb' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'Quick answers', 'iweb' ); ?></h2>
					<ul class="quick-list">
						<?php foreach ( $iweb_quick as $iweb_q ) : ?>
							<li>
								<a href="<?php echo esc_url( $iweb_q[3] ); ?>">
									<span class="quick-list__icon"><?php echo iweb_icon( $iweb_q[0] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
									<span><strong><?php echo esc_html( $iweb_q[1] ); ?></strong> <?php echo esc_html( $iweb_q[2] ); ?></span>
									<?php echo iweb_icon( 'chevron' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>

				<div class="side-card side-card--sand">
					<span class="faq-badge faq-badge--dark"><?php echo iweb_icon( 'book' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<h2><?php esc_html_e( 'Explore more', 'iweb' ); ?></h2>
					<p><?php esc_html_e( 'Check out our detailed guides and articles in the Insights section.', 'iweb' ); ?></p>
					<a class="btn btn--outline btn--sm" href="<?php echo esc_url( iweb_blog_url() ); ?>"><?php esc_html_e( 'Browse all articles', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
				</div>

				<div class="side-card side-card--white">
					<h2 class="faq-side__title"><?php echo iweb_icon( 'question' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'Popular questions', 'iweb' ); ?></h2>
					<ol class="popular-q">
						<?php
						foreach ( $iweb_popular as $iweb_anchor ) :
							if ( ! isset( $iweb_index[ $iweb_anchor ] ) ) {
								continue;
							}
							?>
							<li><a href="#<?php echo esc_attr( $iweb_anchor ); ?>" data-open="<?php echo esc_attr( $iweb_anchor ); ?>"><?php echo esc_html( $iweb_index[ $iweb_anchor ][1] ); ?></a></li>
						<?php endforeach; ?>
					</ol>
				</div>
			</aside>
		</div>
	</div>

	<!-- Closing CTA -->
	<section class="section section--dark cta-band faq-cta">
		<div class="container faq-cta__inner">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Still have questions?', 'iweb' ); ?></p>
				<h2><?php esc_html_e( 'Let\'s discuss your project and find the right solution.', 'iweb' ); ?></h2>
			</div>
			<div class="cta-row">
				<a class="btn btn--light" href="<?php echo esc_url( $iweb_contact_url ); ?>"><?php esc_html_e( 'Start a project', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
				<a class="btn btn--ghost-dark" href="<?php echo esc_url( $iweb_contact_url ); ?>"><?php echo iweb_icon( 'calendar' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'Book a free audit call', 'iweb' ); ?></a>
			</div>
		</div>
	</section>

</main><!-- #primary -->

<?php
get_footer();
