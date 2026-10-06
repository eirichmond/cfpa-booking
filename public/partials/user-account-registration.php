<?php
$public_class = new CFPA_Booking_System_Public('CFPA booking system','1.0.2');

$public_class->process_form();

$profiles = $public_class->user_profile_inputs_fields();
$user_id = get_current_user_id();
$registration_error = CFPA_Booking_System_Public::$registration_error;

// keep what was typed when registration failed
$posted = function( $key ) use ( $registration_error ) {
	return $registration_error && isset( $_POST[ $key ] ) ? wp_unslash( $_POST[ $key ] ) : '';
};

get_header(); ?>


<div class="cfparow">
	<div class="section group">
		<div class="col span_8_of_12">

			<?php while ( have_posts() ) : the_post(); ?>

				<div class="user-profile">

					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

					<p>Please fill in the form below to register your account.</p>

					<hr />

					<div class="entry-content">
						<?php the_content(); ?>
					</div>

					<?php if (isset($_GET) && $_GET['registered'] ==  true) { ?>
						<div class="successreg">
							<p>Thank you for registering!</p>
							<p>Please check your inbox for details on how to login.</p>
							<p>The email may end up in your Junk/ Spam mail folder, so please be sure to check there if it is not in your inbox.</p>
							<p>If you do not receive an email, please contact <a href="mailto:info@cfpa.org.uk">info@cfpa.org.uk</a> for help.</p>
						</div>
					<?php } ?>

					<?php if ( $registration_error ) { ?>
						<div class="danger alert">
							<p><?php echo wp_kses_post( $registration_error ); ?></p>
						</div>
					<?php } ?>

					<div class="register"<?php if (isset($_GET) && $_GET['registered'] ==  true) { ?>style="display:none"<?php } ?>>

						<form id="register" method="post" action="">

							<?php foreach($profiles as $profile) { ?>

									<?php if ($profile['type'] == 'text') {  ?>
									<div class="input-field">
										<input type="<?php echo esc_attr($profile['type']); ?>" name="<?php echo esc_attr($profile['key']); ?>" placeholder="<?php echo esc_attr($profile['label']); ?>" value="<?php echo esc_attr( $posted( $profile['key'] ) ); ?>">
									</div>
									<?php } ?>

									<?php if ($profile['type'] == 'email') { ?>
									<div class="input-field">
										<input class="required" type="<?php echo esc_attr($profile['type']); ?>" name="<?php echo esc_attr($profile['key']); ?>" placeholder="<?php echo esc_attr($profile['label']); ?>" value="<?php echo esc_attr( $posted( $profile['key'] ) ); ?>">
									</div>
									<?php } ?>

									<?php if ($profile['type'] == 'select') { ?>
									<div class="input-field select-field">
										<select name="<?php echo esc_html($profile['key']); ?>">
											<option value="" disabled <?php selected( $posted( $profile['key'] ), '' ); ?>>Select Role</option>
											<?php foreach($profile['options'] as $key => $value) { ?>
												<option value="<?php echo esc_attr($key); ?>" <?php selected( $posted( $profile['key'] ), (string) $key ); ?>><?php echo esc_attr($value); ?></option>
											<?php } ?>

										</select>
									</div>
									<?php } ?>


							<?php } ?>



							<input type="hidden" name="action" value="register-profile">
							<input type="hidden" name="user_id" value="<?php echo esc_attr($user_id); ?>">

							<?php wp_nonce_field( 'front_end_post', 'front_end_post_nonce' ); ?>
							<?php wp_nonce_field( 'add-user', 'add-nonce' ); ?>

							<input type="submit" name="submit" id="submit" class="button button-primary" value="Submit">

						</form>
					</div>


				</div>


			<?php endwhile; ?>


		</div>

	</div>
</div>

<?php get_footer(); ?>
