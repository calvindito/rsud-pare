/* ------------------------------------------------------------------------------
 *
 *  # Echarts - Custom gauge example
 *
 *  Demo JS code for custom gauge chart [light theme]
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var EchartsGaugeCustomLight = function() {


    //
    // Setup module components
    //

    // Custom gauge chart
    var _gaugeCustomLightExample = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define element
        var gauge_custom_element = document.getElementById('gauge_custom');


        //
        // Charts configuration
        //

        if (gauge_custom_element) {

            // Initialize chart
            var gauge_custom = echarts.init(gauge_custom_element, null, { renderer: 'svg' });


            //
            // Chart config
            //

            // Options
            var gauge_custom_options = {

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
                    formatter: '{a} <br/>{b} : {c}%'
                },

                // Add series
                series: [
                    {
                        name: 'Memory usage',
                        type: 'gauge',
                        center: ['50%', '57.5%'],
                        radius: '80%',
                        startAngle: 150,
                        endAngle: -150,
                        itemStyle: {
                            color: 'var(--body-color)'
                        },
                        axisLine: {
                            lineStyle: {
                                color: [[0.2, 'lightgreen'], [0.4, 'orange'], [0.8, 'skyblue'], [1, '#ff4500']], 
                                width: 20
                            }
                        },
                        axisTick: {
                            splitNumber: 10,
                            lineStyle: {
                                color: 'var(--gray-500)'
                            }
                        },
                        axisLabel: {
                            formatter: function(v) {
                                switch (v+''){
                                    case '10': return 'Idle';
                                    case '30': return 'Low';
                                    case '60': return 'Normal';
                                    case '90': return 'High';
                                    default: return '';
                                }
                            },
                            color: 'var(--body-color)',
                            distance: 35
                        },
                        splitLine: {
                            lineStyle: {
                                color: 'var(--gray-600)'
                            }
                        },
                        pointer: {
                            width: 5
                        },
                        title: {
                            offsetCenter: ['-81%', -20],
                            textStyle: {
                                color: 'var(--body-color)',
                                fontSize: 14
                            }
                        },
                        detail: {
                            offsetCenter: ['-80%', 10],
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

            gauge_custom.setOption(gauge_custom_options);

            // Add random data
            clearInterval(timeTicket2);
            var timeTicket2 = setInterval(function () {
                gauge_custom_options.series[0].data[0].value = (Math.random()*100).toFixed(2) - 0;
                gauge_custom.setOption(gauge_custom_options, true);
            }, 2000);
        }


        //
        // Resize charts
        //

        // Resize function
        var triggerChartResize = function() {
            gauge_custom_element && gauge_custom.resize();
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
            _gaugeCustomLightExample();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    EchartsGaugeCustomLight.init();
});
