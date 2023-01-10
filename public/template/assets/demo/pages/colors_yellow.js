/* ------------------------------------------------------------------------------
 *
 *  # Yellow color palette showcase
 *
 *  Demo JS code for colors_yellow.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const YellowPalette = function() {


    //
    // Setup module components
    //

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
                    theme: ' bg-yellow text-black',
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
                template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow border-yellow"></div><div class="tooltip-inner bg-yellow text-black"></div></div>'
            });
        }

        // Popover
        const customPopoverElement = document.querySelector('[data-bs-popup=popover-solid]');
        if(customPopoverElement) {
            new bootstrap.Popover(customPopoverElement, {
                customClass: 'popover-custom',
                template: '<div class="popover bg-yellow border-yellow"><div class="popover-arrow border-yellow"></div><h3 class="popover-header bg-yellow text-black border-black border-opacity-10"></h3><div class="popover-body text-black"></div></div>'
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
            _componentNoty();
            _componentPopups();
            _componentToast();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    YellowPalette.init();
});
