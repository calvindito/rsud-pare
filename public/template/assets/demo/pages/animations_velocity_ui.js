/* ------------------------------------------------------------------------------
 *
 *  # Velocity animations - UI effects
 *
 *  Demo JS code for animations_velocity_ui.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const AnimationsVelocityUi = function() {


    //
    // Setup module components
    //

    // Velocity UI
    const _componentAnimationVelocityUi = function() {
        if (typeof Velocity == 'undefined') {
            console.warn('Warning - velocity.min.js is not loaded.');
            return;
        }

        // Animation demo
        const animationClass = document.querySelectorAll('.velocity-animation');
        animationClass.forEach(function(element) {
            element.addEventListener('click', function (e) {
                e.preventDefault();

                const animation = element.dataset.animation;

                // Element that we animate
                const currentElement = element.closest('.card');

                // Add animation class to panel element
                Velocity(currentElement, 'callout.' + animation, {
                    stagger: 500,
                    complete: function() {
                        currentElement.removeAttribute('style');
                    }
                });
            });
        });


        // Transitions demo
        const transitionClass = document.querySelectorAll('.velocity-transition');
        transitionClass.forEach(function(element) {
            element.addEventListener('click', function (e) {
                e.preventDefault();

                const transition = element.dataset.transition;

                // Element that we animate
                const currentElement = element.closest('.card');

                // Add transition class to panel element
                Velocity(currentElement, 'transition.' + transition, {
                    stagger: 1000,
                    duration: 1000,
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
            _componentAnimationVelocityUi();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    AnimationsVelocityUi.init();
});
