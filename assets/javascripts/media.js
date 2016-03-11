/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


(function () {

    $('#media-detail').on('show.bs.modal', function (e) {

        var modal = $(this);
        var media_id = $(e.relatedTarget).data('media');
        var overlay = $('<div/>', {class: 'overlay'}).append($('<div/>', {class: 'fa fa refresh fa-spin'}));
        var spinner = $('<p/>', {class: 'text-center hidden preloader'}).append('<i class="fa fa-spinner fa-pulse fa-lg"></i>');
        
        //modal.find('.media-details').append(spinner);
        $.ajax({
            url: 'gaportal/media/detail/',
            type: 'POST',
            dataType: 'json',
            data: {'media_id': media_id},
            beforeSend: function () {
                $('div.media-info > div[class^=media]').empty();
                //modal.find('.modal-body').append(overlay);
            },
            success: function (response) {
                //modal.find('.overlay').remove();
                modal.find('img.img-responsive').attr('src', response.media_is_image ? response.media_url : thumbFiletype(response.media_mime));

                var list = $('<ul/>', {class: 'list-unstyled small'});
                list.append('<li><strong>File name: </strong>' + response.media_filename + '</li>');
                list.append('<li><strong>File type: </strong>' + response.media_mime + '</li>');
                list.append('<li><strong>Upload on: </strong>' + response.create_when.substr(0, response.create_when.length - 14) + '</li>');
                list.append('<li><strong>File size: </strong>' + Humanize.fileSize(response.media_filesize) + '</li>');
                if (response.media_is_image)
                    list.append('<li><strong>Dimension: </strong>' + response.media_dimension + '</li>');

                var media_setting = $('div.media-setting');
                media_setting.prepend(spinner);
                media_setting.append($('<div/>', {class: 'form-group'}).append('<label>URL</label><input type="text" name="media_url" readonly class="form-control input-sm" value="' + base_url + response.media_url + '">'));
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
    
    $('#media-detail').on('hide.bs.modal', function(e) {
        location.reload();
    });

    var thumbFiletype = function (mime) {
        var thumbFiletype = null;
        switch (mime) {
            case 'text/plain':
                thumbFiletype = 'file-text-o';
                break;

            case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
            case 'application/vnd.ms-excel':
                thumbFiletype = 'file-excel-o';
                break;

            case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':
            case 'application/powerpoint' :
                thumbFiletype = 'file-powerpoint-o';
                break;

            case 'application/msword':
            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                thumbFiletype = 'file-word-o';
                break;

            case 'application/pdf':
                thumbFiletype = 'file-pdf-o';
                break;

            case 'application/x-rar':
            case 'application/x-gzip':
            case 'application/x-zip':
                thumbFiletype = 'file-zip-o';
                break;

            default:
                thumbFiletype = 'file-o';
        }

        return 'assets/images/file-type/' + thumbFiletype + '.png';
    };

})($);