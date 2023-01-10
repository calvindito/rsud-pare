/* ------------------------------------------------------------------------------
 *
 *  # Ace code editor
 *
 *  Demo JS code for editor_code.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const Ace = function() {


    //
    // Setup module components
    //

    // Ace editor
    const _componentAce = function() {
        if (typeof ace == 'undefined') {
            console.warn('Warning - ace.js is not loaded.');
            return;
        }

        // Global settings
        ace.config.set('theme', 'ace/theme/limitless');
        ace.config.set('showPrintMargin', false);

        // Javascript editor
        const js_editor = ace.edit('javascript_editor', {
            mode: 'ace/mode/javascript'
        });

        // HTML editor
        const html_editor = ace.edit('html_editor', {
            mode: 'ace/mode/html'
        });

        // CSS editor
        const css_editor = ace.edit('css_editor', {
            mode: 'ace/mode/css'
        });


        // JSON editor
        const json_editor = ace.edit('json_editor', {
            mode: 'ace/mode/json'
        });


        // LESS editor
        const less_editor = ace.edit('less_editor', {
            mode: 'ace/mode/less'
        });


        // PHP editor
        const php_editor = ace.edit('php_editor', {
            mode: 'ace/mode/php'
        });


        // Ruby editor
        const ruby_editor = ace.edit('ruby_editor', {
            mode: 'ace/mode/ruby'
        });


        // SASS editor
        const sass_editor = ace.edit('sass_editor', {
            mode: 'ace/mode/sass'
        });


        // Coffee editor
        const coffee_editor = ace.edit('coffee_editor', {
            mode: 'ace/mode/coffee'
        });


        // Handlebars editor
        const handlebars_editor = ace.edit('handlebars_editor', {
            mode: 'ace/mode/handlebars'
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentAce();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    Ace.init();
});
