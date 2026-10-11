<?php
/**
 * Template Name: How We Work
 * Template Post Type: page
 *
 * All copy for the "How we work" page lives in this file. Styling lives in
 * assets/css/how-we-work.css, loaded only for this template.
 *
 * @package iweb
 * @since 1.6.0
 */

$iweb_contact_url = home_url( '/contact/' );

$iweb_principles = array(
	array( 'shield', __( 'Outcome Focused', 'iweb' ), __( 'Every project starts with your business goals.', 'iweb' ) ),
	array( 'chat', __( 'Transparent Communication', 'iweb' ), __( 'Regular updates, clear next steps and no surprises.', 'iweb' ) ),
	array( 'users', __( 'Collaborative Approach', 'iweb' ), __( 'We work as an extension of your team.', 'iweb' ) ),
	array( 'chart', __( 'Long-Term Partnership', 'iweb' ), __( 'We don\'t just deliver and leave. We help you grow.', 'iweb' ) ),
);

$iweb_steps = array(
	array( 'green', 'search', __( 'Understand', 'iweb' ), __( 'We learn about your business, goals, audience, current setup and challenges.', 'iweb' ), __( 'Requirements, opportunities and clear goals.', 'iweb' ) ),
	array( 'orange', 'doc', __( 'Plan', 'iweb' ), __( 'We define the right strategy, solution and roadmap tailored to your needs.', 'iweb' ), __( 'Project plan, timeline and technical approach.', 'iweb' ) ),
	array( 'blue', 'code', __( 'Build', 'iweb' ), __( 'We design, develop, implement and test the solution with regular updates.', 'iweb' ), __( 'Working solution in a staging environment.', 'iweb' ) ),
	array( 'purple', 'chart', __( 'Launch & Grow', 'iweb' ), __( 'We deploy to live, monitor performance and keep optimizing.', 'iweb' ), __( 'A fast, reliable and scalable solution with ongoing support.', 'iweb' ) ),
);

$iweb_board = array(
	__( 'Plan', 'iweb' )   => array( __( 'Discovery & Goals', 'iweb' ), __( 'Strategy & Roadmap', 'iweb' ), __( 'Technical Planning', 'iweb' ) ),
	__( 'Build', 'iweb' )  => array( __( 'Design & Development', 'iweb' ), __( 'Content & SEO', 'iweb' ), __( 'Integrations & Testing', 'iweb' ) ),
	__( 'Review', 'iweb' ) => array( __( 'Client Review', 'iweb' ), __( 'Feedback & Iteration', 'iweb' ), __( 'Performance Checks', 'iweb' ) ),
	__( 'Launch', 'iweb' ) => array( __( 'Deploy to Live', 'iweb' ), __( 'Monitor & Optimize', 'iweb' ), __( 'Ongoing Support', 'iweb' ) ),
);

$iweb_tools = array(
	'WordPress',
	'WooCommerce',
	'PHP',
	'.NET',
	'Node.js',
	'Python',
	'AWS',
	'Google Cloud',
	'Azure',
	'Figma',
);

$iweb_expect = array(
	__( 'Dedicated point of contact', 'iweb' ),
	__( 'Regular updates and demos', 'iweb' ),
	__( 'Clear timelines and milestones', 'iweb' ),
	__( 'Quality testing and performance checks', 'iweb' ),
	__( 'Support after launch', 'iweb' ),
	__( 'A focus on long-term growth', 'iweb' ),
);

get_header();
?>

<main id="primary" class="site-main hww" tabindex="-1">

	<!-- Hero -->
	<section class="hww-hero">
		<div class="container hww-hero__inner">
			<div>
				<nav class="breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'iweb' ); ?>">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'iweb' ); ?></a> ›
					<span aria-current="page"><?php esc_html_e( 'How we work', 'iweb' ); ?></span>
				</nav>
				<p class="eyebrow"><?php esc_html_e( 'A clear and collaborative process', 'iweb' ); ?></p>
				<h1 class="hww-hero__title"><?php esc_html_e( 'From idea to impact.', 'iweb' ); ?> <span class="accent"><?php esc_html_e( 'A process built around your goals.', 'iweb' ); ?></span></h1>
				<p class="hww-hero__lead"><?php esc_html_e( 'We keep things simple, transparent and focused on outcomes. Whether it\'s a new website, SEO growth or AI automation, we follow a proven process to deliver real results.', 'iweb' ); ?></p>
				<div class="cta-row">
					<a class="btn btn--primary" href="<?php echo esc_url( $iweb_contact_url ); ?>"><?php esc_html_e( 'Start a project', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
					<a class="btn btn--outline" href="<?php echo esc_url( iweb_audit_url() ); ?>"><?php echo iweb_icon( 'calendar' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'Book a free audit call', 'iweb' ); ?></a>
				</div>
				<?php /* TODO: confirm the "no long contracts" claim with Imran before publishing. */ ?>
				<p class="fine-print"><?php esc_html_e( 'No long contracts required to get started.', 'iweb' ); ?></p>
			</div>

			<div class="hww-hero__visual" aria-hidden="true">
				<div class="board">
					<?php foreach ( $iweb_board as $iweb_col => $iweb_cards ) : ?>
						<div class="board__col">
							<p class="board__title"><?php echo esc_html( $iweb_col ); ?></p>
							<?php foreach ( $iweb_cards as $iweb_card ) : ?>
								<p class="board__card"><?php echo esc_html( $iweb_card ); ?></p>
							<?php endforeach; ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</section>

	<!-- Principles -->
	<section class="trust-strip" aria-label="<?php esc_attr_e( 'Our principles', 'iweb' ); ?>">
		<ul class="container trust-strip__list">
			<?php foreach ( $iweb_principles as $iweb_p ) : ?>
				<li class="trust-item">
					<?php echo iweb_icon( $iweb_p[0] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<span><strong><?php echo esc_html( $iweb_p[1] ); ?></strong> <?php echo esc_html( $iweb_p[2] ); ?></span>
				</li>
			<?php endforeach; ?>
		</ul>
	</section>

	<!-- Process -->
	<section class="section">
		<div class="container">
			<div class="section-head section-head--split">
				<div>
					<p class="eyebrow"><?php esc_html_e( 'Our process', 'iweb' ); ?></p>
					<h2 class="section-title"><?php esc_html_e( 'A Simple, Transparent Process', 'iweb' ); ?></h2>
					<p class="hww-sub"><?php esc_html_e( 'A proven 4-step process from discovery to ongoing growth.', 'iweb' ); ?></p>
				</div>
				<p><?php esc_html_e( 'We combine strategic thinking, technical expertise and clear communication to deliver solutions that create real business impact.', 'iweb' ); ?></p>
			</div>

			<ol class="hww-steps">
				<?php foreach ( $iweb_steps as $iweb_i => $iweb_step ) : ?>
					<li class="hww-step tone-<?php echo esc_attr( $iweb_step[0] ); ?>">
						<div class="process-step">
							<span class="icon-tile"><?php echo iweb_icon( $iweb_step[1] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
							<span class="process-step__num"><?php echo esc_html( sprintf( '%02d', $iweb_i + 1 ) ); ?></span>
							<h3><?php echo esc_html( $iweb_step[2] ); ?></h3>
							<p><?php echo esc_html( $iweb_step[3] ); ?></p>
						</div>
						<div class="hww-output">
							<p class="hww-output__label"><?php esc_html_e( 'Key output:', 'iweb' ); ?></p>
							<p><?php echo esc_html( $iweb_step[4] ); ?></p>
						</div>
					</li>
				<?php endforeach; ?>
			</ol>
		</div>
	</section>

	<!-- Tools -->
	<section class="container hww-tools">
		<div class="hww-tools__box">
			<div class="hww-tools__head">
				<div>
					<p class="eyebrow"><?php esc_html_e( 'Tools & technologies', 'iweb' ); ?></p>
					<h2 class="section-title"><?php esc_html_e( 'Modern Tools. Proven Stack.', 'iweb' ); ?></h2>
					<p><?php esc_html_e( 'We use the right tools for the right job. Our tech stack is modern, flexible and scalable.', 'iweb' ); ?></p>
				</div>
				<a class="link-arrow" href="<?php echo esc_url( home_url( '/services/' ) ); ?>"><?php esc_html_e( 'See all services', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
			</div>
			<?php /* Swap these text tiles for official logos in assets/images when available. */ ?>
			<ul class="tool-grid">
				<?php foreach ( $iweb_tools as $iweb_tool ) : ?>
					<li><?php echo esc_html( $iweb_tool ); ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<!-- What to expect -->
	<section class="section">
		<div class="container hww-expect">
			<div class="hww-expect__copy">
				<p class="eyebrow"><?php esc_html_e( 'Working together', 'iweb' ); ?></p>
				<h2 class="section-title"><?php esc_html_e( 'What You Can Expect', 'iweb' ); ?></h2>
				<p><?php esc_html_e( 'We keep the process clear and collaborative, so you always know what\'s happening and what\'s next.', 'iweb' ); ?></p>
				<ul class="check-list">
					<?php foreach ( $iweb_expect as $iweb_e ) : ?>
						<li><span class="check-list__icon"><?php echo iweb_icon( 'check' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span> <?php echo esc_html( $iweb_e ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>

			<div class="hww-expect__visual visual-placeholder" aria-hidden="true"><?php echo iweb_icon( 'users' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>

			<aside class="hww-expect__cta">
				<p class="eyebrow"><?php esc_html_e( 'Let\'s work together', 'iweb' ); ?></p>
				<h3><?php esc_html_e( 'Have a Project in Mind?', 'iweb' ); ?></h3>
				<p><?php esc_html_e( 'Tell us about your goals and we\'ll suggest the best way forward.', 'iweb' ); ?></p>
				<a class="btn btn--primary" href="<?php echo esc_url( $iweb_contact_url ); ?>"><?php esc_html_e( 'Start a project', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
				<a class="btn btn--outline" href="<?php echo esc_url( iweb_audit_url() ); ?>"><?php echo iweb_icon( 'calendar' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'Book a free audit call', 'iweb' ); ?></a>
			</aside>
		</div>
	</section>

</main><!-- #primary -->

<?php
get_footer();
