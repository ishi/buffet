$(function () {
	$('#galleries .gallery').on('click', function () {
		var slideTime = 700, 
			$active = $('#galleries .gallery.active');
		
		if ($active.length && $active.get(0) == this) {
			return;
		}
		$active.removeClass("active", slideTime );
		$active.children().removeClass("active", slideTime );
		$(this).addClass( "active", slideTime );
		$(this).children().addClass( "active", slideTime );
	});
	
	$('#galleries .thumbnail img').on('click', function () {
		$(this).parents('.gallery').find('.preview img').attr('src', $(this).attr('src'));
	});

	$('#main_image').innerfade({ 
		speed: 2000, 
		timeout: 10000,
		containerheight: '291px'
	});
});
