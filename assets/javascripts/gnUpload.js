/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


(function ($) {

    var __t = this;
    __t.allowedFiletype = [
        'text/plain',
        'image/jpeg', 'image/png', 'image/gif',
        'application/pdf',
        'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/x-rar', 'application/x-gzip', 'application/x-zip'
    ];

    $.fn.gnUpload = function (opt) {
        var setting = $.fn.extend({
            url: 'media_upload/',
            paramName: 'upload',
            maxFiles: 5,
            maxFilesize: 2,
            allowedFiletype: __t.allowedFiletype
        }, opt);

        return this.each(function () {
            //var t = this;
            var $t = $(this);
            var wrapper = $('<div/>', {class: 'row'});
            //var wrapper = $('<div/>', {class: 'row'}).append($('<div/>', {class: 'col-sm-offset-1 col-sm-10 col-lg-offset-1 col-lg-10'}));
            var heading = $('<h3/>').html('Drop files anywhere to upload');
            //var fileInput = $('<input/>', {type: 'file', multiple: 'multiple', class: 'filestyle', name: setting.paramName});
            //var backdrop = $('<div/>', {class: 'modal-backdrop fade in'});

            var progressWrapper = $('<div/>', {class: 'progress progress-lg active'});
            var progressBar = $('<div/>', {class: 'progress-bar progress-bar-primary progress-bar-striped'});
            
            var message = $('<div/>', {class: 'alert alert-warning alert-dismissable fade in', role: 'alert'}).append($('<button/>', {class: 'close', 'aria-label': 'Close', 'data-dismiss': 'alert', type: 'button'}).append('<span aria-hidden="true">&times;</span>'));
            progressWrapper.append(progressBar);
            //$t.append(heading).append($('<p/>').html('or')).append($('<div/>', {class: 'row'}).append($('<div/>', {class: 'col-lg-4 col-lg-offset-4'}).append(fileInput)));
            $t.append(heading);

            $t.filedrop({
                paramname: setting.paramName,
                maxfiles: setting.maxFiles,
                maxfilesize: setting.maxFilesize,
                allowedfiletypes: setting.allowedFiletype,
                url: setting.url,
                dragOver: function () {
                    $t.css({background: 'lightblue'});
                },
                dragLeave: function () {
                    $t.css({background: 'white'});
                },
                drop: function () {
                    $t.css({background: 'white'});
                    
                    //backdrop.appendTo('body').fadeIn();
                },
                uploadFinished: function (i, file, response, time) {
                    window.location.href = response;
                    //backdrop.fadeOut();
                },
                error: function (err, file) {
                    //backdrop.fadeOut();
                    switch (err) {
                        case 'BrowserNotSupported':
                            showMessage('Your browser does not support HTML5 file uploads');
                            break;
                        case 'TooManyFiles':
                            showMessage('Too many files, please select 5 at most');
                            break;
                        case 'FileTooLarge':
                            showMessage('The filetype you are attempting to upload is too large, please upload files up to 2MB.');
                            break;
                        case 'FileTypeNotAllowed':
                            showMessage('The filetype you are attempting to upload is not allowed');
                            break;
                        default:
                            break;
                    }
                },
                globalProgressUpdated: function (progress) {
                    $t.prepend(wrapper.append($('<div/>', {class: 'col-sm-offset-1 col-sm-10 col-lg-offset-1 col-lg-10'}).append(progressBar.html('<span>' + progress + '%</span>').width(progress + '%'))));
                }
            });

//            $('input[type="file"].filestyle').change(function () {
//                var formData = new FormData();
//                formData.append(setting.paramName, $(this).prop(setting.paramName));
//                $.ajax({
//                    url: setting.url,
//                    dataType: 'json',
//                    type: 'POST',
//                    data: new FormData(this),
//                    success: function (response) {
//                        console.log(response);
//                    }
//                });
//                $t.prepend(progressWrapper).fadeIn('slow');
//            });

//            $('input[type="file"].filestyle').filestyle({
//                input: false,
//                buttonText: '&nbsp;Select file&nbsp;',
//                buttonName: 'btn-primary',
//                size: 'lg',
//                iconName: 'fa fa-cloud-upload'
//            });

            var showMessage = function (msg) {
                $t.prepend(wrapper.append($('<div/>', {class: 'col-sm-offset-1 col-sm-10 col-lg-offset-1 col-lg-10'}).append(message.append('<strong>Oh Snap!</strong>&nbsp;' + msg))));
            };
        });
    };

})(jQuery);