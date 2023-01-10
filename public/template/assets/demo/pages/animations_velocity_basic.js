/* ------------------------------------------------------------------------------
 *
 *  # Velocity animations - basic examples
 *
 *  Demo JS code for animations_velocity_basic.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const AnimationsVelocityBasic = function() {


    //
    // Setup module components
    //

    // Velocity basic
    const _componentAnimationVelocityBasic = function() {
        if (typeof Velocity == 'undefined') {
            console.warn('Warning - velocity.min.js is not loaded.');
            return;
        }

        // Demo config
        const animationClass = document.querySelectorAll('.velocity-property');
        animationClass.forEach(function(element) {
            element.addEventListener('click', function (e) {
                e.preventDefault();
                
                // Get animation class and panel
                const property = element.dataset.property;
                const property2 = element.dataset.property2;
                const property3 = element.dataset.property3;
                const value = element.dataset.value;
                const value2 = element.dataset.value2;
                const value3 = element.dataset.value3;

                // Add options
                const animateMap = {},
                animateOptions = {
                    easing: 'easeInOut',
                    duration: 250
                };
                animateMap[property] = value;
                animateMap[property2] = value2;
                animateMap[property3] = value3;

                // Element that we animate
                const currentElement = element.closest('.demo-velocity-box');

                // Add animation class to panel element
                Velocity(currentElement, animateMap, animateOptions);
                Velocity(currentElement, "reverse", {
                    delay: 1000,
                    complete: function() {
                        currentElement.removeAttribute('style');
                    }
                });
            });
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentAnimationVelocityBasic();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    AnimationsVelocityBasic.init();
});
