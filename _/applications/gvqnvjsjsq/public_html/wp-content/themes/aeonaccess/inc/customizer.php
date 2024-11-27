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

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function aeonaccess_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'aeonaccess_customize_partial_blogname',
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'aeonaccess_customize_partial_blogdescription',
			)
		);
	}

	$wp_customize->add_panel(
		'aeonaccess_panel',
		array(
			'priority'   => 10,
			'capability' => 'edit_theme_options',
			'title'      => __( 'AeonAccess Theme Options', 'aeonaccess' ),
		)
	);

	/* Primary Color Section Inside Core Color Option */

	$wp_customize->add_setting(
		'aeonaccess-button-color',
		array(
			'default'           => '#000',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'aeonaccess-button-color',
			array(
				'label'       => esc_html__( 'Button Color', 'aeonaccess' ),
				'description' => esc_html__( 'Applied to buttons.', 'aeonaccess' ),
				'section'     => 'colors',
			)
		)
	);

	/*Blog Page Options*/
	$wp_customize->add_section(
		'aeonaccess_blog_section',
		array(
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'title'          => __( 'Blog Section Options', 'aeonaccess' ),
			'panel'          => 'aeonaccess_panel',
		)
	);

	/*Sidebar Options*/
	$wp_customize->add_setting(
		'aeonaccess-sidebar-options',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => 'right-sidebar',
			'sanitize_callback' => 'aeonaccess_sanitize_select',
		)
	);

	$wp_customize->add_control(
		'aeonaccess-sidebar-options',
		array(
			'label'       => __( 'Sidebar Options', 'aeonaccess' ),
			'description' => __( 'You can manage the individual sidebar for single post by using the post templates.', 'aeonaccess' ),
			'section'     => 'aeonaccess_blog_section',
			'type'        => 'select',
			'choices'     => array(
				'right-sidebar' => __( 'Right sidebar', 'aeonaccess' ),
				'left-sidebar'  => __( 'Left sidebar', 'aeonaccess' ),
				'no-sidebar'    => __( 'No sidebar', 'aeonaccess' ),
				'middle-column' => __( 'No sidebar, content in the middle column', 'aeonaccess' ),
			),
		)
	);

	/*Enable Sticky Sidebar*/
	$wp_customize->add_setting(
		'aeonaccess-sticky-sidebar',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => 1,
			'sanitize_callback' => 'aeonaccess_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'aeonaccess-sticky-sidebar',
		array(
			'label'       => __( 'Sticky Sidebar', 'aeonaccess' ),
			'description' => __( 'Enable Sticky Sidebar', 'aeonaccess' ),
			'section'     => 'aeonaccess_blog_section',
			'type'        => 'checkbox',
		)
	);

	/*Read More Text*/
	$wp_customize->add_setting(
		'aeonaccess-read-more-text',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => esc_html__( 'Continue Reading', 'aeonaccess' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'aeonaccess-read-more-text',
		array(
			'label'       => __( 'Continue Reading Text', 'aeonaccess' ),
			'description' => __( 'Enter your custom continue reading text. The title will be included after this text.', 'aeonaccess' ),
			'section'     => 'aeonaccess_blog_section',
			'type'        => 'text',
		)
	);

	/* Meta Information */
	$wp_customize->add_setting(
		'aeonaccess-blog-meta',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => 1,
			'sanitize_callback' => 'aeonaccess_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'aeonaccess-blog-meta',
		array(
			'label'       => __( 'Meta Options', 'aeonaccess' ),
			'description' => __( 'Check to show the date, category, tags etc on blog page.', 'aeonaccess' ),
			'section'     => 'aeonaccess_blog_section',
			'type'        => 'checkbox',
		)
	);

	/*Featured Image*/
	$wp_customize->add_setting(
		'aeonaccess-blog-image',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => 1,
			'sanitize_callback' => 'aeonaccess_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'aeonaccess-blog-image',
		array(
			'label'       => __( 'Featured Image', 'aeonaccess' ),
			'description' => __( 'Check to show the featured Image.', 'aeonaccess' ),
			'section'     => 'aeonaccess_blog_section',
			'type'        => 'checkbox',
		)
	);

	/*Excerpt Length*/
	$wp_customize->add_setting(
		'aeonaccess-blog-excerpt',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => 45,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'aeonaccess-blog-excerpt',
		array(
			'label'       => __( 'Excerpt Length', 'aeonaccess' ),
			'description' => __( 'Enter the length of the excerpt.', 'aeonaccess' ),
			'section'     => 'aeonaccess_blog_section',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => -1,
				'step' => 1,
			),
		)
	);

	/*Typography Options */
	$wp_customize->add_section(
		'aeonaccess_typography_section',
		array(
			'title' => __( 'Typography Options', 'aeonaccess' ),
			'panel' => 'aeonaccess_panel',
		)
	);

	/*Font Size*/
	$wp_customize->add_setting(
		'aeonaccess-font-size',
		array(
			'default'           => 18,
			'transport'         => 'refresh',
			'sanitize_callback' => 'aeonaccess_sanitize_number',
		)
	);

	$wp_customize->add_control(
		'aeonaccess-font-size',
		array(
			'label'       => __( 'Font Size', 'aeonaccess' ),
			'section'     => 'aeonaccess_typography_section',
			'type'        => 'number',
			'description' => __( 'Increase/Decrease the base font size.', 'aeonaccess' ),
			'input_attrs' => array(
				'min'  => 14,
				'step' => 1,
			),
		)
	);

	/*Line Height */
	$wp_customize->add_setting(
		'aeonaccess-font-line-height',
		array(
			'default'           => 2,
			'transport'         => 'refresh',
			'sanitize_callback' => 'aeonaccess_sanitize_number',
		)
	);

	$wp_customize->add_control(
		'aeonaccess-font-line-height',
		array(
			'label'       => __( 'Line Height', 'aeonaccess' ),
			'section'     => 'aeonaccess_typography_section',
			'type'        => 'number',
			'description' => __( 'Increase/Decrease Line Height.', 'aeonaccess' ),
			'input_attrs' => array(
				'min'  => '0',
				'step' => '0.1',
			),
		)
	);

	/*Letter Spacing */
	$wp_customize->add_setting(
		'aeonaccess-letter-spacing',
		array(
			'default'           => 0,
			'transport'         => 'refresh',
			'sanitize_callback' => 'aeonaccess_sanitize_number',
		)
	);

	$wp_customize->add_control(
		'aeonaccess-letter-spacing',
		array(
			'label'       => __( 'Letter Spacing', 'aeonaccess' ),
			'section'     => 'aeonaccess_typography_section',
			'type'        => 'number',
			'description' => __( 'Increase/Decrease Letter Spacing.', 'aeonaccess' ),
			'input_attrs' => array(
				'min'  => '-20',
				'max'  => '4',
				'step' => '1',
			),
		)
	);

	/*Footer*/
	$wp_customize->add_section(
		'aeonaccess_footer_section',
		array(
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'title'          => __( 'Footer Options', 'aeonaccess' ),
			'panel'          => 'aeonaccess_panel',
		)
	);

	/*Copyright Text*/
	$wp_customize->add_setting(
		'aeonaccess-copyright-text',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => esc_html__( 'All Rights Reserved', 'aeonaccess' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'aeonaccess-copyright-text',
		array(
			'label'       => __( 'Copyright Text', 'aeonaccess' ),
			'description' => __( 'Enter your own copyright text.', 'aeonaccess' ),
			'section'     => 'aeonaccess_footer_section',
			'type'        => 'text',
		)
	);

	/*Go to Top*/
	$wp_customize->add_setting(
		'aeonaccess-go-to-top',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => 1,
			'sanitize_callback' => 'aeonaccess_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'aeonaccess-go-to-top',
		array(
			'label'       => __( 'Go To Top', 'aeonaccess' ),
			'description' => __( 'Enable/Disable go to top in the footer.', 'aeonaccess' ),
			'section'     => 'aeonaccess_footer_section',
			'type'        => 'checkbox',
		)
	);

	/*Extras*/
	$wp_customize->add_section(
		'aeonaccess_extra_section',
		array(
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'title'          => __( 'Extra Options', 'aeonaccess' ),
			'panel'          => 'aeonaccess_panel',
		)
	);

	/*Breadcrumb Options*/
	$wp_customize->add_setting(
		'aeonaccess-breadcrumb-option',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => 1,
			'sanitize_callback' => 'aeonaccess_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'aeonaccess-breadcrumb-option',
		array(
			'label'       => __( 'Breadcrumb Option', 'aeonaccess' ),
			'description' => __( 'Show/Hide breadcrumbs.', 'aeonaccess' ),
			'section'     => 'aeonaccess_extra_section',
			'type'        => 'checkbox',
		)
	);

	/*Pagination Options*/
	$wp_customize->add_setting(
		'aeonaccess-pagination-type',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => 'numeric',
			'sanitize_callback' => 'aeonaccess_sanitize_select',
		)
	);

	$wp_customize->add_control(
		'aeonaccess-pagination-type',
		array(
			'choices'     => array(
				'default' => __( 'Next and Previous', 'aeonaccess' ),
				'numeric' => __( 'Numeric', 'aeonaccess' ),
			),
			'label'       => __( 'Pagination Option', 'aeonaccess' ),
			'description' => __( 'Select the pagination type.', 'aeonaccess' ),
			'section'     => 'aeonaccess_extra_section',
			'type'        => 'select',
		)
	);

	/*Related Post Options*/
	$wp_customize->add_setting(
		'aeonaccess-related-post',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => 1,
			'sanitize_callback' => 'aeonaccess_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'aeonaccess-related-post',
		array(
			'label'       => __( 'Related Posts', 'aeonaccess' ),
			'description' => __( 'Enable related posts below the post content.', 'aeonaccess' ),
			'section'     => 'aeonaccess_extra_section',
			'type'        => 'checkbox',
		)
	);

	require get_template_directory() . '/inc/customizer-about.php';
}
add_action( 'customize_register', 'aeonaccess_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function aeonaccess_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function aeonaccess_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function aeonaccess_customize_preview_js() {
	wp_enqueue_script( 'aeonaccess-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'aeonaccess_customize_preview_js' );
