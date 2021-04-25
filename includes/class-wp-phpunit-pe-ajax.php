<?php

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access denied.' );
}

if ( class_exists( 'WP_PHPUnit_PE_AJAX' ) ) {
	return;
}

class WP_PHPUnit_PE_AJAX {
	public function __construct() {

	}
}
