<?php
/**
 * The template for displaying search results pages.
 *
 * @package iweb
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main blog blog--archive" tabindex="-1">
	<div class="container">
	<?php iweb_blog_filters(); ?>
	<header class="page-header search-header">
		<h1 class="page-title">
			<?php
			printf(
				/* translators: %s: the search query. */
				esc_html__( 'Search results for: %s', 'iweb' ),
				'<span class="search-term">' . esc_html( get_search_query() ) . '</span>'
			);
			?>
		</h1>
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