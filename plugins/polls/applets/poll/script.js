$(function(){
	$('.vbx-polls select[name="poll"]').live('change',function() {
		var $select = $(this);
		var $options = $('select[name="option"]', $select.parents('.vbx-polls'));
		$options.empty();
		$.getJSON('../../p/polls', { poll : $select.val() }, function(options, i) {
			for(i = 0; i < options.length; i++)
				$options.append($('<option>').attr({ value : i }).text(options[i]));
		});
	});
})
