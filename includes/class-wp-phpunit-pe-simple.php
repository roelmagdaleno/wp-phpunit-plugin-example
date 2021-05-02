<?php

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access denied.' );
}

if ( class_exists( 'WP_PHPUnit_PE_Simple' ) ) {
	return;
}

class WP_PHPUnit_PE_Simple {
	public function __construct() {
		if ( is_admin() ) {
			return;
		}

		add_filter( 'the_title', array( $this, 'change_post_title' ) );
		add_filter( 'the_content', array( $this, 'insert_new_link' ) );
	}

	public function change_post_title( $title ) {
		return str_replace( 'your_name', 'Roel', $title );
	}

	public function insert_new_link( $content ) {
		$content .= '<p><a href="https://roelmagdaleno.com">https://roelmagdaleno.com</a></p>';
		return $content;
	}
}
