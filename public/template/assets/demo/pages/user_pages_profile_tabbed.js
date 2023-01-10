/* ------------------------------------------------------------------------------
 *
 *  # User profile - tabbed
 *
 *  Demo JS code for user_pages_profile_tabbed.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var UserProfileTabbed = function() {


    //
    // Setup module components
    //

    // Schedule
    const _componentFullCalendar = function() {
        if (typeof FullCalendar == 'undefined') {
            console.warn('Warning - Fullcalendar files are not loaded.');
            return;
        }

        // Add events
        const eventColors = [
            {
                title: 'Day off',
                start: '2021-11-01',
                color: '#DB7272'
            },
            {
                title: 'University',
                start: '2021-11-07',
                end: '2021-11-10',
                color: '#42A5F5'
            },
            {
                id: 999,
                title: 'Shopping',
                start: '2021-11-09T13:00:00',
                color: '#8D6E63'
            },
            {
                id: 999,
                title: 'Shopping',
                start: '2021-11-15T16:00:00',
                color: '#00BCD4'
            },
            {
                title: 'Conference',
                start: '2021-11-11',
                end: '2021-11-13',
                color: '#26A69A'
            },
            {
                title: 'Meeting',
                start: '2021-11-14T08:30:00',
                end: '2021-11-14T12:30:00',
                color: '#7986CB'
            },
            {
                title: 'Meeting',
                start: '2021-11-11T09:30:00',
                color: '#78909C'
            },
            {
                title: 'Happy Hour',
                start: '2021-11-12T14:30:00',
                color: '#26A69A'
            },
            {
                title: 'Dinner',
                start: '2021-11-13T19:00:00',
                color: '#FF7043'
            },
            {
                title: 'Birthday Party',
                start: '2021-11-13T03:00:00',
                color: '#4CAF50'
            }
        ];

        // Define element
        const myScheduleElement = document.querySelector('.my-schedule');

        // Initialize
        if(myScheduleElement) {
            var myScheduleInit = new FullCalendar.Calendar(myScheduleElement, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                initialDate: '2021-11-12',
                initialView: 'timeGridWeek',
                businessHours: true,
                direction: document.dir == 'rtl' ? 'rtl' : 'ltr',
                events: eventColors
            });
        }

        // Render if inside hidden element
        document.querySelectorAll('[data-bs-toggle="tab"]').forEach(function(tabs) {
            tabs.addEventListener('shown.bs.tab', function() {
                myScheduleInit.render();
            });
        });
    };

    // Inbox table
    var _componentTableInbox = function() {

        // Define variables
        var highlightColorClass = 'table-primary';

        // Highlight row when checkbox is checked
        document.querySelectorAll('.table-inbox-checkbox input[type=checkbox]').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                this.checked == true ? this.closest('tr').classList.add(highlightColorClass) : this.closest('tr').classList.remove(highlightColorClass);
            });
        });


        //
        // Get and set user initials
        //

        // Get initials from user name
        const getInitials = function(string) {
            const names = string.split(' ');
            let initials = names[0].substring(0, 1).toUpperCase();
            
            if (names.length > 1) {
                initials += names[names.length - 1].substring(0, 1).toUpperCase();
            }
            return initials;
        };

        // Set initials
        document.querySelectorAll('.letter-icon-title').forEach(function(label) {
            const fullName = label.textContent;
            const initials = getInitials(fullName);
            const icon = label.closest('tr').querySelector('.letter-icon');
            icon && icon.append(initials);
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentFullCalendar();
            _componentTableInbox();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    UserProfileTabbed.init();
});
