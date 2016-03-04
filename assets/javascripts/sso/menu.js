$(document).ready(function(){
	var dataModules = [];

	$.ajax({
		url: base_url + "sso/module/api_all",
		method: "GET",
		dataType: "json",
		success: function(data){
			dataModules = data;
		}
	});

	$('#apps_id').change(function(){
		var apps_id = $(this).val();
		var result = $.grep(dataModules, function(e){ return e.app_id == apps_id; }); //function where js

		$("select[name='module_id']").empty();
		$("select[name='module_id']").append('<option value="">Please select...</option>');
		$.each(result, function(k, v){
			$("select[name='module_id']").append('<option value="' + v.module_id + '">' + v.module_url + '</option>');
		});

	});
});