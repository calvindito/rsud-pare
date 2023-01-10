/* ------------------------------------------------------------------------------
 *
 *  # Echarts - area gradient example
 *
 *  Demo JS code for area chart with gradient [light theme]
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var EchartsAreaGradientLight = function() {


    //
    // Setup module components
    //

    // Basic bar chart
    var _areaGradientExample = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define element
        var area_gradient_blue_element = document.getElementById('area_gradient_blue');
        var area_gradient_orange_element = document.getElementById('area_gradient_orange');
        var area_gradient_green_element = document.getElementById('area_gradient_green');

        // HEX to RGBA conversion
        function hex2rgba_convert(hex, alpha) {
            if (!hex || [4, 7].indexOf(hex.length) === -1) {
                return;
            }

            hex = hex.substr(1);
            if (hex.length === 3) {
                hex = hex.split('').map(function (el) {
                    return el + el + '';
                }).join('');
            }

            var r = parseInt(hex.slice(0, 2), 16),
                g = parseInt(hex.slice(2, 4), 16),
                b = parseInt(hex.slice(4, 6), 16);

            if (alpha !== undefined) {
                return "rgba(" + r + ", " + g + ", " + b + ", " + alpha + ")";
            } else {
                return "rgb(" + r + ", " + g + ", " + b + ")";
            }
        }


        //
        // Chart configuration
        //

        // Area chart with gradient - blue
        if (area_gradient_blue_element) {

            // Initialize chart
            var area_gradient_blue = echarts.init(area_gradient_blue_element);


            //
            // Chart config
            //

            // Define variables
            var axisData = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                data = [30, 79, 50, 60, 10, 95, 40],
                color = '#0092f6',
                lineWidth = 1.5;

            // Options
            area_gradient_blue.setOption({

                // Global text styles
                textStyle: {
                    fontFamily: 'var(--body-font-family)',
                    color: 'var(--body-color)',
                    fontSize: 14,
                    lineHeight: 22,
                    textBorderColor: 'transparent'
                },

                // Setup grid
                grid: {
                    left: 20,
                    right: 20,
                    bottom: 20,
                    top: 10,
                    containLabel: true
                },

                // Add tooltip
                tooltip: {
                    trigger: 'axis',
                    className: 'shadow-sm rounded',
                    backgroundColor: 'var(--white)',
                    borderColor: 'var(--gray-400)',
                    padding: 15,
                    textStyle: {
                        color: 'var(--black)'
                    },
                    formatter: '{b} <br/> {c} {a}',
                    axisPointer: {
                        lineStyle: {
                            color: color,
                            type: 'dotted'
                        }
                    }
                },

                // Horizontal axis
                xAxis: {
                    type: "category",
                    boundaryGap: false,
                    data: axisData,
                    axisTick: {
                        show: false
                    },
                    axisLabel: {
                        show: false
                    },
                    axisLine: {
                        show: false
                    }
                },

                // Vertical axis
                yAxis: {
                    type: 'value',
                    max: function (value) {
                        return value.max;
                    },
                    min: function (value) {
                        return value.min;
                    },
                    axisTick: {
                        show: false
                    },
                    axisLabel: {
                        show: false
                    },
                    axisLine: {
                        show: false
                    },
                    splitLine: {
                        show: false
                    }
                },

                // Add series
                series: [{
                    name: 'total visitors',
                    type: 'line',
                    symbol: 'circle',
                    smooth: true,
                    showSymbol: false,
                    symbolSize: 3,
                    itemStyle: {
                        normal: {
                            color: color,
                            lineStyle: {
                                color: color,
                                width: lineWidth
                            },
                            areaStyle: {
                                color: {
                                    type: 'linear',
                                    x: 0,
                                    y: 0,
                                    x2: 0,
                                    y2: 1,
                                    colorStops: [{
                                        offset: 0,
                                        color: hex2rgba_convert(color, 0.25)
                                    }, {
                                        offset: 1,
                                        color: hex2rgba_convert(color, 0)
                                    }]
                                }
                            }
                        },
                        emphasis: {
                            borderColor: hex2rgba_convert(color, 0.25),
                            borderWidth: 10
                        }
                    },
                    data: data,
                    zlevel: 1
                }]
            });
        }

        // Area chart with gradient - orange
        if (area_gradient_orange_element) {

            // Initialize chart
            var area_gradient_orange = echarts.init(area_gradient_orange_element);


            //
            // Chart config
            //

            // Define variables
            var axisData = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                data = [10, 52, 20, 59, 20, 90, 35],
                color = '#ff7043',
                lineWidth = 1.5;

            // Options
            area_gradient_orange.setOption({

                // Global text styles
                textStyle: {
                    fontFamily: 'Roboto, Arial, Verdana, sans-serif',
                    fontSize: 14
                },

                // Setup grid
                grid: {
                    left: 20,
                    right: 20,
                    bottom: 20,
                    top: 10,
                    containLabel: true
                },

                // Add tooltip
                tooltip: {
                    trigger: 'axis',
                    padding: [10, 15],
                    formatter: '{b} <br/> {c} {a}',
                    axisPointer: {
                        lineStyle: {
                            color: color,
                            type: 'dotted'
                        }
                    }
                },

                // Horizontal axis
                xAxis: {
                    type: "category",
                    boundaryGap: false,
                    data: axisData,
                    axisTick: {
                        show: false
                    },
                    axisLabel: {
                        show: false
                    },
                    axisLine: {
                        show: false
                    }
                },

                // Vertical axis
                yAxis: {
                    type: 'value',
                    max: function (value) {
                        return value.max;
                    },
                    min: function (value) {
                        return value.min;
                    },
                    axisTick: {
                        show: false
                    },
                    axisLabel: {
                        show: false
                    },
                    axisLine: {
                        show: false
                    },
                    splitLine: {
                        show: false
                    }
                },

                // Add series
                series: [{
                    name: 'opportunities',
                    type: 'line',
                    symbol: 'circle',
                    smooth: true,
                    showSymbol: false,
                    symbolSize: 3,
                    itemStyle: {
                        normal: {
                            color: color,
                            lineStyle: {
                                color: color,
                                width: lineWidth
                            },
                            areaStyle: {
                                color: {
                                    type: 'linear',
                                    x: 0,
                                    y: 0,
                                    x2: 0,
                                    y2: 1,
                                    colorStops: [{
                                        offset: 0,
                                        color: hex2rgba_convert(color, 0.25)
                                    }, {
                                        offset: 1,
                                        color: hex2rgba_convert(color, 0)
                                    }]
                                }
                            }
                        },
                        emphasis: {
                            borderColor: hex2rgba_convert(color, 0.25),
                            borderWidth: 10
                        }
                    },
                    data: data,
                    zlevel: 2
                }]
            });
        }

        // Area chart with gradient - green
        if (area_gradient_green_element) {

            // Initialize chart
            var area_gradient_green = echarts.init(area_gradient_green_element);


            //
            // Chart config
            //

            // Define variables
            var axisData = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                data = [50, 36, 59, 20, 50, 35, 70],
                color = '#66bb6a',
                lineWidth = 1.5;

            // Options
            area_gradient_green.setOption({

                // Global text styles
                textStyle: {
                    fontFamily: 'Roboto, Arial, Verdana, sans-serif',
                    fontSize: 14
                },

                // Setup grid
                grid: {
                    left: 20,
                    right: 20,
                    bottom: 20,
                    top: 10,
                    containLabel: true
                },

                // Add tooltip
                tooltip: {
                    trigger: 'axis',
                    padding: [10, 15],
                    formatter: '{b} <br/> {c} {a}',
                    axisPointer: {
                        lineStyle: {
                            color: color,
                            type: 'dotted'
                        }
                    }
                },

                // Horizontal axis
                xAxis: {
                    type: "category",
                    boundaryGap: false,
                    data: axisData,
                    axisTick: {
                        show: false
                    },
                    axisLabel: {
                        show: false
                    },
                    axisLine: {
                        show: false
                    }
                },

                // Vertical axis
                yAxis: {
                    type: 'value',
                    max: function (value) {
                        return value.max;
                    },
                    min: function (value) {
                        return value.min;
                    },
                    axisTick: {
                        show: false
                    },
                    axisLabel: {
                        show: false
                    },
                    axisLine: {
                        show: false
                    },
                    splitLine: {
                        show: false
                    }
                },

                // Add series
                series: [{
                    name: 'new leads',
                    type: 'line',
                    symbol: 'circle',
                    smooth: true,
                    showSymbol: false,
                    symbolSize: 3,
                    itemStyle: {
                        normal: {
                            color: color,
                            lineStyle: {
                                color: color,
                                width: lineWidth
                            },
                            areaStyle: {
                                color: {
                                    type: 'linear',
                                    x: 0,
                                    y: 0,
                                    x2: 0,
                                    y2: 1,
                                    colorStops: [{
                                        offset: 0,
                                        color: hex2rgba_convert(color, 0.25)
                                    }, {
                                        offset: 1,
                                        color: hex2rgba_convert(color, 0)
                                    }]
                                }
                            }
                        },
                        emphasis: {
                            borderColor: hex2rgba_convert(color, 0.25),
                            borderWidth: 10
                        }
                    },
                    data: data,
                    zlevel: 3
                }]
            });
        }


        //
        // Resize charts
        //

        // Resize function
        var triggerChartResize = function() {
            area_gradient_blue_element && area_gradient_blue.resize();
            area_gradient_orange_element && area_gradient_orange.resize();
            area_gradient_green_element && area_gradient_green.resize();
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
            _areaGradientExample();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    EchartsAreaGradientLight.init();
});
