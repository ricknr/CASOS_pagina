// Wait DOM

jQuery(document).ready(function ($) {

	// ########## Tabs ##########

	// Nav tab click
	$('#donation-tabs span').click(function (event) {
		// Hide tips
		$('.donation-spin, .donation-success-tip').hide();
		// Remove active class from all tabs
		$('#donation-tabs span').removeClass('nav-tab-active');
		// Hide all panes
		$('.donation-pane').hide();
		// Add active class to current tab
		$(this).addClass('nav-tab-active');
		// Show current pane				

		$('#'+jQuery(this).data('id')).fadeIn(300);		

		// Save tab to cookies
		createCookie(pagenow + '_last_tab', $(this).index(), 365);
	});

	// Auto-open tab by link with hash
	if (strpos(document.location.hash, '#tab-') !== false) $('#donation-tabs span:eq(' + document.location.hash.replace('#tab-', '') + ')').trigger('click');
	// Auto-open tab by cookies
	else if (readCookie(pagenow + '_last_tab') != null) $('#donation-tabs span:eq(' + readCookie(pagenow + '_last_tab') + ')').trigger('click');
	// Open first tab by default
	else $('#donation-tabs span:eq(0)').trigger('click');


	// ########## Ajaxed form ##########

	$('#donation-form').ajaxForm({
		beforeSubmit: function() {
			$('.donation-success-tip').hide();
			$('.donation-spin').fadeIn(200);
			$('.donation-submit').attr('disabled', true);
			$('.donation-notice').fadeOut(400);
		},
		success: function() {
			$('.donation-spin').hide();
			$('.donation-success-tip').show();
			setTimeout(function() {
				$('.donation-success-tip').fadeOut(200);
			}, 2000);
			$('.donation-submit').attr('disabled', false);
		}
	});



	// ########## Cookie utilities ##########

	function createCookie(name, value, days) {
		if (days) {
			var date = new Date();
			date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
			var expires = "; expires=" + date.toGMTString()
		} else var expires = "";
		document.cookie = name + "=" + value + expires + "; path=/"
	}

	function readCookie(name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for (var i = 0; i < ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0) == ' ') c = c.substring(1, c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length)
		}
		return null
	}

	// ########## Strpos tool ##########

	function strpos(haystack, needle, offset) {
		var i = haystack.indexOf(needle, offset);
		return i >= 0 ? i : false;
	}


});
