(function($) {
	$('.customgrid').click(function(){
		addQueryString($(this).data('pk'),$(this).data('pv'));
	});

    function addQueryString(key,value){
    	var currUrl = window.location.href;

    	currUrl = currUrl + '?' + key + '=' + value;

    	alert(currUrl);
    }

    function generateQueryString(){
    	var sSort = '';
    	var sOrder = '';
    	var sPage = '';
    	var sSearch = '';
    }
})(jQuery);