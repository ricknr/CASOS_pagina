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
				<?php the_archive_title( '<h1 class="page-title mb-4">', '</h1>' ); ?>
			</div>
        </div>
        
		<div class="row">
			<div class="blog-contents col-sm-12 col-md-8 col-lg-9 margin-fix-top">
				
				<?php if ( have_posts() ) {

					while ( have_posts() ) { the_post();	
								get_template_part( 'parts/content-item' );						
					}
					the_posts_pagination(array(
						'mid_size' => 2,
						'prev_text' => __('«'),
						'screen_reader_text' => ' ',
						'next_text' => __('»'),
					));

				} else {

					echo '<div class="alert alert-danger">No se encontraron contenidos disponibles para esta búsqueda.</div>';
				} ?>
					
				<?php 
				
				?>
			</div>
		
        
        <div class="sidebar col-sm-12 col-md-4 col-lg-3 margin-fix-top">
			<div class="widget mb-4 ">
				<h4 class="heading title">Buscar</h4>
				<?php get_template_part('searchform'); ?>
			</div>
        	<?php if(!dynamic_sidebar( 'contents-sidebar' )) { 
				}?>
        </div>
		
		</div>
		
    </div>
</div>
<?php get_footer(); ?>