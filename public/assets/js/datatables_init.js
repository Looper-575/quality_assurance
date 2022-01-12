$(document).ready(function () {
    $('.datatable').DataTable( {
        stateSave: true,
        initComplete: function () {
            this.api().columns().every( function () {
                if(this.data().unique()[0].toLowerCase().search('div') != -1 || this.data().unique()[0].toLowerCase().search('<a') != -1){
                } else {
                    let column = this;
                    let select = $('<select CLASS="form-control"><option value="">All</option></select>')
                        .appendTo( $(column.footer()).empty() )
                        .on( 'change', function () {
                            let val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
                            column.search( val ? '^'+val+'$' : '', true, false ).draw();
                        } );

                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                }
            } );
        }
    } );
});
