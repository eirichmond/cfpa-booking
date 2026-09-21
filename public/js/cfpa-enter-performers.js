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

		function range(start, end)
		{

		    var array = new Array();
		    for(var i = start; i <= end; i++)
		    {
		        array.push(i);
		    }
		    return array;
		}

		function check_multiple_entrants() {
			var entrantsLoop = $('.additional-entrant');

			if(entrantsLoop.length >= 1) {
				$("#add-to-basket").hide();
				load_live();
				return;
			} else {
				$("#add-to-basket").show();
			}
		}

		function entrantsCount(dataMinValue, dataMaxValue){
			var errors = document.getElementById('errors');
			var entrants = [];
			var mainPerformer = 1;

			var entrantsLoop = $('.additional-entrant');
			for(var i = 1; i <= entrantsLoop.length; i++) {
				var inx = i;
				--inx;
				var entrant = entrantsLoop.eq(inx);
				if(entrant.val()) {
					entrants.push(entrant.val());
				}
			}
			var totalPerformers = mainPerformer + entrants.length;
			if(totalPerformers >= dataMinValue && totalPerformers <= dataMaxValue) {
				$("#add-to-basket").show();
				errors.style.display = 'none';
			} else {
				$("#add-to-basket").hide();
				errors.style.display = 'block';
				errors.innerHTML = 'all performers must be submitted for this class';
			}

		}

		function load_live() {
			$('.additional-entrant').on('change', function(){
				var selectedOption = $(this).find('option:selected');
				var dataMinValue = selectedOption.data('min');
				var dataMaxValue = selectedOption.data('max');
				entrantsCount(dataMinValue, dataMaxValue);
			});

		}




/*
		$('#additiona-entrant-1').on('change', function(){
			console.log('this was changed');
		});

		$('#additiona-entrant-2').on('change', function(){
			console.log('this was changed');
		});

		$('#additiona-entrant-3').on('change', function(){
			console.log('this was changed');
		});
*/


		function retrievePerformers(user_id, classid) {
			// create a function to post the id
			$.post(
				Retrieve_Performers.ajaxurl,
				{
					// wp ajax action
					action : 'retrieve_eligible_performers',
					classid : classid,
					user_id : user_id,
					nextNonce : Retrieve_Performers.nextNonce

				},

				function (response) {

					/*
					console.dir(response);
*/

					var entrantsLoop = range(2,JSON.parse(response).loop);
					var child_id = JSON.parse(response).child_id;
					var children = JSON.parse(response).children;

/*
					console.log( entrantsLoop );
					console.log( child_id );
					console.log( children );
*/

					$.each(entrantsLoop, function(i, val) {

						//$('#additiona-entrant-' + val).append('<option value="'+child_id[i]+'">'+children[i]+'</option>');

/*
						$('#additiona-entrant-' + val).on('change', function(){
							$( "#child-entrant-id-" + val ).val( child_id[i] );
						});
*/

/*
						$("#entrant-" + val).autocomplete({
							source: children,
							select: function( event, ui ){

								//console.log( event );
								//console.log( ui );

								$( "#child-entrant-id-" + val ).val( child_id[getKeyByValue(children, ui.item.label)] );


								$(this).focusout(function() {
									if ($(this).hasClass('qualified') && $(this).val() != '') {
										$("#add-to-basket").show();
									} else {
										$("#add-to-basket").hide();
									}
								});
							}
						});
*/

					});
					//console.log( response );

					//$('#additional-entrants').html(response);

					// var MaxEntrants = JSON.parse(response).max;
					// console.log(MaxEntrants);
					//

					// once the min is met or the max is met show the add to basket button
					//$("#add-to-basket").show();
				}
			);
		}

		function checkMinMaxEntrance(classid, child_id) {
			$('#loading-data').show();
			var user_id = $('#user-id').val();

			// create a function to post the id
			$.post(
				Check_Min_Max.ajaxurl,
				{
					// wp ajax action
					action : 'check_min_max_entrants',
					classid : classid,
					user_id : user_id,
					child_id : child_id,
					nextNonce : Check_Min_Max.nextNonce

				},

				function (response) {

					// console.log(JSON.parse(response));

					$('#additional-entrants').html(response);
					retrievePerformers(user_id, classid);



					// var MaxEntrants = JSON.parse(response).max;
					// console.log(MaxEntrants);
					//

					// once the min is met or the max is met show the add to basket button
					$('#loading-data').hide();
					check_multiple_entrants();
				}
			);

		}

		function getKeyByValue(object, value) {

/*
			console.log(object);
			console.log(Object.keys(object));
			console.log(value);
*/
			for(var key in object) {
			    if(object[key] === value) {
			        // do stuff with key
			       return key;
			    }
			}

			// new return due to ipad issue an syntax errors
			//console.log(Object.keys(object)[Object.values(object).indexOf(value)]);
			//return Object.keys(object)[Object.values(object).indexOf(value)];
			//return Object.keys(object).find(key => object[key] === value);
		}

		function getAllQualifiedClasses(classes, classCat) {
			debugger;
			if (classes) {
				if (classCat) {
					var classCat = classCat;
				} else {
					var classCat = 'all';
				}
				var qclasses = classes[classCat];
				var qclasses = $.map(qclasses, function(value, index) {
				    return [value];
				});

				//console.log(qclasses);

				$( "#classes" ).autocomplete({
					source: qclasses,
					select: function (event, ui) {
						var classid = getKeyByValue(classes['all'], ui.item.label);
						var child_id = $( '#children' ).val();
						$( "#class-id" ).val( classid );
						checkMinMaxEntrance(classid, child_id);
					}
				});
			} else {
				// autocomplete initialized to avoid error output
				$( "#classes" ).autocomplete();
				$( "#add-to-basket").hide();
				$( "#child-id" ).attr('value','');
				$( "#class-id" ).attr('value','');
				$( "#classes" ).autocomplete( "destroy" ).attr('value','');

			}
		}


		function getAllQualifiedGroupClasses(classes, classCat) {

			if (classes) {
				if (classCat) {
					var classCat = classCat;
				} else {
					var classCat = 'all';
				}
				var qclasses = classes[classCat];
				var qclasses = $.map(qclasses, function(value, index) {
				    return [value];
				});

				//console.log(qclasses);

				$( "#groupclasses" ).autocomplete({
					source: qclasses,
					select: function( event, ui ){
						var classid = getKeyByValue(classes['all'], ui.item.label);
						$( "#group-class-id" ).val( classid );
						$("#add-group-to-basket").show();


						//checkMinMaxEntrance(classid);
					}
				});
			} else {
				// autocomplete initialized to avoid error output
				$( "#groupclasses" ).autocomplete();
				//$( "#add-to-basket").hide();
				$( "#group-id" ).attr('value','');
				$( "#group-class-id" ).attr('value','');
				$( "#groupclasses" ).autocomplete( "destroy" ).attr('value','');

			}
		}


		//$('#loaded-data').hide();
		$("#add-to-basket").hide();
		$("#add-group-to-basket").hide();


		// refactored based on new selecting of performer

		$( "#children" ).on('change',function() {

			$('#loading-data').show();

			$( "#classes" ).prop('disabled', true);
			$('#class-cat').val('');

			var the_child_id = $(this).val();

			if ( !isNaN(the_child_id) && the_child_id !== "" ) {
				$( "#child-id" ).val( the_child_id );

				$.post(
					Get_Children.ajaxurl,
					{
						// wp ajax action
						action : 'get_qualifying_classes_by_id',
						child_id : the_child_id,
						nextNonce : Get_Children.nextNonce

					},

					function( response ) {

						var error = response.error;
						var classes = response.classes;
						var classCat = $('#class-cat').val();

						if(error) {
							$('#loaded-data').hide();
							$('#loaded-group-data').hide();
							$('#loading-data').hide();
							$('#errors').show().html(error);
						} else {
							getAllQualifiedClasses(classes, classCat);
							$('#loading-data').hide();

							$('#class-cat').on('change', function() {

								$('#loading-data').show();

								$( "#classes" ).prop('disabled', false);

								var classCat = $(this).val();
								var childname = $('#children').val();


								if (childname == null || childname == '') {
									alert('Select a child first.');
									$('#class-cat').val('');
								} else {

									if (classCat) {
										getAllQualifiedClasses(classes, classCat);

									}
								}
								$('#loading-data').hide();
							});
						}


					}
				);
			} else {
				$('#loading-data').hide();
				getAllQualifiedClasses();
			}
		});


		// refactored based on new logic
/*
		$.post(
			Get_Children.ajaxurl,
			{
				// wp ajax action
				action : 'get_children',
				nextNonce : Get_Children.nextNonce

			},

			function( response ) {

				console.log(response);

				$('#loading-data').hide();
				$('#loaded-data').show();

				//console.log( JSON.parse(response) );

				var child_id = JSON.parse(response).child_id;
				var children = JSON.parse(response).children;
				var classes = JSON.parse(response).classes;

			    $( "#children" ).autocomplete({
					source: children,
					select: function( event, ui ){


						$( "#children" ).val( ui.item.label );
						$( "#child-id" ).val( child_id[getKeyByValue(children, ui.item.label)] );

						return false;

					}
			    });

				$( "#children" ).focusout(function() {

					$( "#classes" ).prop('disabled', true);

					var childname = $(this).val();

					var the_child_id = child_id[getKeyByValue(children, childname)];

					if (the_child_id) {

						//$("#classes").hide();

						$.post(
							Get_Children.ajaxurl,
							{
								// wp ajax action
								action : 'get_qualifying_classes_by_id',
								child_id : the_child_id,
								nextNonce : Get_Children.nextNonce

							},

							function( response ) {

								console.log( JSON.parse(response) );
								//console.log( response );

								//$("#classes").show();

								$( "#classes" ).prop('disabled', false);

								var classes = JSON.parse(response).classes;
								var classCat = $('#class-cat').val();

								//console.log(classCat);

								getAllQualifiedClasses(classes, classCat);

								$('#class-cat').on('change', function() {

									var classCat = $(this).val();
									var childname = $('#children').val();

									if (childname == null || childname == '') {
										alert('Select a child first.');
										$('#class-cat').val('');
									} else {
										if (classCat) {
											getAllQualifiedClasses(classes, classCat);
										}
									}
								});

							}
						);
					} else {
						getAllQualifiedClasses();
					}
				});

				$( "#classes" ).focusout(function() {

					var classvalue = $(this).val();

					if (classvalue == null || classvalue == '') {
						$("#add-to-basket").hide();
						$( "#class-id" ).attr('value','');
					}


				});

			}
		);
*/

		function check_group_numbers(group_id) {

			$.post(
				Check_Group_Numbers.ajaxurl,
				{
					// wp ajax action
					action : 'check_group_numbers',
					nextNonce : Check_Group_Numbers.nextNonce,
					group_id : group_id
				},

				function( response ) {
					if(response === false) {
						$( "#group-entry" ).html('<a href="/cfpa-user/add-performer/" class="error">Note: Update the number of members in this Group to continue.</a>');
					}
				}
			);

		}

		$.post(
			Get_Groups.ajaxurl,
			{
				// wp ajax action
				action : 'get_groups',
				nextNonce : Get_Groups.nextNonce

			},

			function( response ) {
				$('#loaded-group-data').show();
				//console.log( JSON.parse(response) );
				var group_id = JSON.parse(response).group_id;
				var group = JSON.parse(response).group;
				var classes = JSON.parse(response).classes;

			    $( "#group" ).autocomplete({
					source: group,
					select: function( event, ui ){


						$( "#group" ).val( ui.item.label );
						var group_id_key_value = $( "#group-id" ).val( group_id[getKeyByValue(group, ui.item.label)] );
						check_group_numbers(group_id_key_value[0].value);

						return false;

					}
			    });

				$( "#group" ).on( 'change',function() {
					$('#loading-data').show();
					var the_group_id = $(this).val();
					if (the_group_id) {
						$('#group-id').val(the_group_id);
						$.post(
							Get_Groups.ajaxurl,
							{
								// wp ajax action
								action : 'get_qualifying_group_classes_by_id',
								group_id : the_group_id,
								nextNonce : Get_Groups.nextNonce

							},

							function( response ) {

								//console.log( JSON.parse(response) );
								//console.log( response );

								//$("#classes").show();

								var classes = JSON.parse(response).classes;
								var classCat = $('#group-class-cat').val();

								getAllQualifiedGroupClasses(classes, classCat);

								$('#loading-data').hide();

								$('#group-class-cat').on('change', function() {


									var classCat = $(this).val();
									var groupname = $('#group').val();

									if (groupname == null || groupname == '') {
										alert('Select a child first.');
										$('#class-cat').val('');
									} else {
										if (classCat) {
											getAllQualifiedGroupClasses(classes, classCat);
										}
									}
								});

							}
						);
					} else {
						getAllQualifiedGroupClasses();
					}
				});

/*
				$( "#classes" ).focusout(function() {

					var classvalue = $(this).val();

					if (classvalue == null || classvalue == '') {
						$("#add-to-basket").hide();
						$( "#class-id" ).attr('value','');
					}

				});
*/
			}
		);


	});




})( jQuery );
