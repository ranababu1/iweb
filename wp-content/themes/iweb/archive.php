<?php
/**
 * The template for displaying archive pages.
 *
 * @package iweb
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main" tabindex="-1">
	<header class="page-header archive-header">
		<?php
		the_archive_title( '<h1 class="page-title">', '</h1>' );
		the_archive_description( '<div class="archive-description">', '</div>' );
		?>
	</header><!-- .page-header -->

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
// The sidebar shows only when the Customizer toggle is on.
if ( iweb_has_sidebar() ) {
	get_sidebar();
}

get_footer();