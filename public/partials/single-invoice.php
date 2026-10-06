<?php

$public_class = new CFPA_Booking_System_Public('CFPA_Booking_System_Public', '1.0.2');

//$public_class->notify_users_of_invoice($post->ID);



$profile_address = $public_class->get_profile_invoice_address($post->ID);
$cfpa_address = $public_class->get_cfpa_invoice_address();

$user_id = get_current_user_id();

//$baskets = $public_class->get_users_basket($user_id);
$baskets = get_post_meta(get_the_id(), 'inv_item');

// $programmes = get_post_meta(get_the_id(), 'programmes_ordered');

// if ($programmes) {
// 	$programmes['total'] = ($programmes[0] * $public_class->programe_unit_cost());
// }

// $baskets = $public_class->add_programmes_pandp($post->ID,$baskets);

unset($baskets['basket_id']);
// $total = $public_class->get_basket_totals($baskets, $programmes);
$total = $public_class->get_basket_totals_refactored($baskets);

$total = array_sum($total);

$userinfo = get_userdata(get_current_user_id());

$plugincss = plugin_dir_url( dirname(__FILE__)  ) . 'css/cfpa-bookingsystem-public.css';

$profile_address = array_filter($profile_address);

$inv_status = get_post_meta(get_the_id(), 'inv_status', true);
if ($inv_status == 'unpaid') {
	$show_pay_button = true;
} else {
	$show_pay_button = false;
}
?>

<html>
<head>
<meta name="robots" content="noindex, nofollow">
<link type="text/css" rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>">
<link type="text/css" rel="stylesheet" href="<?php echo $plugincss; ?>">
</head>

<body>


<div class="cfparow">
	<div class="section group">
		<div class="col span_2_of_12">
			<img src="<?php echo plugin_dir_url( dirname(__FILE__)  ); ?>images/cfpa.png" alt="cfpa" width="128" height="128" />
		</div>

		<div class="col span_8_of_12">

			<?php while ( have_posts() ) : the_post(); ?>

				<div class="checkout">

					<p><?php echo strtoupper(join(',<br>', $profile_address)); ?></p>

					<?php the_title( '<p><strong>REF:</strong> ', '</p>' ); ?>
					<p><strong>DATE:</strong> <?php echo date('jS M Y', strtotime($post->post_date)); ?></p>


					<div class="entry-content">
						<?php the_content(); ?>
					</div>


					<table class="rounded checkout-items">
						<thead>
							<tr>
								<th style="text-align:left;">Class</th>
								<th style="text-align:left;">Entrant</th>
								<th style="text-align:right;">Cost</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($baskets as $k => $basket) { ?>

								<?php if (is_numeric($k)) { ?>

									<?php if (empty($basket['class_id']) && $basket['class_id'] == '') { ?>
										<tr>
											<td><?php echo esc_html($basket['performers']); ?></td>
											<td></td>
											<td class="rt">&pound;<?php echo number_format_i18n(($basket['cost']/100), 2); ?></td>
										</tr>
									<?php } else { ?>
										<tr>
											<td><?php echo get_post_meta($basket['class_id'], 'class-ref-no', true); ?> - <?php echo get_the_title($basket['class_id']); ?></td>
											<td><?php echo esc_html($basket['performers']); ?></td>
											<td class="rt">&pound;<?php echo number_format_i18n($basket['cost']/100, 2); ?></td>
										</tr>
									<?php } ?>

								<?php } elseif ($k == 'progs') { ?>

									<tr>
										<td><?php echo esc_html($basket['program_quantity']); ?> x</td>
										<td><?php echo esc_html($basket['program_description']); ?></td>
										<td class="rt">&pound;<?php echo number_format_i18n($basket['program_cost']/100, 2); ?></td>
									</tr>

								<?php } ?>

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

					<?php if ($show_pay_button) { ?>

						<?php if ( isset( $_GET['payment'] ) && $_GET['payment'] === 'cancelled' ) { ?>
							<div class="default alert"><p>Payment cancelled, you have not been charged.</p></div>
						<?php } elseif ( isset( $_GET['payment'] ) && $_GET['payment'] === 'error' ) { ?>
							<div class="danger alert"><p>Sorry, the payment could not be started and you have not been charged. Please try again, or email <a href="mailto:info@cfpa.org.uk">info@cfpa.org.uk</a> if this keeps happening.</p></div>
						<?php } ?>

						<form action="/cfpa-user/charge/" method="POST">
							<input type="hidden" name="pay_by_card" value="1">
							<input type="hidden" name="post_id" value="<?php echo esc_attr( get_the_ID() ); ?>">
							<?php wp_nonce_field( 'purchase_cfpa', 'purchase_nonce' ); ?>
							<input type="submit" class="button" value="Pay &pound;<?php echo esc_attr( number_format_i18n( $total, 2 ) ); ?> Now">
						</form>

					<?php } else { ?>
						<p>✅ Invoice paid</p>
					<?php } ?>

				</div>


			<?php endwhile; ?>


		</div>

	</div>

	<div class="section group">
		<div class="col span_12_of_12">
			<p><?php echo join(', ', $cfpa_address); ?></p>
		</div>
	</div>

</div>

</body>
</html>
