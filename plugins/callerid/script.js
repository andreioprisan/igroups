$(document).ready(function() {
	// Disable all the template row inputs
	$('.callerid-applet tr.hide input').attr('disabled', 'disabled');

	var app = $('.flow-instance.standard---callerid');
	$('.callerid-applet .callerid-prompt .audio-choice', app).live('save', function(event, mode, value) {
		var text = '';
		if(mode == 'say') {
			text = value;
		} else {
			text = 'Play';
		}
		
		var instance = $(event.target).parents('.flow-instance.standard---callerid');
		if(text.length > 0) {
			$(instance).trigger('set-name', 'Caller ID: ' + text.substr(0, 6) + '...');
		}
	});

	$('.callerid-applet input.keypress').live('change', function(event) {
		var row = $(this).parents('tr');
		$('input[name=^choices]', row).attr('name', 'keys['+$(this).val()+']');
	});

	$('.callerid-applet .action.add').live('click', function(event) {
		event.preventDefault();
		var row = $(this).closest('tr');
		var newRow = $('tfoot tr', $(this).parents('.callerid-applet')).html();
		newRow = $('<tr>' + newRow + '</tr>')			
			.show()
			.insertAfter(row);
		$('.flowline-item').droppable(Flows.events.drop.options);
		$('td', newRow).flicker();
		$('.flowline-item input', newRow).attr('name', 'choices[]');
		$('input.keypress', newRow).attr('name', 'keys[]');
		$('input', newRow).removeAttr('disabled').focus();
		$(event.target).parents('.options-table').trigger('change');
		return false;
	});

	$('.callerid-applet .action.remove').live('click', function() {
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

	$('.callerid-applet .options-table').live('change', function() {
		var first = $('tbody tr', this).first();
		$('.action.remove', first).hide();
	});

	$('.callerid-applet .options-table').trigger('change');
});
