/*
* Use this function ti generate the server side datatables
* tableID = ID's tag name of the table
* tableURL = URL of a list of JSON data generated
* tableColumnSetting = setting to give a class for each column show
* indexIDColumn = index of column ID in JSON list
* indexActiveColumn = index of column Status in JSON list
*/
function generateServerSideDataTables(tableID,tableURL,tableColumnSetting,indexIDColumn,indexActiveColumn){
    var tableData = [];
    
    $('#'+tableID).dataTable({
        "bSort": true,
        "sDom": 'fCl<"clear">rtip',
        "aoColumns": tableColumnSetting, //fungsi sorting data table
        "oLanguage": {
            sProcessing: '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>'
        },
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": tableURL,
        "fnServerData": function( sUrl, aaData, fnCallback, oSettings ) {
            tableData[tableID] = aaData;
            oSettings.jqXHR = $.ajax({
                "url": sUrl,
                "data": aaData,
                "success": fnCallback,
                "dataType": "jsonp",
                "cache": false
            });
        },
        "fnCreatedRow": function(nRow,aData,iDataIndex){
            if(aData[indexActiveColumn] == '1'){
                $(nRow).addClass('tr');
            }else{
                $(nRow).addClass('tr danger');
            }
            $(nRow).attr('data-key',aData[indexIDColumn]);
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
}