/* ------------------------------------------------------------------------------
 *
 *  # CKEditor Balloon editor
 *
 *  Demo JS code for editor_ckeditor_balloon.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const CKEditorBalloon = function() {


    //
    // Setup module components
    //

    // CKEditor
    const _componentCKEditorBalloon = function() {
        if (typeof BalloonEditor == 'undefined') {
            console.warn('Warning - ckeditor_balloon.js is not loaded.');
            return;
        }

        // Balloon editor
        BalloonEditor.create(document.querySelector('#ckeditor_balloon_basic'), {
            heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                    { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                    { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                    { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                    { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                    { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                    { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                ]
            }
        }).catch(error => {
            console.error(error);
        });

        // Readonly editor
        BalloonEditor.create(document.querySelector('#ckeditor_balloon_readonly'), {
            heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                    { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                    { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                    { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                    { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                    { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                    { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                ]
            }
        }).then(editor => {
            window.editor = editor;
            const editorElement = document.querySelector("#ckeditor_balloon_readonly_toggle");
            if(editorElement) {
                editorElement.addEventListener("click", () => {
                    editor.isReadOnly =! editor.isReadOnly;
                    editorElement.innerHTML = editor.isReadOnly ? '<i class="ph-eye me-2"></i> Switch to editable mode' : '<i class="ph-eye-slash me-2"></i> Switch to read-only mode';
                });
            }
        }).catch(error => {
            console.error(error);
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentCKEditorBalloon();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    CKEditorBalloon.init();
});
