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
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'iweb' ); ?></a>

<header id="masthead" class="site-header">
	<div class="site-header-inner">

		<div class="site-branding">
			<?php
			if ( has_custom_logo() ) {
				the_custom_logo();
			} else {
				if ( is_front_page() && is_home() ) :
					?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a></h1>
					<?php
				else :
					?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a></p>
					<?php
				endif;

				$iweb_description = get_bloginfo( 'description', 'display' );

				if ( $iweb_description || is_customize_preview() ) :
					?>
					<p class="site-description"><?php echo esc_html( $iweb_description ); ?></p>
					<?php
				endif;
			}
			?>
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
					'fallback_cb'    => false,
				)
			);
			?>
		</nav><!-- #site-navigation -->

	</div><!-- .site-header-inner -->
</header><!-- #masthead -->

<div id="content" class="site-content">