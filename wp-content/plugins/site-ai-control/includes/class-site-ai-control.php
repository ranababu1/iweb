<?php
namespace Site_AI_Control;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Plugin {

	public static function init(): void {
		if ( ! class_exists( 'WP_Ability' ) || ! function_exists( 'wp_register_ability' ) ) {
			add_action(
				'admin_notices',
				static function () {
					if ( current_user_can( 'activate_plugins' ) ) {
						echo '<div class="notice notice-error"><p><strong>Site AI Control:</strong> WordPress 6.9+ Abilities API is required.</p></div>';
					}
				}
			);
			return;
		}

		Abilities::init();
		Admin::init();
	}
}

final class Admin {

	public static function init(): void {
		add_action( 'admin_menu', array( __CLASS__, 'menu' ) );
	}

	public static function menu(): void {
		add_management_page(
			'Site AI Control',
			'Site AI Control',
			'manage_options',
			'site-ai-control',
			array( __CLASS__, 'render' )
		);
	}

	public static function render(): void {
		$site_kit   = defined( 'GOOGLESITEKIT_VERSION' );
		$yoast      = defined( 'WPSEO_VERSION' );
		$mcp        = defined( 'MCP_ADAPTER_VERSION' ) || is_plugin_active( 'mcp-adapter/mcp-adapter.php' );
		$oauth      = is_plugin_active( 'enable-abilities-for-mcp/enable-abilities-for-mcp.php' );
				$adapter_url = home_url( '/wp-json/mcp/mcp-adapter-default-server' );
		$oauth_url   = home_url( '/wp-json/mcp/mcp-oauth-server' );
		$mcp_url     = $oauth ? $oauth_url : $adapter_url;
		?>
		<div class="wrap">
			<h1>Site AI Control</h1>
			<p>This plugin exposes tightly scoped WordPress Abilities to the WordPress MCP Adapter so any compatible MCP client can use the same site capabilities.</p>

			<table class="widefat striped" style="max-width:900px">
				<tbody>
					<tr><td><strong>Plugin version</strong></td><td><?php echo esc_html( SITE_AI_CONTROL_VERSION ); ?></td></tr>
					<tr><td><strong>WordPress</strong></td><td><?php echo esc_html( get_bloginfo( 'version' ) ); ?></td></tr>
					<tr><td><strong>Yoast SEO</strong></td><td><?php echo $yoast ? esc_html( WPSEO_VERSION ) : 'Not detected'; ?></td></tr>
					<tr><td><strong>Site Kit</strong></td><td><?php echo $site_kit ? 'Detected' : 'Not detected'; ?></td></tr>
					<tr><td><strong>MCP Adapter</strong></td><td><?php echo $mcp ? 'Detected' : 'Not detected'; ?></td></tr>
					<tr><td><strong>OAuth layer</strong></td><td><?php echo $oauth ? 'Enable Abilities for MCP detected' : 'Not detected'; ?></td></tr>
				</tbody>
			</table>

			<h2>Universal MCP connection</h2>
			<p><strong>Security note:</strong> standards-compliant but unverified CIMD clients may reach the OAuth consent screen for compatibility. Review the displayed client identity carefully and authorize only clients you trust. Use dedicated, least-privilege WordPress accounts. The Grok publisher entry is only a trust label for an exact client ID; it does not prove that a connection has succeeded.</p>
			<p><strong>Primary endpoint:</strong> <code><?php echo esc_html( $mcp_url ); ?></code></p>
			<p>Site AI Control is client-neutral. The MCP server exposes the same WordPress capabilities to any MCP-compatible AI client. Claude is one client, not the architecture.</p>
			<table class="widefat striped" style="max-width:900px">
				<thead><tr><th>Client</th><th>Recommended connection</th><th>Status</th></tr></thead>
				<tbody>
					<tr><td>Claude</td><td>OAuth custom connector</td><td><?php echo $oauth ? 'OAuth layer detected' : 'Install Enable Abilities for MCP'; ?></td></tr>
					<tr><td>Grok</td><td>OAuth custom MCP connector</td><td><?php echo $oauth ? 'OAuth layer detected; actual client ID and authorization must be verified' : 'OAuth layer not detected'; ?></td></tr>
					<tr><td>ChatGPT</td><td>Remote MCP / custom connector where enabled</td><td>Use the MCP endpoint and the client's supported OAuth flow</td></tr>
					<tr><td>Gemini</td><td>Remote MCP client or Gemini CLI</td><td>Use the MCP endpoint or a local bridge when required</td></tr>
					<tr><td>Qwen</td><td>MCP-capable client / Qwen Code</td><td>Use the MCP endpoint or local bridge</td></tr>
					<tr><td>Ollama</td><td>Local MCP agent or MCP-capable host</td><td>Use the companion Ollama agent with a dedicated Application Password</td></tr>
					<tr><td>Other models</td><td>Any MCP-compatible client/framework</td><td>Use standard MCP transport and authentication supported by the client</td></tr>
				</tbody>
			</table>

			<h3>Connection URLs</h3>
			<ul>
				<li><strong>OAuth-capable clients:</strong> <code><?php echo esc_html( $oauth_url ); ?></code></li>
				<li><strong>Application Password / local bridge clients:</strong> <code><?php echo esc_html( $adapter_url ); ?></code></li>
			</ul>

			<?php if ( $oauth ) : ?>
				<p><strong>OAuth detected.</strong> Keep the OAuth flow for clients that support it. Each connection should authenticate as a least-privilege WordPress user. Do not put an Application Password into a hosted chat connector that supports OAuth.</p>
			<?php else : ?>
				<p><strong>OAuth layer not detected.</strong> Install <em>Enable Abilities for MCP</em> if you want the current Claude OAuth integration. Application Password connections remain available for compatible local clients and bridges.</p>
			<?php endif; ?>

			<h3>Ollama</h3>
			<p>Ollama is treated as an AI runtime, not as a WordPress-specific integration. The companion MCP client can use either a local Ollama model or an Ollama Cloud model while keeping the same WordPress MCP tools.</p>
			<p>Cloud models can be run through the local Ollama application, so the MCP tools remain local to the agent process while the model may execute in Ollama Cloud. See the companion package documentation.</p>
			<p><strong>Security:</strong> use the dedicated <code>eddy</code> account or another least-privilege agent account. Never use an Administrator account for an unattended agent.</p>

			<h2>Abilities</h2>
			<p>All abilities are registered under the <code>site-ai/</code> namespace. MCP exposure is explicit.</p>

			<table class="widefat striped" style="max-width:1100px">
				<thead>
					<tr><th>Ability</th><th>Type</th><th>Purpose</th></tr>
				</thead>
				<tbody>
					<?php
					$abilities = array(
						array( 'site-ai/get-site-health', 'Read', 'WordPress Site Health and environment checks.' ),
						array( 'site-ai/get-pages-needing-seo', 'Read', 'Find pages with missing or weak SEO metadata.' ),
						array( 'site-ai/get-posts-missing-meta', 'Read', 'Find published posts with missing SEO metadata.' ),
						array( 'site-ai/update-yoast-meta', 'Write', 'Update controlled Yoast SEO metadata for supported public post types.' ),
						array( 'site-ai/get-yoast-term-meta', 'Read', 'Read supported Yoast metadata for a taxonomy term/archive.' ),
						array( 'site-ai/update-yoast-term-meta', 'Write', 'Update controlled Yoast metadata for a taxonomy term/archive.' ),
						array( 'site-ai/create-resource', 'Write', 'Create a WordPress post as a draft.' ),
						array( 'site-ai/publish-resource', 'Write', 'Publish an existing WordPress post after approval.' ),
						array( 'site-ai/run-content-audit', 'Read', 'Analyze post content structure and basic quality signals.' ),
						array( 'site-ai/seo-audit', 'Read', 'Audit generated Yoast SEO output and content SEO signals.' ),
						array( 'site-ai/get-search-console-data', 'Read', 'Read Search Console data through Site Kit.' ),
						array( 'site-ai/get-page-speed', 'Read', 'Read PageSpeed Insights data through Site Kit.' ),
						array( 'site-ai/get-ga4-summary', 'Read', 'Read GA4 summary data through Site Kit.' ),
						array( 'site-ai/update-post-dates', 'Write', 'Set or shift publish dates for selected posts or a taxonomy selection, with dry-run preview.' ),
						array( 'site-ai/find-replace-content', 'Write', 'Find and replace text in post content, plain or regex, with dry-run preview.' ),
						array( 'site-ai/detect-ai-slop', 'Read', 'Heuristic AI-slop scoring of post content.' ),
					);
					foreach ( $abilities as $ability ) :
						?>
						<tr>
							<td><code><?php echo esc_html( $ability[0] ); ?></code></td>
							<td><?php echo esc_html( $ability[1] ); ?></td>
							<td><?php echo esc_html( $ability[2] ); ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

			<h2>Security model</h2>
			<ul>
				<li>Read abilities require an authenticated WordPress user with appropriate capability.</li>
				<li>Write abilities use post-level WordPress capability checks.</li>
				<li><code>create-resource</code> always creates a draft.</li>
				<li><code>publish-resource</code> is a separate operation and never creates content.</li>
				<li><code>update-post-dates</code> and <code>find-replace-content</code> enforce per-post edit checks and support <code>dry_run</code> previews.</li>
				<li>No arbitrary post meta, options, SQL, PHP execution, or filesystem abilities are exposed.</li>
			</ul>

			<h2>Important</h2>
			<p>Do not give an AI agent an Administrator account unless you deliberately choose to. Prefer a dedicated WordPress user and grant only the capabilities needed by this plugin and Site Kit dashboard sharing.</p>
		</div>
		<?php
	}
}
