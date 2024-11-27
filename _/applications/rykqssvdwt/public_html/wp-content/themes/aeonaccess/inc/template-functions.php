<?php
/**
 * File aeonaccess.
 *
 * @package   AeonAccess
 * @author    AeonWP <info@aeonwp.com>
 * @copyright Copyright (c) 2020, AeonWP
 * @link      https://aeonwp.com/aeonaccess
 * @license   http://www.gnu.org/licenses/gpl-2.0.html
 * Functions which enhance the theme by hooking into WordPress
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function aeonaccess_body_classes( $classes ) {
	global $post;
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';

	} else {
		$classes[] = esc_attr(get_theme_mod( 'aeonaccess_sidebar_options', 'right-sidebar' ));
	}
	return $classes;
}
add_filter( 'body_class', 'aeonaccess_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function aeonaccess_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'aeonaccess_pingback_header' );
