<?php
/**
 * The main template file.
 *
 * This is the most generic template and is used as a fallback whenever
 * nothing more specific matches a query.
 *
 * @package iweb
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main" tabindex="-1">
	<?php
	if ( have_posts() ) :

		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content' );
		endwhile;

		iweb_the_posts_pagination();

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