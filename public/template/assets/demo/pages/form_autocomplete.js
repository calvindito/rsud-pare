/* ------------------------------------------------------------------------------
 *
 *  # Autocomplete
 *
 *  Demo JS code for form_autocomplete.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const AutocompleteInputs = function() {


    //
    // Setup module components
    //

    // Autocomplete
    const _componentAutocomplete = function() {
        if (typeof autoComplete == 'undefined') {
            console.warn('Warning - autocomplete.min.js is not loaded.');
            return;
        }

        // Demo data
        const autocompleteData = [
            "Andorra",
            "United Arab Emirates",
            "Afghanistan",
            "Antigua and Barbuda",
            "Anguilla",
            "Albania",
            "Armenia",
            "Angola",
            "Antarctica",
            "Argentina",
            "American Samoa",
            "Austria",
            "Australia",
            "Aruba",
            "Åland",
            "Azerbaijan",
            "Bosnia and Herzegovina",
            "Barbados",
            "Bangladesh",
            "Belgium",
            "Burkina Faso",
            "Bulgaria",
            "Bahrain",
            "Burundi",
            "Benin",
            "Saint Barthélemy",
            "Bermuda",
            "Brunei",
            "Bolivia",
            "Bonaire",
            "Brazil",
            "Bahamas",
            "Bhutan",
            "Bouvet Island",
            "Botswana",
            "Belarus",
            "Belize"
        ];

        // Basic
        const autocompleteBasic = new autoComplete({
            selector: "#autocomplete_basic",
            data: {
                src: autocompleteData
            },
            resultItem: {
                highlight: true
            },
            events: {
                input: {
                    selection: function(event){
                        const selection = event.detail.selection.value;
                        autocompleteBasic.input.value = selection;
                    }
                }
            }
        });

        // Disable selection
        const autocompleteSelection = new autoComplete({
            selector: "#autocomplete_selection",
            data: {
                src: autocompleteData
            },
            resultItem: {
                highlight: true
            }
        });

        // Threshold
        const autocompleteThreshold = new autoComplete({
            selector: "#autocomplete_threshold",
            data: {
                src: autocompleteData
            },
            resultItem: {
                highlight: true
            },
            threshold: 3,
            events: {
                input: {
                    selection: function(event){
                        const selection = event.detail.selection.value;
                        autocompleteThreshold.input.value = selection;
                    }
                }
            }
        });

        // Debounce
        const autocompleteDebounce = new autoComplete({
            selector: "#autocomplete_debounce",
            data: {
                src: autocompleteData
            },
            resultItem: {
                highlight: true
            },
            debounce: 500,
            events: {
                input: {
                    selection: function(event){
                        const selection = event.detail.selection.value;
                        autocompleteDebounce.input.value = selection;
                    }
                }
            }
        });

        // Search engine mode
        const autocompleteEngine = new autoComplete({
            selector: "#autocomplete_engine",
            data: {
                src: autocompleteData
            },
            resultItem: {
                highlight: true
            },
            searchEngine: "loose",
            events: {
                input: {
                    selection: function(event){
                        const selection = event.detail.selection.value;
                        autocompleteEngine.input.value = selection;
                    }
                }
            }
        });

        // Show menu on focus
        const autocompleteFocus = new autoComplete({
            selector: "#autocomplete_focus",
            data: {
                src: autocompleteData
            },
            resultItem: {
                highlight: true
            },
            events: {
                input: {
                    selection: function(event){
                        const selection = event.detail.selection.value;
                        autocompleteFocus.input.value = selection;
                    },
                    focus() {
                        const inputValue = autocompleteFocus.input.value;
                        if (inputValue.length) autocompleteFocus.start();
                    }
                }
            }
        });

        // Multiple selection
        const autocompleteMultiple = new autoComplete({
            selector: "#autocomplete_multiple",
            data: {
                src: autocompleteData
            },
            resultItem: {
                highlight: true
            },
            query: (query) => {
                // Split query into array
                const querySplit = query.split(",");
                // Get last query value index
                const lastQuery = querySplit.length - 1;
                // Trim new query
                const newQuery = querySplit[lastQuery].trim();

                return newQuery;
            },
            events: {
                input: {
                    selection(event) {
                        const feedback = event.detail;
                        const input = autocompleteMultiple.input;
                        // Trim selected Value
                        const selection = feedback.selection.value.trim();
                        // Split query into array and trim each value
                        const query = input.value.split(",").map(item => item.trim());
                        // Remove last query
                        query.pop();
                        // Add selected value
                        query.push(selection);
                        // Replace Input value with the new query
                        input.value = query.join(", ") + ", ";
                    }
                }
            }
        });

        // Results counter
        const autocompleteCount = new autoComplete({
            selector: "#autocomplete_count",
            data: {
                src: autocompleteData
            },
            resultItem: {
                highlight: true
            },
            resultsList: {
                element: (list, data) => {
                    const info = document.createElement('li');
                    info.classList.add('pe-none', 'border-bottom', 'pt-0', 'pb-2', 'mb-2');
                    if (data.results.length > 0) {
                        info.innerHTML = `<div class="my-1">Displaying <strong>${data.results.length}</strong> out of <strong>${data.matches.length}</strong> results</div>`;
                    }
                    list.prepend(info);
                },
                maxResults: 15,
                tabSelect: true
            },
            events: {
                input: {
                    selection: function(event){
                        const selection = event.detail.selection.value;
                        autocompleteCount.input.value = selection;
                    }
                }
            }
        });

        // No results
        const autocompleteEmpty = new autoComplete({
            selector: "#autocomplete_empty",
            data: {
                src: autocompleteData
            },
            resultItem: {
                highlight: true
            },
            resultsList: {
                element: (list, data) => {
                    const info = document.createElement('li');
                    info.classList.add('pe-none', 'py-1');
                    if (!data.results.length) {
                        info.innerHTML = `<div class="my-1">Found <strong>${data.matches.length}</strong> matching results for <strong>"${data.query}"</strong></div>`;
                    }
                    list.append(info);
                },
                noResults: true,
                maxResults: 15,
                tabSelect: true
            },
            events: {
                input: {
                    selection: function(event){
                        const selection = event.detail.selection.value;
                        autocompleteEmpty.input.value = selection;
                    }
                }
            }
        });

        // Disable highlight
        const autocompleteHighlight = new autoComplete({
            selector: "#autocomplete_highlight",
            data: {
                src: autocompleteData
            },
            events: {
                input: {
                    selection: function(event){
                        const selection = event.detail.selection.value;
                        autocompleteHighlight.input.value = selection;
                    }
                }
            }
        });

        // External data source
        const autocompleteExternalSource = new autoComplete({
            selector: "#autocomplete_external_source",
            data: {
                src: async function(){
                    try {
                        // Loading placeholder text
                        document.getElementById("autocomplete_external_source").setAttribute("placeholder", "Loading...");
                        // Fetch External Data Source
                        const source = await fetch(
                            "../../../assets/demo/data/typeahead/countries.json"
                        );
                        const data = await source.json();
                        // Post Loading placeholder text
                        document.getElementById("autocomplete_external_source").setAttribute("placeholder", autocompleteExternalSource.placeHolder);
                        // Returns Fetched data
                        return data;
                    }
                    catch (error) {
                        return error;
                    }
                }
            },
            resultItem: {
                highlight: true
            },
            events: {
                input: {
                    focus: () => {
                        if (autocompleteExternalSource.input.value.length) autocompleteExternalSource.start();
                    },
                    selection: function(event){
                        const selection = event.detail.selection.value;
                        autocompleteExternalSource.input.value = selection;
                    }
                }
            }
        });

        // Ignore duplicates
        const autocompleteDuplicates = new autoComplete({
            selector: "#autocomplete_duplicates",
            data: {
                src: async function(){
                    try {
                        // Loading placeholder text
                        document.getElementById("autocomplete_duplicates").setAttribute("placeholder", "Loading...");
                        // Fetch External Data Source
                        const source = await fetch(
                            "../../../assets/demo/data/typeahead/countries.json"
                        );
                        const data = await source.json();
                        // Post Loading placeholder text
                        document.getElementById("autocomplete_duplicates").setAttribute("placeholder", autocompleteDuplicates.placeHolder);
                        // Returns Fetched data
                        return data;
                    }
                    catch (error) {
                        return error;
                    }
                },
                filter: (list) => {
                    // Filter duplicates
                    // incase of multiple data keys usage
                    const filteredResults = Array.from(
                        new Set(list.map((value) => value.match))
                    ).map((food) => {
                        return list.find((value) => value.match === food);
                    });

                    return filteredResults;
                }
            },
            resultItem: {
                highlight: true
            },
            events: {
                input: {
                    focus: () => {
                        if (autocompleteDuplicates.input.value.length) autocompleteDuplicates.start();
                    },
                    selection: function(event){
                        const selection = event.detail.selection.value;
                        autocompleteDuplicates.input.value = selection;
                    }
                }
            }
        });

        // External empty array to save search results
        let history = [];
        const autocompleteRecent = new autoComplete({
            selector: "#autocomplete_recent",
            data: {
                src: autocompleteData
            },
            resultItem: {
                highlight: true
            },
            resultsList: {
                element: (list) => {
                    const recentSearch = history.reverse();
                    const historyLength = recentSearch.length;

                    // Check if there are recent searches
                    if(historyLength) {
                        const historyBlock = document.createElement("li");
                        historyBlock.classList.add('pe-none', 'border-bottom', 'pt-0', 'pb-2', 'mb-2');
                        historyBlock.innerHTML = '<div class="fw-semibold">Recent Searches</div>';
                        // Limit displayed searched to only last "2"
                        recentSearch.slice(0, 2).forEach((item) => {
                            const recentItem = document.createElement("div");
                            recentItem.classList.add('text-muted', 'mt-2')
                            recentItem.innerHTML = item;
                            historyBlock.append(recentItem);
                        });

                        // const separator = document.createElement("li");
                        // separator.classList.add('border-top')
                        // list.insertBefore(separator, list.firstElementChild);

                        list.prepend(historyBlock);
                    }
                }
            },
            events: {
                input: {
                    selection(event) {
                        const feedback = event.detail;
                        const input = autocompleteRecent.input;
                        // Get selected Value
                        const selection = feedback.selection.value;
                        // Add selected value to "history" array
                        history.push(selection);
                        
                        autocompleteRecent.input.value = selection;
                    }
                }
            }
        });

        // Start with
        const autocompleteStart = new autoComplete({
            selector: "#autocomplete_start",
            data: {
                src: autocompleteData,
                filter: (list) => {
                    const results = list.filter((item) => {
                        const inputValue = autocompleteStart.input.value.toLowerCase();
                        const itemValue = item.value.toLowerCase();

                        if (itemValue.startsWith(inputValue)) {
                            return item.value;
                        }
                    });

                    return results;
                }
            },
            resultItem: {
                highlight: true
            },
            events: {
                input: {
                    selection: function(event){
                        const selection = event.detail.selection.value;
                        autocompleteStart.input.value = selection;
                    }
                }
            }
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentAutocomplete();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    AutocompleteInputs.init();
});
