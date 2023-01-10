/* ------------------------------------------------------------------------------
 *
 *  # Learning page kit
 *
 *  Demo JS code for learning html page kit - detailed view
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const LearningCourseDetailed = function() {


    //
    // Setup module components
    //

    // Quill
    const _componentQuill = function() {
        if (typeof Quill == 'undefined') {
            console.warn('Warning - quill.min.js is not loaded.');
            return;
        }

        // Basic examples
        // ------------------------------

        // Basic example
        const quillBasic = new Quill('#add-comment', {
            bounds: '.content-inner',
            placeholder: 'Please add your text here...',
            theme: 'snow'
        });
    };

    // Schedule
    const _componentFullCalendar = function() {
        if (typeof FullCalendar == 'undefined') {
            console.warn('Warning - Fullcalendar files are not loaded.');
            return;
        }

        // Add events
        const eventColors = [
            {
                title: 'Data management',
                start: '2021-11-02',
                color: '#EF5350'
            },
            {
                title: 'Web development',
                start: '2021-11-02',
                end: '2021-11-04',
                color: '#26A69A'
            },
            {
                title: 'UX design camp',
                start: '2021-11-05',
                end: '2021-11-07',
                color: '#5C6BC0'
            },
            {
                id: 999,
                title: 'Business development',
                start: '2021-11-09',
                color: '#26A69A'
            },
            {
                id: 999,
                title: 'Business development',
                start: '2021-11-16',
                end: '2021-11-18',
                color: '#26A69A'
            },
            {
                title: 'Marketing strategy',
                start: '2021-11-19',
                end: '2021-11-22',
                color: '#66BB6A'
            },
            {
                title: 'Web development',
                start: '2021-11-12T10:30:00',
                end: '2021-11-12T12:30:00',
                color: '#EC407A'
            },
            {
                title: 'LESS language',
                start: '2021-11-12T12:00:00',
                color: '#EC407A'
            },
            {
                title: 'SASS language',
                start: '2021-11-12T14:30:00',
                color: '#EC407A'
            },
            {
                title: 'PHP language',
                start: '2021-11-12T17:30:00',
                color: '#EC407A'
            },
            {
                title: 'Python language',
                start: '2021-11-12T20:00:00',
                color: '#EC407A'
            },
            {
                title: 'Operations',
                start: '2021-11-24',
                end: '2021-11-26',
                color: '#795548'
            },
            {
                title: 'Finances',
                start: '2021-11-27',
                end: '2021-11-29',
                color: '#FF7043'
            }
        ];

        // Define element
        const scheduleElement = document.querySelector('.schedule');

        // Initialize
        if(scheduleElement) {
            const scheduleInit = new FullCalendar.Calendar(scheduleElement, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                initialDate: '2021-11-12',
                businessHours: true,
                direction: document.dir == 'rtl' ? 'rtl' : 'ltr',
                events: eventColors
            });

            // Render if inside hidden element
            document.querySelectorAll('a[href="#course-schedule"]').forEach(function(link) {
                link.addEventListener('shown.bs.tab', function (e) {
                    scheduleInit.render();
                });
            });
        }
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentQuill();
            _componentFullCalendar();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    LearningCourseDetailed.init();
});
