/* ------------------------------------------------------------------------------
 *
 *  # Echarts - line with label mark lines example
 *
 *  Demo JS code for line chart with label marks [light theme]
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var EchartsLineLabelMarksLight = function() {


    //
    // Setup module components
    //

    // Basic bar chart
    var _lineLabelMarksExample = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define element
        var line_label_marks_element = document.getElementById('line_label_marks');

        // Chart configuration
        if (line_label_marks_element) {

            // Initialize chart
            var line_label_marks = echarts.init(line_label_marks_element, null, { renderer: 'svg' });

            //
            // Chart config
            //
            var data_val = [2220, 1682, 2791, 3000, 4090, 3230, 2910],
                xAxis_val = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                color = '#66bb6a',
                axisLabelColor = 'rgba(var(--body-color-rgb), .65)',
                axisLineColor = 'var(--gray-500)',
                axisSplitLineColor = 'var(--gray-300)',
                markLineWidth = 1,
                markLineOpacity = 0.25,
                labelFontSize = 12,
                labelColor = 'var(--body-color)',
                labelFontWeight = 500;


            // Options
            line_label_marks.setOption({

                // Global text styles
                textStyle: {
                    fontFamily: 'var(--body-font-family)',
                    color: 'var(--body-color)',
                    fontSize: 14,
                    lineHeight: 22,
                    textBorderColor: 'transparent'
                },

                // Grid
                grid: {
                    left: 20,
                    right: 20,
                    bottom: 0,
                    top: 0,
                    containLabel: true
                },

                // Horizontal axis
                xAxis: {
                    data: xAxis_val,
                    boundaryGap: false,
                    axisLabel: {
                        textStyle: {
                            color: axisLabelColor
                        }
                    },
                    axisTick: {
                        show: false
                    },
                    axisLine: {
                        lineStyle: {
                            color: axisLineColor
                        }
                    },
                    splitLine: {
                        show: false
                    }
                },

                // Vertical axis
                yAxis: {
                    axisLabel: {
                        show: false,
                        textStyle: {
                            color: axisLabelColor
                        }
                    },
                    axisLine: {
                        show: false
                    },
                    axisTick: {
                        show: false
                    },
                    splitLine: {
                        show: true,
                        lineStyle: {
                            color: axisSplitLineColor,
                            type: 'dashed'
                        }
                    }
                },

                // Series
                series: [
                    {
                        type: 'bar',
                        name: 'linedemo',
                        barWidth: markLineWidth,
                        hoverAnimation: false,
                        data: data_val,
                        itemStyle: {
                            normal: {
                                color: color,
                                opacity: markLineOpacity,
                                label: {
                                    show: false
                                }
                            }
                        }
                    },
                    {
                        type: 'line',
                        name: 'linedemo',
                        smooth: true,
                        symbolSize: 8,
                        hoverAnimation: false,
                        silent: true,
                        data: data_val,
                        symbol: 'circle',
                        itemStyle: {
                            normal: {
                                color: color,
                                label: {
                                    show: true,
                                    position: 'top',
                                    verticalAlign: 'bottom',
                                    textStyle: {
                                        color: color,
                                        fontSize: labelFontSize,
                                        fontWeight: labelFontWeight,
                                        color: labelColor
                                    }
                                }
                            }
                        },
                        areaStyle: {
                            normal: {
                                color: color,
                                opacity: 0.05
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
            line_label_marks_element && line_label_marks.resize();
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
            _lineLabelMarksExample();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    EchartsLineLabelMarksLight.init();
});
