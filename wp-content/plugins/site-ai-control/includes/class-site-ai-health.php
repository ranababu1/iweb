<?php
namespace Site_AI_Control;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Health {

	public static function get() {
		if ( ! class_exists( 'WP_Site_Health' ) ) {
			$path = ABSPATH . 'wp-admin/includes/class-wp-site-health.php';
			if ( file_exists( $path ) ) {
				require_once $path;
			}
		}

		$site = array(
			'name'             => get_bloginfo( 'name' ),
			'url'              => home_url(),
			'wordpress_version' => get_bloginfo( 'version' ),
			'php_version'      => PHP_VERSION,
			'php_sapi'         => PHP_SAPI,
			'server_software'  => isset( $_SERVER['SERVER_SOFTWARE'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_SOFTWARE'] ) ) : '',
			'db_version'       => isset( $GLOBALS['wpdb'] ) ? $GLOBALS['wpdb']->db_version() : '',
			'wp_debug'         => defined( 'WP_DEBUG' ) && WP_DEBUG,
			'https'            => is_ssl(),
			'object_cache'     => wp_using_ext_object_cache(),
			'cron_disabled'    => defined( 'DISABLE_WP_CRON' ) && DISABLE_WP_CRON,
			'environment'      => function_exists( 'wp_get_environment_type' ) ? wp_get_environment_type() : 'production',
		);

		$checks = array();

		if ( class_exists( 'WP_Site_Health' ) ) {
			$health = WP_Site_Health::get_instance();
			$tests  = WP_Site_Health::get_tests();

			foreach ( $tests['direct'] as $key => $test ) {
				$method = '';

				if ( ! empty( $test['test'] ) && is_string( $test['test'] ) ) {
					$method = 'get_test_' . $test['test'];
				}

				if ( $method && is_callable( array( $health, $method ) ) ) {
					try {
						$result = call_user_func( array( $health, $method ) );
						$checks[] = self::normalize_check( $key, $test, $result );
					} catch ( \Throwable $e ) {
						$checks[] = array(
							'id'       => $key,
							'label'    => isset( $test['label'] ) ? wp_strip_all_tags( $test['label'] ) : $key,
							'status'   => 'error',
							'message'  => 'Site Health test could not be executed.',
						);
					}
				}
			}

			// Include the most useful asynchronous checks through their direct
			// callable when WordPress exposes one.
			foreach ( $tests['async'] as $key => $test ) {
				if ( empty( $test['async_direct_test'] ) || ! is_callable( $test['async_direct_test'] ) ) {
					continue;
				}

				try {
					$result = call_user_func( $test['async_direct_test'] );
					$checks[] = self::normalize_check( $key, $test, $result );
				} catch ( \Throwable $e ) {
					$checks[] = array(
						'id'       => $key,
						'label'    => isset( $test['label'] ) ? wp_strip_all_tags( $test['label'] ) : $key,
						'status'   => 'error',
						'message'  => 'Site Health asynchronous test could not be executed.',
					);
				}
			}
		}

		return array(
			'site'   => $site,
			'checks' => $checks,
			'generated_at' => gmdate( DATE_ATOM ),
		);
	}

	private static function normalize_check( string $id, array $definition, $result ): array {
		$status = 'unknown';
		$message = '';
		$actions = '';

		if ( is_array( $result ) ) {
			if ( isset( $result['status'] ) ) {
				$status = sanitize_key( (string) $result['status'] );
			}
			if ( isset( $result['label'] ) ) {
				$message = wp_strip_all_tags( (string) $result['label'] );
			}
			if ( isset( $result['description'] ) ) {
				$message = wp_strip_all_tags( (string) $result['description'] );
			}
			if ( isset( $result['actions'] ) ) {
				$actions = wp_strip_all_tags( (string) $result['actions'] );
			}
		}

		return array(
			'id'       => $id,
			'label'    => isset( $definition['label'] ) ? wp_strip_all_tags( $definition['label'] ) : $id,
			'status'   => $status,
			'message'  => $message,
			'actions'  => $actions,
		);
	}
}
