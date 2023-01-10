/* ------------------------------------------------------------------------------
 *
 *  # Tooltips
 *
 *  Demo JS code for components_tooltips.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const Tooltips = function () {


    //
    // Setup module components
    //

    // Custom tooltip color
    const _componentTooltipCustomColor = function() {
		const customTooltipElement = document.querySelector('[data-bs-popup=tooltip-custom]');
		if(customTooltipElement) {
			new bootstrap.Tooltip(customTooltipElement, {
				customClass: 'tooltip-custom',
				template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow border-teal"></div><div class="tooltip-inner bg-teal text-white"></div></div>'
			});
		}
    };

    // Tooltip events
    const _componentTooltipEvents = function() {

    	// Elements
		const onShowTooltipElement = document.querySelector('#tooltip-show');
		const onShownTooltipElement = document.querySelector('#tooltip-shown');
		const onHideTooltipElement = document.querySelector('#tooltip-hide');
		const onHiddenTooltipElement = document.querySelector('#tooltip-hidden');

		// onShow event
		if(onShowTooltipElement) {
			const onShowTooltip = new bootstrap.Tooltip(onShowTooltipElement, {
				title: 'Tooltip title',
				trigger: 'click'
			});

			onShowTooltipElement.addEventListener('show.bs.tooltip', function() {
				alert('onShow event fired.');
			});
		}

		// onShown event
		if(onShownTooltipElement) {
			const onShownTooltip = new bootstrap.Tooltip(onShownTooltipElement, {
				title: 'Tooltip title',
				trigger: 'click'
			});

			onShownTooltipElement.addEventListener('shown.bs.tooltip', function() {
				alert('onShown event fired.');
			});
		}

		// onHide event
		if(onHideTooltipElement) {
			const onHideTooltip = new bootstrap.Tooltip(onHideTooltipElement, {
				title: 'Tooltip title',
				trigger: 'click'
			});

			onHideTooltipElement.addEventListener('hide.bs.tooltip', function() {
				alert('onHide event fired.');
			});
		}

		// onHidden event
		if(onHiddenTooltipElement) {
			const onHiddenTooltip = new bootstrap.Tooltip(onHiddenTooltipElement, {
				title: 'Tooltip title',
				trigger: 'click'
			});

			onHiddenTooltipElement.addEventListener('hidden.bs.tooltip', function() {
				alert('onHidden event fired.');
			});
		}
    };

    // Tooltip methods
    const _componentTooltipMethods = function() {

    	// Elements
    	const showTooltipMethodElementTarget = document.querySelector('#show-tooltip-method-target');
    	const hideTooltipMethodElementTarget = document.querySelector('#hide-tooltip-method-target');
    	const toggleTooltipMethodElementTarget = document.querySelector('#toggle-tooltip-method-target');
    	const disposeTooltipMethodElementTarget = document.querySelector('#dispose-tooltip-method-target');
    	const toggleEnabledTooltipMethodElementTarget = document.querySelector('#toggle-enabled-tooltip-method-target');

		// Show method
		if(showTooltipMethodElementTarget) {
			const showTooltip = new bootstrap.Tooltip(showTooltipMethodElementTarget);

			document.querySelector('#show-tooltip-method').addEventListener('click', function() {
				showTooltip.show();
			});
		}

		// Hide method
		if(hideTooltipMethodElementTarget) {
			const hideTooltip = new bootstrap.Tooltip(hideTooltipMethodElementTarget);

			// Show on hover
			document.querySelector('#hide-tooltip-method').addEventListener('mouseenter', function() {
				hideTooltip.show();
			});

			// Hide on click
			document.querySelector('#hide-tooltip-method').addEventListener('click', function() {
				hideTooltip.hide();
			});
		}

		// Toggle method
		if(toggleTooltipMethodElementTarget) {
			const toggleTooltip = new bootstrap.Tooltip(toggleTooltipMethodElementTarget);

			document.querySelector('#toggle-tooltip-method').addEventListener('click', function() {
				toggleTooltip.toggle();
			});
		}

		// Dispose method
		if(disposeTooltipMethodElementTarget) {
			const disposeTooltip = new bootstrap.Tooltip(disposeTooltipMethodElementTarget);

			// Show on hover
			document.querySelector('#dispose-tooltip-method').addEventListener('mouseenter', function() {
				disposeTooltip.show();
			});

			document.querySelector('#dispose-tooltip-method').addEventListener('click', function() {
				disposeTooltip.dispose();
				disposeTooltipMethodElementTarget.innerHTML = 'Disposed';
				disposeTooltipMethodElementTarget.classList.add('disabled');
				this.classList.add('disabled');
			});
		}

		// Toggle enable method
		if(toggleEnabledTooltipMethodElementTarget) {
			const toggleEnabledTooltip = new bootstrap.Tooltip(toggleEnabledTooltipMethodElementTarget);

			document.querySelector('#toggle-enabled-tooltip-method').addEventListener('click', function() {
				if(toggleEnabledTooltipMethodElementTarget.classList.contains('disabled')) {
					toggleEnabledTooltip.enable();
					toggleEnabledTooltip.innerHTML = 'Target';
					toggleEnabledTooltipMethodElementTarget.classList.remove('disabled');
				}
				else {
					toggleEnabledTooltip.disable();
					toggleEnabledTooltip.innerHTML = 'Disabled';
					toggleEnabledTooltipMethodElementTarget.classList.add('disabled');
				}
			});
		}
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentTooltipCustomColor();
            _componentTooltipEvents();
            _componentTooltipMethods();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    Tooltips.init();
});
