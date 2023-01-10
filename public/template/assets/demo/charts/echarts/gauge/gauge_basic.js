/* ------------------------------------------------------------------------------
 *
 *  # Echarts - Basic gauge example
 *
 *  Demo JS code for baic gauge chart [light theme]
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var EchartsGaugeBasicLight = function() {


    //
    // Setup module components
    //

    // Basic gauge chart
    var _gaugeBasicLightExample = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define element
        var gauge_basic_element = document.getElementById('gauge_basic');


        //
        // Charts configuration
        //

        if (gauge_basic_element) {

            // Initialize chart
            var gauge_basic = echarts.init(gauge_basic_element, null, { renderer: 'svg' });


            //
            // Chart config
            //

            // Options
            var gauge_basic_options = {

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
                    text: 'Server resources usage',
                    subtext: 'Random demo data',
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

                // Add series
                series: [
                    {
                        name: 'Memory usage',
                        type: 'gauge',
                        center: ['50%', '62%'],
                        radius: '90%',
                        detail: {formatter:'{value}%'},
                        itemStyle: {
                            color: 'var(--body-color)'
                        },
                        axisLine: {
                            lineStyle: {
                                color: [[0.2, '#2ec7c9'], [0.8, '#5ab1ef'], [1, '#d87a80']], 
                            }
                        },
                        axisTick: {
                            splitNumber: 10,
                            lineStyle: {
                                color: 'var(--gray-500)'
                            }
                        },
                        axisLabel: {
                            color: 'var(--body-color)'
                        },
                        splitLine: {
                            lineStyle: {
                                color: 'var(--gray-600)'
                            }
                        },
                        title: {
                            offsetCenter: [0, '60%'],
                            textStyle: {
                                color: 'var(--body-color)',
                                fontSize: 14
                            }
                        },
                        detail: {
                            offsetCenter: [0, '45%'],
                            formatter: '{value}%',
                            textStyle: {
                                fontSize: 24,
                                color: 'var(--body-color)',
                                fontWeight: 500
                            }
                        },
                        data: [{value: 50, name: 'Memory usage'}]
                    }
                ]
            };

            gauge_basic.setOption(gauge_basic_options);

            // Add random data
            clearInterval(timeTicket);
            var timeTicket = setInterval(function () {
                gauge_basic_options.series[0].data[0].value = (Math.random()*100).toFixed(2) - 0;
                gauge_basic.setOption(gauge_basic_options, true);
            }, 2000);
        }


        //
        // Resize charts
        //

        // Resize function
        var triggerChartResize = function() {
            gauge_basic_element && gauge_basic.resize();
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
            _gaugeBasicLightExample();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    EchartsGaugeBasicLight.init();
});
