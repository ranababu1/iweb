<?php
/**
 * Product-style UI visual built in HTML and CSS (no photos).
 *
 * Variants: stack (search + dashboard + code), seo, dashboard, code, form.
 * Purely decorative: wrapped in aria-hidden by the caller or here.
 *
 * @package iweb
 */

$iweb_variant = isset( $args['variant'] ) ? $args['variant'] : 'stack';
$iweb_parts   = 'stack' === $iweb_variant ? array( 'seo', 'dashboard', 'code' ) : array( $iweb_variant );
?>
<div class="ui-mock ui-mock--<?php echo esc_attr( $iweb_variant ); ?>" aria-hidden="true">
	<?php foreach ( $iweb_parts as $iweb_part ) : ?>
		<?php if ( 'seo' === $iweb_part ) : ?>
			<div class="ui-frame ui-frame--seo">
				<div class="ui-frame__bar"><span></span><span></span><span></span><em>google.com</em></div>
				<div class="ui-search"><?php echo iweb_icon( 'search' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <span>seo agency for small business</span></div>
				<div class="ui-result ui-result--top">
					<small>yourbusiness.com</small>
					<strong>Your Business | Fast WordPress, SEO and growth</strong>
					<p>High-performance websites that get found and turn visitors into customers.</p>
				</div>
				<div class="ui-result ui-result--ai">
					<b><?php echo iweb_icon( 'sparkle' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> AI overview</b>
					<p>Cites <mark>yourbusiness.com</mark> as a trusted source.</p>
				</div>
				<div class="ui-lines"><i></i><i></i><i></i></div>
			</div>
		<?php elseif ( 'dashboard' === $iweb_part ) : ?>
			<div class="ui-frame ui-frame--dash">
				<div class="ui-frame__bar"><span></span><span></span><span></span><em>Performance</em></div>
				<div class="ui-dash">
					<div class="ui-chips"><span class="is-good">LCP Good</span><span class="is-good">INP Good</span><span class="is-good">CLS Good</span></div>
					<p class="ui-label">Organic sessions</p>
					<svg class="ui-chart" viewBox="0 0 300 110" preserveAspectRatio="none">
						<path class="ui-chart__area" d="M0 100 L0 86 C40 82 60 78 90 70 S150 64 180 48 S240 30 300 12 L300 100 Z"/>
						<path class="ui-chart__line" d="M0 86 C40 82 60 78 90 70 S150 64 180 48 S240 30 300 12"/>
					</svg>
					<div class="ui-bars"><i style="--h:40%"></i><i style="--h:55%"></i><i style="--h:48%"></i><i style="--h:70%"></i><i style="--h:64%"></i><i style="--h:86%"></i><i style="--h:100%"></i></div>
				</div>
			</div>
		<?php elseif ( 'code' === $iweb_part ) : ?>
			<div class="ui-frame ui-frame--code">
				<div class="ui-frame__bar"><span></span><span></span><span></span><em>functions.php</em></div>
<pre class="ui-code"><b>add_action</b>( <s>'init'</s>, <b>function</b> () {
  <i>// Clean, fast, no bloat.</i>
  register_block_pattern( <s>'iws/hero'</s> );
  <b>if</b> ( is_lead( $form ) ) {
    send_to_crm( $form );
  }
} );</pre>
			</div>
		<?php elseif ( 'form' === $iweb_part ) : ?>
			<div class="ui-frame ui-frame--form">
				<div class="ui-frame__bar"><span></span><span></span><span></span><em>New enquiry</em></div>
				<div class="ui-form">
					<span class="ui-field"><small>Project</small>New website + SEO</span>
					<span class="ui-field"><small>Goal</small>More qualified leads</span>
					<span class="ui-field ui-field--area"><small>Details</small><i></i><i></i></span>
					<span class="ui-send">Send enquiry <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
				</div>
			</div>
		<?php endif; ?>
	<?php endforeach; ?>
</div>
