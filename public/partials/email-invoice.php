<?php

	$post_object = get_post($post_id);
	$user_data = get_userdata($post_object->post_author);

	$invoice_items = get_post_meta($post_id, 'inv_item');

	$invoice_items = $this->add_programmes_pandp($post_id,$invoice_items);
	$invoice_status = get_post_meta($post_id, 'inv_status', true);

	// festival information sent with every order confirmation, paid or on account
	$festival_information = 'Please note that this year, all music tracks for Dance classes must be uploaded to the website between 1st December and 1st April. The timetable of classes will be published on the Festival website on 1st March. Headteacher approval will be required for all under 16 year olds who attend the Festival during the school day. See website for more details.';

	$invoice_message = array(
		'paid' => 'Your payment was completed successfully. ' . $festival_information . ' Below are the details of your order:',
		'unpaid' => 'Your order was completed successfully and an invoice has been created for you to pay on account. ' . $festival_information . ' Below are the details of your order:'
	);


	$totals = $this->get_invoice_totals($invoice_items);

	$admin_email = get_bloginfo('admin_email');

	// Email admin
	$email_to = array($admin_email, $user_data->user_email, 'duncanhooper@msn.com');
	$admin_subject = get_bloginfo('name');

	$admin_body = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/xhtml" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width" />
  </head>
  <body style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; width: 100% !important; height: 100%; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; background: #efefef; margin: 0; padding: 0;" bgcolor="#efefef">
<table class="body-wrap" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; width: 100% !important; height: 100%; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; background: #efefef; margin: 0; padding: 0;" bgcolor="#efefef"><tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;"><td class="container" style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; display: block !important; clear: both !important; max-width: 580px !important; margin: 0 auto; padding: 0;">

            <!-- Message start -->
            <table style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; width: 100% !important; border-collapse: collapse; margin: 0; padding: 0;"><tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;"><td align="center" class="masthead" style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; color: white; background: #000000; margin: 0; padding: 20px 0;" bgcolor="#000000">

                        <img src="'. get_bloginfo('template_url').'/img/cheltenham-festival-of-performing-arts-1.png" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; max-width: 100%; display: block; margin: 0 auto; padding: 0;" /></td>
                </tr><tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;"><td class="content" style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; background: white; margin: 0; padding: 30px 35px;" bgcolor="white">

                        <h2 style="font-size: 28px; font-family: Helvetica, Arial, sans-serif; line-height: 1.25; margin: 0 0 20px; padding: 0;">Hi '. $user_data->user_login.',</h2>

                        <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">'.$invoice_message[$invoice_status].'</p>';



			foreach ($invoice_items as $k => $basket) {
				if(is_numeric($k)) {
					$class_title = get_the_title($basket['class_id']);
					$cost = $basket['cost'] / 100;
					$performers = $basket['performers'];
					$admin_body .= '<table class="rounded checkout-items" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; width: 100% !important; border-collapse: collapse; border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color: #e2e2e2; margin: 0 0 20px; padding: 0;">

					<tbody style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">

						<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">

							<td style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">'.esc_attr($class_title).'</td>
							<td class="rt" style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; text-align: right; margin: 0; padding: 0;" align="right">
								<span class="cost" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">&pound;'.esc_attr($cost).'</span>
							</td>
						</tr>';
					$admin_body .= '
						<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
							<td style="font-size: 12px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">'.esc_attr($performers).'</td>
							<td class="rt" style="font-size: 12px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; text-align: right; margin: 0; padding: 0;" align="right">
								<span class="cost" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;"></span>
							</td>
						</tr>
							';
					$admin_body .= '</tbody></table>';
				} elseif ($k == 'progs') {

					$class_title = $basket['program_quantity'];
					$cost = $basket['program_cost'] / 100;
					$performers = $basket['program_description'];
					$admin_body .= '<table class="rounded checkout-items" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; width: 100% !important; border-collapse: collapse; border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color: #e2e2e2; margin: 0 0 20px; padding: 0;">

					<tbody style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">

						<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">

							<td style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">'.esc_attr($class_title).'</td>
							<td class="rt" style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; text-align: right; margin: 0; padding: 0;" align="right">
								<span class="cost" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">&pound;'.esc_attr($cost).'</span>
							</td>
						</tr>';
					$admin_body .= '
						<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
							<td style="font-size: 12px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">'.esc_attr($performers).'</td>
							<td class="rt" style="font-size: 12px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; text-align: right; margin: 0; padding: 0;" align="right">
								<span class="cost" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;"></span>
							</td>
						</tr>
							';
					$admin_body .= '</tbody></table>';

				}
			}
			$admin_body .= '<table id="checkout-totals" class="rounded checkout-items" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; width: 100% !important; border-collapse: collapse; border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color: #e2e2e2; font-weight: bold; margin: 20px 0; padding: 0;"><tbody style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">';

					$admin_body .= '
					<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;"><td class="rt" style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; text-align: left; margin: 0; padding: 0;" align="right">Total</td>
						<td class="rt" style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; text-align: right; margin: 0; padding: 0;" align="right">&pound;'.esc_attr($totals).'</td>
					</tr></tbody></table><table style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; width: 100% !important; border-collapse: collapse; margin: 0; padding: 0;"><tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;"><td align="center" style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
                                    <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">
                                        <a href="'. get_permalink($post_id) .'" class="button" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; color: white; text-decoration: none; display: inline-block; font-weight: bold; border-radius: 4px; background: #71bc37; margin: 0; padding: 0; border-color: #71bc37; border-style: solid; border-width: 10px 20px 8px;">View the invoice online at '.get_bloginfo('name').'</a>
                                    </p>
                                </td>
                            </tr></table>

                    </td>
                </tr></table></td>
    </tr><tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;"><td class="container" style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; display: block !important; clear: both !important; max-width: 580px !important; margin: 0 auto; padding: 0;">

            <!-- Message start -->
            <table style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; width: 100% !important; border-collapse: collapse; margin: 0; padding: 0;"><tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;"><td class="content footer" align="center" style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; background: white none; margin: 0; padding: 30px 35px;" bgcolor="white">
                        <p style="font-size: 14px; font-family:Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; color: #888; text-align: center; margin: 0; padding: 0;" align="center">Sent by <a href="#" style="font-size: 100%; font-family:Helvetica, Arial, sans-serif; line-height: 1.65; color: #888; text-decoration: none; font-weight: bold; margin: 0; padding: 0;">Cheltenham Festival of Performing Arts</a></p><p style="font-size: 14px; font-family:Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; color: #888; text-align: center; margin: 0; padding: 0;" align="center">Sent by <a href="#" style="font-size: 100%; font-family:Helvetica, Arial, sans-serif; line-height: 1.65; color: #888; text-decoration: none; font-weight: bold; margin: 0; padding: 0;">Registered Charity No. 1157550</p>
                    </td>
                </tr></table></td>
    </tr></table></body>
</html>
';

	$admin_headers = array('Content-Type: text/html; charset=UTF-8');

	wp_mail( $email_to, $admin_subject, $admin_body, $admin_headers );

?>
