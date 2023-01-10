/* ------------------------------------------------------------------------------
 *
 *  # Sidebar components
 *
 *  Demo JS code for sidebar_components.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const SidebarComponents = function () {


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
    const _componentMultiselect = function() {
        if (!$().multiselect) {
            console.warn('Warning - bootstrap-multiselect.js is not loaded.');
            return;
        }

        // Initialize
        $('.form-control-multiselect').multiselect();
    };

    // Color picker
    const _componentColorPicker = function() {
        if (!$().spectrum) {
            console.warn('Warning - spectrum.js is not loaded.');
            return;
        }

        // Initialize
        $('.colorpicker-flat-full').spectrum({
            flat: true,
            showInitial: true,
            showButtons: false,
            showInput: true,
            showAlpha: true,
            allowEmpty: true
        });
    };

    // Date picker
    const _componentDatepicker = function() {
        if (typeof Datepicker == 'undefined') {
            console.warn('Warning - datepicker.min.js is not loaded.');
            return;
        }

        // Basic example
        const dpBasicElement = document.querySelector('.datepicker-basic');
        if(dpBasicElement) {
            const dpBasic = new Datepicker(dpBasicElement, {
                buttonClass: 'btn',
                orientation: 'bottom left',
                prevArrow: document.dir == 'rtl' ? '&rarr;' : '&larr;',
                nextArrow: document.dir == 'rtl' ? '&larr;' : '&rarr;'
            });
        }
    };

    // Dragula examples
    const _componentDragula = function() {
        if (typeof dragula == 'undefined') {
            console.warn('Warning - dragula.min.js is not loaded.');
            return;
        }

        // Define containers
        const containers = Array.from(document.querySelectorAll('.tab-pane'));

        // Init dragula
        dragula(containers, {
            mirrorContainer: document.querySelector('.tab-pane'),
            moves: function (el, container, handle) {
                return handle.matches('[data-section-action="sort"]');
            }
        });
    };

    // Reload section example
    const _componentReload = function() {

        // Elements
        const buttonClass = '[data-section-action=reload]',
              containerClass = 'sidebar-section',
              overlayClass = 'card-overlay',
              spinnerClass = 'ph-circle-notch',
              overlayAnimationClass = 'card-overlay-fadeout';

        // Configure
        document.querySelectorAll(buttonClass).forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                // Elements
                const parentContainer = button.closest(`.${containerClass}`),
                      overlayElement = document.createElement('div'),
                      overlayElementIcon = document.createElement('i');

                // Append overlay with icon
                overlayElement.classList.add(overlayClass);
                parentContainer.appendChild(overlayElement);
                overlayElementIcon.classList.add(spinnerClass, 'spinner', 'text-body');
                overlayElement.appendChild(overlayElementIcon);

                // Remove overlay after 2.5s, for demo only
                setTimeout(function() {
                    overlayElement.classList.add(overlayAnimationClass);
                    ['animationend', 'animationcancel'].forEach(function(e) {
                        overlayElement.addEventListener(e, function() {
                            overlayElement.remove();
                        });
                    });
                }, 2500);
            });
        });
    };

    // Dual listbox
    const _componentDualListbox = function() {
        if (typeof DualListbox == 'undefined') {
            console.warn('Warning - dual_listbox.min.js is not loaded.');
            return;
        }

        // Basic example
        const listboxBasicElement = document.querySelector(".listbox-basic");
        const listboxBasic = new DualListbox(listboxBasicElement);
    };

    // Fancytree
    const _componentFancytree = function() {
        if (!$().fancytree) {
            console.warn('Warning - fancytree_all.min.js is not loaded.');
            return;
        }

        // Initialize
        $('.tree-default').fancytree();
    };

    // Lightbox
    const _componentLightbox = function() {
        if (typeof GLightbox == 'undefined') {
            console.warn('Warning - glightbox.min.js is not loaded.');
            return;
        }

        // Image lightbox
        const lightbox = GLightbox({
            selector: '[data-bs-popup="lightbox"]',
            loop: true,
            svg: {
                next: document.dir == "rtl" ? '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 477.175 477.175" xml:space="preserve"><g><path d="M145.188,238.575l215.5-215.5c5.3-5.3,5.3-13.8,0-19.1s-13.8-5.3-19.1,0l-225.1,225.1c-5.3,5.3-5.3,13.8,0,19.1l225.1,225c2.6,2.6,6.1,4,9.5,4s6.9-1.3,9.5-4c5.3-5.3,5.3-13.8,0-19.1L145.188,238.575z"/></g></svg>' : '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 477.175 477.175" xml:space="preserve"> <g><path d="M360.731,229.075l-225.1-225.1c-5.3-5.3-13.8-5.3-19.1,0s-5.3,13.8,0,19.1l215.5,215.5l-215.5,215.5c-5.3,5.3-5.3,13.8,0,19.1c2.6,2.6,6.1,4,9.5,4c3.4,0,6.9-1.3,9.5-4l225.1-225.1C365.931,242.875,365.931,234.275,360.731,229.075z"/></g></svg>',
                prev: document.dir == "rtl" ? '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 477.175 477.175" xml:space="preserve"><g><path d="M360.731,229.075l-225.1-225.1c-5.3-5.3-13.8-5.3-19.1,0s-5.3,13.8,0,19.1l215.5,215.5l-215.5,215.5c-5.3,5.3-5.3,13.8,0,19.1c2.6,2.6,6.1,4,9.5,4c3.4,0,6.9-1.3,9.5-4l225.1-225.1C365.931,242.875,365.931,234.275,360.731,229.075z"/></g></svg>' : '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 477.175 477.175" xml:space="preserve"><g><path d="M145.188,238.575l215.5-215.5c5.3-5.3,5.3-13.8,0-19.1s-13.8-5.3-19.1,0l-225.1,225.1c-5.3,5.3-5.3,13.8,0,19.1l225.1,225c2.6,2.6,6.1,4,9.5,4s6.9-1.3,9.5-4c5.3-5.3,5.3-13.8,0-19.1L145.188,238.575z"/></g></svg>'
            }
        });
    };

    // NoUI slider examples
    const _componentNouiSlider = function() {
        if (typeof noUiSlider == 'undefined') {
            console.warn('Warning - nouislider.min.js is not loaded.');
            return;
        }

        // Demo data for ranges
        const range_all_sliders = {
            'min': [     0 ],
            '10%': [   5,  5 ],
            '50%': [  40, 10 ],
            'max': [ 100 ]
        };

        // Basic slider
        const slider_range = document.getElementById('noui-slider-range');
        noUiSlider.create(slider_range, {
            start: [60],
            range: {
                'min': [20],
                'max': [100]
            },
            direction: document.dir == 'rtl' ? 'rtl' : 'ltr'
        });

        // Range slider
        slider_behaviour = document.getElementById('noui-slider-behaviour');
        noUiSlider.create(slider_behaviour, {
            start: [ 30, 70 ],
            behaviour: 'drag',
            connect: true,
            range: {
                'min':  20,
                'max':  80
            },
            direction: document.dir == 'rtl' ? 'rtl' : 'ltr'
        });


        // Range slider pips
        const pips_range = document.getElementById('noui-slider-pips-range');
        noUiSlider.create(pips_range, {
            range: range_all_sliders,
            start: 40,
            connect: 'lower',
            pips: {
                mode: 'range',
                density: 3
            },
            direction: document.dir == 'rtl' ? 'rtl' : 'ltr'
        });


        //
        // Bottom to top pips
        //

        // First
        const slider_pips_bottom_1 = document.getElementById('noui-slider-bottom1');
        noUiSlider.create(slider_pips_bottom_1, {
            range: range_all_sliders,
            start: 40,
            connect: 'lower',
            orientation: 'vertical',
            direction: 'rtl',
            pips: {
                mode: 'range',
                density: 5
            }
        });

        // Second
        const slider_pips_bottom_2 = document.getElementById('noui-slider-bottom2');
        noUiSlider.create(slider_pips_bottom_2, {
            range: range_all_sliders,
            start: 60,
            connect: 'lower',
            orientation: 'vertical',
            direction: 'rtl',
            pips: {
                mode: 'range',
                density: 5
            }
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        initComponents: function() {
            _componentSelect2();
            _componentMultiselect();
            _componentColorPicker();
            _componentDatepicker();
            _componentDragula();
            _componentReload();
            _componentDualListbox();
            _componentFancytree();
            _componentLightbox();
            _componentNouiSlider();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    SidebarComponents.initComponents();
});
