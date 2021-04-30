<?php

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access denied.' );
}

if ( class_exists( 'WP_PHPUnit_PE_API_REST' ) ) {
	return;
}

class WP_PHPUnit_PE_API_REST {
	private $uri = 'https://rickandmortyapi.com/api/';

	public function get_character( $id ) {
		if ( ! is_user_logged_in() ) {
			return new WP_Error( 'no_user', 'You are not allowed to run this operation.' );
		}

		$id = (int) $id;

		if ( ! $id ) {
			return new WP_Error( 'no_id', 'The character ID is invalid.' );
		}

		$response = wp_remote_get( $this->uri . 'character/' . $id );

		if ( is_wp_error( $response ) ) {
			return new WP_Error( 'internal_error', $response->get_error_message() );
		}

		$valid_http_codes  = array( 200 );
		$current_http_code = wp_remote_retrieve_response_code( $response );
		$response          = json_decode( wp_remote_retrieve_body( $response ), true );

		return ! in_array( $current_http_code, $valid_http_codes, true )
			? new WP_Error( 'not_found', $response['error'] )
			: $response;
	}
}
