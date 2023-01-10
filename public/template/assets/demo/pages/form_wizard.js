/* ------------------------------------------------------------------------------
 *
 *  # Steps wizard
 *
 *  Demo JS code for form_wizard.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const FormWizard = function() {


    //
    // Setup module components
    //

    // Wizard
    const _componentWizard = function() {
        if (!$().steps) {
            console.warn('Warning - steps.min.js is not loaded.');
            return;
        }

        // Basic wizard setup
        $('.steps-basic').steps({
            headerTag: 'h6',
            bodyTag: 'fieldset',
            transitionEffect: 'fade',
            titleTemplate: '<span class="number">#index#</span> #title#',
            labels: {
                previous: document.dir == 'rtl' ? '<i class="ph-arrow-circle-right me-2"></i> Previous' : '<i class="ph-arrow-circle-left me-2"></i> Previous',
                next: document.dir == 'rtl' ? 'Next <i class="ph-arrow-circle-left ms-2"></i>' : 'Next <i class="ph-arrow-circle-right ms-2"></i>',
                finish: 'Submit form <i class="ph-paper-plane-tilt ms-2"></i>'
            },
            onFinished: function (event, currentIndex) {
                alert('Form submitted.');
            }
        });

        // Async content loading
        $('.steps-async').steps({
            headerTag: 'h6',
            bodyTag: 'fieldset',
            transitionEffect: 'fade',
            titleTemplate: '<span class="number">#index#</span> #title#',
            loadingTemplate: '<div class="card-body text-center"><i class="icon-spinner2 spinner me-2"></i>  #text#</div>',
            labels: {
                previous: document.dir == 'rtl' ? '<i class="ph-arrow-circle-right me-2"></i> Previous' : '<i class="ph-arrow-circle-left me-2"></i> Previous',
                next: document.dir == 'rtl' ? 'Next <i class="ph-arrow-circle-left ms-2"></i>' : 'Next <i class="ph-arrow-circle-right ms-2"></i>',
                finish: 'Submit form <i class="ph-paper-plane-tilt ms-2"></i>'
            },
            onContentLoaded: function (event, currentIndex) {
                $(this).find('.card-body').addClass('hide');
            },
            onFinished: function (event, currentIndex) {
                alert('Form submitted.');
            }
        });

        // Specify custom starting step
        $('.steps-starting-step').steps({
            headerTag: 'h6',
            bodyTag: 'fieldset',
            titleTemplate: '<span class="number">#index#</span> #title#',
            labels: {
                previous: document.dir == 'rtl' ? '<i class="ph-arrow-circle-right me-2"></i> Previous' : '<i class="ph-arrow-circle-left me-2"></i> Previous',
                next: document.dir == 'rtl' ? 'Next <i class="ph-arrow-circle-left ms-2"></i>' : 'Next <i class="ph-arrow-circle-right ms-2"></i>',
                finish: 'Submit form <i class="ph-paper-plane-tilt ms-2"></i>'
            },
            transitionEffect: 'fade',
            startIndex: 2,
            autoFocus: true,
            onFinished: function (event, currentIndex) {
                alert('Form submitted.');
            }
        });

        // Enable all steps and make them clickable
        $('.steps-enable-all').steps({
            headerTag: 'h6',
            bodyTag: 'fieldset',
            transitionEffect: 'fade',
            enableAllSteps: true,
            titleTemplate: '<span class="number">#index#</span> #title#',
            labels: {
                previous: document.dir == 'rtl' ? '<i class="ph-arrow-circle-right me-2"></i> Previous' : '<i class="ph-arrow-circle-left me-2"></i> Previous',
                next: document.dir == 'rtl' ? 'Next <i class="ph-arrow-circle-left ms-2"></i>' : 'Next <i class="ph-arrow-circle-right ms-2"></i>',
                finish: 'Submit form <i class="ph-paper-plane-tilt ms-2"></i>'
            },
            onFinished: function (event, currentIndex) {
                alert('Form submitted.');
            }
        });


        //
        // Wizard with validation
        //

        // Stop function if validation is missing
        if (!$().validate) {
            console.warn('Warning - validate.min.js is not loaded.');
            return;
        }

        // Show form
        const validationExampleElement = $('.steps-validation');
        const form = validationExampleElement.show();


        // Initialize wizard
        validationExampleElement.steps({
            headerTag: 'h6',
            bodyTag: 'fieldset',
            titleTemplate: '<span class="number">#index#</span> #title#',
            labels: {
                previous: document.dir == 'rtl' ? '<i class="ph-arrow-circle-right me-2"></i> Previous' : '<i class="ph-arrow-circle-left me-2"></i> Previous',
                next: document.dir == 'rtl' ? 'Next <i class="ph-arrow-circle-left ms-2"></i>' : 'Next <i class="ph-arrow-circle-right ms-2"></i>',
                finish: 'Submit form <i class="ph-paper-plane-tilt ms-2"></i>'
            },
            transitionEffect: 'fade',
            autoFocus: true,
            onStepChanging: function (event, currentIndex, newIndex) {

                // Allways allow previous action even if the current form is not valid!
                if (currentIndex > newIndex) {
                    return true;
                }

                // Needed in some cases if the user went back (clean up)
                if (currentIndex < newIndex) {

                    // To remove error styles
                    form.find('.body:eq(' + newIndex + ') label.error').remove();
                    form.find('.body:eq(' + newIndex + ') .error').removeClass('error');
                }

                form.validate().settings.ignore = ':disabled,:hidden';
                return form.valid();
            },
            onFinishing: function (event, currentIndex) {
                form.validate().settings.ignore = ':disabled';
                return form.valid();
            },
            onFinished: function (event, currentIndex) {
                alert('Submitted!');
            }
        });


        // Initialize validation
        validationExampleElement.validate({
            ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
            errorClass: 'validation-invalid-label',
            highlight: function(element, errorClass) {
                $(element).removeClass(errorClass);
            },
            unhighlight: function(element, errorClass) {
                $(element).removeClass(errorClass);
            },

            // Different components require proper error label placement
            errorPlacement: function(error, element) {

                // Input with icons and Select2
                if (element.hasClass('select2-hidden-accessible')) {
                    error.appendTo(element.parent());
                }

                // Input group, form checks and custom controls
                else if (element.parents().hasClass('form-control-feedback') || element.parents().hasClass('form-check') || element.parents().hasClass('input-group')) {
                    error.appendTo(element.parent().parent());
                }

                // Other elements
                else {
                    error.insertAfter(element);
                }
            },
            rules: {
                email: {
                    email: true
                }
            }
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentWizard();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    FormWizard.init();
});
