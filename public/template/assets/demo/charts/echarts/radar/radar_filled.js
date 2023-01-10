/* ------------------------------------------------------------------------------
 *
 *  # Echarts - Radar filled example
 *
 *  Demo JS code for filled radar chart [light theme]
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var EchartsRadarFilledLight = function() {


    //
    // Setup module components
    //

    // Filled radar chart
    var _radarFilledLightExample = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define element
        var radar_filled_element = document.getElementById('radar_filled');


        //
        // Charts configuration
        //

        if (radar_filled_element) {

            // Initialize chart
            var radar_filled = echarts.init(radar_filled_element, null, { renderer: 'svg' });


            //
            // Chart config
            //

            // Options
            radar_filled.setOption({

                // Global text styles
                textStyle: {
                    fontFamily: 'var(--body-font-family)',
                    color: 'var(--body-color)',
                    fontSize: 14,
                    lineHeight: 22,
                    textBorderColor: 'transparent'
                },

                // Add tooltip
                tooltip: {
                    trigger: 'item',
                    className: 'shadow-sm rounded',
                    backgroundColor: 'var(--white)',
                    borderColor: 'var(--gray-400)',
                    padding: 15,
                    textStyle: {
                        color: '#000'
                    }
                },

                // Add legend
                legend: {
                    orient: 'vertical',
                    top: 0,
                    left: 0,
                    data: ['Allocated Budget','Actual Spending'],
                    itemHeight: 8,
                    itemWidth: 8,
                    textStyle: {
                        color: 'var(--body-color)'
                    }
                },

                // Setup polar coordinates
                radar: [{
                    radius: '84%',
                    center:  ['50%', '50%'],
                    axisName: {
                        color: 'var(--body-color)'
                    },
                    axisLine: {
                        lineStyle: {
                            color: 'var(--gray-500)'
                        }
                    },
                    splitLine: {
                        lineStyle: {
                            color: 'var(--gray-300)'
                        }
                    },
                    splitArea: {
                        areaStyle: {
                            color: ['rgba(var(--white-rgb), .01)', 'rgba(var(--black-rgb), .01)']
                        }
                    },
                    indicator: [
                        {text: 'Sales', max: 100},
                        {text: 'Administration', max: 100},
                        {text: 'Information Techology', max: 100},
                        {text: 'Customer Support', max: 100},
                        {text: 'Development', max: 100},
                        {text: 'Marketing', max: 100}
                    ],
                }],

                // Add series
                series: [{
                    name: 'Budget vs spending',
                    type: 'radar',
                    symbolSize: 7,
                    itemStyle: {
                        normal: {
                            borderWidth: 1
                        }
                    },
                    lineStyle: {
                        normal: {
                            width: 1
                        }
                    },
                    areaStyle: {
                        normal: {
                            opacity: 0.5
                        }
                    },
                    data: [
                        {
                            value: [97, 68, 88, 94, 90, 86],
                            name: 'Allocated Budget'
                        },
                        {
                            value: [97, 32, 46, 95, 88, 92],
                            name: 'Actual Spending'
                        }
                    ]
                }]
            });
        }


        //
        // Resize charts
        //

        // Resize function
        var triggerChartResize = function() {
            radar_filled_element && radar_filled.resize();
        };

        // On sidebar width change
        var sidebarToggle = document.querySelectorAll('.sidebar-control');
        if (sidebarToggle) {
            sidebarToggle.forEach(function(togglers) {
                togglers.addEventListener('click', triggerChartResize);
            });
        }

        // On window resize
        var resizeCharts;
        window.addEventListener('resize', function() {
            clearTimeout(resizeCharts);
            resizeCharts = setTimeout(function () {
                triggerChartResize();
            }, 200);
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _radarFilledLightExample();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    EchartsRadarFilledLight.init();
});
