/* ------------------------------------------------------------------------------
 *
 *  # Datatable sorting
 *
 *  Demo JS code for datatable_sorting.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const DatatableSorting = function() {


    //
    // Setup module components
    //

    // Basic Datatable examples
    const _componentDatatableSorting = function() {
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
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            language: {
                search: '<span class="me-3">Filter:</span> <div class="form-control-feedback form-control-feedback-end flex-fill">_INPUT_<div class="form-control-feedback-icon"><i class="ph-magnifying-glass opacity-50"></i></div></div>',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span class="me-3">Show:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': document.dir == "rtl" ? '&larr;' : '&rarr;', 'previous': document.dir == "rtl" ? '&rarr;' : '&larr;' }
            }
        });


        // Default ordering example
        $('.datatable-sorting').DataTable({
            order: [3, "desc"]
        });


        // Multi column ordering
        $('.datatable-multi-sorting').DataTable({
            columnDefs: [{
                targets: [0],
                orderData: [0, 1]
            }, {
                targets: [1],
                orderData: [1, 0]
            }, {
                targets: [4],
                orderData: [4, 0]
            }, {
                orderable: false,
                width: '100px',
                targets: [5]
            }]
        });


        // Complex headers with sorting
        $('.datatable-complex-header').DataTable({
            columnDefs: []
        });


        // Sequence control
        $('.datatable-sequence-control').dataTable( {
            "aoColumns": [
                null,
                null,
                {"orderSequence": ["asc"]},
                {"orderSequence": ["desc", "asc", "asc"]},
                {"orderSequence": ["desc"]},
                null
            ]
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentDatatableSorting();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    DatatableSorting.init();
});
