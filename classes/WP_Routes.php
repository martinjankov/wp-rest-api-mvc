<?php
/**
 * @package    WPRestAPIStructure
 * @author     Martin Jankov
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WP_Routes {
	public function init() {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	public function register_routes() {
		$this->_load_routes('home');
	}

	private function _load_routes( $file ) {
		@include WPRMVC_ROUTES_DIR . $file . '.php';
	}
}
