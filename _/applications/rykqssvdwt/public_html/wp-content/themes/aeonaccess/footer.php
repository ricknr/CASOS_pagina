<?php
/**
 * File aeonaccess.
 *
 * @package   AeonAccess
 * @author    AeonWP <info@aeonwp.com>
 * @copyright Copyright (c) 2020, AeonWP
 * @link      https://aeonwp.com/aeonaccess
 * @license   http://www.gnu.org/licenses/gpl-2.0.html
 *
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */

?>
</div><!-- #row-wrap -->
</div><!-- #content -->

<div class="site-footer">
	<?php
	if ( has_nav_menu( 'social' ) ) {
		?>
			<nav class="social-icons-footer footer-social-menu-navigation" aria-label="<?php esc_attr_e( 'Social', 'aeonaccess' ); ?>" role="navigation">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'social',
						'menu_class'     => 'aeonaccess-menu-social',
						'depth'          => 1,
						'link_before'    => '<span class="screen-reader-text">',
						'link_after'     => '</span>' . aeonaccess_get_svg( array( 'icon' => 'chain' ) ),
						'container'      => false,
					)
				);
				?>
			</nav>
		<?php
	}
	?>
	<footer id="colophon" role="contentinfo">
		<div class="copyright">
			<?php echo wp_kses_post( get_theme_mod( 'aeonaccess-copyright-text', __( 'All Rights Reserved', 'aeonaccess' ) ) ); ?>
		</div>

		<div class="site-info">
			<div class="wp-credits">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'aeonaccess' ) ); ?>">
			<?php
			/* translators: %s: CMS name, i.e. WordPress. */
				printf( esc_html__( 'Proudly powered by %s', 'aeonaccess' ), 'WordPress' );
			?>
			</a>
			</div>
			<div class="author-credits">
			<?php
			/* translators: 1: Theme name, 2: Theme author. */
			printf( esc_html__( 'Theme: %1$s by %2$s', 'aeonaccess' ), 'AeonAccess', '<a href="https://aeonwp.com/">AeonWP</a>' );
			?>
			</div>
		</div><!-- .site-info -->
		<?php
		/**
		 * Go to Top Option.
		 */
		if ( get_theme_mod( 'aeonaccess-go-to-top', 1 ) == 1 ) {
			 do_action( 'aeonaccess_go_to_top_hook' );
		}
		?>
	</footer><!-- #colophon -->
</div>
<?php wp_footer(); ?>
</body>
</html>
