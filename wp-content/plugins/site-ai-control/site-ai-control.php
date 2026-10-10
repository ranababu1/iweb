<?php
/**
 * Plugin Name: Site AI Control
 * Description: Controlled WordPress Abilities for MCP/AI agents, focused on SEO, content, find-and-replace, post dates, AI-slop detection, and Google Site Kit data.
 * Version: 0.5.1
 * Author: Imran
 * Requires at least: 6.9
 * Requires PHP: 7.4
 * License: GPL-2.0-or-later
 * Text Domain: site-ai-control
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Compatibility: allow standards-compliant CIMD clients to reach the OAuth
 * consent flow on older wp-media/mcp-oauth releases that default to rejecting
 * untrusted clients. The OAuth library must still validate HTTPS client
 * metadata, redirect URIs, PKCE, and tokens; users must review the consent
 * screen before authorizing a client. This is not a publisher verification
 * signal.
 *
 * Current wp-media/mcp-oauth releases allow unverified clients by default and
 * display an explicit warning at consent. This filter keeps older bundled
 * versions compatible with MCP clients whose client_id is not on the trusted
 * publisher allowlist.
 */
add_filter(
	'wpmedia_mcp_oauth_allow_untrusted_providers',
	'__return_true',
	10
);

/**
 * Register Grok's published CIMD identity as a trusted publisher so the
 * consent UI can identify it when its client_id exactly matches this URL.
 * This registration alone does not prove that a Grok connection succeeds.
 */
add_filter(
	'wpmedia_mcp_oauth_trusted_publishers',
	static function ( array $publishers ): array {
		$publishers['grok'] = array(
			'client_ids' => array(
				'https://grok.com/oauth/mcp-client.json',
			),
			'host'       => 'grok.com',
		);

		return $publishers;
	},
	10
);

define( 'SITE_AI_CONTROL_VERSION', '0.5.1' );
define( 'SITE_AI_CONTROL_FILE', __FILE__ );
define( 'SITE_AI_CONTROL_DIR', plugin_dir_path( __FILE__ ) );

require_once SITE_AI_CONTROL_DIR . 'includes/class-site-ai-control.php';
require_once SITE_AI_CONTROL_DIR . 'includes/class-site-ai-abilities.php';
require_once SITE_AI_CONTROL_DIR . 'includes/class-site-ai-seo.php';
require_once SITE_AI_CONTROL_DIR . 'includes/class-site-ai-content.php';
require_once SITE_AI_CONTROL_DIR . 'includes/class-site-ai-google.php';
require_once SITE_AI_CONTROL_DIR . 'includes/class-site-ai-health.php';
require_once SITE_AI_CONTROL_DIR . 'includes/class-site-ai-slop.php';

add_action(
	'plugins_loaded',
	static function () {
		\Site_AI_Control\Plugin::init();
	}
);
