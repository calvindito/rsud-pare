/* ------------------------------------------------------------------------------
 *
 *  # Page header
 *
 *  Demo JS code for content_page_header.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const PageHeader = function () {


    //
    // Setup module components
    //

	// Daterange picker
    const _componentDateRange = function() {
        if (!$().daterangepicker) {
            console.warn('Warning - daterangepicker.js is not loaded.');
            return;
        }

	    // Setup
        $('.daterange-ranges').daterangepicker(
            {
                startDate: moment().subtract(29, 'days'),
                endDate: moment(),
                minDate: '01/01/2020',
                maxDate: '12/31/2021',
                dateLimit: { days: 60 },
                opens: document.dir == 'rtl' ? 'right' : 'left',
                parentEl: '.content-inner',
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            },
            function(start, end) {
                $('.daterange-ranges').html(start.format('MMMM D, YYYY') + ' &nbsp; - &nbsp; ' + end.format('MMMM D, YYYY'));
            }
        );

        // Display date format
        $('.daterange-ranges span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' &nbsp; - &nbsp; ' + moment().format('MMMM D, YYYY'));
    };

	// Select2 selects
    const _componentSelect2 = function() {
        if (!$().select2) {
            console.warn('Warning - select2.min.js is not loaded.');
            return;
        }

	    // Initialize
	    $('.form-control-select2').select2({
	        minimumResultsForSearch: Infinity
	    });
    };

    // Bootstrap multiselect
    const _componentMultiselect = function() {
        if (!$().multiselect) {
            console.warn('Warning - bootstrap_multiselect.js is not loaded.');
            return;
        }

        // Initialize
	    $('.form-control-multiselect').multiselect();
    };


    //
    // Return objects assigned to module
    //

    return {
        initComponents: function() {
        	_componentDateRange();
        	_componentSelect2();
        	_componentMultiselect();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    PageHeader.initComponents();
});
