/**
 * File aeonaccess.
 * @package   AeonAccess
 * @author    AeonWP <info@aeonwp.com>
 * @copyright Copyright (c) 2020, AeonWP
 * @link      https://aeonwp.com/aeonaccess
 * @license   http://www.gnu.org/licenses/gpl-2.0.html
*/
(function($) {
	"use strict";
    var KEYCODE_TAB = 9;
		//Check to see if the window is top if not then display button
		jQuery(window).scroll(function($){
			if (jQuery(this).scrollTop() > 100) {
				jQuery('.go-to-top').addClass('gotop');
				jQuery('.go-to-top').fadeIn();
			} else {
				jQuery('.go-to-top').fadeOut();
			}
		});
		
		//Click event to scroll to top
		jQuery('.go-to-top').click(function($){
			jQuery('html, body').animate({scrollTop : 0},800);
			return false;
		});

		$("#mobile-menu-toggle").on("click", function(e) {
            var element = document.querySelector( '.main-navigation' );
            var focusable = element.querySelectorAll( 'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
            var firstFocusable = focusable[0];
            var lastFocusable = focusable[focusable.length - 1];
            tab_focus( firstFocusable, lastFocusable );
        });
        //Focus trap in popup.
     
        function tab_focus( firstFocusable, lastFocusable ) {
            $(document).on('keydown', function(e) {
                if (e.key === 'Tab' || e.keyCode === KEYCODE_TAB) {
                    if ( e.shiftKey ) /* shift + tab */ {
                        if (document.activeElement === firstFocusable) {
                            lastFocusable.focus();
                            e.preventDefault();
                        }
                    } else /* tab */ {
                        if (document.activeElement === lastFocusable) {
                            firstFocusable.focus();
                            e.preventDefault();
                        }
                    }
                }
            });
        }
	}
)(jQuery);
