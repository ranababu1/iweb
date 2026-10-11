<?php
/**
 * The template for displaying the footer.
 *
 * Closes the content div opened in header.php, then displays the footer
 * widget areas, the footer menu, the social links, and the copyright text.
 *
 * @package iweb
 * @since 1.0.0
 */
?>

	</div><!-- #content .site-content -->

	<?php if ( ! iweb_has_cta_band() ) : ?>
		<section class="big-cta" aria-label="<?php esc_attr_e( 'Start a project', 'iweb' ); ?>">
			<div class="container big-cta__inner">
				<p class="big-cta__title"><?php esc_html_e( 'Project in mind?', 'iweb' ); ?></p>
				<div class="big-cta__actions">
					<a class="btn btn--primary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Start a project', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
					<a class="btn btn--outline" href="<?php echo esc_url( iweb_audit_url() ); ?>"><?php esc_html_e( 'Book a free audit call', 'iweb' ); ?></a>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<footer id="colophon" class="site-footer">
		<div class="site-footer-inner">

			<div class="footer-grid">

				<div class="footer-brand">
					<p class="footer-logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo wp_kses( iweb_wordmark(), array( 'span' => array( 'class' => array() ) ) ); ?></a></p>
					<p class="footer-blurb"><?php esc_html_e( 'We build fast WordPress sites and grow them with technical SEO, CRO and AI-ready content.', 'iweb' ); ?></p>

					<?php
					$iweb_profiles = iweb_get_social_profiles();

					if ( ! empty( $iweb_profiles ) ) :
						?>
						<ul class="social-links">
							<?php foreach ( $iweb_profiles as $iweb_profile ) : ?>
								<li class="social-link">
									<a href="<?php echo esc_url( $iweb_profile['url'] ); ?>">
										<?php
										$iweb_social_icon = iweb_icon( $iweb_profile['network'] );
										echo $iweb_social_icon ? $iweb_social_icon : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
										?>
										<span class="<?php echo $iweb_social_icon ? 'screen-reader-text' : ''; ?>"><?php echo esc_html( $iweb_profile['label'] ); ?></span>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>

					<a class="btn btn--primary btn--sm" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">
						<?php esc_html_e( 'Start a project', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</a>
				</div>

				<?php
				$iweb_footer_cols = array(
					__( 'Services', 'iweb' )  => array(
						__( 'Get found (SEO, AEO, GEO)', 'iweb' ) => home_url( '/services/get-found/' ),
						__( 'Turn visitors into customers', 'iweb' ) => home_url( '/services/turn-visitors-into-customers/' ),
						__( 'Automate the busywork', 'iweb' ) => home_url( '/services/automate-the-busy-work/' ),
						__( 'Know what\'s working', 'iweb' ) => home_url( '/services/know-whats-working/' ),
						__( 'Custom development', 'iweb' ) => home_url( '/services/custom-development/' ),
					),
					__( 'Company', 'iweb' )   => array(
						__( 'How we work', 'iweb' ) => home_url( '/how-we-work/' ),
						__( 'About', 'iweb' )       => home_url( '/about/' ),
						__( 'Work', 'iweb' )        => home_url( '/our-work/' ),
						__( 'Insights', 'iweb' )    => home_url( '/blog/' ),
						__( 'Contact', 'iweb' )     => home_url( '/contact/' ),
					),
					__( 'Resources', 'iweb' ) => array(
						__( 'SEO glossary', 'iweb' )      => home_url( '/seo-glossary/' ),
						__( 'Website cost guide', 'iweb' ) => home_url( '/website-cost-guide/' ),
						__( 'Free audit call', 'iweb' )   => iweb_audit_url(),
					),
				);

				// Drop links to pages that do not exist yet (anchors and the blog are kept).
				foreach ( $iweb_footer_cols as $iweb_k => $iweb_links ) {
					$iweb_footer_cols[ $iweb_k ] = array_filter(
						$iweb_links,
						static function ( $iweb_url ) {
							$iweb_path = trim( (string) wp_parse_url( $iweb_url, PHP_URL_PATH ), '/' );
							if ( '' === $iweb_path || 'blog' === $iweb_path || 'contact' === $iweb_path || false !== strpos( $iweb_url, '#' ) ) {
								return true;
							}
							$iweb_page = get_page_by_path( $iweb_path );
							return $iweb_page && 'publish' === $iweb_page->post_status;
						}
					);
				}

				foreach ( $iweb_footer_cols as $iweb_col_title => $iweb_col_links ) :
					?>
					<nav class="footer-col" aria-label="<?php echo esc_attr( $iweb_col_title ); ?>">
						<h2 class="footer-col__title"><?php echo esc_html( $iweb_col_title ); ?></h2>
						<?php
						$iweb_col_location = 'footer-' . sanitize_title( $iweb_col_title );
						if ( has_nav_menu( $iweb_col_location ) ) :
							wp_nav_menu(
								array(
									'theme_location' => $iweb_col_location,
									'container'      => false,
									'depth'          => 1,
									'fallback_cb'    => false,
								)
							);
						else :
							?>
						<ul>
							<?php foreach ( $iweb_col_links as $iweb_link_label => $iweb_link_url ) : ?>
								<li><a href="<?php echo esc_url( $iweb_link_url ); ?>"><?php echo esc_html( $iweb_link_label ); ?></a></li>
							<?php endforeach; ?>
						</ul>
						<?php endif; ?>

						<?php
						// The newsletter form only renders once a handler URL is supplied.
						$iweb_newsletter_action = apply_filters( 'iweb_newsletter_action', '' );

						if ( 'Resources' === $iweb_col_title && $iweb_newsletter_action ) :
							?>
							<form class="newsletter-form" action="<?php echo esc_url( $iweb_newsletter_action ); ?>" method="post">
								<label class="screen-reader-text" for="footer-email"><?php esc_html_e( 'Your email address', 'iweb' ); ?></label>
								<input id="footer-email" type="email" name="email" placeholder="<?php esc_attr_e( 'Your email address', 'iweb' ); ?>" required>
								<button type="submit" class="btn btn--primary btn--sm"><?php esc_html_e( 'Subscribe', 'iweb' ); ?></button>
							</form>
						<?php endif; ?>
					</nav>
				<?php endforeach; ?>

			</div><!-- .footer-grid -->

			<div class="footer-bottom">
				<p class="iweb-copyright site-info"><?php iweb_the_footer_copyright(); ?></p>

				<?php
				if ( has_nav_menu( 'footer' ) ) :
					?>
					<nav class="footer-navigation" aria-label="<?php esc_attr_e( 'Footer', 'iweb' ); ?>">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'footer',
								'container'      => false,
								'depth'          => 1,
								'fallback_cb'    => false,
							)
						);
						?>
					</nav>
				<?php else : ?>
					<nav class="footer-navigation" aria-label="<?php esc_attr_e( 'Footer', 'iweb' ); ?>">
						<ul>
							<?php foreach ( array( 'privacy-policy' => __( 'Privacy Policy', 'iweb' ), 'terms' => __( 'Terms', 'iweb' ), 'cookie-settings' => __( 'Cookie Settings', 'iweb' ) ) as $iweb_slug => $iweb_label ) : ?>
								<?php $iweb_legal = get_page_by_path( $iweb_slug ); ?>
								<?php if ( $iweb_legal && 'publish' === $iweb_legal->post_status ) : ?>
									<li><a href="<?php echo esc_url( home_url( '/' . $iweb_slug . '/' ) ); ?>"><?php echo esc_html( $iweb_label ); ?></a></li>
								<?php endif; ?>
							<?php endforeach; ?>
						</ul>
					</nav>
				<?php endif; ?>
			</div>

			<p class="footer-wordmark" aria-hidden="true">IWS</p>
			<p class="footer-email"><a href="mailto:hello@imraan.in">hello@imraan.in</a></p>
		</div><!-- .site-footer-inner -->
	</footer><!-- #colophon -->

<?php wp_footer(); ?>

</body>
</html>