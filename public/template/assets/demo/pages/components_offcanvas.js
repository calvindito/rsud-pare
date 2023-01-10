/* ------------------------------------------------------------------------------
 *
 *  # Offcanvas component
 *
 *  Demo JS code for components_offcanvas.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const Offcanvas = function () {


    //
    // Setup module components
    //

    // Load remote content
    const _componentOffcanvasRemote = function() {
        function load(url, element) {
            req = new XMLHttpRequest();
            req.open("GET", url, false);
            req.send(null);

            element.innerHTML = req.responseText; 
        }

        const remoteDataOffcanvas = document.getElementById('panel_remote');
        if(remoteDataOffcanvas) {
            remoteDataOffcanvas.addEventListener('show.bs.offcanvas', function() {
                load("../../../assets/demo/data/offcanvas/offcanvas_content.html", remoteDataOffcanvas.querySelector('.offcanvas-body'));
            });
        }
    };

    // Resizable offcanvas
    const _componentOffcanvasResize = function() {
        const element = document.querySelector('.offcanvas-resizable');
        const minimum_size = element.getAttribute('data-min-width');
        const maximum_size = element.getAttribute('data-max-width');

        let original_width = 0;
        let original_x = 0;
        let original_mouse_x = 0;

        if(element) {
            ['mousedown', 'touchstart'].forEach(function(e) {
                element.querySelector('.offcanvas-resize-handle').addEventListener(e, startResize);
            });
        }

        function startResize(e) {
            e.preventDefault()
            original_width = parseFloat(getComputedStyle(element, null).getPropertyValue('width').replace('px', ''));
            original_x = element.getBoundingClientRect().left;
            original_mouse_x = e.pageX;

            ['mousemove', 'touchmove'].forEach(function(e) {
                window.addEventListener(e, resize);
            });
            ['mouseup', 'touchend'].forEach(function(e) {
                window.addEventListener(e, stopResize);
            });
        }

        function resize(e) {
            const mouse_h_position = e.pageX - original_mouse_x;
            const width = element.classList.contains('offcanvas-start') ? original_width + mouse_h_position : original_width - mouse_h_position;
            if (width > minimum_size && width < maximum_size) {
                element.style.width = width + 'px';
            }
        }

        function stopResize() {
            ['mousemove', 'touchmove'].forEach(function(e) {
                window.removeEventListener(e, resize);
            });
        }
    };

    // Offcanvas callbacks
    const _componentOffcanvasCallbacks = function() {

        // onShow callback
        const onShowCallbackOffcanvas = document.getElementById('panel_onshow');
        if(onShowCallbackOffcanvas) {
            onShowCallbackOffcanvas.addEventListener('show.bs.offcanvas', function() {
                alert('onShow callback fired.')
            });
        }

        // onShown callback
        const onShownCallbackOffcanvas = document.getElementById('panel_onshown');
        if(onShownCallbackOffcanvas) {
            onShownCallbackOffcanvas.addEventListener('shown.bs.offcanvas', function() {
                alert('onShown callback fired.')
            });
        }

        // onHide callback
        const onHideCallbackOffcanvas = document.getElementById('panel_onhide');
        if(onHideCallbackOffcanvas) {
            onHideCallbackOffcanvas.addEventListener('hide.bs.offcanvas', function() {
                alert('onHide callback fired.')
            });
        }

        // onHidden callback
        const onHiddenCallbackOffcanvas = document.getElementById('panel_onhidden');
        if(onHiddenCallbackOffcanvas) {
            onHiddenCallbackOffcanvas.addEventListener('hidden.bs.offcanvas', function() {
                alert('onHidden callback fired.')
            });
        }
    };


    //
    // Return objects assigned to module
    //

    return {
        initComponents: function() {
            _componentOffcanvasRemote();
            _componentOffcanvasResize();
            _componentOffcanvasCallbacks();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    Offcanvas.initComponents();
});
