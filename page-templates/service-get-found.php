<?php
/**
 * Template Name: Service – Get Found
 * Template Post Type: page
 *
 * All copy for the "Get found" (SEO, AEO, GEO) service page lives in this
 * file. Styling lives in assets/css/service.css and behavior in
 * assets/js/service.js, both loaded only for this template.
 *
 * @package iweb
 * @since 1.1.0
 */

/**
 * Show the results and case study sections. Keep false until real case
 * studies exist.
 *
 * @since 1.1.0
 * @param bool $show Whether to render the sections.
 */
$iweb_show_case_studies = apply_filters( 'iweb_show_case_studies', false );

$iweb_contact_url = home_url( '/contact/' );

$iweb_benefits = array(
	array( 'chart', __( 'Higher Visibility', 'iweb' ), __( 'on Google & AI', 'iweb' ) ),
	array( 'users', __( 'More Qualified', 'iweb' ), __( 'Traffic', 'iweb' ) ),
	array( 'funnel', __( 'Better Conversions', 'iweb' ), __( 'and Revenue', 'iweb' ) ),
	array( 'leaf', __( 'Long-Term,', 'iweb' ), __( 'Sustainable Growth', 'iweb' ) ),
);

$iweb_offers = array(
	array( 'green', 'search', __( 'SEO Services', 'iweb' ), __( 'Improve your rankings, attract quality traffic and get long-term results.', 'iweb' ) ),
	array( 'blue', 'sparkle', __( 'AEO / GEO (AI Search)', 'iweb' ), __( 'Optimize your content for AI overviews and generative engines like ChatGPT and Gemini.', 'iweb' ) ),
	array( 'purple', 'gear', __( 'Technical SEO', 'iweb' ), __( 'Fix technical issues, improve crawlability and build a strong SEO foundation.', 'iweb' ) ),
	array( 'orange', 'doc', __( 'Content & Blogging', 'iweb' ), __( 'Create high-quality, SEO-friendly content that ranks and converts.', 'iweb' ) ),
	array( 'red', 'megaphone', __( 'Paid Ads (PPC)', 'iweb' ), __( 'Run targeted Google and social ads to get quick, measurable results.', 'iweb' ) ),
	array( 'green', 'chart', __( 'SEO Consulting', 'iweb' ), __( 'Get a clear strategy and roadmap tailored to your business goals.', 'iweb' ) ),
);

$iweb_steps = array(
	array( 'green', 'bulb', __( 'Understand', 'iweb' ), __( 'We learn about your goals and current situation.', 'iweb' ) ),
	array( 'orange', 'doc', __( 'Plan', 'iweb' ), __( 'We create a clear SEO strategy and roadmap.', 'iweb' ) ),
	array( 'blue', 'code', __( 'Implement', 'iweb' ), __( 'We optimize your site, content and technical setup.', 'iweb' ) ),
	array( 'purple', 'chart', __( 'Measure & Grow', 'iweb' ), __( 'We track results, share reports and keep improving.', 'iweb' ) ),
);

$iweb_faqs = array(
	array( __( 'How long does SEO take to work?', 'iweb' ), __( 'It depends on your site, competition and starting point. Technical fixes can show effects within weeks. Content usually takes a few months to build momentum. We\'ll set realistic expectations after the audit.', 'iweb' ) ),
	array( __( 'Can you guarantee rankings?', 'iweb' ), __( 'No. Anyone who guarantees rankings is guessing or taking shortcuts that can hurt you later. We focus on the things you can control and report progress honestly.', 'iweb' ) ),
	array( __( 'What\'s the difference between SEO, AEO and GEO?', 'iweb' ), __( 'SEO helps you rank in search results. AEO helps you become the direct answer in search features and voice results. GEO helps AI tools like ChatGPT and Perplexity mention and cite your brand. The foundations overlap a lot.', 'iweb' ) ),
	array( __( 'Can you get my business mentioned in ChatGPT?', 'iweb' ), __( 'We can\'t control what AI tools say. We can make your brand easier for them to understand and cite: clear facts on your site, consistent business information, structured data and mentions on trusted third-party sites.', 'iweb' ) ),
	array( __( 'Do you write the content or do we?', 'iweb' ), __( 'Either. We can write it, edit what your team writes, or work from your experts\' notes and interviews. Real expertise from your team makes content stronger.', 'iweb' ) ),
	array( __( 'Should I do SEO or paid ads?', 'iweb' ), __( 'Often both. Ads bring traffic quickly while SEO builds lasting visibility. We\'ll recommend a mix based on your budget and goals.', 'iweb' ) ),
);

get_header();
?>

<main id="primary" class="site-main service" tabindex="-1">

	<!-- Hero -->
	<section class="service-hero">
		<div class="container service-hero__inner">
			<div class="service-hero__copy">
				<nav class="breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'iweb' ); ?>">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'iweb' ); ?></a> ›
					<a href="<?php echo esc_url( home_url( '/services/' ) ); ?>"><?php esc_html_e( 'Services', 'iweb' ); ?></a> ›
					<span aria-current="page"><?php esc_html_e( 'Get found', 'iweb' ); ?></span>
				</nav>
				<p class="eyebrow"><?php esc_html_e( 'Get found', 'iweb' ); ?></p>
				<h1 class="service-hero__title"><?php esc_html_e( 'Show up on Google', 'iweb' ); ?> <br><?php esc_html_e( 'and in', 'iweb' ); ?> <span class="accent"><?php esc_html_e( 'AI answers.', 'iweb' ); ?></span></h1>
				<p class="service-hero__lead"><?php esc_html_e( 'We help your business get found on Google, in AI search and across the web. Our SEO and content strategies bring the right traffic, improve visibility and drive real business growth.', 'iweb' ); ?></p>
				<div class="cta-row">
					<a class="btn btn--primary" href="<?php echo esc_url( $iweb_contact_url ); ?>"><?php esc_html_e( 'Start a project', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
					<a class="btn btn--outline" href="<?php echo esc_url( iweb_audit_url() ); ?>"><?php echo iweb_icon( 'calendar' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'Book a free audit call', 'iweb' ); ?></a>
				</div>
				<?php /* TODO: confirm the "no long contracts" claim with Imran before publishing. */ ?>
				<p class="fine-print"><?php esc_html_e( 'No long contracts required to get started.', 'iweb' ); ?></p>
			</div>

			<div class="service-hero__visual" aria-hidden="true">
				<div class="serp-card">
					<p class="serp-card__brand"><span>G</span>oogle</p>
					<p class="serp-card__query"><?php esc_html_e( 'seo agency for small business', 'iweb' ); ?></p>
					<p class="serp-card__result-title"><?php esc_html_e( 'Your Business', 'iweb' ); ?></p>
					<p class="serp-card__result-desc"><?php esc_html_e( 'High-performance websites that help businesses grow.', 'iweb' ); ?></p>
				</div>
				<div class="ai-card">
					<p class="ai-card__title"><?php echo iweb_icon( 'sparkle' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'AI Overview', 'iweb' ); ?></p>
					<p><?php esc_html_e( 'Your business appears in AI answers with helpful, relevant content.', 'iweb' ); ?></p>
				</div>
			</div>
		</div>
	</section>

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
					<p class="eyebrow"><?php esc_html_e( 'Our SEO services', 'iweb' ); ?></p>
					<h2 class="section-title"><?php esc_html_e( 'A Complete SEO Solution for Modern Businesses', 'iweb' ); ?></h2>
				</div>
				<div>
					<p><?php esc_html_e( 'From technical SEO to content and paid ads, we cover everything you need to get found, attract the right audience and grow your business.', 'iweb' ); ?></p>
					<a class="link-arrow" href="<?php echo esc_url( $iweb_contact_url ); ?>"><?php esc_html_e( 'Talk to an SEO expert', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
				</div>
			</div>

			<div class="offer-cards">
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
		<!-- Results (hidden until real case studies exist) -->
		<section class="section section--dark service-results">
			<div class="container service-results__inner">
				<div>
					<p class="eyebrow"><?php esc_html_e( 'Real results', 'iweb' ); ?></p>
					<h2 class="section-title"><?php esc_html_e( 'Higher Rankings.', 'iweb' ); ?><br><?php esc_html_e( 'More Traffic. Real Growth.', 'iweb' ); ?></h2>
					<p><?php esc_html_e( 'We help businesses achieve sustainable growth through a combination of SEO, content and technical optimization.', 'iweb' ); ?></p>
					<a class="btn btn--light" href="<?php echo esc_url( home_url( '/our-work/' ) ); ?>"><?php esc_html_e( 'View Our Work', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
				</div>
				<ul class="results-list">
					<li><?php echo iweb_icon( 'chart' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'More visibility', 'iweb' ); ?></li>
					<li><?php echo iweb_icon( 'users' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'More customers', 'iweb' ); ?></li>
					<li><?php echo iweb_icon( 'funnel' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'Lower acquisition cost', 'iweb' ); ?></li>
					<li><?php echo iweb_icon( 'leaf' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'Long-term growth', 'iweb' ); ?></li>
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

	<?php if ( $iweb_show_case_studies ) : ?>
		<!-- Case studies (hidden until real case studies exist) -->
		<section class="section case-studies">
			<div class="container case-studies__inner">
				<div>
					<p class="eyebrow"><?php esc_html_e( 'Case studies', 'iweb' ); ?></p>
					<h2 class="section-title"><?php esc_html_e( 'Real Businesses.', 'iweb' ); ?><br><?php esc_html_e( 'Real Results.', 'iweb' ); ?></h2>
					<p><?php esc_html_e( 'We\'ve helped startups, SMBs and enterprises improve visibility, traffic and conversions.', 'iweb' ); ?></p>
					<a class="btn btn--primary" href="<?php echo esc_url( home_url( '/our-work/' ) ); ?>"><?php esc_html_e( 'View Our Work', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
				</div>
				<div class=" has-mock"><?php get_template_part( 'template-parts/ui-mock', null, array( 'variant' => 'seo' ) ); ?></div>
			</div>
		</section>
	<?php endif; ?>

	<!-- FAQ -->
	<section class="section faq">
		<div class="container faq__inner">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Frequently asked questions', 'iweb' ); ?></p>
				<h2 class="section-title"><?php esc_html_e( 'Your Questions, Answered.', 'iweb' ); ?></h2>
				<p><?php esc_html_e( 'Quick answers to common questions about our SEO services.', 'iweb' ); ?></p>
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
					<p class="eyebrow"><?php esc_html_e( 'Ready to get found?', 'iweb' ); ?></p>
					<h2><?php esc_html_e( 'Let\'s Grow Your Business with SEO.', 'iweb' ); ?></h2>
					<p><?php esc_html_e( 'Get a clear strategy, actionable recommendations and a roadmap tailored to your business.', 'iweb' ); ?></p>
				</div>
				<div>
					<div class="cta-row">
						<a class="btn btn--light" href="<?php echo esc_url( $iweb_contact_url ); ?>"><?php esc_html_e( 'Start a project', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
						<a class="btn btn--ghost-dark" href="<?php echo esc_url( iweb_audit_url() ); ?>"><?php echo iweb_icon( 'calendar' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'Book a free audit call', 'iweb' ); ?></a>
					</div>
					<p class="fine-print"><?php esc_html_e( 'No long contracts required to get started.', 'iweb' ); ?></p>
				</div>
			</div>
		</div>
	</section>

</main><!-- #primary -->

<?php
get_footer();
