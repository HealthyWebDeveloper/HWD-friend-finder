/**
 * Javascript file
 *
 * @since 1.0.8
 *
 * @package hwd-friend-finder
 */

// alert('Hello World');

jQuery(document).ready(function($) {
	var data = {
		'action': 'hwd_add_friend',
		'whatever': ajax_object.we_value      // We pass php values differently!
	};
	// We can also pass the url value separately from ajaxurl for front end AJAX implementations
	jQuery.post(ajax_object.ajax_url, data, function(response) {
		alert('Got this from the server: ' + response);
	});
});