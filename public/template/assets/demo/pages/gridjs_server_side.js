/* ------------------------------------------------------------------------------
 *
 *  # Grid.js server side examples
 *
 *  Demo JS code for gridjs_server_side.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const GridJsServerSide = function() {


    //
    // Setup module components
    //

    // Basic
    const _componentGridJsServer = function() {
        if (typeof gridjs == 'undefined') {
            console.warn('Warning - gridjs.min.js is not loaded.');
            return;
        }

        // Import server-side data
        const gridjsServerElement = document.querySelector(".gridjs-example-server");
        if(gridjsServerElement) {
            const gridjsServer = new gridjs.Grid({
                className: {
                    table: 'table'
                },
                columns: ['Title', 'Director', 'Producer'],
                server: {
                    url: 'https://swapi.dev/api/films/',
                    then: data => data.results.map(movie => [movie.title, movie.director, movie.producer])
                }
            });
            gridjsServer.render(gridjsServerElement);
        }

        // Server side search
        const gridjsServerSearchElement = document.querySelector(".gridjs-example-server-search");
        if(gridjsServerSearchElement) {
            const gridjsServerSearch = new gridjs.Grid({
                className: {
                    table: 'table'
                },
                search: {
                    server: {
                        url: (prev, keyword) => `${prev}?search=${keyword}`
                    }
                },
                columns: ['Title', 'Director', 'Producer'],
                server: {
                    url: 'https://swapi.dev/api/films/',
                    then: data => data.results.map(movie => [movie.title, movie.director, movie.producer])
                }
            });
            gridjsServerSearch.render(gridjsServerSearchElement);
        }

        // Server side pagination
        const gridjsServerPaginationElement = document.querySelector(".gridjs-example-server-pagination");
        if(gridjsServerPaginationElement) {
            const gridjsServerPagination = new gridjs.Grid({
                className: {
                    table: 'table'
                },
                pagination: {
                    enabled: true,
                    limit: 5,
                    server: {
                        url: (prev, page, limit) => `${prev}?limit=${limit}&offset=${page * limit}`
                    }
                },
                columns: ['Pokemon', 'URL'],
                server: {
                    url: 'https://pokeapi.co/api/v2/pokemon',
                    then: data => data.results.map(pokemon => [
                        pokemon.name, gridjs.html(`<a href='${pokemon.url}'>Link to ${pokemon.name}</a>`)
                    ]),
                    total: data => data.count
                }
            });
            gridjsServerPagination.render(gridjsServerPaginationElement);
        }

        // Server side sorting
        const gridjsServerSortingElement = document.querySelector(".gridjs-example-server-sorting");
        if(gridjsServerSortingElement) {
            const gridjsServerSorting = new gridjs.Grid({
                className: {
                    table: 'table'
                },
                pagination: true,
                sort: {
                    multiColumn: false,
                    server: {
                        url: (prev, columns) => {
                            if (!columns.length) return prev;

                            const col = columns[0];
                            const dir = col.direction === 1 ? 'asc' : 'desc';
                            let colName = ['name', 'rarity'][col.index];

                            return `${prev}&order=${colName}&dir=${dir}`;
                        }
                    }
                },
                columns: [
                    'Name',
                    'Artist',
                    'Rarity',
                    'Frame',
                    {
                        name: 'Image',
                        width: 50,
                        sort: false,
                        formatter: (img) => gridjs.html(`<img src='${img}' height="40"/>`)
                    }
                ],
                server: {
                    url: 'https://api.scryfall.com/cards/search?q=Inspiring',
                    then: data => data.data.map(card => [card.name, card.artist, card.rarity, card.frame, card.image_uris.small]),
                    total: data => data.total_cards
                }
            });
            gridjsServerSorting.render(gridjsServerSortingElement);
        }
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentGridJsServer();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    GridJsServerSide.init();
});
