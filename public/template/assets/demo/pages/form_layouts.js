/* ------------------------------------------------------------------------------
 *
 *  # Form layouts
 *
 *  Demo JS code for form layouts pages
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var FormLayouts = function() {


    //
    // Setup module components
    //

    // Select2
    var _componentSelect2 = function() {
        if (!$().select2) {
            console.warn('Warning - select2.min.js is not loaded.');
            return;
        };

        // Basic example
        $('.form-control-select2').select2();


        //
        // Select with icons
        //

        // Format icon
        function iconFormat(icon) {
            var originalOption = icon.element;
            if (!icon.id) { return icon.text; }
            var $icon = '<i class="ph-' + $(icon.element).data('icon') + '"></i>' + icon.text;

            return $icon;
        }

        // Initialize with options
        $('.form-control-select2-icons').select2({
            templateResult: iconFormat,
            minimumResultsForSearch: Infinity,
            templateSelection: iconFormat,
            escapeMarkup: function(m) { return m; }
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentSelect2();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    FormLayouts.init();
});
