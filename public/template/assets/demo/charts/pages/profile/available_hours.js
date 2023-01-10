/* ------------------------------------------------------------------------------
 *
 *  # Echarts - Bars with line example
 *
 *  Demo JS code for mixed bars/line chart [light theme]
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var EchartsCustomAvailableHoursLight = function() {


    //
    // Setup module components
    //

    // Bar chart with line
    var _customAvailableHoursLightExample = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define element
        var available_hours_element = document.getElementById('available_hours');


        //
        // Charts configuration
        //

        if (available_hours_element) {

            // Initialize chart
            var available_hours = echarts.init(available_hours_element, null, { renderer: 'svg' });


            //
            // Chart config
            //

            // Options
            available_hours.setOption({

                // Define colors
                color: ['#2ec7c9','#b6a2de','#5ab1ef','#ffb980','#d87a80'],

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
                    data: ['Booked hours', 'Available hours'],
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
                    type: 'category',
                    data : ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
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
                    axisLabel: {
                        color: 'rgba(var(--body-color-rgb), .65)'
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
                        show: true,
                        areaStyle: {
                            color: ['rgba(var(--white-rgb), .01)', 'rgba(var(--black-rgb), .01)']
                        }
                    }
                }],

                // Add series
                series: [
                    {
                        name: 'Booked hours',
                        type: 'bar',
                        data: [4, 8, 6, 4, 7, 5, 9],
                        itemStyle: {
                            normal: {
                                color: '#B0BEC5',
                                label: {
                                    show: true,
                                    position: 'top',
                                    textStyle: {
                                        fontWeight: 500,
                                        color: 'var(--body-color)'
                                    }
                                }
                            }
                        }
                    },
                    {
                        name: 'Available hours',
                        type: 'bar',
                        data: [6, 2, 4, 6, 3, 5, 1],
                        itemStyle: {
                            normal: {
                                color: '#29B6F6',
                                label: {
                                    show: true,
                                    position: 'top',
                                    textStyle: {
                                        fontWeight: 500,
                                        color: 'var(--body-color)'
                                    }
                                }
                            }
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
            available_hours_element && available_hours.resize();
        };

        // On sidebar width change
        var sidebarToggle = document.querySelectorAll('.sidebar-control');
        if (sidebarToggle) {
            sidebarToggle.forEach(function(togglers) {
                togglers.addEventListener('click', triggerChartResize);
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
            _customAvailableHoursLightExample();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    EchartsCustomAvailableHoursLight.init();
});
