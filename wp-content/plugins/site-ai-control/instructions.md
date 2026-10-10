# Site AI Control

## Purpose

`Site AI Control` is a private WordPress plugin for exposing a tightly controlled set of WordPress Abilities to the official WordPress MCP Adapter. It is deliberately client-neutral. Claude, ChatGPT, Gemini, Qwen, Ollama-based agents, IDE agents, and other MCP-compatible clients should consume the same capability layer.

## Current architecture

```text
Any MCP-compatible AI client
  |\
  | \__ Claude / ChatGPT / Gemini / Qwen / Ollama / IDEs / custom agents
  v
MCP transport + authentication
  |
  v
WordPress MCP Adapter
  |
  v
WordPress Abilities API
  |
  v
Site AI Control
  |
  +-- WordPress core
  +-- Yoast SEO
  +-- Site Kit by Google
  +-- Posts / Pages
```

The MCP Adapter is the protocol boundary. Site AI Control must not contain provider-specific model logic.

## Development rule

Before changing this plugin, read this file and `changelog.md`.

Do not remove, rename, broaden, or replace an existing ability without documenting the change in `changelog.md`.

Do not expose generic WordPress CRUD, arbitrary post meta, arbitrary options, SQL, filesystem operations, PHP execution, shell execution, plugin/theme management, or arbitrary API proxying through MCP.

Every new ability must:

1. Have a `site-ai/` namespace.
2. Have a precise input schema.
3. Have a precise output schema.
4. Have a permission callback.
5. Have MCP exposure explicitly enabled with `meta.mcp.public = true`.
6. Have appropriate `meta.annotations`.
7. Be documented here.
8. Be added to `changelog.md` when implemented.
9. Be tested before being marked complete.

## Current abilities

### Read-only

- `site-ai/get-site-health`
- `site-ai/get-pages-needing-seo`
- `site-ai/get-posts-missing-meta`
- `site-ai/run-content-audit`
- `site-ai/seo-audit`
- `site-ai/get-search-console-data`
- `site-ai/get-page-speed`
- `site-ai/get-ga4-summary`
- `site-ai/detect-ai-slop`

### Write

- `site-ai/update-yoast-meta`
- `site-ai/create-resource`
- `site-ai/publish-resource`
- `site-ai/update-post-dates`
- `site-ai/find-replace-content`

## MCP connection model

The WordPress MCP Adapter provides a default HTTP MCP server. Public abilities are exposed through a small discovery layer consisting of discover, get-info, and execute tools. This is intentional and avoids sending every WordPress ability schema to the model at connection time.

For hosted OAuth clients, the current `Enable Abilities for MCP` plugin provides the OAuth layer and Claude custom connector support. Do not implement a second OAuth server inside Site AI Control.

For local bridges and clients that use Application Passwords, use the official MCP Adapter HTTP endpoint:

```text
https://example.com/wp-json/mcp/mcp-adapter-default-server
```

For this site, the OAuth-aware endpoint is:

```text
https://imraan.in/wp-json/mcp/mcp-oauth-server
```

and the Application Password endpoint is:

```text
https://imraan.in/wp-json/mcp/mcp-adapter-default-server
```

## Ollama architecture

Ollama is an AI model runtime, not a WordPress-specific protocol. Use a separate MCP client/agent to connect an Ollama model to the WordPress MCP endpoint.

```text
Ollama local model
        or
Ollama Cloud model
        |
        v
MCP client / agent
        |
        v
WordPress MCP Adapter
        |
        v
Site AI Control
```

Ollama Cloud models can be run through the local Ollama application. This lets the model execute against the same local MCP client and WordPress tools while the model itself runs in Ollama Cloud.

The companion `site-ai-ollama-agent` package in this project is an example reference client. It is intentionally outside the WordPress plugin.

## Client neutrality

Do not add code such as:

```text
if Claude
if ChatGPT
if Gemini
if Qwen
```

inside the Site AI Control ability layer.

Provider-specific behavior belongs in the MCP client, bridge, or agent runtime.

## Resource definition

There is no Resource custom post type on the current site.

For this plugin, a "resource" means a normal WordPress `post`.

`create-resource` always creates:

```text
post_type   = post
post_status = draft
```

Publishing is intentionally a separate ability.

## Bulk operations

Three abilities share one controlled selection model: explicit `post_ids` (up to 100) or a `taxonomy` + `terms` selection with `post_type` (post or page), `post_status` (publish, draft, future, pending, private), `order`, `limit`, and `offset`. When `post_ids` is provided, taxonomy parameters are ignored. Without terms, the selection covers all posts of the given type and status, ordered by date.

### `site-ai/update-post-dates`

- `mode=set` applies one target date. `Y-m-d` keeps each post's existing time of day; `Y-m-d H:i[:s]` sets the full date-time in the site timezone.
- `mode=shift` moves each post date by a relative amount such as `-7 days`, `+2 weeks`, or `-1 year -6 months`.
- `dry_run=true` previews old and new dates without saving.
- Updates `post_date` and `post_date_gmt` correctly for the site timezone. Never changes post status, content, title, or slug.
- Requires per-post `edit_post` permission; posts the user cannot edit are skipped and reported.
- Backdating the newest published post is one call: `mode=shift`, `shift=-7 days`, `limit=1`.

### `site-ai/find-replace-content`

- Plain text search by default. `regex=true` uses a PHP-compatible pattern; the pattern controls its own modifiers.
- `case_sensitive` applies to plain text mode only.
- `dry_run=true` returns per-post match counts and a short context snippet without modifying content.
- Only `post_content` is modified. Titles and excerpts are never touched.
- Content is passed through `wp_kses_post` when the user lacks `unfiltered_html`, matching WordPress core behavior for non-privileged saves.
- Annotated `destructive: true`. WordPress revisions are the rollback path.
- Requires per-post `edit_post` permission.

### `site-ai/detect-ai-slop`

- Read-only heuristic scoring for common AI-writing patterns: weighted cliche phrase density, sentence-length uniformity, stock transition starters, em-dash density, rule-of-three list density, and lexical diversity.
- Returns a 0-100 score, a verdict (low, possible, likely, high), matched phrases with counts, and the strongest signals.
- `min_score` filters results to save tokens. `include_details=true` returns all matches and raw metrics.
- Deterministic and fully local. No model call and no outbound request. A score is a review signal for a human, not proof of AI authorship.

## SEO model

Yoast's generated REST representation contains `yoast_head` and `yoast_head_json`. The plugin uses Yoast's Surfaces API for PHP-level generated metadata where available and falls back to Yoast post meta for controlled values.

Controlled Yoast fields:

```text
seo_title            -> _yoast_wpseo_title
meta_description     -> _yoast_wpseo_metadesc
canonical            -> _yoast_wpseo_canonical
focus_keyphrase      -> _yoast_wpseo_focuskw
og_title             -> _yoast_wpseo_opengraph-title
og_description       -> _yoast_wpseo_opengraph-description
twitter_title        -> _yoast_wpseo_twitter-title
twitter_description  -> _yoast_wpseo_twitter-description
```

Do not write `yoast_head` or `yoast_head_json`. They are generated outputs.

## Google model

Use the existing Site Kit connections for Search Console, GA4, and PageSpeed. Do not create a second Google OAuth implementation in Site AI Control unless a future requirement explicitly demands it.

## Security model

- Least-privilege WordPress users are preferred.
- OAuth clients authenticate as the approving WordPress user.
- Local bridges should use a dedicated Application Password.
- Do not expose Administrator credentials to unattended agents.
- Write operations remain separately permissioned.
- `create-resource` always creates a draft.
- `publish-resource` is a separate operation.
- `update-post-dates` and `find-replace-content` enforce per-post `edit_post` checks at execution time and support `dry_run` previews.
- Do not add arbitrary execution primitives.

## Testing strategy

Test the same abilities through more than one MCP client before declaring a change production-ready.

Minimum client matrix:

1. Claude hosted connector
2. One local MCP client such as Claude Code/Cursor/VS Code
3. Ollama local or cloud model through the companion agent
4. One additional MCP client where available

For each client test:

1. Discover capabilities.
2. Run `get-site-health`.
3. Run one SEO read operation.
4. Run one Google read operation if Site Kit permissions allow it.
5. Test `update-yoast-meta` on one known post only after explicit approval.
6. Test `create-resource` and confirm it remains a draft.
7. Test publishing only after the draft workflow is verified.


## Grok OAuth

Site AI Control 0.3.3 adds Grok's published CIMD client identity to the `wp-media/mcp-oauth` trusted-publisher list using the library's official `wpmedia_mcp_oauth_trusted_publishers` filter. Grok can therefore use the same OAuth MCP endpoint without weakening the trusted-publisher model. Grok client metadata: `https://grok.com/oauth/mcp-client.json`.


## Site AI Control 0.5.0 additions

### Yoast taxonomy SEO abilities

- `site-ai/get-yoast-term-meta` reads the allowlisted Yoast SEO fields for a taxonomy term.
- `site-ai/update-yoast-term-meta` updates only supplied allowlisted fields: SEO title, meta description, canonical URL, focus keyphrase, OpenGraph title/description, and Twitter title/description.
- Public, UI-managed taxonomies only. The authenticated WordPress user must have the taxonomy's term-edit capability. Canonical URLs are validated.
- Global Yoast templates and author archive settings are not covered by these term-level abilities and should be implemented as a separate version-aware module.

### MCP OAuth trust

Site AI Control no longer enables arbitrary/untrusted OAuth publishers globally. The plugin adds Grok's published client metadata to the OAuth layer's trusted-publisher list. Other clients must satisfy the OAuth provider's normal validation and trusted-publisher policy. Do not weaken OAuth validation solely to make a client connect; verify its published client identity and the OAuth integration's current behavior first.

### Cross-site deployment

The plugin is intended to be installable on multiple compatible WordPress sites. Each installation has its own MCP endpoint, authentication, user permissions, integrations and site configuration. Do not reuse administrator credentials across sites. Confirm the actual installed MCP Adapter and OAuth versions and test each target client/site pair before unattended use.
