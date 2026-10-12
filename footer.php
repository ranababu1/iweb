<?php
/**
 * The template for displaying the footer.
 *
 * Closes the content div opened in header.php, then displays the footer
 * widget areas, the footer menu, optional social links, and the copyright text.
 *
 * @package iweb
 * @since 1.0.0
 */
?>

	</div><!-- #content .site-content -->

	<footer id="colophon" class="site-footer site-footer--v2">
		<div class="container footer-wrap">

			<section class="footer-cta" aria-label="<?php esc_attr_e( 'Start a project', 'iweb' ); ?>">
				<div class="footer-cta__main">
					<p class="footer-cta__eyebrow"><span class="footer-cta__line" aria-hidden="true"></span><?php esc_html_e( 'Ready to scale smarter?', 'iweb' ); ?></p>
					<p class="footer-cta__title"><?php esc_html_e( 'Let’s build', 'iweb' ); ?><br><?php esc_html_e( 'something', 'iweb' ); ?> <span class="footer-cta__accent"><?php esc_html_e( 'great.', 'iweb' ); ?></span></p>
				</div>
				<div class="footer-cta__side">
					<p class="footer-cta__text"><?php esc_html_e( 'We implement AI-driven automation that streamlines your operations, slashes overhead costs, and drives measurable revenue growth.', 'iweb' ); ?></p>
					<div class="footer-cta__actions">
						<a class="fbtn fbtn--lime" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Start a project', 'iweb' ); ?> <span class="fbtn__disc" aria-hidden="true"><svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17 17 7M8 7h9v9"/></svg></span></a>
						<a class="fbtn fbtn--outline" href="<?php echo esc_url( iweb_audit_url() ); ?>"><?php echo iweb_icon( 'calendar' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'Book a free audit call', 'iweb' ); ?></a>
					</div>
				</div>
			</section>

			<div class="footer-cols">
				<div class="footer-brand">
					<p class="footer-logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo wp_kses( iweb_wordmark(), array( 'span' => array( 'class' => array() ) ) ); ?></a></p>
					<p class="footer-blurb"><?php esc_html_e( 'We deploy AI to automate the busywork, improve how your business runs and grow your results online.', 'iweb' ); ?></p>
					<?php
					// Only render social icons when real profile URLs are set in Customizer > Social.
					$iweb_profiles = iweb_get_social_profiles();
					if ( ! empty( $iweb_profiles ) ) :
						?>
						<ul class="footer-social">
							<?php foreach ( $iweb_profiles as $iweb_profile ) : ?>
								<li><a href="<?php echo esc_url( $iweb_profile['url'] ); ?>" aria-label="<?php echo esc_attr( $iweb_profile['label'] ); ?>"><?php echo iweb_icon( $iweb_profile['network'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a></li>
							<?php endforeach; ?>
						</ul>
						<?php
					endif;
					?>
				</div>

				<?php
				$iweb_footer_cols = array(
					__( 'Services', 'iweb' )  => array(
						__( 'Get found (SEO, AEO, GEO)', 'iweb' )    => home_url( '/services/get-found/' ),
						__( 'Turn visitors into customers', 'iweb' ) => home_url( '/services/turn-visitors-into-customers/' ),
						__( 'Automate the busywork', 'iweb' )        => home_url( '/services/automate-the-busy-work/' ),
						__( 'Know what&rsquo;s working', 'iweb' )    => home_url( '/services/know-whats-working/' ),
						__( 'Custom development', 'iweb' )           => home_url( '/services/custom-development/' ),
					),
					__( 'Company', 'iweb' )   => array(
						__( 'How we work', 'iweb' )     => home_url( '/how-we-work/' ),
						__( 'About', 'iweb' )           => home_url( '/about/' ),
						__( 'Work', 'iweb' )            => home_url( '/our-work/' ),
						__( 'Insights', 'iweb' )        => home_url( '/blog/' ),
						__( 'Start a project', 'iweb' ) => home_url( '/contact/' ),
					),
					__( 'Resources', 'iweb' ) => array(
						__( 'Glossary', 'iweb' )           => home_url( '/glossary/' ),
						__( 'Website cost guide', 'iweb' ) => home_url( '/website-cost-guide/' ),
						__( 'FAQs', 'iweb' )               => home_url( '/faq/' ),
						__( 'Free audit call', 'iweb' )    => iweb_audit_url(),
					),
				);
				foreach ( $iweb_footer_cols as $iweb_col_title => $iweb_col_links ) :
					?>
					<nav class="footer-col" aria-label="<?php echo esc_attr( $iweb_col_title ); ?>">
						<h2 class="footer-col__title"><?php echo esc_html( $iweb_col_title ); ?></h2>
						<ul>
							<?php foreach ( $iweb_col_links as $iweb_link_label => $iweb_link_url ) : ?>
								<li><a href="<?php echo esc_url( $iweb_link_url ); ?>"><?php echo wp_kses_post( $iweb_link_label ); ?></a></li>
							<?php endforeach; ?>
						</ul>
					</nav>
				<?php endforeach; ?>
			</div>

			<div class="footer-bar">
				<p class="footer-bar__copy">&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> IWS. <?php esc_html_e( 'All rights reserved.', 'iweb' ); ?></p>
				<nav class="footer-bar__links" aria-label="<?php esc_attr_e( 'Legal', 'iweb' ); ?>">
					<a href="<?php echo esc_url( home_url( '/terms/' ) ); ?>"><?php esc_html_e( 'Terms', 'iweb' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/cookie-settings/' ) ); ?>"><?php esc_html_e( 'Cookie settings', 'iweb' ); ?></a>
				</nav>
			</div>
		</div>
	</footer><!-- #colophon -->

<?php wp_footer(); ?>

</body>
</html>