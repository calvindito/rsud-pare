/* ------------------------------------------------------------------------------
 *
 *  # Google Visualization - area
 *
 *  Google Visualization area chart demonstration
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var GoogleAreaBasic = function() {


    //
    // Setup module components
    //

    // Area chart
    var _googleAreaBasic = function() {
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
                drawAreaChart();

                // Resize on sidebar width change
                var sidebarToggle = document.querySelectorAll('.sidebar-control');
                if (sidebarToggle) {
                    sidebarToggle.forEach(function(togglers) {
                        togglers.addEventListener('click', drawAreaChart);
                    });
                }

                // Resize on window resize
                var resizeAreaChart;
                window.addEventListener('resize', function() {
                    clearTimeout(resizeAreaChart);
                    resizeAreaChart = setTimeout(function () {
                        drawAreaChart();
                    }, 200);
                });

                // Redraw chart when color theme is changed
                document.querySelectorAll('[name="main-theme"]').forEach(function(radio) {
                    radio.addEventListener('change', drawAreaChart);
                });
            },
            packages: ['corechart']
        });

        // Chart settings
        function drawAreaChart() {

            // Define charts element
            var area_basic_element = document.getElementById('google-area');

            // Data
            var data = google.visualization.arrayToDataTable([
                ['Year', 'Sales', 'Expenses'],
                ['2004',  1000,      400],
                ['2005',  1170,      460],
                ['2006',  660,       1120],
                ['2007',  1030,      540]
            ]);


            // Options
            var options = {
                fontName: 'var(--body-font-family)',
                height: 400,
                fontSize: 12,
                areaOpacity: 0.25,
                chartArea: {
                    left: '5%',
                    width: '94%',
                    height: 350
                },
                pointSize: 7,
                backgroundColor: 'transparent',
                tooltip: {
                    textStyle: {
                        fontSize: 14
                    }
                },
                vAxis: {
                    title: 'Sales and Expenses',
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
                    gridarea:{
                        count: 10
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
            var area_chart = new google.visualization.AreaChart(area_basic_element);
            area_chart.draw(data, options);
        }
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _googleAreaBasic();
        }
    }
}();


// Initialize module
// ------------------------------

GoogleAreaBasic.init();
