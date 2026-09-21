<?php


if ( ! isset( $_POST['purchase_nonce'] ) || ! wp_verify_nonce( $_POST['purchase_nonce'], 'purchase_cfpa' ) ) {

	wp_die( 'Sorry, your nonce did not verify.');

} else {

   $public_class = new CFPA_Booking_System_Public('CFPA_Booking_System_Public', '1.0.2');
   $public_class->process_cfpa_payment($_POST);

}


/*
$public_class = new CFPA_Booking_System_Public('CFPA_Booking_System_Public', '1.0.2');

$user_id = get_current_user_id();

$baskets = $public_class->get_users_basket($user_id);

unset($baskets['basket_id']);

var_dump($baskets);

$stripe = $public_class->get_stripe_test();

$userinfo = get_userdata(get_current_user_id());
*/

get_header(); ?>


<div class="cfparow">
	<div class="section group">
		<div class="col span_2_of_12"></div>

		<div class="col span_8_of_12">

			<?php while ( have_posts() ) : the_post(); ?>

				<div class="checkout">

					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

					<div class="entry-content">
						<?php the_content(); ?>
					</div>


				</div>


			<?php endwhile; ?>


		</div>

	</div>
</div>

<?php get_footer(); ?>