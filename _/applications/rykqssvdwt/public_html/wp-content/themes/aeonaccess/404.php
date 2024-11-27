<?php
/**
 * File aeonaccess.
 *
 * @author    AeonWP <info@aeonwp.com>
 * @copyright Copyright (c) 2020, AeonWP
 * @link      https://aeonwp.com/aeonaccess
 * @license   http://www.gnu.org/licenses/gpl-2.0.html
 *
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package AeonAccess
 */

get_header();

/** Left sidebar */
get_sidebar( 'left' );

?>
<main id="primary" role="main">
	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e( '404: Not Found', 'aeonaccess' ); ?></h1>
	</header>
	<article <?php post_class( 'post-wrapper' ); ?>>
		<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'aeonaccess' ); ?></p>
		<?php get_search_form(); ?>
	</article>
</main><!-- #primary -->
<?php
get_sidebar();

get_footer();
