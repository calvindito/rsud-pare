/* ------------------------------------------------------------------------------
 *
 *  # Google Visualization - chart combinations
 *
 *  Google Visualization combo chart demonstration
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var GoogleComboChart = function() {


    //
    // Setup module components
    //

    // Combo chart
    var _googleComboChart = function() {
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
                drawCombo();

                // Resize on sidebar width change
                var sidebarToggle = document.querySelectorAll('.sidebar-control');
                if (sidebarToggle) {
                    sidebarToggle.forEach(function(togglers) {
                        togglers.addEventListener('click', drawCombo);
                    });
                }

                // Resize on window resize
                var resizeCombo;
                window.addEventListener('resize', function() {
                    clearTimeout(resizeCombo);
                    resizeCombo = setTimeout(function () {
                        drawCombo();
                    }, 200);
                });

                // Redraw chart when color theme is changed
                document.querySelectorAll('[name="main-theme"]').forEach(function(radio) {
                    radio.addEventListener('change', drawCombo);
                });
            },
            packages: ['corechart']
        });

        // Chart settings
        function drawCombo() {

            // Define charts element
            var combo_chart_element = document.getElementById('google-combo');

            // Data
            var data = google.visualization.arrayToDataTable([
                ['Month', 'Bolivia', 'Ecuador', 'Madagascar', 'Papua New Guinea', 'Rwanda', 'Average'],
                ['2004/05',  165,      938,         522,             998,           450,      614.6],
                ['2005/06',  135,      1120,        599,             1268,          288,      682],
                ['2006/07',  157,      1167,        587,             807,           397,      623],
                ['2007/08',  139,      1110,        615,             968,           215,      609.4],
                ['2008/09',  136,      691,         629,             1026,          366,      569.6]
            ]);


            // Options
            var options_combo = {
                fontName: 'var(--body-font-family)',
                height: 400,
                fontSize: 12,
                backgroundColor: 'transparent',
                seriesType: "bars",
                chartArea: {
                    left: '4%',
                    width: '95%',
                    height: 350
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
                    3: { color: '#8d98b3' },
                    4: { color: '#d87a80' },
                    5: {
                        type: "line",
                        pointSize: 7,
                        curveType: 'function',
                        color: '#f5994e'
                    }
                },
            };

            // Draw chart
            var combo = new google.visualization.ComboChart(combo_chart_element);
            combo.draw(data, options_combo);
        }
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _googleComboChart();
        }
    }
}();


// Initialize module
// ------------------------------

GoogleComboChart.init();
