jQuery(document).ready(function() {
	
	jQuery('.fullscreen-nav-toggler').click(function() {
		jQuery('header #mainnav').slideToggle('slow', function() {
			jQuery('body').toggleClass('mobile-menu-open');
		});
	});
	
	jQuery('.nav-link.disabled').click(function(e){
		e.preventDefault(); 
	})
	
	 jQuery("header").sticky({topSpacing:0, wrapperClassName: 'header-sticky'});
	
	jQuery('.homepage_grid .item.sm div .cont h3').matchHeight();
	
	jQuery('.homepage_grid .item.sm div .cont .extract').matchHeight();
	
	jQuery('.donation-other .description').matchHeight();
	
	jQuery('.match').matchHeight();
	
	jQuery(function () {
  jQuery('[data-toggle="tooltip"]').tooltip();
});
	
jQuery('.expiry').mask('00/00');

	jQuery('.card-number').mask("0000 0000 0000 0000", {placeholder: "XXXX XXXX XXXX XXXX"});
	
	jQuery('.quantity_select li').click(function() {
		var clicked = jQuery(this);
		var value = clicked.data('qty');
		jQuery('input.customqty-input').attr('value','');
		jQuery('.quantity_select li').removeClass('selected');
		clicked.addClass('selected');
		
		jQuery('.quantity').attr('value',value);
		jQuery('#amount').attr('value',value);
		
	});
	
	//jQuery('input.customqty-input').mask('#.##0,00', {reverse: true});
	
	jQuery('input.customqty-input').change(function(){
		var val = jQuery(this).val();
		if(val !== '') {
			jQuery('.quantity_select li').removeClass('selected');
			jQuery('.quantity').attr('value',val);
		}
	});
	
	jQuery('.conecta-posts.carousel').slick({
  dots: true,
  infinite: false,
  speed: 300,
  slidesToShow: 3,
  slidesToScroll: 3,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3,
        infinite: true,
        dots: true
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
}
	);
	jQuery('.area-posts .carousel, .latest-posts.carousel').slick({
  dots: true,
  infinite: false,
  speed: 300,
  slidesToShow: 4,
  slidesToScroll: 1,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3,
        infinite: true,
        dots: true
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
}
	);
	
	var headerHeight = jQuery('.header-sticky').outerHeight(); 
	
	
	jQuery('a[href^="#"][href!="#"]').anchorlink({

	  // animation speed in milliseconds
	  timer : 500,

	  // scroll to hash in URL when loading the page
	  scrollOnLoad : true,

	  // top offset in pixels
	  offsetTop : -headerHeight,

	  // CSS class added to the scroll destination
	  focusClass : 'js-focus'

	});
	
	
	//var voluntariosTitle = jQuery('body.post-template-page-voluntarios .page-header div h1.title');
	
	
	jQuery('.title_voluntarios').each(function() {
		var voluntariosTitle = jQuery(this);
		var arrayvoluntariosTitle = voluntariosTitle.text().split(' – ');
		voluntariosTitle.html(arrayvoluntariosTitle[0]+' <span>'+arrayvoluntariosTitle[1]+'</span>');
	});
	
	
	jQuery("#category_filter input[type=checkbox]").prop("checked", true);
	
	
	jQuery(function($){
	$('#category_filter input[type=checkbox]').change(function(){
		var filter = $('#category_filter');
		$(this).parent().parent('li').toggleClass('unchecked');
		$.ajax({
			url:filter.attr('action'),
			data:filter.serialize(), // form data
			type:filter.attr('method'), // POST
			beforeSend:function(){
				$('#filter-results').html('<h3 class="loader">Cargando</h3>');
			},
			success:function(data){
				$('#filter-results').hide().delay(300).html(data).fadeIn(600); // insert data
			}
		});
		return false;
	});
});
	
	
});