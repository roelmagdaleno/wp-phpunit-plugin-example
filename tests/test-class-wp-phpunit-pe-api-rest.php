<?php

class WP_PHPUnit_PE_API_REST_Test extends WP_UnitTestCase {
	private $api_rest;

	public function setUp() {
		$user_id = self::factory()->user->create( array( 'role' => 'administrator' ) );
		wp_set_current_user( $user_id );

		$this->api_rest = new WP_PHPUnit_PE_API_REST();
	}

	public function test_if_current_character_is_morty() {
		$character_id = 2;
		$character    = $this->api_rest->get_character( $character_id );

		$this->assertNotWPError( $character );
		$this->assertIsArray( $character );
		$this->assertSame( 'Morty Smith', $character['name'] );
	}

	public function test_if_character_is_not_found() {
		$character_id = 22222222;
		$character    = $this->api_rest->get_character( $character_id );

		$this->assertWPError( $character );
		$this->assertSame( 'not_found', $character->get_error_code() );
		$this->assertSame( 'Character not found', $character->get_error_message() );
	}

	public function test_if_character_id_is_invalid() {
		$character_id = "invalid_id";
		$character    = $this->api_rest->get_character( $character_id );

		$this->assertWPError( $character );
		$this->assertSame( 'no_id', $character->get_error_code() );
		$this->assertSame( 'The character ID is invalid.', $character->get_error_message() );
	}
}
