/* ------------------------------------------------------------------------------
 *
 *  # Popovers
 *
 *  Demo JS code for components_popovers.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const Popovers = function () {


    //
    // Setup module components
    //

    // Custom popover color
    const _componentPopoverCustomHeaderColor = function() {
		const customPopoverHeaderElement = document.querySelector('[data-popup=popover-custom]');
		if(customPopoverHeaderElement) {
			new bootstrap.Popover(customPopoverHeaderElement, {
				customClass: 'popover-custom',
				template: '<div class="popover border-teal"><div class="popover-arrow border-teal"></div><h3 class="popover-header bg-teal border-teal text-white"></h3><div class="popover-body"></div></div>'
			});
		}
    };

    // Custom popover background color
    const _componentPopoverCustomBackgroundColor = function() {
		const customPopoverElement = document.querySelector('[data-popup=popover-solid]');
		if(customPopoverElement) {
			new bootstrap.Popover(customPopoverElement, {
				customClass: 'popover-custom',
				template: '<div class="popover bg-primary border-primary"><div class="popover-arrow border-primary"></div><h3 class="popover-header bg-primary text-white border-white border-opacity-25"></h3><div class="popover-body text-white"></div></div>'
			});
		}
    };

    // Popover events
    const _componentPopoverEvents = function() {

    	// Elements
		const onShowPopoverElement = document.querySelector('#popover-show');
		const onShownPopoverElement = document.querySelector('#popover-shown');
		const onHidePopoverElement = document.querySelector('#popover-hide');
		const onHiddenPopoverElement = document.querySelector('#popover-hidden');

		// onShow event
		if(onShowPopoverElement) {
			const onShowPopover = new bootstrap.Popover(onShowPopoverElement, {
				title: 'Popover title',
				content: 'And here\'s some amazing content. It\'s very engaging. Right?',
				trigger: 'click'
			});

			onShowPopoverElement.addEventListener('show.bs.popover', function() {
				alert('onShow event fired.');
			});
		}

		// onShown event
		if(onShownPopoverElement) {
			const onShownPopover = new bootstrap.Popover(onShownPopoverElement, {
				title: 'Popover title',
				content: 'And here\'s some amazing content. It\'s very engaging. Right?',
				trigger: 'click'
			});

			onShownPopoverElement.addEventListener('shown.bs.popover', function() {
				alert('onShown event fired.');
			});
		}

		// onHide event
		if(onHidePopoverElement) {
			const onHidePopover = new bootstrap.Popover(onHidePopoverElement, {
				title: 'Popover title',
				content: 'And here\'s some amazing content. It\'s very engaging. Right?',
				trigger: 'click'
			});

			onHidePopoverElement.addEventListener('hide.bs.popover', function() {
				alert('onHide event fired.');
			});
		}

		// onHidden event
		if(onHiddenPopoverElement) {
			const onHiddenPopover = new bootstrap.Popover(onHiddenPopoverElement, {
				title: 'Popover title',
				content: 'And here\'s some amazing content. It\'s very engaging. Right?',
				trigger: 'click'
			});

			onHiddenPopoverElement.addEventListener('hidden.bs.popover', function() {
				alert('onHidden event fired.');
			});
		}
    };

    // Popover methods
    const _componentPopoverMethods = function() {

    	// Elements
    	const showPopoverMethodElementTarget = document.querySelector('#show-popover-method-target');
    	const hidePopoverMethodElementTarget = document.querySelector('#hide-popover-method-target');
    	const togglePopoverMethodElementTarget = document.querySelector('#toggle-popover-method-target');
    	const disposePopoverMethodElementTarget = document.querySelector('#dispose-popover-method-target');
    	const toggleEnabledPopoverMethodElementTarget = document.querySelector('#toggle-enabled-popover-method-target');

		// Show method
		if(showPopoverMethodElementTarget) {
			const showPopover = new bootstrap.Popover(showPopoverMethodElementTarget, {
				title: 'Popover title',
				content: 'And here\'s some amazing content. It\'s very engaging. Right?',
				placement: 'top'
			});

			document.querySelector('#show-popover-method').addEventListener('click', function() {
				showPopover.show();
			});
		}

		// Hide method
		if(hidePopoverMethodElementTarget) {
			const hidePopover = new bootstrap.Popover(hidePopoverMethodElementTarget, {
				title: 'Popover title',
				content: 'And here\'s some amazing content. It\'s very engaging. Right?',
				placement: 'top'
			});

			// Show on hover
			document.querySelector('#hide-popover-method').addEventListener('mouseenter', function() {
				hidePopover.show();
			});

			// Hide on click
			document.querySelector('#hide-popover-method').addEventListener('click', function() {
				hidePopover.hide();
			});
		}

		// Toggle method
		if(togglePopoverMethodElementTarget) {
			const togglePopover = new bootstrap.Popover(togglePopoverMethodElementTarget, {
				title: 'Popover title',
				content: 'And here\'s some amazing content. It\'s very engaging. Right?',
				placement: 'top'
			});

			document.querySelector('#toggle-popover-method').addEventListener('click', function() {
				togglePopover.toggle();
			});
		}

		// Dispose method
		if(disposePopoverMethodElementTarget) {
			const disposePopover = new bootstrap.Popover(disposePopoverMethodElementTarget, {
				title: 'Popover title',
				content: 'And here\'s some amazing content. It\'s very engaging. Right?',
				placement: 'top'
			});

			// Show on hover
			document.querySelector('#dispose-popover-method').addEventListener('mouseenter', function() {
				disposePopover.show();
			});

			document.querySelector('#dispose-popover-method').addEventListener('click', function() {
				disposePopover.dispose();
				disposePopoverMethodElementTarget.innerHTML = 'Disposed';
				disposePopoverMethodElementTarget.classList.add('disabled');
				this.classList.add('disabled');
			});
		}

		// Toggle enable method
		if(toggleEnabledPopoverMethodElementTarget) {
			const toggleEnabledPopover = new bootstrap.Popover(toggleEnabledPopoverMethodElementTarget, {
				title: 'Popover title',
				content: 'And here\'s some amazing content. It\'s very engaging. Right?',
				placement: 'top',
				trigger: 'hover'
			});

			document.querySelector('#toggle-enabled-popover-method').addEventListener('click', function() {
				if(toggleEnabledPopoverMethodElementTarget.classList.contains('disabled')) {
					toggleEnabledPopover.enable();
					toggleEnabledPopover.innerHTML = 'Target';
					toggleEnabledPopoverMethodElementTarget.classList.remove('disabled');
				}
				else {
					toggleEnabledPopover.disable();
					toggleEnabledPopover.innerHTML = 'Disabled';
					toggleEnabledPopoverMethodElementTarget.classList.add('disabled');
				}
			});
		}
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentPopoverCustomHeaderColor();
            _componentPopoverCustomBackgroundColor();
            _componentPopoverEvents();
            _componentPopoverMethods();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    Popovers.init();
});
