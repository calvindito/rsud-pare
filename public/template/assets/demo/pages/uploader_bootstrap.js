/* ------------------------------------------------------------------------------
 *
 *  # Bootstrap multiple file uploader
 *
 *  Demo JS code for uploader_bootstrap.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const FileUpload = function() {


    //
    // Setup module components
    //

    // Bootstrap file upload
    const _componentFileUpload = function() {
        if (!$().fileinput) {
            console.warn('Warning - fileinput.min.js is not loaded.');
            return;
        }

        //
        // Define variables
        //

        // Buttons inside zoom modal
        const previewZoomButtonClasses = {
            rotate: 'btn btn-light btn-icon btn-sm',
            toggleheader: 'btn btn-light btn-icon btn-header-toggle btn-sm',
            fullscreen: 'btn btn-light btn-icon btn-sm',
            borderless: 'btn btn-light btn-icon btn-sm',
            close: 'btn btn-light btn-icon btn-sm'
        };

        // Icons inside zoom modal classes
        const previewZoomButtonIcons = {
            prev: document.dir == 'rtl' ? '<i class="ph-arrow-right"></i>' : '<i class="ph-arrow-left"></i>',
            next: document.dir == 'rtl' ? '<i class="ph-arrow-left"></i>' : '<i class="ph-arrow-right"></i>',
            rotate: '<i class="ph-arrow-clockwise"></i>',
            toggleheader: '<i class="ph-arrows-down-up"></i>',
            fullscreen: '<i class="ph-corners-out"></i>',
            borderless: '<i class="ph-frame-corners"></i>',
            close: '<i class="ph-x"></i>'
        };

        // File actions
        const fileActionSettings = {
            zoomClass: '',
            zoomIcon: '<i class="ph-magnifying-glass-plus"></i>',
            dragClass: 'p-2',
            dragIcon: '<i class="ph-dots-six"></i>',
            removeClass: '',
            removeErrorClass: 'text-danger',
            removeIcon: '<i class="ph-trash"></i>',
            indicatorNew: '<i class="ph-file-plus text-success"></i>',
            indicatorSuccess: '<i class="ph-check file-icon-large text-success"></i>',
            indicatorError: '<i class="ph-x text-danger"></i>',
            indicatorLoading: '<i class="ph-spinner spinner text-muted"></i>'
        };


        //
        // Basic example
        //

        $('.file-input').fileinput({
            browseLabel: 'Browse',
            browseIcon: '<i class="ph-file-plus me-2"></i>',
            uploadIcon: '<i class="ph-file-arrow-up me-2"></i>',
            removeIcon: '<i class="ph-x fs-base me-2"></i>',
            layoutTemplates: {
                icon: '<i class="ph-check"></i>'
            },
            uploadClass: 'btn btn-light',
            removeClass: 'btn btn-light',
            initialCaption: "No file selected",
            previewZoomButtonClasses: previewZoomButtonClasses,
            previewZoomButtonIcons: previewZoomButtonIcons,
            fileActionSettings: fileActionSettings
        });


        //
        // Custom layout
        //

        $('.file-input-custom').fileinput({
            previewFileType: 'image',
            browseLabel: 'Select',
            browseClass: 'btn btn-secondary',
            browseIcon: '<i class="ph-image me-2"></i>',
            removeLabel: 'Remove',
            removeClass: 'btn btn-danger',
            removeIcon: '<i class="ph-x-square me-2"></i>',
            uploadClass: 'btn btn-teal',
            uploadIcon: '<i class="ph-upload-simple me-2"></i>',
            layoutTemplates: {
                icon: '<i class="ph-check"></i>'
            },
            initialCaption: "Please select image",
            mainClass: 'input-group',
            previewZoomButtonClasses: previewZoomButtonClasses,
            previewZoomButtonIcons: previewZoomButtonIcons,
            fileActionSettings: fileActionSettings
        });


        //
        // Hidden caption
        //

        $('.file-input-caption').fileinput({
            browseLabel: 'Browse',
            browseIcon: '<i class="ph-file-plus me-2"></i>',
            uploadIcon: '<i class="ph-file-arrow-up me-2"></i>',
            removeIcon: '<i class="ph-x fs-base me-2"></i>',
            layoutTemplates: {
                icon: '<i class="ph-check"></i>'
            },
            uploadClass: 'btn btn-light',
            removeClass: 'btn btn-light',
            initialCaption: "No file selected",
            previewZoomButtonClasses: previewZoomButtonClasses,
            previewZoomButtonIcons: previewZoomButtonIcons,
            fileActionSettings: fileActionSettings,
            showCaption: false,
            dropZoneEnabled: false
        });


        //
        // Template modifications
        //

        $('.file-input-advanced').fileinput({
            browseLabel: 'Browse',
            browseClass: 'btn btn-light',
            removeClass: 'btn btn-light',
            uploadClass: 'btn btn-success',
            browseIcon: '<i class="ph-file-plus me-2"></i>',
            uploadIcon: '<i class="ph-file-arrow-up me-2"></i>',
            removeIcon: '<i class="ph-x fs-base me-2"></i>',
            layoutTemplates: {
                icon: '<i class="ph-check"></i>',
                main1: "{preview}\n" +
                    "<div class='input-group {class}'>\n" +
                        "{browse}\n" +
                        "{caption}\n" +
                        "{upload}\n" +
                        "{remove}\n" +
                    "</div>"
            },
            initialCaption: "No file selected",
            previewZoomButtonClasses: previewZoomButtonClasses,
            previewZoomButtonIcons: previewZoomButtonIcons,
            fileActionSettings: fileActionSettings
        });


        //
        // Always display preview
        //

        $('.file-input-preview').fileinput({
            browseLabel: 'Browse',
            browseIcon: '<i class="ph-file-plus me-2"></i>',
            uploadIcon: '<i class="ph-file-arrow-up me-2"></i>',
            removeIcon: '<i class="ph-x fs-base me-2"></i>',
            layoutTemplates: {
                icon: '<i class="ph-check"></i>'
            },
            uploadClass: 'btn btn-light',
            removeClass: 'btn btn-light',
            initialPreview: [
                '../../../assets/images/demo/images/1.png',
                '../../../assets/images/demo/images/2.png',
            ],
            initialPreviewConfig: [
                {caption: 'Jane.jpg', size: 930321, key: 1, url: '{$url}', showDrag: false},
                {caption: 'Anna.jpg', size: 1218822, key: 2, url: '{$url}', showDrag: false}
            ],
            initialPreviewAsData: true,
            overwriteInitial: false,
            maxFileSize: 100,
            previewZoomButtonClasses: previewZoomButtonClasses,
            previewZoomButtonIcons: previewZoomButtonIcons,
            fileActionSettings: fileActionSettings
        });


        //
        // Display preview on load
        //

        $('.file-input-overwrite').fileinput({
            browseLabel: 'Browse',
            browseIcon: '<i class="ph-file-plus me-2"></i>',
            uploadIcon: '<i class="ph-file-arrow-up me-2"></i>',
            removeIcon: '<i class="ph-x fs-base me-2"></i>',
            layoutTemplates: {
                icon: '<i class="ph-check"></i>'
            },
            uploadClass: 'btn btn-light',
            removeClass: 'btn btn-light',
            initialPreview: [
                '../../../assets/images/demo/images/1.png',
                '../../../assets/images/demo/images/2.png'
            ],
            initialPreviewConfig: [
                {caption: 'Jane.jpg', size: 930321, key: 1, url: '{$url}'},
                {caption: 'Anna.jpg', size: 1218822, key: 2, url: '{$url}'}
            ],
            initialPreviewAsData: true,
            overwriteInitial: true,
            previewZoomButtonClasses: previewZoomButtonClasses,
            previewZoomButtonIcons: previewZoomButtonIcons,
            fileActionSettings: fileActionSettings
        });


        //
        // AJAX upload
        //

        $('.file-input-ajax').fileinput({
            browseLabel: 'Browse',
            uploadUrl: "http://localhost", // server upload action
            uploadAsync: true,
            maxFileCount: 5,
            initialPreview: [],
            browseIcon: '<i class="ph-file-plus me-2"></i>',
            uploadIcon: '<i class="ph-file-arrow-up me-2"></i>',
            removeIcon: '<i class="ph-x fs-base me-2"></i>',
            fileActionSettings: {
                removeIcon: '<i class="ph-trash"></i>',
                removeClass: '',
                uploadIcon: '<i class="ph-upload-simple"></i>',
                uploadClass: '',
                zoomIcon: '<i class="ph-magnifying-glass-plus"></i>',
                zoomClass: '',
                indicatorNew: '<i class="ph-file-plus text-success"></i>',
                indicatorSuccess: '<i class="ph-check file-icon-large text-success"></i>',
                indicatorError: '<i class="ph-x text-danger"></i>',
                indicatorLoading: '<i class="ph-spinner spinner text-muted"></i>',
            },
            layoutTemplates: {
                icon: '<i class="ph-check"></i>'
            },
            uploadClass: 'btn btn-light',
            removeClass: 'btn btn-light',
            initialCaption: 'No file selected',
            previewZoomButtonClasses: previewZoomButtonClasses,
            previewZoomButtonIcons: previewZoomButtonIcons
        });


        //
        // Misc
        //

        // Disable/enable button
        $('#btn-modify').on('click', function() {
            $btn = $(this);
            if ($btn.text() == 'Disable file input') {
                $('#file-input-methods').fileinput('disable');
                $btn.html('Enable file input');
                alert('Hurray! I have disabled the input and hidden the upload button.');
            }
            else {
                $('#file-input-methods').fileinput('enable');
                $btn.html('Disable file input');
                alert('Hurray! I have reverted back the input to enabled with the upload button.');
            }
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentFileUpload();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    FileUpload.init();
});
