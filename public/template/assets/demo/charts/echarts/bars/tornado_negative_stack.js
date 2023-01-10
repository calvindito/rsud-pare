/* ------------------------------------------------------------------------------
 *
 *  # Echarts - Negative stack tornado example
 *
 *  Demo JS code for Negative stack tornado chart [light theme]
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var EchartsTornadoNegativeStackLight = function() {


    //
    // Setup module components
    //

    // Negative stack tornado
    var _tornadoNegativeStackLightExample = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define elements
        var tornado_negative_stack_element = document.getElementById('tornado_negative_stack');


        //
        // Charts configuration
        //

        if (tornado_negative_stack_element) {

            // Initialize chart
            var tornado_negative_stack = echarts.init(tornado_negative_stack_element, null, { renderer: 'svg' });


            //
            // Chart config
            //

            // Options
            tornado_negative_stack.setOption({

                // Define colors
                color: ['#66bc69','#5ab1ef','#e36083'],

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
                    right: 15,
                    top: 35,
                    bottom: 0,
                    containLabel: true
                },

                // Add legend
                legend: {
                    type: 'scroll',
                    data: ['Profit', 'Expenses', 'Income'],
                    itemHeight: 8,
                    itemGap: 30,
                    pageIconColor: 'var(--body-color)',
                    pageIconInactiveColor: 'var(--gray-500)',
                    pageTextStyle: {
                        color: 'var(--body-color)'
                    },
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
                    data: ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'],
                    axisTick: {
                        show: false
                    },
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
                        name: 'Profit',
                        type: 'bar',
                        barWidth: 26,
                        itemStyle: {
                            normal: {
                                barBorderRadius: [0, 4, 4, 0],
                                label: {
                                    show: true,
                                    position: 'inside',
                                    textStyle: {
                                        fontSize: 12,
                                        fontWeight: 500,
                                        color: 'var(--white)'
                                    }
                                }
                            }
                        },
                        data: [200, 170, 240, 244, 200, 220, 210]
                    },
                    {
                        name: 'Income',
                        type: 'bar',
                        stack: 'Total',
                        barWidth: 5,
                        itemStyle: {
                            normal: {
                                barBorderRadius: [0, 4, 4, 0],
                                label: {
                                    show: true,
                                    position: 'right',
                                    textStyle: {
                                        fontSize: 12,
                                        fontWeight: 500,
                                        color: 'var(--body-color)'
                                    }
                                }
                            }
                        },
                        data: [320, 302, 341, 374, 390, 450, 420]
                    },
                    {
                        name: 'Expenses',
                        type: 'bar',
                        stack: 'Total',
                        itemStyle: {
                            normal: {
                                barBorderRadius: [4, 0, 0, 4],
                                label: {
                                    show: true,
                                    position: 'left',
                                    textStyle: {
                                        fontSize: 12,
                                        fontWeight: 500,
                                        color: 'var(--body-color)'
                                    }
                                }
                            }
                        },
                        data: [-120, -132, -101, -134, -190, -230, -210]
                    }
                ]
            });
        }


        //
        // Resize charts
        //

        // Resize function
        var triggerChartResize = function() {
            tornado_negative_stack_element && tornado_negative_stack.resize();
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
            _tornadoNegativeStackLightExample();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    EchartsTornadoNegativeStackLight.init();
});
