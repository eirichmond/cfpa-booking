(function ($) {
	"use strict";

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

	$(function () {
		var pivotDate = Schools.pivotDate;

		function calculateAge(dateOfBirth, targetDate) {
			var dob = new Date(dateOfBirth);
			var target = new Date(targetDate);

			var age = target.getFullYear() - dob.getFullYear();

			// Check if the birthday has occurred this year
			if (
				target <
				new Date(target.getFullYear(), dob.getMonth(), dob.getDate())
			) {
				age--;
			}

			return age;
		}

		$(".input_child_school").on("keyup", function () {
			$(".input_child_school_id").val("");
		});

		$(".input_child_school").autocomplete({
			source: function (request, response) {
				// Remove apostrophes from the search term
				let searchTerm = request.term.replace(/'/g, "").toLowerCase();

				// Filter the Schools.schools array based on the cleaned search term
				let results = $.grep(Schools.schools, function (item) {
					// Remove apostrophes from the item label before matching
					let cleanItemLabel = item.label
						.replace(/'/g, "")
						.toLowerCase();
					return cleanItemLabel.includes(searchTerm);
				});

				// Pass the filtered results to the autocomplete response
				response(results);
			},
			change: function (event, ui) {
				if (!ui.item) {
					//http://api.jqueryui.com/autocomplete/#event-change -
					// The item selected from the menu, if any. Otherwise the property is null
					// so clear the item for force selection
					$(".input_child_school").val("");
				}
			},
			select: function (event, ui) {
				var closestForm = $(this).closest("form");
				var childID = closestForm.find('input[name="child_id"]').val();
				var childDobDate = closestForm
					.find('select[name="child_dob_date"]')
					.val();
				var childDobMonth = closestForm
					.find('select[name="child_dob_month"]')
					.val();
				var childDobYear = closestForm
					.find('select[name="child_dob_year"]')
					.val();
				var childDob =
					childDobYear + "-" + childDobMonth + "-" + childDobDate;
				var childAge = calculateAge(childDob, pivotDate);
				if (typeof childID === "undefined") {
					childID = "0";
				}

				$(".child-licence-" + childID).hide();
				$("#child-licence-" + childID + "-agreed").prop(
					"required",
					false
				);
				$(".headmaster-approval-" + childID).hide();
				$("#headmaster-approval-" + childID + "-agreed").prop(
					"required",
					false
				);

				$("#update-performer-" + childID).prop("disabled", true);
				$("#add-performer").prop("disabled", true);

				$(this).val(ui.item.label);
				$(".input_child_school_id").val(ui.item.value);

				$("#loading-data-" + childID).show();
				$(".edit-container").css("opacity", 0.1);
				$.post(
					Schools.ajaxurl,
					{
						// wp ajax action
						action: "check_child_licence_notice",
						childID: childID,
						childAge: childAge,
						schoolID: ui.item.value,
						nextNonce: Schools.nextNonce,
					},
					function (response) {
						if (response.bool) {
							$(".child-licence-" + response.childID).show();
							$(
								"#child-licence-" + response.childID + "-agreed"
							).prop("required", true);
						} else {
							$.post(
								Schools.ajaxurl,
								{
									// wp ajax action
									action: "check_headmaster_approval_notice",
									childID: childID,
									childAge: childAge,
									schoolID: ui.item.value,
									nextNonce: Schools.nextNonce,
								},
								function (response) {
									if (response.bool) {
										$(
											".headmaster-approval-" +
												response.childID
										).show();
										$(
											"#headmaster-approval-" +
												response.childID +
												"-agreed"
										).prop("required", true);
									}
								}
							);
						}
						$("#add-performer").prop("disabled", false);
						$("#update-performer-" + childID).prop(
							"disabled",
							false
						);
						$("#loading-data-" + childID).hide();
						$(".edit-container").css("opacity", 1);
					}
				);

				return false;
			},
		});
	});
})(jQuery);
