/* ------------------------------------------------------------------------------
 *
 *  # Navbar components
 *
 *  Demo JS code for navbar_component.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var NavbarComponents = function() {


    //
    // Setup module components
    //

    // Select2
    var _componentSelect2 = function() {
        if (!$().select2) {
            console.warn('Warning - select2.min.js is not loaded.');
            return;
        }

        // Initialize
        $('.form-control-select2').select2({
            minimumResultsForSearch: Infinity
        });
    };

    // Daterange pickers
    var _componentDaterange = function() {
        if (!$().daterangepicker) {
            console.warn('Warning - daterangepicker.js is not loaded.');
            return;
        }

        //
        // Custom display
        //

        // Initialize
        $('.daterange-ranges-button').daterangepicker(
            {
                startDate: moment().subtract(29, 'days'),
                endDate: moment(),
                minDate: '01/01/2014',
                maxDate: '12/31/2018',
                parentEl: '.content-inner',
                dateLimit: {
                    days: 60
                },
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                opens: document.dir == "rtl" ? 'right' : 'left',
                applyClass: 'btn-small btn-primary btn-block',
                cancelClass: 'btn-small btn-light btn-block',
                locale: {
                    format: 'MM/DD/YYYY',
                    direction: document.dir == "rtl" ? 'rtl' : 'ltr'
                }
            },
            function(start, end) {
                $('.daterange-ranges-button span').html(start.format('MMM D, YY') + ' - ' + end.format('MMM D, YY'));
            }
        );

        // Format results
        $('.daterange-ranges-button span').html(moment().subtract(29, 'days').format('MMM D, YY') + ' - ' + moment().format('MMM D, YY'));


        //
        // Attached to button
        //

        // Initialize
        $('.daterange-ranges').daterangepicker(
            {
                startDate: moment().subtract(29, 'days'),
                endDate: moment(),
                minDate: '01/01/2014',
                maxDate: '12/31/2018',
                parentEl: '.content-inner',
                dateLimit: { days: 60 },
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                opens: document.dir == "rtl" ? 'left' : 'right',
                applyClass: 'btn-small btn-primary btn-block',
                cancelClass: 'btn-small btn-light btn-block',
                locale: {
                    format: 'MM/DD/YYYY',
                    direction: document.dir == "rtl" ? 'rtl' : 'ltr'
                }
            },
            function(start, end) {
                $('.daterange-ranges span').html(start.format('MMM D, YY') + ' - ' + end.format('MMM D, YY'));
            }
        );

        // Format results
        $('.daterange-ranges span').html(moment().subtract(29, 'days').format('MMM D, YY') + ' - ' + moment().format('MMM D, YY'));
    };

    // Multiselect
    var _componentMultiselect = function() {
        if (!$().multiselect) {
            console.warn('Warning - select2.min.js is not loaded.');
            return;
        }

        // Initialize
        $('.form-control-multiselect').multiselect();

        // Material theme example
        $('.form-control-multiselect-material').multiselect({
            buttonClass: 'btn btn-light text-white'
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentSelect2();
            _componentDaterange();
            _componentMultiselect();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    NavbarComponents.init();
});
