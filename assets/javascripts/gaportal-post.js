(function ($) {

    $('#gallery').prepend('<div class="gallery" />');
    $.get(base_url + 'gaportal/media/browse', function (data) {
        $('.gallery').html(data);
    });

    $('input[name="media"]').blur(function () {
        var url = $(this).val();
        if (url === '') {
            $(this).parent('div').prepend('<p class="alert alert-danger alert-sm">Please enter image url</p>').fadeIn('slow');
            return false;
        } else {

            $.ajax({
                url: base_url + 'gaportal/media/upload_from_url',
                type: 'POST',
                data: {
                    file: url
                },
                success: function (data) {
                    console.log(data);
                }

            });
            //$(this).css('visibility', 'hidden');

//            var img = $('<img/>', {
//                src: url,
//                class: "img-responsive"
//            });
//
//            parent.prepend(img);
        }

    });

})(jQuery);