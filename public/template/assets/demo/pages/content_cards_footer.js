/* ------------------------------------------------------------------------------
 *
 *  # Card footer elements
 *
 *  Demo JS code for content_cards_footer.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const CardFooter = function() {


    //
    // Setup module components
    //

    // Select2
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

    // Multiselect
    const _componentMulti = function() {
        if (!$().multiselect) {
            console.warn('Warning - bootstrap-multiselect.js is not loaded.');
            return;
        }

        // Initialize
        $('.form-control-multiselect').multiselect();
    };

    // NoUI slider
    const _componentNouiSlider = function() {
        if (typeof noUiSlider == 'undefined') {
            console.warn('Warning - nouislider.min.js is not loaded.');
            return;
        }


        //
        // Connect lower side
        //

        // Define element
        const slider_connect_lower = document.getElementById('noui-slider-demo');

        // Create slider
        noUiSlider.create(slider_connect_lower, {
            start: 60,
            connect: 'lower',
            tooltips: true,
            range: {
              'min': 0,
              'max': 100
            }
        });


        //
        // Drag behaviour
        //

        // Define element
        var noui_slider_demo = document.getElementById('noui-slider-demo2');

        // Create slider
        noUiSlider.create(noui_slider_demo, {
            start: [ 20, 80 ],
            behaviour: 'drag',
            connect: true,
            tooltips: true,
            range: {
                'min':  0,
                'max':  100
            }
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentSelect2();
            _componentMulti();
            _componentNouiSlider();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    CardFooter.init();
});
