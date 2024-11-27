<?php
// FIX PARA VISUAL COMPOSER

/*add_filter('vc_shortcodes_css_class', function ($class_string, $tag) {
  $tags_to_clean = [
	  'vc_row',
	  'vc_column',
	  'vc_row_inner',
	  'vc_column_inner'
  ];
  if (in_array($tag, $tags_to_clean)) {
	
	  $class_string = str_replace(' wpb_row', '', $class_string);
	  $class_string = str_replace(' vc_row-fluid', '', $class_string);
	  $class_string = str_replace(' vc_column_container', '', $class_string);
	  $class_string = str_replace('wpb_column', '', $class_string);
	  
          // replace vc_, but exclude any custom css 
          // attached via vc_custom_XXX (negative lookahead)
	  $class_string = preg_replace('/vc_(?!custom)/i', '', $class_string);
          
          // replace all vc_
          // $class_string = preg_replace('/vc_/i', '', $class_string);
  }
  $class_string = preg_replace('|col-sm|', 'col-sm', $class_string);
  return $class_string;
}, 10, 2);*/


/* CUSTOM EXCERPT */

function the_excerpt_max_charlength( $charlength, $postid ) {
	$excerpt = get_the_excerpt( $postid );
	$charlength++;

	if ( mb_strlen( $excerpt ) > $charlength ) {
		$subex = mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords = explode( ' ', $subex );
		$excut = -( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			$output = mb_substr( $subex, 0, $excut );
		} else {
			$output = $subex;
		}
		$output .= '...';
		return $output;
	} else {
		return $excerpt;
	}
}

?>