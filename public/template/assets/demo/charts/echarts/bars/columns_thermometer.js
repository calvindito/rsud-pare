/* ------------------------------------------------------------------------------
 *
 *  # Echarts - Thermometer column example
 *
 *  Demo JS code for thermometer column chart [light theme]
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var EchartsColumnsThermometerLight = function() {


    //
    // Setup module components
    //

    // Thermometer column chart
    var _columnsThermometerLightExample = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define element
        var columns_thermometer_element = document.getElementById('columns_thermometer');


        //
        // Charts configuration
        //

        if (columns_thermometer_element) {

            // Initialize chart
            var columns_thermometer = echarts.init(columns_thermometer_element, null, { renderer: 'svg' });


            //
            // Chart config
            //

            // Options
            var columns_thermometer_options = {

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
                    right: 10,
                    top: 35,
                    bottom: 0,
                    containLabel: true
                },

                // Add legend
                legend: {
                    data: ['Actual', 'Forecast'],
                    itemHeight: 8,
                    itemGap: 30,
                    textStyle: {
                        color: 'var(--body-color)'
                    },
                    selectedMode: false
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
                    },
                    axisPointer: {
                        type: 'shadow',
                        shadowStyle: {
                            color: 'rgba(var(--body-color-rgb), 0.025)'
                        }
                    },
                    formatter: function (params) {
                        return '<div class="fw-semibold">' + params[0].name + '</div>'
                        + params[0].seriesName + ': ' + params[0].value + '<br/>'
                        + params[1].seriesName + ': ' + (params[1].value + params[0].value);
                    }
                },

                // Horizontal axis
                xAxis: [{
                    type: 'category',
                    data: ['Cosco', 'CMA', 'APL', 'OOCL', 'Wanhai', 'Zim', 'Maersk', 'Hanjin', 'Nyk'],
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
                            color: 'var(--gray-300)',
                            type: 'dashed'
                        }
                    }
                }],

                // Vertical axis
                yAxis: [{
                    type: 'value',
                    boundaryGap: [0, 0.1],
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

                // Add series
                series: [
                    {
                        name: 'Actual',
                        type: 'bar',
                        stack: 'sum',
                        barCategoryGap: '50%',
                        itemStyle: {
                            normal: {
                                color: '#5570c6',
                                barBorderColor: '#5570c6',
                                barBorderWidth: 6,
                                label: {
                                    show: true,
                                    position: 'insideTop',
                                    color: '#fff',
                                    fontWeight: 500
                                }
                            }
                        },
                        data: [260, 200, 220, 120, 100, 80, 130, 230, 90]
                    },
                    {
                        name: 'Forecast',
                        type: 'bar',
                        stack: 'sum',
                        itemStyle: {
                            normal: {
                                color: 'var(--card-bg)',
                                barBorderColor: '#5570c6',
                                barBorderWidth: 6,
                                barBorderRadius: [4, 4, 0, 0],
                                label: {
                                    show: true,
                                    position: 'top',
                                    formatter: function (params) {
                                        for (var i = 0, l = columns_thermometer_options.xAxis[0].data.length; i < l; i++) {
                                            if (columns_thermometer_options.xAxis[0].data[i] == params.name) {
                                                return columns_thermometer_options.series[0].data[i] + params.value;
                                            }
                                        }
                                    },
                                    color: '#5570c6',
                                    fontWeight: 500
                                }
                            }
                        },
                        data: [40, 80, 50, 80,80, 70, 60, 90, 120]
                    }
                ]
            };

            // Set options
            columns_thermometer.setOption(columns_thermometer_options);
        }


        //
        // Resize charts
        //

        // Resize function
        var triggerChartResize = function() {
            columns_thermometer_element && columns_thermometer.resize();
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
            _columnsThermometerLightExample();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    EchartsColumnsThermometerLight.init();
});
