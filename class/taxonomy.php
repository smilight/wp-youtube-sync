<?php


abstract class WPYS_Taxonomy{
	public static function add(){

		$labels = array(
			'name'                           => __('Playlists'),
			'singular_name'                  => __('Playlist'),
			'search_items'                   => __('Search Playlist'),
			'all_items'                      => __('All Playlists'),
			'edit_item'                      => __('Edit Playlist'),
			'update_item'                    => __('Update Playlist'),
			'add_new_item'                   => __('Add New Playlist'),
			'new_item_name'                  => __('New Playlist Name'),
			'menu_name'                      => __('Playlists'),
			'view_item'                      => __('View Playlist'),
			'popular_items'                  => __('Popular Playlists'),
			'separate_items_with_commas'     => __('Separate playlists with commas'),
			'add_or_remove_items'            => __('Add or remove athletes'),
			'choose_from_most_used'          => 'Choose from the most used athletes',
			'not_found'                      => 'No athletes found'
		);

		$options = [
			'hierarchical' => true,
			'labels' => $labels,
			'query_var' => true,
			'show_admin_column' => true
		];

		register_taxonomy(
			'category_youtubeChanel',
			'youtube_video',
			$options
		);
	}
}

add_action( 'init', ['WPYS_Taxonomy','add'] );
