/* ------------------------------------------------------------------------------
 *
 *  # Echarts - Clustered columns example
 *
 *  Demo JS code for clustered column chart [light theme]
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var EchartsColumnsStackedClusteredLight = function() {


    //
    // Setup module components
    //

    // Clustered column chart
    var _columnsStackedClusteredLightExample = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define element
        var columns_clustered_element = document.getElementById('columns_clustered');


        //
        // Charts configuration
        //

        if (columns_clustered_element) {

            // Initialize chart
            var columns_clustered = echarts.init(columns_clustered_element, null, { renderer: 'svg' });


            //
            // Chart config
            //

            // Options
            columns_clustered.setOption({

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
                    left: 10,
                    right: 5,
                    top: 50,
                    bottom: 0,
                    containLabel: true
                },

                // Add legend
                legend: {
                    type: 'scroll',
                    pageIconColor: 'var(--body-color)',
                    pageTextStyle: {
                        color: 'var(--body-color)'
                    },
                    data: [
                        'Version 1.7 - 2k data','Version 1.7 - 2w data','Version 1.7 - 20w data',
                        'Version 2.0 - 2k data','Version 2.0 - 2w data','Version 2.0 - 20w data'
                    ],
                    itemHeight: 2,
                    itemGap: 30,
                    textStyle: {
                        color: 'var(--body-color)',
                        padding: [0, 10]
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
                xAxis: [
                    {
                        type: 'category',
                        data: ['Line','Bar','Scatter','Pies','Map'],
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
                    },
                    {
                        type: 'category',
                        axisLine: {show:false},
                        axisTick: {show:false},
                        axisLabel: {show:false},
                        splitArea: {show:false},
                        splitLine: {show:false},
                        data: ['Line','Bar','Scatter','Pies','Map']
                    }
                ],

                // Vertical axis
                yAxis: [{
                    type: 'value',
                    axisLabel: {
                        color: 'rgba(var(--body-color-rgb), .65)',
                        formatter: '{value} ms'
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

                // Add series
                series: [
                    {
                        name: 'Version 2.0 - 2k data',
                        type: 'bar',
                        z: 2,
                        itemStyle: {
                            normal: {
                                color: '#F44336',
                                label: {
                                    show: true,
                                    padding: 5,
                                    position: 'top',
                                    color: '#000',
                                    fontWeight: 500,
                                    fontSize: 12
                                }
                            }
                        },
                        data: [247, 187, 95, 175, 270]
                    },
                    {
                        name: 'Version 2.0 - 2w data',
                        type: 'bar',
                        z: 2,
                        itemStyle: {
                            normal: {
                                color: '#4CAF50',
                                label: {
                                    show: true,
                                    padding: 5,
                                    position: 'top',
                                    color: '#000',
                                    fontWeight: 500,
                                    fontSize: 12
                                }
                            }
                        },
                        data: [488, 415, 405, 340, 328]
                    },
                    {
                        name: 'Version 2.0 - 20w data',
                        type: 'bar',
                        z: 2,
                        itemStyle: {
                            normal: {
                                color: '#2196F3',
                                label: {
                                    show: true,
                                    padding: 5,
                                    position: 'top',
                                    color: '#000',
                                    fontWeight: 500,
                                    fontSize: 12
                                }
                            }
                        },
                        data: [906, 911, 908, 778, 550]
                    },
                    {
                        name: 'Version 1.7 - 2k data',
                        type: 'bar',
                        z: 1,
                        xAxisIndex: 1,
                        itemStyle: {
                            normal: {
                                color: '#E57373',
                                barBorderRadius: [4, 4, 0, 0],
                                label: {
                                    show: true,
                                    padding: 5,
                                    position: 'top',
                                    color: 'var(--body-color)',
                                    fontSize: 12,
                                    fontWeight: 500
                                }
                            }
                        },
                        data: [680, 819, 564, 724, 890]
                    },
                    {
                        name: 'Version 1.7 - 2w data',
                        type: 'bar',
                        z: 1,
                        xAxisIndex: 1,
                        itemStyle: {
                            normal: {
                                color: '#81C784',
                                barBorderRadius: [4, 4, 0, 0],
                                label: {
                                    show: true,
                                    padding: 5,
                                    position: 'top',
                                    color: 'var(--body-color)',
                                    fontSize: 12,
                                    fontWeight: 500
                                }
                            }
                        },
                        data: [1212, 2035, 1620, 955, 1300]
                    },
                    {
                        name: 'Version 1.7 - 20w data',
                        type: 'bar',
                        z: 1,
                        xAxisIndex: 1,
                        itemStyle: {
                            normal: {
                                color: '#64B5F6',
                                barBorderRadius: [4, 4, 0, 0],
                                label: {
                                    show: true,
                                    padding: 5,
                                    position: 'top',
                                    color: 'var(--body-color)',
                                    fontSize: 12,
                                    fontWeight: 500
                                }
                            }
                        },
                        data: [2200, 3000, 2500, 3000, 2000]
                    }
                ]
            });
        }


        //
        // Resize charts
        //

        // Resize function
        var triggerChartResize = function() {
            columns_clustered_element && columns_clustered.resize();
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
            _columnsStackedClusteredLightExample();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    EchartsColumnsStackedClusteredLight.init();
});
