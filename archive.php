<?php
/**
 * The template for displaying archive pages.
 *
 * @package iweb
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main blog blog--archive" tabindex="-1">
	<div class="container">
	<?php iweb_blog_filters(); ?>
	<header class="page-header archive-header">
		<?php
		the_archive_title( '<h1 class="page-title">', '</h1>' );
		the_archive_description( '<div class="archive-description">', '</div>' );
		?>
	</header><!-- .page-header -->

	<?php
	if ( have_posts() ) :

		echo '<div class="post-grid">';

		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content' );
		endwhile;

		echo '</div>';

		iweb_the_posts_pagination();

	else :
		get_template_part( 'template-parts/content', 'none' );
	endif;
	?>
	</div>
</main><!-- #primary -->

<?php
get_footer();