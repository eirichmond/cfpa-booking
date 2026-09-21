<?php
$public_class = new CFPA_Booking_System_Public('cfpa booking system', '1.0.2');
$pages = $public_class->public_pages();

//var_dump($pages);

get_header(); ?>
<div class="cfparow">
	<div class="section group">

		<div class="col span_4_of_12">

			<?php if ( is_active_sidebar( 'account-booking' ) ) : ?>
				<?php dynamic_sidebar( 'account-booking' ); ?>
			<?php endif; ?>


		</div>

		<div class="col span_8_of_12">

			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

			<?php if (false == $public_class->entries_closed()) { ?>

				<?php $howtopage = get_page(5241); ?>
				<?php if ($howtopage) { ?>
					<h3><?php echo esc_html( $howtopage->post_title ); ?></h3>
					<?php echo apply_filters( 'the_content', $howtopage->post_content ); ?>

					<?php if(current_user_can('administrator')) {
						edit_post_link( __( 'Edit this content', 'textdomain' ), '<p>', '</p>', $howtopage->ID, 'btn btn-primary btn-edit-post-link' );
					} ?>

				<?php } ?>


				<!-- <h1>Your Account</h1>

				<p>This is where you can manage your account and enter performers and groups.  Teachers entering a large number of performers should
download and complete a <a href="https://www.cheltenhamfestivalofperformingarts.co.uk/wp-content/uploads/2020/01/Multiple-Entries-Form.xlsx">Multiple Entries Form</a> and email it to the appropriate Section Secretary:<br>
<a href="mailto:dance@cheltenhamfestivalofperformingarts.co.uk">dance@cheltenhamfestivalofperformingarts.co.uk</a><br>
<a href="mailto:speechdrama@cheltenhamfestivalofperformingarts.co.uk">speechdrama@cheltenhamfestivalofperformingarts.co.uk</a><br>
<a href="mailto:music@cheltenhamfestivalofperformingarts.co.uk">music@cheltenhamfestivalofperformingarts.co.uk</a>
</p> -->

				<!-- <div class="section group">
					<div class="col span_4_of_12">
						<div class="block mh180">
							<p class="leaders"><a href="<?php echo esc_attr( $pages['profile']['slug'] );?>">Profile</a></p>
							<p>This is where you can keep your contact details up to date.  We will use these details to contact you about your entry so please ensure they are correct.</p>
						</div>
					</div>

					<div class="col span_4_of_12">
						<div class="block mh180">
							<p class="leaders"><a href="<?php echo esc_attr( $pages['add-performer']['slug'] );?>">Add Children</a></p>
							<p>Add the details for any children before you complete your entry.</p>
						</div>
					</div>

					<div class="col span_4_of_12">
						<div class="block mh180">
							<p class="leaders"><a href="<?php echo esc_attr( $pages['enter-performer']['slug'] );?>">Enter Classes</a></p>
							<p>Once all other details are correct you can complete your entry, go to checkout and pay any fees.</p>
						</div>
					</div>
				</div> -->




			<?php } else { ?>

				<?php $howtopage = get_page(5239); ?>
				<?php if ($howtopage) { ?>
					<h3><?php echo esc_html( $howtopage->post_title ); ?></h3>
					<?php echo apply_filters( 'the_content', $howtopage->post_content ); ?>

					<?php if(current_user_can('administrator')) {
						edit_post_link( __( 'Edit this content', 'textdomain' ), '<p>', '</p>', $howtopage->ID, 'btn btn-primary btn-edit-post-link' );
					} ?>
				<?php } ?>

			<?php } ?>



		</div>


	</div>
</div>

<?php get_footer(); ?>