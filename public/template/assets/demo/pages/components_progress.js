/* ------------------------------------------------------------------------------
 *
 *  # Progress bars & loaders
 *
 *  Demo JS code for components_progress.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const Progress = function() {


    //
    // Setup module components
    //

    // Spinner with overlay
    const _componentOverlay = function() {

        // Elements
        // Change button.getAttribute('data-icon') to your desired icon here. Current
        // config is for demo. Or use this code if you wish
        const buttonClass = 'btn-launch-spinner',
              containerClass = 'card',
              overlayClass = 'card-overlay',
              overlayAnimationClass = 'card-overlay-fadeout';

        // Configure
        document.querySelectorAll(`.${buttonClass}`).forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                // Elements
                const parentContainer = button.closest(`.${containerClass}`),
                      overlayElement = document.createElement('div'),
                      overlayElementIcon = document.createElement('span');

                // Append overlay with icon
                overlayElement.classList.add(overlayClass);
                parentContainer.appendChild(overlayElement);
                if(button.getAttribute('data-spin') == 'false') {
                    overlayElementIcon.classList.add(button.getAttribute('data-icon'));
                }
                else {
                    overlayElementIcon.classList.add(button.getAttribute('data-icon'), 'spinner');
                }
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


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentOverlay();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    Progress.init();
});
