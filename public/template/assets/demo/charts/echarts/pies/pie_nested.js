/* ------------------------------------------------------------------------------
 *
 *  # Echarts - Nested pie example
 *
 *  Demo JS code for nexted pie chart [light theme]
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var EchartsPieNestedLight = function() {


    //
    // Setup module components
    //

    // Nested pie chart
    var _scatterPieNestedLightExample = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define element
        var pie_nested_element = document.getElementById('pie_nested');


        //
        // Charts configuration
        //

        if (pie_nested_element) {

            // Initialize chart
            var pie_nested = echarts.init(pie_nested_element, null, { renderer: 'svg' });


            //
            // Chart config
            //

            // Options
            pie_nested.setOption({

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
                    formatter: '{a} <br/>{b}: {c} ({d}%)'
                },

                // Add legend
                legend: {
                    orient: 'vertical',
                    top: 'center',
                    left: 0,
                    data: ['Italy','Spain','Austria','Germany','Poland','Denmark','Hungary','Portugal','France','Netherlands'],
                    itemHeight: 8,
                    itemWidth: 8,
                    textStyle: {
                        color: 'var(--body-color)'
                    },
                    itemStyle: {
                        borderColor: 'transparent'
                    }
                },

                // Add series
                series: [

                    // Inner
                    {
                        name: 'Countries',
                        type: 'pie',
                        selectedMode: 'single',
                        radius: [0, '50%'],
                        itemStyle: {
                            borderColor: 'var(--card-bg)'
                        },
                        label: {
                            position: 'inner'
                        },
                        data: [
                            {value: 535, name: 'Italy'},
                            {value: 679, name: 'Spain'},
                            {value: 1548, name: 'Austria'}
                        ]
                    },

                    // Outer
                    {
                        name: 'Countries',
                        type: 'pie',
                        radius: ['60%', '85%'],
                        itemStyle: {
                            borderColor: 'var(--card-bg)'
                        },
                        label: {
                            color: 'var(--body-color)'
                        },
                        data: [
                            {value: 535, name: 'Italy'},
                            {value: 310, name: 'Germany'},
                            {value: 234, name: 'Poland'},
                            {value: 135, name: 'Denmark'},
                            {value: 948, name: 'Hungary'},
                            {value: 251, name: 'Portugal'},
                            {value: 147, name: 'France'},
                            {value: 202, name: 'Netherlands'}
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
            pie_nested_element && pie_nested.resize();
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
            _scatterPieNestedLightExample();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    EchartsPieNestedLight.init();
});
