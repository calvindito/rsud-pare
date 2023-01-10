/* ------------------------------------------------------------------------------
 *
 *  # Echarts - Line with inverted axes example
 *
 *  Demo JS code for line chart with inverted axes [light theme]
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var EchartsLinesInvertedAxesLight = function() {


    //
    // Setup module components
    //

    // Line chart with inverted axes
    var _linesInvertedAxesLightExample = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define element
        var line_inverted_axes_element = document.getElementById('line_inverted_axes');


        //
        // Charts configuration
        //

        if (line_inverted_axes_element) {

            // Initialize chart
            var line_inverted_axes = echarts.init(line_inverted_axes_element, null, { renderer: 'svg' });


            //
            // Chart config
            //

            // Options
            line_inverted_axes.setOption({

                // Define colors
                color: ['#0092ff'],

                // Global text styles
                textStyle: {
                    fontFamily: 'var(--body-font-family)',
                    color: 'var(--body-color)',
                    fontSize: 14,
                    lineHeight: 22,
                    textBorderColor: 'transparent'
                },

                // Chart animation duration
                animationDuration: 750,

                // Setup grid
                grid: {
                    left: 10,
                    right: 40,
                    top: 35,
                    bottom: 0,
                    containLabel: true
                },

                // Add legend
                legend: {
                    data: ['Altitude(km) and temperature(°C)'],
                    itemHeight: 8,
                    itemGap: 30,
                    textStyle: {
                        color: 'var(--body-color)'
                    }
                },

                // Add tooltip
                tooltip: {
                    trigger: 'axis',
                    formatter: 'Temperature: <br/>{b}km: {c}°C',
                    className: 'shadow-sm rounded',
                    backgroundColor: 'var(--white)',
                    borderColor: 'var(--gray-400)',
                    padding: 15,
                    textStyle: {
                        color: '#000'
                    }
                },

                // Horizontal axis
                xAxis: [{
                    type: 'value',
                    data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    axisLabel: {
                        color: 'rgba(var(--body-color-rgb), .65)',
                        formatter: '{value} °C'
                    },
                    axisLine: {
                        show: true,
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
                        show: true,
                        areaStyle: {
                            color: ['rgba(var(--white-rgb), .01)', 'rgba(var(--black-rgb), .01)']
                        }
                    }
                }],

                // Vertical axis
                yAxis: [{
                    type: 'category',
                    boundaryGap: false,
                    axisLabel: {
                        formatter: '{value} km',
                        color: 'rgba(var(--body-color-rgb), .65)'
                    },
                    axisLine: {
                        onZero: false,
                        lineStyle: {
                            color: 'var(--gray-500)'
                        }
                    },
                    splitLine: {
                        show: true,
                        lineStyle: {
                            color: 'var(--gray-300)'
                        }
                    },
                    data: [
                        0, 10, 20, 30, 40, 50, 60, 70, 80
                    ]
                }],

                // Axis pointer
                axisPointer: [{
                    lineStyle: {
                        color: 'var(--gray-600)'
                    }
                }],

                // Add series
                series: [
                    {
                        name: 'Altitude(km) and temperature(°C)',
                        type: 'line',
                        smooth: true,
                        symbol: 'circle',
                        symbolSize: 8,
                        data: [
                            15, -50, -56.5, -46.5, -22.1, -2.5, -27.7, -55.7, -76.5
                        ]
                    }
                ]
            });
        }


        //
        // Resize charts
        //

        // Resize function
        var triggerChartResize = function() {
            line_inverted_axes_element && line_inverted_axes.resize();
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
            _linesInvertedAxesLightExample();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    EchartsLinesInvertedAxesLight.init();
});
