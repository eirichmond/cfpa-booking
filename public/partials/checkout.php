<?php

global $cfpa;

$public_class = new CFPA_Booking_System_Public('CFPA_Booking_System_Public', '1.0.2');

// a mechanism for testing the email notification add the invoice post id as a param to test
// $public_class->notify_users_of_invoice(412);
//wp_die();

$user_id = get_current_user_id();

// the same calculation start_stripe_checkout() charges
$checkout = $public_class->get_checkout_basket($user_id);
$baskets = $checkout['items'];
$programmes = $checkout['programmes'];
$total = $checkout['total'];


$userinfo = get_userdata(get_current_user_id());
$marketing_permission = get_user_meta(get_current_user_id(), 'marketing_permission', true);

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


					<table class="rounded checkout-items">
						<thead>
							<tr>
								<th>Class</th>
								<th>Entrant</th>
								<th>Cost</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($baskets as $basket) { $basket = $public_class->rendering_group_basket_item($basket); ?>
								<tr>
									<td><?php echo get_post_meta($basket['class_id'], 'class-ref-no', true) . ' - '; if (isset($basket['group_id'])) { echo get_the_title($basket['group_class_id']); } else { echo get_the_title($basket['class_id']); }?></td>
									<td><?php
										if (isset($basket['child_id'])) { echo esc_html($public_class->get_child_by_id($basket['child_id'], 'name')); }
										if (isset($basket['xchildren'])) { echo ', <span>'; $public_class->display_extra_performers($basket['xchildren']); echo '</span>'; }
										if (isset($basket['group_id'])) { echo esc_html($public_class->get_group_by_id($basket['group_id'], 'name')); } ?></td>
									<td class="rt">&pound;<?php echo number_format_i18n($public_class->get_the_class_cost($basket['class_id']), 2); ?></td>
								</tr>
							<?php } ?>


							<?php if ($programmes) { ?>
								<tr>
									<td><?php echo esc_html($programmes['description']); ?></td>
									<td>x <?php echo esc_html($programmes['programmes']); ?></td>
									<td class="rt">&pound;<?php echo number_format_i18n( $programmes['sub_total'],2 ); ?></td>
								</tr>
<!--
								<tr>
									<td>P&P @</td>
									<td></td>
									<td class="rt">&pound;<?php echo number_format_i18n( $programmes['pandp'],2 ); ?></td>
								</tr>
-->
							<?php } ?>


						</tbody>
					</table>

					<table class="rounded checkout-items">
						<tbody>
							<tr>
								<td>Total: </td>
								<td class="rt"><strong>&pound;<?php echo number_format_i18n( $total, 2 ); ?></strong></td>
							</tr>
						</tbody>
					</table>


					<p><i class="icon-check"></i> <?php echo esc_html( $cfpa['consent-text'] ); ?></p><br>

					<div class="option">
						<label for="marketing-permission-checkbox">
							<input type="checkbox" id="marketing-permission-checkbox" name="marketing_permission" value="1" <?php checked( $marketing_permission, '1' ); ?>>
							Please tick here if you do not wish to receive marketing emails from the Festival.
						</label>
					</div>

					<br>

					<div class="option">
						<p><strong>Pay Now</strong> Continue to payment to confirm your entry. In the case of large orders (typically over £200), please select Pay on Account, below.</p>
					</div>

					<?php if ( isset( $_GET['payment'] ) && $_GET['payment'] === 'cancelled' ) { ?>
						<div class="default alert"><p>Payment cancelled, you have not been charged.</p></div>
					<?php } elseif ( isset( $_GET['payment'] ) && $_GET['payment'] === 'error' ) { ?>
						<div class="danger alert"><p>Sorry, the payment could not be started and you have not been charged. Please try again, or email <a href="mailto:info@cfpa.org.uk">info@cfpa.org.uk</a> if this keeps happening.</p></div>
					<?php } ?>

					<form action="/cfpa-user/charge/" method="POST">
					  <input type="hidden" name="pay_by_card" value="1">
					  <?php wp_nonce_field( 'purchase_cfpa', 'purchase_nonce' ); ?>
					  <input type="submit" class="button" value="Pay &pound;<?php echo esc_attr( number_format_i18n( $total, 2 ) ); ?> Now">
					</form>

					<?php if (get_user_meta($user_id, 'pay_by_invoice', true) || current_user_can( 'administrator' )) { ?>

						<div class="option">
							<p><strong>Pay on Account</strong> you can choose to pay later by paying on account, an invoice will be created and sent to the account holder or can be resent to your accounts department once an email address has been provided for them.</p>
						</div>

						<form action="/cfpa-user/charge/" method="post">

							<input type="hidden" name="user_id" value="<?php echo get_current_user_id(); ?>">
							<?php wp_nonce_field( 'purchase_cfpa', 'purchase_nonce' ); ?>
							<div class="poa">
								<input type="submit" value="Pay on account">
							</div>

						</form>
					<?php } ?>


				</div>


			<?php endwhile; ?>


		</div>

	</div>
</div>

<?php get_footer(); ?>
