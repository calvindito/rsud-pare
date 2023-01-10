/* ------------------------------------------------------------------------------
 *
 *  # Select extension for Datatables
 *
 *  Demo JS code for datatable_extension_select.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const DatatableSelect = function() {


    //
    // Setup module components
    //

    // Basic Datatable examples
    const _componentDatatableSelect = function() {
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
            dom: '<"datatable-header"fl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
            language: {
                search: '<span class="me-3">Filter:</span> <div class="form-control-feedback form-control-feedback-end flex-fill">_INPUT_<div class="form-control-feedback-icon"><i class="ph-magnifying-glass opacity-50"></i></div></div>',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span class="me-3">Show:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': document.dir == "rtl" ? '&larr;' : '&rarr;', 'previous': document.dir == "rtl" ? '&rarr;' : '&larr;' }
            }
        });


        // Basic initialization
        $('.datatable-select-basic').DataTable({
            select: true
        });


        // Single item selection
        $('.datatable-select-single').DataTable({
            select: {
                style: 'single'
            }
        });


        // Multiple items selection
        $('.datatable-select-multiple').DataTable({
            select: {
                style: 'multi'
            }
        });


        // Checkbox selection
        $('.datatable-select-checkbox').DataTable({
            columnDefs: [
                {
                    orderable: false,
                    className: 'select-checkbox',
                    targets: 0
                },
                {
                    orderable: false,
                    width: 100,
                    targets: 6
                }
            ],
            select: {
                style: 'os',
                selector: 'td:first-child'
            },
            order: [[1, 'asc']]
        });


        // Buttons
        $('.datatable-select-buttons').DataTable({
            dom: '<"dt-buttons-full"B><"datatable-header"fl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
            buttons: [
                {extend: 'selected', className: 'btn btn-light'},
                {extend: 'selectedSingle', className: 'btn btn-light'},
                {extend: 'selectAll', className: 'btn btn-primary'},
                {extend: 'selectNone', className: 'btn btn-primary'},
                {extend: 'selectRows', className: 'btn btn-teal'},
                {extend: 'selectColumns', className: 'btn btn-teal'},
                {extend: 'selectCells', className: 'btn btn-teal'}
            ],
            select: true
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentDatatableSelect();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    DatatableSelect.init();
});
