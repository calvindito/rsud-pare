/* ------------------------------------------------------------------------------
 *
 *  # Dashboard configuration
 *
 *  Demo dashboard configuration. Contains charts and plugin initializations
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const Dashboard = function () {


    //
    // Setup module components
    //

    // Use first letter as an icon
    const _componentIconLetter = function() {

        // Grab first letter and insert to the icon
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
        initComponents: function() {
            _componentIconLetter();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    Dashboard.initComponents();
});
