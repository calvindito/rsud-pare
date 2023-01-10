/* ------------------------------------------------------------------------------
 *
 *  # Google Visualization - scatter
 *
 *  Google Visualization scatter chart demonstration
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var GoogleScatterBasic = function() {


    //
    // Setup module components
    //

    // Scatter chart
    var _googleScatterBasic = function() {
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
                drawScatter();

                // Resize on sidebar width change
                var sidebarToggle = document.querySelectorAll('.sidebar-control');
                if (sidebarToggle) {
                    sidebarToggle.forEach(function(togglers) {
                        togglers.addEventListener('click', drawScatter);
                    });
                }

                // Resize on window resize
                var resizeScatterBasic;
                window.addEventListener('resize', function() {
                    clearTimeout(resizeScatterBasic);
                    resizeScatterBasic = setTimeout(function () {
                        drawScatter();
                    }, 200);
                });

                // Redraw chart when color theme is changed
                document.querySelectorAll('[name="main-theme"]').forEach(function(radio) {
                    radio.addEventListener('change', drawScatter);
                });
            },
            packages: ['corechart']
        });

        // Chart settings
        function drawScatter() {

            // Define charts element
            var scatter_chart_element = document.getElementById('google-scatter');

            // Data
            var data = google.visualization.arrayToDataTable([
                ['Age', 'Weight'],
                [ 8,      12],
                [ 4,      6],
                [ 11,     14],
                [ 4,      5],
                [ 3,      3.5],
                [ 6.5,    7],
                [ 7,    10],
                [ 6.5,    12],
                [ 6,    13],
                [ 8,    16],
                [ 12,    17],
                [ 18,    8],
                [ 18,    9],
                [ 16,    12]
            ]);

            // Options
            var options = {
                fontName: 'var(--body-font-family)',
                height: 450,
                fontSize: 12,
                backgroundColor: 'transparent',
                colors: [
                    '#ffb980','#b6a2de','#5ab1ef','#2ec7c9',
                    '#d87a80','#8d98b3','#e5cf0d','#97b552'
                ],
                chartArea: {
                    left: '5%',
                    width: '94%',
                    height: 400
                },
                tooltip: {
                    textStyle: {
                        fontSize: 14
                    }
                },
                hAxis: {
                    textStyle: {
                        color: color_theme('#fff', '#333')
                    },
                    baselineColor: color_theme('#6e6f71', '#9CA3AF'),
                    gridlines:{
                        color: color_theme('#4d4d51', '#E5E7EB')
                    },
                    minorGridlines: {
                        color: color_theme('#3f4044', '#F3F4F6')
                    },
                    minValue: 0,
                    maxValue: 15
                },
                vAxis: {
                    title: 'Weight',
                    titleTextStyle: {
                        fontSize: 14,
                        italic: false,
                        color: color_theme('#fff', '#333')
                    },
                    textStyle: {
                        color: color_theme('#fff', '#333')
                    },
                    baselineColor: color_theme('#6e6f71', '#9CA3AF'),
                    gridlines:{
                        color: color_theme('#4d4d51', '#E5E7EB'),
                        count: 10
                    },
                    minorGridlines: {
                        color: color_theme('#3f4044', '#F3F4F6')
                    },
                    minValue: 0,
                    maxValue: 15
                },
                legend: 'none',
                pointSize: 10
            };

            // Draw chart
            var scatter = new google.visualization.ScatterChart(scatter_chart_element);
            scatter.draw(data, options);
        }
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _googleScatterBasic();
        }
    }
}();


// Initialize module
// ------------------------------

GoogleScatterBasic.init();
