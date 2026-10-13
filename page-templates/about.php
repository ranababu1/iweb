<?php
/**
 * Template Name: About
 * Template Post Type: page
 *
 * All copy for the About page lives in this file. Styling lives in
 * assets/css/about.css, loaded only for this template. The hero portrait is
 * the page's featured image.
 *
 * @package iweb
 * @since 1.9.0
 */

$iweb_contact_url = home_url( '/contact' );

$iweb_facts = array(
	array( 'trophy', '14+', __( 'Years of experience', 'iweb' ) ),
	array( 'users', '100+', __( 'Projects delivered', 'iweb' ) ),
	array( 'globe', __( 'Clients across 10+ countries', 'iweb' ), '' ),
	array( 'rocket', __( 'Focus on long-term growth and results', 'iweb' ), '' ),
);

$iweb_values = array(
	array( 'users', __( 'Client first', 'iweb' ), __( 'Your goals come first. We focus on solutions that create real value.', 'iweb' ) ),
	array( 'bulb', __( 'Practical approach', 'iweb' ), __( 'We keep things simple, focused and results driven.', 'iweb' ) ),
	array( 'chart', __( 'Long-term thinking', 'iweb' ), __( 'We build for sustainable growth, not just short-term wins.', 'iweb' ) ),
	array( 'shield', __( 'Transparency', 'iweb' ), __( 'Clear communication, honest advice and reliable delivery.', 'iweb' ) ),
);

$iweb_skills = array(
	array( 'layers', __( 'CMS and websites', 'iweb' ), __( 'Custom builds and optimization', 'iweb' ) ),
	array( 'search', __( 'SEO', 'iweb' ), __( 'Technical SEO, content and strategy', 'iweb' ) ),
	array( 'code', __( 'Custom Development', 'iweb' ), __( '.NET, APIs and integrations', 'iweb' ) ),
	array( 'gear', __( 'AI & Automation', 'iweb' ), __( 'AI chatbots, workflow automation and integrations', 'iweb' ) ),
	array( 'chart', __( 'Analytics & CRO', 'iweb' ), __( 'Tracking, reporting and conversion optimization', 'iweb' ) ),
	array( 'cloud', __( 'Cloud & DevOps', 'iweb' ), __( 'Deployment, performance and security', 'iweb' ) ),
);

$iweb_reasons = array(
	array( 'trophy', __( 'Real-world experience', 'iweb' ), __( '14+ years working on complex digital projects across industries.', 'iweb' ) ),
	array( 'users', __( 'Support from start to finish', 'iweb' ), __( 'From strategy and development to SEO, automation and ongoing optimization.', 'iweb' ) ),
	array( 'target', __( 'Focused on results', 'iweb' ), __( 'We measure success by your business growth and real outcomes.', 'iweb' ) ),
	array( 'check', __( 'A long-term partner', 'iweb' ), __( 'We stick around after launch, not just for a one-time project.', 'iweb' ) ),
);

get_header();
?>

<main id="primary" class="site-main about" tabindex="-1">

	<?php
	while ( have_posts() ) :
		the_post();
		?>

	<!-- Hero -->
	<section class="about-hero">
		<div class="container about-hero__inner">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'About IWS', 'iweb' ); ?></p>
				<h1 class="about-hero__title"><?php esc_html_e( 'Building digital experiences that', 'iweb' ); ?> <span class="accent"><?php esc_html_e( 'create real value.', 'iweb' ); ?></span></h1>
				<p class="about-hero__lead"><?php esc_html_e( 'We help businesses grow with high-performance websites, SEO, AI automation and custom development, combining strategy, technology and practical execution.', 'iweb' ); ?></p>
				<div class="cta-row">
					<a class="btn btn--light" href="<?php echo esc_url( $iweb_contact_url ); ?>"><?php esc_html_e( 'Start a project', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
					<a class="btn btn--outline" href="<?php echo esc_url( iweb_audit_url() ); ?>"><?php echo iweb_icon( 'calendar' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'Book a free audit call', 'iweb' ); ?></a>
				</div>
			</div>

			<div class="about-hero__visual has-mock">
				<?php get_template_part( 'template-parts/ui-mock', null, array( 'variant' => 'stack' ) ); ?>
			</div>
		</div>
	</section>

	<!-- Story -->
	<section class="section about-story">
		<div class="container about-story__inner">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'My story', 'iweb' ); ?></p>
				<h2 class="section-title"><?php esc_html_e( 'From developer to digital growth partner.', 'iweb' ); ?></h2>
				<p><?php esc_html_e( 'I\'m Imran, the founder of IWS. With 14+ years of experience in web development, SEO and digital solutions, I\'ve had the chance to work with startups, SMEs and enterprise brands across industries.', 'iweb' ); ?></p>
				<p><?php esc_html_e( 'IWS started with a simple idea, to help businesses use technology in a practical way to get found, win customers and operate more efficiently.', 'iweb' ); ?></p>
				<p><?php esc_html_e( 'Today, we work with clients globally, combining technical expertise with a deep understanding of business goals to deliver measurable results.', 'iweb' ); ?></p>
			</div>
			<div class="about-story__visual has-mock"><?php get_template_part( 'template-parts/ui-mock', null, array( 'variant' => 'code' ) ); ?></div>
		</div>
	</section>

	<!-- Values -->
	<section class="container">
		<div class="about-values">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Our values', 'iweb' ); ?></p>
				<h2 class="section-title"><?php esc_html_e( 'What we believe in.', 'iweb' ); ?></h2>
			</div>
			<?php foreach ( $iweb_values as $iweb_v ) : ?>
				<div class="about-value">
					<span class="about-badge"><?php echo iweb_icon( $iweb_v[0] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<h3><?php echo esc_html( $iweb_v[1] ); ?></h3>
					<p><?php echo esc_html( $iweb_v[2] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</section>

	<!-- Expertise -->
	<section class="section">
		<div class="container">
			<div class="section-head section-head--split">
				<div>
					<p class="eyebrow"><?php esc_html_e( 'Our expertise', 'iweb' ); ?></p>
					<h2 class="section-title"><?php esc_html_e( 'A unique mix of skills and experience.', 'iweb' ); ?></h2>
				</div>
				<p><?php esc_html_e( 'We bring together strategy, design, development, SEO and AI automation to deliver complete digital solutions for modern businesses.', 'iweb' ); ?></p>
			</div>
			<ul class="skills">
				<?php foreach ( $iweb_skills as $iweb_skill ) : ?>
					<li>
						<?php echo iweb_icon( $iweb_skill[0] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<strong><?php echo esc_html( $iweb_skill[1] ); ?></strong>
						<span><?php echo esc_html( $iweb_skill[2] ); ?></span>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<!-- Why choose us -->
	<section class="section about-why">
		<div class="container">
			<div class="section-head section-head--split">
				<div>
					<p class="eyebrow"><?php esc_html_e( 'Why choose IWS', 'iweb' ); ?></p>
					<h2 class="section-title"><?php esc_html_e( 'More than just a service provider.', 'iweb' ); ?></h2>
				</div>
				<p><?php esc_html_e( 'We combine technical expertise with business understanding to deliver solutions that actually make a difference.', 'iweb' ); ?></p>
			</div>
			<div class="reasons">
				<?php foreach ( $iweb_reasons as $iweb_r ) : ?>
					<article class="reason">
						<span class="reason__icon"><?php echo iweb_icon( $iweb_r[0] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
						<div>
							<h3><?php echo esc_html( $iweb_r[1] ); ?></h3>
							<p><?php echo esc_html( $iweb_r[2] ); ?></p>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- Closing CTA -->
	<section class="section section--dark cta-band about-cta">
		<div class="container about-cta__inner">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Ready to work together?', 'iweb' ); ?></p>
				<h2><?php esc_html_e( 'Let\'s build something great.', 'iweb' ); ?></h2>
			</div>
			<div class="cta-row">
				<a class="btn btn--light" href="<?php echo esc_url( $iweb_contact_url ); ?>"><?php esc_html_e( 'Start a project', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
				<a class="btn btn--ghost-dark" href="<?php echo esc_url( iweb_audit_url() ); ?>"><?php echo iweb_icon( 'calendar' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'Book a free audit call', 'iweb' ); ?></a>
			</div>
		</div>
	</section>

	<?php endwhile; ?>

</main><!-- #primary -->

<?php
get_footer();
