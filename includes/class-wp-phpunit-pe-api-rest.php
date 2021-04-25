<?php

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access denied.' );
}

if ( class_exists( 'WP_PHPUnit_PE_API_REST' ) ) {
	return;
}

class WP_PHPUnit_PE_API_REST {
	public function __construct() {

	}
}
