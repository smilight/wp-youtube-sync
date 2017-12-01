<?php


abstract class WPYS_Taxonomy {
	public static function addToPost( $postId, $termId ) {
		wp_set_post_terms( $postId, [ intval( $termId ) ], 'category_youtubeChanel' );
	}

	public static function add() {

	}

	public static function checkExist( $termName,$playListId ) {

		$term = term_exists( $termName, 'category_youtubeChanel' );

		if ( $term !== 0 && $term !== null ) {

			add_term_meta( $term['term_id'], WPYS_METABOX_KEY . '_category_playlistId', $playListId, true );

			return $term['term_id'];
		} else {
			$newTerm = wp_insert_term( $termName, 'category_youtubeChanel' );

			add_term_meta( $newTerm['term_id'], WPYS_METABOX_KEY . '_category_playlistId', $playListId, true );

			return $newTerm['term_id'];
		}
	}

	public static function init() {

		$labels = array(
			'name'                       => __( 'Playlists', 'wp-youtube-sync' ),
			'singular_name'              => __( 'Playlist', 'wp-youtube-sync' ),
			'search_items'               => __( 'Search Playlist', 'wp-youtube-sync' ),
			'all_items'                  => __( 'All Playlists', 'wp-youtube-sync' ),
			'edit_item'                  => __( 'Edit Playlist', 'wp-youtube-sync' ),
			'update_item'                => __( 'Update Playlist', 'wp-youtube-sync' ),
			'add_new_item'               => __( 'Add New Playlist', 'wp-youtube-sync' ),
			'new_item_name'              => __( 'New Playlist Name', 'wp-youtube-sync' ),
			'menu_name'                  => __( 'Playlists', 'wp-youtube-sync' ),
			'view_item'                  => __( 'View Playlist', 'wp-youtube-sync' ),
			'popular_items'              => __( 'Popular Playlists', 'wp-youtube-sync' ),
			'separate_items_with_commas' => __( 'Separate Playlists with commas', 'wp-youtube-sync' ),
			'add_or_remove_items'        => __( 'Add or remove playlists', 'wp-youtube-sync' ),
			'choose_from_most_used'      => __( 'Choose from the most used playlists', 'wp-youtube-sync' ),
			'not_found'                  => __( 'No playlists found', 'wp-youtube-sync' )
		);

		$options = [
			'hierarchical'      => true,
			'labels'            => $labels,
			'query_var'         => true,
			'show_admin_column' => true
		];

		register_taxonomy(
			'category_youtubeChanel',
			'youtube_video',
			$options
		);
	}
}

add_action( 'init', [ 'WPYS_Taxonomy', 'init' ] );
