<?php
/**
 * Template Name: Service – Automate the Busywork
 * Template Post Type: page
 *
 * All copy for the "Automate the busywork" (AI and automation) service page
 * lives in this file. Styling lives in assets/css/service.css and behavior
 * in assets/js/service.js, shared with the other service templates and
 * loaded only for them.
 *
 * @package iweb
 * @since 1.2.0
 */

/**
 * Show the real examples section. Keep false until real case studies exist.
 *
 * @since 1.1.0
 * @param bool $show Whether to render the section.
 */
$iweb_show_case_studies = apply_filters( 'iweb_show_case_studies', false );

$iweb_contact_url = home_url( '/contact/' );

$iweb_benefits = array(
	array( 'bolt', __( 'Save Time', 'iweb' ), __( 'Automate repetitive tasks and reduce manual work.', 'iweb' ) ),
	array( 'gear', __( 'Improve Accuracy', 'iweb' ), __( 'Fewer errors and more consistent results.', 'iweb' ) ),
	array( 'users', __( 'Integrate Tools', 'iweb' ), __( 'Connect your existing apps and systems.', 'iweb' ) ),
	array( 'chart', __( 'Scale Operations', 'iweb' ), __( 'Do more without adding headcount.', 'iweb' ) ),
	array( 'shield', __( 'Stay Focused', 'iweb' ), __( 'Give your team time for what really matters.', 'iweb' ) ),
);

$iweb_offers = array(
	array( 'blue', 'chat', __( 'AI Chatbots', 'iweb' ), __( 'Intelligent chatbots for customer support, lead generation and internal use.', 'iweb' ) ),
	array( 'green', 'gear', __( 'Workflow Automation', 'iweb' ), __( 'Automate repetitive tasks across your marketing, sales and operations.', 'iweb' ) ),
	array( 'orange', 'puzzle', __( 'AI Integrations', 'iweb' ), __( 'Connect AI with your existing tools like WordPress, HubSpot, Google Workspace and more.', 'iweb' ) ),
	array( 'purple', 'code', __( 'Custom AI Solutions', 'iweb' ), __( 'Build custom solutions for your unique business processes and requirements.', 'iweb' ) ),
);

$iweb_workflow = array(
	array( 'blue', 'doc', __( 'New form submission', 'iweb' ) ),
	array( 'orange', 'sparkle', __( 'Extract information (AI)', 'iweb' ) ),
	array( 'orange', 'users', __( 'Update CRM', 'iweb' ) ),
	array( 'blue', 'chat', __( 'Send personalized email', 'iweb' ) ),
	array( 'purple', 'check', __( 'Create task', 'iweb' ) ),
	array( 'purple', 'megaphone', __( 'Notify team on Slack', 'iweb' ) ),
);

$iweb_steps = array(
	array( 'green', 'search', __( 'Understand', 'iweb' ), __( 'We learn about your goals, current workflows and tools.', 'iweb' ) ),
	array( 'orange', 'doc', __( 'Plan', 'iweb' ), __( 'We identify the right opportunities and create a roadmap.', 'iweb' ) ),
	array( 'blue', 'code', __( 'Build', 'iweb' ), __( 'We design and develop your automation solution.', 'iweb' ) ),
	array( 'purple', 'chart', __( 'Launch & Improve', 'iweb' ), __( 'We launch, monitor results and keep optimizing.', 'iweb' ) ),
);

$iweb_faqs = array(
	array( __( 'What can a website chatbot actually do?', 'iweb' ), __( 'Answer common questions from your own content, collect contact details, qualify leads, book calls and pass complex conversations to your team. It works around the clock.', 'iweb' ) ),
	array( __( 'Will the chatbot make things up?', 'iweb' ), __( 'We reduce that risk by limiting answers to your approved content, setting clear rules and testing before launch. For anything uncertain, it hands over to a person.', 'iweb' ) ),
	array( __( 'Which tools do you use for automation?', 'iweb' ), __( 'It depends on your stack and budget. Often Zapier, Make or n8n, connected to AI models through their APIs. For complex or high-volume needs we write custom integrations.', 'iweb' ) ),
	array( __( 'Is my data safe?', 'iweb' ), __( 'We agree on what data the AI can access before we build. We use providers\' business and API terms, keep access limited and avoid sending sensitive data where it isn\'t needed.', 'iweb' ) ),
	array( __( 'Do I need a big budget to start?', 'iweb' ), __( 'No. Many useful automations are small. We usually start with one or two quick wins and build from there.', 'iweb' ) ),
	array( __( 'Can you add AI to our existing app or website?', 'iweb' ), __( 'Yes. We can add features like smart search, summaries or content drafting through APIs, whether your site runs on WordPress, .NET, Java or something else.', 'iweb' ) ),
);

get_header();
?>

<main id="primary" class="site-main service service--automate" tabindex="-1">

	<!-- Hero -->
	<section class="service-hero">
		<div class="container service-hero__inner">
			<div class="service-hero__copy">
				<nav class="breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'iweb' ); ?>">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'iweb' ); ?></a> ›
					<a href="<?php echo esc_url( home_url( '/services/' ) ); ?>"><?php esc_html_e( 'Services', 'iweb' ); ?></a> ›
					<span aria-current="page"><?php esc_html_e( 'Automate the busywork', 'iweb' ); ?></span>
				</nav>
				<p class="eyebrow"><?php esc_html_e( 'Automate the busywork', 'iweb' ); ?></p>
				<h1 class="service-hero__title"><?php esc_html_e( 'Save time. Reduce manual work. Focus', 'iweb' ); ?> <span class="accent"><?php esc_html_e( 'on what grows your business.', 'iweb' ); ?></span></h1>
				<p class="service-hero__lead"><?php esc_html_e( 'We build practical AI and automation solutions that handle repetitive tasks, streamline workflows and integrate with your existing tools – so your team can focus on higher-value work.', 'iweb' ); ?></p>
				<div class="cta-row">
					<a class="btn btn--primary" href="<?php echo esc_url( $iweb_contact_url ); ?>"><?php esc_html_e( 'Start a project', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
					<a class="btn btn--outline" href="<?php echo esc_url( iweb_audit_url() ); ?>"><?php echo iweb_icon( 'calendar' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'Book a free audit call', 'iweb' ); ?></a>
				</div>
				<?php /* TODO: confirm the "no long contracts" claim with Imran before publishing. */ ?>
				<p class="fine-print"><?php esc_html_e( 'No long contracts required to get started.', 'iweb' ); ?></p>
			</div>

			<div class="service-hero__visual service-hero__visual--workflow" aria-hidden="true">
				<div class="workflow-card">
					<p class="workflow-card__title"><?php esc_html_e( 'AI Workflow', 'iweb' ); ?></p>
					<ol class="workflow-card__steps">
						<?php foreach ( $iweb_workflow as $iweb_w ) : ?>
							<li class="tone-<?php echo esc_attr( $iweb_w[0] ); ?>">
								<span class="icon-tile"><?php echo iweb_icon( $iweb_w[1] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
								<?php echo esc_html( $iweb_w[2] ); ?>
							</li>
						<?php endforeach; ?>
					</ol>
				</div>
				<div class="hours-card">
					<?php echo iweb_icon( 'clock' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<p><?php esc_html_e( 'Save hours every week', 'iweb' ); ?></p>
				</div>
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
					<p class="eyebrow"><?php esc_html_e( 'Our AI and automation services', 'iweb' ); ?></p>
					<h2 class="section-title"><?php esc_html_e( 'Practical AI Solutions for Real Business Needs', 'iweb' ); ?></h2>
				</div>
				<div>
					<p><?php esc_html_e( 'From AI chatbots to workflow automation and custom integrations, we help you identify high-impact use cases and build solutions that save time, reduce cost and improve customer experience.', 'iweb' ); ?></p>
					<a class="link-arrow" href="<?php echo esc_url( $iweb_contact_url ); ?>"><?php esc_html_e( 'Talk to an AI automation expert', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
				</div>
			</div>

			<div class="offer-cards offer-cards--tinted offer-cards--four">
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
		<!-- Real examples (hidden until real case studies exist) -->
		<section class="section section--dark service-results">
			<div class="container service-results__inner">
				<div>
					<p class="eyebrow"><?php esc_html_e( 'Real examples', 'iweb' ); ?></p>
					<h2 class="section-title"><?php esc_html_e( 'From Manual Work for Automated Growth', 'iweb' ); ?></h2>
					<p><?php esc_html_e( 'We help businesses automate real workflows like lead handling, content creation, reporting and customer support.', 'iweb' ); ?></p>
					<a class="btn btn--light" href="<?php echo esc_url( home_url( '/our-work/' ) ); ?>"><?php esc_html_e( 'View Our Work', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
				</div>
				<ul class="results-list">
					<li><?php echo iweb_icon( 'check' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'Leads captured automatically', 'iweb' ); ?></li>
					<li><?php echo iweb_icon( 'check' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'Personalized emails sent', 'iweb' ); ?></li>
					<li><?php echo iweb_icon( 'check' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'CRM updated in real time', 'iweb' ); ?></li>
					<li><?php echo iweb_icon( 'check' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'Team notified on Slack', 'iweb' ); ?></li>
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
				<p><?php esc_html_e( 'Quick answers to common questions about our AI and automation services.', 'iweb' ); ?></p>
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
				<p><?php esc_html_e( 'Book a free audit call and we\'ll help you identify the best opportunities to automate your business workflows.', 'iweb' ); ?></p>
				<a class="btn btn--primary" href="<?php echo esc_url( iweb_audit_url() ); ?>"><?php echo iweb_icon( 'calendar' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'Book a free audit call', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
			</aside>
		</div>
	</section>

	<!-- Closing CTA -->
	<section class="section section--dark cta-band service-cta-band">
		<div class="container service-cta-band__inner">
			<div>
				<h2><?php esc_html_e( 'Let\'s Automate Your Busywork.', 'iweb' ); ?></h2>
				<p><?php esc_html_e( 'Get a clear strategy, actionable recommendations and a roadmap tailored to your business.', 'iweb' ); ?></p>
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
