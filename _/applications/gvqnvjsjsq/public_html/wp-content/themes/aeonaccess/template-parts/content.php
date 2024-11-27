<?php
/**
 * File aeonaccess
 *
 * @package   AeonAccess
 * @author    AeonWP <info@aeonwp.com>
 * @copyright Copyright (c) 2020, AeonWP
 * @link      https://aeonwp.com/aeonaccess
 * @license   http://www.gnu.org/licenses/gpl-2.0.html
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

$read_more           = get_theme_mod( 'aeonaccess-read-more-text', __( 'Continue Reading', 'aeonaccess' ) );
$blog_meta           = get_theme_mod( 'aeonaccess-blog-meta', 1 );
$blog_featured_image = get_theme_mod( 'aeonaccess-blog-image', 1 );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-wrapper' ); ?>>
	<header class="entry-header">
			<?php
			if ( is_singular() ) {
				the_title( '<h1 class="entry-title">', '</h1>' );
			} else {
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			}

			if ( $blog_meta == 1 ) {
				?>
				<ul class="entry-meta clearfix">
					<li>
						<?php aeonaccess_posted_by(); ?>
					</li>
					<li>
						<?php aeonaccess_posted_on(); ?>
					</li>
					<li>
						<span>
							<?php
							$categories = get_the_category();
							if ( ! empty( $categories ) ) {
								echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . ' " rel="category tag">' . esc_html( $categories[0]->name ) . '</a>';
							}
							?>
						</span>
					</li>
				</ul>
			<?php } ?>
			</header><!-- .entry-header -->
		<?php
		if ( has_post_thumbnail() && $blog_featured_image == 1 ) {
			?>
			<div class="featured-wrapper">
				<div class="post-thumbnail">
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'small' ); ?></a>
				</div>
			</div>
			<?php
		}
		?>
		<div class="blog-content">
			<div class="entry-content">
				<?php the_excerpt(); ?>
			</div><!-- .entry-content -->
			<?php
			if ( ! empty( $read_more ) ) {
				?>
				<footer class="entry-footer">
				<a class="more-link" href="<?php the_permalink(); ?>"><?php echo esc_html( $read_more ); ?> <span class="screen-reader-text"><?php the_title(); ?></span></a>
				</footer><!-- .entry-footer -->
				<?php
			}
			?>
		</div>
</article><!-- #post-<?php the_ID(); ?> -->
