<?php
/**
 * Template part for displaying pages.
 *
 * Used by page.php and the static front page.
 *
 * @package iweb
 * @since 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: the page title, hidden from assistive technology. */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'iweb' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				esc_html( get_the_title() )
			)
		);

		wp_link_pages(
			array(
				'before' => '<nav class="page-links" aria-label="' . esc_attr__( 'Pages', 'iweb' ) . '">',
				'after'  => '</nav>',
			)
		);
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php edit_post_link( esc_html__( 'Edit', 'iweb' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->