<?php
/**
 * Template Name: Simple content page
 *
 * A clean hero (eyebrow, title, intro from the excerpt) followed by the page
 * content in a readable column. Used for custom development, legal pages,
 * guides and the booking page.
 *
 * @package iweb
 */

get_header();
?>

<main id="primary" class="site-main simple-page" tabindex="-1">
	<?php
	while ( have_posts() ) :
		the_post();
		$iweb_parent = wp_get_post_parent_id( get_the_ID() );
		?>
		<?php if ( 'custom-development' === get_post_field( 'post_name', get_the_ID() ) ) : ?>
			<?php
			get_template_part(
				'template-parts/service-hero',
				null,
				array(
					'label'       => __( 'Custom development', 'iweb' ),
					'lines'       => array( __( 'Built for', 'iweb' ), __( 'how you work.', 'iweb' ), __( 'Connected to', 'iweb' ) ),
					'highlight'   => __( 'everything you use.', 'iweb' ),
					'lead'        => __( 'We build custom .NET and Java applications, APIs and integrations that fit the way your business runs, including AI features where they save real time.', 'iweb' ),
					'steps'       => array(
						array( 'search', __( 'Discovery and scoping', 'iweb' ), __( 'Agree goals, users and limits', 'iweb' ) ),
						array( 'layout', __( 'System design', 'iweb' ), __( 'Plan data, screens and services', 'iweb' ) ),
						array( 'code', __( '.NET or Java build', 'iweb' ), __( 'Clean code in short cycles', 'iweb' ) ),
						array( 'link', __( 'API and data integration', 'iweb' ), __( 'Connect your CRM, ERP and tools', 'iweb' ) ),
						array( 'check', __( 'Testing and security', 'iweb' ), __( 'Check every release before launch', 'iweb' ) ),
						array( 'refresh', __( 'Launch and support', 'iweb' ), __( 'Go live and keep improving', 'iweb' ) ),
					),
					'result_icon' => 'bolt',
					'result'      => __( 'Software that fits your business', 'iweb' ),
				)
			);
			?>
		<?php else : ?>
		<section class="simple-hero">
			<div class="container simple-hero__inner">
				<nav class="breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'iweb' ); ?>">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'iweb' ); ?></a> ›
					<?php if ( $iweb_parent ) : ?>
						<a href="<?php echo esc_url( get_permalink( $iweb_parent ) ); ?>"><?php echo esc_html( get_the_title( $iweb_parent ) ); ?></a> ›
					<?php endif; ?>
					<span aria-current="page"><?php the_title(); ?></span>
				</nav>
				<?php
				$iweb_eyebrow = get_post_meta( get_the_ID(), 'iweb_eyebrow', true );
				if ( $iweb_eyebrow ) :
					?>
					<p class="eyebrow"><?php echo esc_html( $iweb_eyebrow ); ?></p>
				<?php endif; ?>
				<?php $iweb_h1 = get_post_meta( get_the_ID(), 'iweb_h1', true ); ?>
				<h1 class="simple-hero__title"><?php echo $iweb_h1 ? esc_html( $iweb_h1 ) : esc_html( get_the_title() ); ?></h1>
				<?php if ( has_excerpt() ) : ?>
					<p class="simple-hero__lead"><?php echo esc_html( get_the_excerpt() ); ?></p>
				<?php endif; ?>
			</div>
		</section>
		<?php endif; ?>

		<div class="container simple-body entry-content">
			<?php the_content(); ?>
		</div>
	<?php endwhile; ?>
</main><!-- #primary -->

<?php
get_footer();
