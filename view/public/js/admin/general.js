jQuery(document).ready(function($) {
	$('.box-header button').bind('click', function() {
		document.location.href = $(this).attr('value');
	});

});