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
		var importcsv = $('.import-csv');


		$('.widget_nav_menu .leader').prepend(
			'<i class="fa fa-user" aria-hidden="true"></i> '
		);

		$('.success').delay(1000).animate({ opacity: 0.25, height: "toggle", paddingTop: 0, paddingBottom: 0, marginBottom: 0  }, 600);

		/*
		 * a function to toggle n hide
		 * @param divClass a trigger class
		 * @param divToggle a toggle ID
		 * @param divHide array of ID's to hide
		 */
		function toggle_slidenhide(divClass,divToggle,divHide) {
			$('.'+divClass).on('click', function(){
				$('#'+divToggle).slideToggle();
				$.each(divHide, function(i,val){
					$('#'+val).css({display:'none'});
				});
			});
		}

		/**
		 * get month number from string
		 */
		function getMonthFromString(mon){
			return new Date(Date.parse(mon +" 1, 2012")).getMonth()+1
		}

		/**
		 * calculate the age by dob
		 */
		function calculate_age(dob) {
			var date = new Date();

			var dobMonth = dob.getMonth();
			if(dobMonth < 8) {
				date.setFullYear( date.getFullYear() - 1 );
			}

			var diff_ms = date - dob.getTime();

			var age_dt = new Date(diff_ms);


			return Math.abs(age_dt.getUTCFullYear() - 1970);
		}

		/**
		 * 
		 * @param {*} dob 
		 * @returns 
		 */
		function calculate_age_sept_school_year(dob) {
			var date = new Date();
			var yearNow = date.getFullYear();
			var theMonth = date.getMonth();
			// as we hit Jan in the new year and before Sept, change the previous year to check
			if(theMonth < 8){
				yearNow = date.setFullYear( date.getFullYear() - 1 );
			}
			var august = date.setMonth(7);
			var lastDay = date.setDate(31);

			var diff_ms = date - dob.getTime();

			var age_dt = new Date(diff_ms);
			return Math.abs(age_dt.getUTCFullYear() - 1970);
		}


		/**
		 * is the performer over sixteen
		 */
		function isPerformerOverSixteen(dobDate, dobMonth, dobYear) {
			var dobDate = parseInt(dobDate, 10);
			var dobMonth = parseInt(dobMonth, 10);
			var dobYear = parseInt(dobYear, 10);

			var ageAtSeptSchoolYear = calculate_age(new Date(dobYear, dobMonth, dobDate));

			return ageAtSeptSchoolYear;

		}

		function isPerformerOverSixteenAsOfSeptFirst(dobDate, dobMonth, dobYear) {
			var dobDate = parseInt(dobDate, 10);
			var dobMonth = parseInt(dobMonth, 10);
			var dobYear = parseInt(dobYear, 10);

			var ageAtSeptSchoolYear = calculate_age_sept_school_year(new Date(dobYear, dobMonth, dobDate));

			return ageAtSeptSchoolYear;

		}

		toggle_slidenhide('add-group-trig','addgroup-form',['addchildren-form','addchild-form']);
		toggle_slidenhide('add-child-trig','addchild-form',['addchildren-form','addgroup-form']);
		toggle_slidenhide('add-children-trig','addchildren-form',['addchild-form','addgroup-form']);

		$('#addchild-form').submit(function(event) {
			const placeOfEducation = event.target[1].value;
			const dobDate = $( "select.select_child_dob_date" ).val();
			const dobMonth = $( "select.select_child_dob_month" ).val();
			var dobMonthNumber = getMonthFromString(dobMonth); --dobMonthNumber;
			const dobYear = $( "select.select_child_dob_year" ).val();
			const ageAtSeptSchoolYear = isPerformerOverSixteen(dobDate, dobMonthNumber, dobYear);

			if (ageAtSeptSchoolYear < 16) {
				if(placeOfEducation === '') {
					alert('This performer\'s date of birth requires that a "Place of Eduction" is also provided.');
					return false; // return false to cancel form action
				}
			} else {
				$('.input_child_school').prop('required',false);
			}
		});

		$('#addchild-form .select-field select').on('change', function(){
			const placeOfEducation = $(this)[0].form[4].value;
			const dobDate = $(this)[0].form[1].value;
			const dobMonth = $(this)[0].form[2].value;
			var dobMonthNumber = getMonthFromString(dobMonth); --dobMonthNumber;
			const dobYear = $(this)[0].form[3].value;
			// const ageAtSeptSchoolYear = isPerformerOverSixteen(dobDate, dobMonthNumber, dobYear);
			const ageAtSeptSchoolYear = isPerformerOverSixteenAsOfSeptFirst(dobDate, dobMonthNumber, dobYear);
			console.log(ageAtSeptSchoolYear);
			if (ageAtSeptSchoolYear > 16) {
				$(this)[0].form[4].closest('div').style.display = "none";
				$(this)[0].form[4].required = false;
				$(this)[0].form[5].closest('div').style.display = "none";
				$(this)[0].form[5].required = false;
			} else {
				$(this)[0].form[4].closest('div').style.display = "block";
				$(this)[0].form[4].required = true;
				$(this)[0].form[5].closest('div').style.display = "block";
				$(this)[0].form[5].required = true;
			}

			// const placeOfEducation = event.currentTarget.form[4].value;
			// const dobDate = event.currentTarget.form[1].value;
			// const dobMonth = event.currentTarget.form[2].value;
			// var dobMonthNumber = getMonthFromString(dobMonth); --dobMonthNumber;
			// const dobYear = event.currentTarget.form[3].value;
			// const ageAtSeptSchoolYear = isPerformerOverSixteen(dobDate, dobMonthNumber, dobYear);
			// console.log(ageAtSeptSchoolYear);
			// if (ageAtSeptSchoolYear > 17) {
			// 	event.currentTarget.form[4].style.display = "none";
			// 	event.currentTarget.form[5].style.display = "none";
			// } else {
			// 	event.currentTarget.form[4].style.display = "block";
			// 	event.currentTarget.form[5].style.display = "block";
			// }

		});


		$('.import-csv').on('click', function(){
			$('.import-loading').show();
		});

		$('.editchild-id').on('click', function(e){
			e.preventDefault();
			var childID = $(this).data('child_id');
			var formData = $( '#editchild-' + childID ).serializeArray();
			const placeOfEducation = formData[4].value;
			
			const dobDate = formData[1].value;
			const dobMonth = formData[2].value;
			var dobMonthNumber = getMonthFromString(dobMonth); --dobMonthNumber;
			const dobYear = formData[3].value;
			const ageAtSeptSchoolYear = isPerformerOverSixteenAsOfSeptFirst(dobDate, dobMonthNumber, dobYear);

			if (ageAtSeptSchoolYear > 16) {
				$("#update-performer-"+childID).prop("disabled", false);
			} else {
				if(!placeOfEducation) {
					$("#update-performer-"+childID).prop("disabled", true);
				} else {
					$("#update-performer-"+childID).prop("disabled", false);
				}
			}
			
			$( '#editchild-' + childID ).slideToggle();
		});

		$('.editgroup-id').on('click', function(e){
			e.preventDefault();
			var form = $(this).data('group_id');
			$( '#editgroup-' + form ).slideToggle();
		});

		function switchnswap(theSwitch, theSwap) {
			$('.'+theSwitch+' a').click(function(e){
				e.preventDefault();
			    $('#'+theSwitch+'').animate({ left: '0px'});
			    $('#'+theSwap+'').animate({ left: '9999px'});
			});
		}

		switchnswap('reg-school', 'reg-independ');
		switchnswap('reg-independ', 'reg-school');

/*
		$(".reg-school a").click(function(){
		    $("#reg-school").animate({left: '0px'});
		    $("#reg-independ").animate({left: '-800px'});
		});

		$(".reg-independ a").click(function(){
		    $("#reg-independ").animate({left: '0px'});
		    $("#reg-school").animate({left: '-800px'});
		});
*/
		$("#register").validate({

			rules: {
				salutation: "required",
				first_name: "required",
				last_name: "required",
				user_position: "required",
				address_1: "required",
				town: "required",
				city: "required",
				postcode: "required",
				telephone: "required",
			},
			messages: {
				salutation: "Please enter your Salutation",
				first_name: "Please enter your First Name",
				last_name: "Please enter your Last Name",
				user_position: "Please select your role",
				address_1: "Please enter at least Address 1",
				town: "Please enter your town",
				city: "Please enter your city or county",
				postcode: "Please enter your Postcode",
				telephone: "Please enter your Telephone",
			}

		});

		if(jQuery.browser.mobile) {
			$('.leader').on('click', function(){
				$(this).next().slideToggle();
			});
		} else {
		}

		



	});




})( jQuery );
