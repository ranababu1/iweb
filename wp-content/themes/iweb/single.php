<?php
/**
 * The template for displaying single posts.
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

		get_template_part( 'template-parts/content', 'single' );

		the_post_navigation(
			array(
				'prev_text' => esc_html__( 'Previous post', 'iweb' ),
				'next_text' => esc_html__( 'Next post', 'iweb' ),
			)
		);

		// Show comments when they are open or when any already exist.
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
	endwhile;
	?>
</main><!-- #primary -->

<?php
get_footer();