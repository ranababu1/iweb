<?php
/**
 * The template for displaying single posts.
 *
 * Copy lives in this file. Styling lives in assets/css/blog.css and the
 * share and table-of-contents behavior in assets/js/blog.js. Optional
 * "Key takeaways" come from a `takeaways` custom field, one per line.
 *
 * @package iweb
 * @since 1.11.0
 */

$iweb_contact_url = home_url( '/contact/' );

get_header();

while ( have_posts() ) :
	the_post();

	$iweb_cats      = get_the_category();
	$iweb_url       = rawurlencode( get_permalink() );
	$iweb_title_enc = rawurlencode( get_the_title() );
	$iweb_author_id = get_the_author_meta( 'ID' );

	list( $iweb_content, $iweb_headings ) = iweb_content_with_toc( apply_filters( 'the_content', get_the_content() ) );

	$iweb_takeaways = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) get_post_meta( get_the_ID(), 'takeaways', true ) ) ) );

	$iweb_related_args = array(
		'posts_per_page'      => 3,
		'post__not_in'        => array( get_the_ID() ),
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	);

	if ( $iweb_cats ) {
		$iweb_related_args['category__in'] = wp_list_pluck( $iweb_cats, 'term_id' );
	}

	$iweb_related = new WP_Query( $iweb_related_args );
	?>

<main id="primary" class="site-main post-single" tabindex="-1">
	<div class="container">

		<nav class="breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'iweb' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'iweb' ); ?></a> ›
			<a href="<?php echo esc_url( iweb_blog_url() ); ?>"><?php esc_html_e( 'Insights', 'iweb' ); ?></a> ›
			<?php if ( $iweb_cats ) : ?>
				<a href="<?php echo esc_url( get_category_link( $iweb_cats[0] ) ); ?>"><?php echo esc_html( $iweb_cats[0]->name ); ?></a> ›
			<?php endif; ?>
			<span aria-current="page"><?php the_title(); ?></span>
		</nav>

		<div class="single-layout">
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-main' ); ?>>
				<header class="single-header">
					<?php if ( $iweb_cats ) : ?>
						<p class="eyebrow"><?php echo esc_html( $iweb_cats[0]->name ); ?></p>
					<?php endif; ?>
					<h1 class="single-title"><?php the_title(); ?></h1>
					<?php if ( has_excerpt() ) : ?>
						<p class="single-lead"><?php echo esc_html( get_the_excerpt() ); ?></p>
					<?php endif; ?>

					<div class="single-byline">
						<div class="post-card__meta">
							<?php echo get_avatar( $iweb_author_id, 48, '', '', array( 'class' => 'avatar' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<span>
								<strong><?php echo esc_html( sprintf( /* translators: %s: author name. */ __( 'By %s', 'iweb' ), get_the_author() ) ); ?></strong><br>
								<?php echo esc_html( get_the_date() ); ?> · <?php echo esc_html( iweb_reading_time_label() ); ?>
							</span>
						</div>

						<ul class="share" aria-label="<?php esc_attr_e( 'Share this article', 'iweb' ); ?>">
							<li><a href="<?php echo esc_url( 'https://www.linkedin.com/sharing/share-offsite/?url=' . $iweb_url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo iweb_icon( 'linkedin' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span class="screen-reader-text"><?php esc_html_e( 'Share on LinkedIn', 'iweb' ); ?></span></a></li>
							<li><a href="<?php echo esc_url( 'https://twitter.com/intent/tweet?url=' . $iweb_url . '&text=' . $iweb_title_enc ); ?>" target="_blank" rel="noopener noreferrer"><?php echo iweb_icon( 'x' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span class="screen-reader-text"><?php esc_html_e( 'Share on X', 'iweb' ); ?></span></a></li>
							<li><a href="<?php echo esc_url( 'https://www.facebook.com/sharer/sharer.php?u=' . $iweb_url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo iweb_icon( 'facebook' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span class="screen-reader-text"><?php esc_html_e( 'Share on Facebook', 'iweb' ); ?></span></a></li>
							<li><button type="button" data-copy-link="<?php echo esc_url( get_permalink() ); ?>"><?php echo iweb_icon( 'link' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span class="screen-reader-text" data-copy-label><?php esc_html_e( 'Copy link', 'iweb' ); ?></span></button></li>
						</ul>
					</div>
				</header>

				<?php if ( has_post_thumbnail() ) : ?>
					<figure class="single-hero"><?php the_post_thumbnail( 'large' ); ?></figure>
				<?php endif; ?>

				<?php if ( $iweb_takeaways ) : ?>
					<aside class="takeaways">
						<span class="takeaways__icon"><?php echo iweb_icon( 'bulb' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
						<div>
							<h2><?php esc_html_e( 'Key takeaways', 'iweb' ); ?></h2>
							<ul>
								<?php foreach ( $iweb_takeaways as $iweb_t ) : ?>
									<li><?php echo iweb_icon( 'check' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php echo esc_html( $iweb_t ); ?></li>
								<?php endforeach; ?>
							</ul>
						</div>
					</aside>
				<?php endif; ?>

				<div class="entry-content single-content">
					<?php echo $iweb_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Filtered post content. ?>
				</div>

				<?php
				wp_link_pages(
					array(
						'before' => '<nav class="page-links" aria-label="' . esc_attr__( 'Pages', 'iweb' ) . '">',
						'after'  => '</nav>',
					)
				);
				?>

				<aside class="inline-cta">
					<span class="inline-cta__icon"><?php echo iweb_icon( 'gear' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<div>
						<h2><?php esc_html_e( 'Need help with your website?', 'iweb' ); ?></h2>
						<p><?php esc_html_e( 'We put AI to work on the slow, manual parts of your business and help you grow online.', 'iweb' ); ?></p>
					</div>
					<a class="btn btn--light btn--sm" href="<?php echo esc_url( $iweb_contact_url ); ?>"><?php esc_html_e( 'Start a project', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
				</aside>

				<?php
				$iweb_post_tags = get_the_tags();

				if ( $iweb_post_tags ) :
					?>
					<ul class="tag-list">
						<?php foreach ( $iweb_post_tags as $iweb_tag ) : ?>
							<li><a href="<?php echo esc_url( get_tag_link( $iweb_tag ) ); ?>"><?php echo esc_html( $iweb_tag->name ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<div class="author-box">
					<?php echo get_avatar( $iweb_author_id, 72, '', '', array( 'class' => 'avatar' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<div>
						<p class="author-box__label"><?php esc_html_e( 'About the author', 'iweb' ); ?></p>
						<h2><?php the_author(); ?></h2>
						<p><?php echo esc_html( get_the_author_meta( 'description' ) ); ?></p>
					</div>
				</div>

				<?php
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
				?>
			</article>

			<aside class="single-side">
				<?php if ( count( $iweb_headings ) > 1 ) : ?>
					<nav class="side-block toc" aria-label="<?php esc_attr_e( 'Table of contents', 'iweb' ); ?>" data-toc>
						<h2 class="side-block__title"><?php esc_html_e( 'Table of contents', 'iweb' ); ?></h2>
						<ol>
							<?php foreach ( $iweb_headings as $iweb_h ) : ?>
								<li><a href="#<?php echo esc_attr( $iweb_h['id'] ); ?>"><?php echo esc_html( $iweb_h['text'] ); ?></a></li>
							<?php endforeach; ?>
						</ol>
					</nav>
				<?php endif; ?>

				<div class="side-block side-block--green">
					<h2 class="side-block__title"><?php esc_html_e( 'Get a free website speed audit', 'iweb' ); ?></h2>
					<p><?php esc_html_e( 'We\'ll review your website and share actionable recommendations to improve performance.', 'iweb' ); ?></p>
					<a class="btn btn--dark" href="<?php echo esc_url( iweb_audit_url() ); ?>"><?php esc_html_e( 'Book a free audit call', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
				</div>

				<?php if ( $iweb_related->have_posts() ) : ?>
					<div class="side-block">
						<h2 class="side-block__title"><?php esc_html_e( 'Related articles', 'iweb' ); ?></h2>
						<ul class="related-list">
							<?php
							while ( $iweb_related->have_posts() ) :
								$iweb_related->the_post();
								?>
								<li>
									<a href="<?php the_permalink(); ?>">
										<span class="related-list__thumb"><?php the_post_thumbnail( 'thumbnail' ); ?></span>
										<span>
											<strong><?php the_title(); ?></strong>
											<small><?php echo esc_html( iweb_reading_time_label() ); ?></small>
										</span>
									</a>
								</li>
							<?php endwhile; ?>
						</ul>
					</div>
					<?php wp_reset_postdata(); ?>
				<?php endif; ?>

				<?php iweb_topics_block( false, __( 'Explore more topics', 'iweb' ) ); ?>
			</aside>
		</div>
	</div>

	<!-- Closing CTA -->
	<section class="section section--dark cta-band blog-cta">
		<div class="container blog-cta__inner">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Ready to improve your website?', 'iweb' ); ?></p>
				<h2><?php esc_html_e( 'Let\'s build a faster, higher performing website.', 'iweb' ); ?></h2>
			</div>
			<div class="cta-row">
				<a class="btn btn--light" href="<?php echo esc_url( $iweb_contact_url ); ?>"><?php esc_html_e( 'Start a project', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
				<a class="btn btn--ghost-dark" href="<?php echo esc_url( iweb_audit_url() ); ?>"><?php echo iweb_icon( 'calendar' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'Book a free audit call', 'iweb' ); ?></a>
			</div>
		</div>
	</section>

</main><!-- #primary -->

	<?php
endwhile;

get_footer();
