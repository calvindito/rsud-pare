/* ------------------------------------------------------------------------------
 *
 *  # Responsive extension for Datatables
 *
 *  Demo JS code for datatable_responsive.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const DatatableResponsive = function() {


    //
    // Setup module components
    //

    // Basic Datatable examples
    const _componentDatatableResponsive = function() {
        if (!$().DataTable) {
            console.warn('Warning - datatables.min.js is not loaded.');
            return;
        }

        // Setting datatable defaults
        $.extend( $.fn.dataTable.defaults, {
            autoWidth: false,
            responsive: true,
            columnDefs: [{ 
                orderable: false,
                width: 100,
                targets: [ 5 ]
            }],
            dom: '<"datatable-header"fl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
            language: {
                search: '<span class="me-3">Filter:</span> <div class="form-control-feedback form-control-feedback-end flex-fill">_INPUT_<div class="form-control-feedback-icon"><i class="ph-magnifying-glass opacity-50"></i></div></div>',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span class="me-3">Show:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': document.dir == "rtl" ? '&larr;' : '&rarr;', 'previous': document.dir == "rtl" ? '&rarr;' : '&larr;' }
            }
        });


        // Basic responsive configuration
        $('.datatable-responsive').DataTable();


        // Column controlled child rows
        $('.datatable-responsive-column-controlled').DataTable({
            responsive: {
                details: {
                    type: 'column'
                }
            },
            columnDefs: [
                {
                    className: 'control',
                    orderable: false,
                    targets:   0
                },
                { 
                    width: 100,
                    targets: 6
                },
                { 
                    orderable: false,
                    targets: 6
                }
            ],
            order: [1, 'asc']
        });


        // Control position
        $('.datatable-responsive-control-right').DataTable({
            responsive: {
                details: {
                    type: 'column',
                    target: -1
                }
            },
            columnDefs: [
                {
                    className: 'control',
                    orderable: false,
                    targets: -1
                },
                { 
                    width: 100,
                    targets: [5]
                },
                { 
                    orderable: false,
                    targets: [5]
                }
            ]
        });


        // Whole row as a control
        $('.datatable-responsive-row-control').DataTable({
            responsive: {
                details: {
                    type: 'column',
                    target: 'tr'
                }
            },
            columnDefs: [
                {
                    className: 'control',
                    orderable: false,
                    targets:   0
                },
                { 
                    width: 100,
                    targets: 6
                },
                { 
                    orderable: false,
                    targets: 6
                }
            ],
            order: [1, 'asc']
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentDatatableResponsive();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    DatatableResponsive.init();
});
