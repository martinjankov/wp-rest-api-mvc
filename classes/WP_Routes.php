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

	public function get( $route, $function, $args = array() ) {
		try {
			$this->request( WP_REST_Server::READABLE, $route, $function, $args );
			return $this;
		} catch ( Exception $e ) {}
	}

	public function post( $route, $function, $args = array() ) {
		try {
			$this->request( WP_REST_Server::CREATABLE, $route, $function, $args );
			return $this;
		} catch ( Exception $e ) {}
	}

	public function resource( $slug, $function, $args ) {
		$this->request( 'resource', $slug, $function, $args );
	}

	public function request( $requestMethod, $route, $function, $args = array() ) {
		$allowed_request_metods = array('GET', 'POST', 'PUT', 'FETCH', 'DELETE');

		if ( strpos( $function, '@' ) === false && in_array( $requestMethod, $allowed_request_metods )  ) {
			throw new Exception('Invalid or method does not exist', 404 );
		}

		$controller = $function;

		if ( $resource !== 'resource' ) {
			$function_parts = explode('@', $function );
			$controller = $function_parts[0];
			$method = $function_parts[1];
		}

		if ( ! class_exists( $controller ) ) {
			throw new Exception('Class ' . $controller . ' does not exist', 404 );
		}

		$route = '/' . ltrim( $route, '/' );

		// create resource routes

		$body = array(
		    'methods' => $requestMethod,
		    'callback' => array( $controller, $method ),
		)

		if ( ! empty( $args ) ) {
			$body = array_merge( $body, $args );
		}

		register_rest_route( $this->namespace . '/' . $this->version, $route, $body );
	}
}
