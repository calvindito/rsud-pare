/* ------------------------------------------------------------------------------
 *
 *  # Inbox page
 *
 *  Demo JS code for mail_list.html pages
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var MailList = function() {


    //
    // Setup module components
    //

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
            _componentTableInbox();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    MailList.init();
});
