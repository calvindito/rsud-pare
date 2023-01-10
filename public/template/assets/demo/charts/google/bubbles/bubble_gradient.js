/* ------------------------------------------------------------------------------
 *
 *  # Google Visualization - bubbles with color scale
 *
 *  Google Visualization bubble chart with color scale demonstration
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var GoogleBubbleGradientChart = function() {


    //
    // Setup module components
    //

    // Bubble chart with gradient
    var _googleBubbleGradientChart = function() {
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
                drawBubbleGradientChart();

                // Resize on sidebar width change
                var sidebarToggle = document.querySelectorAll('.sidebar-control');
                if (sidebarToggle) {
                    sidebarToggle.forEach(function(togglers) {
                        togglers.addEventListener('click', drawBubbleGradientChart);
                    });
                }

                // Resize on window resize
                var resizeBubbleGradientChart;
                window.addEventListener('resize', function() {
                    clearTimeout(resizeBubbleGradientChart);
                    resizeBubbleGradientChart = setTimeout(function () {
                        drawBubbleGradientChart();
                    }, 200);
                });

                // Redraw chart when color theme is changed
                document.querySelectorAll('[name="main-theme"]').forEach(function(radio) {
                    radio.addEventListener('change', drawBubbleGradientChart);
                });
            },
            packages: ['corechart']
        });

        // Chart settings
        function drawBubbleGradientChart() {

            // Define charts element
            var bubble_gradient_element = document.getElementById('google-bubble-gradient');

            // Data
            var data = google.visualization.arrayToDataTable([
                ['ID', 'X', 'Y', 'Temperature'],
                ['',   80,  167,      120],
                ['',   79,  136,      130],
                ['',   78,  184,      50],
                ['',   72,  278,      230],
                ['',   81,  200,      210],
                ['',   72,  170,      100],
                ['',   68,  477,      80]
            ]);

            // Optinos
            var options = {
                fontName: 'var(--body-font-family)',
                height: 450,
                fontSize: 12,
                backgroundColor: 'transparent',
                colors: [
                    '#5ab1ef','#d87a80'
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
                    fontSize: 12
                  },
                  opacity: 1,
                  stroke: 'transparent'
                },
                colorAxis: {
                    legend: {
                        textStyle: {
                            color: color_theme('#fff', '#333')
                        }
                    }
                }
            };

            // Draw chart
            var gradient_bubble = new google.visualization.BubbleChart(bubble_gradient_element);
            gradient_bubble.draw(data, options);
        }
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _googleBubbleGradientChart();
        }
    }
}();


// Initialize module
// ------------------------------

GoogleBubbleGradientChart.init();
