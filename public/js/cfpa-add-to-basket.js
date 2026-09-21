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


	   	$('#add-to-basket').on('click',function(event){
			event.preventDefault();
/*
			$('#loading-data').show();
			$('#loaded-data').hide();
*/

			$('#children').val('');
			$('#class-cat').val('');
			$('#classes').val('');

			var xchildren = [];
/*
			$(":input[class^=xchild]").each(function(index, element) {
				xchildren.push($(this).val());
			});
*/

			$('.additional-entrant').each(function(index, element) {
				xchildren.push($(this).val());
			});
			console.log(xchildren);



			var child_id = $('#child-id').val();
			var class_id = $('#class-id').val();
			var user_id = $('#user-id').val();
			var tutor_teacher = $('input[name="tutor_teacher"]').val();

			$.post(
				Add_To_Basket.ajaxurl,
				{
					// wp ajax action
					action : 'add_to_basket',
					class_id : class_id,
					user_id : user_id,
					child_id : child_id,
					xchildren : xchildren,
					tutor_teacher : tutor_teacher,
					nextNonce : Add_To_Basket.nextNonce

				},

				function( response ) {
					//console.log(response);
					$('#loading-data').hide();
					$("#add-to-basket").hide();
					$('#loaded-data').show();
					$('#cfpabasket').replaceWith(response);
					$('#additional-entrants').empty();
					$('input[name="tutor_teacher"]').val('');
					// Place your administration-specific JavaScript here
				   	$('i.remove-item').on('click',function(event){

						$('#totals').empty();
						$('#go-to-checkout').remove();
						$('.totals-loading-data').show();

						var loader = $(this).parent().parent().parent().next('.loading-data');
						var item = $(this).parent().parent().parent();

						var basket_id = $(this).parent().parent().parent().data('basket-id');
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
								//console.log(response);

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

				}

			);

		});

	   	$('#add-group-to-basket').on('click',function(event){
			event.preventDefault();
			$('#loading-data').show();
			$('#loaded-data').hide();

			$('#group').val('');
			//$('#class-cat').val('');
			$('#groupclasses').val('');

			var xchildren = [];
			$(":input[class^=xchild]").each(function(index, element) {
				xchildren.push($(this).val());
			});

			var group_id = $('#group-id').val();
			var group_class_id = $('#group-class-id').val();
			var user_id = $('#user-id').val();

			$.post(
				Add_Group_To_Basket.ajaxurl,
				{
					// wp ajax action
					action : 'add_group_to_basket',
					group_class_id : group_class_id,
					user_id : user_id,
					group_id : group_id,
					nextNonce : Add_Group_To_Basket.nextNonce

				},

				function( response ) {
					//console.log(response);
					$('#loading-data').hide();
					$("#add-to-basket").hide();
					$("#add-group-to-basket").hide();

					$('#loaded-data').show();
					$('#cfpabasket').replaceWith(response);
					$('#additional-entrants').empty();
					// Place your administration-specific JavaScript here
				   	$('i.remove-item').on('click',function(event){

						$('#totals').empty();
						$('#go-to-checkout').remove();
						$('.totals-loading-data').show();

						var loader = $(this).parent().parent().parent().next('.loading-data');
						var item = $(this).parent().parent().parent();

						var basket_id = $(this).parent().parent().parent().data('basket-id');
						var user_id = $(this).parent().parent().parent().data('user-id');
						var basket_item_key = $(this).parent().parent().parent().data('basket-item-key');

						loader.show();
						item.hide();
						//$('#alert-'+class_id).hide();

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
								//console.log(response);
								debugger;
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

				}

			);


		});

		$('#prog-quant').on('change', function(e){
			e.preventDefault();
			var programe_quantity = $(this).val();
			var add_programe_button = $('#add-programmes-to-basket');
			if (programe_quantity >= 1) {
				add_programe_button.show();
			} else {
				add_programe_button.hide();
			}
		});

	   	$('#add-programmes-to-basket').on('click',function(event){
			event.preventDefault();
			var add_programe_button = $('#add-programmes-to-basket');
			var prog_quant = $('#prog-quant').val();
			var user_id = $('#prog-user-id').val();


			$('#prog-quant').val('');
			$.post(
				Add_Programme_To_Basket.ajaxurl,
				{
					// wp ajax action
					action : 'add_programme_to_basket',
					// vars
					user_id : user_id,
					prog_quant : prog_quant,
					nextNonce : Add_Programme_To_Basket.nextNonce

				},

				function( response ) {

					console.log(response);

					add_programe_button.hide();
					$('#cfpabasket').replaceWith(response);
					$('#loading-data').hide();
					$("#add-to-basket").hide();
					$('#loaded-data').show();
					$('#additional-entrants').empty();
					// Place your administration-specific JavaScript here
				   	$('i.remove-item').on('click',function(event){

						$('#totals').empty();
						$('#go-to-checkout').remove();
						$('.totals-loading-data').show();

						var loader = $(this).parent().parent().parent().next('.loading-data');
						var item = $(this).parent().parent().parent();

						var basket_id = $(this).parent().parent().parent().data('basket-id');
						var user_id = $(this).parent().parent().parent().data('user-id');
						var basket_item_key = $(this).parent().parent().parent().data('basket-item-key');

						loader.show();
						item.hide();
						//$('#alert-'+class_id).hide();

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
								//console.log(response);

								loader.hide();
								$('#totals').replaceWith(response);
								$('.totals-loading-data').hide();

							}

						);

					});
				}

			);


		});

	});




})( jQuery );
