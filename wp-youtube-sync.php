<?php
/*
Plugin Name: WP Youtube sync
Plugin URI: https://paaw.pro/plugins/wp-youtube-sync
Description: TODO: description
Author: Oleksii Pershin
Version: 1.0
Author URI: https://paaw.pro/
*/

define( 'WPYS_OPTIONS_KEY', 'wpys_options' );
define( 'WPYS_METABOX_KEY', 'wpys_meta' );

require_once( __DIR__ . '/vendor/autoload.php' );

require_once( __DIR__ . '/class/options.php' );
require_once( __DIR__ . '/class/postType.php' );
require_once( __DIR__ . '/class/metabox.php' );
require_once( __DIR__ . '/class/taxonomy.php' );
require_once( __DIR__ . '/class/post.php' );

use Madcoda\Youtube\Youtube;

function wp_youtube_sync_init() {

	if ( isset( $_POST['do_sync'] ) ) {
		$youtube = new Youtube( array( 'key' => WPYS_Options::get_option( WPYS_OPTIONS_KEY . '_api_key' ) ) );

		$channel        = $youtube->getChannelByName( WPYS_Options::get_option( WPYS_OPTIONS_KEY . '_channel' ) );
		$playlists      = $youtube->getPlaylistsByChannelId( $channel->id );
		$playlist_items = $youtube->getPlaylistItemsByPlaylistId( $playlists[0]->id );

		foreach ( $playlist_items as $playlist_item ) {
			WPYS_Post::add( $playlist_item );
		}

	}

}

add_action( 'admin_init', 'wp_youtube_sync_init' );