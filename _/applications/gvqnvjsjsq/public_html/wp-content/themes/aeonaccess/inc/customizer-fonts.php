<?php
/**
 * File aeonaccess.
 *
 * @package   AeonAccess
 * @author    AeonWP <info@aeonwp.com>
 * @copyright Copyright (c) 2020, AeonWP
 * @link      https://aeonwp.com/aeonaccess
 * @license   http://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! function_exists( 'aeonaccess_font_customize_register' ) ) {
	/**
	 * Add fotn settings and controls for the Theme Customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	function aeonaccess_font_customize_register( $wp_customize ) {

		$wp_customize->add_setting(
			'aeonaccess_title_font',
			array(
				'default'           => 'Open Sans',
				'sanitize_callback' => 'aeonaccess_sanitize_select',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'aeonaccess_title_font',
				array(
					'label'    => __( 'Choose a font for the Site title and Tagline', 'aeonaccess' ),
					'section'  => 'aeonaccess_typography_section',
					'type'     => 'select',
					'priority' => 1,
					'choices'  => array(
						'Noto Serif'         => __( 'Noto Serif', 'aeonaccess' ),
						'Alegreya'           => __( 'Alegreya', 'aeonaccess' ),
						'Alegreya Sans SC'   => __( 'Alegreya Sans SC', 'aeonaccess' ),
						'Arimo'              => __( 'Arimo', 'aeonaccess' ),
						'Bree Serif'         => __( 'Bree Serif', 'aeonaccess' ),
						'Cherry Swash'       => __( 'Cherry Swash', 'aeonaccess' ),
						'Cinzel'             => __( 'Cinzel', 'aeonaccess' ),
						'Exo 2'              => __( 'Exo 2', 'aeonaccess' ),
						'Fondamento'         => __( 'Fondamento', 'aeonaccess' ),
						'Gentium Book Basic' => __( 'Gentium Book Basic', 'aeonaccess' ),
						'Grand Hotel'        => __( 'Grand Hotel', 'aeonaccess' ),
						'Hind'               => __( 'Hind', 'aeonaccess' ),
						'Josefin Sans'       => __( 'Josefin Sans', 'aeonaccess' ),
						'Karla'              => __( 'Karla', 'aeonaccess' ),
						'La Belle Aurore'    => __( 'La Belle Aurore', 'aeonaccess' ),
						'Lato'               => __( 'Lato', 'aeonaccess' ),
						'Libre Baskerville'  => __( 'Libre Baskerville', 'aeonaccess' ),
						'Lobster Two'        => __( 'Lobster Two', 'aeonaccess' ),
						'Lora'               => __( 'Lora', 'aeonaccess' ),
						'Merriweather'       => __( 'Merriweather', 'aeonaccess' ),
						'Montserrat'         => __( 'Montserrat', 'aeonaccess' ),
						'Muli'               => __( 'Muli', 'aeonaccess' ),
						'Noticia Text'       => __( 'Noticia Text', 'aeonaccess' ),
						'Noto Sans'          => __( 'Noto Sans', 'aeonaccess' ),
						'Open Sans'          => __( 'Open Sans', 'aeonaccess' ),
						'Oswald'             => __( 'Oswald', 'aeonaccess' ),
						'Pacifico'           => __( 'Pacifico', 'aeonaccess' ),
						'Playfair Display'   => __( 'Playfair Display', 'aeonaccess' ),
						'Quando'             => __( 'Quando', 'aeonaccess' ),
						'Raleway'            => __( 'Raleway', 'aeonaccess' ),
						'Roboto Slab'        => __( 'Roboto Slab', 'aeonaccess' ),
						'Sorts Mill Goudy'   => __( 'Sorts Mill Goudy', 'aeonaccess' ),
						'Tangerine'          => __( 'Tangerine', 'aeonaccess' ),
						'Ubuntu'             => __( 'Ubuntu', 'aeonaccess' ),
						'Vollkorn'           => __( 'Vollkorn', 'aeonaccess' ),
					),
				)
			)
		);

		$wp_customize->add_setting(
			'aeonaccess_body_font',
			array(
				'default'           => 'Open Sans',
				'sanitize_callback' => 'aeonaccess_sanitize_select',

			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'aeonaccess_body_font',
				array(
					'label'    => __( 'Choose a font for the body text', 'aeonaccess' ),
					'section'  => 'aeonaccess_typography_section',
					'type'     => 'select',
					'priority' => 2,
					'choices'  => array(
						'Noto Serif'         => __( 'Noto Serif', 'aeonaccess' ),
						'Alegreya'           => __( 'Alegreya', 'aeonaccess' ),
						'Alegreya Sans SC'   => __( 'Alegreya Sans SC', 'aeonaccess' ),
						'Arimo'              => __( 'Arimo', 'aeonaccess' ),
						'Exo 2'              => __( 'Exo 2', 'aeonaccess' ),
						'Gentium Book Basic' => __( 'Gentium Book Basic', 'aeonaccess' ),
						'Hind'               => __( 'Hind', 'aeonaccess' ),
						'Josefin Sans'       => __( 'Josefin Sans', 'aeonaccess' ),
						'Karla'              => __( 'Karla', 'aeonaccess' ),
						'Lato'               => __( 'Lato', 'aeonaccess' ),
						'Libre Baskerville'  => __( 'Libre Baskerville', 'aeonaccess' ),
						'Lora'               => __( 'Lora', 'aeonaccess' ),
						'Merriweather'       => __( 'Merriweather', 'aeonaccess' ),
						'Montserrat'         => __( 'Montserrat', 'aeonaccess' ),
						'Muli'               => __( 'Muli', 'aeonaccess' ),
						'Noticia Text'       => __( 'Noticia Text', 'aeonaccess' ),
						'Noto Sans'          => __( 'Noto Sans', 'aeonaccess' ),
						'Old Standard TT'    => __( 'Old Standard TT', 'aeonaccess' ),
						'Open Sans'          => __( 'Open Sans', 'aeonaccess' ),
						'Oswald'             => __( 'Oswald', 'aeonaccess' ),
						'Raleway'            => __( 'Raleway', 'aeonaccess' ),
						'Roboto Slab'        => __( 'Roboto Slab', 'aeonaccess' ),
						'Ubuntu'             => __( 'Ubuntu', 'aeonaccess' ),
						'Vollkorn'           => __( 'Vollkorn', 'aeonaccess' ),
					),
				)
			)
		);
	}
}
add_action( 'customize_register', 'aeonaccess_font_customize_register' );

/**
 * Enqueue the list of fonts.
 */
function aeonaccess_customizer_fonts() {
	wp_enqueue_style( 'aeonaccess_customizer_fonts', 'https://fonts.googleapis.com/css?family=Alegreya:400,700|Alegreya+Sans+SC:400,700|Arimo:400,700|Bree+Serif|Cherry+Swash:400,700|Cinzel:400,700|Exo+2:400,700|Fondamento|Gentium+Book+Basic:400,700|Grand+Hotel|Hind:400,700|Josefin+Sans:400,700|Karla:400,700|La+Belle+Aurore|Lato:400,700|Libre+Baskerville:400,700|Lobster+Two:400,700|Lora:400,700|Merriweather:400,700|Montserrat:400,700|Muli:400,700|Noticia+Text:400,700|Noto+Sans:400,700|Noto+Serif:400,700|Old+Standard+TT:400,700|Open+Sans:400,700|Oswald:400,700|Pacifico|Playfair+Display:400,700|Quando|Raleway:400,700|Roboto+Slab:400,700|Sorts+Mill+Goudy|Tangerine:400,700|Ubuntu:400,700|Vollkorn:400,700', array(), null );
}
add_action( 'customize_controls_print_styles', 'aeonaccess_customizer_fonts' );
add_action( 'customize_preview_init', 'aeonaccess_customizer_fonts' );

add_action(
	'customize_controls_print_styles',
	function() {
		?>
		<style>
		<?php
		$arr = array( 'Alegreya', 'Alegreya Sans SC', 'Arimo', 'Bree Serif', 'Cherry Swash', 'Cinzel', 'Exo 2', 'Fondamento', 'Gentium Book Basic', 'Grand Hotel', 'Hind', 'Josefin Sans', 'Karla', 'La Belle Aurore', 'Lato', 'Libre Baskerville', 'Lora', 'Lobster Two', 'Merriweather', 'Montserrat', 'Muli', 'Noticia Text', 'Noto Sans', 'Noto Serif', 'Old Standard TT', 'Open Sans', 'Oswald', 'Pacifico', 'Playfair Display', 'Quando', 'Raleway', 'Roboto Slab', 'Sorts Mill Goudy', 'Tangerine', 'Ubuntu', 'Vollkorn' );

		foreach ( $arr as $font ) {
			echo '.customize-control select option[value*="' . $font . '"] {font-family: ' . $font . '; font-size: 22px;}';
		}
		?>
		</style>
		<?php
	}
);
