$.widget.bridge('uibutton', $.ui.button);
"use strict";
$(document).ready(function () {
    //var base_url = window.location.protocol + '//' + window.location.host + '/package/';
    //var base_url = window.location.protocol + '//' + window.location.host + '/';


    setTimeout(function () {
        $('select').select2();
        $('.dataTables_filter').find('input').css('width', '200px');
        $('input[type="checkbox"]').iCheck({
            checkboxClass: 'icheckbox_flat-blue'
        });

        $('[data-mask]').inputmask();
        $('.datepicker').datepicker({
            format: 'yyyy/mm/dd'
        });
    }, 10);

    $('.form-horizontal').bootstrapValidator({
        feedbackIcons: {
            valid: 'fa fa-check',
            invalid: 'fa fa-remove',
            validating: 'fa fa-refresh fa-spin'
        }
    });

    $('#confirm-delete').on('show.bs.modal', function (e) {
        $(this).find('.delete').attr('href', $(e.relatedTarget).data('href'));
    });
//    $('#confirm-delete').on('show.bs.modal', function (e) {
//        if ($(e.relatedTarget).data('href') === 'submit') {
//            if ($('form.simplegrid').serializeArray().length <= 1) {
//                $(this).find('.modal-body > strong').html('Please check (<i class="fa fa-check"></i>) at least one data before deleting.');
//                $(this).find('.modal-footer > a').remove();
//                $(this).find('.modal-footer > button').text('Ok');
//            } else {
//                $(this).find('.delete').click(function (e) {
//                    $('form.simplegrid').submit();
//                    e.preventDefault();
//                });
//            }
//        } else {
//            $(this).find('.delete').attr('href', $(e.relatedTarget).data('href'));
//        }
//    });

    $('.connectedSortable').sortable({
        placeholder: 'sort-highlight',
        connectWith: '.connectedSortable',
        handle: '.box-header, .nav-tabs',
        forcePlaceholderSize: true,
        zIndex: 999999
    });

    $('.connectedSortable .box-header, .connectedSortable .nav-tabs-custom').css('cursor', 'move');

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

    $('#editor').Editor();
    $("button:submit").click(function () {
        $('#editor').text($('#editor').Editor("getText"));
    });

    $(":file").filestyle({input: false});

    setInterval(function () {
        $('.alert').fadeOut();
    }, 3000);


});