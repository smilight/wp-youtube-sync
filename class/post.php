<?php

use Madcoda\Youtube\Youtube;
use Cocur\Slugify\Slugify;


abstract class WPYS_Post {
	public static function add( $playlist_item ) {

		$youtube = new Youtube( array( 'key' => WPYS_Options::get_option( WPYS_OPTIONS_KEY . '_api_key' ) ) );

		$videoId = $playlist_item->snippet->resourceId->videoId;

		$title = $playlist_item->snippet->title;

		$playlistId = $playlist_item->snippet->playlistId;

		$image = $playlist_item->snippet->thumbnails->high->url;

		$catExist = 1;

		$videoPost = [
			'post_title'   => $title,
			'post_content' => '<div class="youtube_placeholder" data-id="' . $videoId . '" data-playlist="' . $playlistId . '" data-image="' . $image . '"></div>' . $playlist_item->snippet->description,
			'post_status'  => 'publish',
			'post_type'    => 'youtube_video',
			'post_author'  => 1
		];

		if ( WPYS_Options::get_option( WPYS_OPTIONS_KEY . '_create_playlists' ) === 'yes' ) {
			$catExist                   = WPYS_Taxonomy::checkExist( $youtube->getPlaylistById( $playlistId )->snippet->title, $playlistId );
			$videoPost['post_category'] = intval( $catExist );
		}

		$exist = WPYS_Post::checkExist( $videoId );

		if ( ! $exist ) {

			$postId = wp_insert_post( $videoPost );

			WPYS_Post::addFeaturedImage( $image, $postId, $title );

			add_post_meta( $postId, WPYS_METABOX_KEY . '_videoId', $videoId, true );
			add_post_meta( $postId, WPYS_METABOX_KEY . '_playlistId', $playlistId, true );
			add_post_meta( $postId, WPYS_METABOX_KEY . '_thumbnailUrl', $image, true );

			if ( WPYS_Options::get_option( WPYS_OPTIONS_KEY . '_create_playlists' ) === 'yes' ) {
				WPYS_Taxonomy::addToPost( $postId, $catExist );
			}

		} elseif ( WPYS_Options::get_option( WPYS_OPTIONS_KEY . '_overwrite' ) === 'yes' && $exist ) {

			$videoPost['ID'] = $exist;

			wp_update_post( $videoPost );

			update_post_meta( $exist, WPYS_METABOX_KEY . '_videoId', $videoId, true );
			update_post_meta( $exist, WPYS_METABOX_KEY . '_playlistId', $playlist_item->snippet->playlistId, true );
			update_post_meta( $exist, WPYS_METABOX_KEY . '_thumbnailUrl', $image, true );

		}

	}

	public static function checkExist( $videoId ) {
		$args = [
			'post_type'   => 'youtube_video',
			'post_status' => 'any',
			'meta_query'  => [
				[
					'key'     => WPYS_METABOX_KEY . '_videoId',
					'value'   => $videoId,
					'compare' => '='
				]
			]
		];

		$posts = get_posts( $args );

		return count( $posts ) > 0 ? $posts[0]->ID : false;

	}

	public static function addFeaturedImage( $image_url, $post_id, $postTitle = '' ) {
		$upload_dir = wp_upload_dir();

		$slugify = new Slugify();
		echo $slugify->slugify( $postTitle );
		if ( ! file_exists( $upload_dir['path'] ) && ! is_dir( $upload_dir['path'] ) ) {
			mkdir( $upload_dir['path'], 0755, true );
		}

		$image_data = file_get_contents( $image_url );

		$filename = $slugify->slugify( $postTitle ) . '-' . time() . '-' . basename( $image_url );

		if ( wp_mkdir_p( $upload_dir['path'] ) ) {
			$file = $upload_dir['path'] . '/' . $filename;
		} else {
			$file = $upload_dir['basedir'] . '/' . $filename;
		}
		file_put_contents( $file, $image_data );

		$wp_filetype = wp_check_filetype( $filename, null );
		$attachment  = array(
			'post_mime_type' => $wp_filetype['type'],
			'post_title'     => sanitize_file_name( $filename ),
			'post_content'   => '',
			'post_status'    => 'inherit'
		);
		$attach_id   = wp_insert_attachment( $attachment, $file, $post_id );
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
		wp_update_attachment_metadata( $attach_id, $attach_data );
		set_post_thumbnail( $post_id, $attach_id );
	}

	public static function get( $id ) {
	}
}