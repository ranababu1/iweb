<?php
namespace Site_AI_Control;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Google {

	public static function search_console( array $input ) {
		$dependency = self::require_site_kit();
		if ( is_wp_error( $dependency ) ) {
			return $dependency;
		}

		$end_date   = self::valid_date( $input['end_date'] ?? '' ) ? $input['end_date'] : gmdate( 'Y-m-d', strtotime( '-3 days' ) );
		$start_date = self::valid_date( $input['start_date'] ?? '' ) ? $input['start_date'] : gmdate( 'Y-m-d', strtotime( $end_date . ' -27 days' ) );
		$limit      = min( 1000, max( 1, absint( $input['limit'] ?? 100 ) ) );
		$dimensions = ! empty( $input['dimensions'] ) ? array_values( array_unique( array_map( 'sanitize_text_field', (array) $input['dimensions'] ) ) ) : array( 'date' );

		$params = array(
			'startDate' => $start_date,
			'endDate'   => $end_date,
			'dimensions'=> $dimensions,
			'limit'     => $limit,
		);

		if ( ! empty( $input['url'] ) ) {
			$params['url'] = esc_url_raw( $input['url'] );
		}

		$response = self::site_kit_request(
			'/google-site-kit/v1/modules/search-console/data/searchanalytics',
			$params
		);

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		$data = $response->get_data();

		return array(
			'service'    => 'search-console',
			'property'   => home_url( '/' ),
			'start_date' => $start_date,
			'end_date'   => $end_date,
			'dimensions' => $dimensions,
			'rows'       => is_array( $data['rows'] ?? null ) ? $data['rows'] : array(),
			'raw'        => self::compact_data( $data ),
		);
	}

	public static function page_speed( array $input ) {
		$dependency = self::require_site_kit();
		if ( is_wp_error( $dependency ) ) {
			return $dependency;
		}

		$url      = ! empty( $input['url'] ) ? esc_url_raw( $input['url'] ) : home_url( '/' );
		$strategy = in_array( $input['strategy'] ?? 'mobile', array( 'mobile', 'desktop' ), true ) ? $input['strategy'] : 'mobile';

		if ( ! wp_http_validate_url( $url ) ) {
			return new \WP_Error( 'invalid_url', 'The PageSpeed URL must be a valid HTTP(S) URL.' );
		}

		$response = self::site_kit_request(
			'/google-site-kit/v1/modules/pagespeed-insights/data/pagespeed',
			array(
				'url'      => $url,
				'strategy' => $strategy,
			)
		);

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		$data = $response->get_data();
		$lighthouse = $data['lighthouseResult'] ?? $data['data']['lighthouseResult'] ?? array();
		$categories = $lighthouse['categories'] ?? array();
		$audits     = $lighthouse['audits'] ?? array();

		$scores = array();
		foreach ( array( 'performance', 'accessibility', 'best-practices', 'seo' ) as $category ) {
			if ( isset( $categories[ $category ]['score'] ) && is_numeric( $categories[ $category ]['score'] ) ) {
				$scores[ $category ] = round( (float) $categories[ $category ]['score'] * 100, 1 );
			}
		}

		$key_audits = array();
		foreach ( array( 'first-contentful-paint', 'largest-contentful-paint', 'speed-index', 'total-blocking-time', 'cumulative-layout-shift', 'interactive' ) as $audit_id ) {
			if ( isset( $audits[ $audit_id ] ) ) {
				$audit = $audits[ $audit_id ];
				$key_audits[ $audit_id ] = array(
					'title'        => $audit['title'] ?? '',
					'score'        => $audit['score'] ?? null,
					'display_value'=> $audit['displayValue'] ?? '',
					'numeric_value'=> $audit['numericValue'] ?? null,
					'score_display'=> $audit['scoreDisplayMode'] ?? '',
				);
			}
		}

		return array(
			'service'    => 'pagespeed-insights',
			'url'        => $url,
			'strategy'   => $strategy,
			'scores'     => $scores,
			'audits'     => $key_audits,
			'fetch_time' => $lighthouse['fetchTime'] ?? '',
			'version'    => $lighthouse['lighthouseVersion'] ?? '',
		);
	}

	public static function ga4_summary( array $input ) {
		$dependency = self::require_site_kit();
		if ( is_wp_error( $dependency ) ) {
			return $dependency;
		}

		$end_date   = self::valid_date( $input['end_date'] ?? '' ) ? $input['end_date'] : gmdate( 'Y-m-d', strtotime( '-1 day' ) );
		$start_date = self::valid_date( $input['start_date'] ?? '' ) ? $input['start_date'] : gmdate( 'Y-m-d', strtotime( $end_date . ' -27 days' ) );

		$metrics = array(
			array( 'name' => 'totalUsers' ),
			array( 'name' => 'sessions' ),
			array( 'name' => 'screenPageViews' ),
			array( 'name' => 'engagementRate' ),
			array( 'name' => 'engagedSessions' ),
			array( 'name' => 'conversions' ),
		);

		$params = array(
			'metrics'   => $metrics,
			'startDate' => $start_date,
			'endDate'   => $end_date,
			'limit'     => 100,
		);

		// A daily dimension makes the response useful to an AI agent without
		// exposing arbitrary GA4 report construction in this first version.
		$params['dimensions'] = array(
			array( 'name' => 'date' ),
		);

		if ( ! empty( $input['page_path'] ) ) {
			$params['dimensions'] = array(
				array( 'name' => 'pagePath' ),
			);
			$params['dimensionFilters'] = array(
				'pagePath' => array(
					'filterType' => 'stringFilter',
					'matchType'  => 'EXACT',
					'value'      => sanitize_text_field( $input['page_path'] ),
				),
			);
		}

		$response = self::site_kit_request(
			'/google-site-kit/v1/modules/analytics-4/data/report',
			$params
		);

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		$data = $response->get_data();

		return array(
			'service'    => 'ga4',
			'start_date' => $start_date,
			'end_date'   => $end_date,
			'page_path'  => $input['page_path'] ?? '',
			'rows'       => is_array( $data['rows'] ?? null ) ? $data['rows'] : array(),
			'raw'        => self::compact_data( $data ),
		);
	}

	private static function require_site_kit() {
		if ( ! defined( 'GOOGLESITEKIT_VERSION' ) ) {
			return new \WP_Error( 'site_kit_not_active', 'Site Kit by Google is not active.' );
		}
		return true;
	}

	private static function site_kit_request( string $route, array $params ) {
		$request = new \WP_REST_Request( 'GET', $route );
		$request->set_query_params( $params );

		$response = rest_do_request( $request );

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		if ( $response->is_error() ) {
			$data = $response->get_data();
			$message = is_array( $data ) && isset( $data['message'] ) ? $data['message'] : 'Site Kit returned an error.';
			$code = is_array( $data ) && isset( $data['code'] ) ? sanitize_key( $data['code'] ) : 'site_kit_request_failed';
			return new \WP_Error( $code, wp_strip_all_tags( (string) $message ), array( 'status' => $response->get_status() ) );
		}

		return $response;
	}

	private static function valid_date( string $date ): bool {
		$parsed = \DateTime::createFromFormat( 'Y-m-d', $date );
		return $parsed && $parsed->format( 'Y-m-d' ) === $date;
	}

	private static function compact_data( $data ) {
		if ( ! is_array( $data ) ) {
			return $data;
		}

		// Keep response sizes bounded for MCP. The normalized fields above are
		// the primary contract; raw data is only a small diagnostic subset.
		$allowed = array( 'rows', 'headers', 'totals', 'startDate', 'endDate', 'propertyID', 'siteURL', 'error' );
		$compact = array();

		foreach ( $allowed as $key ) {
			if ( array_key_exists( $key, $data ) ) {
				$compact[ $key ] = $data[ $key ];
			}
		}

		return $compact;
	}
}
