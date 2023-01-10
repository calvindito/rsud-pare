/* ------------------------------------------------------------------------------
 *
 *  # Inbox page - Reading
 *
 *  Demo JS code for mail_list_read.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const MailListRead = function() {


    //
    // Setup module components
    //

    // Grab first letter and insert to the icon
    const _componentIconLetter = function() {

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
            const icon = label.closest('.card-body').querySelector('.letter-icon');
            icon && icon.append(initials);
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentIconLetter();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    MailListRead.init();
});
