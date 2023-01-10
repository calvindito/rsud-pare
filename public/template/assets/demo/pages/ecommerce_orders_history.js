/* ------------------------------------------------------------------------------
 *
 *  # ECommerce - Orders history
 *
 *  Demo JS code for ecommerce_orders_history.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const EcommerceOrdersHistory = function() {


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
        const table = $('.table-orders-history').DataTable({
            autoWidth: false,
            columnDefs: [
                {
                    visible: false,
                    targets: 0
                },
                {
                    targets: 1,
                    width: 400
                },
                { 
                    orderable: false,
                    width: 16,
                    targets: 7
                }
            ],
            order: [[ 0, 'asc' ]],
            dom: '<"datatable-header justify-content-start"f<"ms-sm-auto"l><"ms-sm-3"B>><"datatable-scroll-wrap"t><"datatable-footer"ip>',
            language: {
                search: '<span class="me-3">Filter:</span> <div class="form-control-feedback form-control-feedback-end flex-fill">_INPUT_<div class="form-control-feedback-icon"><i class="ph-magnifying-glass opacity-50"></i></div></div>',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span class="me-3">Show:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': document.dir == "rtl" ? '&larr;' : '&rarr;', 'previous': document.dir == "rtl" ? '&rarr;' : '&larr;' }
            },
            lengthMenu: [ 25, 50, 75, 100 ],
            displayLength: 25,
            buttons: [
                {
                    extend: 'pdfHtml5',
                    text: 'Export to PDF <i class="ph-file-pdf ms-2"></i>',
                    className: 'btn btn-light',
                    orientation: 'landscape',
                    exportOptions: {
                        columns: [ 1, 2, 3, 4, 5, 6 ],
                        stripHtml: true
                    },
                    customize: function (doc) {
                        doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                    }
                }
            ],
            drawCallback: function (settings) {
                var api = this.api();
                var rows = api.rows({ page: 'current' }).nodes();
                var last = null;
     
                api.column(0, { page: 'current' }).data().each(function(group, i) {
                    if (last !== group) {
                        $(rows).eq(i).before(
                            '<tr class="table-light group"><td colspan="8" class="fw-semibold">' + group + '</td></tr>'
                        );
     
                        last = group;
                    }
                });
            }
        });

        // Order by the grouping
        $('.table-orders-history tbody').on( 'click', 'tr.group', function() {
            var currentOrder = table.order()[0];
            if (currentOrder[0] === 0 && currentOrder[1] === 'asc') {
                table.order([0, 'desc']).draw();
            }
            else {
                table.order([0, 'asc']).draw();
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
    EcommerceOrdersHistory.init();
});
