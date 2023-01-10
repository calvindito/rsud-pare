/* ------------------------------------------------------------------------------
 *
 *  # Key Table extension for Datatables
 *
 *  Demo JS code for datatable_extension_key_table.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const DatatableKeyTable = function() {


    //
    // Setup module components
    //

    // Basic Datatable examples
    const _componentDatatableKeyTable = function() {
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
        $('.datatable-key-basic').DataTable({
            keys: true
        });


        // Scrollable table
        $('.datatable-key-scroll').DataTable({
            dom: '<"datatable-header info-right"fi><"datatable-scroll-wrap"t>',
            scrollY: 300,
            paging: false,
            keys: true
        });
     

        // Custom class
        $('.datatable-key-class').DataTable({
            keys: {
                className: 'focus focus-success'
            }
        });


        // Table with events
        const table = $('.datatable-key-events').DataTable({
            keys: true
        });
     
        // Events
        const events = $('#key-events');
        table
            .on('key', function (e, datatable, key, cell, originalEvent) {
                events.append(JSON.stringify('Key press: '+key+' for cell '+cell.data()), '\n');
            })
            .on('key-focus', function (e, datatable, cell) {
                events.append(JSON.stringify('Cell focus: '+cell.data()), '\n');
            })
            .on('key-blur', function (e, datatable, cell) {
                events.append(JSON.stringify('Cell blur: '+cell.data()), '\n');
            });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentDatatableKeyTable();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    DatatableKeyTable.init();
});
