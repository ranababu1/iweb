<?php
namespace Site_AI_Control;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Abilities {

	const CATEGORY_DATA       = 'site-ai-data';
	const CATEGORY_SEO        = 'site-ai-seo';
	const CATEGORY_CONTENT    = 'site-ai-content';
	const CATEGORY_GOOGLE     = 'site-ai-google';
	const CATEGORY_MODIFY     = 'site-ai-modification';

	public static function init(): void {
		add_action( 'wp_abilities_api_categories_init', array( __CLASS__, 'register_categories' ) );
		add_action( 'wp_abilities_api_init', array( __CLASS__, 'register_abilities' ) );
	}

	public static function register_categories(): void {
		$categories = array(
			self::CATEGORY_DATA    => array( 'Site AI Data', 'Read-only WordPress site and environment data.' ),
			self::CATEGORY_SEO     => array( 'Site AI SEO', 'SEO inspection and controlled Yoast operations.' ),
			self::CATEGORY_CONTENT => array( 'Site AI Content', 'Content creation and content quality analysis.' ),
			self::CATEGORY_GOOGLE  => array( 'Site AI Google', 'Google Search Console, PageSpeed and Analytics data through Site Kit.' ),
			self::CATEGORY_MODIFY  => array( 'Site AI Modification', 'Controlled content modifications.' ),
		);

		foreach ( $categories as $slug => $data ) {
			if ( function_exists( 'wp_has_ability_category' ) && wp_has_ability_category( $slug ) ) {
				continue;
			}
			wp_register_ability_category(
				$slug,
				array(
					'label'       => $data[0],
					'description' => $data[1],
				)
			);
		}
	}

	public static function register_abilities(): void {
		self::register(
			'site-ai/get-site-health',
			'Get Site Health',
			'Returns WordPress environment information and direct Site Health checks. This ability is read-only.',
			self::CATEGORY_DATA,
			array(),
			array(
				'type'       => 'object',
				'properties' => array(
					'site'   => array( 'type' => 'object' ),
					'checks' => array( 'type' => 'array', 'items' => array( 'type' => 'object' ) ),
				),
			),
			array( 'readonly' => true, 'destructive' => false, 'idempotent' => true ),
			array( __CLASS__, 'get_site_health' ),
			array( __CLASS__, 'can_read_site' )
		);

		self::register(
			'site-ai/get-pages-needing-seo',
			'Get Pages Needing SEO',
			'Finds WordPress pages with missing or weak SEO metadata. Returns normalized Yoast metadata and issue severity. Does not modify content.',
			self::CATEGORY_SEO,
			self::list_input_schema(),
			self::list_output_schema(),
			array( 'readonly' => true, 'destructive' => false, 'idempotent' => true ),
			array( __CLASS__, 'get_pages_needing_seo' ),
			array( __CLASS__, 'can_read_content' )
		);

		self::register(
			'site-ai/get-posts-missing-meta',
			'Get Posts Missing Meta',
			'Finds published WordPress posts with missing or weak SEO metadata. The meta description is checked independently from the OpenGraph description.',
			self::CATEGORY_SEO,
			self::list_input_schema(),
			self::list_output_schema(),
			array( 'readonly' => true, 'destructive' => false, 'idempotent' => true ),
			array( __CLASS__, 'get_posts_missing_meta' ),
			array( __CLASS__, 'can_read_content' )
		);

		self::register(
			'site-ai/get-categories',
			'Get Post Categories',
			'Returns all WordPress post categories, including empty categories, with their post counts. Use empty_only=true to return only categories with zero posts.',
			self::CATEGORY_DATA,
			self::categories_input_schema(),
			array(
				'type'       => 'object',
				'properties' => array(
					'total'      => array( 'type' => 'integer' ),
					'empty_count'=> array( 'type' => 'integer' ),
					'categories' => array(
						'type'  => 'array',
						'items' => array(
							'type'       => 'object',
							'properties' => array(
								'id'         => array( 'type' => 'integer' ),
								'name'       => array( 'type' => 'string' ),
								'slug'       => array( 'type' => 'string' ),
								'count'      => array( 'type' => 'integer' ),
								'empty'      => array( 'type' => 'boolean' ),
								'parent_id'  => array( 'type' => 'integer' ),
							),
						),
					),
				),
			),
			array( 'readonly' => true, 'destructive' => false, 'idempotent' => true ),
			array( __CLASS__, 'get_categories' ),
			array( __CLASS__, 'can_read_content' )
		);

		self::register(
			'site-ai/get-yoast-term-meta',
			'Get Yoast Term Metadata',
			'Returns supported Yoast SEO metadata for a taxonomy term such as a category, tag, or public custom taxonomy term.',
			self::CATEGORY_SEO,
			array(
				'type' => 'object',
				'properties' => array(
					'term_id' => array( 'type' => 'integer', 'minimum' => 1 ),
					'taxonomy' => array( 'type' => 'string', 'minLength' => 1, 'maxLength' => 64 ),
				),
				'required' => array( 'term_id', 'taxonomy' ),
				'additionalProperties' => false,
			),
			array( 'type' => 'object', 'properties' => array( 'term_id' => array( 'type' => 'integer' ), 'taxonomy' => array( 'type' => 'string' ), 'name' => array( 'type' => 'string' ), 'url' => array( 'type' => 'string' ), 'seo' => array( 'type' => 'object' ) ) ),
			array( 'readonly' => true, 'destructive' => false, 'idempotent' => true ),
			array( __CLASS__, 'get_yoast_term_meta' ),
			array( __CLASS__, 'can_read_term_seo' )
		);

		self::register(
			'site-ai/update-yoast-term-meta',
			'Update Yoast Term Metadata',
			'Updates only explicitly supplied supported Yoast SEO fields for one taxonomy term. Use for category, tag, and supported public custom taxonomy archives.',
			self::CATEGORY_SEO,
			array(
				'type' => 'object',
				'properties' => array(
					'term_id' => array( 'type' => 'integer', 'minimum' => 1 ),
					'taxonomy' => array( 'type' => 'string', 'minLength' => 1, 'maxLength' => 64 ),
					'seo_title' => array( 'type' => 'string', 'maxLength' => 255 ),
					'meta_description' => array( 'type' => 'string', 'maxLength' => 1000 ),
					'canonical' => array( 'type' => 'string', 'maxLength' => 2048 ),
					'focus_keyphrase' => array( 'type' => 'string', 'maxLength' => 255 ),
					'og_title' => array( 'type' => 'string', 'maxLength' => 255 ),
					'og_description' => array( 'type' => 'string', 'maxLength' => 1000 ),
					'twitter_title' => array( 'type' => 'string', 'maxLength' => 255 ),
					'twitter_description' => array( 'type' => 'string', 'maxLength' => 1000 ),
				),
				'required' => array( 'term_id', 'taxonomy' ),
				'additionalProperties' => false,
				'minProperties' => 3,
			),
			array( 'type' => 'object', 'properties' => array( 'term_id' => array( 'type' => 'integer' ), 'taxonomy' => array( 'type' => 'string' ), 'updated' => array( 'type' => 'array', 'items' => array( 'type' => 'string' ) ), 'seo' => array( 'type' => 'object' ) ) ),
			array( 'readonly' => false, 'destructive' => false, 'idempotent' => true ),
			array( __CLASS__, 'update_yoast_term_meta' ),
			array( __CLASS__, 'can_update_term_seo' )
		);

		self::register(
			'site-ai/update-yoast-meta',
			'Update Yoast Meta',
			'Updates only explicitly supplied Yoast SEO metadata for one WordPress post. Supported fields are SEO title, meta description, canonical URL, focus keyphrase, OpenGraph title, OpenGraph description, Twitter title and Twitter description.',
			self::CATEGORY_SEO,
			self::yoast_update_input_schema(),
			self::yoast_update_output_schema(),
			array( 'readonly' => false, 'destructive' => false, 'idempotent' => true ),
			array( __CLASS__, 'update_yoast_meta' ),
			array( __CLASS__, 'can_update_post' )
		);

		self::register(
			'site-ai/create-resource',
			'Create Resource Draft',
			'Creates a normal WordPress post as a draft. It never publishes the post. A resource is represented by the normal post type in this version.',
			self::CATEGORY_CONTENT,
			self::create_resource_input_schema(),
			self::resource_output_schema(),
			array( 'readonly' => false, 'destructive' => false, 'idempotent' => false ),
			array( __CLASS__, 'create_resource' ),
			array( __CLASS__, 'can_create_post' )
		);

		self::register(
			'site-ai/publish-resource',
			'Publish Resource',
			'Publishes an existing WordPress post. This ability does not create content and requires explicit WordPress publish permission.',
			self::CATEGORY_CONTENT,
			array(
				'type'                 => 'object',
				'properties'           => array(
					'post_id' => array(
						'type'        => 'integer',
						'minimum'     => 1,
						'description' => 'Existing WordPress post ID.',
					),
				),
				'required'             => array( 'post_id' ),
				'additionalProperties' => false,
			),
			self::resource_output_schema(),
			array( 'readonly' => false, 'destructive' => false, 'idempotent' => true ),
			array( __CLASS__, 'publish_resource' ),
			array( __CLASS__, 'can_publish_post' )
		);

		self::register(
			'site-ai/run-content-audit',
			'Run Content Audit',
			'Analyzes a WordPress post for basic content quality signals including headings, word count, links, images, alt text, excerpts and content structure. It does not modify content.',
			self::CATEGORY_CONTENT,
			array(
				'type'                 => 'object',
				'properties'           => array(
					'post_id' => array(
						'type'        => 'integer',
						'minimum'     => 1,
						'description' => 'WordPress post ID.',
					),
				),
				'required'             => array( 'post_id' ),
				'additionalProperties' => false,
			),
			array( 'type' => 'object' ),
			array( 'readonly' => true, 'destructive' => false, 'idempotent' => true ),
			array( __CLASS__, 'run_content_audit' ),
			array( __CLASS__, 'can_read_content' )
		);

		self::register(
			'site-ai/seo-audit',
			'Run SEO Audit',
			'Audits generated Yoast SEO output for a WordPress post or page and combines it with basic content SEO signals.',
			self::CATEGORY_SEO,
			array(
				'type'                 => 'object',
				'properties'           => array(
					'post_id' => array(
						'type'        => 'integer',
						'minimum'     => 1,
						'description' => 'WordPress post or page ID.',
					),
				),
				'required'             => array( 'post_id' ),
				'additionalProperties' => false,
			),
			array( 'type' => 'object' ),
			array( 'readonly' => true, 'destructive' => false, 'idempotent' => true ),
			array( __CLASS__, 'seo_audit' ),
			array( __CLASS__, 'can_read_content' )
		);

		self::register(
			'site-ai/get-search-console-data',
			'Get Search Console Data',
			'Returns Google Search Console search analytics data through the existing Site Kit connection. Supports date range, dimensions, URL filtering and a row limit.',
			self::CATEGORY_GOOGLE,
			self::search_console_input_schema(),
			array( 'type' => 'object' ),
			array( 'readonly' => true, 'destructive' => false, 'idempotent' => true ),
			array( __CLASS__, 'get_search_console_data' ),
			array( __CLASS__, 'can_read_site_kit' )
		);

		self::register(
			'site-ai/get-page-speed',
			'Get PageSpeed Insights',
			'Returns PageSpeed Insights data for a URL through the existing Site Kit connection. The output is normalized to key performance and accessibility scores.',
			self::CATEGORY_GOOGLE,
			array(
				'type'                 => 'object',
				'properties'           => array(
					'url' => array(
						'type'        => 'string',
						'format'      => 'uri',
						'description' => 'URL to analyze. Defaults to the site homepage.',
					),
					'strategy' => array(
						'type'        => 'string',
						'enum'        => array( 'mobile', 'desktop' ),
						'default'     => 'mobile',
					),
				),
				'additionalProperties' => false,
			),
			array( 'type' => 'object' ),
			array( 'readonly' => true, 'destructive' => false, 'idempotent' => true ),
			array( __CLASS__, 'get_page_speed' ),
			array( __CLASS__, 'can_read_site_kit' )
		);

		self::register(
			'site-ai/get-ga4-summary',
			'Get GA4 Summary',
			'Returns a controlled GA4 summary through the existing Site Kit connection. Defaults to the last 28 complete days and returns core traffic and engagement metrics.',
			self::CATEGORY_GOOGLE,
			self::ga4_input_schema(),
			array( 'type' => 'object' ),
			array( 'readonly' => true, 'destructive' => false, 'idempotent' => true ),
			array( __CLASS__, 'get_ga4_summary' ),
			array( __CLASS__, 'can_read_site_kit' )
		);

		self::register(
			'site-ai/update-post-dates',
			'Update Post Dates',
			'Updates publish dates for a controlled selection of posts or pages in a single call. Select by post_ids or by taxonomy terms. mode=set applies one date (Y-m-d keeps each post existing time of day). mode=shift moves each date by a relative amount such as -7 days. dry_run=true previews old and new dates without saving. Example: backdate the newest published post by a week with mode=shift, shift=-7 days, limit=1.',
			self::CATEGORY_MODIFY,
			self::bulk_input_schema(
				array(
					'mode' => array(
						'type'        => 'string',
						'enum'        => array( 'set', 'shift' ),
						'description' => 'set applies the date value to every selected post. shift moves each post date by the shift value.',
					),
					'date' => array(
						'type'        => 'string',
						'maxLength'   => 40,
						'description' => 'Target date for mode=set. Y-m-d keeps each post existing time of day. Y-m-d H:i or Y-m-d H:i:s sets the full date-time in the site timezone.',
					),
					'shift' => array(
						'type'        => 'string',
						'maxLength'   => 60,
						'description' => 'Relative shift for mode=shift, for example -7 days, +2 weeks, -1 year -6 months.',
					),
					'dry_run' => array(
						'type'        => 'boolean',
						'default'     => false,
						'description' => 'Preview the new dates without saving changes.',
					),
				),
				array( 'mode' )
			),
			self::bulk_output_schema(),
			array( 'readonly' => false, 'destructive' => false, 'idempotent' => false ),
			array( __CLASS__, 'update_post_dates' ),
			array( __CLASS__, 'can_bulk_edit_content' )
		);

		self::register(
			'site-ai/find-replace-content',
			'Find And Replace Content',
			'Runs find-and-replace over post or page content in a single call. Select by post_ids or by taxonomy terms. Plain text search by default, or regex=true for a PHP-compatible pattern. dry_run=true returns match counts and context snippets without changing anything. Only post_content is modified.',
			self::CATEGORY_MODIFY,
			self::bulk_input_schema(
				array(
					'search' => array(
						'type'        => 'string',
						'minLength'   => 1,
						'maxLength'   => 500,
						'description' => 'Text or regular expression to find.',
					),
					'replace' => array(
						'type'        => 'string',
						'maxLength'   => 2000,
						'description' => 'Replacement text. An empty string deletes matches. In regex mode $1 backreferences are supported.',
					),
					'case_sensitive' => array(
						'type'        => 'boolean',
						'default'     => false,
						'description' => 'Plain text mode only. Regex mode uses the modifiers inside the pattern.',
					),
					'regex' => array(
						'type'        => 'boolean',
						'default'     => false,
						'description' => 'Treat search as a PHP-compatible regular expression.',
					),
					'dry_run' => array(
						'type'        => 'boolean',
						'default'     => false,
						'description' => 'Preview match counts and snippets without modifying content.',
					),
				),
				array( 'search', 'replace' )
			),
			self::bulk_output_schema(),
			array( 'readonly' => false, 'destructive' => true, 'idempotent' => false ),
			array( __CLASS__, 'find_replace_content' ),
			array( __CLASS__, 'can_bulk_edit_content' )
		);

		self::register(
			'site-ai/detect-ai-slop',
			'Detect AI Slop',
			'Scores post or page content for common AI-writing patterns using local deterministic heuristics: weighted cliche phrase density, sentence-length uniformity, stock transition starters, em-dash and rule-of-three density, and lexical diversity. Returns a 0-100 score, a verdict, matched phrases, and signals. Read-only and fully local. A score is a review signal, not proof of AI authorship.',
			self::CATEGORY_CONTENT,
			self::bulk_input_schema(
				array(
					'include_details' => array(
						'type'        => 'boolean',
						'default'     => false,
						'description' => 'Return all matched phrases and raw metrics for each post.',
					),
					'min_score' => array(
						'type'        => 'integer',
						'minimum'     => 0,
						'maximum'     => 100,
						'default'     => 0,
						'description' => 'Only return posts scoring at least this value.',
					),
				),
				array()
			),
			self::slop_output_schema(),
			array( 'readonly' => true, 'destructive' => false, 'idempotent' => true ),
			array( __CLASS__, 'detect_ai_slop' ),
			array( __CLASS__, 'can_read_content' )
		);
	}

	private static function register( string $name, string $label, string $description, string $category, array $input_schema, array $output_schema, array $annotations, callable $execute, callable $permission ): void {
		$args = array(
			'label'               => $label,
			'description'         => $description,
			'category'            => $category,
			'output_schema'       => $output_schema,
			'execute_callback'    => $execute,
			'permission_callback' => $permission,
			'meta'                => array(
				'show_in_rest' => true,
				'mcp'          => array(
					'public' => true,
				),
				'annotations' => $annotations,
			),
		);

		if ( ! empty( $input_schema ) ) {
			$args['input_schema'] = $input_schema;
		}

		wp_register_ability( $name, $args );
	}

	private static function list_input_schema(): array {
		return array(
			'type'                 => 'object',
			'properties'           => array(
				'limit' => array(
					'type'        => 'integer',
					'minimum'     => 1,
					'maximum'     => 100,
					'default'     => 50,
					'description' => 'Maximum number of matching items to return.',
				),
				'offset' => array(
					'type'        => 'integer',
					'minimum'     => 0,
					'default'     => 0,
					'description' => 'Number of matching items to skip.',
				),
			),
			'additionalProperties' => false,
		);
	}

	private static function categories_input_schema(): array {
		return array(
			'type'                 => 'object',
			'properties'           => array(
				'empty_only' => array(
					'type'        => 'boolean',
					'default'     => false,
					'description' => 'When true, return only categories with zero posts.',
				),
				'limit' => array(
					'type'        => 'integer',
					'minimum'     => 1,
					'maximum'     => 500,
					'default'     => 100,
					'description' => 'Maximum number of categories to return.',
				),
				'offset' => array(
					'type'        => 'integer',
					'minimum'     => 0,
					'default'     => 0,
					'description' => 'Number of categories to skip.',
				),
			),
			'additionalProperties' => false,
		);
	}

	private static function list_output_schema(): array {
		return array(
			'type'       => 'object',
			'properties' => array(
				'total_published' => array( 'type' => 'integer' ),
				'total_scanned'   => array( 'type' => 'integer' ),
				'limit'           => array( 'type' => 'integer' ),
				'offset'          => array( 'type' => 'integer' ),
				'items'           => array(
					'type'  => 'array',
					'items' => array( 'type' => 'object' ),
				),
				'note'            => array( 'type' => 'string' ),
			),
		);
	}

	private static function yoast_update_input_schema(): array {
		return array(
			'type'                 => 'object',
			'properties'           => array(
				'post_id'              => array( 'type' => 'integer', 'minimum' => 1 ),
				'seo_title'            => array( 'type' => 'string', 'maxLength' => 255 ),
				'meta_description'    => array( 'type' => 'string', 'maxLength' => 1000 ),
				'canonical'           => array( 'type' => 'string', 'format' => 'uri', 'maxLength' => 2048 ),
				'focus_keyphrase'     => array( 'type' => 'string', 'maxLength' => 255 ),
				'og_title'            => array( 'type' => 'string', 'maxLength' => 255 ),
				'og_description'     => array( 'type' => 'string', 'maxLength' => 1000 ),
				'twitter_title'       => array( 'type' => 'string', 'maxLength' => 255 ),
				'twitter_description' => array( 'type' => 'string', 'maxLength' => 1000 ),
			),
			'required'             => array( 'post_id' ),
			'additionalProperties' => false,
			'minProperties'        => 2,
		);
	}

	private static function yoast_update_output_schema(): array {
		return array(
			'type'       => 'object',
			'properties' => array(
				'post_id' => array( 'type' => 'integer' ),
				'updated' => array( 'type' => 'array', 'items' => array( 'type' => 'string' ) ),
				'seo'     => array( 'type' => 'object' ),
			),
		);
	}

	private static function create_resource_input_schema(): array {
		return array(
			'type'                 => 'object',
			'properties'           => array(
				'title'             => array( 'type' => 'string', 'minLength' => 1, 'maxLength' => 300 ),
				'content'           => array( 'type' => 'string', 'minLength' => 1 ),
				'excerpt'           => array( 'type' => 'string', 'maxLength' => 1000 ),
				'slug'              => array( 'type' => 'string', 'maxLength' => 200 ),
				'category_ids'      => array( 'type' => 'array', 'items' => array( 'type' => 'integer', 'minimum' => 1 ), 'maxItems' => 20 ),
				'tag_ids'           => array( 'type' => 'array', 'items' => array( 'type' => 'integer', 'minimum' => 1 ), 'maxItems' => 50 ),
				'featured_media_id' => array( 'type' => 'integer', 'minimum' => 0 ),
				'seo_title'         => array( 'type' => 'string', 'maxLength' => 255 ),
				'meta_description'  => array( 'type' => 'string', 'maxLength' => 1000 ),
				'focus_keyphrase'   => array( 'type' => 'string', 'maxLength' => 255 ),
			),
			'required'             => array( 'title', 'content' ),
			'additionalProperties' => false,
		);
	}

	private static function resource_output_schema(): array {
		return array(
			'type'       => 'object',
			'properties' => array(
				'success' => array( 'type' => 'boolean' ),
				'post_id' => array( 'type' => 'integer' ),
				'status'  => array( 'type' => 'string' ),
				'url'     => array( 'type' => 'string' ),
				'title'   => array( 'type' => 'string' ),
			),
		);
	}

	private static function search_console_input_schema(): array {
		return array(
			'type'                 => 'object',
			'properties'           => array(
				'start_date' => array( 'type' => 'string', 'pattern' => '^\d{4}-\d{2}-\d{2}$' ),
				'end_date'   => array( 'type' => 'string', 'pattern' => '^\d{4}-\d{2}-\d{2}$' ),
				'dimensions' => array(
					'type'     => 'array',
					'items'    => array( 'type' => 'string', 'enum' => array( 'date', 'query', 'page', 'country', 'device', 'searchAppearance' ) ),
					'maxItems' => 2,
				),
				'url'        => array( 'type' => 'string', 'format' => 'uri' ),
				'limit'      => array( 'type' => 'integer', 'minimum' => 1, 'maximum' => 1000, 'default' => 100 ),
			),
			'additionalProperties' => false,
		);
	}

	private static function ga4_input_schema(): array {
		return array(
			'type'                 => 'object',
			'properties'           => array(
				'start_date' => array( 'type' => 'string', 'pattern' => '^\d{4}-\d{2}-\d{2}$' ),
				'end_date'   => array( 'type' => 'string', 'pattern' => '^\d{4}-\d{2}-\d{2}$' ),
				'page_path'  => array( 'type' => 'string', 'maxLength' => 2048 ),
			),
			'additionalProperties' => false,
		);
	}

	private static function bulk_input_schema( array $properties, array $required, int $default_limit = 10 ): array {
		$defaults = array(
			'post_ids' => array(
				'type'        => 'array',
				'items'       => array( 'type' => 'integer', 'minimum' => 1 ),
				'maxItems'    => 100,
				'description' => 'Explicit WordPress post or page IDs. When provided, taxonomy selection is ignored.',
			),
			'taxonomy' => array(
				'type'        => 'string',
				'maxLength'   => 100,
				'description' => 'Taxonomy slug for the selection, for example category or post_tag. Without terms, all posts of the post type and status are selected.',
			),
			'terms' => array(
				'type'        => 'array',
				'items'       => array( 'type' => array( 'string', 'integer' ) ),
				'maxItems'    => 20,
				'description' => 'Term slugs or term IDs in the selected taxonomy.',
			),
			'post_type' => array(
				'type'        => 'string',
				'enum'        => array( 'post', 'page' ),
				'default'     => 'post',
				'description' => 'Post type used for the selection when post_ids is not provided.',
			),
			'post_status' => array(
				'type'        => 'string',
				'enum'        => array( 'publish', 'draft', 'future', 'pending', 'private' ),
				'default'     => 'publish',
				'description' => 'Post status used for the selection when post_ids is not provided.',
			),
			'order' => array(
				'type'        => 'string',
				'enum'        => array( 'asc', 'desc' ),
				'default'     => 'desc',
				'description' => 'Date order for the selection. desc starts with the newest post.',
			),
			'limit' => array(
				'type'        => 'integer',
				'minimum'     => 1,
				'maximum'     => 100,
				'default'     => $default_limit,
				'description' => 'Maximum number of posts to process.',
			),
			'offset' => array(
				'type'        => 'integer',
				'minimum'     => 0,
				'default'     => 0,
				'description' => 'Number of selected posts to skip when post_ids is not provided.',
			),
		);

		return array(
			'type'                 => 'object',
			'properties'           => array_merge( $defaults, $properties ),
			'required'             => $required,
			'additionalProperties' => false,
		);
	}

	private static function bulk_output_schema(): array {
		return array(
			'type'       => 'object',
			'properties' => array(
				'success' => array( 'type' => 'boolean' ),
				'dry_run' => array( 'type' => 'boolean' ),
				'mode'    => array( 'type' => 'string' ),
				'source'  => array( 'type' => 'string' ),
				'total'   => array( 'type' => 'integer' ),
				'skipped' => array( 'type' => 'array', 'items' => array( 'type' => 'object' ) ),
				'results' => array( 'type' => 'array', 'items' => array( 'type' => 'object' ) ),
			),
		);
	}

	private static function slop_output_schema(): array {
		return array(
			'type'       => 'object',
			'properties' => array(
				'success'       => array( 'type' => 'boolean' ),
				'posts_scanned' => array( 'type' => 'integer' ),
				'returned'      => array( 'type' => 'integer' ),
				'min_score'     => array( 'type' => 'integer' ),
				'average_score' => array( 'type' => 'number' ),
				'summary'       => array( 'type' => 'object' ),
				'note'          => array( 'type' => 'string' ),
				'posts'         => array( 'type' => 'array', 'items' => array( 'type' => 'object' ) ),
			),
		);
	}

	public static function can_read_site(): bool {
		return is_user_logged_in() && current_user_can( 'read' );
	}

	public static function can_read_content(): bool {
		return is_user_logged_in() && ( current_user_can( 'edit_posts' ) || current_user_can( 'edit_pages' ) );
	}

	public static function can_update_post( $input ): bool {
		if ( ! is_user_logged_in() || empty( $input['post_id'] ) ) {
			return false;
		}
		return current_user_can( 'edit_post', (int) $input['post_id'] );
	}

	public static function can_create_post(): bool {
		return is_user_logged_in() && current_user_can( 'edit_posts' );
	}

	public static function can_publish_post( $input ): bool {
		if ( ! is_user_logged_in() || empty( $input['post_id'] ) ) {
			return false;
		}
		return current_user_can( 'publish_posts' ) && current_user_can( 'edit_post', (int) $input['post_id'] );
	}

	public static function can_read_site_kit(): bool {
		if ( ! is_user_logged_in() ) {
			return false;
		}
		if ( current_user_can( 'manage_options' ) ) {
			return true;
		}
		return current_user_can( 'googlesitekit_view_dashboard' ) || current_user_can( 'googlesitekit_view_posts_insights' );
	}

	public static function can_read_term_seo( $input ): bool {
		if ( ! is_user_logged_in() || empty( $input['term_id'] ) || empty( $input['taxonomy'] ) ) {
			return false;
		}
		$taxonomy = get_taxonomy( sanitize_key( $input['taxonomy'] ) );
		$term = get_term( absint( $input['term_id'] ), sanitize_key( $input['taxonomy'] ) );
		return $taxonomy && ! is_wp_error( $term ) && $term && current_user_can( $taxonomy->cap->edit_terms );
	}

	public static function can_update_term_seo( $input ): bool {
		return self::can_read_term_seo( $input );
	}

	public static function get_yoast_term_meta( $input ) {
		return SEO::get_term_meta( $input );
	}

	public static function update_yoast_term_meta( $input ) {
		return SEO::update_term_meta( $input );
	}

	public static function get_site_health() {
		return Health::get();
	}

	public static function get_pages_needing_seo( $input ) {
		return SEO::find_missing( 'page', $input );
	}

	public static function get_posts_missing_meta( $input ) {
		return SEO::find_missing( 'post', $input );
	}

	public static function get_categories( $input ) {
		$empty_only = ! empty( $input['empty_only'] );
		$limit      = isset( $input['limit'] ) ? max( 1, min( 500, absint( $input['limit'] ) ) ) : 100;
		$offset     = isset( $input['offset'] ) ? max( 0, absint( $input['offset'] ) ) : 0;

		$terms = get_terms(
			array(
				'taxonomy'   => 'category',
				'hide_empty' => false,
				'number'     => 0,
				'orderby'    => 'name',
				'order'      => 'ASC',
			)
		);

		if ( is_wp_error( $terms ) ) {
			return $terms;
		}

		$all = array();
		foreach ( $terms as $term ) {
			$count = (int) $term->count;
			if ( $empty_only && $count > 0 ) {
				continue;
			}

			$all[] = array(
				'id'        => (int) $term->term_id,
				'name'      => (string) $term->name,
				'slug'      => (string) $term->slug,
				'count'     => $count,
				'empty'     => 0 === $count,
				'parent_id' => (int) $term->parent,
			);
		}

		$total      = count( $all );
		$empty_count = count( array_filter( $all, static function ( $item ) {
			return ! empty( $item['empty'] );
		} ) );

		return array(
			'total'       => $total,
			'empty_count' => $empty_count,
			'categories'  => array_slice( $all, $offset, $limit ),
		);
	}

	public static function update_yoast_meta( $input ) {
		return SEO::update_yoast_meta( $input );
	}

	public static function create_resource( $input ) {
		return Content::create_resource( $input );
	}

	public static function publish_resource( $input ) {
		return Content::publish_resource( $input );
	}

	public static function run_content_audit( $input ) {
		return Content::audit( $input );
	}

	public static function seo_audit( $input ) {
		return SEO::audit( $input );
	}

	public static function get_search_console_data( $input ) {
		return Google::search_console( $input );
	}

	public static function get_page_speed( $input ) {
		return Google::page_speed( $input );
	}

	public static function get_ga4_summary( $input ) {
		return Google::ga4_summary( $input );
	}

	public static function update_post_dates( $input ) {
		return Content::update_dates( $input );
	}

	public static function find_replace_content( $input ) {
		return Content::find_replace( $input );
	}

	public static function detect_ai_slop( $input ) {
		return Slop::detect( $input );
	}

	public static function can_bulk_edit_content( $input ): bool {
		return is_user_logged_in() && ( current_user_can( 'edit_posts' ) || current_user_can( 'edit_pages' ) );
	}
}
