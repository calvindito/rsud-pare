/* ------------------------------------------------------------------------------
 *
 *  # Echarts - Multiple funnels with separation example
 *
 *  Demo JS code for multiple funnel charts with separation [light theme]
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var EchartsFunnelMultipleSeparateLight = function() {


    //
    // Setup module components
    //

    // Multiple funnel charts with separation
    var _funnelMultipleSeparateLightExample = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define element
        var funnel_multiple_separate_element = document.getElementById('funnel_multiple_separate');


        //
        // Charts configuration
        //

        if (funnel_multiple_separate_element) {

            // Initialize chart
            var funnel_multiple_separate = echarts.init(funnel_multiple_separate_element, null, { renderer: 'svg' });


            //
            // Chart config
            //

            // Options
            funnel_multiple_separate.setOption({

                // Colors
                color: [
                    '#2ec7c9','#b6a2de','#5ab1ef','#ffb980','#d87a80',
                    '#8d98b3','#e5cf0d','#97b552','#95706d','#dc69aa',
                    '#07a2a4','#9a7fd1','#588dd5','#f5994e','#c05050',
                    '#59678c','#c9ab00','#7eb00a','#6f5553','#c14089'
                ],

                // Global text styles
                textStyle: {
                    fontFamily: 'var(--body-font-family)',
                    color: 'var(--body-color)',
                    fontSize: 14,
                    lineHeight: 22,
                    textBorderColor: 'transparent'
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
                    data: ['Chrome','Opera','Safari','Firefox','IE','','Android','Windows','OS X','BlackBerry','Others'],
                    itemHeight: 8,
                    itemWidth: 8,
                    itemGap: 30,
                    textStyle: {
                        color: 'var(--body-color)'
                    }
                },

                // Add series
                series: [
                    {
                        name: 'Browser',
                        type: 'funnel',
                        left: '30%',
                        top: 0,
                        width: '50%',
                        height: '48%',
                        itemStyle: {
                            borderColor: 'var(--card-bg)',
                            label: {
                                position: 'left'
                            }
                        },
                        data: [
                            {value: 60, name: 'Safari'},
                            {value: 30, name: 'Firefox'},
                            {value: 10, name: 'IE'},
                            {value: 80, name: 'Opera'},
                            {value: 100, name: 'Chrome'}
                        ]
                    },
                    {
                        name: 'Operating system',
                        type: 'funnel',
                        left: '30%',
                        top: '52%',
                        width: '50%',
                        height: '48%',
                        sort: 'ascending',
                        itemStyle: {
                            borderColor: 'var(--card-bg)',
                            label: {
                                position: 'right'
                            }
                        },
                        data: [
                            {value: 60, name: 'Android'},
                            {value: 30, name: 'Windows'},
                            {value: 10, name: 'OS X'},
                            {value: 80, name: 'BlackBerry'},
                            {value: 100, name: 'Others'}
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
            funnel_multiple_separate_element && funnel_multiple_separate.resize();
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
            _funnelMultipleSeparateLightExample();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    EchartsFunnelMultipleSeparateLight.init();
});
