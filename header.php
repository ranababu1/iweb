<?php
/**
 * The header for the theme.
 *
 * Displays everything up to and including the opening `<div id="content">`
 * tag, plus the skip link, the site branding, and the primary navigation.
 *
 * @package iweb
 * @since 1.0.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php echo esc_attr( get_bloginfo( 'charset' ) ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script>document.documentElement.classList.add('js');</script>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'iweb' ); ?></a>

<header id="masthead" class="site-header">
	<div class="site-header-inner">

		<div class="site-branding">
			<?php // Text wordmark keeps the brand consistent ("iWebAndSEO") with the footer. ?>
			<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" aria-label="<?php esc_attr_e( 'iWebAndSEO home', 'iweb' ); ?>"><?php echo wp_kses( iweb_wordmark(), array( 'span' => array( 'class' => array() ) ) ); ?></a></p>
		</div><!-- .site-branding -->

		<button id="iweb-menu-toggle" class="menu-toggle" aria-expanded="true" aria-controls="site-navigation">
			<span class="menu-toggle-label"><?php esc_html_e( 'Menu', 'iweb' ); ?></span>
		</button>

		<?php
		/*
		 * Core wp_nav_menu() markup is used: parent links open their submenus
		 * on focus and Escape closes them (assets/js/navigation.js), so no
		 * custom walker is needed. Without JavaScript the menu stays visible
		 * and expanded.
		 */
		?>
		<nav id="site-navigation" class="primary-navigation" aria-label="<?php esc_attr_e( 'Primary', 'iweb' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'menu_class'     => 'nav-menu',
					'container'      => false,
					'fallback_cb'    => 'iweb_fallback_menu',
				)
			);
			?>
		</nav><!-- #site-navigation -->

		<a class="btn btn--primary btn--sm header-cta" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">
			<?php esc_html_e( 'Start a project', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</a>

	</div><!-- .site-header-inner -->
</header><!-- #masthead -->

<div id="content" class="site-content">