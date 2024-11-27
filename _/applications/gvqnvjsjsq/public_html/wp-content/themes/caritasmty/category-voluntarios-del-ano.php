<?php get_header(); ?>
<div id="content">
	<div class="container">
   		<div class="row breadcrumbs align-items-center">
   			<div class="col-12">
    		    	<?php if ( function_exists('yoast_breadcrumb') ) {
						yoast_breadcrumb('
						<div id="breadcrumbs" class="mt-3 mb-3">','</div>
						');
						} ?>
			</div>
		</div>
    	<div class="row page-header">
   			<div class="col-sm-12">
				<?php if (is_category()) { 
							the_archive_title( '<h1 class="page-title mb-3">', '</h1>' );
						} else if (is_post_type_archive('post') || is_home() ) {
							echo '<h1 class="page-title mb-3">Blog</h1>';
						} ?>
			</div>
        </div>
        
		<div class="row">
			<div class="blog-contents col-sm-12 col-md-8 col-lg-9 margin-fix-top">
				<?php if ( have_posts() ) {

					while ( have_posts() ) { the_post(); ?>	
						<div class="item row mb-4">
							<div class="image col-sm-4 mb-2">
								<a href="<?php echo get_permalink($post->ID); ?>">
									<?php if ( has_post_thumbnail() ) {	
												echo get_the_post_thumbnail($post->ID, 'medium_cropped', array('class' => 'img-fluid'));
									} else {
										echo '<img src="'.get_template_directory_uri().'/images/placeholder4x3.png" class="img-fluid">';
									};?>
								</a>
							</div>
							<div class="content col-sm-8">
								<h3 class="title title_voluntarios"><a href="<?php echo get_permalink($post->ID); ?>"><?php echo get_the_title(); ?></a></h3>
								<a href="<?php echo get_permalink($post->ID); ?>" class="readon">Ver más</a>
								 </div>
							</div>		
											
					<?php }

					the_posts_pagination(array(
						'mid_size' => 2,
						'prev_text' => __('«'),
						'screen_reader_text' => ' ',
						'next_text' => __('»'),
					));


				} else {

					echo '<div class="alert">No se encontraron contenidos disponibles para esta búsqueda.</div>';
				}
				?>
			</div>
		
        
        <div class="sidebar col-sm-12 col-md-4 col-lg-3 margin-fix-top">
        	<?php if(!dynamic_sidebar( 'contents-sidebar' )) { 
				}?>
        </div>
		
		</div>
		
    </div>
</div>
<?php get_footer(); ?>