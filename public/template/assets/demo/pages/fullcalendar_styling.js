/* ------------------------------------------------------------------------------
 *
 *  # Fullcalendar basic options
 *
 *  Demo JS code for extra_fullcalendar_styling.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const FullCalendarStyling = function() {


    //
    // Setup module components
    //

    // External events
    const _componentFullCalendarStyling = function() {
        if (typeof FullCalendar == 'undefined') {
            console.warn('Warning - Fullcalendar files are not loaded.');
            return;
        }


        // Add events
        // ------------------------------

        // Event colors
        const eventColors = [
            {
                title: 'All Day Event',
                start: '2020-09-01',
                color: '#EF5350'
            },
            {
                title: 'Long Event',
                start: '2020-09-07',
                end: '2020-09-10',
                color: '#26A69A'
            },
            {
                id: 999,
                title: 'Repeating Event',
                start: '2020-09-09',
                color: '#26A69A'
            },
            {
                id: 999,
                title: 'Repeating Event',
                start: '2020-09-16',
                color: '#5C6BC0'
            },
            {
                title: 'Conference',
                start: '2020-09-11',
                end: '2020-09-13',
                color: '#546E7A'
            },
            {
                title: 'Meeting',
                start: '2020-09-12',
                end: '2020-09-12',
                color: '#d662a2'
            },
            {
                title: 'Lunch',
                start: '2020-09-12T12:00:00'
            },
            {
                title: 'Meeting',
                start: '2020-09-12T14:30:00'
            },
            {
                title: 'Happy Hour',
                start: '2020-09-12T17:30:00'
            },
            {
                title: 'Dinner',
                start: '2020-09-12T20:00:00'
            },
            {
                title: 'Birthday Party',
                start: '2020-09-13T07:00:00'
            },
            {
                title: 'Click for Google',
                url: 'http://google.com/',
                start: '2020-09-28',
                color: '#FF7043'
            }
        ];

        // Event background colors
        const eventBackgroundColors = [
            {
                title: 'Business Lunch',
                start: '2020-09-03T13:00:00',
                constraint: 'businessHours'
            },
            {
                title: 'Meeting',
                start: '2020-09-13T11:00:00',
                constraint: 'availableForMeeting', // defined below
                color: '#257e4a'
            },
            {
                title: 'Conference',
                start: '2020-09-18',
                end: '2020-09-20'
            },
            {
                title: 'Party',
                start: '2020-09-29T20:00:00'
            },

            // areas where "Meeting" must be dropped
            {
                groupId: 'availableForMeeting',
                start: '2020-09-11T10:00:00',
                end: '2020-09-11T16:00:00',
                display: 'background'
            },
            {
                groupId: 'availableForMeeting',
                start: '2020-09-13T10:00:00',
                end: '2020-09-13T16:00:00',
                display: 'background'
            },

            // red areas where no events can be dropped
            {
                start: '2020-09-24',
                end: '2020-09-28',
                overlap: false,
                display: 'background',
                color: '#ff9f89'
            },
            {
                start: '2020-09-06',
                end: '2020-09-08',
                overlap: false,
                display: 'background',
                color: '#ff9f89'
            }
        ];


        // Initialization
        // ------------------------------

        //
        // Event colors
        //

        // Define element
        const calendarEventColorsElement = document.querySelector('.fullcalendar-event-colors');

        // Initialize
        if(calendarEventColorsElement) {
            const calendarEventColorsInit = new FullCalendar.Calendar(calendarEventColorsElement, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,dayGridWeek,dayGridDay'
                },
                initialDate: '2020-09-12',
                navLinks: true, // can click day/week names to navigate views
                businessHours: true, // display business hours
                editable: true,
                selectable: true,
                editable: true,
                direction: document.dir == 'rtl' ? 'rtl' : 'ltr',
                events: eventColors
            });

            // Init
            calendarEventColorsInit.render();

            // Resize calendar when sidebar toggler is clicked
            document.querySelectorAll('.sidebar-control').forEach(function(sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    calendarEventColorsInit.updateSize();
                })
            });
        }


        //
        // Event background colors
        //

        // Define element
        const calendarEventBgColorsElement = document.querySelector('.fullcalendar-background-colors');

        // Initialize
        if(calendarEventBgColorsElement) {
            const calendarEventBgColorsInit = new FullCalendar.Calendar(calendarEventBgColorsElement, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                initialDate: '2020-09-12',
                navLinks: true, // can click day/week names to navigate views
                businessHours: true, // display business hours
                editable: true,
                selectable: true,
                direction: document.dir == 'rtl' ? 'rtl' : 'ltr',
                events: eventBackgroundColors
            });

            // Init
            calendarEventBgColorsInit.render();

            // Resize calendar when sidebar toggler is clicked
            document.querySelectorAll('.sidebar-control').forEach(function(sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    calendarEventBgColorsInit.updateSize();
                })
            });
        }
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentFullCalendarStyling();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    FullCalendarStyling.init();
});
