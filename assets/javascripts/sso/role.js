$(document).ready(function(){
	$('.btn-check-all').click(function(){
		var menu_id = $(this).data('menu_id');
		var checkbox_upper = $('.action-check-' + menu_id).parent();
		var checkbox_lower = $('.action-check-' + menu_id);

		if($(this).data('checked')===false) {
			checkbox_upper.addClass('checked');
			checkbox_upper.attr('aria-checked', true);
			checkbox_lower.attr('checked', true);

			$(this).find('span').empty().append('uncheck all');
			$(this).data('checked', true);
		}else{
			checkbox_upper.removeClass('checked');
			checkbox_upper.attr('aria-checked', false);
			checkbox_lower.attr('checked', false);

			$(this).find('span').empty().append('check all');
			$(this).data('checked', false);
		}
	});
});