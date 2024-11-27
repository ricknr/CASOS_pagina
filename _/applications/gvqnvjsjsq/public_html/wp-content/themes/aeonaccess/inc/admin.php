<?php
/**
 * Documentation for AeonAccess
 *
 * @package   AeonAccess
 * @author    AeonWP <info@aeonwp.com>
 * @copyright Copyright (c) 2020, AeonWP
 * @link      https://aeonwp.com/aeonaccess
 * @license   http://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Add the menu item under Appearance, themes.
 */
function aeonaccess_menu() {
	add_theme_page( __( 'About AeonAccess', 'aeonaccess' ), __( 'About AeonAccess', 'aeonaccess' ), 'edit_theme_options', 'aeonaccess-theme', 'aeonaccess_page' );
}
add_action( 'admin_menu', 'aeonaccess_menu' );

/**
 * Enqueue styles for the help page.
 */
function aeonaccess_admin_scripts( $hook ) {
	if ( 'appearance_page_aeonaccess-theme' !== $hook ) {
		return;
	}
	wp_enqueue_style( 'aeonaccess-admin-style', get_template_directory_uri() . '/css/admin.css', array(), '' );
}
add_action( 'admin_enqueue_scripts', 'aeonaccess_admin_scripts' );

/**
 * Add the theme page
 */
function aeonaccess_page() {
	?>
	<div class="wrap">
		<div class="welcome-panel aeon-panel">
			<div class="welcome-panel-content">
				<img class="aeonlogo" src="<?php echo esc_url( get_template_directory_uri() . '/images/aeonwp.png' ); ?>" alt="" height="130px">
				<div class="aeontitle"><h1><?php esc_html_e( 'AeonAccess', 'aeonaccess' ); ?></h1>
					<br>
					<b><?php esc_html_e( 'Thank you for chosing AeonAccess', 'aeonaccess' ); ?></b><br>
				</div>
			</div>
		</div>
		<div class="welcome-panel">
			<div class="welcome-panel-content">
				<h2><?php esc_html_e( 'Upgrade to Pro', 'aeonaccess' ); ?></h2><br>
				<a href="https://www.templatesell.com/item/aeonaccess-plus/"><?php esc_html_e( 'AeonAccess is available in a premium and free version.', 'aeonaccess' ); ?></a><br><br>
				<img src="<?php echo esc_url( get_template_directory_uri() . '/images/access.jpg' ); ?>" alt="" height="300px">
				<br><br>
			</div>
		</div>
		<div class="welcome-panel">
			<div class="welcome-panel-content">
				<h2><?php esc_html_e( 'Frequently asked questions', 'aeonaccess' ); ?></h2>
				<h3><?php esc_html_e( 'Where can I get support for the theme?', 'aeonaccess' ); ?></h3>
				<?php _e( 'You are welcome to post your questions in the <a href="https://wordpress.org/support/theme/aeonaccess/">support forum</a>.', 'aeonaccess' ); ?>
				<h3><?php esc_html_e( 'How do I use the About section?', 'aeonaccess' ); ?></h3>
				<?php _e( 'You need to have an active sidebar, and enable the option in the customzer.', 'aeonaccess' ); ?><br>
				<?php _e( 'To show your biography, you need to add the content in your WordPress user profile.', 'aeonaccess' ); ?><br>
				<h3><?php esc_html_e( 'Can you add more features?', 'aeonaccess' ); ?></h3>
				<?php esc_html_e( 'The Plus version of the theme has additional features.', 'aeonaccess' ); ?> <?php _e( 'You can learn more about the premium version of the theme here: <a href="https://www.templatesell.com/item/aeonaccess-plus/">AeonAccess Plus</a>.', 'aeonaccess' ); ?><br>
				<?php _e( 'We also offer a <a href="https://aeonwp.com/services/">customization service</a>. ', 'aeonaccess' ); ?><br>
				<h3><?php esc_html_e( 'Where can I download demo content?', 'aeonaccess' ); ?></h3>
				<?php _e( 'You can download the demo content on our <a href="https://aeonwp.com/aeonaccess/#Demo_content">website</a>.', 'aeonaccess' ); ?>
				<br>
				<br>
			</div>
		</div>
		<div class="welcome-panel">
			<div class="welcome-panel-content">
				<h2><?php esc_html_e( 'Have you built something awesome with AeonAccess?', 'aeonaccess' ); ?></h2>
				<br>
				<?php esc_html_e( 'We would love to see what you have created!', 'aeonaccess' ); ?>
				<?php esc_html_e( 'If you would like your website to be featured on our blog, please email us at aeonwpofficial@gmail.com', 'aeonaccess' ); ?>
				<br>
				<br>
			</div>
		</div>
		<div class="welcome-panel">
			<div class="welcome-panel-content">
				<h2><?php esc_html_e( 'If you like the theme, please leave a review', 'aeonaccess' ); ?></h2><br>
				<a href="https://wordpress.org/support/theme/aeonaccess/reviews/#new-post"><?php esc_html_e( 'Rate this theme', 'aeonaccess' ); ?></a>
				<br><br>
			</div>
		</div>
	</div>
	<?php
}
