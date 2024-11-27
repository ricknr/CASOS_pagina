<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
	

	<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KMH8ZS3');</script>
<!-- End Google Tag Manager -->

</head>

<body <?php body_class(); ?>>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KMH8ZS3"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<header>
	<div class="container">
		<nav class="navbar navbar-expand-md navbar-light">
		  <a class="navbar-brand col col-lg-2" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php 
					$custom_logo_id = get_theme_mod( 'custom_logo' );
					if ($custom_logo_id) {
						$logo_image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
						echo '<img src="'.$logo_image[0].'" class="img-fluid" alt="logo caritas de monterrey">';
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