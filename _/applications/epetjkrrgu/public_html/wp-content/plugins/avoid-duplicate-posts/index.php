<?php
/*
Plugin Name: Avoid Duplicate Posts
Plugin URI: http://mythemeshop.com/
Description: Avoid all duplicate posts on homepage (applies to all posts, including widgets).
Author: MyThemeShop
Version: 1.0
Author URI: http://mythemeshop.com/
*/

add_action('parse_query', 'mts_exclude_duplicates');
function mts_exclude_duplicates( &$query ) {
	if (!is_home()) return;
	global $adp_posts;
	$disable_now = $query->get('adp_disable'); // use 'adp_disable' to prevent exclusion
	if (empty($query->post__not_in) && empty($disable_now)) {
		$query->set('post__not_in', $adp_posts);
	}
}

add_filter('the_posts', 'mts_log_posts', 10, 2);
$adp_posts = array();
function mts_log_posts( $posts, $query ) {
	if (!is_home()) return $posts;
	global $adp_posts;
	foreach ($posts as $i => $post) {
		$adp_posts[] = $post->ID;
	}
	return $posts;
}