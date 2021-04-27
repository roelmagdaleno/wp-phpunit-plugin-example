<?php

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access denied.' );
}

if ( class_exists( 'WP_PHPUnit_PE_AJAX' ) ) {
	return;
}

class WP_PHPUnit_PE_AJAX {
	public function __construct() {
		add_action( 'wp_ajax_wp_phpunit_update_email', array( $this, 'update_email' ) );
	}

	public function update_email() {
		check_ajax_referer( 'wp_phpunit_ajax_update_email' );

		$data = json_decode( wp_unslash( $_POST['data'] ), true );
		$user = $data['user'];

		if ( empty( $user ) || ! isset( $user['email'] ) ) {
			wp_send_json_error( array( 'message' => 'There is no data to save.' ) );
		}

		if ( ! is_email( $user['email'] ) ) {
			wp_send_json_error( array( 'message' => 'The inserted email is invalid.' ) );
		}

		update_option( 'wp_phpunit_tests_option', $user );
		wp_send_json_success( array( 'message' => 'Option updated successfully.' ) );
	}
}
