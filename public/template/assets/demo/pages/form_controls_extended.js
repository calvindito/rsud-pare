/* ------------------------------------------------------------------------------
 *
 *  # Extended form controls
 *
 *  Demo JS code for form_controls_extended.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const ExtendedFormControls = function() {


    //
    // Setup module components
    //

    // Mask input
    const _componentMaskInput = function() {
        if (typeof IMask == 'undefined') {
            console.warn('Warning - imask.min.js is not loaded.');
            return;
        }

        // Date range
        const maskDateElement = document.querySelector('#mask_date');
        if(maskDateElement) {
            const maskDate = IMask(maskDateElement, {
                mask: Date,
                min: new Date(1990, 0, 1),
                max: new Date(2020, 0, 1)
            });
        }

        // Phone #
        const maskPhoneElement = document.querySelector('#mask_phone');
        if(maskPhoneElement) {
            const maskPhone = IMask(maskPhoneElement, {
                mask: '+{3}(000)000-00-00'
            });
        }

        // Phone # with extension
        const maskPhoneExtElement = document.querySelector('#mask_phone_ext');
        if(maskPhoneExtElement) {
            const maskPhoneExt = IMask(maskPhoneExtElement, {
                mask: '+{3}(000)000-00-00 / a00000'
            });
        }

        // Phone # in international format
        const maskPhoneIntElement = document.querySelector('#mask_phone_int');
        if(maskPhoneIntElement) {
            const maskPhoneInt = IMask(maskPhoneIntElement, {
                mask: '+{3}0 000 000 000'
            });
        }

        // Currency
        const maskCurrencyElement = document.querySelector('#mask_currency');
        if(maskCurrencyElement) {
            const maskCurrency = IMask(maskCurrencyElement, {
                mask: '$num',
                blocks: {
                    num: {
                        mask: Number,
                        thousandsSeparator: ','
                    }
                }
            });
        }

        // Tax number
        const maskTaxElement = document.querySelector('#mask_tax');
        if(maskTaxElement) {
            const maskTax = IMask(maskTaxElement, {
                mask: '00-000000'
            });
        }

        // SSN number
        const maskSsnElement = document.querySelector('#mask_ssn');
        if(maskSsnElement) {
            const maskSsn = IMask(maskSsnElement, {
                mask: '000-00-0000'
            });
        }

        // Credit card number
        const maskCardElement = document.querySelector('#mask_card');
        if(maskCardElement) {
            const maskCard = IMask(maskCardElement, {
                mask: '0000-0000-0000-0000'
            });
        }

        // Product key
        const maskProductKeyElement = document.querySelector('#mask_product_key');
        if(maskProductKeyElement) {
            const maskProductKey = IMask(maskProductKeyElement, {
                mask: 'a*-000-a000'
            });
        }

        // Order number
        const maskOrderElement = document.querySelector('#mask_order');
        if(maskOrderElement) {
            const maskOrder = IMask(maskOrderElement, {
                mask: 'aaa-000-***'
            });
        }

        // ISBN number
        const maskIsbnElement = document.querySelector('#mask_isbn');
        if(maskIsbnElement) {
            const maskIsbn = IMask(maskIsbnElement, {
                mask: '000-00-000-0000-0'
            });
        }

        // Dynamic mask
        const maskDynamicElment = document.querySelector('#mask_dynamic');
        if(maskDynamicElment) {
            const maskDynamic = IMask(maskDynamicElment, {
                mask: [
                    {
                        mask: '+{3}(000)000-00-00'
                    },
                    {
                        mask: /^\S*@?\S*$/
                    }
                ]
            });
        }
    };

    // Autosize
    const _componentAutosize = function() {
        if (typeof autosize == 'undefined') {
            console.warn('Warning - autosize.min.js is not loaded.');
            return;
        }

        // Basic example
        autosize(document.querySelectorAll('.elastic'));

        // Manual trigger
        const manualElement = document.querySelector('.elastic-manual');
        const manualElementTrigger = document.querySelector('.elastic-manual-trigger');
        manualElementTrigger.addEventListener('click', function() {
            const manual = autosize(manualElement);
            manualElement.value = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sed ultricies nibh, sed faucibus eros. Vivamus tristique fringilla ante, vitae pellentesque quam porta vel. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nunc vehicula gravida nisl non imperdiet. Mauris felis odio, vehicula et laoreet non, tempor non enim. Cras convallis sapien hendrerit nibh sagittis sollicitudin. Fusce nec ultricies justo. Interdum et malesuada fames ac ante ipsum primis in faucibus. Fusce ac urna in dui consequat cursus vel sit amet mauris. Proin nec bibendum arcu. Aenean sit amet nisi mi. Sed non leo nisl. Mauris leo odio, ultricies interdum ornare ac, posuere eu risus. Suspendisse adipiscing sapien sit amet gravida sollicitudin. Maecenas laoreet velit in dui adipiscing, vel fermentum tellus ullamcorper. Nullam et mi rhoncus, tempus nulla sit amet, varius ipsum.';
            autosize.update(manual);
        });

        // Events
        const eventsElement = document.querySelector('.elastic-events');
        const eventsElementTrigger = document.querySelector('.elastic-events-trigger');
        eventsElementTrigger.addEventListener('click', function() {
            const events = autosize(eventsElement);
            eventsElement.value = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sed ultricies nibh, sed faucibus eros. Vivamus tristique fringilla ante, vitae pellentesque quam porta vel. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nunc vehicula gravida nisl non imperdiet. Mauris felis odio, vehicula et laoreet non, tempor non enim. Cras convallis sapien hendrerit nibh sagittis sollicitudin. Fusce nec ultricies justo. Interdum et malesuada fames ac ante ipsum primis in faucibus. Fusce ac urna in dui consequat cursus vel sit amet mauris. Proin nec bibendum arcu. Aenean sit amet nisi mi. Sed non leo nisl. Mauris leo odio, ultricies interdum ornare ac, posuere eu risus. Suspendisse adipiscing sapien sit amet gravida sollicitudin. Maecenas laoreet velit in dui adipiscing, vel fermentum tellus ullamcorper. Nullam et mi rhoncus, tempus nulla sit amet, varius ipsum.';
            autosize.update(events);
        });
        eventsElement.addEventListener('autosize:resized', function(){
          console.log('textarea height updated');
        });

        // Destroy method
        const destroyAutosize = autosize(document.querySelector('.elastic-destroy'));
        document.querySelector('.elastic-destroy-trigger').addEventListener('click', function() {
            autosize.destroy(destroyAutosize);
        });
    };

    // Passy
    const _componentPassy = function() {
        if (!$().passy) {
            console.warn('Warning - passy.js is not loaded.');
            return;
        }

        // Input badges
        const $inputText = $('.text-indicator');
        const $inputLabel = $('.badge-indicator');
        const $inputLabelAbsolute = $('.badge-indicator-absolute');
        const $inputGroup = $('.group-indicator');

        // Output badges
        const $outputText = $('.password-indicator-text');
        const $outputLabel = $('.password-indicator-badge');
        const $outputLabelAbsolute = $('.password-indicator-badge-absolute');
        const $outputGroup = $('.password-indicator-group');



        // Min input length
        $.passy.requirements.length.min = 4;


        // Strength meter
        const feedbackText = [
            {text: '<i class="ph-check me-1"></i> Your password is weak', color: 'text-danger'},
            {text: '<i class="ph-check me-1"></i> Your password is normal', color: 'text-secondary'},
            {text: '<i class="ph-shield-check me-1"></i> Your password is good', color: 'text-primary'},
            {text: '<i class="ph-shield-check me-1"></i> Your password is strong', color: 'text-success'}
        ];
        const feedbackLabel = [
            {color: 'bg-danger', text: 'Weak'},
            {color: 'bg-secondary', text: 'Normal'},
            {color: 'bg-primary', text: 'Good'},
            {color: 'bg-success', text: 'Strong'}
        ];
        const feedbackGroup = [
            {color: 'bg-danger border-danger text-white', text: 'Weak'},
            {color: 'bg-secondary border-secondary text-white', text: 'Normal'},
            {color: 'bg-primary border-primary text-white', text: 'Good'},
            {color: 'bg-success border-success text-white', text: 'Strong'}
        ];


        //
        // Setup strength meter
        //

        // Text indicator
        $inputText.passy(function(strength) {
            $outputText.html(feedbackText[strength].text);
            $outputText.addClass(feedbackText[strength].color);
        });

        // Label indicator
        $inputLabel.passy(function(strength) {
            $outputLabel.text(feedbackLabel[strength].text);
            $outputLabel.addClass(feedbackLabel[strength].color);
        });

        // Absolute positioned badge
        $inputLabelAbsolute.passy(function(strength) {
            $outputLabelAbsolute.text(feedbackLabel[strength].text);
            $outputLabelAbsolute.addClass(feedbackLabel[strength].color);
        });

        // Input group indicator
        $inputGroup.passy(function(strength) {
            $outputGroup.text(feedbackGroup[strength].text);
            $outputGroup.addClass(feedbackGroup[strength].color);
        });


        //
        // Initialize
        //

        // Text
        $('.generate-text').on('click', function() {
            $inputText.passy('generate', 12);
        });

        // Label
        $('.generate-badge').on('click', function() {
            $inputLabel.passy('generate', 12);
        });

        // Absolute badge
        $('.generate-badge-absolute').on('click', function() {
            $inputLabelAbsolute.passy('generate', 10);
        });

        // Group badge
        $('.generate-group').on('click', function() {
            $inputGroup.passy('generate', 8);
        });
    };

    // Maxlength
    const _componentMaxlength = function() {
        if (!$().maxlength) {
            console.warn('Warning - maxlength.min.js is not loaded.');
            return;
        }

        // Basic example
        $('.maxlength').maxlength({
            placement: document.dir == "rtl" ? 'bottom-left-inside' : 'bottom-right-inside'
        });

        // Threshold
        $('.maxlength-threshold').maxlength({
            threshold: 15,
            placement: document.dir == "rtl" ? 'bottom-left-inside' : 'bottom-right-inside'
        });

        // Custom badge color
        $('.maxlength-custom').maxlength({
            threshold: 10,
            warningClass: 'badge bg-primary form-text',
            limitReachedClass: 'badge bg-danger form-text',
            placement: document.dir == "rtl" ? 'bottom-left-inside' : 'bottom-right-inside'
        });

        // Options
        $('.maxlength-options').maxlength({
            alwaysShow: true,
            threshold: 10,
            warningClass: 'text-success form-text',
            limitReachedClass: 'text-danger form-text',
            separator: ' of ',
            preText: 'You have ',
            postText: ' chars remaining.',
            validate: true,
            placement: document.dir == "rtl" ? 'bottom-left-inside' : 'bottom-right-inside'
        });

        // Always show badge
        $('.maxlength-textarea').maxlength({
            alwaysShow: true,
            placement: document.dir == "rtl" ? 'bottom-left-inside' : 'bottom-right-inside'
        });

        // Badge position
        $('.maxlength-badge-position').maxlength({
            alwaysShow: true,
            placement: 'centered-right',
            warningClass: 'text-success left-auto right-0 top-50 translate-middle-y pe-2 mr-1',
            limitReachedClass: 'text-danger left-auto right-0 top-50 translate-middle-y pe-2 mr-1',
            placement: document.dir == "rtl" ? 'centered-left' : 'centered-right'
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentMaskInput();
            _componentAutosize();
            _componentPassy();
            _componentMaxlength();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    ExtendedFormControls.init();
});
