<?php get_header(); 

$primary_cat = new WPSEO_Primary_Term('category', $post->ID);
$primary_cat = $primary_cat->get_primary_term();

if($primary_cat){
	$primary_cat_term_wpseo = get_term($primary_cat,'category');
	$primary_cat_term = $primary_cat_term_wpseo;
} else {
	$post_categories = get_the_category();
	$primary_cat_term = $post_categories[0];
}
//print_r($primary_cat_term );
$category_icon = get_term_meta($primary_cat_term->term_id, 'category_icon', true); 
$category_description = term_description($primary_cat_term->term_id,'category');?>
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
				<h1 class="title mb-4"><?php echo get_the_title(); ?></h1>
			</div>
			<div class="col-12 col-lg-8 mb-3">
				<div class="post-image match">
					<?php if ( has_post_thumbnail() ) {	
							echo get_the_post_thumbnail($post->ID, 'large_cropped', array('class' => 'img-fluid'));
					} else {
						echo '<img src="'.get_template_directory_uri().'/images/placeholder4x3.png" class="img-fluid">';
					};?>
				</div>
			</div>
			<div class="col-12 col-lg-4 mb-3">
				<div class="category-box <?php echo $primary_cat_term->slug; ?> match">
					<div class="category-icon">
					<?php if($category_icon) {
						echo '<img src="'.$category_icon.'">';
					} else {
						echo '<img src="'.get_template_directory_uri().'/images/placeholder-icon.png">';
					}?>
					</div>
					<h3 class="title"><a href="<?php echo get_term_link( $primary_cat_term->slug, 'category' ); ?>"><?php echo $primary_cat_term->name; ?></a></h3>
					<?php echo $category_description; ?>
					<p class="text-center mt-4 pt-3 mb-4"><a href="#donaciones" class="btn btn-primary btn-custom btn-lg">Quiero ayudar</a></p>
				</div>
			</div>
        </div>
        
		<div class="row">
			<div class="blog-contents col-sm-12 col-md-8 col-lg-8 margin-fix-top">
				<div class="author mr-4 mb-4">
					<?php $authorname = get_the_author_meta('display_name');
						  $authorArchive = get_author_posts_url($post->post_author);
						  $authorAvatar = get_avatar($post->post_author, 50, '', $authorname, array ('class' => 'mr-3 rounded-circle'));?>
					<div class="media">
					  <?php echo $authorAvatar; ?>
					  <div class="media-body">
						<h5 class="mt-0"><?php echo $authorname; ?></h5>
						<a href="<?php echo $authorArchive; ?>">Ver artículos</a>
					  </div>
					</div>
				</div>
				<?php the_content(); ?>
				
				<div class="text-center share">
					<h4 class="text-blue">Ayúdanos compartiendo esta nota en redes sociales</h4>
					<?php $url = get_the_permalink();
				$title = get_the_title();
				echo do_shortcode('[easy-social-share buttons="facebook,twitter,whatsapp" counters=0 style="icon" template="18" point_type="simple" url="'.$url.'" text="'.$title.'"]'); ?> 
				</div>
				
			</div>
		
        
        <div class="sidebar col-sm-12 col-md-4 col-lg-4 margin-fix-top">
        	<?php if(!dynamic_sidebar( 'contents-sidebar' )) { 
				}?>
        </div>
		
		</div>
		
		<div class="row related-posts">
			<div class="col-12">
				<h3 class="title">Te podría interesar...</h3>
				<?php echo do_shortcode('[latest_posts catid="'.$primary_cat_term->term_id.'" items="8" view="grid" cols="4"]'); ?>
			</div>
		</div>
		
		
    </div>
	<div id="donaciones" class="bg-blue">
		<div class="container">
			<h2 class="title text-white pt-4 text-center">Cómo ayudar</h2>
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