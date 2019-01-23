jQuery(document).ready(function($) {
	var dropDownMenu = $('table .dropdown-menu');
	var active = dropDownMenu.find('li').eq(0).addClass('active').find('a'); // default action
	dropDownMenu.find('a').click(function(e) {
		if (!confirm('Are you sure you want to "' + $(this).text() + '" marked selectedItems?')) {
			return false;
		}
		e.preventDefault();
		var names = {};
		var elm = $(this);
		var th = elm.parents('th');
		var index = th.index();
		var form = $('<form>', {
			'action': elm.attr('href'),
			'method': 'post'
		});

		// add entity ids
		th.parents('table').find('tbody td:nth-child(' + (index + 1) + ')').find('input:checked').each(function(i, val) {
			var checkbox = $(val).clone().prop('checked', true);
			names[checkbox.attr('name').replace('[]', '')] = true;
			form.append($(val).clone().prop('checked', true));
		});

		// add entity names
		$.each(names, function(name, bool) {
			form.append('<input name="names[]" value="' + name + '" />');
		});
		form.hide().appendTo(document.body).submit();
		return false;
	});

	var actionPanel = dropDownMenu.parent('.btn-group');
	actionPanel.find('button:first-child').bind('click', function() {
		active.click();
	});
});