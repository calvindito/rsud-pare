/* ------------------------------------------------------------------------------
 *
 *  # Echarts - Bars with line example
 *
 *  Demo JS code for mixed bars/line chart [light theme]
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var EchartsCustomBalanceStatsLight = function() {


    //
    // Setup module components
    //

    // Bar chart with line
    var _customBalanceStatsLightExample = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define element
        var balance_statistics_element = document.getElementById('balance_statistics');


        //
        // Charts configuration
        //

        if (balance_statistics_element) {

            // Initialize chart
            var balance_statistics = echarts.init(balance_statistics_element, null, { renderer: 'svg' });


            //
            // Chart config
            //

            // Common styles
            var labelRight = {
                normal: {
                    color: '#FF7043',
                    label: {
                        position: 'right'
                    }
                }
            };

            // Options
            balance_statistics.setOption({

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
                    right: 10,
                    top: 30,
                    bottom: 0,
                    containLabel: true
                },

                // Add legend
                legend: {
                    data: ['Income', 'Outcome'],
                    itemHeight: 8,
                    itemGap: 20,
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
                    data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
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
                        name: 'Income',
                        type: 'bar',
                        barCategoryGap: '50%',
                        label: {
                            position: 'left',
                            show: false,
                            formatter: '{b}',
                            height: 30
                        },
                        itemStyle: {
                            color: '#456db3',
                            barBorderRadius: [0, 3, 3, 0]
                        },
                        data: [190, 122, 160, 240, 110, 180, 280]
                    },
                    {
                        name: 'Outcome',
                        type: 'line',
                        smooth: true,
                        symbol: 'circle',
                        symbolSize: 8,
                        silent: true,
                        data: [120, 180, 30, 137, 90, 230, 120],
                        itemStyle: {
                            color: '#fac858',
                            borderWidth: 2
                        }
                    }
                ]
            });
        }


        //
        // Resize charts
        //

        // Resize function
        var triggerChartResize = function() {
            balance_statistics_element && balance_statistics.resize();
        };

        // On sidebar width change
        var sidebarToggle = document.querySelectorAll('.sidebar-control');
        if (sidebarToggle) {
            sidebarToggle.forEach(function(togglers) {
                togglers.addEventListener('click', triggerChartResize);
            });
        }

        // Resize chart in sidebar on mobile
        var sidebarMobileToggle = document.querySelectorAll('.navbar-toggler');
        if (sidebarMobileToggle) {
            sidebarMobileToggle.forEach(function(toggler) {
                toggler.addEventListener('click', triggerChartResize);
            });
        }

        // Resize charts when hidden element becomes visible
        document.querySelectorAll('[data-bs-toggle="tab"]').forEach(function(tabs) {
            tabs.addEventListener('shown.bs.tab', triggerChartResize);
        });

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
            _customBalanceStatsLightExample();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    EchartsCustomBalanceStatsLight.init();
});
