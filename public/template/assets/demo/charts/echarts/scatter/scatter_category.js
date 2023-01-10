/* ------------------------------------------------------------------------------
 *
 *  # Echarts - Scatter category example
 *
 *  Demo JS code for scatter category chart [light theme]
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var EchartsScatterCategoryLight = function() {


    //
    // Setup module components
    //

    // Category scatter chart
    var _scatterCategoryLightExample = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define element
        var scatter_category_element = document.getElementById('scatter_category');


        //
        // Charts configuration
        //

        if (scatter_category_element) {

            // Initialize chart
            var scatter_category = echarts.init(scatter_category_element, null, { renderer: 'svg' });


            //
            // Chart config
            //

            // Options
            scatter_category.setOption({

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
                    right: 10,
                    top: 74,
                    bottom: 60,
                    containLabel: true
                },

                // Add legend
                legend: {
                    data: ['Series1', 'Series2'],
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
                    },
                    axisPointer: {
                        type: 'cross',
                        crossStyle: {
                            color: 'var(--gray-600)'
                        }
                    },
                },

                // Add data zoom
                dataZoom: [
                    {
                        type: 'inside',
                        start: 30,
                        end: 70
                    },
                    {
                        show: true,
                        type: 'slider',
                        start: 30,
                        end: 70,
                        height: 40,
                        bottom: 10,
                        borderColor: 'var(--gray-400)',
                        fillerColor: 'rgba(0,0,0,0.05)',
                        textStyle: {
                            color: 'var(--body-color)'
                        },
                        handleStyle: {
                            color: '#8fb0f7',
                            borderColor: 'rgba(0,0,0,0.25)'
                        },
                        moveHandleStyle: {
                            color: '#8fb0f7',
                            borderColor: 'rgba(0,0,0,0.25)'
                        },
                        dataBackground: {
                            lineStyle: {
                                color: 'var(--gray-500)'
                            },
                            areaStyle: {
                                color: 'var(--gray-500)',
                                opacity: 0.1
                            }
                        }
                    }
                ],

                // Display visual map
                visualMap: {
                    type: 'piecewise',
                    min: 0,
                    max: 100,
                    orient: 'horizontal',
                    top: 35,
                    left: 'center',
                    splitNumber: 5,
                    itemGap: 30,
                    textStyle: {
                        color: 'var(--body-color)'
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
                    type: 'category',
                    data: function () {
                        var list = [];
                        var len = 0;
                        while (len++ < 500) {
                            list.push(len);
                        }
                        return list;
                    }(),
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
                        name: 'Series1',
                        type: 'scatter',
                        tooltip: {
                            trigger: 'item',
                            formatter: function (params) {
                                return params.seriesName + ' （'  + 'Category' + params.value[0] + '）<br/>'
                                + params.value[1] + ', ' 
                                + params.value[2]; 
                            }
                        },
                        symbolSize: function (value) {
                            return Math.round(value[2]/5);
                        },
                        data: (function () {
                            var d = [];
                            var len = 0;
                            var value;
                            while (len++ < 500) {
                                d.push([
                                    len,
                                    (Math.random()*30).toFixed(2) - 0,
                                    (Math.random()*100).toFixed(2) - 0
                                ]);
                            }
                            return d;
                        })()
                    },

                    {
                        name: 'Series2',
                        type: 'scatter',
                        tooltip: {
                            trigger: 'item',
                            formatter: function (params) {
                                return params.seriesName + ' （'  + 'Category' + params.value[0] + '）<br/>'
                                + params.value[1] + ', ' 
                                + params.value[2]; 
                            }
                        },
                        symbolSize: function (value) {
                            return Math.round(value[2]/5);
                        },
                        data: (function () {
                            var d = [];
                            var len = 0;
                            var value;
                            while (len++ < 500) {
                                d.push([
                                    len,
                                    (Math.random()*30).toFixed(2) - 0,
                                    (Math.random()*100).toFixed(2) - 0
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
            scatter_category_element && scatter_category.resize();
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
            _scatterCategoryLightExample();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    EchartsScatterCategoryLight.init();
});
