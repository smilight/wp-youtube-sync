<?php

define( 'WPYS_VERSION', '1.0' );
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
require_once( __DIR__ . '/class/buttons.php' );


/**
 * Widgets
 */
//require_once( __DIR__ . '/widget/diviWidget.php' );


use Madcoda\Youtube\Youtube;


if ( ! is_admin() ) {

	wp_enqueue_script( 'media-element', plugin_dir_url( __FILE__ ) . 'vendor/bower/mediaelement/build/mediaelement-and-player.min.js', [], WPYS_VERSION, true );
	wp_enqueue_style( 'media-element', plugin_dir_url( __FILE__ ) . 'vendor/bower/mediaelement/build/mediaelementplayer.min.css', [], WPYS_VERSION );

	wp_enqueue_script( 'sharer.js', plugin_dir_url( __FILE__ ) . 'assets/js/script.js', [ 'media-element' ], WPYS_VERSION, true );

}

function wp_youtube_sync_init() {

	if ( array_key_exists( 'do_u_action', $_GET ) ) {
		$youtube = new Youtube( array( 'key' => WPYS_Options::get_option( WPYS_OPTIONS_KEY . '_api_key' ) ) );

		$channel = $youtube->getChannelByName( WPYS_Options::get_option( WPYS_OPTIONS_KEY . '_channel' ) );

		if ( array_key_exists( 'playlistId', $_GET ) && $_GET['playlistId'] !== '' ) {
			$playlist_items = $youtube->getPlaylistItemsByPlaylistId( $_GET['playlistId'] );
			foreach ( $playlist_items as $playlist_item ) {
				WPYS_Post::add( $playlist_item );
			}

		} else {
			$playlists = $youtube->getPlaylistsByChannelId( $channel->id, [ 'maxResults' => 50 ] );

			foreach ( $playlists as $playlist ) {
				$playlist_items = $youtube->getPlaylistItemsByPlaylistId( $playlist->id, 50 );
				foreach ( $playlist_items as $playlist_item ) {
					WPYS_Post::add( $playlist_item );
				}
			}
		}

		wp_safe_redirect( '/wp-admin/edit.php?post_type=youtube_video' );

	}

}

add_action( 'admin_init', 'wp_youtube_sync_init' );