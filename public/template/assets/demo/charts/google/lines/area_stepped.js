/* ------------------------------------------------------------------------------
 *
 *  # Google Visualization - stepped area
 *
 *  Google Visualization stepped area chart demonstration
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var GoogleAreaStepped = function() {


    //
    // Setup module components
    //

    // Stepped area chart
    var _googleAreaStepped = function() {
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
                drawSteppedAreaChart();

                // Resize on sidebar width change
                var sidebarToggle = document.querySelectorAll('.sidebar-control');
                if (sidebarToggle) {
                    sidebarToggle.forEach(function(togglers) {
                        togglers.addEventListener('click', drawSteppedAreaChart);
                    });
                }

                // Resize on window resize
                var resizeSteppedAreaChart;
                window.addEventListener('resize', function() {
                    clearTimeout(resizeSteppedAreaChart);
                    resizeSteppedAreaChart = setTimeout(function () {
                        drawSteppedAreaChart();
                    }, 200);
                });

                // Redraw chart when color theme is changed
                document.querySelectorAll('[name="main-theme"]').forEach(function(radio) {
                    radio.addEventListener('change', drawSteppedAreaChart);
                });
            },
            packages: ['corechart']
        });

        // Chart settings
        function drawSteppedAreaChart() {

            // Define charts element
            var area_stepped_element = document.getElementById('google-area-stepped');

            // Data
            var data = google.visualization.arrayToDataTable([
                ['Director (Year)',  'Rotten Tomatoes', 'IMDB'],
                ['Alfred Hitchcock (1935)', 8.4,         7.9],
                ['Ralph Thomas (1959)',     6.9,         6.5],
                ['Don Sharp (1978)',        6.5,         6.4],
                ['James Hawes (2008)',      4.4,         6.2]
            ]);

            // Options
            var options = {
                fontName: 'var(--body-font-family)',
                height: 400,
                isStacked: true,
                fontSize: 12,
                areaOpacity: 0.25,
                lineWidth: 1,
                pointSize: 7,
                backgroundColor: 'transparent',
                chartArea: {
                    left: '5%',
                    width: '94%',
                    height: 350
                },
                tooltip: {
                    textStyle: {
                        fontSize: 14
                    }
                },
                vAxis: {
                    title: 'Accumulated Rating',
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
                    minValue: 0
                },
                hAxis: {
                    textStyle: {
                        color: color_theme('#fff', '#333')
                    }
                },
                legend: {
                    position: 'top',
                    alignment: 'center',
                    textStyle: {
                        color: color_theme('#fff', '#333')
                    }
                },
                series: {
                    0: { color: '#2ec7c9' },
                    1: { color: '#b6a2de' }
                }
            };

            // Draw chart 
            var stepped_area_chart = new google.visualization.SteppedAreaChart(document.getElementById('google-area-stepped'));
            stepped_area_chart.draw(data, options);
        }
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _googleAreaStepped();
        }
    }
}();


// Initialize module
// ------------------------------

GoogleAreaStepped.init();
