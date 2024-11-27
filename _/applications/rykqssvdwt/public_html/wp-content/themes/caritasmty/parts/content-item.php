<?php $the_excerpt_but_better = the_excerpt_max_charlength(200, $post->ID);
$post_categories = get_the_category();
$primary_cat = new WPSEO_Primary_Term('category', $post->ID);
$primary_cat = $primary_cat->get_primary_term();
$primary_cat_term = get_term($primary_cat,'category');?>
<div class="item row mb-4">
	<div class="image col-sm-6 mb-2">
        <a href="<?php echo get_permalink($post->ID); ?>">
            <?php if ( has_post_thumbnail() ) {	
						echo get_the_post_thumbnail($post->ID, 'medium_cropped', array('class' => 'img-fluid'));
			} else {
				echo '<img src="'.get_template_directory_uri().'/images/placeholder4x3.png" class="img-fluid">';
			};?>
        </a>
    </div>
    <div class="content col-sm-6">
		<div class="mb-1 category <?php echo $primary_cat_term->slug; ?>"><span><?php echo $primary_cat_term->name; ?></span></div>
    	<h3 class="title"><a href="<?php echo get_permalink($post->ID); ?>"><?php echo get_the_title(); ?></a></h3>
        <div><p><?php echo $the_excerpt_but_better; ?></p>
        <a href="<?php echo get_permalink($post->ID); ?>" class="readon">Ver más</a>
         </div>
    </div>
</div>