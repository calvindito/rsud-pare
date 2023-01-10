/* ------------------------------------------------------------------------------
 *
 *  # Datatables data sources
 *
 *  Demo JS code for datatable_data_sources.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const DatatableDataSources = function() {


    //
    // Setup module components
    //

    // Basic Datatable examples
    const _componentDatatableDataSources = function() {
        if (!$().DataTable) {
            console.warn('Warning - datatables.min.js is not loaded.');
            return;
        }

        // Setting datatable defaults
        $.extend( $.fn.dataTable.defaults, {
            autoWidth: false,
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            language: {
                search: '<span class="me-3">Filter:</span> <div class="form-control-feedback form-control-feedback-end flex-fill">_INPUT_<div class="form-control-feedback-icon"><i class="ph-magnifying-glass opacity-50"></i></div></div>',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span class="me-3">Show:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': document.dir == "rtl" ? '&larr;' : '&rarr;', 'previous': document.dir == "rtl" ? '&rarr;' : '&larr;' }
            }
        });


        // HTML sourced data
        $('.datatable-html').dataTable({
            columnDefs: [{ 
                orderable: false,
                width: 100,
                targets: [ 5 ]
            }]
        });


        // AJAX sourced data
        $('.datatable-ajax').dataTable({
            ajax: '../../../assets/demo/data/tables/datatable_ajax.json'
        });


        //
        // Javascript sourced data
        //

        // Data
        const dataSet = [
            ['Trident','Internet Explorer 4.0','Win 95+','4','X'],
            ['Trident','Internet Explorer 5.0','Win 95+','5','C'],
            ['Trident','Internet Explorer 5.5','Win 95+','5.5','A'],
            ['Trident','Internet Explorer 6','Win 98+','6','A'],
            ['Gecko','Firefox 1.0','Win 98+ / OSX.2+','1.7','A'],
            ['Gecko','Firefox 1.5','Win 98+ / OSX.2+','1.8','A'],
            ['Gecko','Firefox 2.0','Win 98+ / OSX.2+','1.8','A'],
            ['Gecko','Firefox 3.0','Win 2k+ / OSX.3+','1.9','A'],
            ['Gecko','Camino 1.0','OSX.2+','1.8','A'],
            ['Gecko','Camino 1.5','OSX.3+','1.8','A'],
            ['Webkit','Safari 1.2','OSX.3','125.5','A'],
            ['Webkit','Safari 1.3','OSX.3','312.8','A'],
            ['Webkit','Safari 2.0','OSX.4+','419.3','A'],
            ['Presto','Opera 7.0','Win 95+ / OSX.1+','-','A'],
            ['Presto','Opera 7.5','Win 95+ / OSX.2+','-','A'],
            ['Misc','NetFront 3.1','Embedded devices','-','C'],
            ['Misc','NetFront 3.4','Embedded devices','-','A'],
            ['Misc','Dillo 0.8','Embedded devices','-','X'],
            ['Misc','Links','Text only','-','X']
        ];

        // Initialize
        $('.datatable-js').dataTable({
            data: dataSet,
            columnDefs: []
        });


        //
        // Nested object data
        //

        $('.datatable-nested').dataTable({
            ajax: '../../../assets/demo/data/tables/datatable_nested.json',
            columns: [
                {data: "name[, ]"},
                {data: "hr.0" },
                {data: "office"},
                {data: "extn"},
                {data: "hr.2"},
                {data: "hr.1"}
            ]
        });


        //
        // Generate content for a column
        //

        // Table config
        const table = $('.datatable-generated').DataTable({
            ajax: '../../../assets/demo/data/tables/datatable_ajax.json',
            columnDefs: [{
                targets: 2,
                data: null,
                defaultContent: "<a class='cursor-pointer'>Show &rarr;</a>"
            },
            { 
                orderable: false,
                targets: [0, 2]
            }]
        });
        
        // Location alert
        $('.datatable-generated tbody').on('click', 'a', function () {
            const data = table.row($(this).parents('tr')).data();
            alert(data[0] +"'s location is: "+ data[ 2 ]);
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentDatatableDataSources();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    DatatableDataSources.init();
});
