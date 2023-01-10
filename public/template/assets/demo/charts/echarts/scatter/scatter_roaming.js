/* ------------------------------------------------------------------------------
 *
 *  # Echarts - Scatter roaming example
 *
 *  Demo JS code for scatter roaming chart [light theme]
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var EchartsScatterRoamingLight = function() {


    //
    // Setup module components
    //

    // Scatter roaming chart
    var _scatterRoamingLightExample = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define element
        var scatter_roaming_element = document.getElementById('scatter_roaming');


        //
        // Charts configuration
        //

        if (scatter_roaming_element) {

            // Initialize chart
            var scatter_roaming = echarts.init(scatter_roaming_element, null, { renderer: 'svg' });


            //
            // Chart config
            //

            // Options
            scatter_roaming.setOption({

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
                    right: 20,
                    top: 10,
                    bottom: 50,
                    containLabel: true
                },

                // Display visual map
                visualMap: {
                    type: 'continuous',
                    min: 0,
                    max: 100,
                    bottom: 0,
                    left: 'center',
                    text: ['High', 'Low'],
                    textGap: 20,
                    color: ['#FB8C00', '#FFE0B2'],
                    calculable: true,
                    itemWidth: 15,
                    itemHeight: 200,
                    orient: 'horizontal',
                    textStyle: {
                        fontSize: 12,
                        color: '#777'
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
                        type: 'cross',
                        crossStyle: {
                            color: 'var(--gray-600)'
                        }
                    }
                },

                // Axis pointer
                axisPointer: [{
                    label: {
                        fontSize: 12
                    },
                    lineStyle: {
                        color: 'var(--gray-600)'
                    }
                }],

                // Horizontal axis
                xAxis: [{
                    type: 'value',
                    scale: true,
                    axisLabel: {
                        color: 'rgba(var(--body-color-rgb), .65)',
                        formatter: '{value} cm'
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
                    scale: true,
                    axisLabel: {
                        color: 'rgba(var(--body-color-rgb), .65)',
                        formatter: '{value} kg'
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
                        name: 'Scatter1',
                        type: 'scatter',
                        data: (function () {
                            var d = [];
                            var len = 500;
                            var value;
                            while (len--) {
                                value = (Math.random()*100).toFixed(2) - 0;
                                d.push([
                                    (Math.random()*value + value).toFixed(2) - 0,
                                    (Math.random()*value).toFixed(2) - 0,
                                    value
                                ]);
                            }
                            return d;
                        })()
                    }
                ]
            });
        }


        //
        // Resize charts
        //

        // Resize function
        var triggerChartResize = function() {
            scatter_roaming_element && scatter_roaming.resize();
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
            _scatterRoamingLightExample();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    EchartsScatterRoamingLight.init();
});
