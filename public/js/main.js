$(function () {
	$('#galleries .gallery .preview').on('click', function () {
		var slideTime = 700, 
			$active = $('#galleries .gallery.active'),
			$gallery = $(this).parents('div.gallery');
		
		// zamykamy aktualny
		$active.removeClass("active", slideTime );
		$active.children().removeClass("active", slideTime );
		$active.find('.preview img').attr('src', $active.find('.thumbnail img').first().data('orig'));
		
		// jeśli event wywołał aktualny to kończymy
		if ($active.length && $active.get(0) === $gallery.get(0)) {
			return;
		}
		
		// w przeciwnym wypadku otwieramy nowy
		$gallery.addClass( "active", slideTime );
		$gallery.children().addClass( "active", slideTime );
	});
	
	$('#galleries .thumbnail img').on('click', function () {
		$(this).parents('.gallery').find('.preview img').attr('src', $(this).data('orig'));
	});

	$('#main_image').innerfade({ 
		speed: 2000, 
		timeout: 10000,
		containerheight: '291px'
	});
});
