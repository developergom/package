$(document).ready(function(){

	/**DataTables Test**/
    var tableDataTest = [];
    function getTableData(datas) {
        var data = '';
        var i = 0;
        for(property in datas) {
            data += '&'+datas[i]['name']+'='+datas[i]['value'];
            i++;
        }
        return data;
    }
    
    $(".testDataTable").dataTable({
        "bSort": true,
        "sDom": 'fCl<"clear">rtip',
        "aoColumns": [{ sClass: "text-left" },{ sClass: "text-center" },{ sClass: "text-left" },{ sClass: "text-right" }], //fungsi sorting data table
        "oLanguage": {
            sProcessing: "Processing . . ."
        },
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": $('base').attr('href')+"sso/test/list_json",
        "fnServerData": function( sUrl, aaData, fnCallback, oSettings ) {
            tableDataTest['testDataTable'] = aaData;
            oSettings.jqXHR = $.ajax({
                "url": sUrl,
                "data": aaData,
                "success": fnCallback,
                "dataType": "jsonp",
                "cache": false
            });
        },
        "fnCreatedRow": function(nRow,aData,iDataIndex){
            if(aData[4] == '1'){
                $(nRow).addClass('tr');
            }else{
                $(nRow).addClass('tr danger');
            }
            $(nRow).attr('data-key',aData[5]);
        },
        "fnDrawCallback": function(oSettings){
            $('.quick-form').hide();

            $('tr.tr').each(function() {
                $('.action').css('visibility', 'hidden');
                var id = $(this).data('key');
                $(this).mouseover(function() {
                    $('#qe-' + id).css('visibility', 'visible');
                }).mouseleave(function() {
                    $('#qe-' + id).css('visibility', 'hidden');
                });

                $('#qt-' + id).click(function(e) {
                    e.preventDefault();
                    $('#qf-' + id).fadeIn();
                });
                
                $('#cqe-' + id).click(function() {
                    $('#qf-' + id).fadeOut();
                });
            });
        }
    });
});