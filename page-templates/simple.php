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

		<div class="container simple-body entry-content">
			<?php the_content(); ?>
		</div>
	<?php endwhile; ?>
</main><!-- #primary -->

<?php
get_footer();
