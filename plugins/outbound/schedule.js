$(function() {
	$('.addcallorsmsschedule').click(function() {
		var $form = $('form.' + $(this).attr('id'));
		$('.vbx-schedule form').not($form).slideUp();
		$form.slideToggle();
		return false;
	});
	$('.date').datepicker();
	$('.time').timePicker({
	  startTime: "08:00", // Using string. Can take string or Date object.
	  endTime: new Date(0, 0, 0, 15, 30, 0), // Using Date object here.
	  show24Hours: false,
	  separator: ':',
	  step: 5});
	
});
