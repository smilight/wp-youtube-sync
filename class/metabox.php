<?php

abstract class WPYS_Meta_Box {
	public static function add() {
		$screens = [ 'post', 'youtube_video' ];
		foreach ( $screens as $screen ) {
			add_meta_box(
				'youtubeVideoId',          // Unique ID
				'Youtube Video Id', // Box title
				[ self::class, 'html' ],   // Content callback, must be of type callable
				$screen                  // Post type
			);
		}
	}

	public static function save( $post_id ) {
		if ( array_key_exists( 'youtubeVideoId', $_POST ) ) {
			update_post_meta(
				$post_id,
				'_youtubeVideoId',
				$_POST['youtubeVideoId']
			);
		}
	}

	public static function html( $post ) {
		$value = get_post_meta( $post->ID, '_youtubeVideoId', true );
		?>
        <label for="youtubeVideoId">Description for this field</label>
        <select name="youtubeVideoId" id="youtubeVideoId" class="postbox">
            <option value="">Select something...</option>
            <option value="something" <?php selected( $value, 'something' ); ?>>Something</option>
            <option value="else" <?php selected( $value, 'else' ); ?>>Else</option>
        </select>
		<?php
	}
}

add_action( 'add_meta_boxes', [ 'WPYS_Meta_Box', 'add' ] );
add_action( 'save_post', [ 'WPYS_Meta_Box', 'save' ] );