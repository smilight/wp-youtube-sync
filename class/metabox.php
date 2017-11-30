<?php

abstract class WPYS_Meta_Box {

	public static $optionsKey = WPYS_METABOX_KEY;

	public static function add() {

		$cmb = new_cmb2_box( array(
			'id'            => 'wpys_metabox',
			'title'         => __( 'Youtube Video Metadata', 'cmb2' ),
			'object_types'  => array( 'youtube_video' ), // Post type
			'context'       => 'side',
			'priority'      => 'high',
			'show_names'    => false,
		) );

		$cmb->add_field( array(
			'name'       => __( 'Video Id', 'cmb2' ),
			'desc'       => __( 'Youtube video id', 'cmb2' ),
			'id'         => self::$optionsKey . '_videoId',
			'type'       => 'text',
			'attributes' => array(
				'placeholder'=>'Video Id',
//				'disabled' => 'disabled',
//				'readonly' => 'readonly',
			)
		) );

		$cmb->add_field( array(
			'name'       => __( 'Playlist Id', 'cmb2' ),
			'desc'       => __( 'Youtube video playlist id', 'cmb2' ),
			'id'         => self::$optionsKey . '_playlistId',
			'type'       => 'text',
			'attributes' => array(
				'placeholder'=>'Playlist Id',
				'disabled' => 'disabled',
				'readonly' => 'readonly',
			)

		) );

		// URL text field
		$cmb->add_field( array(
			'name' => __( 'Thumbnail URL', 'cmb2' ),
			'desc' => __( 'Video thumbnail (standart one)', 'cmb2' ),
			'id'   => self::$optionsKey . '_thumbnailUrl',
			'type' => 'text_url',
			'attributes' => array(
				'placeholder'=>'Thumbnail URL',
				'disabled' => 'disabled',
				'readonly' => 'readonly',
			)
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