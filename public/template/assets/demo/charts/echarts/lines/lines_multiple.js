/* ------------------------------------------------------------------------------
 *
 *  # Echarts - Multiple lines example
 *
 *  Demo JS code for multiple line chart [light theme]
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var EchartsLinesMultipleLight = function() {


    //
    // Setup module components
    //

    // Line multiples
    var _linesMultipleLightExample = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define element
        var line_multiple_element = document.getElementById('line_multiple');


        //
        // Charts configuration
        //

        if (line_multiple_element) {

            // Initialize chart
            var line_multiple = echarts.init(line_multiple_element, null, { renderer: 'svg' });


            //
            // Chart config
            //

            // Options
            line_multiple.setOption({

                // Define colors
                color: ['#f17a52', '#03A9F4'],

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
                grid: [
                    {
                        left: 10,
                        right: 20,
                        top: 40,
                        height: 160,
                        containLabel: true
                    },
                    {
                        left: 10,
                        right: 20,
                        top: 280,
                        height: 160,
                        containLabel: true
                    }
                ],

                // Title
                title: [
                    {
                        left: 'center',
                        text: 'Limitless template sales',
                        top: 0,
                        textStyle: {
                            fontSize: 15,
                            fontWeight: 500,
                            color: 'var(--body-color)'
                        }
                    },
                    {
                        left: 'center',
                        text: 'Londinium template sales',
                        top: 240,
                        textStyle: {
                            fontSize: 15,
                            fontWeight: 500,
                            color: 'var(--body-color)'
                        }
                    }
                ],

                // Tooltip
                tooltip: {
                    trigger: 'axis',
                    className: 'shadow-sm rounded',
                    backgroundColor: 'var(--white)',
                    borderColor: 'var(--gray-400)',
                    padding: 15,
                    textStyle: {
                        color: '#000'
                    },
                    formatter: function (a) {
                        return (
                            a[0]['axisValueLabel'] +
                            "<div class='d-flex align-items-center'>" +
                                '<span class="rounded-pill p-1 me-2" style="background-color: ' + a[0]['color'] + '"></span>' +
                                a[0]['seriesName'] + ': ' + a[0]['value'] + ' sales' +
                            "</div>" +
                            "<div class='d-flex align-items-center'>" +
                                '<span class="rounded-pill p-1 me-2" style="background-color: ' + a[1]['color'] + '"></span>' +
                                a[1]['seriesName'] + ': ' + a[1]['value'] + ' sales' +
                            "</div>"
                        );
                    }
                },

                // Connect axis pointers
                axisPointer: {
                    link: {
                        xAxisIndex: 'all'
                    },
                    lineStyle: {
                        color: 'var(--gray-600)'
                    }
                },

                // Horizontal axis
                xAxis: [
                    {
                        type: 'category',
                        boundaryGap: false,
                        axisLine: {
                            onZero: true,
                            lineStyle: {
                                color: 'var(--gray-500)'
                            }
                        },
                        axisLabel: {
                            textStyle: {
                                color: 'rgba(var(--body-color-rgb), .65)'
                            }
                        },
                        splitLine: {
                            show: true,
                            lineStyle: {
                                color: 'var(--gray-300)',
                                width: 1,
                                type: 'dashed'
                            }
                        },
                        splitArea: {
                            show: true,
                            areaStyle: {
                                color: ['rgba(var(--white-rgb), .01)', 'rgba(var(--black-rgb), .01)']
                            }
                        },
                        data: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
                    },
                    {
                        gridIndex: 1,
                        type: 'category',
                        boundaryGap: false,
                        axisLine: {
                            onZero: true,
                            lineStyle: {
                                color: 'var(--gray-500)'
                            }
                        },
                        axisLabel: {
                            textStyle: {
                                color: 'rgba(var(--body-color-rgb), .65)'
                            }
                        },
                        splitLine: {
                            show: true,
                            lineStyle: {
                                color: 'var(--gray-300)',
                                width: 1,
                                type: 'dashed'
                            }
                        },
                        splitArea: {
                            show: true,
                            areaStyle: {
                                color: ['rgba(var(--white-rgb), .01)', 'rgba(var(--black-rgb), .01)']
                            }
                        },
                        data: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
                    }
                ],

                // Vertical axis
                yAxis: [
                    {
                        type: 'value',
                        axisLine: {
                            show: true,
                            onZero: true,
                            lineStyle: {
                                color: 'var(--gray-500)'
                            }
                        },
                        axisLabel: {
                            textStyle: {
                                color: 'rgba(var(--body-color-rgb), .65)'
                            }
                        },
                        splitLine: {
                            show: true,
                            lineStyle: {
                                color: 'var(--gray-300)',
                                width: 1,
                                type: 'dashed'
                            }
                        }
                    },
                    {
                        gridIndex: 1,
                        type: 'value',
                        axisLine: {
                            show: true,
                            onZero: true,
                            lineStyle: {
                                color: 'var(--gray-500)'
                            }
                        },
                        axisLabel: {
                            textStyle: {
                                color: 'rgba(var(--body-color-rgb), .65)'
                            }
                        },
                        splitLine: {
                            show: true,
                            lineStyle: {
                                color: 'var(--gray-300)',
                                width: 1,
                                type: 'dashed'
                            }
                        }
                    }
                ],

                // Add series
                series: [
                    {
                        name: 'Limitless',
                        type: 'line',
                        smooth: true,
                        symbol: 'circle',
                        symbolSize: 8,
                        data: [63,88,25,65,30,85,57,90,76,19,74,39],
                    },
                    {
                        name: 'Londinium',
                        type: 'line',
                        xAxisIndex: 1,
                        yAxisIndex: 1,
                        smooth: true,
                        symbol: 'circle',
                        symbolSize: 8,
                        data: [60,30,49,72,49,82,90,29,48,20,49,39],
                    }
                ]
            });
        }


        //
        // Resize charts
        //

        // Resize function
        var triggerChartResize = function() {
            line_multiple_element && line_multiple.resize();
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
            _linesMultipleLightExample();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    EchartsLinesMultipleLight.init();
});
