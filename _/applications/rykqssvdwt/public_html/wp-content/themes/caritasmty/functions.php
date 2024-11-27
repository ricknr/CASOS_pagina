<?php

// soporte a funciones de wordpress 
add_theme_support( 'custom-logo' );
add_theme_support( 'title-tag' );
add_filter( 'widget_text', 'do_shortcode' );

// CARGAR SCRIPTS

add_action( 'wp_enqueue_scripts', 'caritas_queue' );

function caritas_queue() {
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/vendors/bootstrap/css/bootstrap.min.css' );
	wp_enqueue_style( 'fonts', 'https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700' );
	wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/vendors/fontawesome/font-awesome.min.css' );
	wp_enqueue_style( 'featherlight-style', get_template_directory_uri() . '/vendors/featherlight/featherlight.min.css' );
	wp_enqueue_style( 'slickstyle', get_stylesheet_directory_uri() . '/vendors/slick/slick.css' );
	wp_enqueue_style( 'slicktheme', get_stylesheet_directory_uri() . '/vendors/slick/slick-theme.css' );
	wp_enqueue_style( 'style', get_stylesheet_uri(), array( 'bootstrap' ) );
	wp_enqueue_style( 'style-caritas', get_stylesheet_directory_uri() . '/css/caritasmty.css', array( 'bootstrap' ) );
	wp_enqueue_style( 'style-categories', get_stylesheet_directory_uri() . '/category-style.css', array( 'bootstrap' ) );
	wp_enqueue_script( 'popper', '//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/vendors/bootstrap/js/bootstrap.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'matchheight', get_template_directory_uri() . '/vendors/matchheight/jquery.matchHeight-min.js', array( 'jquery' ) );
	wp_enqueue_script( 'featherlight', get_template_directory_uri() . '/vendors/featherlight/featherlight.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'anchorlink', get_template_directory_uri() . '/vendors/anchorlink/jquery.anchorlink.js', array( 'jquery' ) );
	wp_enqueue_script( 'slick', get_stylesheet_directory_uri() . '/vendors/slick/slick.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'sticky', get_stylesheet_directory_uri() . '/vendors/sticky/jquery.sticky.js', array( 'jquery' ) );
	
	wp_enqueue_script( 'mask', get_stylesheet_directory_uri() . '/vendors/mask/jquery.mask.min.js', array( 'jquery' ) );
	
	wp_enqueue_script( 'scripts', get_template_directory_uri() . '/scripts.js', array( 'jquery' ) );
}


function cardjs() {
	wp_register_style( 'cardjs-css', get_template_directory_uri() . '/vendors/cardjs/card-js.min.css' );
	wp_register_script( 'cardjs-js', get_template_directory_uri() . '/vendors/cardjs/card-js.min.js', array('jquery') );
}

// registro de menus

require_once('vendors/bootstrap/bs4navwalker.php');

function caritas_menus() {
	register_nav_menus(
		array(
			'mainnav' => __( 'Main Menu' ),
			'secondaryMenu' => __( 'Secondary Menu' )
		)
	);
}
add_action( 'init', 'caritas_menus' );

// tamanos de imagenes

add_action( 'init', 'remove_then_add_image_sizes' );

function remove_then_add_image_sizes() {
	remove_image_size( 'medium' );
	add_image_size( 'medium', 640, 480, true );
}

add_image_size( 'large_cropped', 1024, 768, true );
add_image_size( 'medium_cropped', 640, 480, true );
add_image_size( 'medium_cropped_vertical', 570, 745, true );


// registro de sidebars

function caritas_sidebars() {
	register_sidebar( array(
		'name' => 'Footer',
		'id' => 'footer',
		'before_widget' => '<div class="widget col-12 col-sm-6 col-md-6 col-lg-3 mb-4 %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="heading">',
		'after_title' => '</h4>',
	) );
	register_sidebar( array(
		'name' => 'Sidebar contenidos',
		'id' => 'contents-sidebar',
		'before_widget' => '<div id="%1$s" class="widget mb-4 %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="heading title">',
		'after_title' => '</h4>',
	) );
	register_sidebar( array(
		'name' => 'Sidebar vista blog',
		'id' => 'blog-sidebar',
		'before_widget' => '<div id="%1$s" class="widget mb-4 %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="heading title">',
		'after_title' => '</h4>',
	) );
	
	}
add_action( 'widgets_init', 'caritas_sidebars' );

include('inc/helpers.php');
include('inc/shortcodes.php');
include('inc/widgets.php');

// registro de custom post types

function create_program_cpt() {

	$labels = array(
		'name' => __( 'Programs', 'Post Type General Name', 'caritasmty' ),
		'singular_name' => __( 'Program', 'Post Type Singular Name', 'caritasmty' ),
		'menu_name' => __( 'Programs', 'caritasmty' ),
		'name_admin_bar' => __( 'Program', 'caritasmty' ),
		'archives' => __( 'Program Archives', 'caritasmty' ),
		'attributes' => __( 'Program Attributes', 'caritasmty' ),
		'parent_item_colon' => __( 'Parent Program:', 'caritasmty' ),
		'all_items' => __( 'All Programs', 'caritasmty' ),
		'add_new_item' => __( 'Add New Program', 'caritasmty' ),
		'add_new' => __( 'Add New', 'caritasmty' ),
		'new_item' => __( 'New Program', 'caritasmty' ),
		'edit_item' => __( 'Edit Program', 'caritasmty' ),
		'update_item' => __( 'Update Program', 'caritasmty' ),
		'view_item' => __( 'View Program', 'caritasmty' ),
		'view_items' => __( 'View Programs', 'caritasmty' ),
		'search_items' => __( 'Search Program', 'caritasmty' ),
		'not_found' => __( 'Not found', 'caritasmty' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'caritasmty' ),
		'featured_image' => __( 'Featured Image', 'caritasmty' ),
		'set_featured_image' => __( 'Set featured image', 'caritasmty' ),
		'remove_featured_image' => __( 'Remove featured image', 'caritasmty' ),
		'use_featured_image' => __( 'Use as featured image', 'caritasmty' ),
		'insert_into_item' => __( 'Insert into Program', 'caritasmty' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Program', 'caritasmty' ),
		'items_list' => __( 'Programs list', 'caritasmty' ),
		'items_list_navigation' => __( 'Programs list navigation', 'caritasmty' ),
		'filter_items_list' => __( 'Filter Programs list', 'caritasmty' ),
	);
	$args = array(
		'label' => __( 'Program', 'caritasmty' ),
		'description' => __( '', 'caritasmty' ),
		'labels' => $labels,
		'menu_icon' => 'dashicons-heart',
		'supports' => array('title', 'editor', 'thumbnail', 'page-attributes' ),
		'taxonomies' => array('category', ),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 5,
		'show_in_admin_bar' => false,
		'show_in_nav_menus' => true,
		'can_export' => true,
		'has_archive' => true,
		'hierarchical' => false,
		'exclude_from_search' => true,
		'show_in_rest' => false,
		'publicly_queryable' => true,
		'capability_type' => 'post',
	);
	register_post_type( 'program', $args );

}
add_action( 'init', 'create_program_cpt', 0 );

// category meta

class categoryicon {
	private $meta_fields = array(
		array(
			'label' => 'Featured',
			'id' => 'featured',
			'type' => 'media',
		),
		array(
			'label' => 'Category Icon',
			'id' => 'category_icon',
			'type' => 'media',
		),
		array(
			'label' => 'Category color',
			'id' => 'category_color',
			'type' => 'color',
		),
	);
	public function __construct() {
		if ( is_admin() ) {
			add_action( 'category_add_form_fields', array( $this, 'create_fields' ), 10, 2 );
			add_action( 'category_edit_form_fields', array( $this, 'edit_fields' ),  10, 2 );
			add_action( 'created_category', array( $this, 'save_fields' ), 10, 1 );
			add_action( 'edited_category',  array( $this, 'save_fields' ), 10, 1 );
			add_action( 'admin_footer', array( $this, 'media_fields' ) );
			add_action( 'admin_enqueue_scripts', 'wp_enqueue_media' );
		}
	}
	public function media_fields() {
		?><script>
			jQuery(document).ready(function($){
				if ( typeof wp.media !== 'undefined' ) {
					var _custom_media = true,
					_orig_send_attachment = wp.media.editor.send.attachment;
					$('.category-media').click(function(e) {
						var send_attachment_bkp = wp.media.editor.send.attachment;
						var button = $(this);
						var id = button.attr('id').replace('_button', '');
						_custom_media = true;
							wp.media.editor.send.attachment = function(props, attachment){
							if ( _custom_media ) {
								$('input#'+id).val(attachment.url);
							} else {
								return _orig_send_attachment.apply( this, [props, attachment] );
							};
						}
						wp.media.editor.open(button);
						return false;
					});
					$('.category-media-id').click(function(e) {
						var send_attachment_bkp = wp.media.editor.send.attachment;
						var button = $(this);
						var id = button.attr('id').replace('_button', '');
						_custom_media = true;
							wp.media.editor.send.attachment = function(props, attachment){
							if ( _custom_media ) {
								$('input#'+id).val(attachment.id);
								$('#preview-'+id).css("background-image", "url("+attachment.url+")");  
							} else {
								return _orig_send_attachment.apply( this, [props, attachment] );
							};
						}
						wp.media.editor.open(button);
						return false;
					});
					$('.add_media').on('click', function(){
						_custom_media = false;
					});
				}
			});
		</script><?php
	}
	public function create_fields( $taxonomy ) {
		$output = '';
		foreach ( $this->meta_fields as $meta_field ) {
			$label = '<label for="' . $meta_field['id'] . '">' . $meta_field['label'] . '</label>';
			if ( empty( $meta_value ) ) {
				$meta_value = $meta_field['default']; }
			switch ( $meta_field['type'] ) {
				case 'media':
					if ($meta_field['id'] == 'featured'){
						$input = sprintf(
						'<div id="preview-%s" style="width:200px;height:150px;display:inline-block;background-repeat:none;background-size:cover;background-color:#fdfdfd;background-image:url(%s)"></div><input style="width: 80%%" id="%s" name="%s" type="hidden" value="%s"> <input style="width: 15%%" class="button category-media-id" id="%s_button" name="%s_button" type="button" value="Upload" />',
						$meta_field['id'],
						$meta_image_url[0],
						$meta_field['id'],
						$meta_field['id'],
						$meta_value,
						$meta_field['id'],
						$meta_field['id']
					);
					} else {
						$input = sprintf(
						'<input style="width: 80%%" id="%s" name="%s" type="text" value="%s"> <input style="width: 15%%" class="button category-media" id="%s_button" name="%s_button" type="button" value="Upload" />',
						$meta_field['id'],
						$meta_field['id'],
						$meta_value,
						$meta_field['id'],
						$meta_field['id']
					);
					}
					
					break;
				default:
					$input = sprintf(
						'<input %s id="%s" name="%s" type="%s" value="%s">',
						$meta_field['type'] !== 'color' ? '' : '',
						$meta_field['id'],
						$meta_field['id'],
						$meta_field['type'],
						$meta_value
					);
			}
			$output .= '<div class="form-field">'.$this->format_rows( $label, $input ).'</div>';
		}
		echo $output;
	}
	public function edit_fields( $term, $taxonomy ) {
		$output = '';
		foreach ( $this->meta_fields as $meta_field ) {
			$label = '<label for="' . $meta_field['id'] . '">' . $meta_field['label'] . '</label>';
			$meta_value = get_term_meta( $term->term_id, $meta_field['id'], true );
			if ($meta_field['id'] == 'featured'){
				$meta_image_url = wp_get_attachment_image_src($meta_value, 'medium');
			}
			switch ( $meta_field['type'] ) {
				case 'media':
					if ($meta_field['id'] == 'featured'){
						$input = sprintf(
						'<div id="preview-%s" style="width:200px;height:150px;display:inline-block;background-repeat:none;background-size:cover;background-color:#fdfdfd;background-image:url(%s)"></div><input style="width: 80%%" id="%s" name="%s" type="hidden" value="%s"> <input style="width: 15%%" class="button category-media-id" id="%s_button" name="%s_button" type="button" value="Upload" />',
						$meta_field['id'],
						$meta_image_url[0],
						$meta_field['id'],
						$meta_field['id'],
						$meta_value,
						$meta_field['id'],
						$meta_field['id']
					);
					} else {
						$input = sprintf(
						'<input style="width: 80%%" id="%s" name="%s" type="text" value="%s"> <input style="width: 15%%" class="button category-media" id="%s_button" name="%s_button" type="button" value="Upload" />',
						$meta_field['id'],
						$meta_field['id'],
						$meta_value,
						$meta_field['id'],
						$meta_field['id']
					);
					}
					break;
				default:
					$input = sprintf(
						'<input %s id="%s" name="%s" type="%s" value="%s">',
						$meta_field['type'] !== 'color' ? '' : '',
						$meta_field['id'],
						$meta_field['id'],
						$meta_field['type'],
						$meta_value
					);
			}
			$output .= $this->format_rows( $label, $input );
		}
		echo '<div class="form-field">' . $output . '</div>';
	}
	public function format_rows( $label, $input ) {
		return '<tr class="form-field"><th>'.$label.'</th><td>'.$input.'</td></tr>';
	}
	public function save_fields( $term_id ) {
		foreach ( $this->meta_fields as $meta_field ) {
			if ( isset( $_POST[ $meta_field['id'] ] ) ) {
				switch ( $meta_field['type'] ) {
					case 'email':
						$_POST[ $meta_field['id'] ] = sanitize_email( $_POST[ $meta_field['id'] ] );
						break;
					case 'text':
						$_POST[ $meta_field['id'] ] = sanitize_text_field( $_POST[ $meta_field['id'] ] );
						break;
				}
				update_term_meta( $term_id, $meta_field['id'], $_POST[ $meta_field['id']] );
			} else if ( $meta_field['type'] === 'checkbox' ) {
				update_term_meta( $term_id, $meta_field['id'], '0' );
			}
		}
		create_css_file();
	}
}
if (class_exists('categoryicon')) {
	new categoryicon;
};

function create_css_file() {
	$css_file = dirname(__FILE__).'/category-style.css';

	$categories_with_color = get_terms( array(
		'taxonomy' => 'category',
		'meta_key' => 'category_color'
	) );

	$categories_color_style = '';

	foreach($categories_with_color as $cat ){
		//print_r($cat);
		$color = get_term_meta($cat->term_id, 'category_color', true);

		$categories_color_style .= '.homepage_grid .item .category.'.$cat->slug.', body.category-'.$cat->slug.' #page-header .page-title, body.category-'.$cat->slug.' .btn-custom, body.category-'.$cat->slug.' .category-icon, body.single-post .category-box.'.$cat->slug.' .category-icon, body.single-post .category-box.'.$cat->slug.' .btn-custom, body.single-post .category-box.'.$cat->slug.' .btn-custom:hover {
			background-color: '.$color.';
		}
		body.category-'.$cat->slug.' .tt-heading.title-wrapper {
			background: '.$color.';
		}
		body.category-'.$cat->slug.' .btn-custom, body.single-post .category-box.'.$cat->slug.' .btn-custom, body.single-post .category-box.'.$cat->slug.' .btn-custom:hover {
			border-color: '.$color.';
		}
		.blog-contents .item .content .category.'.$cat->slug.' span {
			background-color: '.$color.';
		}
		body.single-post .page-header .category-box.'.$cat->slug.' .title a, .widget_categories > ul > li.cat-item-'.$cat->term_id.':hover::before {
			color: '.$color.';
		}';
	}
	
	file_put_contents($css_file, $categories_color_style);
}

add_filter( 'get_the_archive_title', function ($title) {  
  
    if ( is_category() ) {  
  
            $title = single_cat_title( '', false );  
            // $title = single_cat_title( 'customize the text demo', false );  
  
        } elseif ( is_tag() ) {  
  
            $title = single_tag_title( '', false );  
  
        } elseif ( is_author() ) {  
  
            $title = '<span class="vcard">' . get_the_author() . '</span>' ;  
  
        } elseif (is_search()) {
			$title = 'Resultado de búsqueda para <span>'.get_search_query().'</span>';
		} 
  
    return $title;  
  
});


function category_filter_function(){
	$args = array(
		'orderby' => 'date', // we will sort posts by date
	);
	
	if( isset( $_POST['cats'] ) ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'category',
				'field' => 'id',
				'terms' => $_POST['cats']
			)
		);
	}
	
	$query = new WP_Query( $args );
 
	if( $query->have_posts() ) :
		while( $query->have_posts() ): $query->the_post();
			get_template_part( 'parts/content-item' );	
		endwhile;
		wp_reset_postdata();
	else :
		echo 'No posts found';
	endif;
 
	die();
	
}

add_action('wp_ajax_category_filter', 'category_filter_function'); 
add_action('wp_ajax_nopriv_category_filter', 'category_filter_function');

?>