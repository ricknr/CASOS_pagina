<?php 
/*
Template Name: Voluntarios del año
Template Post Type: post
*/

get_header(); ?>
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
    	<div class="row page-header mb-4">
   			<div class="col-sm-12">
				<h1 class="title mb-4 title_voluntarios"><?php echo get_the_title(); ?></h1>
			</div>
        </div>
        
		<div class="row">
			<div class="blog-contents col-sm-12 col-md-8 col-lg-9 margin-fix-top">
				
				<?php the_content(); ?>
				
				<div class="past-volunteers">
					<h3 class="title text-center text-blue">Más Voluntarios del Año</h3>
					<?php echo do_shortcode('[latest_posts catid="14" items="8" view="carousel"]'); ?>
				</div>
				
				
				<div class="text-center share">
					<h4 class="text-blue">Ayúdanos compartiendo esta nota en redes sociales</h4>
					<?php $url = get_the_permalink();
				$title = get_the_title();
				echo do_shortcode('[easy-social-share buttons="facebook,twitter,whatsapp" counters=0 style="icon" template="18" point_type="simple" url="'.$url.'" text="'.$title.'"]'); ?> 
				</div>
				
			</div>
		
        
        <div class="sidebar col-sm-12 col-md-4 col-lg-3 margin-fix-top">
        	<?php if(!dynamic_sidebar( 'contents-sidebar' )) { 
				}?>
        </div>
		
		</div>
		
		<div class="row related-posts">
			<div class="col-12">
				<h3 class="title">Te podría interesar...</h3>
				<?php echo do_shortcode('[latest_posts catid="" items="8" view="carousel"]'); ?>
			</div>
		</div>
		
		
    </div>
	<div id="donaciones" class="bg-blue">
		<div class="container">
			<h2 class="title text-white pt-4 text-center">Como ayudar</h2>
		</div>
		<div class="bg-lightblue">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-12 col-sm-6 text-center pt-4 pb-4">
						<p>Un donativo mensual es una forma constante de lograr que miles de personas reciban alimento, consulta médica, medicamentos, albergue, educación, y muchos otros beneficios a los que no podemos ser indiferentes. </p>
					</div>
					<?php echo do_shortcode('[donaciones style="horizontal"]'); ?>
				</div>
			</div>
		</div>
		<div class="bg-lightgray pb-4">
			<div class="container">
				<div class="row">
					<div class="col-12"><h2 class="title mt-2 text-center">OTRAS FORMAS DE AYUDAR</h2></div>
					<div class="col-sm-4 donation-other text-center">
						<h4 class="title">Donación en especie</h4>
						<p class="text-center description">En Cáritas también recibimos tus donativos en especie que pueden ir desde alimentos, medicamentos, productos para el cuidado de la salud, por ejemplo: sillas de ruedas y muletas, así como también muebles, ropa y muchos artículos más en buen estado que pueden ser aprovechados para ayudar a nuestros hermanos más necesitados.</p>
						<p><a class="btn btn-secondary btn-center" href="#">Quiero ayudar</a></p>
					</div>
					<div class="col-sm-4 donation-other text-center">
						<h4 class="title">Voluntariado</h4>
						<p class="text-center description">También puedes donar tu tiempo y conocimiento, ofreciendo tu servicio como voluntario en los programas y actividades que Cáritas de Monterrey realiza.</p>
						<p><a class="btn btn-secondary btn-center" href="#">Quiero ayudar</a></p>
					</div>
					<div class="col-sm-4 donation-other text-center">
						<h4 class="title">Difusión de Cáritas en redes sociales</h4>
						<div class="text-center">Una forma muy fácil de ayudar, es difundir la obra de Cáritas en redes sociales, síguenos y comparte nuestro contenido. Dejar la indiferencia es el primer paso para ayudar a los más necesitados. ¡Cáritas somos todos!
						<?php echo do_shortcode('[easy-followers hide_title="1" new_window="1" template="roundcolor" animation="pop" columns="4"]'); ?> </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>