/* ------------------------------------------------------------------------------
 *
 *  # Indigo color palette showcase
 *
 *  Demo JS code for colors_indigo.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const IndigoPalette = function() {


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
        $('.form-control-select2').select2();
    };

    // Multiselect
    const _componentMultiselect = function() {
        if (!$().multiselect) {
            console.warn('Warning - bootstrap-multiselect.js is not loaded.');
            return;
        }

        // Initialize
        $('.form-control-multiselect').multiselect({
            nonSelectedText: 'Select your state'
        });
    };

    // Noty
    const _componentNoty = function() {
        if (typeof Noty == 'undefined') {
            console.warn('Warning - noty.min.js is not loaded.');
            return;
        }

        // Initialize
        const notyElement = document.querySelector('.noty-launch');
        if(notyElement) {
            notyElement.addEventListener('click', function() {
                new Noty({
                    layout: 'topRight',
                    theme: ' bg-indigo text-white',
                    text: 'Check me out! I\'m a Noty notice.',
                    timeout: 2500
                }).show();
            });
        }
    };

    // Tooltips and popovers
    const _componentPopups = function() {

        // Tooltip
        const customTooltipElement = document.querySelector('[data-bs-popup=tooltip-custom]');
        if(customTooltipElement) {
            new bootstrap.Tooltip(customTooltipElement, {
                customClass: 'tooltip-custom',
                template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow border-indigo"></div><div class="tooltip-inner bg-indigo text-white"></div></div>'
            });
        }

        // Popover
        const customPopoverElement = document.querySelector('[data-bs-popup=popover-solid]');
        if(customPopoverElement) {
            new bootstrap.Popover(customPopoverElement, {
                customClass: 'popover-custom',
                template: '<div class="popover bg-indigo border-indigo"><div class="popover-arrow border-indigo"></div><h3 class="popover-header bg-indigo text-white border-white border-opacity-25"></h3><div class="popover-body text-white"></div></div>'
            });
        }
    };

    // Toast
    const _componentToast = function() {

        // Custom header
        const toastHeaderTrigger = document.querySelector('#toast_header');
        const toastHeaderElement = document.querySelector('#toast_header_example');
        if (toastHeaderTrigger) {
            toastHeaderTrigger.addEventListener('click', function () {
                const toast = new bootstrap.Toast(toastHeaderElement);
                toast.show()
            });
        }

        // Custom header and border
        const toastHeaderBorderTrigger = document.querySelector('#toast_header_border');
        const toastHeaderBorderElement = document.querySelector('#toast_header_border_example');
        if (toastHeaderBorderTrigger) {
            toastHeaderBorderTrigger.addEventListener('click', function () {
                const toast = new bootstrap.Toast(toastHeaderBorderElement);
                toast.show()
            });
        }

        // Custom background
        const toastSolidTrigger = document.querySelector('#toast_solid');
        const toastSolidElement = document.querySelector('#toast_solid_example');
        if (toastSolidTrigger) {
            toastSolidTrigger.addEventListener('click', function () {
                const toast = new bootstrap.Toast(toastSolidElement);
                toast.show()
            });
        }
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentSelect2();
            _componentMultiselect();
            _componentNoty();
            _componentPopups();
            _componentToast();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    IndigoPalette.init();
});
