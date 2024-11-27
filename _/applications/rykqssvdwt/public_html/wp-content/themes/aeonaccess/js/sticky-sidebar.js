/**
 * File aeonaccess.
 * @package   AeonAccess
 * @author    AeonWP <info@aeonwp.com>
 * @copyright Copyright (c) 2020, AeonWP
 * @link      https://aeonwp.com/aeonaccess
 * @license   http://www.gnu.org/licenses/gpl-2.0.html
*/
	jQuery(document).ready(function() {

		//sticky sidebar
		var at_body = jQuery("body");
		var at_window = jQuery(window);

	   if(at_body.hasClass('pt-sticky-sidebar')){
				if(at_body.hasClass('right-sidebar')){
					jQuery('.secondary, #primary').theiaStickySidebar();
				}
				else{
					jQuery('.secondary, #primary').theiaStickySidebar();
				}
			}

});