<?php
/**
 * Custom Header for AeonAccess
 *
 * @package   AeonAccess
 * @author    AeonWP <info@aeonwp.com>
 * @copyright Copyright (c) 2020, AeonWP
 * @link      https://aeonwp.com/aeonaccess
 * @license   http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses aeonaccess_header_style()
 */
function aeonaccess_custom_header_setup() {
	add_theme_support(
		'custom-header',
		apply_filters(
			'aeonaccess_custom_header_args',
			array(
				'default-image'      => get_stylesheet_directory_uri() . '/images/man-black-and-white.jpg',
				'default-text-color' => '#fff',
				'uploads'            => true,
				'width'              => '2000',
				'flex-height'        => true,
				'flex-width'         => true,
				'video'              => false,
			)
		)
	);

	register_default_headers(
		array(
			'default-image' => array(
				'url'           => get_stylesheet_directory_uri() . '/images/man-black-and-white.jpg',
				'thumbnail_url' => get_stylesheet_directory_uri() . '/images/man-black-and-white.jpg',
				'description'   => __( 'Man', 'aeonaccess' ),
			),
			'default-image' => array(
				'url'           => get_stylesheet_directory_uri() . '/images/woman-black-and-white.jpg',
				'thumbnail_url' => get_stylesheet_directory_uri() . '/images/woman-black-and-white.jpg',
				'description'   => __( 'Woman', 'aeonaccess' ),
			),
		)
	);
}
add_action( 'after_setup_theme', 'aeonaccess_custom_header_setup' );

if ( ! function_exists( 'aeonaccess_header_style' ) ) {
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see aeonaccess_custom_header_setup().
	 */
	function aeonaccess_header_style() {
		$header_text_color = get_header_textcolor();

		/*
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
		 */
		if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
			return;
		}

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
		<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) {
			?>
			.site-title,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}
			<?php
			// If the user has set a custom color for the text use that.
		} else {
			?>
			.site-title a,
			.site-description {
				color: #<?php echo esc_attr( $header_text_color ); ?>;
			}
			<?php
		}
		?>
		</style>
		<?php
	}
}
