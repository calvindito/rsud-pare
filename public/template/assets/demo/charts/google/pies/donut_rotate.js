/* ------------------------------------------------------------------------------
 *
 *  # Google Visualization - rotated donut
 *
 *  Google Visualization rotated donut chart demonstration
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var GoogleDonutRotated = function() {


    //
    // Setup module components
    //

    // Rotated donut
    var _googleDonutRotated = function() {
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
                drawDonutRotated();

                // Resize on sidebar width change
                var sidebarToggle = document.querySelectorAll('.sidebar-control');
                if (sidebarToggle) {
                    sidebarToggle.forEach(function(togglers) {
                        togglers.addEventListener('click', drawDonutRotated);
                    });
                }

                // Resize on window resize
                var resizeDonutRotated;
                window.addEventListener('resize', function() {
                    clearTimeout(resizeDonutRotated);
                    resizeDonutRotated = setTimeout(function () {
                        drawDonutRotated();
                    }, 200);
                });

                // Redraw chart when color theme is changed
                document.querySelectorAll('[name="main-theme"]').forEach(function(radio) {
                    radio.addEventListener('change', drawDonutRotated);
                });
            },
            packages: ['corechart']
        });

        // Chart settings
        function drawDonutRotated() {

            // Define charts element
            var donut_rotated_element = document.getElementById('google-donut-rotate');

            // Data
            var data = google.visualization.arrayToDataTable([
                ['Task', 'Hours per Day'],
                ['Work',     11],
                ['Eat',      2],
                ['Commute',  2],
                ['Watch TV', 2],
                ['Sleep',    7]
            ]);

            // Options
            var options_donut_rotate = {
                fontName: 'var(--body-font-family)',
                pieHole: 0.55,
                pieStartAngle: 180,
                height: 300,
                width: 500,
                backgroundColor: 'transparent',
                pieSliceBorderColor: color_theme('#2c2d32', '#fff'),
                colors: [
                    '#2ec7c9','#b6a2de','#5ab1ef','#ffb980',
                    '#d87a80','#8d98b3','#e5cf0d','#97b552'
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
                }
            };

            // Instantiate and draw our chart, passing in some options.
            var donut_rotate = new google.visualization.PieChart(donut_rotated_element);
            donut_rotate.draw(data, options_donut_rotate);
        }
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _googleDonutRotated();
        }
    }
}();


// Initialize module
// ------------------------------

GoogleDonutRotated.init();
