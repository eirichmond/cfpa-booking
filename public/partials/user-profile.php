<?php
$public_class = new CFPA_Booking_System_Public('cfpa booking system', '1.0.2');

$public_class->process_form();

$profiles = $public_class->user_profile_inputs_fields();
$user_id = get_current_user_id();

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

					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

					<div class="entry-content">
						<?php the_content(); ?>
					</div>

					<?php if (isset($_GET) && $_GET['updated'] ==  true) { ?>
						<div class="success">
							<p>Your profile was successfully updated!</p>
						</div>
					<?php } ?>

					<form method="post" action="?updated=1" >

						<?php foreach($profiles as $profile) { ?>

								<?php if ($profile['type'] == 'text') { ?>
								<div class="input-field">
									<input type="<?php echo esc_attr($profile['type']); ?>" name="<?php echo esc_attr($profile['key']); ?>" placeholder="<?php echo esc_attr($profile['label']); ?>" value="<?php echo get_the_author_meta( $profile['key'], $user_id ); ?>">
								</div>
								<?php } ?>

								<?php if ($profile['type'] == 'email') { ?>
								<div class="input-field">
									<input type="<?php echo esc_attr($profile['type']); ?>" name="<?php echo esc_attr($profile['key']); ?>" placeholder="<?php echo esc_attr($profile['label']); ?>" value="<?php echo get_the_author_meta( $profile['key'], $user_id ); ?>">
								</div>
								<?php } ?>

								<?php if ($profile['type'] == 'select') { ?>
								<div class="input-field select-field">
									<select name="<?php echo esc_html($profile['key']); ?>">

										<?php foreach($profile['options'] as $key => $value) { ?>
											<option value="<?php echo esc_attr($key); ?>"<?php if ( get_the_author_meta( $profile['key'], $user_id ) == $key ) echo 'selected="selected"'; ?>><?php echo esc_attr($value); ?></option>
										<?php } ?>

									</select>
								</div>
								<?php } ?>


						<?php } ?>


						<input type="hidden" name="action" value="update-profile">
						<input type="hidden" name="user_id" value="<?php echo esc_attr($user_id); ?>">

						<?php wp_nonce_field( 'front_end_post', 'front_end_post_nonce' ); ?>

						<input type="submit" name="submit" id="submit" class="button button-primary" value="Update Profile">

					</form>

				</div>


			<?php endwhile; ?>


		</div>
	</div>
</div>

<?php get_footer(); ?>