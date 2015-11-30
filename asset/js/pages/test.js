$(document).ready(function(){

	generateServerSideDataTables(
        "dataTable",
        $('base').attr('href')+"sso/test/list_json",
        [{ sClass: "text-left" },{ sClass: "text-center" },{ sClass: "text-left" },{ sClass: "text-right" }],
        5,
        4
    );
    
});

