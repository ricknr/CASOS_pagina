<?php

class category_filter extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'category_filter', 

// Widget name will appear in UI
__('Category filter', 'caritasmty'), 

// Widget description
array( 'description' => __( 'AJAX filter for the blog post view.', 'caritasmty' ), ) 
);
}


public function widget( $args, $instance ) {
	
$categories_array = get_terms( 'category', array(
    'hide_empty' => false,
) );

	//var_dump($categories_array);

echo $args['before_widget'];
$title = apply_filters( 'widget_title', $instance['title'] );
if ( ! empty( $title ) ) {
echo $args['before_title'] . $title . $args['after_title'];
}

$content = '<form id="category_filter" method="post" action="'.site_url().'/wp-admin/admin-ajax.php">
			<ul class="list-unstyled">';
	foreach ( $categories_array as $category ) {
		if ($category->term_id > 1) {
		$content .= '<li><label><input type="checkbox" name="cats[]" value="'.$category->term_id.'" checked="checked"> '.$category->name.'</label></li>';
		}
	}
$content .= '</ul>
<input type="hidden" name="action" value="category_filter"></form>'; 
	
	echo $content;

echo $args['after_widget'];
}
		
// Widget Backend 
public function form( $instance ) {

if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( '', 'wpb_widget_domain' );
}
// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'caritasmty' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<?php 
}
	
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
$instance['items'] = ( ! empty( $new_instance['items'] ) ) ? strip_tags( $new_instance['items'] ) : '3';
return $instance;
}
}

// Register and load the widget
function wpb_load_widget() {
	register_widget( 'category_filter' );
}
add_action( 'widgets_init', 'wpb_load_widget' );

?>