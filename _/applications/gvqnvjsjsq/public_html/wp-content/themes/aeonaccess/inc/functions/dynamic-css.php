<?php
/**
 * File aeonaccess
 *
 * @package   AeonAccess
 * @author    AeonWP <info@aeonwp.com>
 * @copyright Copyright (c) 2020, AeonWP
 * @link      https://aeonwp.com/aeonaccess
 * @license   http://www.gnu.org/licenses/gpl-2.0.html
 * Dynamic css
 *
 * @since AeonAccess 1.0.0
 */

/**
 * This function is prefixed with the parent theme name in order to override it.
 */
function aeonaccess_dynamic_css() {

	/* Get and escape theme options */
	$aeonaccess_body_font           = esc_attr( get_theme_mod( 'aeonaccess_body_font', 'Open Sans' ) );
	$aeonaccess_title_font          = esc_attr( get_theme_mod( 'aeonaccess_title_font', 'Open Sans' ) );
	$aeonaccess_font_size           = absint( get_theme_mod( 'aeonaccess-font-size', 18 ) );
	$aeonaccess_font_line_height    = esc_attr( get_theme_mod( 'aeonaccess-font-line-height', 2 ) );
	$aeonaccess_font_letter_spacing = absint( get_theme_mod( 'aeonaccess-letter-spacing', 0 ) );
	$aeonaccess_about_gravatar      = esc_attr( get_theme_mod( 'aeonaccess-about-gravatar', 'circle' ) );
	$aeonaccess_button_color        = esc_attr( get_theme_mod( 'aeonaccess-button-color', '#000' ) );
	$custom_css                   = '';

	/* Typography Section */

	if ( ! empty( $aeonaccess_body_font ) ) {
		$custom_css .= "body { font-family: '{$aeonaccess_body_font}', BlinkMacSystemFont, -apple-system, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; }";
	}

	if ( ! empty( $aeonaccess_title_font ) ) {
		$custom_css .= ".site-title, .site-description { font-family: '{$aeonaccess_title_font}', BlinkMacSystemFont, -apple-system, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; }";
	}

	if ( ! empty( $aeonaccess_font_size ) ) {
		$custom_css .= "body, input { font-size: {$aeonaccess_font_size}px; }";
		if ( 14 == $aeonaccess_font_size ) {
			$custom_css .= '.widget_search .search-form .search-field { height: 46px; } ';
		}
	}

	if ( ! empty( $aeonaccess_font_line_height ) ) {
		$custom_css .= "body { line-height: {$aeonaccess_font_line_height}; }";
	}

	if ( ! empty( $aeonaccess_font_letter_spacing ) ) {
		$custom_css .= "body { letter-spacing: {$aeonaccess_font_letter_spacing}px; }";
	}

	/* About section */
	if ( 'square' === $aeonaccess_about_gravatar ) {
		$custom_css .= '.about-me-description a img { border-radius: 2px; }';
	} elseif ( 'hide' === $aeonaccess_about_gravatar ) {
		$custom_css .= '.about-me-description a { display: none; }';
	}

	if ( ! empty( $aeonaccess_button_color ) ) {
		$custom_css .= ' button, input[type="button"], input[type="reset"], input[type="submit"], #toTop {
			background: ' . $aeonaccess_button_color . ';
		}';
	}

	wp_add_inline_style( 'aeonaccess-style', $custom_css );
}

add_action( 'wp_enqueue_scripts', 'aeonaccess_dynamic_css', 99 );
