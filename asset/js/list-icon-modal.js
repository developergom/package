$(document).ready(function() {
    
    var input_selector = $('input[name="mico"]');
    var selector = 'div.col-md-3';
    $(this).find(selector).hover(function() {
        $(this).css('cursor', 'pointer');
    });
    
    $(this).find(selector).click(function() {
        $(this).each(function() {
            var text = $(this).text();
            input_selector.val(text);
            $('#modal-list-icon').modal('hide');
        });
    });
    
    input_selector.focus(function() {
        $('#modal-list-icon').modal('toggle');
    });
});
