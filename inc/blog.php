<?php
/**
 * Blog helpers: reading time, featured and popular posts, a table of
 * contents for single posts, and the shared sidebar blocks.
 *
 * @package iweb
 * @since 1.11.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Estimated reading time in minutes.
 *
 * @since 1.11.0
 *
 * @param int|WP_Post|null $post Post.
 * @return int Minutes, at least 1.
 */
function iweb_reading_time( $post = null ) {
	$post  = get_post( $post );
	$words = str_word_count( wp_strip_all_tags( strip_shortcodes( $post->post_content ) ) );

	return max( 1, (int) ceil( $words / 220 ) );
}

/**
 * Print "N min read".
 *
 * @since 1.11.0
 *
 * @param int|WP_Post|null $post Post.
 * @return string
 */
function iweb_reading_time_label( $post = null ) {
	/* translators: %d: reading time in minutes. */
	return sprintf( __( '%d min read', 'iweb' ), iweb_reading_time( $post ) );
}

/**
 * Name of the first category of a post.
 *
 * @since 1.11.0
 *
 * @param int|WP_Post|null $post Post.
 * @return string Category name or empty string.
 */
function iweb_primary_category( $post = null ) {
	$cats = get_the_category( $post ? get_post( $post )->ID : get_the_ID() );

	return $cats ? $cats[0]->name : '';
}

/**
 * URL of the page that lists posts.
 *
 * @since 1.11.0
 *
 * @return string
 */
function iweb_blog_url() {
	$page = (int) get_option( 'page_for_posts' );

	return $page ? get_permalink( $page ) : home_url( '/' );
}

/**
 * Add ids to h2 headings and collect them for a table of contents.
 *
 * @since 1.11.0
 *
 * @param string $html Rendered post content.
 * @return array{0: string, 1: array<int, array{id: string, text: string}>} Content and headings.
 */
function iweb_content_with_toc( $html ) {
	$headings = array();
	$used     = array();

	$html = preg_replace_callback(
		'/<h2([^>]*)>(.*?)<\/h2>/is',
		static function ( $m ) use ( &$headings, &$used ) {
			$text = trim( wp_strip_all_tags( $m[2] ) );
			$id   = sanitize_title( $text );
			$id   = $id ? $id : 'section';
			$base = $id;
			$n    = 2;

			while ( in_array( $id, $used, true ) ) {
				$id = $base . '-' . $n++;
			}

			$used[]     = $id;
			$headings[] = array(
				'id'   => $id,
				'text' => $text,
			);

			if ( false !== strpos( $m[1], ' id=' ) ) {
				return $m[0];
			}

			return '<h2' . $m[1] . ' id="' . esc_attr( $id ) . '">' . $m[2] . '</h2>';
		},
		$html
	);

	return array( $html, $headings );
}

/**
 * Print a post card used on the blog index, archives and search.
 *
 * @since 1.11.0
 *
 * @return void
 */
function iweb_post_card() {
	get_template_part( 'template-parts/content' );
}

/**
 * Category pills for the blog index.
 *
 * @since 1.11.0
 *
 * @return void
 */
function iweb_blog_filters() {
	$current = is_category() ? get_queried_object_id() : 0;
	?>
	<div class="blog-filters">
		<ul class="blog-filters__list">
			<li><a class="pill<?php echo $current ? '' : ' is-active'; ?>" href="<?php echo esc_url( iweb_blog_url() ); ?>"><?php esc_html_e( 'All Topics', 'iweb' ); ?></a></li>
			<?php foreach ( get_categories( array( 'orderby' => 'count', 'order' => 'DESC', 'number' => 8 ) ) as $cat ) : ?>
				<li><a class="pill<?php echo $current === $cat->term_id ? ' is-active' : ''; ?>" href="<?php echo esc_url( get_category_link( $cat ) ); ?>"><?php echo esc_html( $cat->name ); ?></a></li>
			<?php endforeach; ?>
		</ul>
		<form class="blog-search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<label class="screen-reader-text" for="blog-search-field"><?php esc_html_e( 'Search articles', 'iweb' ); ?></label>
			<?php echo iweb_icon( 'search' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<input id="blog-search-field" type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Search articles...', 'iweb' ); ?>">
			<input type="hidden" name="post_type" value="post">
		</form>
	</div>
	<?php
}

/**
 * "Browse by topic" block.
 *
 * @since 1.11.0
 *
 * @param bool $counts Show post counts.
 * @param string $title Block title.
 * @return void
 */
function iweb_topics_block( $counts = true, $title = '' ) {
	$cats = get_categories( array( 'orderby' => 'count', 'order' => 'DESC', 'number' => 8 ) );

	if ( ! $cats ) {
		return;
	}

	$title = $title ? $title : __( 'Browse by topic', 'iweb' );
	?>
	<div class="side-block">
		<h2 class="side-block__title"><?php echo iweb_icon( 'folder' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php echo esc_html( $title ); ?></h2>
		<ul class="topic-list">
			<?php foreach ( $cats as $cat ) : ?>
				<li>
					<a href="<?php echo esc_url( get_category_link( $cat ) ); ?>">
						<span><?php echo esc_html( $cat->name ); ?></span>
						<?php if ( $counts ) : ?>
							<span class="topic-list__count"><?php echo esc_html( number_format_i18n( $cat->count ) ); ?></span>
						<?php endif; ?>
						<?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php
}
