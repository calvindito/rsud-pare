/* ------------------------------------------------------------------------------
 *
 *  # Buttons extension for Datatables. Print examples
 *
 *  Demo JS code for datatable_extension_buttons_print.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const DatatableButtonsPrint = function() {


    //
    // Setup module components
    //

    // Basic Datatable examples
    const _componentDatatableButtonsPrint = function() {
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


        // Basic initialization
        $('.datatable-button-print-basic').DataTable({
            buttons: [
                {
                    extend: 'print',
                    text: '<i class="ph-printer me-2"></i> Print table',
                    className: 'btn btn-primary'
                }
            ]
        });


        // Disable auto print
        $('.datatable-button-print-disable').DataTable({
            buttons: [
                {
                    extend: 'print',
                    text: '<i class="ph-printer me-2"></i> Print table',
                    className: 'btn btn-primary',
                    autoPrint: false
                }
            ]
        });


        // Export options - column selector
        $('.datatable-button-print-columns').DataTable({
            columnDefs: [{
                targets: -1, // Hide actions column
                visible: false
            }],
            buttons: [
                {
                    extend: 'print',
                    text: '<i class="ph-printer me-2"></i> Print table',
                    className: 'btn btn-light',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'colvis',
                    text: '<i class="ph-list"></i>',
                    className: 'btn btn-light btn-icon dropdown-toggle'
                }
            ]
        });


        // Export options - row selector
        $('.datatable-button-print-rows').DataTable({
            buttons: {
                buttons: [
                    {
                        extend: 'print',
                        className: 'btn btn-light',
                        text: '<i class="ph-printer me-2"></i> Print all'
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-light',
                        text: '<i class="ph-check me-2"></i> Print selected',
                        exportOptions: {
                            modifier: {
                                selected: true
                            }
                        }
                    }
                ],
            },
            select: true
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentDatatableButtonsPrint();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    DatatableButtonsPrint.init();
});
