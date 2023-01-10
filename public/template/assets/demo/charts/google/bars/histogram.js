/* ------------------------------------------------------------------------------
 *
 *  # Google Visualization - histogram
 *
 *  Google Visualization histogram demonstration
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var GoogleHistogram = function() {


    //
    // Setup module components
    //

    // Histogram
    var _googleHistogram = function() {
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
                drawHistogram();

                // Resize on sidebar width change
                var sidebarToggle = document.querySelectorAll('.sidebar-control');
                if (sidebarToggle) {
                    sidebarToggle.forEach(function(togglers) {
                        togglers.addEventListener('click', drawHistogram);
                    });
                }

                // Resize on window resize
                var resizeHistogram;
                window.addEventListener('resize', function() {
                    clearTimeout(resizeHistogram);
                    resizeHistogram = setTimeout(function () {
                        drawHistogram();
                    }, 200);
                });

                // Redraw chart when color theme is changed
                document.querySelectorAll('[name="main-theme"]').forEach(function(radio) {
                    radio.addEventListener('change', drawHistogram);
                });
            },
            packages: ['corechart']
        });

        // Chart settings
        function drawHistogram() {

            // Define charts element
            var histogram_chart_element = document.getElementById('google-histogram');

            // Data
            var data = google.visualization.arrayToDataTable([
                ['Dinosaur', 'Length'],
                ['Acrocanthosaurus (top-spined lizard)', 12.2],
                ['Albertosaurus (Alberta lizard)', 9.1],
                ['Allosaurus (other lizard)', 12.2],
                ['Apatosaurus (deceptive lizard)', 22.9],
                ['Archaeopteryx (ancient wing)', 0.9],
                ['Argentinosaurus (Argentina lizard)', 36.6],
                ['Baryonyx (heavy claws)', 9.1],
                ['Brachiosaurus (arm lizard)', 30.5],
                ['Ceratosaurus (horned lizard)', 6.1],
                ['Coelophysis (hollow form)', 2.7],
                ['Compsognathus (elegant jaw)', 0.9],
                ['Deinonychus (terrible claw)', 2.7],
                ['Diplodocus (double beam)', 27.1],
                ['Dromicelomimus (emu mimic)', 3.4],
                ['Gallimimus (fowl mimic)', 5.5],
                ['Mamenchisaurus (Mamenchi lizard)', 21.0],
                ['Megalosaurus (big lizard)', 7.9],
                ['Microvenator (small hunter)', 1.2],
                ['Ornithomimus (bird mimic)', 4.6],
                ['Oviraptor (egg robber)', 1.5],
                ['Plateosaurus (flat lizard)', 7.9],
                ['Sauronithoides (narrow-clawed lizard)', 2.0],
                ['Seismosaurus (tremor lizard)', 45.7],
                ['Spinosaurus (spiny lizard)', 12.2],
                ['Supersaurus (super lizard)', 30.5],
                ['Tyrannosaurus (tyrant lizard)', 15.2],
                ['Ultrasaurus (ultra lizard)', 30.5],
                ['Velociraptor (swift robber)', 1.8]]
            );


            // Options
            var options_histogram = {
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
                    title: 'Dinosaur length',
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
                        color: color_theme('#4d4d51', '#E5E7EB')
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
                series: [{color: '#ffb980'}]
            };

            // Draw chart
            var histogram = new google.visualization.Histogram(histogram_chart_element);
            histogram.draw(data, options_histogram);
        }
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _googleHistogram();
        }
    }
}();


// Initialize module
// ------------------------------

GoogleHistogram.init();
