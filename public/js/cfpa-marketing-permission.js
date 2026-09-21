(function( $ ) {
	'use strict';

	/**
	 * Handle marketing permission checkbox AJAX update.
	 *
	 * @since    1.0.2
	 */
	$(function() {
		$('#marketing-permission-checkbox').on('change', function(event) {
			var checkbox = $(this);
			var isChecked = checkbox.is(':checked');
			var permissionValue = isChecked ? 'true' : 'false';
			
			// Disable checkbox during AJAX request
			checkbox.prop('disabled', true);
			
			$.ajax({
				url: Marketing_Permission.ajaxurl,
				type: 'POST',
				data: {
					action: 'update_marketing_permission',
					permission: permissionValue,
					nonce: Marketing_Permission.nextNonce
				},
				success: function(response) {
					if (response.success) {
						// Optionally show a success message
						// You can add a message element here if needed
					} else {
						// Revert checkbox state on error
						checkbox.prop('checked', !isChecked);
						alert('Failed to update marketing permission. Please try again.');
					}
				},
				error: function() {
					// Revert checkbox state on error
					checkbox.prop('checked', !isChecked);
					alert('An error occurred. Please try again.');
				},
				complete: function() {
					// Re-enable checkbox after request completes
					checkbox.prop('disabled', false);
				}
			});
		});
	});

})( jQuery );









