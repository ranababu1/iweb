<?php
/**
 * The template for displaying pages.
 *
 * @package iweb
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main" tabindex="-1">
	<?php
	while ( have_posts() ) :
		the_post();

		get_template_part( 'template-parts/content', 'page' );

		if ( comments_open() ) {
			comments_template();
		}
	endwhile;
	?>
</main><!-- #primary -->

<?php
get_footer();