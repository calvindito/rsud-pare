/* ------------------------------------------------------------------------------
 *
 *  # Echarts - Single calendar example
 *
 *  Demo JS code for single calendar chart [light theme]
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var EchartsCalendarSingleLight = function() {


    //
    // Setup module components
    //

    // Single calendar chart
    var _calendarSingleLightExample = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define element
        var calendar_single_element = document.getElementById('calendar_single');


        //
        // Charts configuration
        //

        if (calendar_single_element) {

            // Initialize chart
            var calendar_single = echarts.init(calendar_single_element, null, { renderer: 'svg' });


            //
            // Chart config
            //

            // Demo data
            function getVirtulData(year) {
                year = year || '2017';
                var date = +echarts.number.parseDate(year + '-01-01');
                var end = +echarts.number.parseDate((+year + 1) + '-01-01');
                var dayTime = 3600 * 24 * 1000;
                var data = [];
                for (var time = date; time < end; time += dayTime) {
                    data.push([
                        echarts.format.formatTime('yyyy-MM-dd', time),
                        Math.floor(Math.random() * 10000)
                    ]);
                }
                return data;
            }

            // Options
            calendar_single.setOption({

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
                    text: 'Github commits',
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
                    }
                },

                // Add legend
                legend: {
                    orient: 'vertical',
                    top: 'center',
                    left: 0,
                    data: ['IE', 'Opera', 'Safari', 'Firefox', 'Chrome'],
                    itemHeight: 8,
                    itemWidth: 8,
                    textStyle: {
                        color: 'var(--body-color)'
                    }
                },

                // Visual map
                visualMap: {
                    min: 0,
                    max: 10000,
                    type: 'piecewise',
                    orient: 'horizontal',
                    left: 'center',
                    bottom: 0,
                    itemGap: 30,
                    textStyle: {
                        fontSize: 12,
                        color: 'var(--body-color)'
                    }
                },

                // Calendar
                calendar: {
                    top: 80,
                    left: 30,
                    right: 5,
                    cellSize: ['auto', 25],
                    range: '2016',
                    itemStyle: {
                        borderColor: 'var(--card-bg)',
                    },
                    splitLine: {
                        lineStyle: {
                            color: 'var(--dark)',
                            width: 3
                        }
                    },
                    dayLabel: {
                        color: 'var(--body-color)'
                    },
                    monthLabel: {
                        color: 'var(--body-color)'
                    },
                    yearLabel: {show: false}
                },

                // Add series
                series: [{
                    type: 'heatmap',
                    coordinateSystem: 'calendar',
                    data: getVirtulData(2016)
                }]
            });
        }


        //
        // Resize charts
        //

        // Resize function
        var triggerChartResize = function() {
            calendar_single_element && calendar_single.resize();
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
            _calendarSingleLightExample();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    EchartsCalendarSingleLight.init();
});
