/* ------------------------------------------------------------------------------
 *
 *  # Echarts - Floating bars example
 *
 *  Demo JS code for floating bars chart [light theme]
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var EchartsBarsFloatingLight = function() {


    //
    // Setup module components
    //

    // Floating bar chart
    var _barsFloatingLightExample = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define element
        var bars_float_element = document.getElementById('bars_float');


        //
        // Charts configuration
        //

        if (bars_float_element) {

            // Initialize chart
            const bars_float = echarts.init(bars_float_element, null, { renderer: 'svg' });


            //
            // Chart config
            //

            // Variables
            const placeHoledStyle = {
                normal: {
                    barBorderColor: 'transparent',
                    color: 'transparent'
                }
            };
            const dataStyle = { 
                normal: {
                    barBorderRadius: [0, 4, 4, 0],
                    label: {
                        show: true,
                        position: 'insideLeft',
                        formatter: '{c}%',
                        textStyle: {
                            padding: 5,
                            fontSize: 12,
                            fontWeight: 500
                        }
                    }
                }
            };

            // Options
            bars_float.setOption({

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
                    left: 5,
                    right: 15,
                    top: 35,
                    bottom: 0,
                    containLabel: true
                },

                // Add legend
                legend: {
                    data: ['GML', 'PYP','WTC', 'ZTW'],
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
                    },
                    formatter: '<div class="mb-1">{b}</div>{a0}: {c0}%<br/>{a2}: {c2}%<br/>{a4}: {c4}%<br/>{a6}: {c6}%'
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
                    data: ['Paris', 'Berlin', 'Amsterdam', 'Madrid', 'Munich', 'Budapest'],
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
                        name: 'GML',
                        type: 'bar',
                        stack: 'Total',
                        itemStyle: dataStyle,
                        data: [38, 50, 33, 72, 67, 34]
                    },
                    {
                        name: 'GML',
                        type: 'bar',
                        stack: 'Total',
                        itemStyle: placeHoledStyle,
                        data: [62, 50, 67, 28, 33, 66]
                    },
                    {
                        name: 'PYP',
                        type: 'bar',
                        stack: 'Total',
                        itemStyle: dataStyle,
                        data: [61, 41, 42, 30, 50, 62]
                    },
                    {
                        name: 'PYP',
                        type: 'bar',
                        stack: 'Total',
                        itemStyle: placeHoledStyle,
                        data: [39, 59, 58, 70, 50, 38]
                    },
                    {
                        name: 'WTC',
                        type: 'bar',
                        stack: 'Total',
                        itemStyle: dataStyle,
                        data: [37, 35, 44, 60, 28, 43]
                    },
                    {
                        name: 'WTC',
                        type: 'bar',
                        stack: 'Total',
                        itemStyle: placeHoledStyle,
                        data: [63, 65, 56, 40, 72, 57]
                    },
                    {
                        name: 'ZTW',
                        type: 'bar',
                        stack: 'Total',
                        itemStyle: dataStyle,
                        data: [71, 50, 31, 39, 40, 29]
                    },
                    {
                        name: 'ZTW',
                        type: 'bar',
                        stack: 'Total',
                        itemStyle: placeHoledStyle,
                        data: [29, 50, 69, 61, 60, 61]
                    }
                ]
            });
        }


        //
        // Resize charts
        //

        // Resize function
        var triggerChartResize = function() {
            bars_float_element && bars_float.resize();
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
            _barsFloatingLightExample();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    EchartsBarsFloatingLight.init();
});
