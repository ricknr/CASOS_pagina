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
	<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KMH8ZS3');</script>
<!-- End Google Tag Manager -->
</head>

<body <?php body_class(); ?>>
<!-- Google Tag Manager noscript -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KMH8ZS3"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager noscript -->
<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '1272033029605314');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=1272033029605314&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->

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
