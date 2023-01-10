/* ------------------------------------------------------------------------------
 *
 *  # Google Visualization - pie chart
 *
 *  Google Visualization pie chart demonstration
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var GooglePieBasic = function() {


    //
    // Setup module components
    //

    // Pie chart
    var _googlePieBasic = function() {
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
                drawPie();

                // Resize on sidebar width change
                var sidebarToggle = document.querySelectorAll('.sidebar-control');
                if (sidebarToggle) {
                    sidebarToggle.forEach(function(togglers) {
                        togglers.addEventListener('click', drawPie);
                    });
                }

                // Resize on window resize
                var resizePieBasic;
                window.addEventListener('resize', function() {
                    clearTimeout(resizePieBasic);
                    resizePieBasic = setTimeout(function () {
                        drawPie();
                    }, 200);
                });

                // Redraw chart when color theme is changed
                document.querySelectorAll('[name="main-theme"]').forEach(function(radio) {
                    radio.addEventListener('change', drawPie);
                });
            },
            packages: ['corechart']
        });

        // Chart settings    
        function drawPie() {

            // Define charts element
            var pie_chart_element = document.getElementById('google-pie');

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
            var options_pie = {
                fontName: 'var(--body-font-family)',
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
            var pie = new google.visualization.PieChart(pie_chart_element);
            pie.draw(data, options_pie);
        }
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _googlePieBasic();
        }
    }
}();


// Initialize module
// ------------------------------

GooglePieBasic.init();
