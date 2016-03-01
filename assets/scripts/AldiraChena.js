/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

(function ($) {

    $.fn.AldiraChena = function (opt) {

        var setting = $.fn.extend({
        }, opt);

        return this.each(function () {
            var t = this;
            var $t = $(this);
            var form_upload = '<input type="file" name="media" class="filestyle" data-input="true" data-buttonText="&nbsp;Banner&nbsp;" data-iconName="fa fa-cloud-upload" data-input="false" />';
            var wrapper = '<div class="col-center">' + form_upload + '</div>';

            $t.append('<div class="dropbox"><h3>Drop files anywhere to upload</h3><p>or</p>' + wrapper + '</div>');
        });

    };

})(jQuery);



$(function () {
    $('.AldiraChena').AldiraChena();
});