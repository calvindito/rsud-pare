/* ------------------------------------------------------------------------------
 *
 *  # Echarts - EU map with scatter example
 *
 *  Demo JS code for EU map with scatter chart [light theme]
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var EchartsMapEuropeScale = function() {


    //
    // Setup module components
    //

    // Basic bar chart
    var _mapEuropeScaleExample = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define element
        var map_europe_scale_element = document.getElementById('map_europe_scale');

        // Chart configuration
        if (map_europe_scale_element) {

            // Initialize chart
            var map_europe_scale = echarts.init(map_europe_scale_element, null, { renderer: 'svg' });


            //
            // Chart config
            //

            // Data
            var mapData = [
                {'code': 'NL', 'name': 'Netherlands', 'value': 300, 'newSales': '0'},
                {'code': 'CZ', 'name': 'Czech Rep.', 'value': 800, 'newSales': '0'},
                {'code': 'DE', 'name': 'Germany', 'value': 450, 'newSales': '2'},
                {'code': 'UA', 'name': 'Ukraine', 'value': 289, 'newSales': '0'},
                {'code': 'PL', 'name': 'Poland', 'value': 673, 'newSales': '0'},
                {'code': 'HU', 'name': 'Hungary', 'value': 930, 'newSales': '0'},
                {'code': 'FR', 'name': 'France', 'value': 793, 'newSales': '0'},
                {'code': 'ES', 'name': 'Spain', 'value': 349, 'newSales': '0'},
                {'code': 'UK', 'name': 'United Kingdom', 'value': 376, 'newSales': '0'},
                {'code': 'IT', 'name': 'Italy', 'value': 640, 'newSales': '0'},
                {'code': 'PT', 'name': 'Portugal', 'value': 839, 'newSales': '0'},
                {'code': 'RO', 'name': 'Romania', 'value': 438, 'newSales': '0'},
                {'code': 'AT', 'name': 'Austria', 'value': 630, 'newSales': '0'},
                {'code': 'BE', 'name': 'Belgium', 'value': 349, 'newSales': '0'},
                {'code': 'LU', 'name': 'Luxembourg', 'value': 650, 'newSales': '0'},
                {'code': 'CH', 'name': 'Switzerland', 'value': 740, 'newSales': '0'},
                {'code': 'BY', 'name': 'Belarus', 'value': 439, 'newSales': '0'},
                {'code': 'SK', 'name': 'Slovakia', 'value': 583, 'newSales': '0'},
                {'code': 'SL', 'name': 'Slovenia', 'value': 590, 'newSales': '0'},
                {'code': 'RS', 'name': 'Serbia', 'value': 249, 'newSales': '0'},
                {'code': 'HR', 'name': 'Croatia', 'value': 629, 'newSales': '0'},
                {'code': 'GR', 'name': 'Greece', 'value': 810, 'newSales': '0'},
                {'code': 'NO', 'name': 'Norway', 'value': 590, 'newSales': '0'},
                {'code': 'SE', 'name': 'Sweden', 'value': 648, 'newSales': '0'},
                {'code': 'BG', 'name': 'Bulgaria', 'value': 520, 'newSales': '0'},
                {'code': 'RU', 'name': 'Russia', 'value': 638, 'newSales': '0'},
                {'code': 'DK', 'name': 'Denmark', 'value': 829, 'newSales': '0'},
                {'code': 'TR', 'name': 'Turkey', 'value': 530, 'newSales': '0'},
            ];

            // Configure heatmap
            var max = -Infinity,
                min = Infinity;

            mapData.forEach(function (itemOpt) {
                if (itemOpt.value > max) {
                    max = itemOpt.value;
                }
                if (itemOpt.value < min) {
                    min = itemOpt.value;
                }
            });

            // Colors
            var mapColorRange = ['#e0ffff', '#006edd'],
                mapBackgroundColor = 'var(--map-bg)',
                mapPlaceholderColor = 'var(--map-placeholder-color)',
                mapHoverColor = 'var(--map-hover-color)',
                mapBorderColor = 'var(--map-border-color)';


            // Options
            map_europe_scale.setOption({

                // Map background color
                backgroundColor: mapBackgroundColor,

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
                    trigger: 'item',
                    formatter: function (params) {
                        if (params.data) {
                            return '<strong>' + params.name + '</strong><br/>'
                            + 'Sales today: ' + params.value; 
                        }
                        else {
                            return;
                        }
                    },
                    className: 'shadow-sm rounded',
                    backgroundColor: 'var(--white)',
                    borderColor: 'rgba(var(--black-rgb), 0.5)',
                    padding: [10, 15],
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

                // Visual map
                visualMap: {
                    show: false,
                    max: max,
                    calculable: true,
                    seriesIndex: 0,
                    inRange: {
                        color: mapColorRange
                    },
                    orient: 'horizontal',
                    left: 'center'
                },

                // Geographic coordinates
                // world map zoomed in to Europe
                geo: {
                    show: true,
                    map: 'world',
                    zoom: 8,
                    center: [16, 48],
                    label: {
                        normal: {
                            show: false
                        },
                        emphasis: {
                            show: false
                        }
                    },
                    select: {
                        label: {
                            show: false
                        },
                        itemStyle: {
                            areaColor: mapHoverColor
                        }
                    },
                    roam: 'scale',
                    scaleLimit: {
                        min: 2,
                        max: 14
                    },
                    itemStyle: {
                        normal: {
                            areaColor: mapPlaceholderColor,
                            borderColor: mapBorderColor,
                            borderWidth: 1
                        },
                        emphasis: {
                            areaColor: mapHoverColor
                        }
                    }
                },

                // Add series
                series: [
                    {
                        type: 'map',
                        geoIndex: 0,
                        label: {
                            normal: {
                                show: true
                            },
                            emphasis: {
                                show: false
                            }
                        },
                        data: mapData.map(function (itemOpt) {
                            return {
                                name: itemOpt.name,
                                value: itemOpt.value
                            };
                        })
                    }
                ]
            });
        }


        //
        // Resize charts
        //

        // Resize function
        var triggerChartResize = function() {
            map_europe_scale_element && map_europe_scale.resize();
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
            _mapEuropeScaleExample();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    EchartsMapEuropeScale.init();
});
