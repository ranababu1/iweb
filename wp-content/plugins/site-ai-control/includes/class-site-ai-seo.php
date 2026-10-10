<?php
namespace Site_AI_Control;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class SEO {

	private const REQUIRED_FIELDS = array(
		'seo_title'         => array( 'severity' => 'warning', 'label' => 'SEO title' ),
		'meta_description'  => array( 'severity' => 'critical', 'label' => 'Meta description' ),
		'canonical'         => array( 'severity' => 'warning', 'label' => 'Canonical URL' ),
		'og_title'          => array( 'severity' => 'warning', 'label' => 'OpenGraph title' ),
		'og_description'    => array( 'severity' => 'warning', 'label' => 'OpenGraph description' ),
		'og_image'          => array( 'severity' => 'warning', 'label' => 'OpenGraph image' ),
		'twitter_card'      => array( 'severity' => 'info', 'label' => 'Twitter card' ),
	);

	private const META_KEYS = array(
		'seo_title'            => '_yoast_wpseo_title',
		'meta_description'     => '_yoast_wpseo_metadesc',
		'canonical'            => '_yoast_wpseo_canonical',
		'focus_keyphrase'      => '_yoast_wpseo_focuskw',
		'og_title'             => '_yoast_wpseo_opengraph-title',
		'og_description'       => '_yoast_wpseo_opengraph-description',
		'twitter_title'        => '_yoast_wpseo_twitter-title',
		'twitter_description'  => '_yoast_wpseo_twitter-description',
	);

	public static function find_missing( string $post_type, array $input ) {
		if ( ! in_array( $post_type, array( 'post', 'page' ), true ) ) {
			return new \WP_Error( 'invalid_post_type', 'Only posts and pages are supported.' );
		}

		$limit  = min( 100, max( 1, absint( $input['limit'] ?? 50 ) ) );
		$offset = max( 0, absint( $input['offset'] ?? 0 ) );

		$query = new \WP_Query(
			array(
				'post_type'              => $post_type,
				'post_status'            => 'publish',
				'posts_per_page'         => $limit,
				'offset'                 => $offset,
				'orderby'                => 'date',
				'order'                  => 'DESC',
				'no_found_rows'          => false,
				'ignore_sticky_posts'    => true,
				'update_post_meta_cache' => true,
				'update_post_term_cache' => false,
			)
		);

		$items = array();

		foreach ( $query->posts as $post ) {
			$seo    = self::get_normalized( $post->ID );
			$issues = self::issues_for( $seo, $post );

			if ( empty( $issues ) ) {
				continue;
			}

			$items[] = array(
				'post_id'    => (int) $post->ID,
				'post_type'  => $post->post_type,
				'title'      => get_the_title( $post ),
				'url'        => get_permalink( $post ),
				'modified'   => get_post_modified_time( DATE_ATOM, true, $post ),
				'issues'     => $issues,
				'seo'        => $seo,
			);
		}

		// The WP_Query offset/limit applies before filtering, so the returned
		// count is not necessarily the number of matching items on the site.
		return array(
			'total_published' => (int) $query->found_posts,
			'total_scanned'   => count( $query->posts ),
			'limit'           => $limit,
			'offset'        => $offset,
			'items'         => $items,
			'note'          => 'Pagination applies to scanned published items, not only matching items.',
		);
	}

	public static function get_normalized( int $post_id ): array {
		$post = get_post( $post_id );
		if ( ! $post ) {
			return array();
		}

		$data = array(
			'seo_title'            => self::meta_value( $post_id, 'seo_title' ),
			'meta_description'     => self::meta_value( $post_id, 'meta_description' ),
			'canonical'            => self::meta_value( $post_id, 'canonical' ),
			'focus_keyphrase'      => self::meta_value( $post_id, 'focus_keyphrase' ),
			'og_title'             => self::meta_value( $post_id, 'og_title' ),
			'og_description'       => self::meta_value( $post_id, 'og_description' ),
			'twitter_title'        => self::meta_value( $post_id, 'twitter_title' ),
			'twitter_description'  => self::meta_value( $post_id, 'twitter_description' ),
			'og_image'             => '',
			'twitter_card'         => '',
			'robots'               => array(),
			'schema'               => array(),
		);

		if ( function_exists( 'YoastSEO' ) ) {
			try {
				$surface = YoastSEO()->meta->for_post( $post_id );

				$data['seo_title']           = self::string_value( $surface, 'title', $data['seo_title'] );
				$data['meta_description']    = self::string_value( $surface, 'description', $data['meta_description'] );
				$data['canonical']           = self::string_value( $surface, 'canonical', $data['canonical'] );
				$data['focus_keyphrase']     = self::string_value( $surface, 'primary_focus_keyword', $data['focus_keyphrase'] );
				$data['og_title']            = self::string_value( $surface, 'open_graph_title', $data['og_title'] );
				$data['og_description']      = self::string_value( $surface, 'open_graph_description', $data['og_description'] );
				$data['twitter_title']       = self::string_value( $surface, 'twitter_title', $data['twitter_title'] );
				$data['twitter_description'] = self::string_value( $surface, 'twitter_description', $data['twitter_description'] );

				$og_image = self::property_value( $surface, 'open_graph_image' );
				if ( is_array( $og_image ) ) {
					$data['og_image'] = (string) ( $og_image['url'] ?? $og_image['src'] ?? '' );
				} elseif ( is_object( $og_image ) ) {
					$data['og_image'] = method_exists( $og_image, 'get_url' ) ? (string) $og_image->get_url() : '';
				} elseif ( is_string( $og_image ) ) {
					$data['og_image'] = $og_image;
				}

				$data['twitter_card'] = self::string_value( $surface, 'twitter_card', '' );

				$data['robots'] = array(
					'noindex'      => (bool) self::property_value( $surface, 'is_robots_noindex' ),
					'nofollow'     => (bool) self::property_value( $surface, 'is_robots_nofollow' ),
					'noarchive'    => (bool) self::property_value( $surface, 'is_robots_noarchive' ),
					'nosnippet'    => (bool) self::property_value( $surface, 'is_robots_nosnippet' ),
					'noimageindex' => (bool) self::property_value( $surface, 'is_robots_noimageindex' ),
				);

				$schema = self::property_value( $surface, 'schema' );
				$data['schema'] = is_array( $schema ) ? $schema : array();
			} catch ( \Throwable $e ) {
				// Fall back to post meta. We intentionally do not expose the
				// exception to the AI agent because the metadata remains useful.
			}
		}

		return $data;
	}

	/**
	 * Return normalized Yoast metadata for a taxonomy term.
	 * Yoast uses term metadata keys (without the post-meta `_yoast_` prefix).
	 */
	public static function get_term_meta( array $input ) {
		if ( ! defined( 'WPSEO_VERSION' ) ) {
			return new \WP_Error( 'yoast_not_active', 'Yoast SEO is not active.' );
		}

		$term_id = absint( $input['term_id'] ?? 0 );
		$taxonomy_name = sanitize_key( $input['taxonomy'] ?? '' );
		$taxonomy = get_taxonomy( $taxonomy_name );
		$term = $taxonomy ? get_term( $term_id, $taxonomy_name ) : null;

		if ( ! $taxonomy || ! $taxonomy->public || ! $taxonomy->show_ui || ! $term || is_wp_error( $term ) ) {
			return new \WP_Error( 'invalid_term', 'The taxonomy term does not exist or the taxonomy is not publicly manageable.' );
		}
		if ( ! current_user_can( $taxonomy->cap->edit_terms ) ) {
			return new \WP_Error( 'forbidden', 'You do not have permission to view SEO metadata for this taxonomy.' );
		}

		$fields = self::term_meta_keys();
		$seo = array();
		foreach ( $fields as $field => $meta_key ) {
			$value = get_term_meta( $term_id, $meta_key, true );
			$seo[ $field ] = is_scalar( $value ) ? (string) $value : '';
		}

		$link = get_term_link( $term );
		return array(
			'term_id' => $term_id,
			'taxonomy' => $taxonomy_name,
			'name' => (string) $term->name,
			'url' => is_wp_error( $link ) ? '' : $link,
			'seo' => $seo,
		);
	}

	/** Update only allowlisted Yoast term metadata keys. */
	public static function update_term_meta( array $input ) {
		if ( ! defined( 'WPSEO_VERSION' ) ) {
			return new \WP_Error( 'yoast_not_active', 'Yoast SEO is not active.' );
		}

		$term_id = absint( $input['term_id'] ?? 0 );
		$taxonomy_name = sanitize_key( $input['taxonomy'] ?? '' );
		$taxonomy = get_taxonomy( $taxonomy_name );
		$term = $taxonomy ? get_term( $term_id, $taxonomy_name ) : null;

		if ( ! $taxonomy || ! $taxonomy->public || ! $taxonomy->show_ui || ! $term || is_wp_error( $term ) ) {
			return new \WP_Error( 'invalid_term', 'The taxonomy term does not exist or the taxonomy is not publicly manageable.' );
		}
		if ( ! current_user_can( $taxonomy->cap->edit_terms ) ) {
			return new \WP_Error( 'forbidden', 'You do not have permission to edit SEO metadata for this taxonomy.' );
		}

		$keys = self::term_meta_keys();
		$updated = array();
		foreach ( $keys as $field => $meta_key ) {
			if ( ! array_key_exists( $field, $input ) ) {
				continue;
			}
			$value = is_string( $input[ $field ] ) ? trim( wp_unslash( $input[ $field ] ) ) : '';
			$value = sanitize_text_field( $value );
			if ( 'canonical' === $field && '' !== $value && ! wp_http_validate_url( $value ) ) {
				return new \WP_Error( 'invalid_canonical', 'The canonical value must be a valid HTTP or HTTPS URL.' );
			}
			if ( '' === $value ) {
				delete_term_meta( $term_id, $meta_key );
			} else {
				update_term_meta( $term_id, $meta_key, $value );
			}
			$updated[] = $field;
		}

		clean_term_cache( $term_id, $taxonomy_name );
		$result = self::get_term_meta( array( 'term_id' => $term_id, 'taxonomy' => $taxonomy_name ) );
		if ( is_wp_error( $result ) ) {
			return $result;
		}
		$result['updated'] = $updated;
		return $result;
	}

	private static function term_meta_keys(): array {
		return array(
			'seo_title' => 'wpseo_title',
			'meta_description' => 'wpseo_desc',
			'canonical' => 'wpseo_canonical',
			'focus_keyphrase' => 'wpseo_focuskw',
			'og_title' => 'wpseo_opengraph-title',
			'og_description' => 'wpseo_opengraph-description',
			'twitter_title' => 'wpseo_twitter-title',
			'twitter_description' => 'wpseo_twitter-description',
		);
	}

	public static function update_yoast_meta( array $input ) {
		if ( ! defined( 'WPSEO_VERSION' ) ) {
			return new \WP_Error( 'yoast_not_active', 'Yoast SEO is not active.' );
		}

		$post_id = absint( $input['post_id'] ?? 0 );
		$post    = get_post( $post_id );

		$post_type = $post ? get_post_type_object( $post->post_type ) : null;
		if ( ! $post || ! $post_type || ! $post_type->public || ! $post_type->show_ui || in_array( $post->post_type, array( 'attachment', 'revision' ), true ) ) {
			return new \WP_Error( 'invalid_post', 'The specified content does not exist or its post type is not publicly manageable.' );
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return new \WP_Error( 'forbidden', 'You do not have permission to edit this content.' );
		}

		$allowed = array_keys( self::META_KEYS );
		$updated = array();

		foreach ( $allowed as $field ) {
			if ( ! array_key_exists( $field, $input ) ) {
				continue;
			}

			$value = is_string( $input[ $field ] ) ? trim( wp_unslash( $input[ $field ] ) ) : '';
			$value = wp_strip_all_tags( $value );

			if ( 'canonical' === $field && '' !== $value && ! wp_http_validate_url( $value ) ) {
				return new \WP_Error( 'invalid_canonical', 'The canonical value must be a valid URL.' );
			}

			$key = self::META_KEYS[ $field ];

			if ( '' === $value ) {
				delete_post_meta( $post_id, $key );
			} else {
				update_post_meta( $post_id, $key, $value );
			}

			$updated[] = $field;
		}

		// Yoast documents that indexables are updated when content or metadata is
		// saved. Trigger the normal WordPress save lifecycle after changing the
		// controlled meta fields, without calling private Yoast internals.
		wp_update_post( array( 'ID' => $post_id ), true );
		clean_post_cache( $post_id );

		return array(
			'post_id' => $post_id,
			'updated' => $updated,
			'seo'     => self::get_normalized( $post_id ),
		);
	}

	public static function audit( array $input ) {
		$post_id = absint( $input['post_id'] ?? 0 );
		$post    = get_post( $post_id );

		if ( ! $post || ! in_array( $post->post_type, array( 'post', 'page' ), true ) ) {
			return new \WP_Error( 'invalid_post', 'The specified post or page does not exist.' );
		}

		if ( ! current_user_can( 'read_post', $post_id ) ) {
			return new \WP_Error( 'forbidden', 'You do not have permission to view this post.' );
		}

		$seo     = self::get_normalized( $post_id );
		$issues  = self::issues_for( $seo, $post );
		$content = Content::audit( array( 'post_id' => $post_id ) );

		if ( is_wp_error( $content ) ) {
			$content = array();
		}

		$score = 100;
		foreach ( $issues as $issue ) {
			$score -= 'critical' === $issue['severity'] ? 15 : ( 'warning' === $issue['severity'] ? 7 : 2 );
		}
		if ( isset( $content['summary']['missing_alt_text'] ) && $content['summary']['missing_alt_text'] > 0 ) {
			$score -= min( 15, $content['summary']['missing_alt_text'] * 3 );
		}
		if ( isset( $content['summary']['internal_links'] ) && 0 === $content['summary']['internal_links'] ) {
			$score -= 10;
		}
		$score = max( 0, min( 100, $score ) );

		return array(
			'post_id' => $post_id,
			'title'   => get_the_title( $post ),
			'url'     => get_permalink( $post ),
			'score'   => $score,
			'issues'  => $issues,
			'seo'     => $seo,
			'content' => $content,
		);
	}

	private static function issues_for( array $seo, \WP_Post $post ): array {
		$issues = array();

		foreach ( self::REQUIRED_FIELDS as $field => $config ) {
			$value = $seo[ $field ] ?? '';
			$empty = is_array( $value ) ? empty( $value ) : '' === trim( (string) $value );

			if ( $empty ) {
				$issues[] = array(
					'field'    => $field,
					'severity' => $config['severity'],
					'message'  => $config['label'] . ' is missing from the generated Yoast metadata.',
				);
			}
		}

		$title = trim( (string) ( $seo['seo_title'] ?? '' ) );
		if ( '' !== $title && ( mb_strlen( $title ) < 20 || mb_strlen( $title ) > 65 ) ) {
			$issues[] = array(
				'field'    => 'seo_title',
				'severity' => 'warning',
				'message'  => 'SEO title is outside the preferred 20-65 character range used by this audit.',
				'length'   => mb_strlen( $title ),
			);
		}

		$description = trim( (string) ( $seo['meta_description'] ?? '' ) );
		if ( '' !== $description && ( mb_strlen( $description ) < 70 || mb_strlen( $description ) > 160 ) ) {
			$issues[] = array(
				'field'    => 'meta_description',
				'severity' => 'warning',
				'message'  => 'Meta description is outside the preferred 70-160 character range used by this audit.',
				'length'   => mb_strlen( $description ),
			);
		}

		if ( ! empty( $seo['robots']['noindex'] ) ) {
			$issues[] = array(
				'field'    => 'robots',
				'severity' => 'critical',
				'message'  => 'The generated robots metadata contains noindex.',
			);
		}

		if ( '' === trim( (string) ( $seo['focus_keyphrase'] ?? '' ) ) ) {
			$issues[] = array(
				'field'    => 'focus_keyphrase',
				'severity' => 'info',
				'message'  => 'No Yoast focus keyphrase is set. This is informational and is not automatically treated as a technical SEO failure.',
			);
		}

		return $issues;
	}

	private static function meta_value( int $post_id, string $field ): string {
		$key = self::META_KEYS[ $field ] ?? '';
		if ( '' === $key ) {
			return '';
		}
		return trim( (string) get_post_meta( $post_id, $key, true ) );
	}

	private static function string_value( $object, string $property, string $fallback ): string {
		$value = self::property_value( $object, $property );
		return is_scalar( $value ) ? trim( (string) $value ) : $fallback;
	}

	private static function property_value( $object, string $property ) {
		if ( is_object( $object ) && isset( $object->{$property} ) ) {
			return $object->{$property};
		}
		if ( is_array( $object ) && array_key_exists( $property, $object ) ) {
			return $object[ $property ];
		}
		return null;
	}
}
