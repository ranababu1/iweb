<?php
/**
 * The template for displaying the comments area.
 *
 * Returns early when the current post is protected by a password.
 *
 * @package iweb
 * @since 1.0.0
 */

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>

		<h2 class="comments-title">
			<?php
			$iweb_comment_count = get_comments_number();

			printf(
				/* translators: 1: the number of comments. */
				esc_html( _n( '%1$s comment', '%1$s comments', $iweb_comment_count, 'iweb' ) ),
				esc_html( number_format_i18n( $iweb_comment_count ) )
			);
			?>
		</h2>

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 48,
				)
			);
			?>
		</ol><!-- .comment-list -->

		<?php
		if ( ! comments_open() ) :
			?>
			<p class="comments-closed"><?php esc_html_e( 'Comments are closed.', 'iweb' ); ?></p>
			<?php
		endif;

	endif;

	comment_form();
	?>

</div><!-- #comments -->