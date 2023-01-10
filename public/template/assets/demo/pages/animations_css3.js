/* ------------------------------------------------------------------------------
 *
 *  # CSS3 animations
 *
 *  Demo JS code for animations_css3.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const AnimationsCSS3 = function() {


    //
    // Setup module components
    //

    // CSS3 animations
    const _componentAnimationCSS = function() {

        // Toggle animations
        const animationClass = document.querySelectorAll('.animation');
        animationClass.forEach(function(element) {
            element.addEventListener('click', function (e) {
                e.preventDefault();

                // Get animation class from 'data' attribute
                const animation = this.getAttribute('data-animation');
                const animationTarget = this.closest('.card');

                animationTarget.classList.add('animated', animation);

                animationTarget.addEventListener('animationend', function() {
                    animationTarget.classList.remove('animated', animation);
                });
            });
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentAnimationCSS();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    AnimationsCSS3.init();
});
