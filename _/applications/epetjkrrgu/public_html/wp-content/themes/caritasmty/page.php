<?php get_header(); ?>
<div id="content">
	<div class="container">
		
    	<?php if(!is_home() && !is_front_page()) { ?>
		
		<div class="row page-header pb-3 pt-3 mb-1">
   			
			<div class="col-12 align-items-center breadcrumbs pt-2 pb-2">
    		    	<?php if ( function_exists('yoast_breadcrumb') ) {
						yoast_breadcrumb('
						<div id="breadcrumbs">','</div>
						');
						} ?>
			</div>
			<div class="col-sm-12">
				<h1 class="title mb-4"><?php echo get_the_title(); ?></h1>
				<hr>
			</div>
			
        </div>
        	
												  
		<?php }?>
       		
        <div class="page-content">
        
    		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php the_content(); ?>
			<?php //endif; ?>
			<?php endwhile; else: ?>
			<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
			<?php endif; ?>
			
		</div>
	</div>
	<?php if(!is_home() && !is_front_page()) { ?>
			<div class="bg-lightgray">
				<div class="container">
					<div class="col-12 text-center share mt-4 pt-4 pb-4">
						<h5 class="text-blue">Ayúdanos compartiendo esta información en redes sociales</h5>
						<?php $url = get_the_permalink();
					$title = get_the_title();
					echo do_shortcode('[easy-social-share buttons="facebook,twitter,pinterest,whatsapp" counters=0 style="icon" template="18" point_type="simple" url="'.$url.'" text="'.$title.'"]'); ?> 
					</div>
				</div>
			</div>
	<?php }?>
</div>
<?php get_footer(); ?>