/* ------------------------------------------------------------------------------
 *
 *  # Echarts - Customers chart example
 *
 *  Customers chart demo for ecommerce_customers.html page [light theme]
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var EchartsEcommerceCustomers = function() {


    //
    // Setup module components
    //

    // Chart
    var _customersExample = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define element
        var customers_chart_element = document.getElementById('customers_chart');


        //
        // Charts configuration
        //

        if (customers_chart_element) {

            // Initialize chart
            var customers_chart = echarts.init(customers_chart_element, null, { renderer: 'svg' });


            //
            // Chart config
            //

            // Options
            customers_chart.setOption({

                // Define colors
                color: ['#EF5350', '#03A9F4','#4CAF50'],

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
                    top: 35,
                    bottom: 0,
                    containLabel: true
                },

                // Add legend
                legend: {
                    type: 'scroll',
                    data: ['New customers','Returned customers','Orders'],
                    itemHeight: 8,
                    itemGap: 40,
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
                    type: 'category',
                    data: ['January','February','March','April','May','June','July','August','September','October','November','December'],
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
                yAxis: [
                    {
                        type: 'value',
                        axisTick: {
                            show: false
                        },
                        axisLabel: {
                            color: 'rgba(var(--body-color-rgb), .65)',
                            formatter: '{value}k'
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
                    },
                    {
                        type: 'value',
                        axisTick: {
                            show: false
                        },
                        axisLabel: {
                            color: 'rgba(var(--body-color-rgb), .65)',
                            formatter: '{value}k'
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
                    }
                ],

                // Add series
                series: [
                    {
                        name: 'New customers',
                        type: 'bar',
                        data: [20, 49, 70, 232, 256, 767, 1356, 1622, 326, 200, 64, 33]
                    },
                    {
                        name: 'Returned customers',
                        type: 'bar',
                        data: [26, 59, 90, 264, 287, 707, 1756, 1822, 487, 188, 60, 23]
                    },
                    {
                        name: 'Orders',
                        type: 'line',
                        smooth: true,
                        symbol: 'circle',
                        symbolSize: 8,
                        yAxisIndex: 1,
                        data: [20, 22, 33, 45, 63, 102, 203, 234, 230, 165, 120, 62]
                    }
                ]
            });
        }


        //
        // Resize charts
        //

        // Resize function
        var triggerChartResize = function() {
            customers_chart_element && customers_chart.resize();
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
            _customersExample();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    EchartsEcommerceCustomers.init();
});
