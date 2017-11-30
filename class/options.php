<?php

abstract class WPYS_Options {

	public static $adminOptionKey = WPYS_OPTIONS_KEY;

	public static function add() {

		$cmb_options = new_cmb2_box( [
			'id'           => self::$adminOptionKey . '_metabox',
			'title'        => __( 'Options', 'wp-youtube-sync' ),
			'object_types' => [ 'options-page', 'page', 'youtube_video' ],
			'option_key'   => self::$adminOptionKey,
			'menu_title'   => __( 'Options', 'wp-youtube-sync' ),
			'parent_slug'  => 'edit.php?post_type=youtube_video',
		] );

		$cmb_options->add_field( [
			'name' => __( 'Youtube API Key', 'wp-youtube-sync' ),
			'id'   => self::$adminOptionKey . '_api_key',
			'type' => 'text',
		] );

		$cmb_options->add_field( [
			'name' => __( 'Youtube Channel Name', 'wp-youtube-sync' ),
			'id'   => self::$adminOptionKey . '_channel',
			'type' => 'text',
		] );

		$cmb_options->add_field([
			'name' => __('Overwrite posts ', 'wp-youtube-sync'),
			'id' => self::$adminOptionKey . '_overwrite',
			'type' => 'checkbox',
			'default' => 'off'
		]);

		$cmb_options->add_field([
			'name' => __('Create playlists in WP? ', 'wp-youtube-sync'),
			'id' => self::$adminOptionKey . '_create_playlists',
			'type' => 'checkbox',
			'default' => 'off'
		]);

	}

	public static function get_option( $key = '', $default = false ) {
		var_dump(self::$adminOptionKey);
		if ( function_exists( 'cmb2_get_option' ) ) {
			return cmb2_get_option( self::$adminOptionKey, $key, $default );
		}
		// Fallback to get_option if CMB2 is not loaded yet.
		$opts = get_option( self::$adminOptionKey, $default );
		$val  = $default;
		if ( 'all' == $key ) {
			$val = $opts;
		} elseif ( is_array( $opts ) && array_key_exists( $key, $opts ) && false !== $opts[ $key ] ) {
			$val = $opts[ $key ];
		}

		return $val;
	}
}

add_action( 'cmb2_admin_init', [ 'WPYS_Options', 'add' ] );