/* ------------------------------------------------------------------------------
 *
 *  # Tag inputs
 *
 *  Demo JS code for form_tag_inputs.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var TagInputs = function() {


    //
    // Setup module components
    //

    // Tokenfield
    var _componentTokenfield = function() {
        if (typeof Tokenfield == 'undefined') {
            console.warn('Warning - tokenfield.min.js is not loaded.');
            return;
        }

        // Demo data
        const cars = [
            {id: 1, name: "Acura"},
            {id: 2, name: "Audi"},
            {id: 3, name: "BMW"},
            {id: 4, name: "Buick"},
            {id: 5, name: "Cadillac"},
            {id: 6, name: "Chevrolet"},
            {id: 7, name: "Chrysler"},
            {id: 8, name: "Citroen"},
            {id: 9, name: "Dodge"},
            {id: 10, name: "Eagle"},
            {id: 11, name: "Ferrari"},
            {id: 12, name: "Ford"},
            {id: 13, name: "General Motors"},
            {id: 14, name: "GMC"},
            {id: 15, name: "Honda"},
            {id: 16, name: "Hummer"},
            {id: 17, name: "Hyundai"},
            {id: 18, name: "Infiniti"},
            {id: 19, name: "Isuzu"},
            {id: 20, name: "Jaguar"},
            {id: 21, name: "Jeep"},
            {id: 22, name: "Kia"},
            {id: 23, name: "Lamborghini"},
            {id: 24, name: "Land Rover"},
            {id: 25, name: "Lexus"},
            {id: 26, name: "Lincoln"},
            {id: 27, name: "Lotus"},
            {id: 28, name: "Mazda"},
            {id: 29, name: "Mercedes-Benz"},
            {id: 30, name: "Mercury"},
            {id: 31, name: "Mitsubishi"},
            {id: 32, name: "Nissan"},
            {id: 33, name: "Oldsmobile"},
            {id: 34, name: "Peugeot"},
            {id: 35, name: "Pontiac"},
            {id: 36, name: "Porsche"},
            {id: 37, name: "Regal"},
            {id: 38, name: "Renault"},
            {id: 39, name: "Saab"},
            {id: 40, name: "Saturn"},
            {id: 41, name: "Seat"},
            {id: 42, name: "Skoda"},
            {id: 43, name: "Subaru"},
            {id: 44, name: "Suzuki"},
            {id: 45, name: "Toyota"},
            {id: 46, name: "Volkswagen"},
            {id: 47, name: "Volvo"}
        ];


        // Basic initialization
        document.querySelectorAll('.tokenfield-basic').forEach(function(element) {
            const tfBasic = new Tokenfield({
                el: element,
                items: cars
            });
        });

        const tfCustom = new Tokenfield({
            el: document.querySelector('.tokenfield-custom'),
            newItems: false,
            items: cars
        });

        const tfSingle = new Tokenfield({
            el: document.querySelector('.tokenfield-single'),
            multiple: false,
            items: cars
        });

        const tfLimit = new Tokenfield({
            el: document.querySelector('.tokenfield-limit'),
            maxItems: 2,
            items: cars
        });

        const tfMatchStart = new Tokenfield({
            el: document.querySelector('.tokenfield-match-start'),
            matchStart: true,
            items: cars
        });

        const tfMatchEnd = new Tokenfield({
            el: document.querySelector('.tokenfield-match-end'),
            matchEnd: true,
            items: cars
        });

        const tfBlur = new Tokenfield({
            el: document.querySelector('.tokenfield-blur'),
            addItemOnBlur: true,
            items: cars
        });

        const tfDelimiters = new Tokenfield({
            el: document.querySelector('.tokenfield-delimiters'),
            delimiters: [','],
            items: cars
        });

        const tfPaste = new Tokenfield({
            el: document.querySelector('.tokenfield-paste'),
            addItemsOnPaste: true,
            items: cars
        });

        const tfMinChars = new Tokenfield({
            el: document.querySelector('.tokenfield-min-chars'),
            minChars: 1,
            items: cars
        });

        const tfPlaceholder = new Tokenfield({
            el: document.querySelector('.tokenfield-placeholder'),
            items: cars,
            placeholder: 'Custom placeholder'
        });

        const tfRemote = new Tokenfield({
            el: document.querySelector('.tokenfield-remote'),
            items: cars,
            remote: {
                url: '../../../assets/demo/data/tags_input/car_brands.json'
            }
        });

        const tfRemoteRemap = new Tokenfield({
            el: document.querySelector('.tokenfield-remote-remap'),
            items: cars,
            remote: {
                url: '../../../assets/demo/data/tags_input/car_brands.json',
                headers: {
                    'foo': 'bar',
                    'hello': function() {
                        return 'world';
                    }
                }
            }
        });
        tfRemoteRemap.remapData = function(response) {
        console.log('bar');
            return response;
        }
        tfRemoteRemap.renderSetItemLabel = function(item) {
            return item.name.toUpperCase();
        }
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentTokenfield();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    TagInputs.init();
});
