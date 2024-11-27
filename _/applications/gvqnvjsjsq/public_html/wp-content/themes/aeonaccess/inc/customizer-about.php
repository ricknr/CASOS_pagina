<?php
/**
 * About section customizer options.
 *
 * @package  AeonAccess
 * @author    AeonWP <info@aeonwp.com>
 * @copyright Copyright (c) 2020, AeonWP
 * @link      https://aeonwp.com/aeonaccess
 * @license   http://www.gnu.org/licenses/gpl-2.0.html
 */

$wp_customize->add_section(
	'aeonaccess_about',
	array(
		'title' => __( 'About Section', 'aeonaccess' ),
		'panel' => 'aeonaccess_panel',
	)
);

$wp_customize->selective_refresh->add_partial(
	'aeonaccess-enable-about',
	array(
		'selector'        => '.about-me',
		'render_callback' => 'aeonaccess_about_user',
	)
);

$wp_customize->add_setting(
	'aeonaccess-enable-about',
	array(
		'sanitize_callback' => 'aeonaccess_sanitize_checkbox',
	)
);

$wp_customize->add_control(
	'aeonaccess-enable-about',
	array(
		'type'        => 'checkbox',
		'label'       => __( 'Check this box to enable the About section.', 'aeonaccess' ),
		'description' => __( 'This section is displayed at the top of the sidebar on the homepage. It shows the users gravatar and Biographical Info. The content is generated from the users settings.', 'aeonaccess' ),
		'section'     => 'aeonaccess_about',
	)
);

// Create a list of users.
$users  = get_users();
$output = array();
foreach ( (array) $users as $user ) {
	$output[ $user->ID ] = $user->display_name;
}

$wp_customize->add_setting(
	'aeonaccess_about_user',
	array(
		'sanitize_callback' => 'aeonaccess_sanitize_select',
	)
);

$wp_customize->add_control(
	'aeonaccess_about_user',
	array(
		'type'    => 'select',
		'label'   => __( 'Select which user to feature in the About section', 'aeonaccess' ),
		'section' => 'aeonaccess_about',
		'choices' => $output,
	)
);

$wp_customize->add_setting(
	'aeonaccess-about-gravatar',
	array(
		'sanitize_callback' => 'aeonaccess_sanitize_select',
		'default'           => 'circle',
	)
);

$wp_customize->add_control(
	'aeonaccess-about-gravatar',
	array(
		'type'    => 'select',
		'label'   => __( 'Select Gravatar style', 'aeonaccess' ),
		'section' => 'aeonaccess_about',
		'choices' => array(
			'circle' => __( 'Circle (Default)', 'aeonaccess' ),
			'square' => __( 'Square', 'aeonaccess' ),
			'hide'   => __( 'Hide Gravatar', 'aeonaccess' ),
		),
	)
);
