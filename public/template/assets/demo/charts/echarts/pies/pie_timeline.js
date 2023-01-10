/* ------------------------------------------------------------------------------
 *
 *  # Echarts - Pie with timeline example
 *
 *  Demo JS code for pie chart with timeline [light theme]
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var EchartsPieTimelineLight = function() {


    //
    // Setup module components
    //

    // Pie chart with timeline
    var _pieTimelineLightExample = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define element
        var pie_timeline_element = document.getElementById('pie_timeline');


        //
        // Charts configuration
        //

        if (pie_timeline_element) {

            // Initialize chart
            var pie_timeline = echarts.init(pie_timeline_element, null, { renderer: 'svg' });


            //
            // Chart config
            //

            var idx = 1;

            // Options
            pie_timeline.setOption({

                // Add timeline
                timeline: {
                    axisType: 'category',
                    left: 0,
                    right: 0,
                    bottom: 0,
                    label: {
                        fontSize: 12                            
                    },
                    lineStyle: {
                        color: 'var(--gray-200)'
                    },
                    checkpointStyle: {
                        color: 'var(--primary)',
                        borderColor: 'var(--primary)'
                    },
                    progress: {
                        label: {
                            fontSize: 12
                        },
                        lineStyle: {
                            color: 'var(--primary)'
                        }
                    },
                    data: [
                        '2014-01-01', '2014-02-01', '2014-03-01', '2014-04-01', '2014-05-01',
                        { name:'2014-06-01', symbol: 'emptyStar2', symbolSize: 8 },
                        '2014-07-01', '2014-08-01', '2014-09-01', '2014-10-01', '2014-11-01',
                        { name:'2014-12-01', symbol: 'star2', symbolSize: 8 }
                    ],
                    autoPlay: true,
                    playInterval: 3000
                },

                options: [
                    {

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
                            text: 'Browser statistics',
                            subtext: 'Based on shared research',
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
                            formatter: '{a} <br/>{b}: {c} ({d}%)'
                        },

                        // Add legend
                        legend: {
                            orient: 'vertical',
                            top: 'center',
                            left: 0,
                            data: ['Chrome','Firefox','Safari','IE9+','IE8-'],
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
                        series: [{
                            name: 'Browser',
                            type: 'pie',
                            center: ['50%', '50%'],
                            radius: '60%',
                            itemStyle: {
                                borderColor: 'var(--card-bg)'
                            },
                            label: {
                                color: 'var(--body-color)'
                            },
                            data: [
                                {value: idx * 128 + 80, name: 'Chrome'},
                                {value: idx * 64 + 160, name: 'Firefox'},
                                {value: idx * 32 + 320, name: 'Safari'},
                                {value: idx * 16 + 640, name: 'IE9+'},
                                {value: idx++ * 8 + 1280, name: 'IE8-'}
                            ]
                        }]
                    },

                    {
                        series: [{
                            name: 'Browser',
                            type: 'pie',
                            data: [
                                {value: idx * 128 + 80,  name:'Chrome'},
                                {value: idx * 64  + 160,  name:'Firefox'},
                                {value: idx * 32  + 320,  name:'Safari'},
                                {value: idx * 16  + 640,  name:'IE9+'},
                                {value: idx++ * 8  + 1280, name:'IE8-'}
                            ]
                        }]
                    },
                    {
                        series: [{
                            name: 'Browser',
                            type: 'pie',
                            data: [
                                {value: idx * 128 + 80,  name:'Chrome'},
                                {value: idx * 64  + 160,  name:'Firefox'},
                                {value: idx * 32  + 320,  name:'Safari'},
                                {value: idx * 16  + 640,  name:'IE9+'},
                                {value: idx++ * 8  + 1280, name:'IE8-'}
                            ]
                        }]
                    },
                    {
                        series: [{
                            name: 'Browser',
                            type: 'pie',
                            data: [
                                {value: idx * 128 + 80,  name:'Chrome'},
                                {value: idx * 64  + 160,  name:'Firefox'},
                                {value: idx * 32  + 320,  name:'Safari'},
                                {value: idx * 16  + 640,  name:'IE9+'},
                                {value: idx++ * 8  + 1280, name:'IE8-'}
                            ]
                        }]
                    },
                    {
                        series: [{
                            name: 'Browser',
                            type: 'pie',
                            data: [
                                {value: idx * 128 + 80,  name:'Chrome'},
                                {value: idx * 64  + 160,  name:'Firefox'},
                                {value: idx * 32  + 320,  name:'Safari'},
                                {value: idx * 16  + 640,  name:'IE9+'},
                                {value: idx++ * 8  + 1280, name:'IE8-'}
                            ]
                        }]
                    },
                    {
                        series: [{
                            name: 'Browser',
                            type: 'pie',
                            data: [
                                {value: idx * 128 + 80,  name:'Chrome'},
                                {value: idx * 64  + 160,  name:'Firefox'},
                                {value: idx * 32  + 320,  name:'Safari'},
                                {value: idx * 16  + 640,  name:'IE9+'},
                                {value: idx++ * 8  + 1280, name:'IE8-'}
                            ]
                        }]
                    },
                    {
                        series: [{
                            name: 'Browser',
                            type: 'pie',
                            data: [
                                {value: idx * 128 + 80,  name:'Chrome'},
                                {value: idx * 64  + 160,  name:'Firefox'},
                                {value: idx * 32  + 320,  name:'Safari'},
                                {value: idx * 16  + 640,  name:'IE9+'},
                                {value: idx++ * 8  + 1280, name:'IE8-'}
                            ]
                        }]
                    },
                    {
                        series: [{
                            name: 'Browser',
                            type: 'pie',
                            data: [
                                {value: idx * 128 + 80,  name:'Chrome'},
                                {value: idx * 64  + 160,  name:'Firefox'},
                                {value: idx * 32  + 320,  name:'Safari'},
                                {value: idx * 16  + 640,  name:'IE9+'},
                                {value: idx++ * 8  + 1280, name:'IE8-'}
                            ]
                        }]
                    },
                    {
                        series: [{
                            name: 'Browser',
                            type: 'pie',
                            data: [
                                {value: idx * 128 + 80,  name:'Chrome'},
                                {value: idx * 64  + 160,  name:'Firefox'},
                                {value: idx * 32  + 320,  name:'Safari'},
                                {value: idx * 16  + 640,  name:'IE9+'},
                                {value: idx++ * 8  + 1280, name:'IE8-'}
                            ]
                        }]
                    },
                    {
                        series: [{
                            name: 'Browser',
                            type: 'pie',
                            data: [
                                {value: idx * 128 + 80,  name:'Chrome'},
                                {value: idx * 64  + 160,  name:'Firefox'},
                                {value: idx * 32  + 320,  name:'Safari'},
                                {value: idx * 16  + 640,  name:'IE9+'},
                                {value: idx++ * 8  + 1280, name:'IE8-'}
                            ]
                        }]
                    },
                    {
                        series: [{
                            name: 'Browser',
                            type: 'pie',
                            data: [
                                {value: idx * 128 + 80,  name:'Chrome'},
                                {value: idx * 64  + 160,  name:'Firefox'},
                                {value: idx * 32  + 320,  name:'Safari'},
                                {value: idx * 16  + 640,  name:'IE9+'},
                                {value: idx++ * 8  + 1280, name:'IE8-'}
                            ]
                        }]
                    },
                    {
                        series: [{
                            name: 'Browser',
                            type: 'pie',
                            data: [
                                {value: idx * 128 + 80,  name:'Chrome'},
                                {value: idx * 64  + 160,  name:'Firefox'},
                                {value: idx * 32  + 320,  name:'Safari'},
                                {value: idx * 16  + 640,  name:'IE9+'},
                                {value: idx++ * 8  + 1280, name:'IE8-'}
                            ]
                        }]
                    }
                ]
            });
        }


        //
        // Resize charts
        //

        // Resize function
        var triggerChartResize = function() {
            pie_timeline_element && pie_timeline.resize();
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
            _pieTimelineLightExample();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    EchartsPieTimelineLight.init();
});
