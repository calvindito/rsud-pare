/* ------------------------------------------------------------------------------
 *
 *  # Collapsible, accordion and other navs
 *
 *  Demo JS code for components_navs.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var ComponentsCollapsible = function() {


    //
    // Setup module components
    //

    // Sortable cards
    var _componentDragula = function() {
        if (typeof dragula == 'undefined') {
            console.warn('Warning - dragula.min.js is not loaded.');
            return;
        }

        // Define containers
        const containers = Array.from(document.querySelectorAll('.collapsible-sortable, .accordion-sortable'));

        // Init dragula
        dragula(containers, {
            mirrorContainer: document.querySelector('.content-inner'),
            moves: function (el, container, handle) {
                return handle.matches('[data-action=move]');
            }
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentDragula();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    ComponentsCollapsible.init();
});
