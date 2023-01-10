/* ------------------------------------------------------------------------------
 *
 *  # Buttons extension for Datatables. Excel examples
 *
 *  Demo JS code for datatable_extension_buttons_excel.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const DatatableButtonsExcel = function() {


    //
    // Setup module components
    //

    // Basic Datatable examples
    const _componentDatatableButtonsExcel = function() {
        if (!$().DataTable) {
            console.warn('Warning - datatables.min.js is not loaded.');
            return;
        }

        // Setting datatable defaults
        $.extend( $.fn.dataTable.defaults, {
            autoWidth: false,
            dom: '<"datatable-header justify-content-start"f<"ms-sm-auto"l><"ms-sm-3"B>><"datatable-scroll-wrap"t><"datatable-footer"ip>',
            language: {
                search: '<span class="me-3">Filter:</span> <div class="form-control-feedback form-control-feedback-end flex-fill">_INPUT_<div class="form-control-feedback-icon"><i class="ph-magnifying-glass opacity-50"></i></div></div>',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span class="me-3">Show:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': document.dir == "rtl" ? '&larr;' : '&rarr;', 'previous': document.dir == "rtl" ? '&rarr;' : '&larr;' }
            }
        });


        // Auto filter
        $('.datatable-excel-filter').DataTable({
            buttons: {
                dom: {
                    button: {
                        className: 'btn btn-light'
                    }
                },
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: 'Export to Excel <i class="ph-file-xls ms-2"></i>',
                        autoFilter: true,
                        sheetName: 'Exported data'
                    }
                ]
            }
        });


        // Bold text
        $('.datatable-excel-bold').DataTable({
            buttons: {
                dom: {
                    button: {
                        className: 'btn btn-light'
                    }
                },
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: 'Export to Excel <i class="ph-file-xls ms-2"></i>',
                        customize: function( xlsx ) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
             
                            $('row c[r^="C"]', sheet).attr( 's', '2' );
                        }
                    }
                ]
            }
        });


        // Cell background
        $('.datatable-excel-background').DataTable({
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: 'Export to Excel <i class="ph-file-xls ms-2"></i>',
                    customize: function(xlsx) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
         
                        // Loop over the cells in column `C`
                        $('row c[r^="C"]', sheet).each( function () {
                            // Get the value
                            if ( $('is t', this).text() == 'New York' ) {
                                $(this).attr( 's', '20' );
                            }
                        });
                    }
                }
            ]
        });


        // Customize borders
        $('.datatable-excel-borders').DataTable({
            buttons: {
                dom: {
                    button: {
                        className: 'btn btn-light'
                    }
                },
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: 'Export to Excel <i class="ph-file-xls ms-2"></i>',
                        customize: function ( xlsx ){
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
             
                            // jQuery selector to add a border
                            $('row c[r*="10"]', sheet).attr( 's', '25' );
                        }
                    }
                ]
            }
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentDatatableButtonsExcel();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    DatatableButtonsExcel.init();
});
