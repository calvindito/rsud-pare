/* ------------------------------------------------------------------------------
 *
 *  # Google Visualization - stacked columns
 *
 *  Google Visualization stacked column chart demonstration
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var GoogleColumnStacked = function() {


    //
    // Setup module components
    //

    // Stacked column chart
    var _googleColumnStacked = function() {
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
                drawColumnStacked();

                // Resize on sidebar width change
                var sidebarToggle = document.querySelectorAll('.sidebar-control');
                if (sidebarToggle) {
                    sidebarToggle.forEach(function(togglers) {
                        togglers.addEventListener('click', drawColumnStacked);
                    });
                }

                // Resize on window resize
                var resizeColumnStacked;
                window.addEventListener('resize', function() {
                    clearTimeout(resizeColumnStacked);
                    resizeColumnStacked = setTimeout(function () {
                        drawColumnStacked();
                    }, 200);
                });

                // Redraw chart when color theme is changed
                document.querySelectorAll('[name="main-theme"]').forEach(function(radio) {
                    radio.addEventListener('change', drawColumnStacked);
                });
            },
            packages: ['corechart']
        });

        // Chart settings
        function drawColumnStacked() {

            // Define charts element
            var column_stacked_element = document.getElementById('google-column-stacked');

            // Data
            var data = google.visualization.arrayToDataTable([
                ['Genre', 'Fantasy & Sci Fi', 'Romance', 'Mystery/Crime', 'General', 'Western', 'Literature', { role: 'annotation' } ],
                ['2000', 20, 30, 35, 40, 45, 30, ''],
                ['2005', 14, 20, 25, 30, 48, 30, ''],
                ['2010', 10, 24, 20, 32, 18, 5, ''],
                ['2015', 15, 25, 30, 35, 20, 15, ''],
                ['2020', 16, 22, 23, 30, 16, 9, ''],
                ['2025', 12, 26, 20, 40, 20, 30, ''],
                ['2030', 28, 19, 29, 30, 12, 13, '']
            ]);


            // Options
            var options_column_stacked = {
                fontName: 'var(--body-font-family)',
                height: 400,
                fontSize: 12,
                backgroundColor: 'transparent',
                isStacked: true,
                chartArea: {
                    left: '5%',
                    width: '95%',
                    height: 350
                },
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
                    1: { color: '#b6a2de' },
                    2: { color: '#5ab1ef' },
                    3: { color: '#ffb980' },
                    4: { color: '#d87a80' },
                    5: { color: '#8d98b3' }
                }
            };

            // Draw chart
            var column_stacked = new google.visualization.ColumnChart(column_stacked_element);
            column_stacked.draw(data, options_column_stacked);
        }
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _googleColumnStacked();
        }
    }
}();


// Initialize module
// ------------------------------

GoogleColumnStacked.init();
