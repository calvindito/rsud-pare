/* ------------------------------------------------------------------------------
 *
 *  # Bootstrap modals and extensions
 *
 *  Demo JS code for components_modals.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const Modals = function () {


    //
    // Setup module components
    //

    // Load remote content
    const _componentModalRemote = function() {
        function load(url, element) {
            req = new XMLHttpRequest();
            req.open("GET", url, false);
            req.send(null);

            element.innerHTML = req.responseText; 
        }

        const remoteDataModal = document.getElementById('modal_remote');
        if(remoteDataModal) {
            remoteDataModal.addEventListener('show.bs.modal', function() {
                load("../../../assets/demo/data/wizard/education.html", remoteDataModal.querySelector('.modal-body'));
            });
        }
    };

    // Modal callbacks
    const _componentModalCallbacks = function() {

        // onShow callback
        const onShowCallbackModal = document.getElementById('modal_onshow');
        if(onShowCallbackModal) {
            onShowCallbackModal.addEventListener('show.bs.modal', function() {
                alert('onShow callback fired.')
            });
        }

        // onShown callback
        const onShownCallbackModal = document.getElementById('modal_onshown');
        if(onShownCallbackModal) {
            onShownCallbackModal.addEventListener('shown.bs.modal', function() {
                alert('onShown callback fired.')
            });
        }

        // onHide callback
        const onHideCallbackModal = document.getElementById('modal_onhide');
        if(onHideCallbackModal) {
            onHideCallbackModal.addEventListener('hide.bs.modal', function() {
                alert('onHide callback fired.')
            });
        }

        // onHidden callback
        const onHiddenCallbackModal = document.getElementById('modal_onhidden');
        if(onHiddenCallbackModal) {
            onHiddenCallbackModal.addEventListener('hidden.bs.modal', function() {
                alert('onHidden callback fired.')
            });
        }
    };

    // Bootbox extension
    const _componentModalBootbox = function() {
        if (typeof bootbox == 'undefined') {
            console.warn('Warning - bootbox.min.js is not loaded.');
            return;
        }

        // Alert dialog
        const bbAlert = document.querySelector('#alert');
        if(bbAlert) {
            bbAlert.addEventListener('click', function() {
                bootbox.alert({
                    title: 'Check this out!',
                    message: 'Native alert dialog has been replaced with Bootbox alert box.'
                });
            });
        }

        // Confirmation dialog
        const bbConfirm = document.querySelector('#confirm');
        if(bbConfirm) {
            bbConfirm.addEventListener('click', function() {
                bootbox.confirm({
                    title: 'Confirm dialog',
                    message: 'Native confirm dialog has been replaced with Bootbox confirm box.',
                    buttons: {
                        confirm: {
                            label: 'Yes',
                            className: 'btn-primary'
                        },
                        cancel: {
                            label: 'Cancel',
                            className: 'btn-link'
                        }
                    },
                    callback: function (result) {
                        bootbox.alert({
                            title: 'Confirmation result',
                            message: 'Confirm result: ' + result
                        });
                    }
                });
            });
        }

        // Prompt dialog
        const bbPrompt = document.querySelector('#prompt');
        if(bbPrompt) {
            bbPrompt.addEventListener('click', function() {
                bootbox.prompt({
                    title: 'Please enter your name',
                    buttons: {
                        confirm: {
                            label: 'Yes',
                            className: 'btn-primary'
                        },
                        cancel: {
                            label: 'Cancel',
                            className: 'btn-link'
                        }
                    },
                    callback: function (result) {
                        if (result === null) {                                             
                            bootbox.alert({
                                title: 'Prompt dismissed',
                                message: 'You have cancelled this damn thing'
                            });                              
                        } else {
                            bootbox.alert({
                                title: 'Hi <strong>' + result + '</strong>',
                                message: 'How are you doing today?'
                            });                              
                        }
                    }
                });
            });
        }

        // Prompt dialog with default value
        const bbPromptValue = document.querySelector('#prompt_value');
        if(bbPromptValue) {
            bbPromptValue.addEventListener('click', function() {
                bootbox.prompt({
                    title: 'What is your real name?',
                    value: 'Eugene Kopyov',
                    buttons: {
                        confirm: {
                            label: 'Yes',
                            className: 'btn-primary'
                        },
                        cancel: {
                            label: 'Cancel',
                            className: 'btn-link'
                        }
                    },
                    callback: function(result) {
                        if (result === null) {                                             
                            bootbox.alert({
                                title: 'Prompt dismissed',
                                message: 'You have cancelled this damn thing'
                            });                              
                        } else {
                            bootbox.alert({
                                title: 'Hi <strong>' + result + '</strong>',
                                message: 'How are you doing today?'
                            });                              
                        }
                    }
                });
            });
        }

        // Custom bootbox dialog
        const bbCustom = document.querySelector('#bootbox_custom');
        if(bbCustom) {
            bbCustom.addEventListener('click', function() {
                bootbox.dialog({
                    message: 'I am a custom dialog',
                    title: 'Custom title',
                    buttons: {
                        success: {
                            label: 'Success!',
                            className: 'btn-success',
                            callback: function() {
                                bootbox.alert({
                                    title: 'Success!',
                                    message: 'This is a great success!'
                                });
                            }
                        },
                        danger: {
                            label: 'Danger!',
                            className: 'btn-danger',
                            callback: function() {
                                bootbox.alert({
                                    title: 'Ohh noooo!',
                                    message: 'Uh oh, look out!'
                                });
                            }
                        },
                        main: {
                            label: 'Click ME!',
                            className: 'btn-primary',
                            callback: function() {
                                bootbox.alert({
                                    title: 'Hooray!',
                                    message: 'Something awesome just happened!'
                                });
                            }
                        }
                    }
                });
            });
        }

        // Custom bootbox dialog with form
        const bbForm = document.querySelector('#bootbox_form');
        if(bbForm) {
            bbForm.addEventListener('click', function() {
                bootbox.dialog({
                        title: 'This is a form in a modal.',
                        message: '<form action="">' +
                                    '<div class="row mb-3">' +
                                        '<label class="col-md-4 col-form-label">Name</label>' +
                                        '<div class="col-md-8">' +
                                            '<input id="name" name="name" type="text" placeholder="Your name" class="form-control">' +
                                            '<div class="form-text text-muted">Here goes your name</div>' +
                                        '</div>' +
                                    '</div>' +
                                    '<div class="row">' +
                                        '<label class="col-md-4 col-form-label">How awesome is this?</label>' +
                                        '<div class="col-md-8">' +
                                            '<div class="form-check-horizontal">' +
                                                '<div class="form-check mb-2">' +
                                                    '<label class="form-check-label">' +
                                                        '<input type="radio" class="form-check-input" name="awesomeness" id="awesomeness-0" value="Really awesome" checked>' +
                                                        'Really awesome' +
                                                    '</label>' +
                                                '</div>' +
                                                '<div class="form-check">' +
                                                    '<label class="form-check-label">' +
                                                        '<input type="radio" class="form-check-input" name="awesomeness" id="awesomeness-1" value="Super cool">' +
                                                        'Super cool' +
                                                    '</label>' +
                                                '</div>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>' +
                                '</form>',
                        buttons: {
                            success: {
                                label: 'Save',
                                className: 'btn-success',
                                callback: function () {
                                    const name = document.querySelector('#name').value;
                                    const answer = document.querySelector('input[name="awesomeness"]:checked').value;
                                    bootbox.alert({
                                        title: 'Hello ' + name + '!',
                                        message: 'You have chosen <strong>' + answer + '</strong>.'
                                    });
                                }
                            }
                        }
                    }
                );
            });
        }
    };


    //
    // Return objects assigned to module
    //

    return {
        initComponents: function() {
            _componentModalRemote();
            _componentModalCallbacks();
            _componentModalBootbox();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    Modals.initComponents();
});
