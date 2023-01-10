/* ------------------------------------------------------------------------------
 *
 *  # Advanced datatables
 *
 *  Demo JS code for datatable_advanced.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const DatatableAdvanced = function() {


    //
    // Setup module components
    //

    // Basic Datatable examples
    const _componentDatatableAdvanced = function() {
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


        // Datatable 'length' options
        $('.datatable-show-all').DataTable({
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]]
        });

        // DOM positioning
        $('.datatable-dom-position').DataTable({
            dom: '<"datatable-header length-left"lp><"datatable-scroll"t><"datatable-footer info-right"fi>',
        });

        // Highlighting rows and columns on mouseover
        const lastIdx = null;
        const table = $('.datatable-highlight').DataTable();
         
        $('.datatable-highlight tbody').on('mouseover', 'td', function() {
            const colIdx = table.cell(this).index().column;

            if (colIdx !== lastIdx) {
                $(table.cells().nodes()).removeClass('active');
                $(table.column(colIdx).nodes()).addClass('active');
            }
        }).on('mouseleave', function() {
            $(table.cells().nodes()).removeClass('active');
        });

        // Columns rendering
        $('.datatable-columns').dataTable({
            columnDefs: [ 
                {
                    // The `data` parameter refers to the data for the cell (defined by the
                    // `data` option, which defaults to the column being worked with, in
                    // this case `data: 0`.
                    render: function (data, type, row) {
                        return data +' ('+ row[3]+')';
                    },
                    targets: 0
                },
                { visible: false, targets: [ 3 ] }
            ]
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentDatatableAdvanced();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    DatatableAdvanced.init();
});
