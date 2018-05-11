<?php
/**
 * @package    WPRestAPIStructure
 * @author     Martin Jankov
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WP_Model {
	protected static $post_type;
	protected static $wp_table;
	protected static $post_status;
	protected static $query_result;

	public function init() {
		self::$post_type = 'post';
		self::$wp_table = 'wp_posts';
		self::$post_status = 'publish';

		self::$query_result = array();
	}

	public static function all() {
		return self::query();
	}

	/**
	 * Query wrapper
	 * @return array
	 */
	public static function query() {
		$query_args = array(
			'post_type' => self::$post_type,
			'status' => self::$post_status,
		);

		if ( isset( self::$args ) ) {

			if ( ! empty( self::$args['per_page'] ) && is_numeric( self::$args['per_page'] ) ) {
				$query_args['posts_per_page'] = self::$args['per_page'];
			}

			if ( ! empty( self::$args['page'] ) && is_numeric( self::$args['page'] ) ) {
				$query_args['paged'] = self::$args['page'];
			}

			if ( ! empty( self::$args['include'] ) && is_array( self::$args['include'] ) ) {
				$query_args['post__in'] = self::$args['include'];
			}

			if ( ! empty( self::$args['exclude'] ) && is_array( self::$args['exclude'] ) ) {
				$query_args['post__not_in'] = self::$args['exclude'];
			}

			if ( ! empty( self::$args['meta_query'] ) && is_array( self::$args['meta_query'] ) ) {
				$query_args['meta_query'] = self::$args['meta_query'];
			}
		}

		$query = new WP_Query( $query_args );

		if ( $query->have_posts() ) {
				self::$query_result =  $query->posts;
		}

		// use get_metadata and format the return of the post

		return self::$query_result;
	}

	/**
	 * Return formated array with post id and title
	 * @return array
	 */
	public static function get_id_title_arr() {
		$result = array();

		foreach ( self::$query_result as $record ) {
			$result[ $record->ID ] = $record->post_title;
		}

		return $result;
	}

	/**
	 * Get post type custom field value
	 * @param  string $meta_key
	 * @param  int $ID
	 * @return string
	 */
	public static function get_field( string $meta_key, int $ID = null ) {
		if ( is_null( $ID ) ) {
			$ID = get_the_ID();
		}

		if ( ! empty( $meta_key ) ) {
			return get_post_meta( $ID, $meta_key, true );
		}

		return '';
	}
}

WP_Model::init();
