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
	protected $namespace;
	protected $version;

	public function __construct() {
		$this->namespace = 'wpras';
		$this->version = 'v1';
	}

	public function init() {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	public function register_routes() {
		$this->_load_routes('api');
	}

	private function _load_routes( $file ) {
		@include WPRMVC_ROUTES_DIR . $file . '.php';
	}

	public function get( $route, $function ) {
		try {
			$this->request('GET', $route, $function );
		} catch ( Exception $e ) {}
	}

	public function post( $route, $function ) {
		try {
			$this->request('POST', $route, $function );
		} catch ( Exception $e ) {}
	}

	public function request( $requestMethod, $route, $function ) {
		if ( strpos( $function, '@' ) === false ) {
			throw new Exception('Invalid or method does not exist', 404 );
		}

		$function_parts = explode('@', $function );
		$controller = $function_parts[0];
		$method = $function_parts[1];

		if ( ! class_exists( $controller ) ) {
			throw new Exception('Class ' . $controller . ' does not exist', 404 );
		}

		$route = '/' . ltrim( $route, '/' );

		register_rest_route( $this->namespace . '/' . $this->version, $route, array(
		    'methods' => $requestMethod,
		    'callback' => array( $controller, $method ),
		) );
	}
}
