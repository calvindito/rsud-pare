/* ------------------------------------------------------------------------------
 *
 *  # Echarts - Scatter bubble size example
 *
 *  Demo JS code for scatter chart with custom bubble size [light theme]
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var EchartsScatterBubbleSizeLight = function() {


    //
    // Setup module components
    //

    // Scatter chart with custom bubble size
    var _scatterBubbleSizeLightExample = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define element
        var scatter_bubble_size_element = document.getElementById('scatter_bubble_size');


        //
        // Charts configuration
        //

        if (scatter_bubble_size_element) {

            // Initialize chart
            var scatter_bubble_size = echarts.init(scatter_bubble_size_element, null, { renderer: 'svg' });


            //
            // Chart config
            //

            // Demo data
            function random(){
                var r = Math.round(Math.random() * 100);
                return (r * (r % 2 == 0 ? 1: -1));
            }
            function randomDataArray() {
                var d = [];
                var len = 100;
                while (len--) {
                    d.push([
                        random(),
                        random(),
                        Math.abs(random()),
                    ]);
                }
                return d;
            }

            // Options
            scatter_bubble_size.setOption({

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
                    data: ['Scatter1', 'Scatter2'],
                    itemGap: 30,
                    textStyle: {
                        color: 'var(--body-color)'
                    }
                },

                // Add tooltip
                tooltip: {
                    trigger: 'item',
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
                    }
                }],

                // Horizontal axis
                xAxis: [{
                    type: 'value',
                    scale: true,
                    splitNumber: 4,
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
                    scale: true,
                    splitNumber: 4,
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
                        name: 'Scatter1',
                        type: 'scatter',
                        symbolSize: function (value) {
                            return Math.round(value[2] / 3);
                        },
                        data: randomDataArray()
                    },
                    {
                        name: 'Scatter2',
                        type: 'scatter',
                        symbolSize: function (value) {
                            return Math.round(value[2] / 3);
                        },
                        data: randomDataArray()
                    }
                ]
            });
        }


        //
        // Resize charts
        //

        // Resize function
        var triggerChartResize = function() {
            scatter_bubble_size_element && scatter_bubble_size.resize();
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
            _scatterBubbleSizeLightExample();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    EchartsScatterBubbleSizeLight.init();
});
