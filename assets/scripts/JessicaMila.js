(function ($) {

    $.fn.JessicaMila = function (opt) {
        var setting = $.fn.extend({
        }, opt);

        return this.each(function () {
            var t = this;
            var $t = $(this);

            $t.dataTable({
                select: true,
                fixedHeader: true,
                pagingType: 'simple_numbers',
                //dom: '<"input-group"f>',
                language: {
                    paginate: {
                        first: '<span class="fa fa-angle-double-left"></span>',
                        next: '<span class="fa fa-angle-right"></span>',
                        previous: '<span class="fa fa-angle-left"></span>',
                        last: '<span class="fa fa-angle-double-right"></span>'
                    },
                    decimal: '',
                    emptyTable: 'No data available in table',
                    info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                    infoEmpty: 'Showing 0 to 0 of 0 entries',
                    infoFiltered: '(filtered from _MAX_ total entries)',
                    infoPostFix: '',
                    thousands: ',',
                    lengthMenu: 'Show &nbsp; _MENU_',
                    loadingRecords: 'Loading...',
                    processing: '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>',
                    search: '_INPUT_',
                    searchPlaceholder: 'Search...',
                    zeroRecords: 'No matching records found'
                },
                processing: true,
                serverSide: true,
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: true,
                ajax: {
                    url: $t.data('url'),
                    type: 'POST'
                }
            });
        });
    };

}(jQuery));

$(function () {
    $('.dataTable').JessicaMila();
});