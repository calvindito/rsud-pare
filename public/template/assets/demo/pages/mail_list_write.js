/* ------------------------------------------------------------------------------
 *
 *  # Inbox page - Writing
 *
 *  Demo JS code for mail_list_write.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const MailListWrite = function() {


    //
    // Setup module components
    //

    // Quill
    const _componentQuill = function() {
        if (typeof Quill == 'undefined') {
            console.warn('Warning - quill.min.js is not loaded.');
            return;
        }

        // Basic examples
        // ------------------------------

        // Basic example
        const quillBasic = new Quill('#editor', {
            bounds: '.content-inner',
            placeholder: 'Please add your text here...',
            theme: 'snow'
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentQuill();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    MailListWrite.init();
});
