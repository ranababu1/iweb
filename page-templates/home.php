<?php
/**
 * Template Name: Home
 * Template Post Type: page
 *
 * All homepage copy lives in this file. Layout and styling live in
 * assets/css/home.css, which is only loaded for this template.
 *
 * @package iweb
 * @since 1.1.0
 */

/**
 * Show the featured work section. Keep false until real case studies exist.
 *
 * @since 1.1.0
 * @param bool $show Whether to render the section.
 */
$iweb_show_case_studies = apply_filters( 'iweb_show_case_studies', false );

$iweb_contact_url = home_url( '/contact/' );

$iweb_services = array(
	array(
		'tone'  => 'green',
		'icon'  => 'search',
		'title' => __( 'Get found', 'iweb' ),
		'blurb' => __( 'Show up on Google and in AI answers.', 'iweb' ),
		'url'   => home_url( '/services/get-found/' ),
		'items' => array(
			__( 'SEO Services', 'iweb' ),
			__( 'AEO / GEO (AI Search)', 'iweb' ),
			__( 'Technical SEO', 'iweb' ),
			__( 'Content & Blogging', 'iweb' ),
			__( 'Paid Ads (PPC)', 'iweb' ),
		),
	),
	array(
		'tone'  => 'orange',
		'icon'  => 'cursor',
		'title' => __( 'Turn visitors into customers', 'iweb' ),
		'blurb' => __( 'Fast sites built to convert.', 'iweb' ),
		'url'   => home_url( '/services/turn-visitors-into-customers/' ),
		'items' => array(
			__( 'WordPress Development', 'iweb' ),
			__( 'WooCommerce', 'iweb' ),
			__( 'Site Speed Optimization', 'iweb' ),
			__( 'UX & UI Design', 'iweb' ),
			__( 'Conversion Rate Optimization', 'iweb' ),
		),
	),
	array(
		'tone'  => 'blue',
		'icon'  => 'gear',
		'title' => __( 'Automate the busywork', 'iweb' ),
		'blurb' => __( 'AI that saves your team hours.', 'iweb' ),
		'url'   => home_url( '/services/automate-the-busywork/' ),
		'items' => array(
			__( 'AI Chatbots', 'iweb' ),
			__( 'Workflow Automation', 'iweb' ),
			__( 'AI Integrations', 'iweb' ),
			__( 'Custom AI Solutions', 'iweb' ),
		),
	),
	array(
		'tone'  => 'purple',
		'icon'  => 'chart',
		'title' => __( 'Know what\'s working', 'iweb' ),
		'blurb' => __( 'Tracking and reports you can trust.', 'iweb' ),
		'url'   => home_url( '/services/know-whats-working/' ),
		'items' => array(
			__( 'GA4 Setup & Reporting', 'iweb' ),
			__( 'Tag Manager', 'iweb' ),
			__( 'Conversion Tracking', 'iweb' ),
			__( 'Custom Dashboards', 'iweb' ),
			__( 'Performance Insights', 'iweb' ),
		),
	),
);

$iweb_trust = array(
	array( 'clock', '15+', __( 'Years of Experience', 'iweb' ) ),
	array( 'layers', '500+', __( 'Projects Delivered', 'iweb' ) ),
	array( 'globe', __( 'Global', 'iweb' ), __( 'Client Base', 'iweb' ) ),
	array( 'layers', __( 'End-to-End', 'iweb' ), __( 'Digital Solutions', 'iweb' ) ),
);

$iweb_steps = array(
	array( 'green', 'bulb', __( 'Understand', 'iweb' ), __( 'We learn about your goals and requirements.', 'iweb' ) ),
	array( 'orange', 'doc', __( 'Plan', 'iweb' ), __( 'We create a clear strategy and roadmap.', 'iweb' ) ),
	array( 'blue', 'code', __( 'Build', 'iweb' ), __( 'We design and develop your solution.', 'iweb' ) ),
	array( 'purple', 'chart', __( 'Grow', 'iweb' ), __( 'We support, optimize and help you scale.', 'iweb' ) ),
);

$iweb_numbers = array(
	array( '15+', __( 'Years in Business', 'iweb' ) ),
	array( '500+', __( 'Projects Delivered', 'iweb' ) ),
	array( '200+', __( 'Happy Clients', 'iweb' ) ),
	array( '95%', __( 'Client Retention', 'iweb' ) ),
);

get_header();
?>

<main id="primary" class="site-main home" tabindex="-1">

	<!-- Hero -->
	<section class="home-hero">
		<div class="container home-hero__inner">
			<div class="home-hero__copy">
				<p class="eyebrow"><?php esc_html_e( 'Grow. Optimize. Scale.', 'iweb' ); ?></p>
				<h1 class="home-hero__title">
					<?php esc_html_e( 'Get found.', 'iweb' ); ?><br>
					<?php esc_html_e( 'Win customers.', 'iweb' ); ?><br>
					<span class="accent"><?php esc_html_e( 'Scale without the busywork.', 'iweb' ); ?></span>
				</h1>
				<p class="home-hero__lead"><?php esc_html_e( 'iWebAndSEO builds high-performance WordPress sites and grows them with technical SEO, CRO and AI-ready content. Then we automate the repetitive work and show you what\'s actually driving results.', 'iweb' ); ?></p>
				<div class="cta-row">
					<a class="btn btn--primary" href="<?php echo esc_url( $iweb_contact_url ); ?>"><?php esc_html_e( 'Start a project', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
					<a class="btn btn--outline" href="<?php echo esc_url( $iweb_contact_url ); ?>"><?php echo iweb_icon( 'calendar' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'Book a free audit call', 'iweb' ); ?></a>
				</div>
				<?php /* TODO: confirm the "no long contracts" claim with Imran before publishing. */ ?>
				<p class="fine-print"><?php esc_html_e( 'No long contracts required to get started.', 'iweb' ); ?></p>
			</div>

			<div class="home-hero__visual" aria-hidden="true">
				<div class="hero-browser">
					<div class="hero-browser__bar"><span></span><span></span><span></span></div>
					<div class="hero-browser__body">
						<p class="hero-browser__kicker"><?php esc_html_e( 'Ideas into', 'iweb' ); ?></p>
						<p class="hero-browser__title"><?php esc_html_e( 'Real Business Growth', 'iweb' ); ?></p>
						<div class="hero-browser__scene"></div>
					</div>
				</div>
				<ul class="hero-checks">
					<li><?php echo iweb_icon( 'check' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'Better visibility', 'iweb' ); ?></li>
					<li><?php echo iweb_icon( 'check' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'More customers', 'iweb' ); ?></li>
					<li><?php echo iweb_icon( 'check' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'Less manual work', 'iweb' ); ?></li>
				</ul>
			</div>
		</div>
	</section>

	<!-- Trust strip -->
	<section class="trust-strip" aria-label="<?php esc_attr_e( 'At a glance', 'iweb' ); ?>">
		<ul class="container trust-strip__list">
			<?php foreach ( $iweb_trust as $iweb_item ) : ?>
				<li class="trust-item">
					<?php echo iweb_icon( $iweb_item[0] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<span><strong><?php echo esc_html( $iweb_item[1] ); ?></strong> <?php echo esc_html( $iweb_item[2] ); ?></span>
				</li>
			<?php endforeach; ?>
		</ul>
	</section>

	<!-- Services -->
	<section id="services" class="section">
		<div class="container">
			<div class="section-head section-head--split">
				<div>
					<p class="eyebrow"><?php esc_html_e( 'Our services', 'iweb' ); ?></p>
					<h2 class="section-title"><?php esc_html_e( 'Digital Solutions', 'iweb' ); ?><br><?php esc_html_e( 'Built Around', 'iweb' ); ?> <span class="accent"><?php esc_html_e( 'Your Goals', 'iweb' ); ?></span></h2>
				</div>
				<div>
					<p><?php esc_html_e( 'From high-converting websites to AI automation, we deliver solutions that help you attract visitors, win customers and grow – without the complexity.', 'iweb' ); ?></p>
					<a class="link-arrow" href="<?php echo esc_url( home_url( '/services/' ) ); ?>"><?php esc_html_e( 'Explore All Services', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
				</div>
			</div>

			<div class="service-cards">
				<?php foreach ( $iweb_services as $iweb_service ) : ?>
					<article class="service-card tone-<?php echo esc_attr( $iweb_service['tone'] ); ?>">
						<span class="icon-tile"><?php echo iweb_icon( $iweb_service['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
						<h3><?php echo esc_html( $iweb_service['title'] ); ?></h3>
						<p class="service-card__blurb"><?php echo esc_html( $iweb_service['blurb'] ); ?></p>
						<ul class="service-card__list">
							<?php foreach ( $iweb_service['items'] as $iweb_li ) : ?>
								<li><?php echo esc_html( $iweb_li ); ?></li>
							<?php endforeach; ?>
						</ul>
						<a class="link-arrow" href="<?php echo esc_url( $iweb_service['url'] ); ?>"><?php esc_html_e( 'Learn More', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
					</article>
				<?php endforeach; ?>
			</div>

			<div class="custom-dev tone-blue">
				<span class="icon-tile"><?php echo iweb_icon( 'code' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
				<div>
					<h3><?php esc_html_e( 'Custom development', 'iweb' ); ?> <span class="custom-dev__tech"><?php esc_html_e( '(.NET, Java, APIs)', 'iweb' ); ?></span></h3>
					<p><?php esc_html_e( 'Build custom software and integrations for your unique business needs.', 'iweb' ); ?></p>
				</div>
				<a class="link-arrow" href="<?php echo esc_url( home_url( '/services/custom-development/' ) ); ?>"><?php esc_html_e( 'Learn More', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
			</div>
		</div>
	</section>

	<?php if ( $iweb_show_case_studies ) : ?>
		<!-- Featured work (hidden until real case studies exist) -->
		<section class="section section--dark featured-work">
			<div class="container featured-work__inner">
				<div>
					<p class="eyebrow"><?php esc_html_e( 'Featured work', 'iweb' ); ?></p>
					<h2 class="section-title"><?php esc_html_e( 'Real Projects.', 'iweb' ); ?><br><?php esc_html_e( 'Real Results.', 'iweb' ); ?></h2>
					<p class="featured-work__lead"><?php esc_html_e( 'We help businesses turn ideas into digital products that drive measurable growth.', 'iweb' ); ?></p>
					<a class="btn btn--light" href="<?php echo esc_url( home_url( '/work/' ) ); ?>"><?php esc_html_e( 'View Our Work', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
				</div>
				<div class="featured-work__visual visual-placeholder" aria-hidden="true"><?php echo iweb_icon( 'image' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
			</div>
		</section>
	<?php endif; ?>

	<!-- Process -->
	<section id="process" class="section process">
		<div class="container">
			<div class="process__head">
				<div>
					<p class="eyebrow"><?php esc_html_e( 'How we work', 'iweb' ); ?></p>
					<h2 class="section-title"><?php esc_html_e( 'A Simple Process.', 'iweb' ); ?><br><?php esc_html_e( 'Real Partnership.', 'iweb' ); ?></h2>
					<p><?php esc_html_e( 'We keep things clear, collaborative and focused on results. From strategy to support, you\'ll always know what\'s happening.', 'iweb' ); ?></p>
					<a class="btn btn--primary" href="<?php echo esc_url( home_url( '/#process' ) ); ?>"><?php esc_html_e( 'See how we work', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
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

			<ul class="numbers">
				<?php foreach ( $iweb_numbers as $iweb_n ) : ?>
					<li><strong><?php echo esc_html( $iweb_n[0] ); ?></strong> <span><?php echo esc_html( $iweb_n[1] ); ?></span></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<!-- Closing CTA -->
	<section class="home-cta section section--dark cta-band">
		<div class="container home-cta__inner">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Let\'s build together', 'iweb' ); ?></p>
				<h2><?php esc_html_e( 'Ready to Grow Your Business?', 'iweb' ); ?></h2>
				<p><?php esc_html_e( 'Whether it\'s a website, SEO, AI automation or custom software, let\'s turn your ideas into real results.', 'iweb' ); ?></p>
				<div class="cta-row">
					<a class="btn btn--light" href="<?php echo esc_url( $iweb_contact_url ); ?>"><?php esc_html_e( 'Start a project', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
					<a class="btn btn--ghost-dark" href="<?php echo esc_url( $iweb_contact_url ); ?>"><?php echo iweb_icon( 'calendar' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'Book a free audit call', 'iweb' ); ?></a>
				</div>
			</div>
		</div>
	</section>

	<!-- Latest insights -->
	<?php
	$iweb_insights = new WP_Query(
		array(
			'posts_per_page'      => 3,
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
		)
	);

	if ( $iweb_insights->have_posts() ) :
		?>
		<section class="section insights">
			<div class="container">
				<div class="section-head section-head--split">
					<div>
						<p class="eyebrow"><?php esc_html_e( 'Latest insights', 'iweb' ); ?></p>
						<h2 class="section-title"><?php esc_html_e( 'Tips, Guides and Ideas for Growth', 'iweb' ); ?></h2>
						<p><?php esc_html_e( 'Stay updated with practical insights on web development, SEO, AI and more.', 'iweb' ); ?></p>
					</div>
					<a class="link-arrow" href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"><?php esc_html_e( 'View All Articles', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
				</div>

				<div class="insight-cards">
					<?php
					while ( $iweb_insights->have_posts() ) :
						$iweb_insights->the_post();
						$iweb_cats = get_the_category();
						?>
						<article class="insight-card">
							<a class="insight-card__media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
								<?php
								if ( has_post_thumbnail() ) {
									the_post_thumbnail( 'medium_large', array( 'loading' => 'lazy' ) );
								}
								?>
							</a>
							<div class="insight-card__body">
								<?php if ( $iweb_cats ) : ?>
									<p class="insight-card__cat"><?php echo esc_html( $iweb_cats[0]->name ); ?></p>
								<?php endif; ?>
								<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<p class="insight-card__meta">
									<?php echo esc_html( get_the_date() ); ?> ·
									<?php
									/* translators: %d: reading time in minutes. */
									echo esc_html( sprintf( __( '%d min read', 'iweb' ), max( 1, (int) ceil( str_word_count( wp_strip_all_tags( get_the_content() ) ) / 220 ) ) ) );
									?>
								</p>
							</div>
						</article>
					<?php endwhile; ?>
				</div>
			</div>
		</section>
		<?php
		wp_reset_postdata();
	endif;
	?>

</main><!-- #primary -->

<?php
get_footer();
