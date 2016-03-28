
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
            backdrop.fadeOut();
            switch (err) {
                case 'BrowserNotSupported':
                    showMessage('Your browser does not support HTML5 file uploads!');
                    break;
                case 'TooManyFiles':
                    showMessage('Too many files! Please select 5 at most! (configurable)');
                    break;
                case 'FileTooLarge':
                    showMessage(file.name + ' is too large! Please upload files up to 2mb (configurable).');
                    break;
                default:
                    break;
            }
        },
        progressUpdated: function (i, file, progress) {
            var progressBar = $('<div/>', {class: 'progress-bar progress-bar-striped', role: 'progressbar'}).html('<span>' + progress + '</span>');
            var progressWrapper = $('<div/>', {class: 'progress progress-lg'});
            var container = $('<div/>', {class: 'container'}).append($('<div/>', {class: 'row'}).append($('<div/>', {class: 'col-lg-12'})).append(progressWrapper));
            progressWrapper.append(progressBar);
            container.prependTo('body');
        },
        uploadFinished: function (i, file, response, time) {
            backdrop.fadeOut();
            window.location.href = base_url + 'gaportal/media/';
        }
    });
    var showMessage = function (msg) {
        var message = $('<div/>', {class: 'alert alert-warning alert-dismissable fade in', role: 'alert'})
                .append($('<button/>', {class: 'close', 'aria-label': 'Close', 'data-dismiss': 'alert', type: 'button'})
                        .append('<span aria-hidden="true">&times;</span>'))
                .html('<strong>Oh Snap!</strong>' + msg);
        $t.prepend(message);
    };
});
$('#media-detail').on('show.bs.modal', function (event) {
    var modal = $(this);
    var media_id = $(event.relatedTarget).data('media');
    var overlay = $('<div/>', {class: 'overlay'}).append($('<div/>', {class: 'fa fa refresh fa-spin'}));
    $.ajax({
        url: 'gaportal/media/detail/',
        type: 'POST',
        dataType: 'json',
        data: {'media_id': media_id},
        beforeSend: function () {
            $('div.media-info > div[class^=media-]').empty();
            modal.find('.modal-body').append(overlay);
        },
        success: function (response) {
            modal.find('.overlay').remove();
            modal.find('img.img-responsive').attr('src', response.media_url);
            var list = $('<ul/>', {class: 'list-unstyled small'});
            list.append('<li><strong>File name: </strong>' + response.media_filename + '</li>');
            list.append('<li><strong>File type: </strong>' + response.media_mime + '</li>');
            list.append('<li><strong>Upload on: </strong>' + response.create_when.substr(0, response.create_when.length - 14) + '</li>');
            list.append('<li><strong>File size: </strong>' + Humanize.fileSize(response.media_filesize) + '</li>');
            if (response.media_is_image)
                list.append('<li><strong>Dimension: </strong>' + response.media_dimension + '</li>');
            
            var media_setting = $('div.media-setting');
            media_setting.prepend($('<p/>', {class: 'text-center hidden preloader'}).append('<i class="fa fa-spinner fa-pulse fa-lg"></i>'));
            media_setting.append($('<div/>', {class: 'form-group'}).append('<label>URL</label><input type="text" name="media_url" readonly class="form-control input-sm" value="' + base_url + response.media_url.substring(2, response.media_url.length) + '">'));
            media_setting.append($('<div/>', {class: 'form-group'}).append('<label>Title</label><input type="text" data-primary-key="' + response.media_id + '" name="media_title" class="form-control input-sm" value="' + response.media_title + '">'));
            media_setting.append($('<div/>', {class: 'form-group'}).append('<label>Description</label><textarea data-primary-key="' + response.media_id + '" name="media_description" class="form-control input-sm">' + response.media_description + '</textarea>'));
            media_setting.append($('<div/>', {class: 'form-group'}).append('<label>Alt Text</label><input type="text" data-primary-key="' + response.media_id + '" name="media_alt_text" class="form-control input-sm" value="' + response.media_alt_text + '">'));
            $('div.media-details').prepend(list).append('<hr />');
            var formData = {};
            media_setting.find('.form-group > input[type="text"], .form-group > textarea').each(function () {
                $(this).on('blur', function () {
                    $('p.preloader').removeClass('hidden').addClass('show');
                    formData['media_id'] = $(this).data('primary-key');
                    formData[$(this).attr('name')] = $(this).val();
                    $.ajax({
                        url: 'gaportal/media/edit',
                        type: 'POST',
                        dataType: 'json',
                        data: formData,
                        success: function (resp) {
                            if (resp)
                                $('p.preloader').removeClass('show').addClass('hidden');
                        }
                    });
                });
            });
            modal.find('.modal-footer a').attr('data-href', base_url + 'gaportal/media/delete/' + response.media_id);
        }
    });
});

