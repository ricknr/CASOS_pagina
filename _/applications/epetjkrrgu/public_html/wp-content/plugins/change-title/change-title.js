var original = document.title;
var message = change_title;

if ( message ) {
	window.addEventListener('focus', function() {
		document.title = original;
	});

	window.addEventListener('blur', function() {
		document.title = message;
	});
}