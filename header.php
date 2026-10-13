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

<header id="masthead" class="site-header iws-header">
	<?php
	$iweb_services = iweb_nav_services();
	$iweb_links    = iweb_nav_links();
	$iweb_req      = trailingslashit( home_url( add_query_arg( array() ) ) );
	$iweb_logo     = wp_kses( iweb_wordmark(), array( 'span' => array( 'class' => array() ) ) );
	?>
	<div class="iws-bar">
		<a class="iws-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" aria-label="<?php esc_attr_e( 'IWS home', 'iweb' ); ?>"><?php echo $iweb_logo; // phpcs:ignore ?></a>

		<nav class="iws-nav" aria-label="<?php esc_attr_e( 'Primary', 'iweb' ); ?>">
			<ul class="iws-nav__list">
				<li class="iws-nav__item iws-nav__item--mega">
					<button type="button" class="iws-nav__link iws-nav__trigger" aria-expanded="false" aria-controls="iws-mega"><?php esc_html_e( 'Services', 'iweb' ); ?> <svg class="iws-chev" viewBox="0 0 24 24" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg></button>
					<div class="iws-mega" id="iws-mega" hidden>
						<div class="iws-mega__inner">
							<div class="iws-mega__col iws-mega__cats">
								<p class="iws-mega__label"><?php esc_html_e( 'Our services', 'iweb' ); ?></p>
								<ul>
								<?php foreach ( $iweb_services as $i => $svc ) : ?>
									<li><a class="iws-cat<?php echo 0 === $i ? ' is-active' : ''; ?>" data-cat="<?php echo esc_attr( $svc['key'] ); ?>" href="<?php echo esc_url( $svc['url'] ); ?>"><span class="iws-cat__icon"><?php echo iweb_icon( $svc['icon'] ); // phpcs:ignore ?></span><span class="iws-cat__text"><?php echo esc_html( $svc['label'] ); ?></span><svg class="iws-cat__chev" viewBox="0 0 24 24" aria-hidden="true"><path d="m9 6 6 6-6 6"/></svg></a></li>
								<?php endforeach; ?>
								</ul>
							</div>
							<?php foreach ( $iweb_services as $i => $svc ) : ?>
							<div class="iws-mega__panel<?php echo 0 === $i ? ' is-active' : ''; ?>" data-panel="<?php echo esc_attr( $svc['key'] ); ?>">
								<div class="iws-mega__col iws-mega__subs">
									<p class="iws-mega__label"><?php echo esc_html( $svc['label'] ); ?></p>
									<ul>
									<?php foreach ( $svc['items'] as $item ) : ?>
										<li><a href="<?php echo esc_url( $svc['url'] ); ?>"><?php echo esc_html( $item ); ?></a></li>
									<?php endforeach; ?>
									</ul>
								</div>
								<div class="iws-mega__card">
									<span class="iws-mega__card-icon"><?php echo iweb_icon( $svc['card'] ); // phpcs:ignore ?></span>
									<p class="iws-mega__card-title"><?php echo esc_html( $svc['title'] ); ?></p>
									<p class="iws-mega__card-copy"><?php echo esc_html( $svc['copy'] ); ?></p>
									<a class="iws-mega__card-link" href="<?php echo esc_url( $svc['url'] ); ?>"><?php /* translators: %s service name */ printf( esc_html__( 'Explore %s', 'iweb' ), esc_html( $svc['label'] ) ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore ?></a>
								</div>
							</div>
							<?php endforeach; ?>
						</div>
					</div>
				</li>
				<?php foreach ( $iweb_links as $label => $url ) : ?>
				<li class="iws-nav__item"><a class="iws-nav__link" href="<?php echo esc_url( $url ); ?>"<?php echo trailingslashit( $url ) === $iweb_req ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $label ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</nav>

		<div class="iws-bar__end">
			<span class="iws-divider" aria-hidden="true"></span>
			<a class="iws-cta" href="<?php echo esc_url( home_url( '/contact' ) ); ?>"><?php esc_html_e( 'Start a project', 'iweb' ); ?> <span class="iws-cta__arrow"><?php echo iweb_icon( 'arrow' ); // phpcs:ignore ?></span></a>
			<button type="button" class="iws-burger" aria-expanded="false" aria-controls="iws-drawer" aria-label="<?php esc_attr_e( 'Open menu', 'iweb' ); ?>"><span></span><span></span><span></span></button>
		</div>
	</div>

	<div class="iws-drawer" id="iws-drawer" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Menu', 'iweb' ); ?>" hidden>
		<div class="iws-drawer__top">
			<a class="iws-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'IWS home', 'iweb' ); ?>"><?php echo $iweb_logo; // phpcs:ignore ?></a>
			<button type="button" class="iws-drawer__close" aria-label="<?php esc_attr_e( 'Close menu', 'iweb' ); ?>"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18"/></svg></button>
		</div>
		<div class="iws-drawer__body">
			<ul class="iws-m">
				<li>
					<button type="button" class="iws-m__row" aria-expanded="false" aria-controls="iws-m-services"><?php esc_html_e( 'Services', 'iweb' ); ?><svg class="iws-chev" viewBox="0 0 24 24" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg></button>
					<div class="iws-m__panel" id="iws-m-services" hidden>
						<ul>
						<?php foreach ( $iweb_services as $svc ) : ?>
							<li>
								<button type="button" class="iws-m__cat" aria-expanded="false" aria-controls="iws-m-<?php echo esc_attr( $svc['key'] ); ?>"><span class="iws-cat__icon"><?php echo iweb_icon( $svc['icon'] ); // phpcs:ignore ?></span><span><?php echo esc_html( $svc['label'] ); ?></span><svg class="iws-chev" viewBox="0 0 24 24" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg></button>
								<ul class="iws-m__subs" id="iws-m-<?php echo esc_attr( $svc['key'] ); ?>" hidden>
									<?php foreach ( $svc['items'] as $item ) : ?>
									<li><a href="<?php echo esc_url( $svc['url'] ); ?>"><?php echo esc_html( $item ); ?></a></li>
									<?php endforeach; ?>
									<li><a class="iws-m__all" href="<?php echo esc_url( $svc['url'] ); ?>"><?php printf( esc_html__( 'Explore %s', 'iweb' ), esc_html( $svc['label'] ) ); // phpcs:ignore ?> &rarr;</a></li>
								</ul>
							</li>
						<?php endforeach; ?>
						</ul>
					</div>
				</li>
				<?php foreach ( $iweb_links as $label => $url ) : ?>
				<li><a class="iws-m__row" href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $label ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
		<div class="iws-drawer__foot">
			<a class="iws-cta iws-cta--block" href="<?php echo esc_url( home_url( '/contact' ) ); ?>"><?php esc_html_e( 'Start a project', 'iweb' ); ?> <span class="iws-cta__arrow"><?php echo iweb_icon( 'arrow' ); // phpcs:ignore ?></span></a>
		</div>
	</div>
	<div class="iws-scrim" hidden></div>
</header><!-- #masthead -->

<div id="content" class="site-content">