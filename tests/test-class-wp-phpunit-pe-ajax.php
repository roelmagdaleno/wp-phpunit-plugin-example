<?php

class WP_PHPUnit_PE_Ajax_Test extends WP_Ajax_UnitTestCase {
	private $nonce;

	public function setUp() {
		$this->nonce = wp_create_nonce( 'wp_phpunit_ajax_update_email' );
		new WP_PHPUnit_PE_AJAX();
	}

	public function test_if_sent_data_is_empty() {
		$_POST['_wpnonce'] = $this->nonce;
		$_POST['data']     = wp_json_encode( array( 'data' => array() ) );

		try {
			$this->_handleAjax( 'wp_phpunit_update_email' );
		} catch ( WPAjaxDieStopException|WPAjaxDieContinueException $e ) {}

		$this->assertTrue( isset( $e ) );

		$response = json_decode( $this->_last_response, true );

		$this->assertSame( 'error', $response['type'] );
		$this->assertSame( 'There is no data to save.', $response['message'] );
	}

	public function test_if_email_to_update_is_invalid() {
		$_POST['_wpnonce'] = $this->nonce;
		$_POST['data']     = wp_json_encode( array(
			'data' => array( 'email' => 'hola.org' ),
		) );

		try {
			$this->_handleAjax( 'wp_phpunit_update_email' );
		} catch ( WPAjaxDieStopException|WPAjaxDieContinueException $e ) {}

		$this->assertTrue( isset( $e ) );

		$response = json_decode( $this->_last_response, true );

		$this->assertSame( 'error', $response['type'] );
		$this->assertSame( 'The inserted email is invalid.', $response['message'] );
	}

	public function test_update_email_success() {
		$_POST['_wpnonce'] = $this->nonce;
		$_POST['data']     = wp_json_encode( array(
			'data' => array( 'email' => 'hola@example.org' ),
		) );

		try {
			$this->_handleAjax( 'wp_phpunit_update_email' );
		} catch ( WPAjaxDieStopException|WPAjaxDieContinueException $e ) {}

		$this->assertTrue( isset( $e ) );

		$response = json_decode( $this->_last_response, true );

		$this->assertSame( 'success', $response['type'] );
		$this->assertSame( 'Option updated successfully.', $response['message'] );
	}
}
