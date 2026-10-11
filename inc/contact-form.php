<?php
/**
 * Project enquiry form handling.
 *
 * The form on the Start a project template posts to admin-post.php. The
 * handler validates the request, emails the enquiry (with any attachments)
 * and redirects back with a status flag.
 *
 * @package iweb
 * @since 1.10.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Email address that receives enquiries and is shown on the page.
 *
 * @since 1.10.0
 *
 * @return string
 */
function iweb_contact_email() {
	return sanitize_email( apply_filters( 'iweb_contact_email', get_option( 'admin_email' ) ) );
}

/**
 * Project types offered in the form.
 *
 * @since 1.10.0
 *
 * @return string[]
 */
function iweb_contact_project_types() {
	return apply_filters(
		'iweb_contact_project_types',
		array(
			__( 'Get found (SEO, AEO, GEO)', 'iweb' ),
			__( 'Turn visitors into customers', 'iweb' ),
			__( 'Automate the busywork', 'iweb' ),
			__( 'Know what\'s working', 'iweb' ),
			__( 'Custom development', 'iweb' ),
			__( 'Not sure yet', 'iweb' ),
		)
	);
}

/**
 * Budget ranges offered in the form.
 *
 * @since 1.10.0
 *
 * @return string[]
 */
function iweb_contact_budgets() {
	return apply_filters(
		'iweb_contact_budgets',
		array(
			__( 'Under $2,000', 'iweb' ),
			__( '$2,000 – $5,000', 'iweb' ),
			__( '$5,000 – $10,000', 'iweb' ),
			__( '$10,000+', 'iweb' ),
			__( 'Not sure yet', 'iweb' ),
		)
	);
}

/**
 * Redirect back to the form with a status flag.
 *
 * @since 1.10.0
 *
 * @param string $status Status: sent, invalid, spam, upload or failed.
 * @return void
 */
function iweb_contact_redirect( $status ) {
	$back = wp_get_referer();
	$back = $back ? $back : home_url( '/contact/' );

	wp_safe_redirect( add_query_arg( 'iweb_contact', $status, remove_query_arg( 'iweb_contact', $back ) ) . '#enquiry' );
	exit;
}

/**
 * Handle a project enquiry submission.
 *
 * @since 1.10.0
 *
 * @return void
 */
function iweb_handle_contact_form() {
	if ( ! isset( $_POST['iweb_contact_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['iweb_contact_nonce'] ) ), 'iweb_contact' ) ) {
		iweb_contact_redirect( 'invalid' );
	}

	// Honeypot: real visitors never see or fill this field.
	if ( ! empty( $_POST['iweb_hp'] ) ) {
		iweb_contact_redirect( 'sent' );
	}

	// One enquiry per minute per visitor.
	$ip_key = 'iweb_contact_' . md5( isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '' );

	if ( get_transient( $ip_key ) ) {
		iweb_contact_redirect( 'spam' );
	}

	$name    = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$company = isset( $_POST['company'] ) ? sanitize_text_field( wp_unslash( $_POST['company'] ) ) : '';
	$website = isset( $_POST['website'] ) ? esc_url_raw( wp_unslash( $_POST['website'] ) ) : '';
	$type    = isset( $_POST['project_type'] ) ? sanitize_text_field( wp_unslash( $_POST['project_type'] ) ) : '';
	$budget  = isset( $_POST['budget'] ) ? sanitize_text_field( wp_unslash( $_POST['budget'] ) ) : '';
	$details = isset( $_POST['details'] ) ? sanitize_textarea_field( wp_unslash( $_POST['details'] ) ) : '';

	if ( '' === $name || ! is_email( $email ) || ! in_array( $type, iweb_contact_project_types(), true ) || '' === $details ) {
		iweb_contact_redirect( 'invalid' );
	}

	if ( '' !== $budget && ! in_array( $budget, iweb_contact_budgets(), true ) ) {
		$budget = '';
	}

	// Attachments: up to 3 files, 10MB each, WordPress-allowed types only.
	$attachments = array();
	$uploaded    = array();

	if ( ! empty( $_FILES['attachments']['name'][0] ) ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';

		$count = min( 3, count( $_FILES['attachments']['name'] ) );

		for ( $i = 0; $i < $count; $i++ ) {
			if ( UPLOAD_ERR_NO_FILE === $_FILES['attachments']['error'][ $i ] ) {
				continue;
			}

			$file = array(
				'name'     => $_FILES['attachments']['name'][ $i ],
				'type'     => $_FILES['attachments']['type'][ $i ],
				'tmp_name' => $_FILES['attachments']['tmp_name'][ $i ],
				'error'    => $_FILES['attachments']['error'][ $i ],
				'size'     => $_FILES['attachments']['size'][ $i ],
			);

			if ( UPLOAD_ERR_OK !== $file['error'] || $file['size'] > 10 * MB_IN_BYTES ) {
				iweb_contact_redirect( 'upload' );
			}

			$result = wp_handle_upload( $file, array( 'test_form' => false ) );

			if ( ! empty( $result['error'] ) ) {
				iweb_contact_redirect( 'upload' );
			}

			$uploaded[]    = $result['file'];
			$attachments[] = $result['file'];
		}
	}

	$lines = array(
		'Name: ' . $name,
		'Email: ' . $email,
		'Company: ' . $company,
		'Website: ' . $website,
		'Project type: ' . $type,
		'Budget: ' . $budget,
		'',
		$details,
	);

	$headers = array( 'Reply-To: ' . $name . ' <' . $email . '>' );
	$subject = sprintf( '[%s] Project enquiry from %s', wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ), $name );
	$sent    = wp_mail( iweb_contact_email(), $subject, implode( "\n", $lines ), $headers, $attachments );

	// Files only exist to be attached; do not keep them on the server.
	foreach ( $uploaded as $path ) {
		wp_delete_file( $path );
	}

	if ( ! $sent ) {
		iweb_contact_redirect( 'failed' );
	}

	set_transient( $ip_key, 1, MINUTE_IN_SECONDS );
	iweb_contact_redirect( 'sent' );
}
add_action( 'admin_post_nopriv_iweb_contact', 'iweb_handle_contact_form' );
add_action( 'admin_post_iweb_contact', 'iweb_handle_contact_form' );
