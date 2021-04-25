<?php

class WP_PHPUnit_PE_Simple_Test extends WP_UnitTestCase {
	private $post;

	/**
	 * Initialize the WP_PHPUnit_PE_Simple class to register the
	 * filters hooks to change the post title.
	 */
	public function setUp() {
		$this->post = $this->factory->post->create_and_get( array(
			'post_title'   => 'My name is your_name',
			'post_content' => 'Hello, this is a custom post content for PHPUnit testing...',
		) );

		new WP_PHPUnit_PE_Simple();
	}

	public function test_change_post_title() {
		$title = get_the_title( $this->post );
		$this->assertSame( 'My name is Roel', $title );
	}

	public function test_insert_new_link() {
		$permalink = get_permalink( $this->post );
		$this->go_to( $permalink );

		ob_start();
		the_content();
		$post_content = ob_get_clean();

		$this->assertContains( '<a href="https://roelmagdaleno.com">https://roelmagdaleno.com</a>', $post_content );
	}
}
