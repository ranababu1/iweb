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

			<?php
			// Footer widget areas. Each area is only output when it has widgets.
			$iweb_footer_has_widgets = is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' );

			if ( $iweb_footer_has_widgets ) :
				?>
				<div class="footer-widgets">
					<?php
					for ( $iweb_i = 1; $iweb_i <= 3; $iweb_i++ ) :
						if ( is_active_sidebar( 'footer-' . $iweb_i ) ) :
							?>
							<div class="footer-widget-area footer-widget-area-<?php echo esc_attr( $iweb_i ); ?>">
								<?php dynamic_sidebar( 'footer-' . $iweb_i ); ?>
							</div>
							<?php
						endif;
					endfor;
					?>
				</div><!-- .footer-widgets -->
				<?php
			endif;

			// Footer menu.
			if ( has_nav_menu( 'footer' ) ) :
				?>
				<nav class="footer-navigation" aria-label="<?php esc_attr_e( 'Footer', 'iweb' ); ?>">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'container'      => false,
							'depth'           => 1,
							'fallback_cb'     => false,
						)
					);
					?>
				</nav>
				<?php
			endif;

			// Social links: the social menu, or the Customizer profiles as a fallback.
			if ( has_nav_menu( 'social' ) ) :
				?>
				<nav class="social-navigation" aria-label="<?php esc_attr_e( 'Social', 'iweb' ); ?>">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'social',
							'container'      => false,
							'depth'           => 1,
							'fallback_cb'    => false,
						)
					);
					?>
				</nav>
				<?php
			else :
				$iweb_profiles = iweb_get_social_profiles();

				if ( ! empty( $iweb_profiles ) ) :
					?>
					<nav class="social-navigation" aria-label="<?php esc_attr_e( 'Social', 'iweb' ); ?>">
						<ul class="social-links">
							<?php
							foreach ( $iweb_profiles as $iweb_profile ) :
								?>
								<li class="social-link">
									<a href="<?php echo esc_url( $iweb_profile['url'] ); ?>"><?php echo esc_html( $iweb_profile['label'] ); ?></a>
								</li>
								<?php
							endforeach;
							?>
						</ul>
					</nav>
					<?php
				endif;
			endif;
			?>

			<p class="iweb-copyright site-info"><?php iweb_the_footer_copyright(); ?></p>

		</div><!-- .site-footer-inner -->
	</footer><!-- #colophon -->

<?php wp_footer(); ?>

</body>
</html>