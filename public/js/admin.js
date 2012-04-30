$(function () {
	$('.button').button();
	
	var delay = 3000, interval = 3000;
	$('#ui-messages .ui-widget').each(function () {
		$(this).delay(delay).fadeOut(1000); 
		delay += interval;
	});
	$('#ui-messages .ui-widget').on('click', function () {$(this).stop(true).fadeOut(1000)} );

	$('textarea').cleditor();
});
