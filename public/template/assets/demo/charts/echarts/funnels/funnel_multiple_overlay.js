/* ------------------------------------------------------------------------------
 *
 *  # Echarts - Multiple funnels with overlay example
 *
 *  Demo JS code for multiple funnel charts with overlay [light theme]
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var EchartsFunnelMultipleOverlayLight = function() {


    //
    // Setup module components
    //

    // Multiple funnel charts with overlay
    var _funnelMultipleOverlayLightExample = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define element
        var funnel_multiple_overlay_element = document.getElementById('funnel_multiple_overlay');


        //
        // Charts configuration
        //

        if (funnel_multiple_overlay_element) {

            // Initialize chart
            var funnel_multiple_overlay = echarts.init(funnel_multiple_overlay_element, null, { renderer: 'svg' });


            //
            // Chart config
            //

            // Options
            funnel_multiple_overlay.setOption({

                // Colors
                color: [
                    'rgba(255, 69, 0, 0.5)',
                    'rgba(255, 150, 0, 0.5)',
                    'rgba(255, 200, 0, 0.5)',
                    'rgba(155, 200, 50, 0.5)',
                    'rgba(55, 200, 100, 0.5)'
                ],

                // Global text styles
                textStyle: {
                    fontFamily: 'var(--body-font-family)',
                    color: 'var(--body-color)',
                    fontSize: 14,
                    lineHeight: 22,
                    textBorderColor: 'transparent'
                },

                // Add title
                title: {
                    text: 'Browser popularity',
                    subtext: 'Open source information',
                    left: 'center',
                    textStyle: {
                        fontSize: 18,
                        fontWeight: 500,
                        color: 'var(--body-color)'
                    },
                    subtextStyle: {
                        fontSize: 12,
                        color: 'rgba(var(--body-color-rgb), 0.5)'
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
                    formatter: '{a} <br/>{b}: {c}%'
                },

                // Add legend
                legend: {
                    orient: 'vertical',
                    top: 'center',
                    left: 0,
                    data: ['Chrome','Opera','Safari','Firefox','IE'],
                    itemHeight: 8,
                    itemWidth: 8,
                    textStyle: {
                        color: 'var(--body-color)'
                    }
                },

                // Add series
                series: [
                    {
                        name: 'Expected',
                        type: 'funnel',
                        left: '25%',
                        right: '25%',
                        top: '16%',
                        height: '84%',
                        width: '50%',
                        itemStyle: {
                            normal: {
                                borderColor: 'var(--card-bg)',
                                label: {
                                    formatter: '{b}'
                                },
                                labelLine: {
                                    show: false
                                }
                            },
                            emphasis: {
                                label: {
                                    position: 'inside',
                                    formatter: '{b}: {c}%'
                                }
                            }
                        },
                        data: [
                            {value: 45, name: 'IE'},
                            {value: 60, name: 'Firefox'},
                            {value: 70, name: 'Safari'},
                            {value: 80, name: 'Opera'},
                            {value: 100, name: 'Chrome'}
                        ]
                    },
                    {
                        name: 'Result',
                        type: 'funnel',
                        left: '25%',
                        right: '25%',
                        top: '16%',
                        height: '84%',
                        width: '50%',
                        maxSize: '80%',
                        itemStyle: {
                            normal: {
                                borderColor: 'var(--card-bg)',
                                label: {
                                    position: 'inside',
                                    formatter: '{c}%'
                                }
                            },
                            emphasis: {
                                label: {
                                    position: 'inside',
                                    formatter: '{b}: {c}%'
                                }
                            }
                        },
                        data: [
                            {value: 30, name: 'IE'},
                            {value: 48, name: 'Firefox'},
                            {value: 66, name: 'Safari'},
                            {value: 69, name: 'Opera'},
                            {value: 80, name: 'Chrome'}
                        ]
                    }
                ]
            });
        }


        //
        // Resize charts
        //

        // Resize function
        var triggerChartResize = function() {
            funnel_multiple_overlay_element && funnel_multiple_overlay.resize();
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
            _funnelMultipleOverlayLightExample();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    EchartsFunnelMultipleOverlayLight.init();
});
