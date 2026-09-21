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
	   	$('i.remove-item').on('click',function(event){
			
			$('#totals').empty();
			$('#go-to-checkout').remove();
			$('.totals-loading-data').show();
			
			var loader = $(this).parent().parent().parent().next('.loading-data');
			var item = $(this).parent().parent().parent();
			
			var basket_id = $(this).parent().parent().parent().data('basket-id');
			var class_id = $(this).parent().parent().parent().attr('id');
			var user_id = $(this).parent().parent().parent().data('user-id');
			var basket_item_key = $(this).parent().parent().parent().data('basket-item-key');
			
			loader.show();
			item.hide();
			$('#alert-'+class_id).hide();
			
			$.post(
				Remove_From_Basket.ajaxurl,
				{
					// wp ajax action
					action : 'remove_from_basket',
					basket_id : basket_id,
					user_id : user_id,
					basket_item_key : basket_item_key,
					nextNonce : Remove_From_Basket.nextNonce
					
				},
							
				function( response ) {
					
					loader.hide();
					$('#totals').replaceWith(response);
					$('.totals-loading-data').hide();
/*
					$('#loading-data').hide();
					$("#add-to-basket").hide();
					$('#loaded-data').show();
					$('#cfpabasket').replaceWith(response);
*/
					
				}
				
			);
			
		});
		
	});

	 
	 

})( jQuery );
