/* ------------------------------------------------------------------------------
 *
 *  # Autofill extension for Datatables
 *
 *  Demo JS code for datatable_extension_autofill.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const DatatableAutofill = function() {


    //
    // Setup module components
    //

    // Basic Datatable examples
    const _componentDatatableAutofill = function() {
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
        $('.datatable-autofill-basic').DataTable({
            autoFill: true
        });


        // Always confirm action
        $('.datatable-autofill-confirm').DataTable({
            autoFill: {
                alwaysAsk: true
            },
        });


        // Click focus
        $('.datatable-autofill-click').DataTable({
            autoFill: {
                focus: 'click'
            }
        });


        // Column selector
        $('.datatable-autofill-column').DataTable( {
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
            order: [1, 'asc'],
            autoFill: {
                columns: ':not(:first-child):not(:last-child)'
            }
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentDatatableAutofill();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    DatatableAutofill.init();
});
