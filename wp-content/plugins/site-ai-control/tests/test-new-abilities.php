<?php
/**
 * Standalone tests for Site AI Control bulk abilities and registration helpers.
 *
 * Run with: php tests/test-new-abilities.php
 *
 * These tests stub the WordPress functions used by the code paths under
 * test. They do not replace the multi-client MCP test matrix documented
 * in instructions.md.
 */

error_reporting( E_ALL );
ini_set( 'display_errors', '1' );

define( 'ABSPATH', __DIR__ . '/' );

$GLOBALS['__site_ai_test'] = array(
	'updated'     => array(),
	'query_posts' => array(),
	'last_query'  => array(),
);

class WP_Error {
	private $code;
	private $message;
	public function __construct( $code = '', $message = '' ) {
		$this->code    = $code;
		$this->message = $message;
	}
	public function get_error_code() {
		return $this->code;
	}
	public function get_error_message() {
		return $this->message;
	}
}

class WP_Post {
	public $ID;
	public $post_type = 'post';
	public $post_status = 'publish';
	public $post_date;
	public $post_date_gmt;
	public $post_content;
	public $post_title;
	public $post_excerpt = '';
	public $post_category = array();
	public $post_name = '';
}

class WP_Query {
	public $posts;
	public $found_posts;

	public function __construct( $args = array() ) {
		$GLOBALS['__site_ai_test']['last_query'] = $args;
		$posts = $GLOBALS['__site_ai_test']['query_posts'];

		if ( ! empty( $args['post__in'] ) ) {
			$ids   = array_map( 'intval', (array) $args['post__in'] );
			$posts = array_values( array_filter( $posts, static function ( $post ) use ( $ids ) {
				return in_array( (int) $post->ID, $ids, true );
			} ) );
		}

		if ( ! empty( $args['tax_query'] ) ) {
			$term_ids = (array) $args['tax_query'][0]['terms'];
			$posts    = array_values( array_filter( $posts, static function ( $post ) use ( $term_ids ) {
				return ! empty( array_intersect( array_map( 'intval', (array) $post->post_category ), array_map( 'intval', $term_ids ) ) );
			} ) );
		}

		if ( isset( $args['post_type'] ) && 'any' !== $args['post_type'] ) {
			$posts = array_values( array_filter( $posts, static function ( $post ) use ( $args ) {
				return $post->post_type === $args['post_type'];
			} ) );
		}

		if ( isset( $args['post_status'] ) && 'any' !== $args['post_status'] ) {
			$posts = array_values( array_filter( $posts, static function ( $post ) use ( $args ) {
				return $post->post_status === $args['post_status'];
			} ) );
		}

		$order = isset( $args['order'] ) ? $args['order'] : 'DESC';
		usort( $posts, static function ( $a, $b ) use ( $order ) {
			$result = strcmp( $a->post_date, $b->post_date );
			return 'ASC' === $order ? $result : - $result;
		} );

		$this->found_posts = count( $posts );

		$offset = isset( $args['offset'] ) ? (int) $args['offset'] : 0;
		$limit  = isset( $args['posts_per_page'] ) ? (int) $args['posts_per_page'] : 10;
		$this->posts = array_slice( $posts, $offset, $limit );
	}
}

function is_wp_error( $thing ) {
	return $thing instanceof WP_Error;
}

function is_user_logged_in() {
	return true;
}

function current_user_can( $capability ) {
	return true;
}

function wp_timezone() {
	return new DateTimeZone( 'UTC' );
}

function wp_slash( $value ) {
	if ( is_array( $value ) ) {
		return array_map( 'wp_slash', $value );
	}
	return addslashes( (string) $value );
}

function wp_kses_post( $content ) {
	return $content;
}

function wp_strip_all_tags( $text ) {
	return trim( strip_tags( (string) $text ) );
}

function absint( $value ) {
	return abs( (int) $value );
}

function sanitize_key( $key ) {
	return strtolower( preg_replace( '/[^a-z0-9_\-]/', '', strtolower( (string) $key ) ) );
}

function sanitize_title( $title ) {
	return trim( preg_replace( '/[^a-z0-9]+/u', '-', strtolower( (string) $title ) ), '-' );
}

function get_the_title( $post ) {
	return is_object( $post ) ? (string) $post->post_title : '';
}

function get_permalink( $post ) {
	return 'https://example.com/?p=' . ( is_object( $post ) ? (int) $post->ID : (int) $post );
}

function taxonomy_exists( $taxonomy ) {
	return in_array( $taxonomy, array( 'category', 'post_tag' ), true );
}

function is_taxonomy_viewable( $taxonomy ) {
	return taxonomy_exists( $taxonomy );
}

function term_exists( $term, $taxonomy = '' ) {
	if ( 5 === (int) $term || 'news' === (string) $term || '5' === (string) $term ) {
		return array(
			'term_id'          => 5,
			'term_taxonomy_id' => 5,
		);
	}
	return null;
}

function wp_update_post( $postarr, $wp_error = true ) {
	$GLOBALS['__site_ai_test']['updated'][] = $postarr;
	return (int) $postarr['ID'];
}

require __DIR__ . '/../includes/class-site-ai-content.php';
require __DIR__ . '/../includes/class-site-ai-slop.php';
require __DIR__ . '/../includes/class-site-ai-seo.php';
require __DIR__ . '/../includes/class-site-ai-google.php';
require __DIR__ . '/../includes/class-site-ai-health.php';
require __DIR__ . '/../includes/class-site-ai-abilities.php';
require __DIR__ . '/../includes/class-site-ai-control.php';

$pass = 0;
$fail = 0;

function check( $label, $condition ) {
	global $pass, $fail;
	if ( $condition ) {
		$pass++;
		echo "PASS  {$label}\n";
	} else {
		$fail++;
		echo "FAIL  {$label}\n";
	}
}

function reset_test_state() {
	$GLOBALS['__site_ai_test']['updated'] = array();
}

function site_ai_fixture_post( $id, $title, $date, $content, $categories = array() ) {
	$post                = new WP_Post();
	$post->ID            = $id;
	$post->post_title    = $title;
	$post->post_date     = $date;
	$post->post_date_gmt = $date;
	$post->post_content  = $content;
	$post->post_category = $categories;
	$post->post_name     = 'post-' . $id;

	return $post;
}

$slop_content = "Let's delve into the ever-evolving world of remote work. It is important to note that this topic is a testament to how quickly habits change. The tapestry of modern work is a treasure trove of lessons. Furthermore, we will unlock the power of focused mornings. Moreover, hybrid teams rely on a crucial role for clear writing. Additionally, tools matter more than offices ever did. In conclusion, we embark on a journey toward better routines.\n\nAt its core, remote work rewards people who plan the day before it starts. A seamless experience with a short daily checklist beats a complicated system nobody follows. Furthermore, deep work needs long stretches of quiet time. Moreover, boundaries between home and office keep energy stable. Additionally, one shared calendar prevents most scheduling conflicts. It is important to note that breaks are part of the work, not a reward for it.\n\nIn summary, the game-changer is not the software. It is the agreement to protect each other's focus. Furthermore, teams that write things down scale faster than teams that repeat themselves. Moreover, async by default makes time zones a strength. Additionally, documentation compounds quietly for years. The possibilities are endless when the basics are steady.";

$human_content = "I planted tomatoes last spring. The seedlings arrived late, so the harvest started slowly. My neighbour suggested coffee grounds for the slugs, which worked better than the copper tape I tried the year before.\n\nRain in July nearly drowned everything. Still, by August the plants had recovered and we were giving away bags of fruit to anyone who knocked on the door. My son ate the small yellow pear variety straight off the vine; he refused the bigger ones.\n\nThe real lesson had nothing to do with gardening. Patience is mostly a habit you build while waiting for something to grow. Next year I want to try chillies, mostly to prove to myself that one good season was not a fluke.";

$GLOBALS['__site_ai_test']['query_posts'] = array(
	site_ai_fixture_post( 101, 'Newest post', '2026-09-20 10:00:00', 'Hello world. hello WP.', array( 5 ) ),
	site_ai_fixture_post( 102, 'Slop post', '2026-09-10 08:30:00', $slop_content, array( 5 ) ),
	site_ai_fixture_post( 103, 'Human post', '2026-08-01 09:00:00', $human_content, array() ),
);
reset_test_state();
$result = \Site_AI_Control\Content::update_dates( array( 'mode' => 'shift', 'shift' => '-7 days', 'limit' => 1 ) );
check( 'shift backdates the newest published post', ! is_wp_error( $result ) && 1 === count( $result['results'] ) && '2026-09-13 10:00:00' === $result['results'][0]['new_date'] );
check( 'shift saves through wp_update_post', 1 === count( $GLOBALS['__site_ai_test']['updated'] ) && '2026-09-13 10:00:00' === $GLOBALS['__site_ai_test']['updated'][0]['post_date'] );
check( 'shift writes a matching GMT date', '2026-09-13 10:00:00' === $GLOBALS['__site_ai_test']['updated'][0]['post_date_gmt'] );

reset_test_state();
$result = \Site_AI_Control\Content::update_dates( array( 'post_ids' => array( 101 ), 'mode' => 'set', 'date' => '2025-01-15' ) );
check( 'set with a date keeps the time of day', ! is_wp_error( $result ) && '2025-01-15 10:00:00' === $result['results'][0]['new_date'] );

reset_test_state();
$result = \Site_AI_Control\Content::update_dates( array( 'post_ids' => array( 101 ), 'mode' => 'set', 'date' => '2025-01-15 09:30:00' ) );
check( 'set with a full datetime overrides the time', ! is_wp_error( $result ) && '2025-01-15 09:30:00' === $result['results'][0]['new_date'] );

reset_test_state();
$result = \Site_AI_Control\Content::update_dates( array( 'mode' => 'shift', 'shift' => '-30 days', 'limit' => 2, 'dry_run' => true ) );
check( 'dry run previews without saving', ! is_wp_error( $result ) && 2 === count( $result['results'] ) && 0 === $result['updated'] && empty( $GLOBALS['__site_ai_test']['updated'] ) );

$result = \Site_AI_Control\Content::update_dates( array( 'post_ids' => array( 101 ), 'mode' => 'set', 'date' => '2025-02-30' ) );
check( 'impossible calendar date is rejected', is_wp_error( $result ) && 'invalid_date' === $result->get_error_code() );

$result = \Site_AI_Control\Content::update_dates( array( 'mode' => 'shift', 'shift' => 'next tuesday', 'limit' => 1 ) );
check( 'non-relative shift is rejected', is_wp_error( $result ) && 'invalid_shift' === $result->get_error_code() );

$result = \Site_AI_Control\Content::update_dates( array( 'post_ids' => array( 0 ), 'mode' => 'shift', 'shift' => '-1 day' ) );
check( 'empty post_ids is rejected', is_wp_error( $result ) && 'invalid_post_ids' === $result->get_error_code() );

$result = \Site_AI_Control\Content::update_dates( array( 'taxonomy' => 'missing_tax', 'terms' => array( 'x' ), 'mode' => 'shift', 'shift' => '-1 day' ) );
check( 'unknown taxonomy is rejected', is_wp_error( $result ) && 'invalid_taxonomy' === $result->get_error_code() );

$result = \Site_AI_Control\Content::update_dates( array( 'taxonomy' => 'category', 'terms' => array( 'missing-term' ), 'mode' => 'shift', 'shift' => '-1 day' ) );
check( 'unknown term is rejected', is_wp_error( $result ) && 'invalid_terms' === $result->get_error_code() );

reset_test_state();
$result = \Site_AI_Control\Content::update_dates( array( 'taxonomy' => 'category', 'terms' => array( 'news' ), 'mode' => 'shift', 'shift' => '-1 day', 'limit' => 10 ) );
$ids    = array();
foreach ( $result['results'] as $item ) {
	$ids[] = (int) $item['post_id'];
}
check( 'taxonomy selection updates the right posts', ! is_wp_error( $result ) && 2 === count( $ids ) && in_array( 101, $ids, true ) && in_array( 102, $ids, true ) );

reset_test_state();
$result = \Site_AI_Control\Content::update_dates( array( 'mode' => 'shift', 'shift' => '-1 day', 'limit' => 10 ) );
check( 'selection without ids or taxonomy covers all posts', ! is_wp_error( $result ) && 'all' === $result['source'] && 3 === count( $result['results'] ) );
reset_test_state();
$result = \Site_AI_Control\Content::find_replace( array( 'post_ids' => array( 101 ), 'search' => 'hello', 'replace' => 'hi' ) );
check( 'plain replace is case-insensitive by default', ! is_wp_error( $result ) && 2 === $result['total_matches'] && 1 === $result['posts_updated'] );
check( 'plain replace saves the new content', false !== strpos( $GLOBALS['__site_ai_test']['updated'][0]['post_content'], 'hi world. hi WP.' ) );

reset_test_state();
$result = \Site_AI_Control\Content::find_replace( array( 'post_ids' => array( 101 ), 'search' => 'Hello', 'replace' => 'Hey', 'case_sensitive' => true ) );
check( 'case-sensitive plain replace', ! is_wp_error( $result ) && 1 === $result['total_matches'] );

reset_test_state();
$result = \Site_AI_Control\Content::find_replace( array( 'post_ids' => array( 101 ), 'search' => '\bworld\b', 'replace' => 'earth', 'regex' => true ) );
check( 'regex replace works', ! is_wp_error( $result ) && 1 === $result['total_matches'] && false !== strpos( $GLOBALS['__site_ai_test']['updated'][0]['post_content'], 'Hello earth.' ) );

reset_test_state();
$result = \Site_AI_Control\Content::find_replace( array( 'post_ids' => array( 101 ), 'search' => 'hello', 'replace' => 'hi', 'dry_run' => true ) );
check( 'dry run reports matches without saving', ! is_wp_error( $result ) && 2 === $result['total_matches'] && 0 === $result['posts_updated'] && empty( $GLOBALS['__site_ai_test']['updated'] ) && '' !== (string) $result['results'][0]['preview'] );

$result = \Site_AI_Control\Content::find_replace( array( 'post_ids' => array( 101 ), 'search' => '(unclosed', 'replace' => 'x', 'regex' => true ) );
check( 'invalid regex is rejected', is_wp_error( $result ) && 'invalid_pattern' === $result->get_error_code() );

reset_test_state();
$result = \Site_AI_Control\Content::find_replace( array( 'post_ids' => array( 101 ), 'search' => 'hello', 'replace' => '$1' ) );
check( 'plain replace treats $1 literally', ! is_wp_error( $result ) && false !== strpos( $GLOBALS['__site_ai_test']['updated'][0]['post_content'], '$1 world.' ) );
$result = \Site_AI_Control\Slop::detect( array( 'post_ids' => array( 102 ) ) );
check( 'slop post scores as likely or high', ! is_wp_error( $result ) && 1 === $result['returned'] && $result['posts'][0]['score'] >= 40 && in_array( $result['posts'][0]['verdict'], array( 'likely', 'high' ), true ) );
check( 'slop post reports matched phrases and signals', ! empty( $result['posts'][0]['matches'] ) && ! empty( $result['posts'][0]['signals'] ) );

$result = \Site_AI_Control\Slop::detect( array( 'post_ids' => array( 103 ) ) );
check( 'human-sounding post scores low', ! is_wp_error( $result ) && 'low' === $result['posts'][0]['verdict'] && $result['posts'][0]['score'] < 20 );

$result = \Site_AI_Control\Slop::detect( array( 'min_score' => 40, 'limit' => 10 ) );
$returned_ids = array();
foreach ( $result['posts'] as $entry ) {
	$returned_ids[] = (int) $entry['post_id'];
}
check( 'min_score filters the report', ! is_wp_error( $result ) && 3 === $result['posts_scanned'] && 1 === $result['returned'] && in_array( 102, $returned_ids, true ) );

$result = \Site_AI_Control\Slop::detect( array( 'post_ids' => array( 103 ), 'include_details' => true ) );
check( 'include_details returns metrics', ! is_wp_error( $result ) && ! empty( $result['posts'][0]['metrics'] ) );

$result = \Site_AI_Control\Slop::detect( array( 'taxonomy' => 'missing_tax', 'terms' => array( 'x' ) ) );
check( 'slop selection rejects unknown taxonomy', is_wp_error( $result ) && 'invalid_taxonomy' === $result->get_error_code() );
check( 'Abilities exposes the new dispatch methods', method_exists( 'Site_AI_Control\Abilities', 'update_post_dates' ) && method_exists( 'Site_AI_Control\Abilities', 'find_replace_content' ) && method_exists( 'Site_AI_Control\Abilities', 'detect_ai_slop' ) );
check( 'bulk edit permission callback works', \Site_AI_Control\Abilities::can_bulk_edit_content( array() ) );
check( 'slop phrase dictionary is populated', count( constant( 'Site_AI_Control\Slop::PHRASES' ) ) > 100 );

echo "\n{$pass} passed, {$fail} failed\n";
exit( $fail > 0 ? 1 : 0 );