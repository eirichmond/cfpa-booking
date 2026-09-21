(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	 
	 $(function() {
		// Place your administration-specific JavaScript here
		$('.remove-child').on('click',function(e){
			
			var child_id = $(this).attr('data-child_id');
			var remove_div = $(this).attr('data-remove');
			
			var r = confirm('Please confirm you wish to remove this performer from the account?');
			e.preventDefault();
			if (r == true) {
				$.post(
					Remove_Child.ajaxurl,
					{
						// wp ajax action
						action : 'remove_child',
						child_id : child_id,
						remove : remove_div,
						nextNonce : Remove_Child.nextNonce
						
					},
								
					function( response ) {
						console.log( response );
					}
				);
				$('#'+remove_div).delay(300).animate({ opacity: 0.25, height: "toggle", paddingTop: 0, paddingBottom: 0, marginBottom: 0  }, 600);
				//$('#'+remove_div).remove();
			}
		});
		 
		$('.remove-group').on('click',function(e){
			var group_id = $(this).attr('data-group_id');
			var remove_div = $(this).attr('data-remove');
			
			var r = confirm('Please confirm you wish to remove this group from the account?');
			e.preventDefault();
			if (r == true) {
				$.post(
					Remove_Group.ajaxurl,
					{
						// wp ajax action
						action : 'remove_group',
						group_id : group_id,
						remove : remove_div,
						nextNonce : Remove_Group.nextNonce
						
					},
								
					function( response ) {
						console.log( response );
					}
				);
				$('#'+remove_div).delay(300).animate({ opacity: 0.25, height: "toggle", paddingTop: 0, paddingBottom: 0, marginBottom: 0  }, 600);
				//$('#'+remove_div).remove();
			}
		});
		 
	 });

	 
	 

})( jQuery );
