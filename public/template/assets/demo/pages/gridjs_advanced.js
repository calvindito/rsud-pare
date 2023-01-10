/* ------------------------------------------------------------------------------
 *
 *  # Grid.js advanced examples
 *
 *  Demo JS code for gridjs_advanced.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const GridJsAdvanced = function() {


    //
    // Setup module components
    //

    // Basic
    const _componentGridJsAdvanced = function() {
        if (typeof gridjs == 'undefined') {
            console.warn('Warning - gridjs.min.js is not loaded.');
            return;
        }

        // Demo data
        const demoData = [
            ["John", "john@example.com", "(353) 01 222 3333", "Netherlands"],
            ["Mark", "mark@gmail.com", "(01) 22 888 4444", "Switzerland"],
            ["Eoin", "eoin@gmail.com", "0097 22 654 00033", "Germany"],
            ["Sarah", "sarahcdd@gmail.com", "+322 876 1233", "France"],
            ["Afshin", "afshin@mail.com", "(353) 22 87 8356", "Norway"]
        ];


        // Nested header
        const gridjsNestedHeaderElement = document.querySelector(".gridjs-example-nested-header");
        if(gridjsNestedHeaderElement) {
            const gridjsNestedHeader = new gridjs.Grid({
                className: {
                    table: 'table table-bordered'
                },
                sort: true,
                columns: [
                    { 
                        name: 'Name',
                        columns: [
                            {
                                name: 'First'
                            },
                            {
                                name: 'Last'
                            }
                        ]
                    },
                    'Email',
                    'Phone Number',
                    { 
                        name: 'Address',
                        columns: [
                            {
                                name: 'Country'
                            },
                            {
                                name: 'City'
                            }
                        ]
                    }
                ],
                data: [
                    ["John", "Murray", "john@example.com", "(353) 01 222 3333", "Netherlands", "Amsterdam"],
                    ["Mark", "Smith", "mark@gmail.com", "(01) 22 888 4444", "Switzerland", "Zurich"],
                    ["Eoin", "Black", "eoin@gmail.com", "0097 22 654 00033", "Germany", "Berlin"],
                    ["Sarah", "Johnson", "sarahcdd@gmail.com", "+322 876 1233", "France", "Paris"],
                    ["Afshin", "Belkin", "afshin@mail.com", "(353) 22 87 8356", "Norway", "Oslo"]
                ]
            });
            gridjsNestedHeader.render(gridjsNestedHeaderElement);
        }

        // Multi column sort
        const gridjsMultiSortingElement = document.querySelector(".gridjs-example-sort-multi");
        if(gridjsMultiSortingElement) {
            const gridjsMultiSorting = new gridjs.Grid({
                className: {
                    table: 'table'
                },
                sort: {
                    multiColumn: false
                },
                columns: ["Name", "Email", "Phone Number", "Country"],
                data: demoData
            });
            gridjsMultiSorting.render(gridjsMultiSortingElement);
        }

        // Custom sort
        const gridjsCustomSortingElement = document.querySelector(".gridjs-example-sort-custom");
        if(gridjsCustomSortingElement) {
            const gridjsCustomSorting = new gridjs.Grid({
                className: {
                    table: 'table'
                },
                sort: {
                    multiColumn: false
                },
                columns: [
                    "Name",
                    "Email",
                    {
                        name: "Phone Number",
                        sort: {
                            compare: (a, b) => {
                                const code = (x) => x.split(' ').slice(-1)[0];

                                if (code(a) > code(b)) {
                                    return 1;
                                } else if (code(b) > code(a)) {
                                    return -1;
                                } else {
                                    return 0;
                                }
                            }
                        }
                    },
                    "Country"
                ],
                data: demoData
            });
            gridjsCustomSorting.render(gridjsCustomSortingElement);
        }

        // Events
        const gridjsEventsElement = document.querySelector(".gridjs-example-events");
        if(gridjsEventsElement) {
            const gridjsEvents = new gridjs.Grid({
                className: {
                    table: 'table'
                },
                pagination: true,
                sort: true,
                search: true,
                columns: ["Name", "Email", "Phone Number", "Country"],
                data: demoData
            });
            gridjsEvents.render(gridjsEventsElement);

            // Events
            gridjsEvents.on('ready', () => console.log('Instance is ready'));
            gridjsEvents.on('load', () => console.log('Data is loaded'));
            gridjsEvents.on('rowClick', (...args) => console.log('row: ' + JSON.stringify(args), args));
            gridjsEvents.on('cellClick', (...args) => console.log('cell: ' + JSON.stringify(args), args));
        }
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentGridJsAdvanced();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    GridJsAdvanced.init();
});
