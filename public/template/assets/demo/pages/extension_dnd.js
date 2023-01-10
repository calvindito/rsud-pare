/* ------------------------------------------------------------------------------
 *
 *  # Dragula - drag and drop library
 *
 *  Demo JS code for extension_dnd.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const DragAndDrop = function() {


    //
    // Setup module components
    //

    // Dragula examples
    const _componentDragula = function() {
        if (typeof dragula == 'undefined') {
            console.warn('Warning - dragula.min.js is not loaded.');
            return;
        }

        // Draggable cards
        dragula([document.getElementById('cards-target-left'), document.getElementById('cards-target-right')]);

        // Draggable forms
        dragula([document.getElementById('forms-target-left'), document.getElementById('forms-target-right')]);

        // Draggable media lists
        dragula([document.getElementById('media-list-target-left'), document.getElementById('media-list-target-right')], {
            mirrorContainer: document.querySelector('.media-list-container'),
            moves: function (el, container, handle) {
                return handle.classList.contains('dragula-handle');
            }
        });


        //
        // Dropdown menu items
        //

        // Define containers
        // const containers = $('.dropdown-menu-sortable').toArray();
        const containers = Array.from(document.querySelectorAll('.dropdown-menu-sortable'));

        // Init dragula
        dragula(containers, {
            mirrorContainer: document.querySelector('.dropdown-menu-sortable')
        });


        //
        // Draggable tabs
        //

        // Basic tabs
        dragula([document.getElementById('tabs-target-left')], {
            mirrorContainer: document.querySelector('#tabs-target-left')
        });

        // Basic justified
        dragula([document.getElementById('tabs-target-right')], {
            mirrorContainer: document.querySelector('#tabs-target-right')
        });

        // Colored tabs
        dragula([document.getElementById('tabs-solid-target-left')], {
            mirrorContainer: document.querySelector('#tabs-solid-target-left')
        });

        // Colored justified
        dragula([document.getElementById('tabs-solid-target-right')], {
            mirrorContainer: document.querySelector('#tabs-solid-target-right')
        });


        //
        // Draggable pills
        //

        // Basic pills
        dragula([document.getElementById('pills-target-left')], {
            mirrorContainer: document.querySelector('#pills-target-left')
        });

        // Basic justified
        dragula([document.getElementById('pills-target-right')], {
            mirrorContainer: document.querySelector('#pills-target-right')
        });

        // Toolbar pills
        dragula([document.getElementById('pills-toolbar-target-left')], {
            mirrorContainer: document.querySelector('#pills-toolbar-target-left')
        });

        // Toolbar justified
        dragula([document.getElementById('pills-toolbar-target-right')], {
            mirrorContainer: document.querySelector('#pills-toolbar-target-right')
        });


        //
        // Accordion and collapsible
        //

        // Accordion
        dragula([document.getElementById('accordion-target')], {
            mirrorContainer: document.getElementById('accordion-target')
        });

        // Collapsible
        dragula([document.getElementById('collapsible-target')], {
            mirrorContainer: document.getElementById('collapsible-target')
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentDragula();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    DragAndDrop.init();
});
