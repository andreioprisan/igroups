$(document).ready(function() {
	// Disable all the template row inputs
	$('.set-cookie tr.hide input').attr('disabled', 'disabled');

	$('.set-cookie .action.add').live('click', function(event) {
		event.preventDefault();
		var row = $(this).closest('tr');
		var newRow = $('tfoot tr', $(this).parents('.set-cookie')).html();
		newRow = $('<tr>' + newRow + '</tr>')			
			.show()
			.insertAfter(row);
		$('td', newRow).flicker();
		$('input.keypress:eq(0)', newRow).attr('name', 'names[]');
		$('input.keypress:eq(1)', newRow).attr('name', 'values[]');
		$('input', newRow).removeAttr('disabled').focus();
		$(event.target).parents('.options-table').trigger('change');
		return false;
	});

	$('.set-cookie .action.remove').live('click', function() {
		var row = $(this).closest('tr');
		var bgColor = row.css('background-color');
		row.animate(
			{
				backgroundColor : '#FEEEBD'
			}, 
			'fast')
			.fadeOut('fast', function() {
				row.remove();
			});

		return false;
	});

	$('.set-cookie .options-table').live('change', function() {
		var first = $('tbody tr', this).first();
		$('.action.remove', first).hide();
	});

	$('.set-cookie .options-table').trigger('change');
});
