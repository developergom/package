$(document).ready(function(){
	var x = 0;
	var html_append = '';

	$('#multipleinput').change(function(){
		var val = $(this).val();
		
		if(val==='1'){
			html_append += '<div class="form-group" id="form-group-' + x + '">';
			html_append += '<label for="items_' + x + '" class="control-label col-sm-2">items</label>';
			html_append += '<div class="col-sm-2">';
				html_append += '<input type="text" name="items[]" id="items_' + x + '" class="form-control" value="" required>';
			html_append += '</div>';
			html_append += '<label for="value_' + x + '" class="control-label col-sm-2">Value</label>';
			html_append += '<div class="col-sm-2">';
				html_append += '<input type="text" name="value[]" id="value_' + x + '" class="form-control" value="" required>';
			html_append += '</div>';
			html_append += '<div class="col-sm-2"><a href="javascript:void(0)" class="btn btn-success btn-add">+</a>';
			html_append += '&nbsp;<a href="javascript:void(0)" class="btn btn-danger btn-substract">-</a></div>';
			html_append += '</div>';
		}
		else
		{
			html_append += '<div class="form-group">';
			html_append += '<label for="value" class="control-label col-sm-2">Value</label>';
			html_append += '<div class="col-sm-10">';
				html_append += '<input type="text" name="value" id="value" class="form-control" value="" required>';
			html_append += '</div>';
			html_append += '</div>';

			/*$('.form-horizontal').bootstrapValidator('addField', 
													'value', 
													{ 
														validators: {
															notEmpty: {
																message: 'Required coy'
															}
														}
													});*/
		}

		x = 0;
		$('#value-section').empty();
		$('#value-section').append(html_append);
		html_append = '';

		/*$.notify("Hello world", {
			className: 'success',
			style: 'bootstrap',
			showAnimation: 'fadeIn',
			hideAnimation: 'fadeOut'
		});*/
	});	

	$(document).on('click','.btn-add',function(){
		x++;

		html_append += generate_input(x);
		
		$('#value-section').append(html_append);
		html_append = '';

		return false;
	});

	$(document).on('click','.btn-substract', function(){
		delete_input(x);
		x--;
		return false;
	});

});

function generate_input(x){
	var html_append = '';

	html_append += '<div class="form-group" id="form-group-' + x + '">';
	html_append += '<label for="items_' + x + '" class="control-label col-sm-2">items</label>';
	html_append += '<div class="col-sm-2">';
		html_append += '<input type="text" name="items[]" id="items_' + x + '" class="form-control" value="" required>';
	html_append += '</div>';
	html_append += '<label for="value_' + x + '" class="control-label col-sm-2">Value</label>';
	html_append += '<div class="col-sm-2">';
		html_append += '<input type="text" name="value[]" id="value_' + x + '" class="form-control" value="" required>';
	html_append += '</div>';
	html_append += '</div>';

	return html_append;
}

function delete_input(x){
	$('#form-group-'+x).remove();
}