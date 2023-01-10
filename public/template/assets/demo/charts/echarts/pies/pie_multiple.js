/* ------------------------------------------------------------------------------
 *
 *  # Echarts - Pie multiple example
 *
 *  Demo JS code for multiple pie charts [light theme]
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var EchartsPieMultipleLight = function() {


    //
    // Setup module components
    //

    // Multiple pie charts
    var _pieMultipleLightExample = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define element
        var pie_multiples_element = document.getElementById('pie_multiples');


        //
        // Charts configuration
        //

        if (pie_multiples_element) {

            // Initialize chart
            var pie_multiples = echarts.init(pie_multiples_element, null, { renderer: 'svg' });


            //
            // Chart config
            //

            // Options
            pie_multiples.setOption({

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

                // Add title
                title: {
                    text: 'The Application World',
                    subtext: 'from global web index',
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

                // Add legend
                legend: {
                    bottom: 0,
                    left: 'center',
                    itemHeight: 8,
                    itemWidth: 8,
                    itemGap: 30,
                    selectedMode: false,
                    textStyle: {
                        color: 'var(--body-color)'
                    },
                    itemStyle: {
                        borderColor: 'transparent'
                    }
                },

                // Configure dataset
                dataset: {
                    source: [
                        ['product', '2012', '2013', '2014', '2015', '2016', '2017'],
                        ['Milk Tea', 86.5, 92.1, 85.7, 83.1, 73.4, 55.1],
                        ['Matcha Latte', 41.1, 30.4, 65.1, 53.3, 83.8, 98.7],
                        ['Cheese Cocoa', 24.1, 67.2, 79.5, 86.4, 65.2, 82.5],
                        ['Walnut Brownie', 55.2, 67.1, 69.2, 72.4, 53.9, 39.1]
                    ]
                },
                // Add series
                series: [
                    {
                        type: 'pie',
                        radius: '30%',
                        center: ['35%', '30%'],
                        itemStyle: {
                            borderColor: 'var(--card-bg)'
                        },
                        label: {
                            color: 'var(--body-color)'
                        },
                      // No encode specified, by default, it is '2012'.
                    },
                    {
                        type: 'pie',
                        radius: '30%',
                        center: ['65%', '30%'],
                        itemStyle: {
                            borderColor: 'var(--card-bg)'
                        },
                        label: {
                            color: 'var(--body-color)'
                        },
                        encode: {
                            itemName: 'product',
                            value: '2013'
                        }
                    },
                    {
                        type: 'pie',
                        radius: '30%',
                        center: ['25%', '75%'],
                        itemStyle: {
                            borderColor: 'var(--card-bg)'
                        },
                        label: {
                            color: 'var(--body-color)'
                        },
                        encode: {
                            itemName: 'product',
                            value: '2014'
                        }
                    },
                    {
                        type: 'pie',
                        radius: '30%',
                        center: ['50%', '75%'],
                        itemStyle: {
                            borderColor: 'var(--card-bg)'
                        },
                        label: {
                            color: 'var(--body-color)'
                        },
                        encode: {
                            itemName: 'product',
                            value: '2015'
                        }
                    },
                    {
                        type: 'pie',
                        radius: '30%',
                        center: ['75%', '75%'],
                        itemStyle: {
                            borderColor: 'var(--card-bg)'
                        },
                        label: {
                            color: 'var(--body-color)'
                        },
                        encode: {
                            itemName: 'product',
                            value: '2016'
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
            pie_multiples_element && pie_multiples.resize();
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
            _pieMultipleLightExample();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    EchartsPieMultipleLight.init();
});
