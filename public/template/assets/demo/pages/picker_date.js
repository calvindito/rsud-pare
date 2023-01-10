/* ------------------------------------------------------------------------------
 *
 *  # Date and time pickers
 *
 *  Demo JS code for picker_date.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var DateTimePickers = function() {


    //
    // Setup module components
    //

    // Daterange picker
    const _componentDaterange = function() {
        if (!$().daterangepicker) {
            console.warn('Warning - daterangepicker.js is not loaded.');
            return;
        }

        // Basic initialization
        $('.daterange-basic').daterangepicker({
            parentEl: '.content-inner'
        });

        // Display week numbers
        $('.daterange-weeknumbers').daterangepicker({
            parentEl: '.content-inner',
            showWeekNumbers: true
        });

        // Button class options
        $('.daterange-buttons').daterangepicker({
            parentEl: '.content-inner',
            applyClass: 'btn-success',
            cancelClass: 'btn-danger'
        });

        // Display time picker
        $('.daterange-time').daterangepicker({
            parentEl: '.content-inner',
            timePicker: true,
            locale: {
                format: 'MM/DD/YYYY h:mm a'
            }
        });

        // Show picker on right
        $('.daterange-left').daterangepicker({
            parentEl: '.content-inner',
            opens: 'left'
        });

        // Single picker
        $('.daterange-single').daterangepicker({
            parentEl: '.content-inner',
            singleDatePicker: true
        });

        // Display date dropdowns
        $('.daterange-datemenu').daterangepicker({
            parentEl: '.content-inner',
            showDropdowns: true
        });

        // 10 minute increments
        $('.daterange-increments').daterangepicker({
            parentEl: '.content-inner',
            timePicker: true,
            timePickerIncrement: 10,
            locale: {
                format: 'MM/DD/YYYY h:mm a'
            }
        });

        // Localization
        $('.daterange-locale').daterangepicker({
            parentEl: '.content-inner',
            ranges: {
                'Сегодня': [moment(), moment()],
                'Вчера': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Последние 7 дней': [moment().subtract(6, 'days'), moment()],
                'Последние 30 дней': [moment().subtract(29, 'days'), moment()],
                'Этот месяц': [moment().startOf('month'), moment().endOf('month')],
                'Прошедший месяц': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            locale: {
                applyLabel: 'Вперед',
                cancelLabel: 'Отмена',
                startLabel: 'Начальная дата',
                endLabel: 'Конечная дата',
                customRangeLabel: 'Выбрать дату',
                daysOfWeek: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт','Сб'],
                monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
                firstDay: 1
            }
        });


        //
        // Pre-defined ranges and callback
        //

        // Initialize with options
        $('.daterange-predefined').daterangepicker(
            {
                startDate: moment().subtract(29, 'days'),
                endDate: moment(),
                minDate: '01/01/2020',
                maxDate: '12/12/2021',
                dateLimit: { days: 60 },
                parentEl: '.content-inner',
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            },
            function(start, end) {
                console.log('Date range has been changed');
            }
        );


        //
        // Inside button
        //

        // Initialize with options
        $('.daterange-ranges').daterangepicker(
            {
                startDate: moment().subtract(29, 'days'),
                endDate: moment(),
                minDate: '01/01/2020',
                maxDate: '12/31/2021',
                dateLimit: { days: 60 },
                opens: document.dir == 'rtl' ? 'right' : 'left', // double check this !!!!!!!!!!!!!!!!!!!!!!
                parentEl: '.content-inner',
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            },
            function(start, end) {
                $('.daterange-ranges').html(start.format('MMMM D, YYYY') + ' &nbsp; - &nbsp; ' + end.format('MMMM D, YYYY'));
            }
        );

        // Display date format
        $('.daterange-ranges span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' &nbsp; - &nbsp; ' + moment().format('MMMM D, YYYY'));
    };

    // Date picker
    const _componentDatepicker = function() {
        if (typeof Datepicker == 'undefined') {
            console.warn('Warning - datepicker.min.js is not loaded.');
            return;
        }

        // Basic example
        const dpBasicElement = document.querySelector('.datepicker-basic');
        if(dpBasicElement) {
            const dpBasic = new Datepicker(dpBasicElement, {
                container: '.content-inner',
                buttonClass: 'btn',
                prevArrow: document.dir == 'rtl' ? '&rarr;' : '&larr;',
                nextArrow: document.dir == 'rtl' ? '&larr;' : '&rarr;'
            });
        }

        // Hide on selection
        const dpAutoHideElement = document.querySelector('.datepicker-autohide');
        if(dpAutoHideElement) {
            const dpAutoHide = new Datepicker(dpAutoHideElement, {
                container: '.content-inner',
                buttonClass: 'btn',
                prevArrow: document.dir == 'rtl' ? '&rarr;' : '&larr;',
                nextArrow: document.dir == 'rtl' ? '&larr;' : '&rarr;',
                autohide: true
            });
        }

        // Week numbers
        const dpWeeksElement = document.querySelector('.datepicker-week-numbers');
        if(dpWeeksElement) {
            const dpWeeks = new Datepicker(dpWeeksElement, {
                container: '.content-inner',
                buttonClass: 'btn',
                prevArrow: document.dir == 'rtl' ? '&rarr;' : '&larr;',
                nextArrow: document.dir == 'rtl' ? '&larr;' : '&rarr;',
                calendarWeeks: true
            });
        }

        // Clear date selection
        const dpClearElement = document.querySelector('.datepicker-clear-date');
        if(dpClearElement) {
            const dpClear = new Datepicker(dpClearElement, {
                container: '.content-inner',
                buttonClass: 'btn',
                prevArrow: document.dir == 'rtl' ? '&rarr;' : '&larr;',
                nextArrow: document.dir == 'rtl' ? '&larr;' : '&rarr;',
                clearBtn: true
            });
        }

        // Disabled weekdays
        const dpWeekdaysDisabledElement = document.querySelector('.datepicker-weekdays-disabled');
        if(dpWeekdaysDisabledElement) {
            const dpWeekdaysDisabled = new Datepicker(dpWeekdaysDisabledElement, {
                container: '.content-inner',
                buttonClass: 'btn',
                prevArrow: document.dir == 'rtl' ? '&rarr;' : '&larr;',
                nextArrow: document.dir == 'rtl' ? '&larr;' : '&rarr;',
                daysOfWeekDisabled: [6]
            });
        }

        // Disabled dates
        const dpDatesDisabledElement = document.querySelector('.datepicker-dates-disabled');
        if(dpDatesDisabledElement) {
            const dpDatesDisabled = new Datepicker(dpDatesDisabledElement, {
                container: '.content-inner',
                buttonClass: 'btn',
                prevArrow: document.dir == 'rtl' ? '&rarr;' : '&larr;',
                nextArrow: document.dir == 'rtl' ? '&larr;' : '&rarr;',
                datesDisabled: ['01/03/2022', '01/05/2022', '01/10/2022', '01/20/2022', '01/25/2022']
            });
        }

        // Highlighted weekdays
        const dpDaysHighlightedElement = document.querySelector('.datepicker-days-highlighted');
        if(dpDaysHighlightedElement) {
            const dpDaysHighlighted = new Datepicker(dpDaysHighlightedElement, {
                container: '.content-inner',
                buttonClass: 'btn',
                prevArrow: document.dir == 'rtl' ? '&rarr;' : '&larr;',
                nextArrow: document.dir == 'rtl' ? '&larr;' : '&rarr;',
                daysOfWeekHighlighted: [3]
            });
        }

        // Date format
        const dpDateFormatElement = document.querySelector('.datepicker-date-format');
        if(dpDateFormatElement) {
            const dpDateFormat = new Datepicker(dpDateFormatElement, {
                container: '.content-inner',
                buttonClass: 'btn',
                prevArrow: document.dir == 'rtl' ? '&rarr;' : '&larr;',
                nextArrow: document.dir == 'rtl' ? '&larr;' : '&rarr;',
                format: 'yyyy-mm-dd'
            });
        }

        // Multiple dates
        const dpDatesMultipleElement = document.querySelector('.datepicker-multiple-dates');
        if(dpDatesMultipleElement) {
            const dpDatesMultiple = new Datepicker(dpDatesMultipleElement, {
                container: '.content-inner',
                buttonClass: 'btn',
                prevArrow: document.dir == 'rtl' ? '&rarr;' : '&larr;',
                nextArrow: document.dir == 'rtl' ? '&larr;' : '&rarr;',
                maxNumberOfDates: 3
            });
        }

        // Minimum date
        const dpDateMinElement = document.querySelector('.datepicker-date-min');
        if(dpDateMinElement) {
            const dpDateMin = new Datepicker(dpDateMinElement, {
                container: '.content-inner',
                buttonClass: 'btn',
                prevArrow: document.dir == 'rtl' ? '&rarr;' : '&larr;',
                nextArrow: document.dir == 'rtl' ? '&larr;' : '&rarr;',
                minDate: '01/01/2022'
            });
        }

        // Maximum date
        const dpDateMaxElement = document.querySelector('.datepicker-date-max');
        if(dpDateMaxElement) {
            const dpDateMax = new Datepicker(dpDateMaxElement, {
                container: '.content-inner',
                buttonClass: 'btn',
                prevArrow: document.dir == 'rtl' ? '&rarr;' : '&larr;',
                nextArrow: document.dir == 'rtl' ? '&larr;' : '&rarr;',
                maxDate: '01/01/2022'
            });
        }

        // Change pick level
        const dpPickLevelElement = document.querySelector('.datepicker-pick-level');
        if(dpPickLevelElement) {
            const dpPickLevel = new Datepicker(dpPickLevelElement, {
                container: '.content-inner',
                buttonClass: 'btn',
                prevArrow: document.dir == 'rtl' ? '&rarr;' : '&larr;',
                nextArrow: document.dir == 'rtl' ? '&larr;' : '&rarr;',
                pickLevel: 1
            });
        }

        // Change default view
        const dpDefaultViewElement = document.querySelector('.datepicker-default-view');
        if(dpDefaultViewElement) {
            const dpDefaultView = new Datepicker(dpDefaultViewElement, {
                container: '.content-inner',
                buttonClass: 'btn',
                prevArrow: document.dir == 'rtl' ? '&rarr;' : '&larr;',
                nextArrow: document.dir == 'rtl' ? '&larr;' : '&rarr;',
                startView: 2
            });
        }

        // Display picker title
        const dpTitleElement = document.querySelector('.datepicker-with-title');
        if(dpTitleElement) {
            const dpTitle = new Datepicker(dpTitleElement, {
                container: '.content-inner',
                buttonClass: 'btn',
                prevArrow: document.dir == 'rtl' ? '&rarr;' : '&larr;',
                nextArrow: document.dir == 'rtl' ? '&larr;' : '&rarr;',
                title: 'Pick a date'
            });
        }

        // Today button
        const dpTodayButtonElement = document.querySelector('.datepicker-date-today');
        if(dpTodayButtonElement) {
            const dpTodayButton = new Datepicker(dpTodayButtonElement, {
                container: '.content-inner',
                buttonClass: 'btn',
                prevArrow: document.dir == 'rtl' ? '&rarr;' : '&larr;',
                nextArrow: document.dir == 'rtl' ? '&larr;' : '&rarr;',
                todayBtn: true
            });
        }

        // Start day of the week
        const dpStartDayElement = document.querySelector('.datepicker-start-day');
        if(dpStartDayElement) {
            const dpStartDay = new Datepicker(dpStartDayElement, {
                container: '.content-inner',
                buttonClass: 'btn',
                prevArrow: document.dir == 'rtl' ? '&rarr;' : '&larr;',
                nextArrow: document.dir == 'rtl' ? '&larr;' : '&rarr;',
                weekStart: 1
            });
        }

        // Date range
        const dpRangeElement = document.querySelector('.datepicker-range');
        if(dpRangeElement) {
            const dpRange = new DateRangePicker(dpRangeElement, {
                container: '.content-inner',
                buttonClass: 'btn',
                prevArrow: document.dir == 'rtl' ? '&rarr;' : '&larr;',
                nextArrow: document.dir == 'rtl' ? '&larr;' : '&rarr;'
            });
        }

        // Allow one sided range
        const dpOneSideElement = document.querySelector('.datepicker-range-one-side');
        if(dpOneSideElement) {
            const dpOneSide = new DateRangePicker(dpOneSideElement, {
                container: '.content-inner',
                buttonClass: 'btn',
                prevArrow: document.dir == 'rtl' ? '&rarr;' : '&larr;',
                nextArrow: document.dir == 'rtl' ? '&larr;' : '&rarr;',
                allowOneSidedRange: false
            });
        }
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentDaterange();
            _componentDatepicker();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    DateTimePickers.init();
});
