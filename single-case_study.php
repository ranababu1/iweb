<?php
/**
 * The template for a single case study.
 *
 * Content comes from the case_study post type (see inc/case-studies.php).
 * Sections without data are not rendered. Styling lives in
 * assets/css/case-study.css, loaded only on case studies.
 *
 * @package iweb
 * @since 1.8.0
 */

$iweb_contact_url = home_url( '/contact/' );

get_header();

while ( have_posts() ) :
	the_post();

	$iweb_stats     = iweb_cs_stats();
	$iweb_delivered = iweb_cs_lines( iweb_cs_field( 'cs_delivered' ) );
	$iweb_challenge = iweb_cs_field( 'cs_challenge' );
	$iweb_solution  = iweb_cs_field( 'cs_solution' );
	$iweb_quote     = iweb_cs_field( 'cs_quote' );
	$iweb_facts     = array_filter(
		array(
			array( 'layers', __( 'Client', 'iweb' ), iweb_cs_field( 'cs_client' ) ),
			array( 'globe', __( 'Industry', 'iweb' ), iweb_cs_field( 'cs_industry' ) ),
			array( 'gear', __( 'Services', 'iweb' ), iweb_cs_field( 'cs_services' ) ),
			array( 'code', __( 'Platform', 'iweb' ), iweb_cs_field( 'cs_platform' ) ),
			array( 'calendar', __( 'Duration', 'iweb' ), iweb_cs_field( 'cs_duration' ) ),
		),
		static function ( $fact ) {
			return '' !== $fact[2];
		}
	);

	$iweb_related = new WP_Query(
		array(
			'post_type'      => 'case_study',
			'posts_per_page' => 3,
			'post__not_in'   => array( get_the_ID() ),
			'no_found_rows'  => true,
		)
	);
	?>

<main id="primary" class="site-main cs" tabindex="-1">

	<!-- Hero -->
	<section class="cs-hero">
		<div class="container cs-hero__inner">
			<div>
				<nav class="breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'iweb' ); ?>">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'iweb' ); ?></a> ›
					<a href="<?php echo esc_url( home_url( '/work/' ) ); ?>"><?php esc_html_e( 'Work', 'iweb' ); ?></a> ›
					<span aria-current="page"><?php the_title(); ?></span>
				</nav>
				<?php if ( iweb_cs_field( 'cs_category' ) ) : ?>
					<p class="eyebrow"><?php echo esc_html( iweb_cs_field( 'cs_category' ) ); ?></p>
				<?php endif; ?>
				<h1 class="cs-hero__title"><?php the_title(); ?></h1>
				<?php if ( has_excerpt() ) : ?>
					<p class="cs-hero__lead"><?php echo esc_html( get_the_excerpt() ); ?></p>
				<?php endif; ?>

				<?php if ( $iweb_stats ) : ?>
					<ul class="cs-hero__stats">
						<?php foreach ( array_slice( $iweb_stats, 0, 3 ) as $iweb_stat ) : ?>
							<li><strong><?php echo esc_html( $iweb_stat['value'] ); ?></strong> <?php echo esc_html( $iweb_stat['short'] ); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<div class="cta-row">
					<a class="btn btn--primary" href="<?php echo esc_url( $iweb_contact_url ); ?>"><?php esc_html_e( 'Start a similar project', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
					<a class="btn btn--outline" href="<?php echo esc_url( $iweb_contact_url ); ?>"><?php echo iweb_icon( 'calendar' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'Book a free audit call', 'iweb' ); ?></a>
				</div>
			</div>

			<div class="cs-hero__visual">
				<?php
				if ( has_post_thumbnail() ) {
					the_post_thumbnail( 'large' );
				} else {
					echo '<div class="visual-placeholder" aria-hidden="true">' . iweb_icon( 'image' ) . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
				?>
			</div>
		</div>
	</section>

	<?php if ( $iweb_facts ) : ?>
		<!-- Facts -->
		<section class="container">
			<ul class="cs-facts">
				<?php foreach ( $iweb_facts as $iweb_fact ) : ?>
					<li>
						<?php echo iweb_icon( $iweb_fact[0] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<span><strong><?php echo esc_html( $iweb_fact[1] ); ?></strong> <?php echo esc_html( $iweb_fact[2] ); ?></span>
					</li>
				<?php endforeach; ?>
			</ul>
		</section>
	<?php endif; ?>

	<?php if ( $iweb_challenge || $iweb_solution ) : ?>
		<!-- Challenge and solution -->
		<section class="container cs-pair">
			<?php if ( $iweb_challenge ) : ?>
				<div class="cs-panel">
					<span class="cs-panel__icon">!</span>
					<div>
						<h2><?php esc_html_e( 'The challenge', 'iweb' ); ?></h2>
						<p><?php echo esc_html( $iweb_challenge ); ?></p>
					</div>
				</div>
			<?php endif; ?>
			<?php if ( $iweb_solution ) : ?>
				<div class="cs-panel">
					<span class="cs-panel__icon"><?php echo iweb_icon( 'bulb' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<div>
						<h2><?php esc_html_e( 'Our solution', 'iweb' ); ?></h2>
						<p><?php echo esc_html( $iweb_solution ); ?></p>
					</div>
				</div>
			<?php endif; ?>
		</section>
	<?php endif; ?>

	<?php if ( $iweb_stats ) : ?>
		<!-- Key results -->
		<section class="container">
			<div class="cs-results">
				<h2><span class="cs-panel__icon"><?php echo iweb_icon( 'chart' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span> <?php esc_html_e( 'Key results', 'iweb' ); ?></h2>
				<ul>
					<?php foreach ( $iweb_stats as $iweb_stat ) : ?>
						<li><strong><?php echo esc_html( $iweb_stat['value'] ); ?></strong> <span><?php echo esc_html( $iweb_stat['long'] ); ?></span></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( $iweb_delivered || trim( get_the_content() ) ) : ?>
		<!-- What we delivered and gallery -->
		<section class="container cs-delivered">
			<?php if ( $iweb_delivered ) : ?>
				<div>
					<h2><?php echo iweb_icon( 'gear' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'What we delivered', 'iweb' ); ?></h2>
					<ul class="check-list">
						<?php foreach ( $iweb_delivered as $iweb_item ) : ?>
							<li><?php echo iweb_icon( 'check' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php echo esc_html( $iweb_item ); ?></li>
						<?php endforeach; ?>
					</ul>
					<a class="btn btn--primary" href="<?php echo esc_url( $iweb_contact_url ); ?>"><?php esc_html_e( 'Start a similar project', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
				</div>
			<?php endif; ?>
			<?php if ( trim( get_the_content() ) ) : ?>
				<div class="cs-gallery entry-content"><?php the_content(); ?></div>
			<?php endif; ?>
		</section>
	<?php endif; ?>

	<?php if ( $iweb_quote ) : ?>
		<!-- Client feedback -->
		<section class="container">
			<figure class="cs-quote">
				<div>
					<p class="eyebrow"><?php esc_html_e( 'Client feedback', 'iweb' ); ?></p>
					<blockquote><p>“<?php echo esc_html( $iweb_quote ); ?>”</p></blockquote>
				</div>
				<figcaption>
					<strong><?php echo esc_html( iweb_cs_field( 'cs_quote_name' ) ); ?></strong><br>
					<?php echo esc_html( iweb_cs_field( 'cs_quote_role' ) ); ?>
				</figcaption>
			</figure>
		</section>
	<?php endif; ?>

	<?php if ( $iweb_related->have_posts() ) : ?>
		<!-- Related projects -->
		<section class="container cs-related">
			<div class="cs-related__head">
				<h2><?php esc_html_e( 'Related projects', 'iweb' ); ?></h2>
				<a class="btn btn--outline btn--sm" href="<?php echo esc_url( home_url( '/work/' ) ); ?>"><?php esc_html_e( 'View all work', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
			</div>
			<div class="cs-related__list">
				<?php
				while ( $iweb_related->have_posts() ) :
					$iweb_related->the_post();
					?>
					<article class="cs-related__item">
						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true"><?php the_post_thumbnail( 'thumbnail' ); ?></a>
						<?php endif; ?>
						<div>
							<h3><?php the_title(); ?></h3>
							<p><?php echo esc_html( get_the_excerpt() ); ?></p>
							<a class="link-arrow" href="<?php the_permalink(); ?>"><?php esc_html_e( 'View project', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
						</div>
					</article>
				<?php endwhile; ?>
			</div>
		</section>
		<?php wp_reset_postdata(); ?>
	<?php endif; ?>

	<!-- Closing CTA -->
	<section class="section section--dark cta-band cs-cta">
		<div class="container cs-cta__inner">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Ready to build your project?', 'iweb' ); ?></p>
				<h2><?php esc_html_e( 'Let\'s create something great together.', 'iweb' ); ?></h2>
			</div>
			<div class="cta-row">
				<a class="btn btn--light" href="<?php echo esc_url( $iweb_contact_url ); ?>"><?php esc_html_e( 'Start a project', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
				<a class="btn btn--ghost-dark" href="<?php echo esc_url( $iweb_contact_url ); ?>"><?php echo iweb_icon( 'calendar' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'Book a free audit call', 'iweb' ); ?></a>
			</div>
		</div>
	</section>

</main><!-- #primary -->

	<?php
endwhile;

get_footer();
