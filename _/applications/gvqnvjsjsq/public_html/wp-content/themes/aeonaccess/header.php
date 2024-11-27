<?php
/**
 * File aeonaccess
 *
 * @package   AeonAccess
 * @author    AeonWP <info@aeonwp.com>
 * @copyright Copyright (c) 2020, AeonWP
 * @link      https://aeonwp.com/aeonaccess
 * @license   http://www.gnu.org/licenses/gpl-2.0.html
 *
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
	<header id="masthead" class="site-header" role="banner" 
	<?php
	if ( has_header_image() && is_home() ) {
		echo 'style="
		background: url(' . esc_url( get_header_image() ) . ') no-repeat top center; 
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;"';
	}
	?>
	>
	<?php
	if ( has_nav_menu( 'primary' ) ) {
		?>
		<!-- Main Menu -->
		<nav id="site-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Header', 'aeonaccess' ); ?>" class="main-navigation" itemscope="itemscope" itemtype="https://schema.org/SiteNavigationElement">
		<button id="mobile-menu-toggle" aria-controls="main-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'aeonaccess' ); ?></button>
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'menu_id'        => 'main-menu',
				'depth'          => 2,
				'container'      => 'ul',
			)
		);
		?>
		</nav><!-- #site-navigation -->
		<?php
	}
	?>

		<!-- Start Header Branding -->
		<div class="site-branding">
			<?php
			the_custom_logo();

			if ( display_header_text() ) {
				if ( is_front_page() && is_home() ) {
					?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
					<?php
				} else {
					?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></p>
					<?php
				}

				$aeonaccess_description = get_bloginfo( 'description', 'display' );
				if ( $aeonaccess_description || is_customize_preview() ) {
					?>
					<p class="site-description"><?php echo $aeonaccess_description; /* WPCS: xss ok. */ ?></p>
					<?php
				}
			}
			?>
		</div>
		<!-- End Header Branding -->
</header><!-- #masthead -->
<?php
do_action( 'aeonaccess_breadcrumb_hook' );
?>

<div id="content" class="blog-wrapper">
	<div class="row-wrap">
