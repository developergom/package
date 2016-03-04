///* 
// * To change this license header, choose License Headers in Project Properties.
// * To change this template file, choose Tools | Templates
// * and open the template in the editor.
// */
//
//(function ($, window, undefined) {
//    var hasOnProgress = ('onprogress' in $.ajaxSettings.xhr());
//    if (hasOnProgress === false)
//        return;
//
//    var oldXHR = $.ajaxSettings.xhr;
//    $.ajaxSettings.xhr = function () {
//        var xhr = oldXHR();
//        if (xhr instanceof window.XMLHttpRequest)
//            xhr.addEventListener('progress', this.progress, false);
//
//        if (xhr.upload)
//            xhr.upload.addEventListener('progress', this.progress, false);
//
//        return xhr;
//    };
//})($, window);
//
//(function ($) {
//    $.event.props.push('dataTransfer');
//    $.fn.AldiraChena = function (opt) {
//        var setting = $.fn.extend({
//            url: base_url + 'media_upload/?files'
//        }, opt);
//
//        return this.each(function () {
//            var t = this;
//            var $t = $(this);
//            var container = $('<div/>', {class: 'container-fluid'});
//            var wrapper = $('<div/>', {class: 'dropbox'});
//            var form = $('<form/>', {enctype: 'multipart/form-data', action: setting.url});
//            var heading = $('<h3/>', {class: 'text-center'}).html('Drop files anywhere to upload');
//            var p = $('<p/>', {class: 'text-center'}).html('or');
//            var inputFile = $('<input/>', {type: 'file', class: 'col-center', name: 'upload_media[]', multiple: 'multiple'});
//            var progressBar = $('<div/>', {class: 'progress-bar progress-bar-striped', role: 'progressbar'});
//            var progressBarWrapper = $('<div/>', {class: 'row'}).prepend($('<div/>', {class: 'col-lg-offset-1 col-lg-10'}).append($('<div/>', {class: 'progress progress-lg'}).append(progressBar)));
//
//            heading.appendTo(form);
//            p.appendTo(form);
//            inputFile.appendTo(form);
//            container.append(wrapper.append(form));
//            wrapper.append(progressBarWrapper);
//            $t.append(container);
//
//            $.event.props.push('dataTransfer');
//            $t.on({
//                dragover: function (e) {
//                    e.preventDefault();
//                    e.stopPropagation();
//                    $(this).css('background-color', 'lightblue');
//                },
//                dragleave: function (e) {
//                    e.preventDefault();
//                    e.stopPropagation();
//                    $(this).css('background-color', 'white');
//                },
//                drop: function (e) {
//                    e.preventDefault();
//                    e.stopPropagation();
//
//                    var file = e.dataTransfer.files[0];
//                    var fileReader = new FileReader();
//
//                    var this_obj = $(this);
//                    fileReader.onload = (function (file) {
//                        return function (event) {
////                            filename = file.name;
////                            image_data = event.target.result;
//                            // Preview
//                            $(this_obj).next().html('<a href="#" class="upload-file">Upload file</a>');
//                            $(this_obj).html('<img style="max-width: 200px; max-height: 200px;" src="' + event.target.result + '">');
//                        };
//                    })(file);
//
//                    fileReader.readAsDataURL(file);
//                    form.submitUpload();
//                }
//            });
//
//            $t.find('input[type="file"]').on('change', function () {
//                var files;
//                $('input[type=file]').on('change', function (e) {
//                    files = e.target.files;
//                });
//
//                var data = new FormData();
//                $.each(files, function (k, v) {
//                    data.append(k, v);
//                });
//
//                $.ajax({
//                    url: $t.find('form').attr('action'),
//                    type: 'POST',
//                    cache: false,
//                    dataType: 'json',
//                    processData: false,
//                    contentType: false,
//                    data: data,
//                    progress: function (e) {
//                        if (e.lengthComputable) {
//                            var precision = e.loaded / e.total * 100;
//                            var progress = $('.progress-bar');
//                            progress.toggleClass('active', precision < 100);
//                            progress.css({
//                                width: precision = precision.toPrecision(3) + '%'
//                            }).html('<span>' + precision + ' complete</span>');
//                        } else {
//                            console.warn('content length not reported');
//                        }
//                    },
//                    success: function (data, textStatus, jqXHR) {
//                        console.log('success');
//                    },
//                    error: function (event) {
//                        console.log(event);
//                    }
//                });
//            });
//        });
//    };
//
//    $.fn.submitUpload = function () {
//        return this.each(function () {
//            var files;
//            $('input[type=file]').on('change', function (e) {
//                files = e.target.files;
//            });
//
//            $(this).on('submit', function (e) {
//                e.stopPropagation();
//                e.preventDefault();
//
//                var data = new FormData();
//                $.each(files, function (k, v) {
//                    data.append(k, v);
//                });
//
//                $.ajax({
//                    url: $(this).attr('action'),
//                    type: 'POST',
//                    cache: false,
//                    dataType: 'json',
//                    processData: false,
//                    contentType: false,
//                    data: data,
//                    progress: function (e) {
//                        if (e.lengthComputable) {
//                            var precision = e.loaded / e.total * 100;
//                            var progress = $('#progress');
//                            progress.toggleClass('active', precision < 100);
//                            progress.css({
//                                width: precision = precision.toPrecision(3) + '%'
//                            }).html('<span>' + precision + '</span>');
//                        } else {
//                            console.warn('content length not reported');
//                        }
//                    },
//                    success: function (data, textStatus, jqXHR) {
//                        console.log(data);
//                    },
//                    error: function (event) {
//                        console.log(event);
//                    }
//                });
//            });
//        });
//    };
//
//})(jQuery);

$(document).ready(function () {

    var $t = $('.AldiraChena');
    var heading = $('<h3/>', {class: 'text-center'}).html('Drop files anywhere to upload');
    var backdrop = $('<div/>', {class: 'modal-backdrop fade in'});

    $t.append(heading);
    $t.filedrop({
        paramname: 'upload_media',
        maxfiles: 5,
        maxfilesize: 2,
        url: 'gaportal/media/upload/',
        dragOver: function () {
            $t.css({background: 'lightblue'});
        },
        dragLeave: function () {
            $t.css({background: 'white'});
        },
        drop: function () {
            $t.css({background: 'white'});
            backdrop.appendTo('body');
        },
        error: function (err, file) {
            switch (err) {
                case 'BrowserNotSupported':
                    alert('Your browser does not support HTML5 file uploads!');
                    break;
                case 'TooManyFiles':
                    alert('Too many files! Please select 5 at most! (configurable)');
                    break;
                case 'FileTooLarge':
                    alert(file.name + ' is too large! Please upload files up to 2mb (configurable).');
                    break;
                default:
                    break;
            }
            backdrop.fadeOut();
        },
        progressUpdated: function (i, file, progress) {
            var progressBar = $('<div/>', {class: 'progress-bar progress-bar-striped', role: 'progressbar'}).html('<span>' + progress + '</span>');
            var progressWrapper = $('<div/>', {class: 'progress progress-lg'});
            var container = $('<div/>', {class: 'container'}).append($('<div/>', {class: 'row'}). append($('<div/>', {class: 'col-lg-12'})).append(progressWrapper));
            progressWrapper.append(progressBar);
            container.prependTo('body');
        },
        uploadFinished: function (i, file, response, time) {
            backdrop.fadeOut();
            window.location.href = base_url + 'gaportal/media/';
        }
    });

    var showMessage = function (msg) {

    };

});

$(document).on('show.bs.modal', '.modal', function () {
    var zIndex = 1040 + (10 * $('.modal:visible').length);
    $(this).css('z-index', zIndex);
    setTimeout(function () {
        $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
    }, 0);
});