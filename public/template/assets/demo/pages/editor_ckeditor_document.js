/* ------------------------------------------------------------------------------
 *
 *  # CKEditor Document editor
 *
 *  Demo JS code for editor_ckeditor_document.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const CKEditorDocument = function() {


    //
    // Setup module components
    //

    // Document editor
    const _componentCKEditorDocument = function() {
        if (typeof DecoupledEditor == 'undefined') {
            console.warn('Warning - ckeditor_document.js is not loaded.');
            return;
        }

        // Basic example
        DecoupledEditor.create(document.querySelector('#document_editor_basic .document-editor-editable'), {
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
            const toolbarContainer = document.querySelector('#document_editor_basic .document-editor-toolbar');
            toolbarContainer.appendChild(editor.ui.view.toolbar.element);
        })
        .catch(error => {
            console.error(error);
        });

        // Empty with placeholder
        DecoupledEditor.create(document.querySelector('#document_editor_empty .document-editor-editable'), {
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
            const toolbarContainer = document.querySelector('#document_editor_empty .document-editor-toolbar');
            toolbarContainer.appendChild(editor.ui.view.toolbar.element);
            window.editor = editor;
        })
        .catch(error => {
            console.error(error);
        });

        // Readonly editor
        DecoupledEditor.create(document.querySelector('#document_editor_readonly .document-editor-editable'), {
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

            // Toggle state
            const editorElement = document.querySelector("#ckeditor_document_readonly_toggle");
            if(editorElement) {
                editorElement.addEventListener("click", () => {
                    editor.isReadOnly =! editor.isReadOnly;
                    editorElement.innerHTML = editor.isReadOnly ? '<i class="ph-eye me-2"></i> Switch to editable mode' : '<i class="ph-eye-slash me-2"></i> Switch to read-only mode';
                });
            }

            // Toolbar
            const toolbarContainer = document.querySelector('#document_editor_readonly .document-editor-toolbar');
            toolbarContainer.appendChild(editor.ui.view.toolbar.element);
        }).catch(error => {
            console.error(error);
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentCKEditorDocument();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    CKEditorDocument.init();
});
