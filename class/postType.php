<?php

abstract class WPYS_Post_Type {
	public static function add() {

// Set UI labels for Custom Post Type
		$labels = array(
			'name'               => _x( 'Videos', 'Post Type General Name', 'wp-youtube-sync' ),
			'singular_name'      => _x( 'Video', 'Post Type Singular Name', 'wp-youtube-sync' ),
			'menu_name'          => __( 'Videos', 'wp-youtube-sync' ),
			'parent_item_colon'  => __( 'Parent Video', 'wp-youtube-sync' ),
			'all_items'          => __( 'All Videos', 'wp-youtube-sync' ),
			'view_item'          => __( 'View Video', 'wp-youtube-sync' ),
			'add_new_item'       => __( 'Add New Video', 'wp-youtube-sync' ),
			'add_new'            => __( 'Add New', 'wp-youtube-sync' ),
			'edit_item'          => __( 'Edit Video', 'wp-youtube-sync' ),
			'update_item'        => __( 'Update Video', 'wp-youtube-sync' ),
			'search_items'       => __( 'Search Video', 'wp-youtube-sync' ),
			'not_found'          => __( 'Not Found', 'wp-youtube-sync' ),
			'not_found_in_trash' => __( 'Not found in Trash', 'wp-youtube-sync' ),
		);

// Set other options for Custom Post Type

		$args = array(
			'label'               => __( 'movies', 'wp-youtube-sync' ),
			'description'         => __( 'Video news and reviews', 'wp-youtube-sync' ),
			'labels'              => $labels,
			// Features this CPT supports in Post Editor
			'supports'            => array(
				'title',
				'editor',
				'excerpt',
				'author',
				'thumbnail',
				'comments',
				'revisions',
				'custom-fields',
			),
			// You can associate this CPT with a taxonomy or custom taxonomy.
			'taxonomies'          => array( 'genres' ),
			/* A hierarchical CPT is like Pages and can have
			* Parent and child items. A non-hierarchical CPT
			* is like Posts.
			*/
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
		);

		// Registering your Custom Post Type
		register_post_type( 'youtube_video', $args );

	}
}

add_action( 'init', [ 'WPYS_Post_Type', 'add' ], 0 );
