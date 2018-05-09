<?php
/**
 * Plugin Name: WP Rest API MVC
 * Author:      Martin Jankov
 * Author URI:  https://martincv.com
 * Version:     0.0.1
 * Text Domain: wprmvc
 *
 * @package    WPRestAPIMVC
 * @author     Martin Jankov
 * @since      0.0.1
 * @license    GPL-3.0+
 * @copyright  Copyright (c) 2018, Martin Jankov
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class WPRestAPIMVC {

	/**
	 * Holds the instance
	 *
	 * @var Class instance
	 */
	private static $_instance;


	/**
	 * Plugin verion
	 *
	 * @var string
	 */
	private $_version = '0.0.1';

	/**
	 * Set class instance or return if already set
	 *
	 * @return Class object Class of type WPRestAPIMVC
	 */
	public static function instance() {

		if ( ! isset( self::$_instance ) && ! ( self::$_instance instanceof WPRestAPIMVC ) ) {
			self::$_instance = new WPRestAPIMVC;
			self::$_instance->constants();
			self::$_instance->includes();
			self::$_instance->objects();
		}
		return self::$_instance;
	}

	/**
	 * Include classes and functions
	 *
	 * @return void
	 */
	private function includes() {
		// Classes
		require_once WPRMVC_CLASSES_DIR . 'index.php';

		// Models
		require_once WPRMVC_MODELS_DIR . 'index.php';

		// Controllers
		require_once WPRMVC_CONTROLLERS_DIR . 'index.php';

	}

	/**
	 * Define the plugin constants
	 *
	 * @return void
	 */
	private function constants() {

		// Plugin version
		if ( ! defined( 'WPRMVC_VERSION' ) ) {
			define( 'WPRMVC_VERSION', $this->_version );
		}

		// Plugin Folder Path
		if ( ! defined( 'WPRMVC_PLUGIN_DIR' ) ) {
			define( 'WPRMVC_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		}

		// Plugin Folder URL
		if ( ! defined( 'WPRMVC_PLUGIN_URL' ) ) {
			define( 'WPRMVC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		}

		// Plugin Root File
		if ( ! defined( 'WPRMVC_PLUGIN_FILE' ) ) {
			define( 'WPRMVC_PLUGIN_FILE', __FILE__ );
		}

		// Routes Folder Path
		if ( ! defined( 'WPRMVC_ROUTES_DIR' ) ) {
			define( 'WPRMVC_ROUTES_DIR', WPRMVC_PLUGIN_DIR . 'app/routes/' );
		}

		// Contollers Folder Path
		if ( ! defined( 'WPRMVC_CONTROLLERS_DIR' ) ) {
			define( 'WPRMVC_CONTROLLERS_DIR', WPRMVC_PLUGIN_DIR . 'app/controllers/' );
		}


		// Models Folder Path
		if ( ! defined( 'WPRMVC_MODELS_DIR' ) ) {
			define( 'WPRMVC_MODELS_DIR', WPRMVC_PLUGIN_DIR . 'app/models/' );
		}

		// Classes Folder Path
		if ( ! defined( 'WPRMVC_CLASSES_DIR' ) ) {
			define( 'WPRMVC_CLASSES_DIR', WPRMVC_PLUGIN_DIR . 'classes/' );
		}
	}

	/**
	 * Initialze class objects
	 *
	 * @return void
	 */
	public function objects() {
		(new WP_Routes)->init();
	}
}

function wprmvc() {
	return WPRestAPIMVC::instance();
}
wprmvc();
