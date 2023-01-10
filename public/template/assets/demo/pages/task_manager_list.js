/* ------------------------------------------------------------------------------
 *
 *  # Task list view
 *
 *  Demo JS code for task_manager_list.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var TaskManagerList = function () {


    //
    // Setup components
    //

    // Datatable
    var _componentDatatable = function() {
        if (!$().DataTable) {
            console.warn('Warning - datatables.min.js is not loaded.');
            return;
        }

        // Create an array with the values of all the input boxes in a column
        $.fn.dataTable.ext.order['dom-text'] = function (settings, col) {
            return this.api().column(col, {order:'index'}).nodes().map( function (td, i) {
                return $('input', td).val();
            });
        };
         
        // Create an array with the values of all the select options in a column
        $.fn.dataTable.ext.order['dom-select'] = function (settings, col) {
            return this.api().column(col, {order:'index'}).nodes().map( function (td, i) {
                return $('select', td).val();
            });
        };

        // Initialize data table
        $('.tasks-list').DataTable({
            autoWidth: false,
            columnDefs: [
                {
                    type: "natural",
                    width: 20,
                    targets: 0
                },
                {
                    visible: false,
                    targets: 1
                },
                {
                    width: '40%',
                    targets: 2
                },
                {
                    width: '10%',
                    targets: 3
                },
                {
                    orderDataType: 'dom-text',
                    type: 'string',
                    targets: 4
                },
                {
                    orderDataType: 'dom-select',
                    type: 'string',
                    targets: 5
                },
                { 
                    orderable: false,
                    width: 100,
                    targets: 7
                },
                {
                    width: '15%',
                    targets: [4, 5, 6]
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
            lengthMenu: [ 15, 25, 50, 75, 100 ],
            displayLength: 25,
            drawCallback: function (settings) {
                var api = this.api();
                var rows = api.rows({page:'current'}).nodes();
                var last=null;
     
                // Grouod rows
                api.column(1, {page:'current'}).data().each(function (group, i) {
                    if (last !== group) {
                        $(rows).eq(i).before(
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
    TaskManagerList.init();
});
