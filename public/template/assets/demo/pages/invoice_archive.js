/* ------------------------------------------------------------------------------
 *
 *  # Invoice archive
 *
 *  Demo JS code for invoice_archive.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const InvoiceArchive = function() {


    //
    // Setup module components
    //

    // Datatable
    const _componentDatatable = function() {
        if (!$().DataTable) {
            console.warn('Warning - datatables.min.js is not loaded.');
            return;
        }

        // Initialize
        $('.invoice-archive').DataTable({
            autoWidth: false,
            columnDefs: [
                {
                    width: 30,
                    targets: 0
                },
                {
                    visible: false,
                    targets: 1
                },
                { 
                    orderable: false,
                    width: 120,
                    targets: 7
                },
                {
                    width: '15%',
                    targets: [4, 5]
                },
                {
                    width: '15%',
                    targets: 6
                },
                {
                    width: '15%',
                    targets: 3
                }
            ],
            order: [[ 0, 'desc' ]],
            dom: '<"datatable-header"fl><"datatable-scroll-lg"t><"datatable-footer"ip>',
            language: {
                search: '<span class="me-3">Filter:</span> <div class="form-control-feedback form-control-feedback-end flex-fill">_INPUT_<div class="form-control-feedback-icon"><i class="ph-magnifying-glass opacity-50"></i></div></div>',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span class="me-3">Show:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': document.dir == "rtl" ? '&larr;' : '&rarr;', 'previous': document.dir == "rtl" ? '&rarr;' : '&larr;' }
            },
            lengthMenu: [ 25, 50, 75, 100 ],
            displayLength: 25,
            drawCallback: function ( settings ) {
                const api = this.api();
                const rows = api.rows( {page:'current'} ).nodes();
                let last = null;
     
                api.column(1, {page:'current'} ).data().each( function ( group, i ) {
                    if ( last !== group ) {
                        $(rows).eq( i ).before(
                            '<tr class="table-light"><td colspan="8" class="fw-semibold">'+group+'</td></tr>'
                        );
     
                        last = group;
                    }
                });
            }
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentDatatable();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    InvoiceArchive.init();
});
