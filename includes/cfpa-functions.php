<?php

function cfpa_logout_redirect( $redirect_to, $requested_redirect_to, $user ) {
	$redirect_to = home_url();
	return $redirect_to;
}
add_filter('logout_redirect', 'cfpa_logout_redirect', 10, 3);


// Redefine user notification function
if ( !function_exists('wp_new_user_notification') ) {

	function wp_new_user_notification( $user_id, $notify = '' ) {

        global $wpdb;
		$user = new WP_User( $user_id );

		$user_login = stripslashes( $user->user_login );
		$user_email = stripslashes( $user->user_email );

		$ebo = get_option('sd_options');
		//$welcome = $ebo['opt-editor-tiny'];

		$message  = sprintf( __('New user registration on %s:'), get_option('blogname') ) . "\r\n\r\n";
		$message .= sprintf( __('Username: %s'), $user_login ) . "\r\n\r\n";
		$message .= sprintf( __('E-mail: %s'), $user_email ) . "\r\n";

		@wp_mail(
			get_option('admin_email'),
			sprintf(__('[%s] New User Registration'), get_option('blogname') ),
			$message
		);


		if ( 'admin' === $notify || empty( $notify ) ) {
			return;
		}

		// Generate a key.
		$key = wp_generate_password( 20, false );

		do_action( 'retrieve_password_key', $user->user_login, $key );

		// Now insert the key, hashed, into the DB.
		if ( empty( $wp_hasher ) ) {
			require_once ABSPATH . WPINC . '/class-phpass.php';
			$wp_hasher = new PasswordHash( 8, true );
		}

		$hashed = time() . ':' . $wp_hasher->HashPassword( $key );
		$wpdb->update( $wpdb->users, array( 'user_activation_key' => $hashed ), array( 'user_login' => $user->user_login ) );


/*
		$message  = __('Hi there,') . "\r\n\r\n";
		$message .= sprintf( __("Welcome to %s membership!"), get_option('blogname')) . "\r\n\r\n";

		$message .= $welcome;

		$message .= sprintf(__('Username: %s'), $user->user_login) . "\r\n\r\n";
		$message .= __('To set your password, visit the following address:') . "\r\n\r\n";

		$message .= sprintf( __('If you have any problems, please contact me at %s.'), get_option('admin_email') ) . "\r\n\r\n";
		$message .= __('Cheers!');
*/

		$pwreset = network_site_url('wp-login.php?action=rp&key='.$key.'&login=' . rawurlencode($user->user_login), 'login');


$message = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/xhtml" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width" />
<!-- For development, pass document through inliner -->
</head>

<body style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; width: 100% !important; height: 100%; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; background: #efefef; margin: 0; padding: 0;" bgcolor="#efefef">
<table class="body-wrap" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; width: 100% !important; height: 100%; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; background: #efefef; margin: 0; padding: 0;" bgcolor="#efefef">

	<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
		<td class="container" style="font-size: 100%; font-family:Helvetica, Arial, sans-serif; line-height: 1.65; display: block !important; clear: both !important; max-width: 580px !important; margin: 0 auto; padding: 0;">

			<!-- Message start -->
			<table style="font-size: 100%; font-family:Helvetica, Arial, sans-serif; line-height: 1.65; width: 100% !important; border-collapse: collapse; margin: 0; padding: 0;">

				<tr style="font-size: 100%; font-family:Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">

					<td align="center" class="masthead" style="font-size: 100%; font-family:Helvetica, Arial, sans-serif; line-height: 1.65; color: white; background: #fff; margin: 0; padding: 80px 0;" bgcolor="#fff">

	                	<img src="http://cheltfestperfarts.webeden.co.uk/communities/5/004/011/108/065/images/4612256158_198x262.jpg" alt="cheltenham festival of performing arts" style="font-size: 100%; font-family:Helvetica, Arial, sans-serif; line-height: 1.65; max-width: 100%; display: block; margin: 0 auto; padding: 0;" />
	        		</td>
    			</tr>
				<tr style="font-size: 100%; font-family:Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">

					<td class="content" style="font-size: 100%; font-family:Helvetica, Arial, sans-serif; line-height: 1.65; background: white; margin: 0; padding: 30px 35px;" bgcolor="white">

						<h2 style="font-size: 28px; font-family:Helvetica, Arial, sans-serif; line-height: 1.25; margin: 0 0 20px; padding: 0;">Account Created!</h2>

						<p style="font-size: 16px; font-family:Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Your username is: <strong style="font-size: 100%; font-family:Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">'.$user->user_login.'</strong></p>

		                <p style="font-size: 16px; font-family:Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Now you have an account you can make bookings for your performers.</p>
		                <p style="font-size: 16px; font-family:Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;"><strong style="font-size: 100%; font-family:Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">There are a couple of things you should know first...</strong></p>
		                <p style="font-size: 16px; font-family:Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;"><strong style="font-size: 100%; font-family:Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">1. Use the link below to set your password,</strong> one will get automatically generated but you can change this to something more familiar, simply change it using the link below.</p>
						<p style="font-size: 16px; font-family:Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;"><strong style="font-size: 100%; font-family:Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">2. When you login for the first time you need to add a performer,</strong> as the parent, guardian or teacher you are the account holder but for security reasons we need to register certain information about the performers you are adding to your account.</p>

						<p style="font-size: 16px; font-family:Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Now you have the details you need don\'t forget to reset your password below.</p>

		                <table style="font-size: 100%; font-family:Helvetica, Arial, sans-serif; line-height: 1.65; width: 100% !important; border-collapse: collapse; margin: 0; padding: 0;">
			                <tr style="font-size: 100%; font-family:Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
			               		<td align="center" style="font-size: 100%; font-family:Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
	                            	<p style="font-size: 16px; font-family:Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">
	                                	<a href="'.$pwreset.'" class="button" style="font-size: 100%; font-family:Helvetica, Arial, sans-serif; line-height: 1.65; color: white; text-decoration: none; display: inline-block; font-weight: bold; border-radius: 4px; background: #71bc37; margin: 0; padding: 0; border-color: #71bc37; border-style: solid; border-width: 10px 20px 8px;">Reset Password</a>
									</p>
	                        	</td>
	                    	</tr>
	                    </table>

	                    <p style="font-size: 16px; font-family:Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">If you have any problems, please contact <a href="mailto:elliott@squareonemd.co.uk" style="font-size: 100%; font-family:Helvetica, Arial, sans-serif; line-height: 1.65; color: #71bc37; text-decoration: none; margin: 0; padding: 0;">elliott@squareonemd.co.uk</a>.</p>

						<p style="font-size: 16px; font-family:Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Many thanks <em style="font-size: 100%; font-family:Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">– Cheltenham Festival of Performing Arts</em></p>

	            	</td>
        		</tr>
        	</table>
        </td>
	</tr>


	<tr style="font-size: 100%; font-family:Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
		<td class="container" style="font-size: 100%; font-family:Helvetica, Arial, sans-serif; line-height: 1.65; display: block !important; clear: both !important; max-width: 580px !important; margin: 0 auto; padding: 0;">

			<!-- Message start -->
		    <table style="font-size: 100%; font-family:Helvetica, Arial, sans-serif; line-height: 1.65; width: 100% !important; border-collapse: collapse; margin: 0; padding: 0;">
			    <tr style="font-size: 100%; font-family:Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
			    	<td class="content footer" align="center" style="font-size: 100%; font-family:Helvetica, Arial, sans-serif; line-height: 1.65; background: white none; margin: 0; padding: 30px 35px;" bgcolor="white">
		                <p style="font-size: 14px; font-family:Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; color: #888; text-align: center; margin: 0; padding: 0;" align="center">Sent by <a href="#" style="font-size: 100%; font-family:Helvetica, Arial, sans-serif; line-height: 1.65; color: #888; text-decoration: none; font-weight: bold; margin: 0; padding: 0;">Cheltenham Festival of Performing Arts</a> - Registered Charity No. 1157550</p>
		            </td>
		        </tr>
		    </table>

		</td>

	</tr>

</table>
</body>
</html>
';

		$admin_headers = array('Content-Type: text/html; charset=UTF-8');

		wp_mail(
			$user_email,
			sprintf( __('[%s] Your username and password info'), get_option('blogname') ),
			$message, $admin_headers
		);
	}
}

function do_csv_instructions() {
	$instructions = get_option('wedevs_csv_upload');
	if ($instructions) {
		$html = $instructions['wysiwyg'];
		$html .= '<br/>';
		$html .= '<h4 class="download-csv-example button button-primary"><i class="fa fa-download" aria-hidden="true"></i> <a href="'.$instructions['file'].'" target="_blank" download>Download</a></h4>';
		$html .= '<hr />';
	}

	if ($html) {
		echo apply_filters('the_content', $html);
	}

}


add_filter('gettext', 'custom_text_change', 20, 3);
function custom_text_change($translated_text, $text, $domain) {
    // Check the original text and replace it
    if ($text === 'Username or Email Address') {
        $translated_text = 'Email Address or Username<br/ >(i.e. first name, then space, then surname)';
    }
    if ($text === 'Check your email for the confirmation link, then visit the <a href="%s">login page</a>.') {
        $translated_text = 'Check your email for the confirmation link, then visit the <a href="%s">login page</a>.<br />The email may end up in your Junk/ Spam mail folder, so please be sure to check there if it is not in your inbox.';
    }
    return $translated_text;
}

add_filter( 'wp_login_errors', 'cfpa_login_errors' );
function cfpa_login_errors( $errors ) {
	if( isset( $errors->errors['invalid_email'] ) ) {
		$errors->errors["invalid_email"][0] = 'Unknown Email Address. Check again or try your username, which is your first name, followed by a space, followed by your surname.';
	}
	return $errors;
}


?>
