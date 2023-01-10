/* ------------------------------------------------------------------------------
 *
 *  # Echarts - Stacked line example
 *
 *  Demo JS code for stacked line chart [light theme]
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var EchartsLinesStackedLight = function() {


    //
    // Setup module components
    //

    // Stacked line chart
    var _linesStackedLightExample = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define element
        var line_stacked_element = document.getElementById('line_stacked');


        //
        // Charts configuration
        //

        if (line_stacked_element) {

            // Initialize chart
            var line_stacked = echarts.init(line_stacked_element, null, { renderer: 'svg' });


            //
            // Chart config
            //

            // Options
            line_stacked.setOption({

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
                    right: 25,
                    top: 35,
                    bottom: 10,
                    containLabel: true
                },

                // Add legend
                legend: {
                    data: ['Edge', 'Opera', 'Safari', 'Firefox', 'Chrome'],
                    itemHeight: 8,
                    itemGap: 30,
                    textStyle: {
                        color: 'var(--body-color)'
                    }
                },

                // Add tooltip
                tooltip: {
                    trigger: 'axis',
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
                    type: 'category',
                    boundaryGap: false,
                    data: [
                        'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'
                    ],
                    axisLabel: {
                        color: 'rgba(var(--body-color-rgb), .65)'
                    },
                    axisLine: {
                        lineStyle: {
                            color: 'var(--gray-500)'
                        }
                    },
                    splitLine: {
                        show: true,
                        lineStyle: {
                            color: 'var(--gray-300)'
                        }
                    }
                }],

                // Vertical axis
                yAxis: [{
                    type: 'value',
                    axisLabel: {
                        color: 'rgba(var(--body-color-rgb), .65)'
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

                // Axis pointer
                axisPointer: [{
                    lineStyle: {
                        color: 'var(--gray-600)'
                    }
                }],

                // Add series
                series: [
                    {
                        name: 'Edge',
                        type: 'line',
                        stack: 'Total',
                        smooth: true,
                        symbol: 'circle',
                        symbolSize: 8,
                        data: [120, 132, 101, 134, 90, 230, 210]
                    },
                    {
                        name: 'Opera',
                        type: 'line',
                        stack: 'Total',
                        smooth: true,
                        symbol: 'circle',
                        symbolSize: 8,
                        data: [220, 182, 191, 234, 290, 330, 310]
                    },
                    {
                        name: 'Safari',
                        type: 'line',
                        stack: 'Total',
                        smooth: true,
                        symbol: 'circle',
                        symbolSize: 8,
                        data: [150, 232, 201, 154, 190, 330, 410]
                    },
                    {
                        name: 'Firefox',
                        type: 'line',
                        stack: 'Total',
                        smooth: true,
                        symbol: 'circle',
                        symbolSize: 8,
                        data: [320, 332, 301, 334, 390, 330, 320]
                    },
                    {
                        name: 'Chrome',
                        type: 'line',
                        stack: 'Total',
                        smooth: true,
                        symbol: 'circle',
                        symbolSize: 8,
                        data: [820, 932, 901, 934, 1290, 1330, 1320]
                    }
                ]
            });
        }


        //
        // Resize charts
        //

        // Resize function
        var triggerChartResize = function() {
            line_stacked_element && line_stacked.resize();
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
            _linesStackedLightExample();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    EchartsLinesStackedLight.init();
});
