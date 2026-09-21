<?php
$public_class = new CFPA_Booking_System_Public('cfpa booking system', '1.0.2');

$terms = get_terms( array( 'taxonomy' => 'class_cat', 'hide_empty' => false ) );
$user_id = get_current_user_id();

$check_performers = $public_class->check_user_has_performers($user_id);

$is_school = false;
if (user_can($user_id, 'multiple')) {
	$is_school = true;
}

$progs = array(1,2,3,4,5,6,7,8,9,10);

$entries_closes = true;


get_header(); ?>

<div class="cfparow">
	<div class="section group">
		<div class="col span_4_of_12">

			<?php if ( is_active_sidebar( 'account-booking' ) ) : ?>
				<?php dynamic_sidebar( 'account-booking' ); ?>
			<?php endif; ?>

		</div>
		<div class="col span_8_of_12">

			<?php while ( have_posts() ) : the_post(); ?>

				<div class="user-profile block">


					<div class="entry-content">
						<?php the_content(); ?>

						<?php //include('temp-eligible-classes.php'); ?>

					</div>

					<?php if (!empty($_GET) && $_GET['updated'] ==  true) { ?>
						<div class="success">
							<p>Your profile was successfully updated!</p>
						</div>
					<?php } ?>


					<?php if (false == $public_class->entries_closed()) { ?>

						<?php /* check if there are any performers first */ if ($check_performers) { $children = $public_class->pre_get_children(); $account_groups = $public_class->pre_get_groups(); ?>

							<form id="loaded-data" method="post" action="?basket-update=1">

								<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

								<p>Click on the 'Performer' arrow below and select your performer from the list.</p>
								<p>Then click on the 'Category' arrow and select either 'Dance', 'Drama', or 'Music'.</p>
								<p>Then click in the 'Class' box and start typing the required class number or class name and select from the list.</p>
								<p>If your selected class is for a duet, trio or quartet, add the names of the additional performers in the boxes below the first listed performer. These additional performers must have already been added using Add/Edit Performer(s) before creating the class entry.</p>
								<p>When it appears, click on <span class="add-child dis" id="add-to-basket dis"><i class="fa fa-plus" aria-hidden="true"></i></span> to add your selection to Your Basket.</p>


								<div id="#" class="section group enter-class">
									<div class="col span_4_of_12">

										<div class="input-field select-field">
											<select id="children" name="childname">
												<option value="" selected>Performer</option>
												<?php foreach ($children as $k => $v) { ?>
													<option value="<?php echo esc_attr( $k );?>"><?php echo esc_html( $v );?></option>
												<?php } ?>
											</select>
										</div>

									</div>
									<div class="col span_3_of_12">
										<div class="input-field select-field">
											<select id="class-cat" name="class-cat">
												<option value="" selected>Category</option>
												<?php foreach ($terms as $term) { ?>
													<option value="<?php echo $term->slug;?>"><?php echo $term->name;?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="col span_3_of_12">

										<div class="input-field">
											<input id="classes" type="text" name="class-ref" placeholder="Class" disabled value="">
										</div>

									</div>
									<div class="col span_2_of_12">

										<a href="#" class="add-child" id="add-to-basket">
											<i class="fa fa-plus" aria-hidden="true"></i>
										</a>

										<div id="loading-data" style="display:none;">
											Please Wait... <i class="fa fa-cog fa-spin fa-2x fa-fw" aria-hidden="true"></i>
										</div>

									</div>
								</div>

								<input id="child-id" type="hidden" value="">
								<input id="class-id" type="hidden" value="">
								<input id="user-id" type="hidden" value="<?php echo $user_id; ?>">

								<div id="additional-entrants" class="section group enter-class">

								</div>

								<div class="section group enter-class">
									<div class="col span_10_of_12">

										<div id="tutor-teacher" class="input-field">
											<p for="class-mentor">Please enter the name of the tutor/teacher for this class, if any (optional)</p>
											<input type="text" id="class-mentor" name="tutor_teacher" placeholder="Tutor/teacher" value="">
										</div>

									</div>
								</div>



							</form>

							<div id="errors" class="error" style="display:none;"></div>

							<?php //  if ($is_school || user_can($user_id, 'administrator')) { ?>

								<form id="loaded-group-data" method="post" action="?basket-update=1" style="display:none;">

								<h1 class="entry-title">Enter Group</h1>
								<p>Click on the 'Group Name' below and follow the same procedure as above.</p>

									<div id="group-entry" class="section group enter-class">

										<div class="col span_4_of_12">
											<div class="input-field select-field">
												<!-- <input id="group" type="text" name="groupname" placeholder="Group Name" value=""> -->


												<select id="group" name="groupname">
													<option value="" selected>Group</option>
													<?php foreach ($account_groups as $k => $v) { ?>
														<option value="<?php echo esc_attr( $k );?>"><?php echo esc_html( $v );?></option>
													<?php } ?>
												</select>



											</div>
										</div>

										<div class="col span_3_of_12">
											<div class="input-field select-field">
												<select id="group-class-cat" name="group-class-cat">
													<option value="" selected>Category</option>
													<?php foreach ($terms as $term) { ?>
														<option value="<?php echo $term->slug;?>"><?php echo $term->name;?></option>
													<?php } ?>
												</select>
											</div>
										</div>

										<div class="col span_3_of_12">

											<div class="input-field">
												<input id="groupclasses" type="text" name="class-ref" placeholder="Class" value="">
											</div>

										</div>
										<div class="col span_2_of_12">

											<a href="#" class="add-group" id="add-group-to-basket">
												<i class="fa fa-plus" aria-hidden="true"></i>
											</a>

										</div>
									</div>


									<input id="group-id" type="hidden" value="">
									<input id="group-class-id" type="hidden" value="">
									<input id="user-id" type="hidden" value="<?php echo $user_id; ?>">

								</form>

							<?php // } ?>

							<!-- <form id="loaded-group-data" method="post" action="?basket-update=1">

								<h1 class="entry-title">Programmes</h1>
								<p>Would you like to add printed programmes to your basket?</p>

								<div id="#" class="section group enter-class">

									<div class="col span_4_of_12">
										<div class="input-field select-field">
											<select id="prog-quant" name="programmes">
												<option value="" selected>Quantity</option>
												<?php foreach ($progs as $prog) { ?>
													<option value="<?php echo esc_attr($prog)?>"><?php echo esc_attr($prog)?></option>
												<?php } ?>
											</select>
										</div>
									</div>

									<div class="col span_2_of_12">

										<a href="#" class="add-programme" id="add-programmes-to-basket" style="display: none">
											<i class="fa fa-plus" aria-hidden="true"></i>
										</a>

									</div>
								</div>

								<input id="prog-user-id" type="hidden" value="<?php echo $user_id; ?>">

							</form> -->

						<?php } /* if not then tell the user */ else { ?>

							<h1>No performers in your account!</h1>
							<p>It doesn't look like you've added any performers yet, you can add performers, including yourself <a href="/add-performer/">here</a></p>

						<?php } ?>

					<?php } else { ?>

						<?php
							echo $public_class->entries_closed_msg();
						?>

					<?php } ?>



				</div>


			<?php endwhile; ?>


		</div>
	</div>
</div>

<?php get_footer(); ?>
