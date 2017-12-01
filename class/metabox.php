<?php

abstract class WPYS_Meta_Box {

	public static $optionsKey = WPYS_METABOX_KEY;

	public static function add() {

		/**
		 * Add metaboxes for "youtube_video" post type
		 */
		$cmb = new_cmb2_box( array(
			'id'           => 'wpys_metabox',
			'title'        => __( 'Youtube Video Metadata', 'wp-youtube-sync' ),
			'object_types' => array( 'youtube_video' ),
			'context'      => 'side',
			'priority'     => 'high',
			'show_names'   => false,
		) );

		$cmb->add_field( array(
			'name'       => __( 'Video Id', 'wp-youtube-sync' ),
			'desc'       => __( 'Youtube video id', 'wp-youtube-sync' ),
			'id'         => self::$optionsKey . '_videoId',
			'type'       => 'text',
			'attributes' => array(
				'disabled' => 'disabled',
				'readonly' => 'readonly',
			)
		) );

		$cmb->add_field( array(
			'name'       => __( 'Playlist Id', 'wp-youtube-sync' ),
			'desc'       => __( 'Youtube video playlist id', 'wp-youtube-sync' ),
			'id'         => self::$optionsKey . '_playlistId',
			'type'       => 'text',
			'attributes' => array(
				'disabled' => 'disabled',
				'readonly' => 'readonly',
			)

		) );

		// URL text field
		$cmb->add_field( array(
			'name'       => __( 'Thumbnail URL', 'wp-youtube-sync' ),
			'desc'       => __( 'Video thumbnail (standard one)', 'wp-youtube-sync' ),
			'id'         => self::$optionsKey . '_thumbnailUrl',
			'type'       => 'text_url',
			'attributes' => array(
				'disabled' => 'disabled',
				'readonly' => 'readonly',
			)
		) );


		/**
		 * Add metaboxes for "category_youtubeChanel" tag
		 */
		$cmb_term = new_cmb2_box( array(
			'id'               => self::$optionsKey . '_category_metabox',
			'title'            => __( 'Playlist Id', 'wp-youtube-sync' ),
			'object_types'     => array( 'term' ),
			'taxonomies'       => array( 'category_youtubeChanel' ),
			 'new_term_section' => true, // Will display in the "Add New Category" section
		) );

		$cmb_term->add_field( array(
			'name'       => __( 'Playlist Id', 'wp-youtube-sync' ),
			'desc'       => __( 'Youtube video playlist id', 'wp-youtube-sync' ),
			'id'         => self::$optionsKey . '_category_playlistId',
			'type'       => 'text',
//			'attributes' => array(
//				'disabled' => 'disabled',
//				'readonly' => 'readonly',
//			)

		) );

	}

	public static function get_option( $key = '', $default = false ) {
		if ( function_exists( 'cmb2_get_option' ) ) {
			return cmb2_get_option( self::$optionsKey, $key, $default );
		}
		// Fallback to get_option if CMB2 is not loaded yet.
		$opts = get_option( self::$optionsKey, $default );
		$val  = $default;
		if ( 'all' == $key ) {
			$val = $opts;
		} elseif ( is_array( $opts ) && array_key_exists( $key, $opts ) && false !== $opts[ $key ] ) {
			$val = $opts[ $key ];
		}

		return $val;
	}
}

add_action( 'cmb2_admin_init', [ 'WPYS_Meta_Box', 'add' ] );