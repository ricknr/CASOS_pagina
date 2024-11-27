<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
	<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-123644774-1"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', 'UA-123644774-1');
</script>
	
</head>

<body <?php body_class(); ?>>
<header>
	<div class="container">
		<nav class="navbar navbar-expand-md navbar-light">
		  <a class="navbar-brand col col-lg-2" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php 
					$custom_logo_id = get_theme_mod( 'custom_logo' );
					if ($custom_logo_id) {
						$logo_image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
						echo '<img src="'.$logo_image[0].'" class="img-fluid">';
					}?></a>
		  <button class="fullscreen-nav-toggler d-md-none" type="button">
			<i class="fa fa-bars"></i>
		  </button>

			<?php
					wp_nav_menu (array (
					'theme_location' => 'mainnav',
					'container' => 'div',
					'menu_class'      => 'navbar-nav',
					'container_id' => 'mainnav',
					'container_class' => 'd-md-flex col-md-8 col-lg-10 justify-content-end',
					'walker'          => new bs4navwalker()
				));?> 
		</nav>
	</div>
</header>