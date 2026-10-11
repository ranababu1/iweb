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

<main id="primary" class="site-main blog blog--archive" tabindex="-1">
	<div class="container">
	<?php iweb_blog_filters(); ?>
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