/* ------------------------------------------------------------------------------
 *
 *  # Google Visualization - geo chart
 *
 *  Google Visualization geo chart demonstration
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var GoogleGeoRegion = function() {


    //
    // Setup module components
    //

    // Geo chart
    var _googleGeoRegion = function() {
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
                drawRegionsMap();

                // Resize on sidebar width change
                var sidebarToggle = document.querySelectorAll('.sidebar-control');
                if (sidebarToggle) {
                    sidebarToggle.forEach(function(togglers) {
                        togglers.addEventListener('click', drawRegionsMap);
                    });
                }

                // Resize on window resize
                var resizeGeoRegion;
                window.addEventListener('resize', function() {
                    clearTimeout(resizeGeoRegion);
                    resizeGeoRegion = setTimeout(function () {
                        drawRegionsMap();
                    }, 200);
                });

                // Redraw chart when color theme is changed
                document.querySelectorAll('[name="main-theme"]').forEach(function(radio) {
                    radio.addEventListener('change', drawRegionsMap);
                });
            },
            packages: ['geochart']
        });

        // Chart settings
        function drawRegionsMap() {

            // Define charts element
            var geo_region_element = document.getElementById('google-geo-region');

            // Data
            var data = google.visualization.arrayToDataTable([
                ['Country', 'Popularity'],
                ['Germany', 200],
                ['United States', 300],
                ['Brazil', 400],
                ['Canada', 500],
                ['France', 600],
                ['RU', 700]
            ]);

            // Options
            var options = {
                fontName: 'var(--body-font-family)',
                height: 500,
                width: "100%",
                fontSize: 12,
                backgroundColor: 'transparent',
                datalessRegionColor: color_theme('#404249', '#f5f5f5'),
                tooltip: {
                    textStyle: {
                        fontSize: 14
                    }
                },
                colorAxis: {
                    colors: [color_theme('#467045', '#efe6dc'), color_theme('#81de7e', '#109618')]
                }
            };

            // Draw chart
            var chart = new google.visualization.GeoChart(geo_region_element);
            chart.draw(data, options);
        }
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _googleGeoRegion();
        }
    }
}();


// Initialize module
// ------------------------------

GoogleGeoRegion.init();
