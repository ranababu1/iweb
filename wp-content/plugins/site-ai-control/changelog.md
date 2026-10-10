## 0.5.1 - OAuth client compatibility fix

- Restored `wpmedia_mcp_oauth_allow_untrusted_providers` compatibility filter so valid CIMD clients can reach consent with older OAuth library versions that hard-reject unknown clients.
- Retained Grok publisher metadata registration for exact client-ID verification.
- Clarified that OAuth plugin detection does not confirm a successful Grok connection and that unverified-client consent must be reviewed carefully.

# Changelog

## 0.5.0 - Portable MCP foundation and Yoast taxonomy metadata

- Added `site-ai/get-yoast-term-meta` for reading supported Yoast metadata on taxonomy terms.
- Added `site-ai/update-yoast-term-meta` for allowlisted, validated taxonomy SEO metadata updates.
- Expanded post SEO updates to eligible public, UI-managed post types with per-object edit checks; attachments and revisions are excluded.
- Removed the global opt-in to untrusted OAuth providers; preserve the OAuth layer's trusted-publisher validation.
- Updated admin ability inventory and documentation for multi-site portability and client compatibility limitations.

## 0.3.3
- Fix: OAuth compatibility for non-Claude MCP clients by enabling valid untrusted CIMD providers through the maintained wp-media/mcp-oauth filter.
- Fix: Grok publisher registration remains available as a verified publisher.
- Security: OAuth library validation, PKCE, CIMD URL validation, and WordPress consent remain in force; this does not accept arbitrary non-CIMD clients.
# Changelog

## 0.4.0 - Bulk dates, find-and-replace, and AI-slop detection

### Added
- Added `site-ai/update-post-dates`: set or shift publish dates for a controlled selection of posts (explicit IDs or taxonomy terms) in a single call. Supports `set` (absolute date, `Y-m-d` preserves each post's time of day) and `shift` (relative move) modes, `dry_run` preview, site-timezone-correct `post_date_gmt` handling, and per-post edit permission checks. Never changes post status or content.
- Added `site-ai/find-replace-content`: plain-text or regex find-and-replace over post content for explicit IDs or a taxonomy selection, with case-sensitivity control, `dry_run` match preview with context snippets, `wp_kses_post` sanitization for users without `unfiltered_html`, and per-post edit permission checks. Annotated `destructive: true`; WordPress revisions remain the rollback path.
- Added `site-ai/detect-ai-slop`: read-only, fully local heuristic AI-slop scoring (weighted cliche phrase density, sentence-length uniformity, stock transition starters, em-dash and rule-of-three density, lexical diversity) with a 0-100 score, verdict, matched phrases, `min_score` filtering, and `include_details`.
- Added a shared controlled selection helper used by the three new abilities (explicit post IDs or public taxonomy terms).

### Security
- The new bulk abilities are field-scoped (dates and content substitution only), not generic CRUD or generic bulk writes.
- Write abilities enforce per-post `edit_post` checks at execution time; posts the authenticated user cannot edit are skipped and reported.
- No SQL, arbitrary options, arbitrary post meta, filesystem, shell, or PHP execution primitives were added.
- AI-slop detection is deterministic, local, and heuristic. It is a review signal, not proof of AI authorship, and sends no data off-site.

### Tests
- Added a standalone harness in `tests/` covering date updates, find-and-replace (plain, regex, dry-run, literal `$`), slop scoring, and the selection helper.

## 0.3.3 - Universal MCP OAuth publisher bridge

- Added Grok's published MCP OAuth Client ID Metadata Document to the maintained `wp-media/mcp-oauth` trusted-publisher list via the official `wpmedia_mcp_oauth_trusted_publishers` filter.
- Kept the OAuth trust model explicit; arbitrary OAuth clients are not accepted.
- Preserved the existing Claude OAuth behavior and all existing Site AI abilities.

## 0.3.1

- Added `site-ai/get-categories` for listing WordPress post categories, including empty categories and post counts.
- Supports `empty_only`, `limit`, and `offset`.


## 0.3.0 - Universal MCP client architecture

### Added
- Reframed Site AI Control as a client-neutral MCP capability layer rather than a Claude-specific integration.
- Added a Universal MCP connection section to the admin diagnostics screen.
- Added separate endpoint guidance for OAuth-capable hosted clients and Application Password/local bridge clients.
- Added client guidance for Claude, ChatGPT, Gemini, Qwen, Ollama, and generic MCP-compatible clients.
- Added an Ollama integration guide and companion agent package documentation.
- Documented Ollama local models and Ollama Cloud models as interchangeable model runtimes behind the same MCP tool layer.

### Design decision
- Site AI Control does not contain provider-specific LLM logic.
- MCP remains the integration contract.
- WordPress MCP Adapter remains the MCP server/transport layer.
- Enable Abilities for MCP remains the OAuth layer for hosted clients where supported.
- Ollama is integrated through an external MCP client/agent rather than adding Ollama code to the WordPress plugin.
- Existing site-ai abilities and their permission model are unchanged.

### Security
- No new generic WordPress CRUD, SQL, shell, filesystem, plugin, theme, or arbitrary meta capabilities were added.
- Hosted OAuth clients should authenticate as a least-privilege WordPress user.
- Local bridges and Ollama should use a dedicated Application Password user.

## 0.2.0 - Claude Chat OAuth integration bridge

### Added
- Added admin diagnostics for the Claude Chat OAuth companion integration.
- Added the MCP endpoint URL to the Site AI Control diagnostics page.
- Added explicit setup guidance for using `Enable Abilities for MCP` as the maintained OAuth layer.
- Added a security reminder not to place WordPress Application Passwords into Claude Chat custom connector settings.

### Design decision
- Site AI Control does not implement or fork OAuth 2.1 itself.
- Claude Chat OAuth is delegated to the maintained `wp-media/mcp-oauth` implementation bundled by `Enable Abilities for MCP`.
- Site AI Control remains the tightly scoped ability layer. The companion plugin provides authentication and per-ability exposure controls.

## [0.1.1] - 2026-08-17

### Fixed
- Fixed a fatal error during Abilities API registration caused by omitted category arguments on the write, content-audit, SEO-audit, and Google ability registrations.
- Corrected ability REST exposure to use the WordPress Abilities API `meta.show_in_rest` location.
- Corrected Site Kit detection to use the official `GOOGLESITEKIT_VERSION` constant rather than an incorrect class check.
- Corrected the Site Kit dependency check to use the official Site Kit version constant.
- This release specifically addresses the WordPress Site Health/REST preload fatal error that could cause Site Kit admin pages to WSOD.

## [0.1.0] - 2026-08-17

### Added

#### Plugin foundation
- Created the `Site AI Control` plugin.
- Added WordPress 6.9+ Abilities API compatibility check.
- Added an admin diagnostics page under `Tools -> Site AI Control`.
- Added explicit MCP exposure using `meta.mcp.public = true`.
- Added REST exposure with `show_in_rest = true`.
- Added separate ability categories for data, SEO, content, Google and modification operations.
- Added `instructions.md` as the complete project plan and continuation guide.

#### WordPress Site Health
- Added `site-ai/get-site-health`.
- Returns WordPress/site environment information.
- Executes available direct WordPress Site Health checks.
- Executes available asynchronous Site Health checks through their direct callable where WordPress exposes one.

#### SEO discovery
- Added `site-ai/get-pages-needing-seo`.
- Added `site-ai/get-posts-missing-meta`.
- Supports controlled pagination.
- Supports posts and pages only.
- Uses Yoast's Surfaces API when available.
- Falls back to Yoast post meta where required.
- Distinguishes the normal meta description from the OpenGraph description.
- Reports missing SEO fields with severity.

#### SEO auditing
- Added `site-ai/seo-audit`.
- Checks generated Yoast SEO metadata.
- Checks SEO title length.
- Checks meta description length.
- Checks canonical.
- Checks OpenGraph metadata.
- Checks Twitter card presence.
- Reports robots noindex.
- Reports missing focus keyphrase as informational.
- Combines SEO findings with the content audit.

#### Content auditing
- Added `site-ai/run-content-audit`.
- Reports word count.
- Reports H1/H2/H3 counts.
- Reports internal/external links.
- Reports image count.
- Reports missing alt text.
- Reports excerpt presence.
- Reports basic content structure issues.

#### Yoast write operation
- Added `site-ai/update-yoast-meta`.
- Supports controlled Yoast fields only.
- Uses post-level WordPress edit permissions.
- Supports SEO title.
- Supports meta description.
- Supports canonical.
- Supports focus keyphrase.
- Supports OpenGraph title and description.
- Supports Twitter title and description.
- Returns normalized SEO data after the update.
- Triggers the normal WordPress post-save lifecycle after metadata changes so Yoast can refresh indexable/generated state.

#### Resource workflow
- Added `site-ai/create-resource`.
- A resource is represented by a normal WordPress post.
- Always creates a draft.
- Supports title, content, excerpt, slug, categories, tags and featured image.
- Supports optional initial SEO metadata.
- Added `site-ai/publish-resource`.
- Publishes an existing WordPress post only.
- Requires WordPress publish and post-edit capabilities.
- Does not create content.

#### Google / Site Kit
- Added `site-ai/get-search-console-data`.
- Uses the existing Site Kit Search Console connection.
- Supports date range, dimensions, URL filtering and row limits.
- Added controlled default date behavior.
- Added `site-ai/get-page-speed`.
- Uses the existing Site Kit PageSpeed Insights connection.
- Supports mobile and desktop.
- Returns normalized Lighthouse category scores.
- Returns selected key performance audits.
- Added `site-ai/get-ga4-summary`.
- Uses the existing Site Kit Analytics 4 connection.
- Returns a controlled set of traffic and engagement metrics.
- Supports date range.
- Supports optional page-path filtering.
- Uses a daily dimension by default.

#### Security / safety
- No generic WordPress CRUD ability.
- No arbitrary post meta ability.
- No arbitrary options ability.
- No SQL ability.
- No shell execution.
- No PHP execution.
- No filesystem access through MCP.
- No automatic publishing from `create-resource`.
- No bulk-write ability.
- Google data is accessed through the existing Site Kit connection rather than introducing a second Google OAuth system.
- MCP exposure is explicit per ability.

### Known limitations
- Google abilities depend on Site Kit's existing connection and permissions.
- Site Kit REST routes are an integration dependency and should be regression-tested after Site Kit upgrades.
- Content/SEO scoring is deterministic and heuristic.
- `get-posts-missing-meta` and `get-pages-needing-seo` use scan-based pagination.
- No LiteSpeed Cache purge ability yet.
- No ACF abilities.
- No bulk SEO update ability.
- No approval token system yet.
- No persistent audit log yet.

## [Unreleased]

### Planned

- Verify all abilities from multiple MCP clients against the production MCP Adapter.
- Verify Site Kit permissions for the dedicated MCP user.
- Add robust Site Kit 401/403 diagnostics.
- Add richer Yoast schema and indexability checks.
- Add Search Console page/query opportunity analysis.
- Add GA4 post performance summaries.
- Add LiteSpeed Cache purge ability with narrowly scoped operations.
- Add audit logging for write operations.
- Add stronger publish preconditions.
- Add rollback support.
- Add automated tests.
