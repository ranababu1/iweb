<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package iweb
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main" tabindex="-1">
	<section class="error-404 not-found">
		<header class="page-header">
			<h1 class="page-title"><?php esc_html_e( 'Page not found', 'iweb' ); ?></h1>
		</header><!-- .page-header -->

		<div class="page-content">
			<p><?php esc_html_e( 'It looks like nothing was found at this address. Maybe try a search?', 'iweb' ); ?></p>

			<?php get_search_form(); ?>
		</div><!-- .page-content -->
	</section><!-- .error-404 -->
</main><!-- #primary -->

<?php
get_footer();