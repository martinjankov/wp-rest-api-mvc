<?php
/**
 * @package    WPRestAPIStructure
 * @author     Martin Jankov
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class HomeController {
	public function index() {
		return Post::all();
	}

	public function store( WP_REST_Request $request ) {
		return $request->get_params();
	}
}
