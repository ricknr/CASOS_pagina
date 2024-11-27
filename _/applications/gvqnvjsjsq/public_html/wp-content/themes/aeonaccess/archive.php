<?php
/**
 * File aeonaccess.
 *
 * @package  AeonAccess
 * @author    AeonWP <info@aeonwp.com>
 * @copyright Copyright (c) 2020, AeonWP
 * @link      https://aeonwp.com/aeonaccess
 * @license   http://www.gnu.org/licenses/gpl-2.0.html
 *
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

get_header();

/** Left sidebar */
get_sidebar( 'left' );

?>
	<main id="primary" role="main">
		<?php
		if ( have_posts() ) {
			?>
			<header class="page-header">
				<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) {
				the_post();
				/**
				 * Include the Post-Type-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_type() );
			}

			/**
			 * Aeonaccess_post_navigation hook.
			 *
			 * @since AeonAccess 1.0.0
			 *
			 * @hooked aeonaccess_posts_navigation -  10
			 */
			do_action( 'aeonaccess_action_navigation' );
		} else {
			get_template_part( 'template-parts/content', 'none' );
		}
		?>
	</main><!-- #primary -->
<?php
get_sidebar();

get_footer();
