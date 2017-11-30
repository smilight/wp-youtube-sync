<?php


abstract class WPYS_Post {
	public static function add( $playlist_item ) {

		$videoId = $playlist_item->snippet->resourceId->videoId;

		$videoPost = [
			'post_title'   => $playlist_item->snippet->title,
			'post_content' => $playlist_item->snippet->description,
			'post_status'  => 'publish',
			'post_type'    => 'youtube_video',
			'post_author'  => 1
		];

		$image = $playlist_item->snippet->thumbnails->high->url;

		$exist = WPYS_Post::checkExist( $videoId );

		if ( ! $exist ) {

			$postId = wp_insert_post( $videoPost );

			WPYS_Post::addFeaturedImage( $image, $postId );

			add_post_meta( $postId, WPYS_METABOX_KEY . '_videoId', $videoId, true );
			add_post_meta( $postId, WPYS_METABOX_KEY . '_playlistId', $playlist_item->snippet->playlistId, false );
			add_post_meta( $postId, WPYS_METABOX_KEY . '_thumbnailUrl', $image, false );
		} elseif ( WPYS_Options::get_option( WPYS_OPTIONS_KEY . '_overwrite' ) === 'on' && $exist ) {

			$videoPost['ID'] = $exist;

			wp_update_post( $videoPost );

			update_post_meta( $exist, WPYS_METABOX_KEY . '_videoId', $videoId, true );
			update_post_meta( $exist, WPYS_METABOX_KEY . '_playlistId', $playlist_item->snippet->playlistId, false );
			update_post_meta( $exist, WPYS_METABOX_KEY . '_thumbnailUrl', $image, false );

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

	public static function addFeaturedImage( $image_url, $post_id ) {
		$upload_dir = wp_upload_dir();

		if ( ! file_exists( $upload_dir['path'] ) && ! is_dir( $upload_dir['path'] ) ) {
			mkdir( $upload_dir['path'], 0755, true );
		}

		$image_data = file_get_contents( $image_url );
		$filename   = basename( $image_url );
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