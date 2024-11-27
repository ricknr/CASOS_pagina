<div class="item featured">
	<div class="image">
        <a href="<?php echo get_permalink($post->ID); ?>">
             <?php if ( has_post_thumbnail() ) {	
						echo get_the_post_thumbnail($post->ID, 'medium_cropped', array('class' => 'img-fluid'));
			} else {
				echo '<img src="'.get_template_directory_uri().'/img/placeholder16x9.png" class="img-fluid">';
			};?>
            <div class="inner">	
                <?php /*?><span><?php echo get_the_date('j F Y'); ?></span><?php */?>
                <h3><?php echo get_the_title(); ?></h3>
            </div>
        </a>
    </div>
</div>