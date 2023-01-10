/* ------------------------------------------------------------------------------
 *
 *  # Floating action buttons
 *
 *  Demo JS code for extra_fab.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const FloatingActionButton = function() {


    //
    // Setup module components
    //

    // FAB
    const _componentFab = function() {

        // Add bottom spacing if reached bottom, to avoid footer overlapping        
        window.addEventListener('scroll', function() {
            const bottomFabs = document.querySelectorAll('.fab-menu-bottom-start, .fab-menu-bottom-end'),
                fabClass = 'reached-bottom';

            for (const i = 0; i < bottomFabs.length; ++i) {
                if(window.pageYOffset + window.innerHeight > document.body.clientHeight - 40) {
                    bottomFabs[i].classList.add(fabClass);
                }
                else {
                    bottomFabs[i].classList.remove(fabClass);
                }
            }
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentFab();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    FloatingActionButton.init();
});
