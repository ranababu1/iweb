<?php
/**
 * Template Name: Our Work
 * Template Post Type: page
 *
 * All copy for the work page lives in this file. Styling lives in
 * assets/css/our-work.css, loaded only for this template.
 *
 * Projects and the client quote are supplied through filters so that only
 * real work is ever shown. With none supplied, an empty state is rendered.
 *
 * @package iweb
 * @since 1.7.0
 */

$iweb_contact_url = home_url( '/contact/' );

/**
 * Projects to list. Each item is an array with keys: category, title,
 * excerpt, url and optionally image (URL).
 *
 * @since 1.7.0
 * @param array[] $projects Projects.
 */
$iweb_projects = apply_filters( 'iweb_work_projects', array() );

/**
 * Client quote. Array with keys: quote, name, role and optionally image
 * (URL). Return an empty array to hide the block.
 *
 * @since 1.7.0
 * @param array $quote Quote data.
 */
$iweb_quote = apply_filters( 'iweb_work_quote', array() );

$iweb_points = array(
	array( 'chart', __( 'Diverse industries', 'iweb' ), __( 'Startups, SMEs and enterprise brands.', 'iweb' ) ),
	array( 'code', __( 'End-to-end delivery', 'iweb' ), __( 'Strategy, design, development and growth.', 'iweb' ) ),
	array( 'users', __( 'Long-term partnerships', 'iweb' ), __( 'Many clients work with us for years.', 'iweb' ) ),
	array( 'rocket', __( 'Measurable results', 'iweb' ), __( 'Focused on real business outcomes.', 'iweb' ) ),
);

get_header();
?>

<main id="primary" class="site-main work" tabindex="-1">

	<!-- Hero -->
	<section class="work-hero">
		<div class="container work-hero__inner">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Our work', 'iweb' ); ?></p>
				<h1 class="work-hero__title"><?php esc_html_e( 'Real projects.', 'iweb' ); ?> <span class="accent"><?php esc_html_e( 'Real business impact.', 'iweb' ); ?></span></h1>
				<p class="work-hero__lead"><?php esc_html_e( 'From high-performance websites to SEO, AI automation and custom development, here are some of the projects we\'ve delivered for clients across industries.', 'iweb' ); ?></p>
				<div class="cta-row">
					<a class="btn btn--primary" href="<?php echo esc_url( $iweb_contact_url ); ?>"><?php esc_html_e( 'Start a project', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
					<a class="btn btn--outline" href="<?php echo esc_url( $iweb_contact_url ); ?>"><?php echo iweb_icon( 'calendar' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'Book a free audit call', 'iweb' ); ?></a>
				</div>
			</div>

			<div class="work-hero__visual" aria-hidden="true">
				<span class="work-note work-note--a"><?php esc_html_e( 'Strategy', 'iweb' ); ?></span>
				<span class="work-note work-note--b"><?php esc_html_e( 'Design & Build', 'iweb' ); ?></span>
				<span class="work-note work-note--c"><?php esc_html_e( 'Optimize', 'iweb' ); ?></span>
				<span class="work-note work-note--d"><?php esc_html_e( 'Scale', 'iweb' ); ?></span>
				<div class="work-screen">
					<p><?php esc_html_e( 'Better Ideas for a Brighter Future', 'iweb' ); ?></p>
				</div>
			</div>
		</div>
	</section>

	<!-- Points -->
	<section class="trust-strip" aria-label="<?php esc_attr_e( 'What to expect', 'iweb' ); ?>">
		<ul class="container trust-strip__list">
			<?php foreach ( $iweb_points as $iweb_p ) : ?>
				<li class="trust-item">
					<?php echo iweb_icon( $iweb_p[0] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<span><strong><?php echo esc_html( $iweb_p[1] ); ?></strong> <?php echo esc_html( $iweb_p[2] ); ?></span>
				</li>
			<?php endforeach; ?>
		</ul>
	</section>

	<!-- Projects -->
	<section class="section">
		<div class="container">
			<div class="section-head section-head--split">
				<div>
					<p class="eyebrow"><?php esc_html_e( 'Featured work', 'iweb' ); ?></p>
					<h2 class="section-title"><?php esc_html_e( 'Selected Projects', 'iweb' ); ?></h2>
				</div>
				<p><?php esc_html_e( 'A quick look at some of our recent work. Each project is unique, but the goal is always the same — help our clients grow.', 'iweb' ); ?></p>
			</div>

			<?php if ( $iweb_projects ) : ?>
				<div class="project-cards">
					<?php foreach ( $iweb_projects as $iweb_project ) : ?>
						<article class="project-card">
							<a class="project-card__media" href="<?php echo esc_url( $iweb_project['url'] ); ?>" tabindex="-1" aria-hidden="true">
								<?php if ( ! empty( $iweb_project['image'] ) ) : ?>
									<img src="<?php echo esc_url( $iweb_project['image'] ); ?>" alt="" loading="lazy">
								<?php endif; ?>
							</a>
							<div class="project-card__body">
								<p class="project-card__cat"><?php echo esc_html( $iweb_project['category'] ); ?></p>
								<h3><a href="<?php echo esc_url( $iweb_project['url'] ); ?>"><?php echo esc_html( $iweb_project['title'] ); ?></a></h3>
								<p><?php echo esc_html( $iweb_project['excerpt'] ); ?></p>
								<span class="project-card__arrow"><?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
			<?php else : ?>
				<div class="work-empty visual-placeholder">
					<?php echo iweb_icon( 'image' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<p><?php esc_html_e( 'Case studies are on their way. Want to talk about your project in the meantime?', 'iweb' ); ?></p>
					<a class="btn btn--primary" href="<?php echo esc_url( $iweb_contact_url ); ?>"><?php esc_html_e( 'Start a project', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<?php if ( $iweb_quote ) : ?>
		<!-- Client feedback -->
		<section class="container work-quote-wrap">
			<figure class="work-quote">
				<div>
					<p class="eyebrow"><?php esc_html_e( 'Client feedback', 'iweb' ); ?></p>
					<blockquote><p>“<?php echo esc_html( $iweb_quote['quote'] ); ?>”</p></blockquote>
				</div>
				<figcaption>
					<?php if ( ! empty( $iweb_quote['image'] ) ) : ?>
						<img src="<?php echo esc_url( $iweb_quote['image'] ); ?>" alt="" width="72" height="72" loading="lazy">
					<?php endif; ?>
					<span><strong><?php echo esc_html( $iweb_quote['name'] ); ?></strong><br><?php echo esc_html( $iweb_quote['role'] ); ?></span>
				</figcaption>
			</figure>
		</section>
	<?php endif; ?>

	<!-- Closing CTA -->
	<section class="section section--dark cta-band work-cta">
		<div class="container work-cta__inner">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Ready to grow?', 'iweb' ); ?></p>
				<h2><?php esc_html_e( 'Let\'s build something great together.', 'iweb' ); ?></h2>
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
