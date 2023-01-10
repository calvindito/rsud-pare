/* ------------------------------------------------------------------------------
 *
 *  # Google Visualization - sliced donut
 *
 *  Google Visualization sliced donut chart demonstration
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var GoogleDonutExploded = function() {


    //
    // Setup module components
    //

    // Exploded donut
    var _googleDonutExploded = function() {
        if (typeof google == 'undefined') {
            console.warn('Warning - Google Charts library is not loaded.');
            return;
        }

        // Switch colors in dark and light themes
        function color_theme(darkColor, lightColor) {
            return document.documentElement.getAttribute('data-color-theme') == 'dark' ? darkColor : lightColor
        }

        // Initialize chart
        google.charts.load('current', {
            callback: function () {

                // Draw chart
                drawDonutExploded();

                // Resize on sidebar width change
                var sidebarToggle = document.querySelectorAll('.sidebar-control');
                if (sidebarToggle) {
                    sidebarToggle.forEach(function(togglers) {
                        togglers.addEventListener('click', drawDonutExploded);
                    });
                }

                // Resize on window resize
                var resizeDonutExploded;
                window.addEventListener('resize', function() {
                    clearTimeout(resizeDonutExploded);
                    resizeDonutExploded = setTimeout(function () {
                        drawDonutExploded();
                    }, 200);
                });

                // Redraw chart when color theme is changed
                document.querySelectorAll('[name="main-theme"]').forEach(function(radio) {
                    radio.addEventListener('change', drawDonutExploded);
                });
            },
            packages: ['corechart']
        });

        // Chart settings
        function drawDonutExploded() {

            // Define charts element
            var donut_exploded_element = document.getElementById('google-donut-exploded');

            // Data
            var data = google.visualization.arrayToDataTable([
                ['Language', 'Speakers (in millions)'],
                ['Assamese', 13],
                ['Bengali', 83],
                ['Gujarati', 46],
                ['Hindi', 90],
                ['Kannada', 38],
                ['Maithili', 20],
                ['Malayalam', 33],
                ['Marathi', 72],
                ['Oriya', 33],
                ['Punjabi', 29],
                ['Tamil', 61],
                ['Telugu', 74],
                ['Urdu', 52]
            ]);

            // Options
            var options_donut_exploded = {
                fontName: 'var(--body-font-family)',
                height: 300,
                width: 540,
                backgroundColor: 'transparent',
                pieSliceBorderColor: color_theme('#2c2d32', '#fff'),
                colors: [
                    '#2ec7c9','#b6a2de','#5ab1ef','#ffb980','#d87a80',
                    '#8d98b3','#e5cf0d','#97b552','#95706d','#dc69aa',
                    '#07a2a4','#9a7fd1','#588dd5','#f5994e','#c05050',
                    '#59678c','#c9ab00','#7eb00a','#6f5553','#c14089'
                ],
                legend: {
                    textStyle: {
                        color: color_theme('#fff', '#333')
                    }
                },
                chartArea: {
                    left: 50,
                    width: '90%',
                    height: '90%'
                },
                pieHole: 0.5,
                pieSliceText: 'label',
                slices: {  
                    2: {offset: 0.15},
                    8: {offset: 0.1},
                    10: {offset: 0.15},
                    11: {offset: 0.1}
                }
            };

            // Instantiate and draw our chart, passing in some options.
            var donut_exploded = new google.visualization.PieChart(donut_exploded_element);
            donut_exploded.draw(data, options_donut_exploded);
        }
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _googleDonutExploded();
        }
    }
}();


// Initialize module
// ------------------------------

GoogleDonutExploded.init();
