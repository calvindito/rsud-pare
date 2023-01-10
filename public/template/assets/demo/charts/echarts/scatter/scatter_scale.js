/* ------------------------------------------------------------------------------
 *
 *  # Echarts - Scatter scale example
 *
 *  Demo JS code for scalable scatter chart [light theme]
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var EchartsScatterScaleLight = function() {


    //
    // Setup module components
    //

    // Scalable scatter chart
    var _scatterScaleSizeLightExample = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define element
        var scatter_scale_element = document.getElementById('scatter_scale');


        //
        // Charts configuration
        //

        if (scatter_scale_element) {

            // Initialize chart
            var scatter_scale = echarts.init(scatter_scale_element, null, { renderer: 'svg' });


            //
            // Chart config
            //

            // Options
            scatter_scale.setOption({

                // Main colors
                color: ['#2ec7c9', '#b6a2de'],

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
                    top: 35,
                    bottom: 0,
                    containLabel: true
                },

                // Add legend
                legend: {
                    data: ['sin', 'cos'],
                    itemGap: 30,
                    textStyle: {
                        color: 'var(--body-color)'
                    }
                },

                // Add tooltip
                tooltip: {
                    trigger: 'axis',
                    showDelay : 0,
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
                        name: 'sin',
                        type: 'scatter',
                        large: true,
                        symbolSize: 7,
                        data: (function () {
                            var d = [];
                            var len = 1000;
                            var x = 0;
                            while (len--) {
                                x = (Math.random() * 10).toFixed(3) - 0;
                                d.push([
                                    x,
                                    (Math.sin(x) - x * (len % 2 ? 0.1 : -0.1) * Math.random()).toFixed(3) - 0
                                ]);
                            }
                            return d;
                        })()
                    },
                    {
                        name: 'cos',
                        type: 'scatter',
                        large: true,
                        symbolSize: 6,
                        data: (function () {
                            var d = [];
                            var len = 2000;
                            var x = 0;
                            while (len--) {
                                x = (Math.random() * 10).toFixed(3) - 0;
                                d.push([
                                    x,
                                    (Math.cos(x) - x * (len % 2 ? 0.1 : -0.1) * Math.random()).toFixed(3) - 0
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
            scatter_scale_element && scatter_scale.resize();
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
            _scatterScaleSizeLightExample();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    EchartsScatterScaleLight.init();
});
