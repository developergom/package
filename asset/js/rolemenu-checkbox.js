(function($) {

    $('.all').find('input[type="checkbox"]').each(function() {
        var $t = $(this);
        $t.click(function() {
            var key = $t.data('mid');
            $('.acc-' + key).prop('checked', ($t.is(':checked')) ? true : false);
        });
    });

})(jQuery);