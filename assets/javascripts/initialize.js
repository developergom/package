$.widget.bridge('uibutton', $.ui.button);
"use strict";
$(document).ready(function () {
    setTimeout(function () {

        $('select').select2();
        $('.filestyle').filestyle();
        $('.dataTables_filter').find('input').css('width', '200px');
        $('input[type="checkbox"]').iCheck({
            checkboxClass: 'icheckbox_flat-blue'
        });

        //$('.AldiraChena').AldiraChena();
        /*$('.datepicker').datepicker({
         format: 'yyyy/mm/dd'
         });*/
    }, 10);

    $('.validate').bootstrapValidator({
        feedbackIcons: {
            valid: 'fa fa-check',
            invalid: 'fa fa-remove',
            validating: 'fa fa-refresh fa-spin'
        }
    });

    $('#confirm-delete').on('show.bs.modal', function (e) {
        $(this).find('.delete').attr('href', $(e.relatedTarget).data('href'));
    });

    $('.connectedSortable').sortable({
        placeholder: 'sort-highlight',
        connectWith: '.connectedSortable',
        handle: '.box-header, .nav-tabs',
        forcePlaceholderSize: true,
        zIndex: 999999
    });


    $('.connectedSortable .box-header, .connectedSortable .nav-tabs-custom').css('cursor', 'move');

    $('[data-toggle="tooltip"]').tooltip();

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



//    $(':file').filestyle({
//        input: false,
//        buttonText: "&nbsp;Add Media"
//    });


    setInterval(function () {
        $('.alert').fadeOut();
    }, 6000 * 5);

    $('.thumbnail').hover(function () {
        $(this).find('.caption').fadeIn(250);
    }, function () {
        $(this).find('.caption').fadeOut(250);
    });

    $('.gnUpload').gnUpload({
        url: base_url + 'gaportal/media/upload/',
        paramName: 'upload_media'
    });

    //$('#editor').wysihtml5();

//    $("button:submit").click(function () {
//        $('#editor').text($('#editor').Editor("getText"));
//    });

    $('#summernote').summernote({
        height: 300
    });
    $('[data-mask]').inputmask();
});

$(document).on('show.bs.modal', '.modal', function () {
    var zIndex = 1040 + (10 * $('.modal:visible').length);
    $(this).css('z-index', zIndex);
    setTimeout(function () {
        $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
    }, 0);
});