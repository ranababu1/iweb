<?php
/**
 * Service hub hero: headline on the left, numbered step panel on the right.
 *
 * Expects $args with keys: label, lines (array), highlight, lead,
 * steps (array of [icon, title, subtitle]), result_icon, result.
 *
 * @package iweb
 * @since 1.3.0
 */

$iweb_h = wp_parse_args(
	isset( $args ) ? $args : array(),
	array(
		'label'       => '',
		'lines'       => array(),
		'highlight'   => '',
		'lead'        => '',
		'steps'       => array(),
		'result_icon' => 'clock',
		'result'      => '',
	)
);

if ( ! function_exists( 'iweb_svc_icon' ) ) {
	/**
	 * Inline SVG icon for the service hero.
	 *
	 * @param string $name Icon key.
	 * @return string SVG markup.
	 */
	function iweb_svc_icon( $name ) {
		$p = array(
			'doc'      => '<path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5M9 13h6M9 17h6"/>',
			'sparkle'  => '<path d="M12 3l1.8 5.2L19 10l-5.2 1.8L12 17l-1.8-5.2L5 10l5.2-1.8z"/><path d="M19 15l.7 2.3L22 18l-2.3.7L19 21l-.7-2.3L16 18l2.3-.7z"/>',
			'database' => '<ellipse cx="12" cy="5" rx="7" ry="3"/><path d="M5 5v14c0 1.7 3.1 3 7 3s7-1.3 7-3V5M5 12c0 1.7 3.1 3 7 3s7-1.3 7-3"/>',
			'mail'     => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/>',
			'check'    => '<circle cx="12" cy="12" r="9"/><path d="M8 12l3 3 5-6"/>',
			'slack'    => '<path d="M10 3a2 2 0 0 0 0 4h2V5a2 2 0 0 0-2-2zM3 10a2 2 0 0 0 4 0V8H5a2 2 0 0 0-2 2zM14 21a2 2 0 0 0 0-4h-2v2a2 2 0 0 0 2 2zM21 14a2 2 0 0 0-4 0v2h2a2 2 0 0 0 2-2z"/><path d="M12 7v5M7 12h5M12 17v-5M17 12h-5"/>',
			'clock'    => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
			'search'   => '<circle cx="11" cy="11" r="7"/><path d="M20 20l-4-4"/>',
			'target'   => '<circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="5"/><circle cx="12" cy="12" r="1"/>',
			'pen'      => '<path d="M4 20h4L19 9l-4-4L4 16z"/><path d="M13 7l4 4"/>',
			'code'     => '<path d="M8 8l-4 4 4 4M16 8l4 4-4 4M14 5l-4 14"/>',
			'pin'      => '<path d="M12 21s-7-6.2-7-11a7 7 0 0 1 14 0c0 4.8-7 11-7 11z"/><circle cx="12" cy="10" r="2.5"/>',
			'chart'    => '<path d="M4 20V4M4 20h16"/><path d="M8 16l4-5 3 3 5-6"/>',
			'trend'    => '<path d="M3 17l6-6 4 4 8-8"/><path d="M15 7h6v6"/>',
			'bolt'     => '<path d="M13 2L4 14h7l-1 8 9-12h-7z"/>',
			'layout'   => '<rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 9h18M9 9v11"/>',
			'form'     => '<rect x="4" y="3" width="16" height="18" rx="2"/><path d="M8 8h8M8 12h8M8 16h4"/>',
			'split'    => '<path d="M6 3v6a4 4 0 0 0 4 4h4a4 4 0 0 1 4 4v4M18 3v6a4 4 0 0 1-4 4"/><path d="M3 6l3-3 3 3M15 6l3-3 3 3"/>',
			'refresh'  => '<path d="M20 11a8 8 0 0 0-14.6-4.5L4 8M4 13a8 8 0 0 0 14.6 4.5L20 16"/><path d="M4 4v4h4M20 20v-4h-4"/>',
			'users'    => '<circle cx="9" cy="8" r="3.5"/><path d="M2.5 20a6.5 6.5 0 0 1 13 0"/><path d="M16 4.5a3.5 3.5 0 0 1 0 7M18 14a6 6 0 0 1 3.5 6"/>',
			'tag'      => '<path d="M3 12V4h8l10 10-8 8z"/><circle cx="7.5" cy="8.5" r="1.5"/>',
			'link'     => '<path d="M10 14a4 4 0 0 0 5.7 0l3-3a4 4 0 0 0-5.7-5.7l-1 1"/><path d="M14 10a4 4 0 0 0-5.7 0l-3 3a4 4 0 0 0 5.7 5.7l1-1"/>',
			'gauge'    => '<path d="M4 18a8 8 0 1 1 16 0"/><path d="M12 18l4-6"/>',
			'bulb'     => '<path d="M9 18h6M10 21h4"/><path d="M12 3a6 6 0 0 0-3.5 10.9c.6.5 1 1.2 1 2.1h5c0-.9.4-1.6 1-2.1A6 6 0 0 0 12 3z"/>',
			'arrow'    => '<path d="M7 17L17 7M9 7h8v8"/>',
			'calendar' => '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/>',
		);
		$d = isset( $p[ $name ] ) ? $p[ $name ] : $p['check'];
		return '<svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $d . '</svg>';
	}
}
?>
<section class="svc-hero">
	<div class="container svc-hero__inner">
		<div class="svc-hero__copy">
			<nav class="svc-hero__crumbs" aria-label="<?php esc_attr_e( 'Breadcrumb', 'iweb' ); ?>">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'iweb' ); ?></a> <span aria-hidden="true">›</span>
				<a href="<?php echo esc_url( home_url( '/services/' ) ); ?>"><?php esc_html_e( 'Services', 'iweb' ); ?></a> <span aria-hidden="true">›</span>
				<span aria-current="page"><?php echo esc_html( $iweb_h['label'] ); ?></span>
			</nav>
			<p class="svc-hero__eyebrow"><?php echo esc_html( $iweb_h['label'] ); ?></p>
			<h1 class="svc-hero__title">
				<?php foreach ( $iweb_h['lines'] as $iweb_line ) : ?>
					<span class="svc-hero__line"><?php echo esc_html( $iweb_line ); ?></span>
				<?php endforeach; ?>
				<span class="svc-hero__line svc-hero__line--hl"><?php echo esc_html( $iweb_h['highlight'] ); ?></span>
			</h1>
			<p class="svc-hero__lead"><?php echo esc_html( $iweb_h['lead'] ); ?></p>
			<div class="svc-hero__ctas">
				<a class="svc-btn svc-btn--lime" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Start a project', 'iweb' ); ?> <span class="svc-btn__dot"><?php echo iweb_svc_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span></a>
				<a class="svc-btn svc-btn--outline" href="<?php echo esc_url( home_url( '/book-a-call/' ) ); ?>"><?php echo iweb_svc_icon( 'calendar' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'Book a free audit call', 'iweb' ); ?></a>
			</div>
			<p class="svc-hero__note"><?php esc_html_e( 'No long contracts required to get started.', 'iweb' ); ?></p>
		</div>

		<div class="svc-hero__panel" aria-hidden="true">
			<div class="svc-flow">
				<ol class="svc-flow__steps">
					<?php foreach ( $iweb_h['steps'] as $iweb_i => $iweb_s ) : ?>
						<li class="svc-step">
							<span class="svc-step__icon"><?php echo iweb_svc_icon( $iweb_s[0] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
							<span class="svc-step__text"><strong><?php echo esc_html( $iweb_s[1] ); ?></strong><small><?php echo esc_html( $iweb_s[2] ); ?></small></span>
							<span class="svc-step__num"><?php echo esc_html( $iweb_i + 1 ); ?></span>
						</li>
					<?php endforeach; ?>
				</ol>
				<div class="svc-flow__link"></div>
				<div class="svc-result">
					<span class="svc-result__marks"></span>
					<span class="svc-result__icon"><?php echo iweb_svc_icon( $iweb_h['result_icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<p><?php echo esc_html( $iweb_h['result'] ); ?></p>
				</div>
			</div>
		</div>
	</div>
</section>
