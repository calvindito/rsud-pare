/* ------------------------------------------------------------------------------
 *
 *  # Echarts - Stacked bar example
 *
 *  Demo JS code for stacked bar chart [light theme]
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var EchartsBarsStackedLight = function() {


    //
    // Setup module components
    //

    // Stacked bar chart
    var _barsStackedLightExample = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define element
        var bars_stacked_element = document.getElementById('bars_stacked');


        //
        // Charts configuration
        //

        if (bars_stacked_element) {

            // Initialize chart
            var bars_stacked = echarts.init(bars_stacked_element, null, { renderer: 'svg' });


            //
            // Chart config
            //

            // Options
            bars_stacked.setOption({

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
                    top: 35,
                    bottom: 0,
                    containLabel: true
                },

                // Add legend
                legend: {
                    data: ['Internet Explorer','Opera','Safari','Firefox','Chrome'],
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
                    data: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
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
                        name: 'Internet Explorer',
                        type: 'bar',
                        stack: 'Total',
                        barWidth: 36,
                        itemStyle: {
                            normal: {
                                color: '#42A5F5',
                                label: {
                                    show: true,
                                    position: 'insideRight',
                                    padding: [0, 10],
                                    fontSize: 12,
                                    fontWeight: 500
                                }
                            }
                        },
                        data:[320, 302, 301, 334, 390, 330, 320]
                    },
                    {
                        name: 'Opera',
                        type: 'bar',
                        stack: 'Total',
                        itemStyle: {
                            normal: {
                                color: '#ef5350',
                                label: {
                                    show: true,
                                    position: 'insideRight',
                                    padding: [0, 10],
                                    fontSize: 12,
                                    fontWeight: 500
                                }
                            }
                        },
                        data:[120, 132, 101, 134, 120, 230, 210]
                    },
                    {
                        name: 'Safari',
                        type: 'bar',
                        stack: 'Total',
                        itemStyle: {
                            normal: {
                                color: '#66bb6a',
                                label: {
                                    show: true,
                                    position: 'insideRight',
                                    padding: [0, 10],
                                    fontSize: 12,
                                    fontWeight: 500
                                }
                            }
                        },
                        data:[220, 182, 191, 234, 290, 330, 310]
                    },
                    {
                        name: 'Firefox',
                        type: 'bar',
                        stack: 'Total',
                        itemStyle: {
                            normal: {
                                color: '#ff7043',
                                label: {
                                    show: true,
                                    position: 'insideRight',
                                    padding: [0, 10],
                                    fontSize: 12,
                                    fontWeight: 500
                                }
                            }
                        },
                        data:[150, 212, 201, 154, 190, 330, 410]
                    },
                    {
                        name: 'Chrome',
                        type: 'bar',
                        stack: 'Total',
                        itemStyle: {
                            normal: {
                                color: '#26a69a',
                                barBorderRadius: [0, 4, 4, 0],
                                label: {
                                    show: true,
                                    position: 'insideRight',
                                    padding: [0, 10],
                                    fontSize: 12,
                                    fontWeight: 500
                                }
                            }
                        },
                        data:[820, 832, 901, 934, 1290, 1330, 1320]
                    }
                ]
            });
        }


        //
        // Resize charts
        //

        // Resize function
        var triggerChartResize = function() {
            bars_stacked_element && bars_stacked.resize();
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
            _barsStackedLightExample();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    EchartsBarsStackedLight.init();
});
