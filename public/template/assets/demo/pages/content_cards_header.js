/* ------------------------------------------------------------------------------
 *
 *  # Card header elements
 *
 *  Demo JS code for content_cards_header.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const CardHeader = function() {


    //
    // Setup module components
    //

    // Select2
    const _componentSelect2 = function() {
        if (!$().select2) {
            console.warn('Warning - select2.min.js is not loaded.');
            return;
        };

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

        // Define element
        const noui_slider_demo = document.getElementById('noui-slider-demo');

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

    // Sortable cards
    const _componentDragula = function() {
        if (typeof dragula == 'undefined') {
            console.warn('Warning - dragula.min.js is not loaded.');
            return;
        }

        // Define containers
        const containers = Array.from(document.querySelectorAll('[class*="col-"], .content'));

        // Init dragula
        dragula(containers, {
            mirrorContainer: document.querySelector('.content-inner'),
            moves: function(el, container, handle) {
                return handle.parentNode.matches('[data-card-action="sort"]');
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
            _componentDragula();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    CardHeader.init();
});
