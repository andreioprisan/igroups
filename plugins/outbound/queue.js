$(function() {
	$('#scheduleeventdelete').click(function() {
		var $event = $(this).parent().parent(), id = $event.attr('id'), type = $event.children().children('tr').eq(1).text();
		if(confirm('Are you sure that you want to delete this scheduled event?'))
		$.ajax({
			type: 'POST',
			url: window.location,
			data: {
				remove: id.match(/([\d]+)/)[1]
			},
			success: function() {
				$event.hide(500);
			},
			dataType: 'text'
		});
		return false;
	});
});
