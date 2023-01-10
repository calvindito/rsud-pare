/* ------------------------------------------------------------------------------
 *
 *  # Content widgets
 *
 *  Demo JS code for widgets_content.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const ContentWidgets = function() {


    //
    // Setup module components
    //

    // Dropzone file uploader
    const _componentDropzone = function() {
        if (typeof Dropzone == 'undefined') {
            console.warn('Warning - dropzone.min.js is not loaded.');
            return;
        }

        // Configure dropzone
        let dropzoneMultiple = new Dropzone("#dropzone_multiple", {
            url: "#",
            paramName: "file", // The name that will be used to transfer the file
            dictDefaultMessage: 'Drop files to upload <div>or CLICK</div>',
            maxFilesize: 0.1 // MB
        });
    };

    // Datepicker
    const _componentDatepicker = function() {
        if (typeof Datepicker == 'undefined') {
            console.warn('Warning - datepicker.min.js is not loaded.');
            return;
        }

        // Basic example
        const dpBasicElement = document.querySelector('.form-control-datepicker');
        if(dpBasicElement) {
            const dpBasic = new Datepicker(dpBasicElement, {
                container: '.content-inner',
                buttonClass: 'btn',
                prevArrow: document.dir == 'rtl' ? '&rarr;' : '&larr;',
                nextArrow: document.dir == 'rtl' ? '&larr;' : '&rarr;'
            });
        }
    };

    // Chart
    const _chatMessagesStats = function() {
        if (typeof d3 == 'undefined') {
            console.warn('Warning - d3.min.js is not loaded.');
            return;
        }

        // Main variables
        var element = document.getElementById('messages-stats'),
            height = 60,
            color = '#26A69A';


        // Initialize chart only if element exsists in the DOM
        if(element) {

            // Define main variables
            var d3Container = d3.select(element),
                margin = {top: 0, right: 0, bottom: 0, left: 0},
                width = d3Container.node().getBoundingClientRect().width - margin.left - margin.right,
                height = height - margin.top - margin.bottom;

            // Date and time format
            var parseDate = d3.time.format('%Y-%m-%d').parse;


            // Create SVG
            // ------------------------------

            // Container
            var container = d3Container.append('svg');

            // SVG element
            var svg = container
                .attr('width', width + margin.left + margin.right)
                .attr('height', height + margin.top + margin.bottom)
                .append('g')
                    .attr('transform', 'translate(' + margin.left + ',' + margin.top + ')')


            // Construct chart layout
            // ------------------------------

            // Area
            var area = d3.svg.area()
                .x(function(d) { return x(d.date); })
                .y0(height)
                .y1(function(d) { return y(d.value); })
                .interpolate('monotone')


            // Construct scales
            // ------------------------------

            // Horizontal
            var x = d3.time.scale().range([0, width ]);

            // Vertical
            var y = d3.scale.linear().range([height, 0]);


            // Load data
            // ------------------------------

            d3.json('../../../assets/demo/data/dashboard/monthly_sales.json', function (error, data) {

                // Show what's wrong if error
                if (error) return console.error(error);

                // Pull out values
                data.forEach(function (d) {
                    d.date = parseDate(d.date);
                    d.value = +d.value;
                });

                // Get the maximum value in the given array
                var maxY = d3.max(data, function(d) { return d.value; });

                // Reset start data for animation
                var startData = data.map(function(datum) {
                    return {
                        date: datum.date,
                        value: 0
                    };
                });


                // Set input domains
                // ------------------------------

                // Horizontal
                x.domain(d3.extent(data, function(d, i) { return d.date; }));

                // Vertical
                y.domain([0, d3.max( data, function(d) { return d.value; })]);



                //
                // Append chart elements
                //

                // Add area path
                svg.append('path')
                    .datum(data)
                    .attr('class', 'd3-area')
                    .style('fill', color)
                    .attr('d', area)
                    .transition() // begin animation
                        .duration(1000)
                        .attrTween('d', function() {
                            var interpolator = d3.interpolateArray(startData, data);
                            return function (t) {
                                return area(interpolator (t));
                            }
                        });


                // Resize chart
                // ------------------------------

                // Call function on window resize
                window.addEventListener('resize', messagesAreaResize);

                // Call function on sidebar width change
                document.querySelectorAll('.sidebar-control').forEach(function(toggler) {
                    toggler.addEventListener('click', messagesAreaResize);
                })

                // Resize function
                // 
                // Since D3 doesn't support SVG resize by default,
                // we need to manually specify parts of the graph that need to 
                // be updated on window resize
                function messagesAreaResize() {

                    // Layout variables
                    width = d3Container.node().getBoundingClientRect().width - margin.left - margin.right;


                    // Layout
                    // -------------------------

                    // Main svg width
                    container.attr("width", width + margin.left + margin.right);

                    // Width of appended group
                    svg.attr("width", width + margin.left + margin.right);

                    // Horizontal range
                    x.range([0, width]);


                    // Chart elements
                    // -------------------------

                    // Area path
                    svg.selectAll('.d3-area').datum( data ).attr("d", area);
                }
            });
        }
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentDatepicker();
            _chatMessagesStats();
            _componentDropzone();
        }
    }
}();


// Initialize module
// ------------------------------

// When content loaded
document.addEventListener('DOMContentLoaded', function() {
    ContentWidgets.init();
});
