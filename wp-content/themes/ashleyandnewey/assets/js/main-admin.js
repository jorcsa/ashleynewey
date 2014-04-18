$(document).ready(function() {

    var aurl = "/wp-content/themes/ashleyandnewey/assets/ajax/";

    $('body').addClass('ex_highlight_row');

    var rTable = $('#reservation-table').dataTable( {
        "sPaginationType": "full_numbers",
        'bScrollCollapse': false,
        'bPaginate': true,
        'bStateSave': false,
        "sDom": 'CT<"clear">lfrtip',
        "aaSorting": [[4, 'desc']],
        "oTableTools": {
            "sSwfPath": "/wp-content/themes/ashleyandnewey/assets/swf/copy_csv_xls_pdf.swf",
            "sRowSelect": "multi",
            "aButtons": [
                {
                    "sExtends": "pdf",
                    "sButtonText": "PDF",
                    "mColumns": [ 0, 1, 2, 3, 4 ],
                    "sFileName": "A&N_reservations.pdf",
                    'sTitle': 'A&N reservations'
                },
                {
                    "sExtends": "xls",
                    "sButtonText": "Excel",
                    "mColumns": [ 0, 1, 2, 3, 4 ],
                    "sFileName": "A&N_reservations.xls"
                },
                {
                    "sExtends": "pdf",
                    "sButtonText": "PDF (selected)",
                    "bSelectedOnly": "true",
                    "mColumns": [ 0, 1, 2, 3, 4 ],
                    "sFileName": "A&N_reservations.pdf",
                    'sTitle': 'A&N reservations'
                },
                {
                    "sExtends": "xls",
                    "sButtonText": "Excel (selected)",
                    "bSelectedOnly": "true",
                    "mColumns": [ 0, 1, 2, 3, 4 ],
                    "sFileName": "A&N_reservations.xls"
                },
                {
                    "sExtends": "pdf",
                    "sButtonText": "PDF (visible)",
                    "bSelectedOnly": "true",
                    "mColumns": "visible",
                    "sFileName": "A&N_reservations.pdf",
                    'sTitle': 'A&N reservations'
                },
                {
                    "sExtends": "xls",
                    "sButtonText": "Excel (visible)",
                    "bSelectedOnly": "true",
                    "mColumns": "visible",
                    "sFileName": "A&N_reservations.xls"
                }
            ]
        }
    } );




/*
	$("#rTable .confirmation", rTable.fnGetNodes()).each(function(){
	    $(this).on("click", function(){
	        var thise = $(this);
	        var id = $(this).data('id');
	        var values = { id : id };
			$(thise).parent().html();
	
	        $.ajax({
	            type: "POST",
	            url:  aurl + "reserve-confirmation.php",
	            data: values,
	            cache: false,
	            success: function(){
	                $(thise).parent().html('');
	            }
	        });
	  
	        return false;
	    });
    });

*/

    $("body").on( "click", "#rTable .confirmation", function(){
        var thise = $(this);
        var id = $(this).data('id');
        var values = { id : id };
		$(thise).parent().html();

        $.ajax({
            type: "POST",
            url:  aurl + "reserve-confirmation.php",
            data: values,
            cache: false,
            success: function(){
                $(thise).parent().html('');
            }
        });
  
        return false;
    });

    $("body").on( "click", "#rTable .delete", function(){
        var thise = $(this);
        var id = $(this).data('id');
        var values = { id : id };
        $.ajax({
            type: "POST",
            url:  aurl + "reserve-delete.php",
            data: values,
            cache: false,
            success: function(){
                rTable.fnDeleteRow( $('tr[data-id="'+id+'"]')[0] );
            }
        });
        return false;
    });

    var uTable = $('#useractivity-table').dataTable( {
        "sPaginationType": "full_numbers",
        'bScrollCollapse': false,
        'bPaginate': true,
        'bStateSave': false,
        "aaSorting": [[0, 'desc']]
    });

} );

function conf(message){
    var answer = confirm(message)
    if (answer){
        return false;
    }
    return false;
}