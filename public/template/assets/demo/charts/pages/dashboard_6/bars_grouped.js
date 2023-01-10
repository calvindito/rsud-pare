/* ------------------------------------------------------------------------------
 *
 *  # Echarts - grouped bars example
 *
 *  Demo JS code for grouped bar chart [light theme]
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var EchartsBarsGroupedLight = function() {


    //
    // Setup module components
    //

    // Basic bar chart
    var _barsGroupedExample = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define element
        var bars_grouped_element = document.getElementById('bars_grouped');

        // Chart configuration
        if (bars_grouped_element) {

            // Initialize chart
            var bars_grouped = echarts.init(bars_grouped_element, null, { renderer: 'svg' });


            //
            // Chart config
            //

            // Styles
            var legendFontSize = 12,
                legendColor = 'var(--body-color)',
                tooltipShadowColor = 'rgba(var(--body-color-rgb), 0.025)',
                tooltipBackgroundColor = 'var(--white)',
                tooltipBorderColor = 'var(--gray-400)',
                tooltipTextColor = 'var(--black)',
                axisLabelColor = 'rgba(var(--body-color-rgb), .65)',
                axisLineColor = 'var(--gray-500)',
                axisSplitLineColor = 'var(--gray-300)',
                barColor1 = '#1990FF',
                barColor2 = '#65bc6a';

            // Options
            bars_grouped.setOption({

                // Global text styles
                textStyle: {
                    fontFamily: 'var(--body-font-family)',
                    color: 'var(--body-color)',
                    fontSize: 14,
                    lineHeight: 22,
                    textBorderColor: 'transparent'
                },

                // Tooltip
                tooltip: {
                    trigger: 'axis',
                    formatter: 'Sales in {b}<br />{a0}: {c0}<br />{a1}: {c1}',
                    className: 'shadow-sm rounded',
                    backgroundColor: tooltipBackgroundColor,
                    borderColor: tooltipBorderColor,
                    padding: 15,
                    textStyle: {
                        color: tooltipTextColor
                    },
                    axisPointer: {
                        type: 'shadow',
                        shadowStyle: {
                            color: tooltipShadowColor
                        },
                        z: -1
                    }
                },

                // Grid
                grid: {
                    left: 10,
                    right: 10,
                    bottom: 0,
                    top: 0,
                    containLabel: true
                },

                // Legend
                legend: {
                    show: false,
                    left: 'center',
                    icon: 'circle',
                    bottom: '0',
                    itemGap: 16,
                    itemHeight: 10,
                    data: [
                        {
                            name:'Forecasted'
                        },
                        {
                            name:'Actual'
                        }
                    ],
                    textStyle: {
                        color: legendColor,
                        legendFontSize: legendFontSize
                    }
                },

                // Horizontal axis
                xAxis: {
                    type: 'category',
                    data: ['Jan', 'Feb', 'Mar','Apr','May','Jun','Jul','Aug','Sep', 'Oct', 'Nov','Dec'],
                    axisLabel: {
                        textStyle: {
                            color: axisLabelColor
                        }
                    },
                    axisTick:{
                        show: false
                    },
                    axisLine:{
                        lineStyle:{
                            color: axisLineColor
                        }
                    },
                    splitLine: {
                        show: false
                    }
                },

                // Vertical axis
                yAxis: {
                    type: 'value',
                    axisLabel: {
                        show: false,
                        textStyle: {
                            color: axisLabelColor
                        }
                    },
                    axisLine:{
                        show: false
                    },
                    axisTick:{
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
                        name: 'Forecasted',
                        type: 'bar',
                        data: [25, 30, 35, 55, 62, 78, 65, 55, 60, 45, 42, 15],
                        barWidth: 10,
                        barGap: '10%',
                        itemStyle: {
                            normal: {
                                show: true,
                                color: barColor1,
                                barBorderRadius: [20,20,0,0]
                            },
                            emphasis: {
                                color: barColor1
                            }
                        }
                    },
                    {
                        name: 'Actual',
                        type: 'bar',
                        data: [30, 45, 55, 60, 62, 72, 80, 62, 60, 55, 45, 30],
                        barWidth: 10,
                        barGap: '10%',
                        itemStyle: {
                            normal: {
                                show: true,
                                color: barColor2,
                                 barBorderRadius: [20, 20, 0, 0]
                            },
                            emphasis: {
                                color: barColor2
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
            bars_grouped_element && bars_grouped.resize();
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
            _barsGroupedExample();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    EchartsBarsGroupedLight.init();
});
