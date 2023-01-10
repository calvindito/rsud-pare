/* ------------------------------------------------------------------------------
 *
 *  # Dual listboxes
 *
 *  Demo JS code for form_dual_listboxes.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const DualListboxes = function() {


    //
    // Setup module components
    //

    // Dual listbox
    const _componentDualListbox = function() {
        if (typeof DualListbox == 'undefined') {
            console.warn('Warning - dual_listbox.min.js is not loaded.');
            return;
        }

        // Basic example
        const listboxBasicElement = document.querySelector(".listbox-basic");
        const listboxBasic = new DualListbox(listboxBasicElement);

        // Options
        const listboxOptionsElement = document.querySelector(".listbox-options");
        const listboxOptions = new DualListbox(listboxOptionsElement, {
            options: [
                { text: "Classical mechanics", value: "option1", selected: true },
                { text: "Electromagnetism", value: "option2" },
                { text: "Relativity", value: "option3" },
                { text: "Quantum mechanics", value: "option4", selected: true },
                { text: "Astrophysics", value: "option5" },
                { text: "Biophysics", value: "option6", selected: true },
                { text: "Chemical physics", value: "option7" },
                { text: "Econophysics", value: "option8" },
                { text: "Geophysics", value: "option9" },
                { text: "Medical physics", value: "option10" },
                { text: "Physical chemistry", value: "option11" },
                { text: "Continuum mechanics", value: "option12", selected: true },
                { text: "Electrodynamics", value: "option13" },
                { text: "Quantum field theory", value: "option14", selected: true },
                { text: "Scattering theory", value: "option15" },
                { text: "Chaos theory", value: "option16", selected: true },
                { text: "Newton's laws of motion", value: "option17", selected: true },
                { text: "Thermodynamics", value: "option18" },
                { text: "Option 2", value: "option19" },
                { text: "Option 1", value: "option20" },
                { text: "Option 2", value: "option21" },
                { text: "Option 1", value: "option22" },
                { text: "Option 2", value: "option23" }
            ]
        });

        // Buttons text
        const listboxButtonsElement = document.querySelector(".listbox-buttons");
        const listboxButtons = new DualListbox(listboxButtonsElement, {
            addButtonText: "<i class='ph-caret-right'></i>",
            removeButtonText: "<i class='ph-caret-left'></i>",
            addAllButtonText: "<i class='ph-caret-double-right'></i>",
            removeAllButtonText: "<i class='ph-caret-double-left'></i>"
        });

        // Sorting
        const listboxSortingElement = document.querySelector(".listbox-sorting");
        const listboxSorting = new DualListbox(listboxSortingElement, {
            sortable: true,
            upButtonText: "<i class='ph-caret-up'></i>",
            downButtonText: "<i class='ph-caret-down'></i>"
        });

        // Hidden buttons
        const listboxButtonsHiddenElement = document.querySelector(".listbox-buttons-hidden");
        const listboxButtonsHidden = new DualListbox(listboxButtonsHiddenElement, {
            showAddButton: false,
            showAddAllButton: false,
            showRemoveButton: false,
            showRemoveAllButton: false
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentDualListbox();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    DualListboxes.init();
});
