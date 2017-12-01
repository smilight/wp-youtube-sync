<?php

abstract class WPYS_Buttons {
	public static function addCategoryFetchBtn( $actions, $tag ) {
		if ( $tag->taxonomy == 'category_youtubeChanel' ):
			$playlistId = get_term_meta( $tag->term_id, WPYS_METABOX_KEY . '_category_playlistId', true );
			if ( $playlistId !== null && $playlistId !== '' ) {
				$actions['fetch-playlist-videos'] = '<a href="/wp-admin/edit-tags.php?taxonomy=category_youtubeChanel&post_type=youtube_video&do_u_action&playlistId=' . $playlistId . '"> Sync videos </a>';
			}
		endif;

		return $actions;

	}

	public static function addTableFetchBtn( $views ) {
		$views['kill-server'] = '<a href="/wp-admin/edit.php?post_type=youtube_video&do_u_action" id="update-from-provider" title="Fetch all videos from Channel" class="page-title-action" style="margin:5px">Fetch all videos from Channel (kill server)</a>';

		return $views;

	}
}

add_filter( 'tag_row_actions', [ 'WPYS_Buttons', 'addCategoryFetchBtn' ], 10, 2 );
add_filter( 'views_edit-youtube_video', [ 'WPYS_Buttons', 'addTableFetchBtn' ] );
