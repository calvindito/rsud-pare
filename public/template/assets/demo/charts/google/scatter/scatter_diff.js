/* ------------------------------------------------------------------------------
 *
 *  # Google Visualization - diff scatter
 *
 *  Google Visualization diff scatter chart demonstration
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var GoogleScatterDiff = function() {


    //
    // Setup module components
    //

    // Scatter diff chart
    var _googleScatterDiff = function() {
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
                drawScatterDiff();

                // Resize on sidebar width change
                var sidebarToggle = document.querySelectorAll('.sidebar-control');
                if (sidebarToggle) {
                    sidebarToggle.forEach(function(togglers) {
                        togglers.addEventListener('click', drawScatterDiff);
                    });
                }

                // Resize on window resize
                var resizeScatterDiff;
                window.addEventListener('resize', function() {
                    clearTimeout(resizeScatterDiff);
                    resizeScatterDiff = setTimeout(function () {
                        drawScatterDiff();
                    }, 200);
                });

                // Redraw chart when color theme is changed
                document.querySelectorAll('[name="main-theme"]').forEach(function(radio) {
                    radio.addEventListener('change', drawScatterDiff);
                });
            },
            packages: ['corechart']
        });

        // Chart settings
        function drawScatterDiff() {

            // Define charts element
            var scatter_diff_element = document.getElementById('google-scatter-diff');

            // Old data
            var oldData = google.visualization.arrayToDataTable([
                ['', 'Medicine 1', 'Medicine 2'],
                [23, null, 12], [9, null, 39], [15, null, 28],
                [37, null, 30], [21, null, 14], [12, null, 18],
                [29, null, 34], [ 8, null, 12], [38, null, 28],
                [35, null, 12], [26, null, 10], [10, null, 29],
                [11, null, 10], [27, null, 38], [39, null, 17],
                [34, null, 20], [38, null,  5], [33, null, 27],
                [23, null, 39], [12, null, 10], [ 8, 15, null],
                [39, 15, null], [27, 31, null], [30, 24, null],
                [31, 39, null], [35,  6, null], [ 5,  5, null],
                [19, 39, null], [22,  8, null], [19, 23, null],
                [27, 20, null], [11,  6, null], [34, 33, null],
                [38,  8, null], [39, 29, null], [13, 23, null],
                [13, 36, null], [39,  6, null], [14, 37, null], [13, 39, null]
            ]);

            // New data
            var newData = google.visualization.arrayToDataTable([
                ['', 'Medicine 1', 'Medicine 2'],
                [22, null, 12], [7, null, 40], [14, null, 31],
                [37, null, 30], [18, null, 17], [9, null, 20],
                [26, null, 36], [5, null, 13], [36, null, 30],
                [35, null, 15], [24, null, 12], [7, null, 31],
                [10, null, 12], [24, null, 40], [37, null, 18],
                [32, null, 21], [35, null, 7], [31, null, 30],
                [21, null, 42], [12, null, 10], [10, 13, null],
                [40, 12, null], [28, 29, null], [32, 22, null],
                [31, 37, null], [38, 5, null], [6, 4, null],
                [21, 36, null], [22, 8, null], [21, 22, null],
                [28, 17, null], [12, 5, null], [37, 30, null],
                [41, 7, null], [41, 27, null], [15, 20, null],
                [14, 36, null], [42, 3, null], [14, 37, null], [15, 36, null]
            ]);

            // Options
            var options = {
                fontName: 'var(--body-font-family)',
                height: 450,
                fontSize: 12,
                backgroundColor: 'transparent',
                colors: [
                    '#2ec7c9','#d87a80','#5ab1ef','#ffb980',
                    '#b6a2de','#8d98b3','#e5cf0d','#97b552'
                ],
                chartArea: {
                    left: '3%',
                    width: '95%',
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
                    minValue: 0
                },
                vAxis: {
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
                    minValue: 0
                },
                legend: {
                    position: 'top',
                    alignment: 'center',
                    textStyle: {
                        color: color_theme('#fff', '#333')
                    }
                },
                pointSize: 10,
                diff: {
                    oldData: {
                        opacity: 0.5
                    }
                },
            };

            // Attach chart to the DOM element
            var chartOldOpacity = new google.visualization.ScatterChart(scatter_diff_element);

            // Set data
            var diffData = chartOldOpacity.computeDiff(oldData, newData);

            // Draw our chart, passing in some options
            chartOldOpacity.draw(diffData, options);
        }
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _googleScatterDiff();
        }
    }
}();


// Initialize module
// ------------------------------

GoogleScatterDiff.init();
