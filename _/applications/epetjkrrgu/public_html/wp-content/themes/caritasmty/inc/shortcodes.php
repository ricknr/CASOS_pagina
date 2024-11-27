<?php
add_shortcode( 'featured_categories', function($atts, $content = null) {

	extract(shortcode_atts(array(
		'id' 						=> '',
		'view'						=> 'carousel',
		'type'						=> 'category',
		'class' 						=> '',     
		), $atts));

 	global $post;
	
 	$output     = '';
 	$posts= 0;
	
	$classes = $class.' '.$view; 
			
			$ids = array($id);
				
			if ($id) {
				$query_args = array(
							'taxonomy' => $type,
							'hide_empty' => false,
							'include'    => $id
					);
			}
			
	
		    $categories = get_terms($query_args);
			//print_r($categories);

		    if(count($categories)>0){
				if ($view != "carousel"){
					$itemclass = "col-sm-4";
				} else {
					$itemclass = "";
				}
				
				
				$output .= '<div class="featured-product-categories '.$classes.'">';

			    foreach ($categories as $category) { 
					//print_r($category);
					if ($type == 'category'){
						$t_id = $category->term_id;
						$term_meta = get_option( "category_$t_id" );
						$thumbnail_id = $term_meta['featured'];
					} else {
						$thumbnail_id = get_woocommerce_term_meta($category->term_id, 'thumbnail_id' ,true);
					}
					
					$thumbnail_img = wp_get_attachment_image_src( $thumbnail_id, 'medium_cropped' );
					
					$cat_link = get_term_link( $category->term_id, $type );
					
					$output .= '<div class="item '.$itemclass.'">';
					$output .= '<a href="'.$cat_link.'">';
					if ($thumbnail_img){
						$output .= '<img src="'.$thumbnail_img[0].'" class="img-fluid">';
					} else {
						$output .= '<img src="'.get_template_directory_uri().'/img/placeholder4x3.png" class="img-fluid">';
					}
					$output .= '</a>';
					$output .= '<h3><a href="'.$cat_link.'">'.$category->name.'</a></h3>';
					$output .= '<div>'.substr($category->description, 0, 120).'...</div>';
					
					$output .= '</div>';
					
				}
				
				$output .= '</div>';
	
			}
	return $output;

});

add_shortcode( 'conecta', function($atts, $content = null) {
	extract(shortcode_atts(array(
		'items'						=> 1,
		'cols'						=> 3,
		'class' 						=> '',     
		), $atts));
	
	$voluntarios_slug = 'voluntarios-del-ano';
	$eventos_slug = array('eventos','noticias');
	
	$args_eventos = array(
	 'posts_per_page' => $items,
	 'orderby' => 'date',
	 'post_type' => 'post',
	 'post_status' => 'publish',
	 'tax_query' => array(
		array(
			'taxonomy' => 'category',
			'field' => 'slug',
			'terms' => $eventos_slug
		)
	)
	);
	$args_voluntarios = array(
	 'posts_per_page' => 1,
	 'orderby' => 'date',
	 'post_type' => 'post',
	 'post_status' => 'publish',
	 'tax_query' => array(
		array(
			'taxonomy' => 'category',
			'field' => 'slug',
			'terms' => $voluntarios_slug
		)
	)
	);
	
	$query_eventos = get_posts($args_eventos);
	$query_voluntarios = get_posts($args_voluntarios);
	$query_voluntarios[0]->cat_slug .= 'voluntario';
	/*$contecta_posts = $query_eventos;
	$contecta_posts[2] = $query_voluntarios[0];*/
	
	$contecta_posts = array_merge(array_slice($query_eventos, 0, 2, true), array(2 =>$query_voluntarios[0]), array_slice($query_eventos, 2, count($query_eventos) - 1, false));
	
	//var_dump($contecta_posts);
	
	$content = '<div class="conecta-mod row'.$class.'">';
	
	$content .= '<div class="col-12 col-lg-3"><h2 class="title text-blue">Conecta <em>con Cáritas</em></h2></div>';
	
	$content .= '<div class="col-12 col-lg-9">';

	$content .= '<div class="conecta-posts carousel">';
	foreach ( $contecta_posts as $post ) {
		setup_postdata( $post );
		$thumbnail = get_the_post_thumbnail( $post->ID, 'medium_cropped', array( 'class' => 'img-fluid' ) );
		$the_excerpt_but_better = the_excerpt_max_charlength(100, $post->ID);
		/* $cat = get_the_category($post->ID);
		$t_id = $cat[0]->term_id;
		$term_meta = get_option( "category_$t_id" );
		$category_link = get_category_link( $cat[ 0 ]->term_id );
		$categoryimage = esc_attr( $term_meta['image'] ) ? esc_attr( $term_meta['image'] ) : 'http://placehold.it/100x100';*/
		
		$content .= '<div class="item mb-4 pl-3 pr-3 '.$post->cat_slug.'">';
		$content .= '<div class="image mb-3"><a href="'.get_permalink($post->ID).'">';
		if ($thumbnail) {
			$content .= $thumbnail;
		} else {
			$content .= '<img src="'.get_template_directory_uri().'/images/placeholder4x3.png" class="img-fluid">';
		}
		$content .= '</a></div>';
		$content .= '<h4 class="title mb-3"><a href="'.get_permalink($post->ID).'">'.$post->post_title.'</a></h4>';		
        $content .= '</div>';
	}
	$content .= '</div></div></div>'; 
	wp_reset_postdata();
	
	return $content;
	
});

if (class_exists('WPBakeryVisualComposerAbstract')) {
	vc_map(array(
		"name" => __("Conecta posts", "caritas"),
		"base" => "conecta",
		//'icon' => get_template_directory_uri().'/img/caritas-vc-icon.png',
		"class" => "",
		"description" => __("Displays Conecta section.", "caritas"),
		"category" => __('Cáritas de Monterrey', "caritas"),
		"params" => array(	
			array(
				"type" => "textfield",
				"heading" => __("Number of posts", "caritas"),
				"param_name" => "items",
				"value" => '1'
				),
			array(
				"type" => "textfield",
				"heading" => __("Number of columns", "caritas"),
				"param_name" => "cols",
				"value" => '3'
				),
			array(
				"type" => "textfield",
				"heading" => __("Custom Class", "caritas"),
				"param_name" => "class",
				"value" => "",
				),	

			)

		));
}



add_shortcode( 'latest_posts', function($atts, $content = null) {
	extract(shortcode_atts(array(
		'catid' 						=> 0,
		'items'						=> 1,
		'cols'						=> 3,
		'view'						=> 'list',
		'archive'						=> false,
		'class' 						=> '',     
		), $atts));
	
	if ($catid == 0) {
		$args = array(
	 'posts_per_page' => $items,
	 'orderby' => 'date',
	 'post_type' => 'post',
	 'post_status' => 'publish' );
	} else { 
	
	$args = array(
	 'posts_per_page' => $items,
	 'orderby' => 'date',
	 'post_type' => 'post',
	 'post_status' => 'publish',
	 'tax_query' => array(
		array(
			'taxonomy' => 'category',
			'field' => 'term_id',
			'terms' => array($catid)
		)
	)
	 
	);
	}
	$latest_posts_total = get_posts($args);
	$class = "";
	$itemclass = "";
	if ($view == 'list') {
		$class = "col-xs-6";
		$itemclass = "row";
	} else if($view == 'sidebar') {
		
	} else if($view == 'grid'){
		$gridclass = 12 / $cols;
		$itemclass .= "col-md-4 col-sm-6 col-12 mb-4 col-lg-".$gridclass;
		$view .= ' row';
	}
	$content = '<div class="latest-posts '.$view.'">';
	foreach ( $latest_posts_total as $post ) {
		setup_postdata( $post );
		$thumbnail = get_the_post_thumbnail( $post->ID, 'medium_cropped', array( 'class' => 'img-fluid' ) );
		$the_excerpt_but_better = the_excerpt_max_charlength(100, $post->ID);
		/* $cat = get_the_category($post->ID);
		$t_id = $cat[0]->term_id;
		$term_meta = get_option( "category_$t_id" );
		$category_link = get_category_link( $cat[ 0 ]->term_id );
		$categoryimage = esc_attr( $term_meta['image'] ) ? esc_attr( $term_meta['image'] ) : 'http://placehold.it/100x100';*/
		
		$content .= '<div class="item mb-4 '.$itemclass.'">';
		$content .= '<div class="image mb-3 '.$class.'"><a href="'.get_permalink($post->ID).'">';
		if ($thumbnail) {
			$content .= $thumbnail;
		} else {
			$content .= '<img src="'.get_template_directory_uri().'/images/placeholder4x3.png" class="img-fluid">';
		}
		$content .= '</a></div>';
		$content .= '<h4 class="title mb-3"><a href="'.get_permalink($post->ID).'">'.$post->post_title.'</a></h4>';
		if ($view != 'sidebar') {
			
		$content .= '<div class="content">';
		$content .= '<p>'.$the_excerpt_but_better.'</p>';
		$content .= '<a href="'.get_permalink($post->ID).'" class="readon">Conoce más</a>';
		$content .= '</div>';
			
		}
		
        $content .= '</div>';
	}
	$content .= '</div>'; 
	wp_reset_postdata();
	
	return $content;
	
});


if (class_exists('WPBakeryVisualComposerAbstract')) {
	vc_map(array(
		"name" => __("Latests posts", "caritas"),
		"base" => "latest_posts",
		//'icon' => get_template_directory_uri().'/img/caritas-vc-icon.png',
		"class" => "",
		"description" => __("Displays the latest content.", "caritas"),
		"category" => __('Cáritas de Monterrey', "caritas"),
		"params" => array(	
			
			array(
				"type" => "textfield",
				"heading" => __("Categories", "caritas"),
				"param_name" => "catid",
				"value" => ''
				),
			array(
				"type" => "textfield",
				"heading" => __("Number of posts", "caritas"),
				"param_name" => "items",
				"value" => '1'
				),
			array(
				"type" => "textfield",
				"heading" => __("Number of columns", "caritas"),
				"param_name" => "cols",
				"value" => '3'
				),
			array(
				"type" => "dropdown",
				"heading" => __("View", "caritas"),
				"param_name" => "view",
				"value" => array('list','grid','sidebar')
				),

			array(
				"type" => "textfield",
				"heading" => __("Custom Class", "caritas"),
				"param_name" => "class",
				"value" => "",
				),	

			)

		));
}



// homepage grid 

function homepage_grid_cache($cats) {
	$args = array(
          'taxonomy' => 'category',
          'number'  =>  12,
          'include' => $cats,
          'orderby'  => 'include',
        );

	$categories = get_terms( $args );
	
	$sticky = get_option( 'sticky_posts' );
	$homepage_grid_query = array();
	
	foreach( $categories as $category ) {
		
		//var_dump($category);
		$category_icon = get_term_meta($category->term_id, 'category_icon', true);
	
		$args = array(
			'posts_per_page' => 1,
			'post_type' => 'post',
			'tax_query' => array(
				array(
					'taxonomy' => 'category',
					'field' => 'term_id',
					'terms' => $category->term_id,
					'include_children' => false
				)
			),
			'post__in'            => $sticky,
			//'no_found_rows' => true,
			'ignore_sticky_posts' => 0,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false
		);
		
		$the_query = new WP_Query( $args );
		
		// The Loop
		while ( $the_query->have_posts() ) : $the_query->the_post();
		
			$post_thumbnail = null;
			$post_thumbnail_vertical = null;
			$post_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium_cropped');
			$post_thumbnail_vertical = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium_cropped_vertical');
		
			$the_extract = the_excerpt_max_charlength(120,get_the_ID());
			
		
			/* All the data pulled is saved into an array which we'll save later */
		

			$homepage_grid_query[$category->slug] = array(
				'name'	=> get_the_title(),
				'extract'	=> $the_extract,
				'post_id' => get_the_ID(),
				'category' => $category->name,
				'category_slug' => $category->slug,
				'category_icon' => $category_icon,
				'term_link' =>  esc_attr( get_term_link( $category->slug, 'category' ) ),
				'post_thumbnail' => $post_thumbnail[0],
				'post_thumbnail_vertical' => $post_thumbnail_vertical[0]
			);
		
		endwhile;
   }
   
   	// Reset Post Data
	wp_reset_postdata();
	
	set_transient( 'homepage_grid_query', $homepage_grid_query );
	
	return $homepage_grid_query;
}


add_shortcode( 'homepage_grid', function($atts, $content = null) {
	extract(shortcode_atts(array(
		'categories' 		=> 0,
		'class' 			=> '',     
		), $atts));
	$content = '';

	if ($categories == 0) {
		$content .= 'Selecciona las categorias a mostrar';
	} else {
		$cats = explode(',', $categories);
		 $homepage_grid_query = get_transient('homepage_grid_query');
	       if ( !$homepage_grid_query ) {
	            $homepage_grid_query = homepage_grid_cache($cats);
	       }
		$homepage_grid_query = homepage_grid_cache($cats);
		//var_dump($homepage_grid_query);
		
		$content .= '<div class="homepage_grid mb-4 pb-4 row '.$class.'">';
			$counter = 1;
			foreach ($homepage_grid_query as $item) {
				setup_postdata( $item );
				
				//$item_id = $item['post_id'];
				//$the_extract = the_excerpt_max_charlength(100,$item_id);
				
				if ($counter < 3){
					$content .= '<div class="item featured col-12 col-lg-6 pb-4">
					<div class="row">
					<div class="image col-sm-6 mb-3 mb-md-2"><a href="'.get_permalink($item['post_id']).'" class="d-block" ><img src="'.$item['post_thumbnail_vertical'].'" class="img-fluid"></a> <a href="'.$item['term_link'].'" class="category '.$item['category_slug'].'">';
					if ($item['category_icon']) {
						$content .= '<img src="'.$item['category_icon'].'" class="img-fluid">';
					}
					$content .= $item['category'].'</a> </div>
					<div class="cont col-sm-6"><h3><a href="'.get_permalink($item['post_id']).'">'.$item['name'].'</a></h3>
					<div class="extract ml-3 mt-3">'.$item['extract'].'
					<a href="'.get_permalink($item['post_id']).'" class="readon mt-4 d-block">Conoce más</a></div>
					</div></div>
					</div>';
				} else {
					$content .= '<div class="item sm col-12 col-md-6 col-lg-3 pb-4 mb-4">
					<div class="row">
					<div class="image col-12 mb-3 mb-md-2"><a href="'.get_permalink($item['post_id']).'" class="d-block" ><img src="'.$item['post_thumbnail'].'" class="img-fluid"></a>';
					$content .= '<a href="'.$item['term_link'].'" class="category '.$item['category_slug'].'">';
					if ($item['category_icon']) {
						$content .= '<img src="'.$item['category_icon'].'" class="img-fluid">';
					}
					$content .= $item['category'].'</a> </div>
					<div class="cont col-12"><h3><a href="'.get_permalink($item['post_id']).'">'.$item['name'].'</a></h3>
					<div class="extract ml-3 mt-3">'.$item['extract'].'
					<a href="'.get_permalink($item['post_id']).'" class="readon mt-4 d-block">Conoce más</a></div>
					';
					$content .= '<a href="'.$item['term_link'].'" class="category mt-4 '.$item['category_slug'].'">';
					if ($item['category_icon']) {
						$content .= '<img src="'.$item['category_icon'].'" class="img-fluid">';
					}
					$content .= $item['category'].'</a>';
					$content .= '</div></div>
					</div>';
				}
				
				$counter++;
			}
		$content .= '</div>';
		wp_reset_postdata();
		
	}
	
	
	return $content;
});

if (class_exists('WPBakeryVisualComposerAbstract')) {
	vc_map(array(
		"name" => __("Homepage grid", "caritas"),
		"base" => "homepage_grid",
		//'icon' => get_template_directory_uri().'/img/caritas-vc-icon.png',
		"class" => "",
		"description" => __("Displays the latest content in a featured format.", "caritas"),
		"category" => __('Cáritas de Monterrey', "caritas"),
		"params" => array(	
			
			array(
				"type" => "textfield",
				"heading" => __("Category", "caritas"),
				"param_name" => "categories",
				"value" => ''
				),	

			array(
				"type" => "textfield",
				"heading" => __("Custom Class", "caritas"),
				"param_name" => "class",
				"value" => "",
				),	

			)

		));
}


add_shortcode( 'donaciones', function($atts, $content = null) {
	extract(shortcode_atts(array(
		'style' 		=> 'horizontal',
		'class' 			=> '',     
		), $atts));
	$content = '';
		
	add_action( 'wp_enqueue_scripts', 'cardjs' );
	
	//include('donaciones.php');
	include( WP_PLUGIN_DIR . '/donation-master/front-end/donaciones.php');

	return $content;
});

if (class_exists('WPBakeryVisualComposerAbstract')) {
	vc_map(array(
		"name" => __("Modulo donaciones", "caritas"),
		"base" => "donaciones",
		//'icon' => get_template_directory_uri().'/img/caritas-vc-icon.png',
		"class" => "",
		"description" => __("", "caritas"),
		"category" => __('Cáritas de Monterrey', "caritas"),
		"params" => array(	
			
			array(
				"type" => "dropdown",
				"heading" => __("Estilo", "caritas"),
				"param_name" => "style",
				"value" => array('Horizontal' => 'horizontal', 'Vertical' => 'vertial', 'Sidebar' => 'mini')
				),	

			array(
				"type" => "textfield",
				"heading" => __("Custom Class", "caritas"),
				"param_name" => "class",
				"value" => "",
				),	

			)

		));
}



?>
