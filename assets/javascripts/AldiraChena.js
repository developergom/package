
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
            var container = $('<div/>', {class: 'container'}).append($('<div/>', {class: 'row'}).append($('<div/>', {class: 'col-lg-12'})).append(progressWrapper));
            progressWrapper.append(progressBar);
            //container.prependTo('body');
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


$('.thumbnail').hover(function () {
    $(this).find('.caption').slideDown(250);
}, function () {
    $(this).find('.caption').slideUp(250);
}); 