<?php
namespace Site_AI_Control;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Content {

	public static function create_resource( array $input ) {
		$title   = sanitize_text_field( $input['title'] ?? '' );
		$content = wp_kses_post( $input['content'] ?? '' );

		if ( '' === $title || '' === trim( wp_strip_all_tags( $content ) ) ) {
			return new \WP_Error( 'invalid_resource', 'Title and content are required.' );
		}

		$postarr = array(
			'post_type'    => 'post',
			'post_status'  => 'draft',
			'post_title'   => $title,
			'post_content' => $content,
		);

		if ( isset( $input['excerpt'] ) ) {
			$postarr['post_excerpt'] = wp_kses_post( $input['excerpt'] );
		}

		if ( isset( $input['slug'] ) && '' !== trim( $input['slug'] ) ) {
			$postarr['post_name'] = sanitize_title( $input['slug'] );
		}

		if ( isset( $input['category_ids'] ) ) {
			$postarr['post_category'] = array_map( 'absint', (array) $input['category_ids'] );
		}

		if ( isset( $input['tag_ids'] ) ) {
			$postarr['tags_input'] = array_map( 'absint', (array) $input['tag_ids'] );
		}

		if ( ! empty( $input['featured_media_id'] ) ) {
			$postarr['meta_input'] = array();
		}

		$post_id = wp_insert_post( wp_slash( $postarr ), true );

		if ( is_wp_error( $post_id ) ) {
			return $post_id;
		}

		$post_id = (int) $post_id;

		if ( ! empty( $input['featured_media_id'] ) ) {
			$media_id = absint( $input['featured_media_id'] );
			if ( wp_attachment_is_image( $media_id ) ) {
				set_post_thumbnail( $post_id, $media_id );
			}
		}

		$seo_input = array( 'post_id' => $post_id );
		foreach ( array( 'seo_title', 'meta_description', 'focus_keyphrase' ) as $field ) {
			if ( array_key_exists( $field, $input ) ) {
				$seo_input[ $field ] = $input[ $field ];
			}
		}

		if ( count( $seo_input ) > 1 ) {
			SEO::update_yoast_meta( $seo_input );
		}

		return array(
			'success' => true,
			'post_id' => $post_id,
			'status'  => 'draft',
			'url'     => get_permalink( $post_id ),
			'title'   => get_the_title( $post_id ),
		);
	}

	public static function publish_resource( array $input ) {
		$post_id = absint( $input['post_id'] ?? 0 );
		$post    = get_post( $post_id );

		if ( ! $post || 'post' !== $post->post_type ) {
			return new \WP_Error( 'invalid_post', 'The specified resource post does not exist.' );
		}

		if ( 'publish' === $post->post_status ) {
			return array(
				'success' => true,
				'post_id' => $post_id,
				'status'  => 'publish',
				'url'     => get_permalink( $post_id ),
				'title'   => get_the_title( $post_id ),
			);
		}

		$updated = wp_update_post(
			array(
				'ID'          => $post_id,
				'post_status' => 'publish',
			),
			true
		);

		if ( is_wp_error( $updated ) ) {
			return $updated;
		}

		return array(
			'success' => true,
			'post_id' => $post_id,
			'status'  => get_post_status( $post_id ),
			'url'     => get_permalink( $post_id ),
			'title'   => get_the_title( $post_id ),
		);
	}

	public static function audit( array $input ) {
		$post_id = absint( $input['post_id'] ?? 0 );
		$post    = get_post( $post_id );

		if ( ! $post || ! in_array( $post->post_type, array( 'post', 'page' ), true ) ) {
			return new \WP_Error( 'invalid_post', 'The specified post or page does not exist.' );
		}

		if ( ! current_user_can( 'read_post', $post->ID ) ) {
			return new \WP_Error( 'forbidden', 'You do not have permission to view this post.' );
		}

		$content = (string) $post->post_content;
		$html    = $content;

		$dom = null;
		$old  = libxml_use_internal_errors( true );

		if ( class_exists( 'DOMDocument' ) ) {
			$dom = new \DOMDocument();
			$dom->loadHTML(
				'<?xml encoding="UTF-8">' . '<div id="site-ai-content-root">' . $html . '</div>',
				LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
			);
		}

		$plain_text = trim( preg_replace( '/\s+/u', ' ', wp_strip_all_tags( $html ) ) );
		$words      = '' === $plain_text ? 0 : count( preg_split( '/\s+/u', $plain_text ) );

		$h1 = $h2 = $h3 = 0;
		$internal_links = 0;
		$external_links = 0;
		$images = 0;
		$missing_alt = 0;

		$site_host = wp_parse_url( home_url(), PHP_URL_HOST );

		if ( $dom ) {
			foreach ( array( 'h1', 'h2', 'h3' ) as $tag ) {
				$nodes = $dom->getElementsByTagName( $tag );
				if ( 'h1' === $tag ) {
					$h1 = $nodes->length;
				} elseif ( 'h2' === $tag ) {
					$h2 = $nodes->length;
				} else {
					$h3 = $nodes->length;
				}
			}

			$link_nodes = $dom->getElementsByTagName( 'a' );
			foreach ( $link_nodes as $link ) {
				$href = trim( (string) $link->getAttribute( 'href' ) );
				if ( '' === $href || '#' === $href[0] || 0 === strpos( $href, 'mailto:' ) || 0 === strpos( $href, 'tel:' ) ) {
					continue;
				}

				$host = wp_parse_url( $href, PHP_URL_HOST );
				if ( ! $host || ! $site_host || strtolower( $host ) === strtolower( $site_host ) ) {
					$internal_links++;
				} else {
					$external_links++;
				}
			}

			$image_nodes = $dom->getElementsByTagName( 'img' );
			$images      = $image_nodes->length;
			foreach ( $image_nodes as $image ) {
				if ( '' === trim( (string) $image->getAttribute( 'alt' ) ) ) {
					$missing_alt++;
				}
			}
		} else {
			$h1 = preg_match_all( '/<h1\b[^>]*>/i', $html );
			$h2 = preg_match_all( '/<h2\b[^>]*>/i', $html );
			$h3 = preg_match_all( '/<h3\b[^>]*>/i', $html );
			$images = preg_match_all( '/<img\b/i', $html );
			$missing_alt = preg_match_all( '/<img\b(?![^>]*\balt\s*=)/i', $html );
			$internal_links = 0;
			$external_links = 0;
		}

		libxml_clear_errors();
		libxml_use_internal_errors( $old );

		$issues = array();

		if ( 0 === $h1 ) {
			$issues[] = array( 'severity' => 'warning', 'field' => 'h1', 'message' => 'No H1 heading detected in the post content.' );
		} elseif ( $h1 > 1 ) {
			$issues[] = array( 'severity' => 'info', 'field' => 'h1', 'message' => 'More than one H1 heading detected.' );
		}

		if ( $words < 300 ) {
			$issues[] = array( 'severity' => 'info', 'field' => 'word_count', 'message' => 'Content is under 300 words. This is not automatically a ranking problem, but it may indicate thin content.' );
		}

		if ( $missing_alt > 0 ) {
			$issues[] = array( 'severity' => 'warning', 'field' => 'images', 'message' => $missing_alt . ' image(s) are missing alt text.' );
		}

		if ( 0 === $internal_links ) {
			$issues[] = array( 'severity' => 'warning', 'field' => 'internal_links', 'message' => 'No internal links were detected.' );
		}

		if ( 0 === $h2 && $words > 500 ) {
			$issues[] = array( 'severity' => 'info', 'field' => 'headings', 'message' => 'Long-form content has no H2 headings.' );
		}

		return array(
			'post_id' => $post_id,
			'title'   => get_the_title( $post ),
			'url'     => get_permalink( $post ),
			'summary' => array(
				'word_count'      => $words,
				'h1'              => $h1,
				'h2'              => $h2,
				'h3'              => $h3,
				'internal_links'  => $internal_links,
				'external_links'  => $external_links,
				'images'          => $images,
				'missing_alt_text'=> $missing_alt,
				'has_excerpt'     => '' !== trim( $post->post_excerpt ),
				'content_length'  => strlen( $content ),
			),
			'issues'  => $issues,
		);
	}
	/**
	 * Controlled post selection shared by the bulk abilities.
	 *
	 * Explicit post_ids win over taxonomy selection. Without post_ids the
	 * selection uses the given taxonomy terms, or all posts of the given
	 * post type and status, ordered by date.
	 */
	public static function select_posts( array $input, int $default_limit = 10, int $max_limit = 100 ) {
		if ( array_key_exists( 'post_ids', $input ) ) {
			$post_ids = array_values( array_unique( array_filter( array_map( 'absint', (array) $input['post_ids'] ) ) ) );
			$post_ids = array_slice( $post_ids, 0, $max_limit );

			if ( empty( $post_ids ) ) {
				return new \WP_Error( 'invalid_post_ids', 'post_ids was provided but contains no valid post IDs.' );
			}

			$query = new \WP_Query(
				array(
					'post_type'              => 'any',
					'post_status'            => 'any',
					'post__in'               => $post_ids,
					'posts_per_page'         => count( $post_ids ),
					'orderby'                => 'post__in',
					'ignore_sticky_posts'    => true,
					'no_found_rows'          => true,
					'update_post_term_cache' => false,
				)
			);

			$posts = array();
			foreach ( $query->posts as $post ) {
				if ( $post instanceof \WP_Post
					&& in_array( $post->post_type, array( 'post', 'page' ), true )
					&& current_user_can( 'read_post', $post->ID )
				) {
					$posts[] = $post;
				}
			}

			return array(
				'posts'  => $posts,
				'source' => 'post_ids',
				'total'  => count( $post_ids ),
				'limit'  => count( $post_ids ),
				'offset' => 0,
			);
		}

		$requested_type   = (string) ( $input['post_type'] ?? 'post' );
		$post_type        = in_array( $requested_type, array( 'post', 'page' ), true ) ? $requested_type : 'post';
		$allowed          = array( 'publish', 'draft', 'future', 'pending', 'private' );
		$requested_status = (string) ( $input['post_status'] ?? 'publish' );
		$post_status      = in_array( $requested_status, $allowed, true ) ? $requested_status : 'publish';
		$order       = 'asc' === strtolower( (string) ( $input['order'] ?? 'desc' ) ) ? 'ASC' : 'DESC';
		$limit       = min( $max_limit, max( 1, absint( $input['limit'] ?? $default_limit ) ) );
		$offset      = max( 0, absint( $input['offset'] ?? 0 ) );

		$args = array(
			'post_type'              => $post_type,
			'post_status'            => $post_status,
			'posts_per_page'         => $limit,
			'offset'                 => $offset,
			'orderby'                => 'date',
			'order'                  => $order,
			'ignore_sticky_posts'    => true,
			'no_found_rows'          => false,
			'update_post_term_cache' => false,
		);

		$taxonomy      = isset( $input['taxonomy'] ) ? sanitize_key( (string) $input['taxonomy'] ) : '';
		$terms         = isset( $input['terms'] ) ? (array) $input['terms'] : array();
		$invalid_terms = array();

		if ( '' !== $taxonomy || ! empty( $terms ) ) {
			if ( '' === $taxonomy || ! taxonomy_exists( $taxonomy ) || ! is_taxonomy_viewable( $taxonomy ) ) {
				return new \WP_Error( 'invalid_taxonomy', 'The provided taxonomy does not exist or is not viewable.' );
			}

			if ( empty( $terms ) ) {
				return new \WP_Error( 'invalid_terms', 'A taxonomy selection requires at least one term slug or term ID.' );
			}

			$term_ids = array();

			foreach ( $terms as $term ) {
				if ( is_int( $term ) || ctype_digit( (string) $term ) ) {
					$found = term_exists( (int) $term, $taxonomy );
				} else {
					$found = term_exists( sanitize_title( (string) $term ), $taxonomy );
				}

				if ( ! empty( $found ) ) {
					$term_ids[] = (int) ( is_array( $found ) ? $found['term_id'] : $found );
				} else {
					$invalid_terms[] = is_scalar( $term ) ? (string) $term : '';
				}
			}

			$term_ids = array_values( array_unique( array_filter( $term_ids ) ) );

			if ( empty( $term_ids ) ) {
				return new \WP_Error( 'invalid_terms', 'None of the provided terms exist in the taxonomy.' );
			}

			$args['tax_query'] = array(
				array(
					'taxonomy'         => $taxonomy,
					'field'            => 'term_id',
					'terms'            => $term_ids,
					'include_children' => true,
				),
			);
		}

		$query = new \WP_Query( $args );

		$result = array(
			'posts'         => $query->posts,
			'source'        => '' !== $taxonomy ? 'taxonomy' : 'all',
			'total'         => (int) $query->found_posts,
			'limit'         => $limit,
			'offset'        => $offset,
			'invalid_terms' => $invalid_terms,
		);

		if ( '' !== $taxonomy ) {
			$result['taxonomy'] = $taxonomy;
		}

		return $result;
	}
	private static function parse_target_date( string $date ) {
		$date = trim( $date );

		if ( preg_match( '/^(\d{4})-(\d{2})-(\d{2})$/', $date, $m ) ) {
			if ( ! checkdate( (int) $m[2], (int) $m[3], (int) $m[1] ) ) {
				return new \WP_Error( 'invalid_date', 'The provided date is not a valid calendar date.' );
			}

			return array(
				'year'     => (int) $m[1],
				'month'    => (int) $m[2],
				'day'      => (int) $m[3],
				'has_time' => false,
				'hour'     => 0,
				'minute'   => 0,
				'second'   => 0,
			);
		}

		if ( preg_match( '/^(\d{4})-(\d{2})-(\d{2})[ T](\d{2}):(\d{2})(?::(\d{2}))?$/', $date, $m ) ) {
			$hour   = (int) $m[4];
			$minute = (int) $m[5];
			$second = isset( $m[6] ) ? (int) $m[6] : 0;

			if ( ! checkdate( (int) $m[2], (int) $m[3], (int) $m[1] ) || $hour > 23 || $minute > 59 || $second > 59 ) {
				return new \WP_Error( 'invalid_date', 'The provided date or time is not valid.' );
			}

			return array(
				'year'     => (int) $m[1],
				'month'    => (int) $m[2],
				'day'      => (int) $m[3],
				'has_time' => true,
				'hour'     => $hour,
				'minute'   => $minute,
				'second'   => $second,
			);
		}

		return new \WP_Error( 'invalid_date', 'date must be Y-m-d, Y-m-d H:i, or Y-m-d H:i:s in the site timezone.' );
	}

	private static function valid_relative_shift( string $shift ): bool {
		return 1 === preg_match( '/^(?:[+-]?\d{1,4}\s*(?:years?|months?|weeks?|days?|hours?|minutes?|mins?|seconds?|secs?)\s*)+$/i', $shift );
	}
	public static function update_dates( array $input ) {
		$selection = self::select_posts( $input, 10, 100 );
		if ( is_wp_error( $selection ) ) {
			return $selection;
		}

		$mode    = strtolower( (string) ( $input['mode'] ?? '' ) );
		$dry_run = ! empty( $input['dry_run'] );

		if ( 'set' === $mode ) {
			$target = self::parse_target_date( isset( $input['date'] ) ? (string) $input['date'] : '' );
			if ( is_wp_error( $target ) ) {
				return $target;
			}
		} elseif ( 'shift' === $mode ) {
			$shift = trim( (string) ( $input['shift'] ?? '' ) );

			if ( '' === $shift || ! self::valid_relative_shift( $shift ) ) {
				return new \WP_Error( 'invalid_shift', 'mode=shift requires a relative shift such as -7 days, +2 weeks, or -1 year -6 months.' );
			}
		} else {
			return new \WP_Error( 'invalid_mode', 'mode must be set or shift.' );
		}

		$results = array();
		$skipped = array();
		$updated = 0;

		foreach ( $selection['posts'] as $post ) {
			if ( ! $post instanceof \WP_Post ) {
				continue;
			}

			if ( ! current_user_can( 'edit_post', $post->ID ) ) {
				$skipped[] = array( 'post_id' => (int) $post->ID, 'reason' => 'permission' );
				continue;
			}

			try {
				$dt = new \DateTime( $post->post_date, wp_timezone() );
			} catch ( \Throwable $e ) {
				$skipped[] = array( 'post_id' => (int) $post->ID, 'reason' => 'invalid_date' );
				continue;
			}

			if ( 'set' === $mode ) {
				$dt->setDate( $target['year'], $target['month'], $target['day'] );

				if ( $target['has_time'] ) {
					$dt->setTime( $target['hour'], $target['minute'], $target['second'] );
				}
			} elseif ( ! $dt->modify( $shift ) ) {
				$skipped[] = array( 'post_id' => (int) $post->ID, 'reason' => 'invalid_shift' );
				continue;
			}

			$year = (int) $dt->format( 'Y' );

			if ( $year < 1900 || $year > 2100 ) {
				$skipped[] = array( 'post_id' => (int) $post->ID, 'reason' => 'date_out_of_range' );
				continue;
			}

			$new_local = $dt->format( 'Y-m-d H:i:s' );

			$gmt = clone $dt;
			$gmt->setTimezone( new \DateTimeZone( 'UTC' ) );
			$new_gmt = $gmt->format( 'Y-m-d H:i:s' );

			$old_local = (string) $post->post_date;
			$changed   = $new_local !== $old_local;

			$item = array(
				'post_id'  => (int) $post->ID,
				'title'    => get_the_title( $post ),
				'status'   => $post->post_status,
				'old_date' => $old_local,
				'new_date' => $new_local,
				'changed'  => $changed,
			);

			if ( ! $dry_run && $changed ) {
				$updated_post = wp_update_post(
					wp_slash(
						array(
							'ID'            => $post->ID,
							'post_date'     => $new_local,
							'post_date_gmt' => $new_gmt,
						)
					),
					true
				);

				if ( is_wp_error( $updated_post ) ) {
					$skipped[] = array(
						'post_id' => (int) $post->ID,
						'reason'  => 'update_failed',
						'error'   => $updated_post->get_error_message(),
					);
					continue;
				}

				$updated++;
			}

			$results[] = $item;
		}

		return array(
			'success' => true,
			'dry_run' => $dry_run,
			'mode'    => $mode,
			'source'  => $selection['source'],
			'total'   => count( $selection['posts'] ),
			'updated' => $dry_run ? 0 : $updated,
			'skipped' => $skipped,
			'results' => $results,
		);
	}
	public static function find_replace( array $input ) {
		$selection = self::select_posts( $input, 10, 100 );
		if ( is_wp_error( $selection ) ) {
			return $selection;
		}

		$search = isset( $input['search'] ) ? (string) $input['search'] : '';

		if ( '' === $search ) {
			return new \WP_Error( 'invalid_search', 'search is required and must not be empty.' );
		}

		$replace        = array_key_exists( 'replace', $input ) && is_string( $input['replace'] ) ? $input['replace'] : '';
		$case_sensitive = ! empty( $input['case_sensitive'] );
		$regex          = ! empty( $input['regex'] );
		$dry_run        = ! empty( $input['dry_run'] );

		if ( $regex ) {
			$delimiter = self::pick_pattern_delimiter( $search );

			if ( null === $delimiter ) {
				return new \WP_Error( 'invalid_pattern', 'The regex search uses every supported delimiter (# ~ @ % /). Rewrite it without one of those characters.' );
			}

			$valid_utf8  = ! function_exists( 'mb_check_encoding' ) || mb_check_encoding( $search, 'UTF-8' );
			$pattern     = $delimiter . $search . $delimiter . ( $valid_utf8 ? 'u' : '' );
			$replacement = $replace;
		} else {
			$pattern     = '#' . preg_quote( $search, '#' ) . '#' . ( $case_sensitive ? '' : 'i' );
			$replacement = str_replace( array( '\\', '$' ), array( '\\\\', '\\$' ), $replace );
		}

		if ( false === @preg_match( $pattern, '' ) ) {
			return new \WP_Error( 'invalid_pattern', 'The provided search is not a valid regular expression.' );
		}

		$results           = array();
		$skipped           = array();
		$posts_with_matches = 0;
		$posts_updated      = 0;
		$total_matches      = 0;

		foreach ( $selection['posts'] as $post ) {
			if ( ! $post instanceof \WP_Post ) {
				continue;
			}

			if ( ! current_user_can( 'edit_post', $post->ID ) ) {
				$skipped[] = array( 'post_id' => (int) $post->ID, 'reason' => 'permission' );
				continue;
			}

			$content = (string) $post->post_content;
			$count   = 0;
			$new     = preg_replace( $pattern, $replacement, $content, -1, $count );

			if ( null === $new ) {
				$skipped[] = array( 'post_id' => (int) $post->ID, 'reason' => 'regex_error' );
				continue;
			}

			if ( 0 === $count ) {
				continue;
			}

			$posts_with_matches++;
			$total_matches += $count;

			$item = array(
				'post_id' => (int) $post->ID,
				'title'   => get_the_title( $post ),
				'matches' => $count,
			);

			if ( $dry_run ) {
				$item['preview'] = self::match_preview( $pattern, $content );
				$results[]       = $item;
				continue;
			}

			if ( ! current_user_can( 'unfiltered_html' ) ) {
				$new = wp_kses_post( $new );
			}

			$updated_post = wp_update_post(
				wp_slash(
					array(
						'ID'           => $post->ID,
						'post_content' => $new,
					)
				),
				true
			);

			if ( is_wp_error( $updated_post ) ) {
				$skipped[] = array(
					'post_id' => (int) $post->ID,
					'reason'  => 'update_failed',
					'error'   => $updated_post->get_error_message(),
				);
				continue;
			}

			$posts_updated++;
			$item['updated'] = true;
			$results[]       = $item;
		}

		return array(
			'success'            => true,
			'dry_run'            => $dry_run,
			'mode'               => $regex ? 'regex' : 'plain',
			'search'             => $search,
			'replace'            => $replace,
			'posts_scanned'      => count( $selection['posts'] ),
			'posts_with_matches' => $posts_with_matches,
			'posts_updated'      => $dry_run ? 0 : $posts_updated,
			'total_matches'      => $total_matches,
			'skipped'            => $skipped,
			'results'            => $results,
		);
	}
	private static function pick_pattern_delimiter( string $pattern ): ?string {
		foreach ( array( '#', '~', '@', '%', '/' ) as $delimiter ) {
			if ( false === strpos( $pattern, $delimiter ) ) {
				return $delimiter;
			}
		}

		return null;
	}

	private static function match_preview( string $pattern, string $content ): string {
		$matches = array();

		if ( ! preg_match( $pattern, $content, $matches, PREG_OFFSET_CAPTURE ) ) {
			return '';
		}

		$pos     = (int) $matches[0][1];
		$length  = strlen( (string) $matches[0][0] );
		$start   = max( 0, $pos - 60 );
		$excerpt = substr( $content, $start, $length + 120 );
		$excerpt = wp_strip_all_tags( (string) $excerpt );
		$excerpt = trim( (string) preg_replace( '/\s+/u', ' ', $excerpt ) );

		return $excerpt;
	}
}
