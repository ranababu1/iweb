<?php
/**
 * The front page template.
 *
 * Displays the static front page when one is set, otherwise the latest
 * posts. Kept intentionally thin so it is easy to replace.
 *
 * @package iweb
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main" tabindex="-1">
	<?php
	if ( have_posts() ) :

		if ( is_page() ) :
			// A static front page is set.
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content', 'page' );
			endwhile;
		else :
			// Latest posts view.
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content' );
			endwhile;

			iweb_the_posts_pagination();
		endif;

	else :
		get_template_part( 'template-parts/content', 'none' );
	endif;
	?>
</main><!-- #primary -->

<?php
if ( iweb_has_sidebar() ) {
	get_sidebar();
}

get_footer();