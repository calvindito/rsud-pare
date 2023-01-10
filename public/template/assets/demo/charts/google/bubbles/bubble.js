/* ------------------------------------------------------------------------------
 *
 *  # Google Visualization - bubbles
 *
 *  Google Visualization bubble chart demonstration
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var GoogleBubbleChart = function() {


    //
    // Setup module components
    //

    // Bubble chart
    var _googleBubbleChart = function() {
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
                drawBubbleChart();

                // Resize on sidebar width change
                var sidebarToggle = document.querySelectorAll('.sidebar-control');
                if (sidebarToggle) {
                    sidebarToggle.forEach(function(togglers) {
                        togglers.addEventListener('click', drawBubbleChart);
                    });
                }

                // Resize on window resize
                var resizeBubbleChart;
                window.addEventListener('resize', function() {
                    clearTimeout(resizeBubbleChart);
                    resizeBubbleChart = setTimeout(function () {
                        drawBubbleChart();
                    }, 200);
                });

                // Redraw chart when color theme is changed
                document.querySelectorAll('[name="main-theme"]').forEach(function(radio) {
                    radio.addEventListener('change', drawBubbleChart);
                });
            },
            packages: ['corechart']
        });

        // Chart settings
        function drawBubbleChart() {

            // Define charts element
            var bubble_chart_element = document.getElementById('google-bubble');

            // Data
            var data = google.visualization.arrayToDataTable([
                ['ID', 'Life Expectancy', 'Fertility Rate', 'Region'],
                ['CAN',    82.66,              1.67,      'North America'],
                ['DEU',    79.84,              1.36,      'Europe'],
                ['DNK',    70.6,               1.84,      'Europe'],
                ['EGY',    72.73,              2.78,      'Middle East'],
                ['GBR',    75.05,              2,         'Europe'],
                ['IRN',    72.49,              0.7,       'Middle East'],
                ['IRQ',    68.09,              4.77,      'Middle East'],
                ['ISR',    81.55,              3.96,      'Middle East'],
                ['RUS',    68.6,               1.54,      'Europe'],
                ['USA',    78.09,              3.05,      'North America']
            ]);

            // Options
            var options = {
                fontName: 'var(--body-font-family)',
                height: 450,
                fontSize: 12,
                backgroundColor: 'transparent',
                colors: [
                    '#2ec7c9','#b6a2de','#5ab1ef','#ffb980',
                    '#d87a80','#8d98b3','#e5cf0d','#97b552'
                ],
                chartArea: {
                    left: '4%',
                    width: '95%',
                    height: 400
                },
                tooltip: {
                    textStyle: {
                        fontSize: 14
                    }
                },
                vAxis: {
                    title: 'Fertility Rate',
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
                    },
                    baselineColor: color_theme('#6e6f71', '#9CA3AF'),
                    gridlines:{
                        color: color_theme('#4d4d51', '#E5E7EB'),
                        count: 10
                    },
                    minorGridlines: {
                        color: color_theme('#3f4044', '#F3F4F6')
                    }
                },
                bubble: {
                  textStyle: {
                    auraColor: 'none',
                    color: '#fff'
                  },
                  opacity: 1,
                  stroke: 'transparent'
                },
                legend: {
                    position: 'top',
                    alignment: 'center',
                    textStyle: {
                        color: color_theme('#fff', '#333')
                    }
                }
            };

            // Draw chart
            var bubble = new google.visualization.BubbleChart(bubble_chart_element);
            bubble.draw(data, options);
        }
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _googleBubbleChart();
        }
    }
}();


// Initialize module
// ------------------------------

GoogleBubbleChart.init();
