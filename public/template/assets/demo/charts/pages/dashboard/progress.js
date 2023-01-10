/* ------------------------------------------------------------------------------
 *
 *  # D3.js - horizontal bar chart
 *
 *  Demo d3.js horizontal bar chart setup with .csv data source
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var DashboardProgress = function() {


    //
    // Setup module components
    //

    // Rounded progress charts
    var _ProgressRoundedChart = function(element, radius, border, color, end, iconClass, textTitle, textAverage) {
        if (typeof d3 == 'undefined') {
            console.warn('Warning - d3.min.js is not loaded.');
            return;
        }

        // Initialize chart only if element exsists in the DOM
        if(element) {


            // Basic setup
            // ------------------------------

            // Main variables
            var d3Container = d3.select(element),
                startPercent = 0,
                endPercent = end,
                twoPi = Math.PI * 2,
                formatPercent = d3.format('.0%'),
                boxSize = radius * 2;

            // Values count
            var count = Math.abs((endPercent - startPercent) / 0.01);

            // Values step
            var step = endPercent < startPercent ? -0.01 : 0.01;



            // Create chart
            // ------------------------------

            var svgWrapper = d3Container
                .append('div')
                .attr('class', 'position-relative');

            // Add SVG element
            var container = svgWrapper.append('svg');

            // Add SVG group
            var svg = container
                .attr('width', boxSize)
                .attr('height', boxSize)
                .append('g')
                    .attr('transform', 'translate(' + (boxSize / 2) + ',' + (boxSize / 2) + ')');



            // Construct chart layout
            // ------------------------------

            // Arc
            var arc = d3.svg.arc()
                .startAngle(0)
                .innerRadius(radius)
                .outerRadius(radius - border);



            //
            // Append chart elements
            //

            // Paths
            // ------------------------------

            // Background path
            svg.append('path')
                .attr('class', 'd3-progress-background')
                .attr('d', arc.endAngle(twoPi))
                .style('fill', color)
                .style('opacity', 0.2);

            // Foreground path
            var foreground = svg.append('path')
                .attr('class', 'd3-progress-foreground')
                .attr('filter', 'url(#blur)')
                .style('fill', color)
                .style('stroke', color);

            // Front path
            var front = svg.append('path')
                .attr('class', 'd3-progress-front')
                .style('fill', color)
                .style('fill-opacity', 1);



            // Text
            // ------------------------------

            // Percentage text value
            var numberText = d3.select(element)
                .append('h4')
                    .attr('class', 'pt-1 mt-2 mb-0')

            // Icon
            svgWrapper
                .append('i')
                    .attr('class', iconClass + ' counter-icon');

            // Title
            d3.select(element)
                .append('div')
                    .text(textTitle);

            // Subtitle
            d3.select(element)
                .append('div')
                    .attr('class', 'fs-sm text-muted mb-3')
                    .text(textAverage);



            // Animation
            // ------------------------------

            // Animate path
            function updateProgress(progress) {
                foreground.attr('d', arc.endAngle(twoPi * progress));
                front.attr('d', arc.endAngle(twoPi * progress));
                numberText.text(formatPercent(progress));
            }

            // Animate text
            var progress = startPercent;
            (function loops() {
                updateProgress(progress);
                if (count > 0) {
                    count--;
                    progress += step;
                    setTimeout(loops, 10);
                }
            })();
        }
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _ProgressRoundedChart('#hours-available-progress', 38, 2, '#F06292', 0.68, 'ph-check text-pink', 'Hours available', '64% average');
            _ProgressRoundedChart('#goal-progress', 38, 2, '#5C6BC0', 0.82, 'ph-trophy text-indigo', 'Productivity goal', '87% average');
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    DashboardProgress.init();
});
