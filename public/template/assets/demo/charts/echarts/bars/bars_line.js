/* ------------------------------------------------------------------------------
 *
 *  # Echarts - Bars with line example
 *
 *  Demo JS code for mixed bars/line chart [light theme]
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var EchartsBarsLineLight = function() {


    //
    // Setup module components
    //

    // Bar chart with line
    var _barsLineBarsExample = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define element
        var bars_mix_element = document.getElementById('bars_mix');


        //
        // Charts configuration
        //

        if (bars_mix_element) {

            // Initialize chart
            var bars_mix = echarts.init(bars_mix_element, null, { renderer: 'svg' });


            //
            // Chart config
            //

            // Options
            bars_mix.setOption({

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
                    left: 0,
                    right: 30,
                    top: 30,
                    bottom: 0,
                    containLabel: true
                },

                // Add legend
                legend: {
                    data: ['Customers', 'Returned'],
                    itemHeight: 8,
                    itemGap: 30,
                    textStyle: {
                        color: 'var(--body-color)',
                        padding: [0, 5]
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
                    },
                    axisPointer: {
                        type: 'shadow',
                        shadowStyle: {
                            color: 'rgba(var(--body-color-rgb), 0.025)'
                        }
                    }
                },

                // Horizontal axis
                xAxis: [{
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
                        show: true,
                        lineStyle: {
                            color: 'var(--gray-300)',
                            type: 'dashed'
                        }
                    }
                }],

                // Vertical axis
                yAxis: [{
                    type: 'category',
                    data: ['Oct', 'Sep', 'Aug', 'July', 'June', 'May', 'Apr', 'Mar', 'Feb', 'Jan'],
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
                        name: 'Customers',
                        type: 'bar',
                        barCategoryGap: '40%',
                        label: {
                            show: false
                        },
                        itemStyle: {
                            normal: {
                                color: '#456db3',
                                barBorderRadius: [0, 4, 4, 0]
                            }
                        },
                        data: [1900, 1029, 1602, 2004, 1100, 1800, 2800, 1407, 2200, 900]
                    },
                    {
                        name: 'Returned',
                        type: 'line',
                        symbol: 'circle',
                        symbolSize: 8,
                        silent: true,
                        itemStyle: {
                            normal: {
                                color: '#fac858'
                            }
                        },
                        data: [100, 1000, 800, 1070, 900, 300, 1200, 900, 1200, 200]
                    }
                ]
            });
        }


        //
        // Resize charts
        //

        // Resize function
        var triggerChartResize = function() {
            bars_mix_element && bars_mix.resize();
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
            _barsLineBarsExample();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    EchartsBarsLineLight.init();
});
