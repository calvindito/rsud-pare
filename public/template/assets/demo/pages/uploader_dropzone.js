/* ------------------------------------------------------------------------------
 *
 *  # Dropzone multiple file uploader
 *
 *  Demo JS code for uploader_dropzone.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const DropzoneUploader = function() {


    //
    // Setup module components
    //

    // Dropzone file uploader
    const _componentDropzone = function() {
        if (typeof Dropzone == 'undefined') {
            console.warn('Warning - dropzone.min.js is not loaded.');
            return;
        }

        // Multiple files
        let dropzoneMultiple = new Dropzone("#dropzone_multiple", {
            url: "#",
            paramName: "file", // The name that will be used to transfer the file
            dictDefaultMessage: 'Drop files to upload <div>or CLICK</div>',
            maxFilesize: 0.1 // MB
        });

        // Single files
        let dropzoneSingle = new Dropzone("#dropzone_single", {
            url: "#",
            paramName: "file", // The name that will be used to transfer the file
            maxFilesize: 1, // MB
            maxFiles: 1,
            dictDefaultMessage: 'Drop file to upload <span>or CLICK</span>',
            autoProcessQueue: false,
            init: function() {
                this.on('addedfile', function(file){
                    if (this.fileTracker) {
                    this.removeFile(this.fileTracker);
                }
                    this.fileTracker = file;
                });
            }
        });

        // Accepted files
        let dropzoneFiles = new Dropzone("#dropzone_accepted_files", {
            url: "#",
            paramName: "file", // The name that will be used to transfer the file
            dictDefaultMessage: 'Drop files to upload <span>or CLICK</span>',
            maxFilesize: 1, // MB
            acceptedFiles: 'image/*'
        });

        // Removable thumbnails
        let dropzoneRemove = new Dropzone("#dropzone_remove", {
            url: "#",
            paramName: "file", // The name that will be used to transfer the file
            dictDefaultMessage: 'Drop files to upload <span>or CLICK</span>',
            maxFilesize: 1, // MB
            addRemoveLinks: true
        });

        // File limitations
        let dropzoneFileLimits = new Dropzone("#dropzone_file_limits", {
            url: "#",
            paramName: "file", // The name that will be used to transfer the file
            dictDefaultMessage: 'Drop files to upload <span>or CLICK</span>',
            maxFilesize: 0.4, // MB
            maxFiles: 4,
            maxThumbnailFilesize: 1,
            addRemoveLinks: true
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentDropzone();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    DropzoneUploader.init();
});
