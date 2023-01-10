/* ------------------------------------------------------------------------------
 *
 *  # Velocity animations - advanced examples
 *
 *  Demo JS code for animations_velocity_examples.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const AnimationsVelocityAdvanced = function() {


    //
    // Setup module components
    //

    // Velocity advanced
    const _componentAnimationVelocityAdvanced = function() {
        if (typeof Velocity == 'undefined') {
            console.warn('Warning - velocity.min.js is not loaded.');
            return;
        }

        // Properties animation
        const velocityPropsElement = document.querySelectorAll('.velocity-properties');
        velocityPropsElement.forEach(function(link) {
            link.addEventListener('click', function (e) {
                e.preventDefault();

                // Element that we animate
                const currentElements = link.closest('.card-body').querySelectorAll('.card');

                // Add animation class to panel element
                Velocity(currentElements, {
                    marginLeft: 20,
                    marginRight: 20,
                    opacity: 0.5
                });
                Velocity(currentElements, "reverse", {
                    delay: 1000,
                    complete: function() {
                        currentElements.forEach(function(cards) {
                            cards.removeAttribute('style');
                        });
                    }
                });
            });
        });

        // Chained animation
        const velocityChainedElement = document.querySelectorAll('.velocity-chained');
        velocityChainedElement.forEach(function(link) {
            link.addEventListener('click', function (e) {
                e.preventDefault();

                // Element that we animate
                const currentElements = link.closest('.card-body').querySelectorAll('.card');

                // Add animation class to panel element
                Velocity(currentElements, {
                    marginLeft: 20,
                    marginRight: 20,
                    opacity: 0.5
                });
                Velocity(currentElements, "reverse", {
                    delay: 1000
                });
                Velocity(currentElements, {
                    marginRight: 20
                });
                Velocity(currentElements, "reverse", {
                    delay: 1000
                });
                Velocity(currentElements, {
                    opacity: 0.5
                });
                Velocity(currentElements, "reverse", {
                    delay: 1000,
                    complete: function() {
                        currentElements.forEach(function(cards) {
                            cards.removeAttribute('style');
                        });
                    }
                });
            });
        });

        // Stagger animation
        const velocityStaggerElement = document.querySelectorAll('.velocity-stagger');
        velocityStaggerElement.forEach(function(link) {
            link.addEventListener('click', function (e) {
                e.preventDefault();

                // Element that we animate
                const currentElements = link.closest('.velocity-container').querySelectorAll('.card');

                // Add animation class to panel element
                Velocity(currentElements, 'transition.slideUpIn', {
                    stagger: 500
                });
            });
        });

        // Drag animation
        const velocityDragElement = document.querySelectorAll('.velocity-drag');
        velocityDragElement.forEach(function(link) {
            link.addEventListener('click', function (e) {
                e.preventDefault();

                // Element that we animate
                const currentElements = link.closest('.velocity-container').querySelectorAll('.card');

                // Add animation class to panel element
                Velocity(currentElements, 'transition.slideUpBigIn', {
                    duration: 1000,
                    drag: true
                });
            });
        });

        // Backwards animation
        const velocityBackwardsElement = document.querySelectorAll('.velocity-backwards');
        velocityBackwardsElement.forEach(function(link) {
            link.addEventListener('click', function (e) {
                e.preventDefault();

                // Element that we animate
                const currentElements = link.closest('.velocity-container').querySelectorAll('.card');

                // Add animation class to panel element
                Velocity(currentElements, 'transition.slideDownOut', {
                    stagger: 400,
                    backwards: true
                });
                Velocity(currentElements, {
                    opacity: 1
                }, {
                  duration: 500,
                  display: 'block'
                });
            });
        });


        //
        // Animation callbacks
        //

        // Begin callback
        const velocityBeginElement = document.querySelectorAll('.velocity-begin');
        velocityBeginElement.forEach(function(link) {
            link.addEventListener('click', function (e) {
                e.preventDefault();

                // Element that we animate
                const currentElements = link.closest('.velocity-container').querySelectorAll('.row');

                // Add animation class to panel element
                Velocity(currentElements, {
                    marginLeft: 20,
                    marginRight: 20,
                    opacity: 0.5
                }, {
                    begin: function() {
                        alert('Begin callback example');
                    }
                });
                Velocity(currentElements, "reverse", {
                    delay: 1000,
                    complete: function() {
                        currentElements.forEach(function(cards) {
                            cards.removeAttribute('style');
                        });
                    }
                });
            });
        });

        // Complete callback
        const velocityCompleteElement = document.querySelectorAll('.velocity-complete');
        velocityCompleteElement.forEach(function(link) {
            link.addEventListener('click', function (e) {
                e.preventDefault();

                // Element that we animate
                const currentElements = link.closest('.velocity-container').querySelectorAll('.row');

                // Add animation class to panel element
                Velocity(currentElements, {
                    marginLeft: 20,
                    marginRight: 20,
                    opacity: 0.5
                }, {
                    complete: function() {
                        alert('Complete callback example');
                    }
                });
                Velocity(currentElements, "reverse", {
                    delay: 1000,
                    complete: function() {
                        currentElements.forEach(function(cards) {
                            cards.removeAttribute('style');
                        });
                    }
                });
            });
        });

        // Progress callback
        const velocityProgressElement = document.querySelectorAll('.velocity-progress');
        velocityProgressElement.forEach(function(link) {
            link.addEventListener('click', function (e) {
                e.preventDefault();

                // Element that we animate
                const currentElements = link.closest('.velocity-container').querySelectorAll('.row');
                const percentage = document.querySelector('#percentComplete');
                const time = document.querySelector('#timeRemaining');

                // Add animation class to panel element
                Velocity(currentElements, {
                    marginLeft: 20,
                    marginRight: 20,
                    opacity: 0.5
                }, {
                    duration: 1000,
                    progress: function(elements, percentComplete, timeRemaining, timeStart) {
                        percentage.innerHTML = Math.round(percentComplete * 100) + '% complete.';
                        time.innerHTML = timeRemaining + 'ms remaining.';
                    }
                });
                Velocity(currentElements, "reverse", {
                    delay: 1000,
                    complete: function() {
                        currentElements.forEach(function(cards) {
                            cards.removeAttribute('style');
                        });
                    }
                });
            });
        });
    }


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentAnimationVelocityAdvanced();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    AnimationsVelocityAdvanced.init();
});
