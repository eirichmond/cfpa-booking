<?php
$public_class = new CFPA_Booking_System_Public('cfpa booking system', '1.0.2');

$public_class->process_form();

$children_profiles = $public_class->children_profile_inputs_fields();

$group_profiles = $public_class->group_profile_inputs_fields();


$user_id = get_current_user_id();



if (user_can($user_id, 'multiple')) {
	$is_school = true;
}

$entries_closes = false;

get_header(); ?>

<div class="cfparow">
	<div class="section group">
		<div class="col span_3_of_12">

			<?php if ( is_active_sidebar( 'account-booking' ) ) : ?>
				<?php dynamic_sidebar( 'account-booking' ); ?>
			<?php endif; ?>

		</div>
		<div class="col span_9_of_12">

			<?php while ( have_posts() ) : the_post(); ?>

				<div class="user-profile block">

					<?php if (false == $entries_closes) { ?>

					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

					<div class="entry-content">
						<?php the_content(); ?>
					</div>

					<?php if (isset($_GET) && $_GET['childadded'] == true) { ?>
						<div class="success">
							<p>Performer was successfully added!</p>
						</div>
					<?php } ?>

					<?php if (isset($_GET) && $_GET['childrenadded'] == true) { ?>
						<div class="success">
							<p>Performers were successfully added!</p>
						</div>
					<?php } ?>

					<?php if (isset($_GET) && $_GET['groupadded'] == true) { ?>
						<div class="success">
							<p>Group was successfully added!</p>
						</div>
					<?php } ?>

					<?php if (isset($_GET) && $_GET['childedit'] == true) { ?>
						<div class="success">
							<p>Performers details have been successfully updated!</p>
						</div>
					<?php } ?>

					<?php if (isset($_GET) && $_GET['groupedit'] == true) { ?>
						<div class="success">
							<p>Group was updated successfully!</p>
						</div>
					<?php } ?>

					<?php if (isset($_GET) && $_GET['upload'] == true) { ?>
						<div class="error">
							<p>Error! Either there was no file attached to upload or the file was not a .csv, please try again.</p>
						</div>
					<?php } ?>


					<?php if ($public_class->get_users_children($user_id)) {  ?>

						<div class="section group phead">
							<div class="col span_2_of_12">Performers Name</div>
							<div class="col span_2_of_12">Place of Education</div>
							<div class="col span_3_of_12">DOB</div>
							<div class="col span_3_of_12">Registered</div>
							<div class="col span_1_of_12">Edit</div>
							<div class="col span_1_of_12">Delete</div>
						</div>


							<?php foreach ($public_class->get_users_children($user_id) as $child) { $array = (array)$child; ?>

								<div id="child-id-<?php echo $child->child_id; ?>" class="section group">
									<div class="col span_2_of_12 child_name"><?php echo esc_html($child->child_name); ?></div>
									<div class="col span_2_of_12 child_school"><?php echo esc_html($child->child_school); ?></div>
									<div class="col span_3_of_12 child_dob"><?php echo esc_html(date('jS M Y', strtotime($child->child_dob))); ?></div>
									<div class="col span_3_of_12 registered_date"><?php echo esc_html(date('jS M Y', strtotime($child->registered_date))); ?></div>
									<div class="col span_1_of_12 editchild"><a href="#" class="editchild-id" data-child_id="<?php echo esc_attr($child->child_id); ?>"><i class="fa fa-pencil-square fa-2x" aria-hidden="true"></i></a></div>
									<div class="col span_1_of_12 removechild"><a href="#" class="remove-child" data-child_id="<?php echo esc_attr($child->child_id); ?>" data-remove="child-id-<?php echo $child->child_id; ?>"><i data-child_id="<?php echo esc_attr($child->child_id); ?>" class="fa fa-minus-circle fa-2x" aria-hidden="true"></i></a></div>
								</div>

								<form id="editchild-<?php echo esc_attr($child->child_id); ?>" class="innerform" method="post" action="?childedit=1" style="display: none;" >

									<div id="loading-data-<?php echo esc_attr($child->child_id); ?>" class="loadingdata" style="display:none;">
										Please Wait... <i class="fa fa-cog fa-spin fa-2x fa-fw" aria-hidden="true"></i>
									</div>

									<div class="edit-container">

										<div class="section group">

											<?php foreach($children_profiles as $profile) { ?>

												<?php if ($profile['key'] == 'child_name') { ?>
													<div class="input-field col span_12_of_12">
														<label class="" for="<?php echo esc_attr($profile['key']); ?>"><?php echo esc_html($profile['label']); ?></label>
														<input class="input_<?php echo esc_attr($profile['key']); ?>" type="<?php echo esc_attr($profile['type']); ?>" name="<?php echo esc_attr($profile['key']); ?>" placeholder="<?php echo esc_attr($profile['label']); ?>" value="<?php echo esc_attr($array[$profile['key']]); ?>" <?php if($profile['required']) { echo esc_attr('required'); } ?>>
													</div>
												<?php } ?>

												<?php if ($profile['type'] == 'select') { ?>

													<?php if ($profile['key'] == 'child_dob_date') { ?>
														<div class="first-section col span_4_of_12">
															<label class="" for="<?php echo esc_attr($profile['key']); ?>"><?php echo esc_html($profile['label']); ?></label>
															<div class="select-field">
															<select name="<?php echo esc_html($profile['key']); ?>">

																<option disabled>Select date</option>
																<option value="01" <?php selected( $child->child_d, '01'); ?>>1</option>
																<option value="02" <?php selected( $child->child_d, '02'); ?>>2</option>
																<option value="03" <?php selected( $child->child_d, '03'); ?>>3</option>
																<option value="04" <?php selected( $child->child_d, '04'); ?>>4</option>
																<option value="05" <?php selected( $child->child_d, '05'); ?>>5</option>
																<option value="06" <?php selected( $child->child_d, '06'); ?>>6</option>
																<option value="07" <?php selected( $child->child_d, '07'); ?>>7</option>
																<option value="08" <?php selected( $child->child_d, '08'); ?>>8</option>
																<option value="09" <?php selected( $child->child_d, '09'); ?>>9</option>
																<option value="10" <?php selected( $child->child_d, '10'); ?>>10</option>
																<option value="11" <?php selected( $child->child_d, '11'); ?>>11</option>
																<option value="12" <?php selected( $child->child_d, '12'); ?>>12</option>
																<option value="13" <?php selected( $child->child_d, '13'); ?>>13</option>
																<option value="14" <?php selected( $child->child_d, '14'); ?>>14</option>
																<option value="15" <?php selected( $child->child_d, '15'); ?>>15</option>
																<option value="16" <?php selected( $child->child_d, '16'); ?>>16</option>
																<option value="17" <?php selected( $child->child_d, '17'); ?>>17</option>
																<option value="18" <?php selected( $child->child_d, '18'); ?>>18</option>
																<option value="19" <?php selected( $child->child_d, '19'); ?>>19</option>
																<option value="20" <?php selected( $child->child_d, '20'); ?>>20</option>
																<option value="21" <?php selected( $child->child_d, '21'); ?>>21</option>
																<option value="22" <?php selected( $child->child_d, '22'); ?>>22</option>
																<option value="23" <?php selected( $child->child_d, '23'); ?>>23</option>
																<option value="24" <?php selected( $child->child_d, '24'); ?>>24</option>
																<option value="25" <?php selected( $child->child_d, '25'); ?>>25</option>
																<option value="26" <?php selected( $child->child_d, '26'); ?>>26</option>
																<option value="27" <?php selected( $child->child_d, '27'); ?>>27</option>
																<option value="28" <?php selected( $child->child_d, '28'); ?>>28</option>
																<option value="29" <?php selected( $child->child_d, '29'); ?>>29</option>
																<option value="30" <?php selected( $child->child_d, '30'); ?>>30</option>
																<option value="31" <?php selected( $child->child_d, '31'); ?>>31</option>

															</select>
															</div>
														</div>
													<?php } ?>

													<?php if ($profile['key'] == 'child_dob_month') { ?>
														<div class="col span_4_of_12">
															<label class="" for="<?php echo esc_attr($profile['key']); ?>"><?php echo esc_html($profile['label']); ?></label>
															<div class="select-field">
															<select name="<?php echo esc_html($profile['key']); ?>">

																<option disabled>Select Month</option>
																<option value="01" <?php selected( $child->child_m, '01'); ?>>Jan</option>
																<option value="02" <?php selected( $child->child_m, '02'); ?>>Feb</option>
																<option value="03" <?php selected( $child->child_m, '03'); ?>>Mar</option>
																<option value="04" <?php selected( $child->child_m, '04'); ?>>Apr</option>
																<option value="05" <?php selected( $child->child_m, '05'); ?>>May</option>
																<option value="06" <?php selected( $child->child_m, '06'); ?>>Jun</option>
																<option value="07" <?php selected( $child->child_m, '07'); ?>>Jul</option>
																<option value="08" <?php selected( $child->child_m, '08'); ?>>Aug</option>
																<option value="09" <?php selected( $child->child_m, '09'); ?>>Sep</option>
																<option value="10" <?php selected( $child->child_m, '10'); ?>>Oct</option>
																<option value="11" <?php selected( $child->child_m, '11'); ?>>Nov</option>
																<option value="12" <?php selected( $child->child_m, '12'); ?>>Dec</option>

															</select>
															</div>
														</div>
													<?php } ?>

													<?php if ($profile['key'] == 'child_dob_year') { $years = $profile['options']; ?>
														<div class="col span_4_of_12">
															<label class="" for="<?php echo esc_attr($profile['key']); ?>"><?php echo esc_html($profile['label']); ?></label>
															<div class="select-field">
															<select name="<?php echo esc_html($profile['key']); ?>">

																<option disabled>Select Year</option>
																<?php foreach($years as $year) { ?>
																	<option value="<?php echo $year; ?>" <?php selected( $child->child_y, $year); ?>><?php echo $year; ?></option>
																<?php } ?>

															</select>
															</div>
														</div>
													<?php } ?>

												<?php } ?>


												<?php if ($profile['key'] == 'child_school') { ?>

													<div class="input-field first-section col span_6_of_12">
														<label class="" for="<?php echo esc_attr($profile['key']); ?>"><?php echo esc_html($profile['label']); ?></label>
														<input class="input_<?php echo esc_attr($profile['key']); ?>" type="<?php echo esc_attr($profile['type']); ?>" name="<?php echo esc_attr($profile['key']); ?>" placeholder="<?php echo esc_attr($profile['label']); ?>" value="<?php echo esc_attr($array[$profile['key']]); ?>" <?php if($profile['required']) { echo esc_attr('required'); } ?>>
														<label style="color:red;font-wieght:bold;">Please select from the list which shortens as you type.  Please enter and select 'Home schooled' or 'No longer in school' or 'School not listed' if any of these apply.</label>
													</div>

												<?php } ?>

												<?php if ($profile['key'] == 'parent_email') { ?>

													<div class="input-field col span_6_of_12">
														<label class="" for="<?php echo esc_attr($profile['key']); ?>"><?php echo esc_html($profile['label']); ?></label>
														<input class="input_<?php echo esc_attr($profile['key']); ?>" type="<?php echo esc_attr($profile['type']); ?>" name="<?php echo esc_attr($profile['key']); ?>" placeholder="<?php echo esc_attr($profile['label']); ?>" value="<?php echo esc_attr($array[$profile['key']]); ?>" <?php if($profile['required']) { echo esc_attr('required'); } ?>>
													</div>

												<?php } ?>


											<?php } ?>
										</div>

										<input type="hidden" class="input_child_school_id" name="input_child_school_id" value="<?php echo esc_attr($child->child_school_id); ?>">
										<input type="hidden" name="child_id" value="<?php echo esc_attr($child->child_id); ?>">
										<input type="hidden" name="action" value="edit-child">
										<input type="hidden" name="user_id" value="<?php echo esc_attr($user_id); ?>">

										<?php wp_nonce_field( 'front_end_post', 'front_end_post_nonce' ); ?>

										<div class="performer-notices">

											<div class="performer-notice child-licence-<?php echo esc_attr($child->child_id); ?>" style="display:none;">
												<?php echo esc_html( $public_class->child_licence_notice_text() ); ?>
												<label for="child-licence-agreed">
													<input type="checkbox" id="child-licence-<?php echo esc_attr($child->child_id); ?>-agreed" name="child_licence_agreed" value="1">
													<?php echo esc_html( $public_class->child_licence_notice_checkbox_label() ); ?>
												</label>
											</div>

											<div class="performer-notice headmaster-approval-<?php echo esc_attr($child->child_id); ?>" style="display:none;">
												<?php echo esc_html( $public_class->headmaster_approval_notice_text() ); ?>
												<label for="headmaster-approval-agreed">
													<input type="checkbox" id="headmaster-approval-<?php echo esc_attr($child->child_id); ?>-agreed" name="headmaster_approval_agreed" value="1">
													<?php echo esc_html( $public_class->headmaster_approval_notice_checkbox_label() ); ?>
												</label>
											</div>

										</div>

										<input id="update-performer-<?php echo esc_attr($child->child_id); ?>" type="submit" name="submit" class="button button-primary" value="Update Performer">

									</div>


								</form>

							<?php } ?>

					<?php } ?>


					<h4 class="add-child-trig button button-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add a Performer</h4>

					<!-- <?php if ($is_school == true || user_can($user_id, 'administrator')) { ?>
						<h4 class="add-children-trig button button-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add multiple Performers</h4>
					<?php } ?> -->

					<form id="addchild-form" style="position:relative;" method="post" action="?childadded=1" >

						<div id="loading-data-0" class="loadingdata" style="display:none;">
							Please Wait... <i class="fa fa-cog fa-spin fa-2x fa-fw" aria-hidden="true"></i>
						</div>

						<div class="edit-container">
							<div class="section group">

								<?php foreach($children_profiles as $profile) {  ?>


									<?php if ($profile['key'] == 'child_name') { ?>
										<div class="input-field col span_12_of_12">
											<label class="" for="<?php echo esc_attr($profile['key']); ?>"><?php echo esc_html($profile['label']); ?></label>
											<input class="input_<?php echo esc_attr($profile['key']); ?>" type="<?php echo esc_attr($profile['type']); ?>" name="<?php echo esc_attr($profile['key']); ?>" placeholder="<?php echo esc_attr($profile['label']); ?>" value="<?php echo get_the_author_meta( $profile['key'], $user_id ); ?>"<?php $public_class->check_user_position_field_requirement($profile['type'], $user_id); ?> <?php if($profile['required']) { echo esc_attr('required'); } ?>>
										</div>
									<?php } ?>


									<?php if ($profile['type'] == 'select') { ?>

										<?php if ($profile['key'] == 'child_dob_date') { ?>
											<div class="first-section col span_4_of_12">
												<label class="" for="<?php echo esc_attr($profile['key']); ?>"><?php echo esc_html($profile['label']); ?></label>
												<div class="select-field">
												<select class="select_<?php echo esc_html($profile['key']); ?>" name="<?php echo esc_html($profile['key']); ?>" required>
													<option value="" selected disabled>Select an option</option>
													<?php foreach($profile['options'] as $key => $value) { ?>
														<option value="<?php echo esc_attr($value); ?>"<?php //if ( get_the_author_meta( $profile['key'], $user_id ) == $key ) echo 'selected="selected"'; ?>><?php echo esc_attr($value); ?></option>
													<?php } ?>

												</select>
												</div>
											</div>
										<?php } ?>

										<?php if ($profile['key'] == 'child_dob_month') { ?>
											<div class="col span_4_of_12">
												<label class="" for="<?php echo esc_attr($profile['key']); ?>"><?php echo esc_html($profile['label']); ?></label>
												<div class="select-field">
												<select class="select_<?php echo esc_html($profile['key']); ?>" name="<?php echo esc_html($profile['key']); ?>" required>
													<option value="" selected disabled>Select an option</option>
													<?php foreach($profile['options'] as $key => $value) { ?>
														<option value="<?php echo esc_attr($value); ?>"<?php //if ( get_the_author_meta( $profile['key'], $user_id ) == $key ) echo 'selected="selected"'; ?>><?php echo esc_attr($value); ?></option>
													<?php } ?>

												</select>
												</div>
											</div>
										<?php } ?>

										<?php if ($profile['key'] == 'child_dob_year') { $years = $profile['options']; ?>
											<div class="col span_4_of_12">
												<label class="" for="<?php echo esc_attr($profile['key']); ?>"><?php echo esc_html($profile['label']); ?></label>
												<div class="select-field">
												<select class="select_<?php echo esc_html($profile['key']); ?>" name="<?php echo esc_html($profile['key']); ?>" required>
													<option value="" selected disabled>Select an option</option>
													<?php foreach($profile['options'] as $key => $value) { ?>
														<option value="<?php echo esc_attr($value); ?>"<?php //if ( get_the_author_meta( $profile['key'], $user_id ) == $key ) echo 'selected="selected"'; ?>><?php echo esc_attr($value); ?></option>
													<?php } ?>

												</select>
												</div>

											</div>
										<?php } ?>


									<?php } ?>

									<?php if ($profile['key'] == 'child_school') { ?>
										<div class="input-field first-section col span_6_of_12">
											<label class="" for="<?php echo esc_attr($profile['key']); ?>"><?php echo esc_html($profile['label']); ?></label>
											<input class="input_<?php echo esc_attr($profile['key']); ?>" type="<?php echo esc_attr($profile['type']); ?>" name="<?php echo esc_attr($profile['key']); ?>" placeholder="<?php echo esc_attr($profile['label']); ?>" value="<?php echo get_the_author_meta( $profile['key'], $user_id ); ?>"<?php $public_class->check_user_position_field_requirement($profile['type'], $user_id); ?> <?php if($profile['required']) { echo esc_attr('required'); } ?>>
											<label style="color:red;font-wieght:bold;">Please select from the list which shortens as you type. Please enter and select 'Home schooled' or 'No longer in school' or 'School not listed' if any of these apply.</label>
										</div>
									<?php } ?>

									<?php if ($profile['key'] == 'parent_email') { ?>
										<div class="input-field col span_6_of_12">
											<label class="" for="<?php echo esc_attr($profile['key']); ?>"><?php echo esc_html($profile['label']); ?></label>
											<input class="input_<?php echo esc_attr($profile['key']); ?>" type="<?php echo esc_attr($profile['type']); ?>" name="<?php echo esc_attr($profile['key']); ?>" placeholder="<?php echo esc_attr($profile['label']); ?>" value="<?php echo get_the_author_meta( $profile['key'], $user_id ); ?>"<?php $public_class->check_user_position_field_requirement($profile['type'], $user_id); ?> <?php if($profile['required']) { echo esc_attr('required'); } ?>>
										</div>
									<?php } ?>

								<?php } ?>

							</div>


							<input type="hidden" name="action" value="add-child">
							<input type="hidden" class="input_child_school_id" name="input_child_school_id" value="">
							<input type="hidden" name="user_id" value="<?php echo esc_attr($user_id); ?>">

							<?php wp_nonce_field( 'front_end_post', 'front_end_post_nonce' ); ?>







							<div class="performer-notices">

								<div class="performer-notice child-licence-0" style="display:none;">
									<?php echo esc_html( $public_class->child_licence_notice_text() ); ?>
									<label for="child-licence-agreed">
										<input type="checkbox" id="child-licence-0-agreed" name="child_licence_agreed" value="1">
										<?php echo esc_html( $public_class->child_licence_notice_checkbox_label() ); ?>
									</label>
								</div>

								<div class="performer-notice headmaster-approval-0" style="display:none;">
									<?php echo esc_html( $public_class->headmaster_approval_notice_text() ); ?>
									<label for="headmaster-approval-agreed">
										<input type="checkbox" id="headmaster-approval-0-agreed" name="headmaster_approval_agreed" value="1">
										<?php echo esc_html( $public_class->headmaster_approval_notice_checkbox_label() ); ?>
									</label>
								</div>

							</div>



							<input type="submit" name="submit" id="add-performer" class="button button-primary" value="Confirm Performer">

						</div>

					</form>



					<?php //if ($is_school == true || user_can($user_id, 'administrator')) { ?>


						<?php if ($public_class->get_users_groups($user_id)) {  ?>

							<?php //$public_class->get_users_groups($user_id); ?>
							<?php foreach ($public_class->get_users_groups($user_id) as $group) {  ?>

								<div id="group-id-<?php echo $group->group_id; ?>" class="section group">
								<div class="col span_4_of_12"><?php echo esc_html($group->group_name); ?></div>
								<div class="col span_4_of_12">Group Numbers: <?php echo esc_html($group->group_number); ?></div>
								<div class="col span_2_of_12"><?php echo esc_html(date('jS M Y', strtotime($group->registered_date))); ?></div>
								<div class="col span_1_of_12"><a href="#" class="editgroup-id" data-group_id="<?php echo esc_attr($group->group_id); ?>"><i class="fa fa-pencil-square fa-2x" aria-hidden="true"></i></a></div>
								<div class="col span_1_of_12"><a href="#" class="remove-group" data-group_id="<?php echo esc_attr($group->group_id); ?>" data-remove="group-id-<?php echo $group->group_id; ?>"><i data-group_id="<?php echo esc_attr($group->group_id); ?>" class="fa fa-minus-circle fa-2x" aria-hidden="true"></i></a></div>
								</div>

								<form id="editgroup-<?php echo esc_attr($group->group_id); ?>" class="innerform" method="post" action="?groupedit=1" style="display: none;" >
									<div class="section group">

									<?php foreach($group_profiles as $profile) {  ?>

											<?php if ($profile['type'] == 'text') { ?>

												<div class="input-field col span_6_of_12">
													<label class="" for="<?php echo esc_attr($profile['key']); ?>"><?php echo esc_html($profile['label']); ?></label>
													<input type="<?php echo esc_attr($profile['type']); ?>" name="<?php echo esc_attr($profile['key']); ?>" placeholder="<?php echo esc_attr($profile['placeholder']); ?>" value="<?php echo esc_attr($group->group_name); ?>">
												</div>

											<?php } ?>

											<?php if ($profile['type'] == 'number') { ?>

												<div class="input-field col span_6_of_12">
													<label class="" for="<?php echo esc_attr($profile['key']); ?>"><?php echo esc_html($profile['label']); ?></label>
													<input type="<?php echo esc_attr($profile['type']); ?>" name="<?php echo esc_attr($profile['key']); ?>" placeholder="<?php echo esc_attr($profile['placeholder']); ?>" value="<?php echo esc_attr($group->group_name); ?>">
												</div>

											<?php } ?>

									<?php } ?>
									</div>

									<input type="hidden" name="group_id" value="<?php echo esc_attr($group->group_id); ?>">
									<input type="hidden" name="action" value="edit-group">
									<input type="hidden" name="user_id" value="<?php echo esc_attr($user_id); ?>">

									<?php wp_nonce_field( 'front_end_post', 'front_end_post_nonce' ); ?>

									<input type="submit" name="submit" id="submit" class="button button-primary" value="Update Group">

								</form>

							<?php } ?>

						<?php } ?>

						<h4 class="add-group-trig button button-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add a Group</h4>


						<form id="addgroup-form" method="post" action="?groupadded=1">
							<div class="section group">

								<?php foreach($group_profiles as $profile) {  ?>
									<?php if ($profile['type'] == 'text') { ?>
										<div class="input-field col span_6_of_12">
											<label class="" for="<?php echo esc_attr($profile['key']); ?>"><?php echo esc_html($profile['label']); ?></label>
											<input type="<?php echo esc_attr($profile['type']); ?>" name="<?php echo esc_attr($profile['key']); ?>" placeholder="<?php echo esc_attr($profile['placeholder']); ?>" value="">
										</div>
									<?php } ?>
									<?php if ($profile['type'] == 'number') { ?>
										<div class="input-field col span_6_of_12">
											<label class="" for="<?php echo esc_attr($profile['key']); ?>"><?php echo esc_html($profile['label']); ?></label>
											<input type="<?php echo esc_attr($profile['type']); ?>" name="<?php echo esc_attr($profile['key']); ?>" placeholder="<?php echo esc_attr($profile['placeholder']); ?>" required>
										</div>
									<?php } ?>
								<?php } ?>
							</div>

							<input type="hidden" name="action" value="add-group">
							<input type="hidden" name="user_id" value="<?php echo esc_attr($user_id); ?>">

							<?php wp_nonce_field( 'front_end_post', 'front_end_post_nonce' ); ?>

							<input type="submit" name="submit" id="submit" class="button button-primary" value="Confirm Group">

						</form>



					<?php // } ?>


				<?php } else { ?>

						<h1>The on-line entry system for the 2019 Festival is now closed</h1>

<!--
						<p>If you missed the deadline but would like to enter the Festival please contact the Section Secretary who will let you know if your entry can be accepted.</p>

						<p><strong>Speech & Drama:</strong><br>Ginny Burge (Tel: 07843 499262)<br><a href="mailto:<?php echo antispambot( 'speechdrama@cheltenhamfestivalofperformingarts.co.uk' ); ?>"><?php echo antispambot( 'speechdrama@cheltenhamfestivalofperformingarts.co.uk' ); ?></a></p>

						<p><strong>Music:</strong><br>David Terry (Tel: 01242 7000000)<br><a href="mailto:<?php echo antispambot( 'music@cheltenhamfestivalofperformingarts.co.uk' ); ?>"><?php echo antispambot( 'music@cheltenhamfestivalofperformingarts.co.uk' ); ?></a></p>

						<p><strong>Dance:</strong><br>Carol McDowall (Tel: 01242 514582)<br><a href="mailto:<?php echo antispambot( 'dance@cheltenhamfestivalofperformingarts.co.uk' ); ?>"><?php echo antispambot( 'dance@cheltenhamfestivalofperformingarts.co.uk' ); ?></a></p>
-->

				<?php } ?>


				</div>


			<?php endwhile; ?>


		</div>
	</div>
</div>

<?php get_footer(); ?>
