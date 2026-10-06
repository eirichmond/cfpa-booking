<?php

$public_class = new CFPA_Booking_System_Public('CFPA_Booking_System_Public', '1.0.2');
$payment_result = '';

if ( isset( $_GET['session_id'] ) ) {

	// returning from Stripe's payment page
	$payment_result = $public_class->complete_stripe_checkout( sanitize_text_field( wp_unslash( $_GET['session_id'] ) ) );

} elseif ( ! isset( $_POST['purchase_nonce'] ) || ! wp_verify_nonce( $_POST['purchase_nonce'], 'purchase_cfpa' ) ) {

	wp_die( 'Sorry, your nonce did not verify.');

} elseif ( isset( $_POST['pay_by_card'] ) ) {

	// redirects to Stripe's payment page
	$public_class->start_stripe_checkout( $_POST );

} else {

	// pay on account
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
						<?php if ( $payment_result === 'error' ) { ?>
							<div class="danger alert">
								<p>Sorry, we could not confirm your payment. If your card has been charged your entry is safe, but please email <a href="mailto:info@cfpa.org.uk">info@cfpa.org.uk</a> so we can check it for you. Otherwise please return to <a href="/cfpa-user/checkout/">checkout</a> and try again.</p>
							</div>
						<?php } else {
							the_content();
						} ?>
					</div>


				</div>


			<?php endwhile; ?>


		</div>

	</div>
</div>

<?php get_footer(); ?>