<?php
/**
 * Left Sidebar
 *
 * @package  AeonAccess
 * @author    AeonWP <info@aeonwp.com>
 * @copyright Copyright (c) 2020, AeonWP
 * @link      https://aeonwp.com/aeonaccess
 * @license   http://www.gnu.org/licenses/gpl-2.0.html
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside role="complementary" class="secondary left-sidebar">
	<?php
	aeonaccess_about_user();
	dynamic_sidebar( 'sidebar-1' );
	?>
</aside><!-- #secondary -->
