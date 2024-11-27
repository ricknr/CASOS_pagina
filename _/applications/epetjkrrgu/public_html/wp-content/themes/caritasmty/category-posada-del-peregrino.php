<?php get_header(); 

$cat_id = get_queried_object_id();

$featured_image = get_term_meta($cat_id,'featured',true); 
$category_icon = get_term_meta($cat_id,'category_icon',true); 

if($featured_image){
	$categoryfeaturedimg = wp_get_attachment_image_src($featured_image, 'full');
}

$description = term_description();?> 

<div id="content">
	<div id="page-header" class="mb-4" style="background-image:url(<?php echo $categoryfeaturedimg[0]; ?>);">
		<div class="page-title">
			<div class="container">
				<?php the_archive_title( '<h1 class="title">', '</h1>' );?>
			</div>
		</div>
	</div>
	<div class="container">
        <div class="row justify-content-center pt-4 pb-4">
    		<div class="col-4 col-md-2 text-center"><div class="category-icon"><?php if ($category_icon){ echo '<img src="'.$category_icon.'">';}?></div></div>
			<div class="col-8 category-description"><?php echo $description; ?></div>
			<div class="w-100"></div>
			<div class="col-8 col-sm-6 col-md-4 mt-4 mb-4 pt-4 pb-4"><a href="#donaciones" class="btn btn-primary btn-custom btn-block btn-lg anchor">Quiero ayudar</a></div>
		</div>
		
		<div class="row">
			<?php $programs_args = array(
					 'posts_per_page' => -1,
					 'orderby' => 'menu_order',
					 'order'	=> 'ASC',
					 'post_type' => 'program',
					 'post_status' => 'publish',
					 'tax_query' => array(
						array(
							'taxonomy' => 'category',
							'field' => 'term_id',
							'terms' => $cat_id
						)
					)
					);
			$programs = get_posts($programs_args);
			
			if($programs) { 
				//var_dump($programs);
			?>
			<div class="col-12"><h2 class="title text-center">Ubicaciones</h2></div>
			
			<?php foreach ( $programs as $program ) {
					setup_postdata( $program ); ?>
			<div class="program bg-lightgray pt-4 p-b-4 mb-4 col-12">
				<div class="row">
					<div class="col-12 col-md-4 order-md-last mb-4">
						<?php $thumbnail = get_the_post_thumbnail( $program->ID, 'medium_cropped', array( 'class' => 'img-fluid' ) );
						if ($thumbnail) {
							echo $thumbnail;
						} else {
							echo '<img src="'.get_template_directory_uri().'/images/placeholder4x3.png" class="img-fluid">';
						} ?>
					</div>
					<div class="col-12 col-md-8">
						<h4 class="program-name"><?php echo $program->post_title; ?></h4>
						<div class="ml-4 pl-4 program-description">
							<?php echo apply_filters('the_content', $program->post_content); ?>
						</div>
					</div>
				</div>
			</div>
			<div class="w-100"></div>
			<?php }
			wp_reset_postdata();?>
			<?php } ?>
			
			<div class="col-12 text-center share mt-4 mb-4">
				<h4 class="text-blue">Ayúdanos compartiendo esta nota en redes sociales</h4>
				<?php 
				$url = get_term_link( $cat_id, 'category' );
				$title = single_term_title('', false);
				echo do_shortcode('[easy-social-share buttons="facebook,twitter,whatsapp" counters=0 style="icon" template="18" point_type="simple" url="'.$url.'" text="'.$title.'"]'); ?> 
			</div>
			
			<?php if ( have_posts() ) { ?>
			<div class="col-12 area-posts">
				<h3 class="title">Conoce más sobre <strong><?php the_archive_title( '', '' );?></strong></h3>
				<div class="grid row">
				<?php while ( have_posts() ) { the_post();
							echo '<div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">';
							get_template_part( 'parts/content-item-simple' );
							echo '</div>';
				} ?>
				</div>
				<div class="row">
					<?php the_posts_pagination(array(
				'mid_size' => 2,
				'prev_text' => __('«'),
				'screen_reader_text' => ' ',
				'next_text' => __('»'),
			)); ?>
				</div>
			</div>
			<?php } else {
				echo '<div class="alert alert-warning" role="alert">
				  <strong>No encontramos información sobre esta área de servicio.</strong>
				</div>';
			} ?>
			
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
					<?php $especie = get_permalink( get_page_by_path( 'donativo-en-especie' ) );
					$voluntariado = get_permalink( get_page_by_path( 'voluntariado' ) );?>
					<div class="col-12"><h2 class="title mt-2 text-center">OTRAS FORMAS DE AYUDAR</h2></div>
					<div class="col-sm-4 donation-other text-center">
						<h4 class="title">Donación en especie</h4>
						<p class="text-center description">En Cáritas también recibimos tus donativos en especie que pueden ir desde alimentos, medicamentos, productos para el cuidado de la salud, por ejemplo: sillas de ruedas y muletas, así como también muebles, ropa y muchos artículos más en buen estado que pueden ser aprovechados para ayudar a nuestros hermanos más necesitados.</p>
						<p><a class="btn btn-secondary btn-center" href="<?php echo $especie; ?>">Quiero ayudar</a></p>
					</div>
					<div class="col-sm-4 donation-other text-center">
						<h4 class="title">Voluntariado</h4>
						<p class="text-center description">También puedes donar tu tiempo y conocimiento, ofreciendo tu servicio como voluntario en los programas y actividades que Cáritas de Monterrey realiza.</p>
						<p><a class="btn btn-secondary btn-center" href="<?php echo $voluntariado; ?>">Quiero ser voluntario</a></p>
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