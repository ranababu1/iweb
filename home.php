<?php
/**
 * The blog index (the page set as "Posts page").
 *
 * Copy lives in this file. Styling lives in assets/css/blog.css, loaded on
 * all blog views.
 *
 * @package iweb
 * @since 1.11.0
 */

$iweb_contact_url = home_url( '/contact/' );
$iweb_paged       = max( 1, (int) get_query_var( 'paged' ) );

// Featured article: the newest sticky post, otherwise the newest post.
$iweb_featured = null;

if ( 1 === $iweb_paged ) {
	$iweb_sticky   = get_option( 'sticky_posts' );
	$iweb_featured = get_posts(
		array(
			'posts_per_page'      => 1,
			'post__in'            => $iweb_sticky ? $iweb_sticky : array( 0 ),
			'ignore_sticky_posts' => true,
		)
	);

	if ( ! $iweb_featured ) {
		$iweb_featured = get_posts( array( 'posts_per_page' => 1 ) );
	}

	$iweb_featured = $iweb_featured ? $iweb_featured[0] : null;
}

$iweb_popular = get_posts(
	array(
		'posts_per_page'      => 5,
		'orderby'             => 'comment_count',
		'order'               => 'DESC',
		'ignore_sticky_posts' => true,
	)
);

$iweb_newsletter = apply_filters( 'iweb_newsletter_action', '' );

get_header();
?>

<main id="primary" class="site-main blog" tabindex="-1">

	<!-- Hero -->
	<section class="blog-hero">
		<div class="container blog-hero__inner">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Insights', 'iweb' ); ?></p>
				<h1 class="blog-hero__title"><?php esc_html_e( 'Practical ideas for', 'iweb' ); ?> <span class="accent"><?php esc_html_e( 'real business growth.', 'iweb' ); ?></span></h1>
				<p class="blog-hero__lead"><?php esc_html_e( 'Guides, tutorials and insights on WordPress, SEO, AI automation, web development and digital growth.', 'iweb' ); ?></p>
			</div>
			<div class="blog-hero__visual" aria-hidden="true"><span><?php esc_html_e( 'Learn', 'iweb' ); ?></span><span><?php esc_html_e( 'Apply', 'iweb' ); ?></span><span><?php esc_html_e( 'Grow', 'iweb' ); ?></span></div>
		</div>
	</section>

	<div class="container">
		<?php iweb_blog_filters(); ?>

		<div class="blog-layout">
			<div class="blog-layout__main">

				<?php if ( $iweb_featured ) : ?>
					<section aria-labelledby="featured-heading">
						<p id="featured-heading" class="eyebrow"><?php esc_html_e( 'Featured article', 'iweb' ); ?></p>
						<article class="featured-post">
							<a class="featured-post__media" href="<?php echo esc_url( get_permalink( $iweb_featured ) ); ?>" tabindex="-1" aria-hidden="true">
								<?php echo get_the_post_thumbnail( $iweb_featured, 'large' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</a>
							<div class="featured-post__body">
								<?php if ( iweb_primary_category( $iweb_featured ) ) : ?>
									<p class="tag-label"><?php echo esc_html( iweb_primary_category( $iweb_featured ) ); ?></p>
								<?php endif; ?>
								<h2><a href="<?php echo esc_url( get_permalink( $iweb_featured ) ); ?>"><?php echo esc_html( get_the_title( $iweb_featured ) ); ?></a></h2>
								<p><?php echo esc_html( wp_trim_words( get_the_excerpt( $iweb_featured ), 32, '…' ) ); ?></p>
								<div class="post-card__meta">
									<?php echo get_avatar( $iweb_featured->post_author, 40, '', '', array( 'class' => 'avatar' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
									<span>
										<strong><?php echo esc_html( sprintf( /* translators: %s: author name. */ __( 'By %s', 'iweb' ), get_the_author_meta( 'display_name', $iweb_featured->post_author ) ) ); ?></strong><br>
										<?php echo esc_html( get_the_date( '', $iweb_featured ) ); ?> · <?php echo esc_html( iweb_reading_time_label( $iweb_featured ) ); ?>
									</span>
									<a class="post-card__go" href="<?php echo esc_url( get_permalink( $iweb_featured ) ); ?>" aria-label="<?php echo esc_attr( sprintf( /* translators: %s: post title. */ __( 'Read %s', 'iweb' ), get_the_title( $iweb_featured ) ) ); ?>"><?php echo iweb_icon( 'chevron' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
								</div>
							</div>
						</article>
					</section>
				<?php endif; ?>

				<p class="eyebrow blog-latest-label"><?php esc_html_e( 'Latest articles', 'iweb' ); ?></p>

				<?php
				if ( have_posts() ) :
					?>
					<div class="post-grid">
						<?php
						while ( have_posts() ) :
							the_post();

							// The featured article is shown above, not repeated.
							if ( $iweb_featured && get_the_ID() === $iweb_featured->ID ) {
								continue;
							}

							iweb_post_card();
						endwhile;
						?>
					</div>
					<?php
					iweb_the_posts_pagination();
				else :
					get_template_part( 'template-parts/content', 'none' );
				endif;
				?>
			</div>

			<aside class="blog-layout__side">
				<?php if ( $iweb_newsletter ) : ?>
					<div class="side-block side-block--green">
						<h2 class="side-block__title"><?php echo iweb_icon( 'leaf' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'Get actionable insights in your inbox', 'iweb' ); ?></h2>
						<p><?php esc_html_e( 'Get practical guides, tools and ideas to grow your business online.', 'iweb' ); ?></p>
						<form class="newsletter-form newsletter-form--light" action="<?php echo esc_url( $iweb_newsletter ); ?>" method="post">
							<label class="screen-reader-text" for="blog-email"><?php esc_html_e( 'Your email address', 'iweb' ); ?></label>
							<input id="blog-email" type="email" name="email" placeholder="<?php esc_attr_e( 'Your email address', 'iweb' ); ?>" required>
							<button type="submit" class="btn btn--primary btn--sm"><?php esc_html_e( 'Subscribe', 'iweb' ); ?></button>
						</form>
						<p class="fine-print"><?php esc_html_e( 'No spam. Unsubscribe anytime.', 'iweb' ); ?></p>
					</div>
				<?php endif; ?>

				<?php if ( $iweb_popular ) : ?>
					<div class="side-block">
						<h2 class="side-block__title"><?php echo iweb_icon( 'bolt' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'Popular articles', 'iweb' ); ?></h2>
						<ol class="popular-list">
							<?php foreach ( $iweb_popular as $iweb_pop ) : ?>
								<li>
									<a href="<?php echo esc_url( get_permalink( $iweb_pop ) ); ?>">
										<strong><?php echo esc_html( get_the_title( $iweb_pop ) ); ?></strong>
										<span><?php echo esc_html( iweb_reading_time_label( $iweb_pop ) ); ?></span>
									</a>
								</li>
							<?php endforeach; ?>
						</ol>
					</div>
				<?php endif; ?>

				<?php iweb_topics_block(); ?>
			</aside>
		</div>
	</div>

	<!-- Closing CTA -->
	<section class="section section--dark cta-band blog-cta">
		<div class="container blog-cta__inner">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Turn insights into results', 'iweb' ); ?></p>
				<h2><?php esc_html_e( 'Need help with your website or SEO?', 'iweb' ); ?></h2>
				<p><?php esc_html_e( 'Let\'s discuss your goals and find the right solution for your business.', 'iweb' ); ?></p>
			</div>
			<div class="cta-row">
				<a class="btn btn--light" href="<?php echo esc_url( $iweb_contact_url ); ?>"><?php esc_html_e( 'Start a project', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
				<a class="btn btn--ghost-dark" href="<?php echo esc_url( iweb_audit_url() ); ?>"><?php echo iweb_icon( 'calendar' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'Book a free audit call', 'iweb' ); ?></a>
			</div>
		</div>
	</section>

</main><!-- #primary -->

<?php
get_footer();
