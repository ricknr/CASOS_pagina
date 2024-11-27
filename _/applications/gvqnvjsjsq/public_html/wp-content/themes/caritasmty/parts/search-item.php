<?php $the_excerpt_but_better = the_excerpt_max_charlength(200, $post->ID);
$post_type = get_post_type();
$extra_class = array ( 'item','row', 'margin-bottom'); 
?>
<div <?php post_class($extra_class); ?>>
	<div class="image col-sm-4">
        <a href="<?php echo get_permalink($post->ID); ?>">
            <?php if ( has_post_thumbnail() ) {	
						echo get_the_post_thumbnail($post->ID, 'shop_catalog', array('class' => 'img-fluid'));
			} else {
				echo '<img src="'.get_template_directory_uri().'/img/placeholder4x4.png" class="img-fluid">';
			};?>
        </a>
    </div>
    <div class="content col-sm-8">
    	<h3><a href="<?php echo get_permalink($post->ID); ?>"><?php echo get_the_title(); ?></a></h3>
        <div><p><?php echo $the_excerpt_but_better; ?></p>
        <a href="<?php echo get_permalink($post->ID); ?>" class="btn btn-primary readmore">Ver más</a>
        </div>
    </div>
</div>