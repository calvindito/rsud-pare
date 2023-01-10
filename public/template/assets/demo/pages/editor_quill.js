/* ------------------------------------------------------------------------------
 *
 *  # Quill editor
 *
 *  Demo JS code for editor_quill.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const QuillEditor = function() {


    //
    // Setup module components
    //

    // Quill editor
    const _componentQuill = function() {
        if (typeof Quill == 'undefined') {
            console.warn('Warning - summernote.min.js is not loaded.');
            return;
        }

        // Basic examples
        // ------------------------------

        // Basic example
        const quillBasic = new Quill('.quill-basic', {
            bounds: '.content-inner',
            placeholder: 'Please add your text here...',
            theme: 'snow'
        });

        // Full features example
        const quillFull = new Quill('.quill-full', {
            modules: {
                toolbar: [
                    [{ 'font': [] }],
                    [{ 'size': ['small', false, 'large', 'huge'] }],
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote', 'code-block'],
                    [{ 'header': 1 }, { 'header': 2 }],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'script': 'sub'}, { 'script': 'super' }],
                    [{ 'indent': '-1'}, { 'indent': '+1' }],
                    [{ 'direction': 'rtl' }],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'align': [] }],
                    [ 'formula', 'image', 'video' ],
                    ['clean']
                ]
            },
            bounds: '.content-inner',
            placeholder: 'Please add your text here...',
            theme: 'snow'
        });

        // Empty editor with placeholder
        const quillPlaceholder = new Quill('.quill-placeholder', {
            bounds: '.content-inner',
            placeholder: 'Please add your text here...',
            theme: 'snow'
        });

        // Scrollable editor
        const quillReadonly = new Quill('.quill-scrollable', {
            bounds: '.content-inner',
            scrollingContainer: 'quill-scrollable-container',
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
    QuillEditor.init();
});
