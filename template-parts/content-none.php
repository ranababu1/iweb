<?php
/**
 * Template part for displaying a "no content" message.
 *
 * Used by index.php, archive.php, search.php, and front-page.php when the
 * current query returns no posts.
 *
 * @package iweb
 * @since 1.0.0
 */
?>

<section class="no-results not-found">
	<header class="page-header">
		<h2 class="page-title"><?php esc_html_e( 'Nothing found', 'iweb' ); ?></h2>
	</header><!-- .page-header -->

	<div class="page-content">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) :
			?>
			<p>
				<?php
				printf(
					wp_kses(
						/* translators: %s: the link to the post editor. */
						__( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'iweb' ),
						array(
							'a' => array(
								'href' => array(),
							),
						)
					),
					esc_url( admin_url( 'post-new.php' ) )
				);
				?>
			</p>
			<?php
		elseif ( is_search() ) :
			?>
			<p><?php esc_html_e( 'Sorry, nothing matched your search terms. Please try again with different keywords.', 'iweb' ); ?></p>
			<?php
			get_search_form();
		else :
			?>
			<p><?php esc_html_e( 'Nothing was found here. Perhaps a search can help.', 'iweb' ); ?></p>
			<?php
			get_search_form();
		endif;
		?>
	</div><!-- .page-content -->
</section><!-- .no-results -->