/* ------------------------------------------------------------------------------
 *
 *  # Grid.js data sources examples
 *
 *  Demo JS code for gridjs_data_source.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const GridJsDataSource = function() {


    //
    // Setup module components
    //

    // Basic
    const _componentGridJsData = function() {
        if (typeof gridjs == 'undefined') {
            console.warn('Warning - gridjs.min.js is not loaded.');
            return;
        }

        // JSON format
        const gridjsJsonElement = document.querySelector(".gridjs-example-json");
        if(gridjsJsonElement) {
            const gridjsJson = new gridjs.Grid({
                className: {
                    table: 'table'
                },
                columns: [
                    {id: 'name', name: 'Name'},
                    {id: 'email', name: 'Email'},
                    {id: 'phoneNumber', name: 'Phone Number'},
                    {id: 'country', name: 'Country'}
                ],
                data: [
                    {name: 'John', email: 'john@example.com', phoneNumber: '(353) 01 222 3333', country: 'Netherlands'},
                    {name: 'Mark', email: 'mark@gmail.com', phoneNumber: '(01) 22 888 4444', country: 'Switzerland'},
                    {name: 'Eoin', email: 'eoin@gmail.com', phoneNumber: '0097 22 654 00033', country: 'Germany'},
                    {name: 'Sarah', email: 'sarahcdd@gmail.com', phoneNumber: '+322 876 1233', country: 'France'},
                    {name: 'Afshin', email: 'afshin@mail.com', phoneNumber: '(353) 22 87 8356', country: 'Norway'}
                ]
            });
            gridjsJson.render(gridjsJsonElement);
        }

        // XML format
        const gridjsXmlElement = document.querySelector(".gridjs-example-xml");
        if(gridjsXmlElement) {
            const gridjsXml = new gridjs.Grid({
                className: {
                    table: 'table'
                },
                sort: true,
                search: true,
                pagination: true,
                columns: ['Location', 'Change Frequency', 'Priority'],
                server: {
                    url: '../../../assets/demo/data/gridjs/demo.xml',
                    handle: (res) => {
                        return res.text().then(str => (new window.DOMParser()).parseFromString(str, "text/xml"));
                    },
                    then: data => {
                        return Array.from(data.querySelectorAll('url'))
                        .map(row => [
                            row.querySelector('loc').innerHTML,
                            row.querySelector('changefreq').innerHTML,
                            row.querySelector('priority').innerHTML,
                        ]);
                    }
                }
            });
            gridjsXml.render(gridjsXmlElement);
        }

        // Async data import
        const gridjsAsyncElement = document.querySelector(".gridjs-example-async");
        if(gridjsAsyncElement) {
            const gridjsAsync = new gridjs.Grid({
                className: {
                    table: 'table table'
                },
                sort: true,
                columns: ["Name", "Email", "Phone Number", "Country"],
                data: () => {
                    return new Promise(resolve => {
                        setTimeout(() =>
                            resolve([
                                ["John", "john@example.com", "(353) 01 222 3333", "Netherlands"],
                                ["Mark", "mark@gmail.com", "(01) 22 888 4444", "Switzerland"],
                                ["Eoin", "eoin@gmail.com", "0097 22 654 00033", "Germany"],
                                ["Sarah", "sarahcdd@gmail.com", "+322 876 1233", "France"],
                                ["Afshin", "afshin@mail.com", "(353) 22 87 8356", "Norway"]
                            ]),
                        1000);
                    });
                }
            });
            gridjsAsync.render(gridjsAsyncElement);
        }
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentGridJsData();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    GridJsDataSource.init();
});
