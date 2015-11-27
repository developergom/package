$.widget.bridge('uibutton', $.ui.button);
"use strict";
$(function () {
    var base_url = window.location.protocol + '//' + window.location.host + '/package/';
    //var base_url = window.location.protocol + '//' + window.location.host + '/';

    $('.form-horizontal').bootstrapValidator({
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        }
    });
    
    $('#confirm-delete').on('show.bs.modal', function (e) {
        $(this).find('.danger').attr('href', $(e.relatedTarget).data('href'));
    });
    
    $('.connectedSortable').sortable({
        placeholder: "sort-highlight",
        connectWith: ".connectedSortable",
        handle: ".box-header, .nav-tabs",
        forcePlaceholderSize: true,
        zIndex: 999999
    });
    
    $('.connectedSortable .box-header, .connectedSortable .nav-tabs-custom').css('cursor', 'move');
    $('.quick-form').hide();
    $('tr.tr').each(function () {
        var id = $(this).data('key');
        $(this).mouseover(function () {
            $('#qe-' + id).css('visibility', 'visible');
        }).mouseleave(function () {
            $('#qe-' + id).css('visibility', 'hidden');
        });
        $('#qt-' + id).click(function (e) {
            e.preventDefault();
            $('#qf-' + id).fadeIn();
        });
        $('#cqe-' + id).click(function () {
            $('#qf-' + id).fadeOut();
        });
    });
    
    setInterval(function () {
        $('.alert').fadeOut();
    }, 3000);
})(jQuery);