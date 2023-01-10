/* ------------------------------------------------------------------------------
 *
 *  # Reorder Columns extension for Datatables
 *
 *  Demo JS code for datatable_extension_reorder.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const DatatableColumnReorder = function() {


    //
    // Setup module components
    //

    // Basic Datatable examples
    const _componentDatatableColumnReorder = function() {
        if (!$().DataTable) {
            console.warn('Warning - datatables.min.js is not loaded.');
            return;
        }

        // Setting datatable defaults
        $.extend( $.fn.dataTable.defaults, {
            autoWidth: false,
            columnDefs: [{ 
                orderable: false,
                width: 100,
                targets: [ 5 ]
            }],
            colReorder: true,
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            language: {
                search: '<span class="me-3">Filter:</span> <div class="form-control-feedback form-control-feedback-end flex-fill">_INPUT_<div class="form-control-feedback-icon"><i class="ph-magnifying-glass opacity-50"></i></div></div>',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span class="me-3">Show:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': document.dir == "rtl" ? '&larr;' : '&rarr;', 'previous': document.dir == "rtl" ? '&rarr;' : '&larr;' }
            }
        });


        // Basic column reorder
        $('.datatable-reorder').DataTable();


        // Realtime updating
        $('.datatable-reorder-realtime').DataTable({
            colReorder: {
                realtime: false
            }
        });


        // Save state after reorder
        $('.datatable-reorder-state-saving').DataTable({
            stateSave: true
        });


        // Predefined column ordering
        $('.datatable-reorder-predefined').DataTable({
            colReorder: {
                order: [1, 3, 2, 4, 0, 5]
            }
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentDatatableColumnReorder();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    DatatableColumnReorder.init();
});
