/* ------------------------------------------------------------------------------
 *
 *  # Echarts - Basic area chart example
 *
 *  Demo JS code for basic area chart [light theme]
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var EchartsAreaBasicLight = function() {


    //
    // Setup module components
    //

    // Basic area chart
    var _areaBasicLightExample = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define element
        var area_basic_element = document.getElementById('area_basic');


        //
        // Charts configuration
        //

        if (area_basic_element) {

            // Initialize chart
            var area_basic = echarts.init(area_basic_element, null, { renderer: 'svg' });


            //
            // Chart config
            //

            // Options
            area_basic.setOption({

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
                    right: 40,
                    top: 35,
                    bottom: 5,
                    containLabel: true
                },

                // Add legend
                legend: {
                    data: ['New orders', 'In progress', 'Closed deals'],
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
                        name: 'Closed deals',
                        type: 'line',
                        data: [10, 12, 21, 54, 260, 830, 710],
                        areaStyle: {
                            normal: {
                                opacity: 0.25
                            }
                        },
                        smooth: true,
                        symbol: 'circle',
                        symbolSize: 8,
                    },
                    {
                        name: 'In progress',
                        type: 'line',
                        smooth: true,
                        symbol: 'circle',
                        symbolSize: 8,
                        areaStyle: {
                            normal: {
                                opacity: 0.25
                            }
                        },
                        data: [30, 182, 434, 791, 390, 30, 10]
                    },
                    {
                        name: 'New orders',
                        type: 'line',
                        smooth: true,
                        symbol: 'circle',
                        symbolSize: 8,
                        areaStyle: {
                            normal: {
                                opacity: 0.25
                            }
                        },
                        data: [1320, 1132, 601, 234, 120, 90, 20]
                    }
                ]
            });
        }


        //
        // Resize charts
        //

        // Resize function
        var triggerChartResize = function() {
            area_basic_element && area_basic.resize();
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
            _areaBasicLightExample();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    EchartsAreaBasicLight.init();
});
