<?php

require_once( __DIR__ . '/vendor/autoload.php' );

require_once(__DIR__ .'/class/postType.php');
require_once(__DIR__ .'/class/metabox.php');

use Madcoda\Youtube\Youtube;

/**
 * @package WP Youtube sync
 * @version 1.0
 */
/*
Plugin Name: WP Youtube sync
Plugin URI: https://paaw.pro/plugins/wp-youtube-sync
Description: TODO: description
Author: Oleksii Pershin
Version: 1.0
Author URI: https://paaw.pro/
*/

/*
* Creating a function to create our CPT
*/

function hello_dolly() {

	$API_key   = 'AIzaSyDrxR5gZ7YC7_zB0rQsjcnkCEnw5AAR0TA';
	$channelID = 'UC5V8mErVFOpcQXEb3y9IMZw';
	$maxResults = 10;

	$youtube = new Youtube(array('key' => $API_key));

	$channel = $youtube->getChannelByName('RadaTVchannel');
	$results = $youtube->getPlaylistsByChannelId($channel->id);

	var_dump($results);

//	$videoList = json_decode( file_get_contents( 'https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&channelId=' . $channelID . '&maxResults=' . $maxResults . '&key=' . $API_key . '' ) );
//	var_dump($videoList);
//	foreach ( $videoList->items as $item ) {
//		Embed video
//		if ( isset( $item->id->videoId ) ) {
//			echo '<div class="youtube-video">
//                <iframe width="280" height="150" src="https://www.youtube.com/embed/' . $item->id->videoId . '" frameborder="0" allowfullscreen></iframe>
//                <h2>' . $item->snippet->title . '</h2>
//            </div>';
//		}
//	}
}

add_action( 'admin_notices', 'hello_dolly' );

?>
