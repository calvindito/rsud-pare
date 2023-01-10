/* ------------------------------------------------------------------------------
 *
 *  # Sweet Alert component
 *
 *  Demo JS code for extra_sweetalert.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const SweetAlert = function () {


    //
    // Setup module components
    //

    // Sweet Alerts
    const _componentSweetAlert = function() {
        if (typeof swal == 'undefined') {
            console.warn('Warning - sweet_alert.min.js is not loaded.');
            return;
        }

        // Defaults
        const swalInit = swal.mixin({
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-light',
                    denyButton: 'btn btn-light',
                    input: 'form-control'
                }
            });


        //
        // Basic options
        //

        // Basic
        const swalBasicElement = document.querySelector('#sweet_basic');
        if(swalBasicElement) {
            swalBasicElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'Here is a message!'
                });
            });
        }

        // With title
        const swalTitleElement = document.querySelector('#sweet_title_text');
        if(swalTitleElement) {
            swalTitleElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'Here\'s a message!',
                    text: 'It\'s pretty, isn\'t it?'
                });
            });
        }

        // Close button
        const swalCloseElement = document.querySelector('#sweet_close');
        if(swalCloseElement) {
            swalCloseElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'Good job!',
                    text: 'You clicked the button!',
                    icon: 'success',
                    showCloseButton: true
                });
            });
        }

        // Custom padding
        const swalPaddingElement = document.querySelector('#sweet_padding');
        if(swalPaddingElement) {
            swalPaddingElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    icon: 'error',
                    padding: 40
                });
            });
        }

        // Custom width
        const swalWidthElement = document.querySelector('#sweet_width');
        if(swalWidthElement) {
            swalWidthElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'Got question?',
                    text: 'If you have any questions, don\t hesitate to let us know!',
                    icon: 'question',
                    width: '35%'
                });
            });
        }

        // Auto closing
        const swalAutoCloserElement = document.querySelector('#sweet_auto_closer');
        if(swalAutoCloserElement) {
            swalAutoCloserElement.addEventListener('click', function() {
                let timerInterval;
                swalInit.fire({
                    title: 'Auto close alert!',
                    html: 'I will close in <b></b> milliseconds.',
                    timer: 2500,
                    timerProgressBar: true,
                    didOpen: function() {
                        Swal.showLoading()
                        const b = Swal.getHtmlContainer().querySelector('b');
                        timerInterval = setInterval(() => {
                            b.textContent = Swal.getTimerLeft();
                        }, 100);
                    },
                    willClose: function() {
                        clearInterval(timerInterval)
                    }
                }).then(function (result) {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        console.log('I was closed by the timer')
                    }
                });
            });
        }

        // AJAX requests
        const swalAjaxElement = document.querySelector('#sweet_ajax');
        if(swalAjaxElement) {
            swalAjaxElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'Submit your Github username',
                    input: 'text',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    inputPlaceholder: 'Enter Github username',
                    showCancelButton: true,
                    confirmButtonText: 'Look up',
                    showLoaderOnConfirm: true,
                    preConfirm: function(login) {
                        return fetch('https://api.github.com/users/' + login)
                            .then(function(response) {
                                if(!response.ok) {
                                    throw new Error(response.statusText)
                                }
                                return response.json();
                            })
                            .catch(function(error) {
                                swalInit.showValidationMessage(
                                    'Request failed: ' + error
                                );
                            });
                    },
                    allowOutsideClick: false
                }).then(function(result) {
                    if(result.value) {
                        swalInit.fire({
                            title: result.value.login + '\'s avatar',
                            imageUrl: result.value.avatar_url
                        });
                    }
                });
            });
        }

        // HTML message
        const swalHtmlElement = document.querySelector('#sweet_html');
        if(swalHtmlElement) {
            swalHtmlElement.addEventListener('click', function() {
                swalInit.fire({
                    title: '<i>HTML</i> &nbsp; <span class="fw-light">example</span>',
                    icon: 'info',
                    html:
                        'You can use <strong>bold text</strong>, ' +
                        '<a href="//github.com">links</a> ' +
                        'and other HTML tags',
                    showCloseButton: true,
                    showCancelButton: true,
                    focusConfirm: false,
                    confirmButtonText: '<i class="ph-thumbs-up me-2"></i> Great!',
                    confirmButtonAriaLabel: 'Thumbs up, great!',
                    cancelButtonText: '<i class="ph-thumbs-down"></i>',
                    cancelButtonAriaLabel: 'Thumbs down'
                });
            });
        }

        // Image
        const swalImageElement = document.querySelector('#sweet_image');
        if(swalImageElement) {
            swalImageElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'Sweet!',
                    text: 'Bootstrap is awesome.',
                    imageUrl: 'https://getbootstrap.com/docs/4.1/assets/img/bootstrap-stack.png',
                    imageWidth: 260
                });
            });
        }

        // Background 
        const swalBackgroundElement = document.querySelector('#sweet_bg');
        if(swalBackgroundElement) {
            swalBackgroundElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'Sweet!',
                    icon: 'success',
                    text: 'Custom backgrounds are awesome.',
                    background: !document.documentElement.getAttribute('data-color-theme') || document.documentElement.getAttribute('data-color-theme') == 'light' ? '#fff url("../../../assets/images/demo/pattern.png") repeat' : '#383940 url("../../../assets/images/demo/pattern.png") repeat',
                });
            });
        }

        // Chaining notifications
        const swalChainElement = document.querySelector('#sweet_chain');
        async function chainedAlerts() {
            const steps = ['1', '2', '3'];
            const Queue = Swal.mixin({
                progressSteps: steps,
                confirmButtonText: document.dir == 'rtl' ? '&larr; Next' : 'Next &rarr;',
                input: 'text',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-light',
                    denyButton: 'btn btn-light',
                    input: 'form-control'
                },
                // optional classes to avoid backdrop blinking between steps
                showClass: { backdrop: 'swal2-noanimation' },
                hideClass: { backdrop: 'swal2-noanimation' }
            });

            await Queue.fire({
                title: 'Question 1',
                text: 'Step #1 - ask your first question',
                currentProgressStep: 0,
                inputPlaceholder: 'Enter your first question',
                // optional class to show fade-in backdrop animation which was disabled in Queue mixin
                showClass: { backdrop: 'swal2-noanimation' },
            });
            await Queue.fire({
                title: 'Question 2',
                text: 'Step #2 - ask your second question',
                inputPlaceholder: 'Enter your second question',
                currentProgressStep: 1
            });
            await Queue.fire({
                title: 'Question 3',
                text: 'Step #3 - ask your third question',
                inputPlaceholder: 'Enter your third question',
                currentProgressStep: 2,
                confirmButtonText: 'OK',
                // optional class to show fade-out backdrop animation which was disabled in Queue mixin
                showClass: { backdrop: 'swal2-noanimation' },
            });
        };
        if(swalChainElement) {
            swalChainElement.addEventListener('click', function() {
                chainedAlerts();
            });
        }

        // Reversed buttons
        const swalReverseButtonsElement = document.querySelector('#sweet_reverse_buttons');
        if(swalReverseButtonsElement) {
            swalReverseButtonsElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'What is your name?',
                    input: 'text',
                    inputPlaceholder: 'Your name or nickname',
                    showCancelButton: true,
                    confirmButtonText: 'Submit',
                    reverseButtons: true
                });
            });
        }

        // Fullscreen
        const swalFullscreenElement = document.querySelector('#sweet_fullscreen');
        if(swalFullscreenElement) {
            swalFullscreenElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'Here\'s a message!',
                    text: 'It\'s pretty, isn\'t it?',
                    icon: 'success',
                    showConfirmButton: false,
                    showCloseButton: true,
                    grow: 'fullscreen'
                });
            });
        }

        // Column grow
        const swalColumnElement = document.querySelector('#sweet_column');
        if(swalColumnElement) {
            swalColumnElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'Here\'s a message!',
                    text: 'It\'s pretty, isn\'t it?',
                    icon: 'success',
                    showConfirmButton: false,
                    showCloseButton: true,
                    grow: 'column'
                });
            });
        }

        // Row grow
        const swalRowElement = document.querySelector('#sweet_row');
        if(swalRowElement) {
            swalRowElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'Here\'s a message!',
                    text: 'It\'s pretty, isn\'t it?',
                    icon: 'success',
                    grow: 'row'
                });
            });
        }

        // Disabled keyboard interact
        const swalKeyboardElement = document.querySelector('#sweet_disabled_keyboard');
        if(swalKeyboardElement) {
            swalKeyboardElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    icon: 'error',
                    allowEscapeKey: false,
                    allowEnterKey: false
                });
            });
        }

        // Disabled animation
        const swalAnimationElement = document.querySelector('#sweet_disabled_animation');
        if(swalAnimationElement) {
            swalAnimationElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'For your information',
                    text: 'This is some sort of a custom alert',
                    icon: 'info',
                    showClass: {
                        popup: 'swal2-noanimation',
                        backdrop: 'swal2-noanimation'
                    },
                    hideClass: {
                        popup: '',
                        backdrop: ''
                    }
                });
            });
        }

        // Disabled backdrop
        const swalBackdropElement = document.querySelector('#sweet_disabled_backdrop');
        if(swalBackdropElement) {
            swalBackdropElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'Got question?',
                    text: 'You will get the answer soon!',
                    icon: 'question',
                    allowOutsideClick: false,
                    backdrop: false
                });
            });
        }

        // Disabled backdrop
        const swalOutsideClickElement = document.querySelector('#sweet_disabled_outside_click');
        if(swalOutsideClickElement) {
            swalOutsideClickElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    icon: 'error',
                    allowOutsideClick: false
                });
            });
        }


        //
        // Input types
        //

        // Text type
        const swalTextElement = document.querySelector('#sweet_text');
        if(swalTextElement) {
            swalTextElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'What is your name?',
                    input: 'text',
                    inputPlaceholder: 'Your name or nickname',
                    showCancelButton: true,
                    inputValidator: function(value) {
                        return !value && 'You need to write something!'
                    }
                }).then(function(result) {
                    if(result.value) {
                        swalInit.fire({
                            icon: 'success',
                            html: 'Hi, ' + result.value
                        });
                    }
                });
            });
        }

        // Email type
        const swalEmailElement = document.querySelector('#sweet_email');
        if(swalEmailElement) {
            swalEmailElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'Input email address',
                    input: 'email',
                    inputPlaceholder: 'Enter your email',
                }).then(function(result) {
                    if(result.value) {
                        swalInit.fire({
                            icon: 'success',
                            html: 'Entered email: ' + result.value
                        });
                    }
                });
            });
        }

        // URL type
        const swalUrlElement = document.querySelector('#sweet_url');
        if(swalUrlElement) {
            swalUrlElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'Input URL',
                    input: 'url',
                    inputPlaceholder: 'Enter URL',
                }).then(function(result) {
                    if(result.value) {
                        swalInit.fire({
                            icon: 'success',
                            html: 'Entered URL: ' + result.value
                        });
                    }
                });
            });
        }

        // Password type
        const swalPasswordElement = document.querySelector('#sweet_password');
        if(swalPasswordElement) {
            swalPasswordElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'Enter your password',
                    input: 'password',
                    inputPlaceholder: 'Enter your password',
                    inputAttributes: {
                        'maxlength': 10,
                        'autocapitalize': 'off',
                        'autocorrect': 'off'
                    }
                }).then(function(result) {
                    if(result.value) {
                        swalInit.fire({
                            icon: 'success',
                            html: 'Entered password: ' + result.value
                        });
                    }
                });
            });
        }

        // Textarea type
        const swalTextareaElement = document.querySelector('#sweet_textarea');
        if(swalTextareaElement) {
            swalTextareaElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'Enter your comment',
                    input: 'textarea',
                    inputPlaceholder: 'Type your message here',
                    showCancelButton: true
                }).then(function(result) {
                    if(result.value) {
                        swalInit.fire({
                            title: '<span class="mb-2">Your comment:</span>',
                            text: result.value
                        });
                    }
                });
            });
        }

        // Select type
        const swalSelectElement = document.querySelector('#sweet_select');
        if(swalSelectElement) {
            swalSelectElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'Select Netherlands',
                    input: 'select',
                    inputOptions: {
                        'DE': 'Germany',
                        'UA': 'Ukraine',
                        'HR': 'Croatia',
                        'NL': 'Netherlands'
                    },
                    inputPlaceholder: 'Select country',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-light',
                        denyButton: 'btn btn-light',
                        input: 'form-select'
                    },
                    showCancelButton: true,
                    inputValidator: function(value) {
                        return new Promise(function(resolve) {
                            if(value === 'NL') {
                                resolve();
                            }
                            else {
                                resolve('You need to select Netherlands :)');
                            }
                        });
                    }
                }).then(function(result) {
                    if(result.value) {
                        swalInit.fire({
                            icon: 'success',
                            html: 'You selected: ' + result.value
                        });
                    }
                });
            });
        }

        // Radio type
        const swalRadioElement = document.querySelector('#sweet_radio');
        if(swalRadioElement) {
            swalRadioElement.addEventListener('click', function() {

                // inputOptions can be an object or Promise
                const inputOptions = new Promise(function(resolve) {
                    setTimeout(function() {
                        resolve({
                            '#ff0000': 'Red',
                            '#00ff00': 'Green',
                            '#0000ff': 'Blue'
                        });
                    }, 2000)
                });

                // Initialize
                swalInit.fire({
                    title: 'Select color',
                    input: 'radio',
                    inputOptions: inputOptions,
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-light',
                        denyButton: 'btn btn-light'
                    },
                    inputValidator: function(value) {
                        return !value && 'You need to choose something!'
                    }
                }).then(function(result) {
                    if(result.value) {
                        swalInit.fire({
                            icon: 'success',
                            html: 'You selected: ' + result.value
                        });
                    }
                });
            });
        }

        // Checkbox type
        const swalCheckboxElement = document.querySelector('#sweet_checkbox');
        if(swalCheckboxElement) {
            swalCheckboxElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'Terms and conditions',
                    input: 'checkbox',
                    inputValue: 1,
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-light',
                        denyButton: 'btn btn-light'
                    },
                    inputPlaceholder: 'I agree with the terms and conditions',
                    confirmButtonText: 'Continue <i class="ph-arrow-circle-right ms-2></i>',
                    inputValidator: function(value) {
                        return !value && 'You need to agree with T&C'
                    }
                }).then(function(result) {
                    if(result.value) {
                        swalInit.fire({
                            icon: 'success',
                            text: 'You agreed with T&C :)'
                        });
                    }
                });
            });
        }

        // Range type
        const swalRangeElement = document.querySelector('#sweet_range');
        if(swalRangeElement) {
            swalRangeElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'How old are you?',
                    icon: 'question',
                    input: 'range',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-light',
                        denyButton: 'btn btn-light'
                    },
                    inputAttributes: {
                        min: 8,
                        max: 120,
                        step: 1
                    },
                    inputValue: 25
                }).then(function(result) {
                    if(result.value) {
                        swalInit.fire({
                            icon: 'success',
                            html: 'Your age is ' + result.value
                        });
                    }
                });
            });
        }


        //
        // Contextual alerts
        //
        
        // Success alert
        const swalSuccessElement = document.querySelector('#sweet_success');
        if(swalSuccessElement) {
            swalSuccessElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'Good job!',
                    text: 'You clicked the button!',
                    icon: 'success'
                });
            });
        }

        // Error alert
        const swalErrorElement = document.querySelector('#sweet_error');
        if(swalErrorElement) {
            swalErrorElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    icon: 'error'
                });
            });
        }

        // Warning alert
        const swalWarningElement = document.querySelector('#sweet_warning');
        if(swalWarningElement) {
            swalWarningElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'Are you sure?',
                    text: 'You will not be able to recover this imaginary file!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!'
                });
            });
        }

        // Info alert
        const swalInfoElement = document.querySelector('#sweet_info');
        if(swalInfoElement) {
            swalInfoElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'For your information',
                    text: 'This is some sort of a custom alert',
                    icon: 'info'
                });
            });
        }

        // Question
        const swalQuestionElement = document.querySelector('#sweet_question');
        if(swalQuestionElement) {
            swalQuestionElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'Got question?',
                    text: 'You will get the answer soon!',
                    icon: 'question'
                });
            });
        }

        // Alert combinatio
        const swalCombineElement = document.querySelector('#sweet_combine');
        if(swalCombineElement) {
            swalCombineElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    }
                }).then(function(result) {
                    if(result.value) {
                        swalInit.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        );
                    }
                    else if(result.dismiss === swal.DismissReason.cancel) {
                        swalInit.fire(
                            'Cancelled',
                            'Your imaginary file is safe :)',
                            'error'
                        );
                    }
                });
            });
        }


        //
        // Positions
        //

        // Top
        const swalTopElement = document.querySelector('#sweet_top');
        if(swalTopElement) {
            swalTopElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'Good job!',
                    text: 'You clicked the button!',
                    icon: 'success',
                    position: 'top'
                });
            });
        }

        // Top left
        const swalTopLeftElement = document.querySelector('#sweet_top_left');
        if(swalTopLeftElement) {
            swalTopLeftElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'Good job!',
                    text: 'You clicked the button!',
                    icon: 'success',
                    position: 'top-start'
                });
            });
        }

        // Top right
        const swalTopRightElement = document.querySelector('#sweet_top_right');
        if(swalTopRightElement) {
            swalTopRightElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'Good job!',
                    text: 'You clicked the button!',
                    icon: 'success',
                    position: 'top-end'
                });
            });
        }


        // Center left
        const swalCenterLeftElement = document.querySelector('#sweet_center_left');
        if(swalCenterLeftElement) {
            swalCenterLeftElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'Good job!',
                    text: 'You clicked the button!',
                    icon: 'success',
                    position: 'center-start'
                });
            });
        }

        // Center right
        const swalCenterRightElement = document.querySelector('#sweet_center_right');
        if(swalCenterRightElement) {
            swalCenterRightElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'Good job!',
                    text: 'You clicked the button!',
                    icon: 'success',
                    position: 'center-end'
                });
            });
        }


        // Bottom
        const swalBottomElement = document.querySelector('#sweet_bottom');
        if(swalBottomElement) {
            swalBottomElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'Good job!',
                    text: 'You clicked the button!',
                    icon: 'success',
                    position: 'bottom'
                });
            });
        }

        // Bottom left
        const swalBottomLeftElement = document.querySelector('#sweet_bottom_left');
        if(swalBottomLeftElement) {
            swalBottomLeftElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'Good job!',
                    text: 'You clicked the button!',
                    icon: 'success',
                    position: 'bottom-start'
                });
            });
        }

        // Bottom right
        const swalBottomRightElement = document.querySelector('#sweet_bottom_right');
        if(swalBottomRightElement) {
            swalBottomRightElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'Good job!',
                    text: 'You clicked the button!',
                    icon: 'success',
                    position: 'bottom-end'
                });
            });
        }


        //
        // Toasts
        //

        // Success alert
        const swalToastSuccessElement = document.querySelector('#sweet_toast_success');
        if(swalToastSuccessElement) {
            swalToastSuccessElement.addEventListener('click', function() {
                swalInit.fire({
                    text: 'Success toast message',
                    icon: 'success',
                    toast: true,
                    showConfirmButton: false,
                    position: 'top-end'
                });
            });
        }

        // Error alert
        const swalToastErrorElement = document.querySelector('#sweet_toast_error');
        if(swalToastErrorElement) {
            swalToastErrorElement.addEventListener('click', function() {
                swalInit.fire({
                    text: 'Something went wrong!',
                    icon: 'error',
                    toast: true,
                    showConfirmButton: false,
                    position: 'top-end'
                });
            });
        }

        // Warning alert
        const swalToastWarningElement = document.querySelector('#sweet_toast_warning');
        if(swalToastWarningElement) {
            swalToastWarningElement.addEventListener('click', function() {
                swalInit.fire({
                    text: 'Warning toast message',
                    icon: 'warning',
                    toast: true,
                    showConfirmButton: false,
                    position: 'top-end'
                });
            });
        }

        // Info alert
        const swalToastInfoElement = document.querySelector('#sweet_toast_info');
        if(swalToastInfoElement) {
            swalToastInfoElement.addEventListener('click', function() {
                swalInit.fire({
                    text: 'Info toast message',
                    icon: 'info',
                    toast: true,
                    showConfirmButton: false,
                    position: 'top-end'
                });
            });
        }

        // Question
        const swalToastQuestionElement = document.querySelector('#sweet_toast_question');
        if(swalToastQuestionElement) {
            swalToastQuestionElement.addEventListener('click', function() {
                swalInit.fire({
                    text: 'Toast message with question',
                    icon: 'question',
                    toast: true,
                    showConfirmButton: false,
                    position: 'top-end'
                });
            });
        }


        // Top
        const swalToastTopElement = document.querySelector('#sweet_toast_top');
        if(swalToastTopElement) {
            swalToastTopElement.addEventListener('click', function() {
                swalInit.fire({
                    text: 'Success toast message',
                    icon: 'success',
                    toast: true,
                    showConfirmButton: false,
                    position: 'top'
                });
            });
        }

        // Top left
        const swalToastTopLeftElement = document.querySelector('#sweet_toast_top_left');
        if(swalToastTopLeftElement) {
            swalToastTopLeftElement.addEventListener('click', function() {
                swalInit.fire({
                    text: 'Success toast message',
                    icon: 'success',
                    toast: true,
                    showConfirmButton: false,
                    position: 'top-start'
                });
            });
        }

        // Center left
        const swalToastCenterLeftElement = document.querySelector('#sweet_toast_center_left');
        if(swalToastCenterLeftElement) {
            swalToastCenterLeftElement.addEventListener('click', function() {
                swalInit.fire({
                    text: 'Success toast message',
                    icon: 'success',
                    toast: true,
                    showConfirmButton: false,
                    position: 'center-start'
                });
            });
        }

        // Center
        const swalToastCenterElement = document.querySelector('#sweet_toast_center');
        if(swalToastCenterElement) {
            swalToastCenterElement.addEventListener('click', function() {
                swalInit.fire({
                    text: 'Success toast message',
                    icon: 'success',
                    toast: true,
                    showConfirmButton: false,
                    position: 'center'
                });
            });
        }

        // Center right
        const swalToastCenterRightElement = document.querySelector('#sweet_toast_center_right');
        if(swalToastCenterRightElement) {
            swalToastCenterRightElement.addEventListener('click', function() {
                swalInit.fire({
                    text: 'Success toast message',
                    icon: 'success',
                    toast: true,
                    showConfirmButton: false,
                    position: 'center-end'
                });
            });
        }

        // Bottom left
        const swalToastBottomLeftElement = document.querySelector('#sweet_toast_bottom_left');
        if(swalToastBottomLeftElement) {
            swalToastBottomLeftElement.addEventListener('click', function() {
                swalInit.fire({
                    text: 'Success toast message',
                    icon: 'success',
                    toast: true,
                    showConfirmButton: false,
                    position: 'bottom-start'
                });
            });
        }

        // Bottom
        const swalToastBottomElement = document.querySelector('#sweet_toast_bottom');
        if(swalToastBottomElement) {
            swalToastBottomElement.addEventListener('click', function() {
                swalInit.fire({
                    text: 'Success toast message',
                    icon: 'success',
                    toast: true,
                    showConfirmButton: false,
                    position: 'bottom'
                });
            });
        }

        // Bottom right
        const swalToastBottomRightElement = document.querySelector('#sweet_toast_bottom_right');
        if(swalToastBottomRightElement) {
            swalToastBottomRightElement.addEventListener('click', function() {
                swalInit.fire({
                    text: 'Success toast message',
                    icon: 'success',
                    toast: true,
                    showConfirmButton: false,
                    position: 'bottom-end'
                });
            });
        }


        //
        // Events
        //

        // onOpen event
        const swalOnOpenElement = document.querySelector('#sweet_onopen');
        if(swalOnOpenElement) {
            swalOnOpenElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'Here\'s a message!',
                    icon: 'success',
                    text: 'It\'s pretty, isn\'t it?',
                    didOpen: function() {
                        alert('Notification is opened.');
                    }
                });
            });
        }

        // onClose event
        const swalOnCloseElement = document.querySelector('#sweet_onclose');
        if(swalOnCloseElement) {
            swalOnCloseElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'Here\'s a message!',
                    text: 'It\'s pretty, isn\'t it?',
                    icon: 'success',
                    didClose: function() {
                        alert('Notification is closed.');
                    }
                });
            });
        }
    };

    // SweetAlert with Select2 selects
    var _componentSelect2 = function() {
        if (!$().select2) {
            console.warn('Warning - select2.min.js is not loaded.');
            return;
        }

        // Swal defaults
        const swalInit = swal.mixin({
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-light',
                    denyButton: 'btn btn-light'
                }
            });

        // Select2 single
        const swalSelect2SingleElement = document.querySelector('#sweet_select2_single');
        if(swalSelect2SingleElement) {
            swalSelect2SingleElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'Select Netherlands',
                    input: 'select',
                    inputOptions: {
                        '': '',
                        'DE': 'Germany',
                        'UA': 'Ukraine',
                        'HR': 'Croatia',
                        'NL': 'Netherlands'
                    },
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-light',
                        denyButton: 'btn btn-light',
                        input: 'form-control select-single'
                    },
                    showCancelButton: true,
                    inputValidator: function(value) {
                        return new Promise(function(resolve) {
                            if(value === 'NL') {
                                resolve();
                            }
                            else {
                                resolve('You need to select Netherlands :)');
                            }
                        });
                    },
                    inputAttributes: {
                        'data-placeholder': 'Select Netherlands'
                    },
                    didOpen: function() {

                        // Initialize Select2
                        $('.swal2-select.select-single').select2({
                            minimumResultsForSearch: Infinity
                        });
                    }
                }).then(function(result) {
                    if(result.value) {
                        swalInit.fire({
                            icon: 'success',
                            html: 'You selected: ' + result.value
                        });
                    }
                });
            });
        }

        // Select2 multiple
        const swalSelect2MultipleElement = document.querySelector('#sweet_select2_multiple');
        if(swalSelect2MultipleElement) {
            swalSelect2MultipleElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'Select country',
                    input: 'select',
                    inputOptions: {
                        'DE': 'Germany',
                        'UA': 'Ukraine',
                        'HR': 'Croatia',
                        'NL': 'Netherlands'
                    },
                    inputValue: 'NL',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-light',
                        denyButton: 'btn btn-light',
                        input: 'form-control select-multiple'
                    },
                    showCancelButton: true,
                    inputValidator: function(value) {
                        return !value && 'You need to select something!'
                    },
                    inputAttributes: {
                        'data-placeholder': 'Select country',
                        'multiple': 'multiple'
                    },
                    didOpen: function() {

                        // Initialize Select2
                        $('.swal2-select.select-multiple').select2();
                    }
                }).then(function(result) {
                    if(result.value) {
                        swalInit.fire({
                        icon: 'success',
                        html: 'You selected: ' + JSON.stringify($('.swal2-select.select-multiple').val())
                    });
                }
                });
            });
        }
    };

    // SweetAlert with Bootstrap Multiselect
    var _componentMultiselect = function() {
        if (!$().multiselect) {
            console.warn('Warning - bootstrap-multiselect.js is not loaded.');
            return;
        }

        // Swal defaults
        const swalInit = swal.mixin({
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-light',
                    denyButton: 'btn btn-light',
                    input: 'form-control select-multiselect'
                }
            });

        // SweetAlert with Multiselect
        const swalMultiselectElement = document.querySelector('#sweet_multiselect');
        if(swalMultiselectElement) {
            swalMultiselectElement.addEventListener('click', function() {
                swalInit.fire({
                    title: 'Select countries',
                    input: 'select',
                    buttonsStyling: false,
                    inputOptions: {
                        'DE': 'Germany',
                        'UA': 'Ukraine',
                        'HR': 'Croatia',
                        'NL': 'Netherlands'
                    },
                    showCancelButton: true,
                    inputValidator: function(value) {
                        return !$('.swal2-select.select-multiselect').val().length && 'You need to select something!'
                    },
                    inputAttributes: {
                        'multiple': 'multiple'
                    },
                    didOpen: function() {

                        // Initialize Multiselect when dialog is opened
                        $('.swal2-select.select-multiselect').multiselect();
                    }
                }).then(function(result) {

                    // Display selected values
                    swalInit.fire({
                        icon: 'success',
                        html: 'You selected: ' + JSON.stringify($('.swal2-select.select-multiselect').val())
                    });

                    // Cancel button dialog
                    if(result.dismiss === swal.DismissReason.cancel) {
                        swalInit.fire(
                            'Cancelled',
                            'You are safe now',
                            'error'
                        );
                    }
                });
            });        
        }
    };


    //
    // Return objects assigned to module
    //

    return {
        initComponents: function() {
            _componentSweetAlert();
            _componentSelect2();
            _componentMultiselect();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    SweetAlert.initComponents();
});
