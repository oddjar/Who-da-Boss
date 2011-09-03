<?php

/*
Plugin Name: Who da Boss at #wcfay?
Plugin URI: http://oddjar.com/
Description: Provides a shortcode to pull a list of tweets from a given hashtag, and calculate who has tweeted the most within a given timeframe
Version: 0.1
Author: Johnathon Williams
Author URI: http://oddjar.com/ 
*/

/**
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * **********************************************************************
 */

function oj_insert_the_boss( $atts ) {
	$atts = extract(shortcode_atts(array(
		'hashtag'=>'#wcfay',
		'count'=>50
		), $atts));
	$search_string = "http://search.twitter.com/search.json?q=$hashtag&result_type=mixed&count=$count";
	$twitter_call = wp_remote_get( $search_string );
	
	$twitter_results = json_decode( $twitter_call['body'], true);
	$the_list = $twitter_results['results'];
	$name_list = array();
	foreach ($the_list as $tweet) {
		$name_list[] = $tweet['from_user'];
	}
	
	$the_count = array_count_values( $name_list );
	arsort($the_count);
	$trans = array_flip($the_count);
	$values = array_values($trans);
	$the_boss = $values[0];
	return "<h3>$the_boss is the boss!</h3>";
	
}
add_shortcode( 'who-da-boss','oj_insert_the_boss' );
?>
