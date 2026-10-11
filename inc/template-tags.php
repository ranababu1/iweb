<?php
/**
 * Custom template tags for the iweb theme.
 *
 * These print small pieces of entry meta and are used inside the template
 * parts. They are kept in one place so they can be reused and overridden.
 *
 * @package iweb
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Print HTML with meta information for the current post date.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iweb_posted_on() {
	$iweb_time = sprintf(
		'<time class="entry-date published" datetime="%1$s">%2$s</time>',
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() )
	);

	printf(
		/* translators: %s: the post date. */
		'<span class="posted-on">' . esc_html__( 'Posted on %s', 'iweb' ) . '</span>',
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $iweb_time . '</a>'
	);
}

/**
 * Print HTML with meta information about the current post author.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iweb_posted_by() {
	printf(
		/* translators: %s: the post author name. */
		'<span class="byline">' . esc_html__( 'by %s', 'iweb' ) . '</span>',
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);
}

/**
 * Print the post thumbnail (featured image) for the current post.
 *
 * On singular views the image is printed on its own. On archive views it is
 * linked to the post but hidden from assistive technology and removed from
 * the tab order, because the entry title already provides the same link.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iweb_post_thumbnail() {
	if ( ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) {
		the_post_thumbnail( 'post-thumbnail' );
		return;
	}
	?>
	<div class="post-thumbnail">
		<a href="<?php echo esc_url( get_permalink() ); ?>" aria-hidden="true" tabindex="-1">
			<?php the_post_thumbnail( 'post-thumbnail' ); ?>
		</a>
	</div>
	<?php
}

/**
 * Print HTML with the categories, tags, and edit link for the current post.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iweb_entry_footer() {
	if ( 'post' !== get_post_type() ) {
		return;
	}

	// Categories.
	$iweb_categories = get_the_category_list( ' ' );

	if ( $iweb_categories ) {
		printf(
			/* translators: %s: the list of category links. */
			'<span class="cat-links">' . esc_html__( 'Posted in %s', 'iweb' ) . '</span>',
			$iweb_categories
		);
	}

	// Tags.
	$iweb_tags = get_the_tag_list( '', ' ' );

	if ( $iweb_tags ) {
		printf(
			/* translators: %s: the list of tag links. */
			'<span class="tags-links">' . esc_html__( 'Tagged %s', 'iweb' ) . '</span>',
			$iweb_tags
		);
	}

	// Edit link.
	edit_post_link(
		sprintf(
			wp_kses(
				/* translators: %s: the post title, hidden from assistive technology. */
				__( 'Edit <span class="screen-reader-text">%s</span>', 'iweb' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			esc_html( get_the_title() )
		),
		'<span class="edit-link">',
		'</span>'
	);
}

/**
 * Print the paginated navigation between archive pages.
 *
 * A thin wrapper so all loop templates share the same, translatable markup.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iweb_the_posts_pagination() {
	the_posts_pagination(
		array(
			'mid_size'  => 1,
			'prev_text' => esc_html__( 'Previous', 'iweb' ),
			'next_text' => esc_html__( 'Next', 'iweb' ),
		)
	);
}