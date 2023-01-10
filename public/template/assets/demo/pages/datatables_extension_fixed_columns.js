/* ------------------------------------------------------------------------------
 *
 *  # Fixed Columns extension for Datatables
 *
 *  Demo JS code for datatable_extension_fixed_columns.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const DatatableFixedColumns = function() {


    //
    // Setup module components
    //

    // Basic Datatable examples
    const _componentDatatableFixedColumns = function() {
        if (!$().DataTable) {
            console.warn('Warning - datatables.min.js is not loaded.');
            return;
        }

        // Setting datatable defaults
        $.extend( $.fn.dataTable.defaults, {
            columnDefs: [{ 
                orderable: false,
                width: 100,
                targets: [ 5 ]
            }],
            dom: '<"datatable-header"fl><"datatable-scroll datatable-scroll-wrap"t><"datatable-footer"ip>',
            language: {
                search: '<span class="me-3">Filter:</span> <div class="form-control-feedback form-control-feedback-end flex-fill">_INPUT_<div class="form-control-feedback-icon"><i class="ph-magnifying-glass opacity-50"></i></div></div>',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span class="me-3">Show:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': document.dir == "rtl" ? '&larr;' : '&rarr;', 'previous': document.dir == "rtl" ? '&rarr;' : '&larr;' }
            }
        });


        // Left fixed column example
        $('.datatable-fixed-left').DataTable({
            columnDefs: [
                { 
                    orderable: false,
                    targets: 5
                },
                { 
                    width: 200,
                    targets: 0
                },
                { 
                    width: 300,
                    targets: 1
                },
                { 
                    width: 200,
                    targets: [5, 6]
                },
                { 
                    width: 100,
                    targets: 4
                }
            ],
            scrollX: true,
            scrollY: 350,
            scrollCollapse: true,
            fixedColumns: true
        });


        // Right fixed column example
        $('.datatable-fixed-right').DataTable({
            columnDefs: [
                { 
                    orderable: false,
                    targets: 5
                },
                { 
                    width: 300,
                    targets: 0
                },
                { 
                    width: 300,
                    targets: 1
                },
                { 
                    width: 200,
                    targets: [5, 6]
                },
                { 
                    width: 100,
                    targets: [3, 4]
                }
            ],
            scrollX: true,
            scrollY: 350,
            scrollCollapse: true,
            fixedColumns: {
                leftColumns: 0,
                rightColumns: 1
            }
        });


        // Left and right fixed columns
        $('.datatable-fixed-both').DataTable({
            columnDefs: [
                { 
                    orderable: false,
                    targets: 5
                },
                { 
                    width: 200,
                    targets: 0
                },
                { 
                    width: 100,
                    targets: 1
                },
                { 
                    width: 200,
                    targets: [5, 6]
                },
                { 
                    width: 100,
                    targets: 4
                }
            ],
            scrollX: true,
            scrollY: 350,
            scrollCollapse: true,
            fixedColumns: {
                leftColumns: 1,
                rightColumns: 1
            }
        });


        //
        // Fixed column with complex headers
        //
        
        // Initialize
        const table = $('.datatable-fixed-complex').DataTable({
            autoWidth: false,
            columnDefs: [
                { 
                    orderable: false,
                    targets: 5
                },
                { 
                    width: 250,
                    targets: 0
                },
                { 
                    width: 250,
                    targets: 1
                },
                { 
                    width: 200,
                    targets: [5, 6]
                },
                { 
                    width: 100,
                    targets: 4
                }
            ],
            scrollX: true,
            scrollY: 350,
            scrollCollapse: true,
            fixedColumns: true
        });

        // Adjust columns on window resize
        setTimeout(function() {
            $(window).on('resize', function () {
                table.columns.adjust();
            });
        }, 100);
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentDatatableFixedColumns();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    DatatableFixedColumns.init();
});
