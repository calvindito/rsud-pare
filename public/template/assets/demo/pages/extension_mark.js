/* ------------------------------------------------------------------------------
 *
 *  # Mark.js extension
 *
 *  Demo JS code for extension_mark.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const MarkJS = function() {


    //
    // Setup module components
    //

    // Basic example
    const _markBasic = function() {

        // Create an instance of mark.js and pass an argument containing
        // the DOM object of the context (where to search for matches)
        const instanceBase = new Mark(document.querySelector(".demo-target-base"));

        // Cache DOM elements
        const inputBase = document.querySelector("input[name='keyword-basic']");

        // Initialize
        function performMarkBasic() {

            // Read the keyword
            const keywordBase = inputBase.value;

            // Remove previous marked elements and mark
            // the new keyword inside the context
            instanceBase.unmark({
                done: function(){
                    instanceBase.mark(keywordBase);
                }
            });
        }

        // Listen to input and option changes
        inputBase.addEventListener("input", performMarkBasic);
    };

    // Exclude matches
    const _markExclude = function() {

        // Create an instance of mark.js and pass an argument containing
        // the DOM object of the context (where to search for matches)
        const instanceExclude = new Mark(document.querySelector(".demo-target-exclude"));

        // Cache DOM elements
        const inputExclude = document.querySelector("input[name='keyword-exclude']");

        // Initialize
        function performMarkExclude() {

            // Read the keyword
            const keywordExclude = inputExclude.value;

            // Remove previous marked elements and mark
            // the new keyword inside the context
            instanceExclude.unmark({
                done: function(){
                    instanceExclude.mark(keywordExclude, {
                        exclude: [
                            "del"
                        ]
                    });
                }
            });
        }

        // Listen to input and option changes
        inputExclude.addEventListener("input", performMarkExclude);
    };

    // Synonyms
    const _markSynonyms = function() {

        // Create an instance of mark.js and pass an argument containing
        // the DOM object of the context (where to search for matches)
        const instanceSynonym = new Mark(document.querySelector(".demo-target-synonym"));

        // Cache DOM elements
        const inputSynonym = document.querySelector("input[name='keyword-synonym']");

        // Initialize
        function performMarkSynonym() {

            // Read the keyword
            const keywordSynonym = inputSynonym.value;

            // Remove previous marked elements and mark
            // the new keyword inside the context
            instanceSynonym.unmark({
                done: function(){
                    instanceSynonym.mark(keywordSynonym, {
                        synonyms: {
                            "1": "one",
                            "10": "ten"
                        }
                    });
                }
            });
        }

        // Listen to input and option changes
        inputSynonym.addEventListener("input", performMarkSynonym);
    };

    // Element and class
    const _markElementClass = function() {

        // Create an instance of mark.js and pass an argument containing
        // the DOM object of the context (where to search for matches)
        const instanceElementClass = new Mark(document.querySelector(".demo-target-element"));

        // Cache DOM elements
        const inputElementClass = document.querySelector("input[name='keyword-element']");

        // Initialize
        function performMarkElementClass() {

            // Read the keyword
            const keywordElementClass = inputElementClass.value;

            // Remove previous marked elements and mark
            // the new keyword inside the context
            instanceElementClass.unmark({
                done: function(){
                    instanceElementClass.mark(keywordElementClass, {
                        element: 'span',
                        className: 'bg-primary bg-opacity-10 text-primary'
                    });
                }
            });
        }

        // Listen to input and option changes
        inputElementClass.addEventListener("input", performMarkElementClass);
    };

    // Filtering table rows
    const _markFiltering = function() {

        // Create an instance of mark.js and pass an argument containing
        // the DOM object of the context (where to search for matches)
        const keywordInput = document.querySelector('input[name="keyword-table"]');
        const tab = document.querySelector('.table');
        const tableEl = new Mark(tab);

        // Listen to input and option changes
        keywordInput.addEventListener('input', function() {
            const term = this.value;

            // Remove filter and show initial state
            if (term) {
                tab.querySelectorAll('td mark').forEach(function(mark) {
                    mark.closest('tr').classList.add('d-none');
                });
            }
            tableEl.unmark();

            // Find marks and init filter
            tableEl.mark(term, {
                done: function() {
                    tab.querySelectorAll('td mark').forEach(function(mark) {
                        mark.closest('tr').classList.remove('d-none');
                    });
                }
            });
        });
    };

    // Toggle options dynamically
    const _markOptions = function() {

        // Create an instance of mark.js and pass an argument containing
        // the DOM object of the context (where to search for matches)
        var markInstance = new Mark(document.querySelector(".demo-target-options"));

        // Cache DOM elements
        var keywordInput = document.querySelector("input[name='keyword-options']");
        var optionInputs = document.querySelectorAll("input[name='options']");

        function performMark() {

            // Read the keyword
            var keyword = keywordInput.value;

            // Determine selected options
            var options = {};
            [].forEach.call(optionInputs, function(opt) {
                options[opt.value] = opt.checked;
            });

            // Remove previous marked elements and mark
            // the new keyword inside the context
            markInstance.unmark({
                done: function(){
                    markInstance.mark(keyword, options);
                }
            });
        };

        // Listen to input and option changes
        keywordInput.addEventListener("input", performMark);
        optionInputs.forEach(function(inputs) {
            inputs.addEventListener("change", performMark);
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _markBasic();
            _markExclude();
            _markSynonyms();
            _markElementClass();
            _markFiltering();
            _markOptions();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    MarkJS.init();
});
