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
						__( 'Automate the busywork', 'iweb' ) => home_url( '/services/automate-the-busywork/' ),
						__( 'Know what\'s working', 'iweb' ) => home_url( '/services/know-whats-working/' ),
						__( 'Custom development', 'iweb' ) => home_url( '/services/custom-development/' ),
					),
					__( 'Company', 'iweb' )   => array(
						__( 'How we work', 'iweb' ) => home_url( '/#process' ),
						__( 'About', 'iweb' )       => home_url( '/about/' ),
						__( 'Work', 'iweb' )        => home_url( '/work/' ),
						__( 'Insights', 'iweb' )    => home_url( '/blog/' ),
						__( 'Contact', 'iweb' )     => home_url( '/contact/' ),
					),
					__( 'Resources', 'iweb' ) => array(
						__( 'SEO glossary', 'iweb' )      => home_url( '/seo-glossary/' ),
						__( 'Website cost guide', 'iweb' ) => home_url( '/website-cost-guide/' ),
						__( 'Free audit call', 'iweb' )   => home_url( '/contact/' ),
					),
				);

				foreach ( $iweb_footer_cols as $iweb_col_title => $iweb_col_links ) :
					?>
					<nav class="footer-col" aria-label="<?php echo esc_attr( $iweb_col_title ); ?>">
						<h2 class="footer-col__title"><?php echo esc_html( $iweb_col_title ); ?></h2>
						<ul>
							<?php foreach ( $iweb_col_links as $iweb_link_label => $iweb_link_url ) : ?>
								<li><a href="<?php echo esc_url( $iweb_link_url ); ?>"><?php echo esc_html( $iweb_link_label ); ?></a></li>
							<?php endforeach; ?>
						</ul>

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
							<li><a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'iweb' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/terms/' ) ); ?>"><?php esc_html_e( 'Terms', 'iweb' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/cookie-settings/' ) ); ?>"><?php esc_html_e( 'Cookie Settings', 'iweb' ); ?></a></li>
						</ul>
					</nav>
				<?php endif; ?>
			</div>

		</div><!-- .site-footer-inner -->
	</footer><!-- #colophon -->

<?php wp_footer(); ?>

</body>
</html>