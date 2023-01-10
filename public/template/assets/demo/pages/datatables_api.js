/* ------------------------------------------------------------------------------
 *
 *  # Datatables API
 *
 *  Demo JS code for datatable_api.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const DatatableAPI = function() {


    //
    // Setup module components
    //

    // Basic Datatable examples
    const _componentDatatableAPI = function() {
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


        // Single row selection
        const singleSelect = $('.datatable-selection-single').DataTable();
        $('.datatable-selection-single tbody').on('click', 'tr', function() {
            if ($(this).hasClass('table-success')) {
                $(this).removeClass('table-success');
            }
            else {
                singleSelect.$('tr.table-success').removeClass('table-success');
                $(this).addClass('table-success');
            }
        });


        // Multiple rows selection
        $('.datatable-selection-multiple').DataTable();
        $('.datatable-selection-multiple tbody').on('click', 'tr', function() {
            $(this).toggleClass('table-success');
        });


        // Individual column searching with text inputs
        $('.datatable-column-search-inputs thead tr:eq(1) th').not(':last-child').each(function () {
            const title = $(this).text();
            $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
        });
        $('.datatable-column-search-inputs').DataTable({
            orderCellsTop: true,
            initComplete: function () {
                this.api()
                    .columns()
                    .every(function (index) {
                        const that = this;
     
                        $('input').on('keyup change clear', function () {
                            if (that.search() !== this.value) {
                                that.column($(this).parent().index() + ':visible').search(this.value).draw();
                            }
                        });
                    });
            }
        });


        // Individual column searching with selects
        $('.datatable-column-search-selects').DataTable({
            orderCellsTop: true,
            initComplete: function () {
                this.api()
                    .columns()
                    .every(function () {
                        const column = this;
                        const select = $('<select class="form-select"><option value="0" selected disabled>Filter</option></select>')
                            .appendTo($('.datatable-column-search-selects thead tr:eq(1) th').not(':last-child').eq(column.index()).empty())
                            .on('change', function () {
                                const val = $.fn.dataTable.util.escapeRegex($(this).val());
     
                                column.search(val ? '^' + val + '$' : '', true, false).draw();
                            });
     
                        column
                            .data()
                            .unique()
                            .sort()
                            .each(function (d, j) {
                                select.append('<option value="'+d.replace(/<(?:.|\n)*?>/gm, '')+'">'+d.replace(/<(?:.|\n)*?>/gm, '')+'</option>')
                            });
                    });
            }
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentDatatableAPI();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    DatatableAPI.init();
});
