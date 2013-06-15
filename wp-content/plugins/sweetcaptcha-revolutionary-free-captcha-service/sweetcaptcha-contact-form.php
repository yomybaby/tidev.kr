<?php
// Display SweetCaptcha Contact Form in front end - page or post
//**********************************************************************************************************************
if (!function_exists('swtcptcf_display_form')) {

  function swtcptcf_display_form() {
    global $error_message, $swtcptcf_options, $result;
    $swtcptcf_options = get_option('sweetcaptcha_form_contact_options');
    $content = "";

    $page_url = ( isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on" ? "https://" : "http://" ) . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    // If contact form submited
    $name = isset($_REQUEST['swtcptcf_contact_name']) ? $_REQUEST['swtcptcf_contact_name'] : "";
    $email = isset($_REQUEST['swtcptcf_contact_email']) ? $_REQUEST['swtcptcf_contact_email'] : "";
    $subject = isset($_REQUEST['swtcptcf_contact_subject']) ? $_REQUEST['swtcptcf_contact_subject'] : "";
    $message = isset($_REQUEST['swtcptcf_contact_message']) ? $_REQUEST['swtcptcf_contact_message'] : "";
    $send_copy = isset($_REQUEST['swtcptcf_contact_send_copy']) ? $_REQUEST['swtcptcf_contact_send_copy'] : "";
    // If it is good
    if (true === $result) {
      $_SESSION['swtcptcf_send_mail'] = true;
      if ($swtcptcf_options['swtcptcf_action_after_send'] == 1)
        $content .= $swtcptcf_options['swtcptcf_thank_text'];
      else
        $content .= "<script type='text/javascript'>window.location.href = '" . $swtcptcf_options['swtcptcf_redirect_url'] . "';</script>";
    }
    else if (false === $result) {
      // If email not be delivered
      $error_message['error_form'] = __("Sorry, your e-mail could not be delivered.", 'sweetcaptcha');
    } else {
      $_SESSION['swtcptcf_send_mail'] = false;
      // Output form
      $content .= '<form method="post" id="swtcptcf_contact_form" action="' . $page_url . '" enctype="multipart/form-data">';
      if (isset($error_message['error_form'])) {
        $content .= '<div class="error-form">' . $error_message['error_form'] . '</div>';
      }
      $content .= '<div class="input-label">
					<label for="swtcptcf_contact_name">' . $swtcptcf_options['swtcptcf_name_label'] . '<span class="required"> *</span></label>
				</div>';
      if (isset($error_message['error_name'])) {
        $content .= '<div class="error-form">' . $error_message['error_name'] . '</div>';
      }
      $content .= '<div class="input">
					<input class="text" type="text" size="40" value="' . $name . '" name="swtcptcf_contact_name" id="swtcptcf_contact_name" />
				</div>

				<div class="input-label">
					<label for="swtcptcf_contact_email">' . $swtcptcf_options['swtcptcf_email_label'] . '<span class="required"> *</span></label>
				</div>';
      if (isset($error_message['error_email'])) {
        $content .= '<div class="error-form">' . $error_message['error_email'] . '</div>';
      }
      $content .= '<div class="input">
					<input class="text" type="text" size="40" value="' . $email . '" name="swtcptcf_contact_email" id="swtcptcf_contact_email" />
				</div>

				<div class="input-label">
					<label for="swtcptcf_contact_subject">' . $swtcptcf_options['swtcptcf_subject_label'] . '<span class="required"> *</span></label>
				</div>';
      if (isset($error_message['error_subject'])) {
        $content .= '<div class="error-form">' . $error_message['error_subject'] . '</div>';
      }
      $content .= '<div class="input">
					<input class="text" type="text" size="40" value="' . $subject . '" name="swtcptcf_contact_subject" id="swtcptcf_contact_subject" />
				</div>

				<div class="input-label">
					<label for="swtcptcf_contact_message">' . $swtcptcf_options['swtcptcf_message_label'] . '<span class="required"> *</span></label>
				</div>';
      if (isset($error_message['error_message'])) {
        $content .= '<div class="error-form">' . $error_message['error_message'] . '</div>';
      }
      $content .= '<div class="input">
					<textarea rows="5" cols="30" name="swtcptcf_contact_message" id="swtcptcf_contact_message">' . $message . '</textarea>
				</div>';
      if (isset($error_message['error_captcha'])) {
        $content .= '<div class="error-form">' . $error_message['error_captcha'] . '</div>';
      }

      $content .= sweetcaptcha_shortcode();

      if ($swtcptcf_options['swtcptcf_send_copy'] == 1) {
        $content .= '<div style="text-align: left;">
						<input type="checkbox" value="1" name="swtcptcf_contact_send_copy" id="swtcptcf_contact_send_copy" style="text-align: left; margin: 0;" ' . ( $send_copy == '1' ? " checked=\"checked\" " : "" ) . ' />
						<label for="swtcptcf_contact_send_copy">' . __("Send me a copy", 'sweetcaptcha') . '</label>
					</div>';
      }

      $content .= '<div style="text-align: left; padding-top: 8px;">
					<input type="hidden" value="send" name="swtcptcf_contact_action"><input type="hidden" value="Version: 3.13" />
					<input type="submit" value="' . __("Submit", 'sweetcaptcha') . '" style="cursor: pointer; margin: 0pt; text-align: center;margin-bottom:10px;" /> 
				</div>
				</form>';
    }
    return $content;
  }

}
//**********************************************************************************************************************
if (!function_exists('swtcptcf_check_and_send')) {

  function swtcptcf_check_and_send() {
    //die ('swtcptcf_check_and_send'); 
    global $result;
    $swtcptcf_options = get_option('sweetcaptcha_form_contact_options');
    if (isset($_REQUEST['swtcptcf_contact_action'])) {
      // Check all input data
      $result = swtcptcf_check_form();
    }
    if (true === $result) { // OK
      $_SESSION['swtcptcf_send_mail'] = true;
      if ($swtcptcf_options['swtcptcf_action_after_send'] == 0) {
        wp_redirect($swtcptcf_options['swtcptcf_redirect_url']);
        exit;
      }
    }
  }

}
//**********************************************************************************************************************
// Check SweetCaptcha Contact Form input data
if (!function_exists('swtcptcf_check_form')) {

  function swtcptcf_check_form() {
    global $error_message;
    global $swtcptcf_options;
    //$path_of_uploaded_file = '';
    if (empty($swtcptcf_options))
      $swtcptcf_options = get_option('sweetcaptcha_form_contact_options');
    $result = "";
    // Error messages array
    $error_message = array();
    $error_message['error_name'] = __("Please input your name.", 'sweetcaptcha');
    $error_message['error_email'] = __("Please input your e-mail address.", 'sweetcaptcha');
    $error_message['error_subject'] = __("Subject required.", 'sweetcaptcha');
    $error_message['error_message'] = __("Message text required.", 'sweetcaptcha');
    $error_message['error_form'] = __("Please correct your input data below and try again.", 'sweetcaptcha');
    // Check information
    if ("" != $_REQUEST['swtcptcf_contact_name'])
      unset($error_message['error_name']);
    if ("" != $_REQUEST['swtcptcf_contact_email'] && preg_match("/^(?:[a-z0-9]+(?:[a-z0-9\-_\.]+)?@[a-z0-9]+(?:[a-z0-9\-\.]+)?\.[a-z]{2,5})$/i", trim($_REQUEST['swtcptcf_contact_email'])))
      unset($error_message['error_email']);
    if ("" != $_REQUEST['swtcptcf_contact_subject'])
      unset($error_message['error_subject']);
    if ("" != $_REQUEST['swtcptcf_contact_message'])
      unset($error_message['error_message']);
    
    sweetcaptcha_validate_contact_form($error_message);

    if (1 == count($error_message)) { // OK
      unset($error_message['error_form']);
      $result = swtcptcf_send_mail();
    }

    return $result;
  }

}

//**********************************************************************************************************************
// Send mail function
if (!function_exists('swtcptcf_send_mail')) {

  function swtcptcf_send_mail() {
    global $swtcptcf_options, $path_of_uploaded_file;
    $to = "";
    if (isset($_SESSION['swtcptcf_send_mail']) && $_SESSION['swtcptcf_send_mail'] == true)
      return true;
    if ($swtcptcf_options['swtcptcf_select_email'] == 'user') {
      if (function_exists('get_userdatabylogin') && false !== $user = get_userdatabylogin($swtcptcf_options['swtcptcf_user_email'])) {
        $to = $user->user_email;
      } else if (false !== $user = get_user_by('login', $swtcptcf_options_submit['swtcptcf_user_email']))
        $to = $user->user_email;
    }
    else {
      $to = $swtcptcf_options['swtcptcf_custom_email'];
    }
    if ("" == $to) {
      // If email options are not certain choose admin email
      $to = get_option("admin_email");
    }
    if ("" != $to) {
      // subject
      $subject = $_REQUEST['swtcptcf_contact_subject'];
      $user_info_string = '';
      $userdomain = '';
      $form_action_url = '';
      $attachments = array();
      $headers = "";

      if (getenv('HTTPS') == 'on') {
        $form_action_url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
      } else {
        $form_action_url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
      }

      if ($swtcptcf_options['swtcptcf_display_add_info'] == 1) {
        $userdomain = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        if ($swtcptcf_options['swtcptcf_display_add_info'] == 1 ||
                $swtcptcf_options['swtcptcf_display_sent_from'] == 1 ||
                $swtcptcf_options['swtcptcf_display_coming_from'] == 1 ||
                $swtcptcf_options['swtcptcf_display_user_agent'] == 1) {
          $user_info_string .= '<tr>
							<td><br /></td><td><br /></td>
						</tr>';
        }
        if ($swtcptcf_options['swtcptcf_display_sent_from'] == 1) {
          $user_info_string .= '<tr>
							<td>' . __('Sent from (ip address)', 'sweetcaptcha') . ':</td><td>' . $_SERVER['REMOTE_ADDR'] . " ( " . $userdomain . " )" . '</td>
						</tr>';
        }
        if ($swtcptcf_options['swtcptcf_display_date_time'] == 1) {
          $user_info_string .= '<tr>
							<td>' . __('Date/Time', 'sweetcaptcha') . ':</td><td>' . date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime(current_time('mysql'))) . '</td>
						</tr>';
        }
        if ($swtcptcf_options['swtcptcf_display_coming_from'] == 1) {
          $user_info_string .= '<tr>
							<td>' . __('Coming from (referer)', 'sweetcaptcha') . ':</td><td>' . $form_action_url . '</td>
						</tr>';
        }
        if ($swtcptcf_options['swtcptcf_display_user_agent'] == 1) {
          $user_info_string .= '<tr>
							<td>' . __('Using (user agent)', 'sweetcaptcha') . ':</td><td>' . swtcptcf_clean_input($_SERVER['HTTP_USER_AGENT']) . '</td>
						</tr>';
        }
      }
      // message
      $message = '
			<html>
			<head>
				<title>' . __("Contact from", 'sweetcaptcha') . get_bloginfo('name') . '</title>
			</head>
			<body>
				<table>
					<tr>
						<td width="160">' . __("Name", 'sweetcaptcha') . '</td><td>' . $_REQUEST['swtcptcf_contact_name'] . '</td>
					</tr>
					<tr>
						<td>' . __("Email", 'sweetcaptcha') . '</td><td>' . $_REQUEST['swtcptcf_contact_email'] . '</td>
					</tr>
					<tr>
						<td>' . __("Subject", 'sweetcaptcha') . '</td><td>' . $_REQUEST['swtcptcf_contact_subject'] . '</td>
					</tr>
					<tr>
						<td>' . __("Message", 'sweetcaptcha') . '</td><td>' . $_REQUEST['swtcptcf_contact_message'] . '</td>
					</tr>
					<tr>
						<td>' . __("Site", 'sweetcaptcha') . '</td><td>' . get_bloginfo("url") . '</td>
					</tr>
					<tr>
						<td><br /></td><td><br /></td>
					</tr>
					' . $user_info_string . '
				</table>
			</body>
			</html>
			';
      if ($swtcptcf_options['swtcptcf_mail_method'] == 'wp-mail') {
        // To send HTML mail, the Content-type header must be set
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

        // Additional headers
        $headers .= 'From: ' . $_REQUEST['swtcptcf_contact_email'] . "\r\n";
        if (isset($_REQUEST['swtcptcf_contact_send_copy']) && $_REQUEST['swtcptcf_contact_send_copy'] == 1)
          wp_mail($_REQUEST['swtcptcf_contact_email'], stripslashes($subject), stripslashes($message), $headers, $attachments);

        // Mail it
        return wp_mail($to, stripslashes($subject), stripslashes($message), $headers, $attachments);
      }
      else {
        // HTML e-mail, we should set Content-type header
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

        // Additional headers
        $headers .= 'From: ' . $_REQUEST['swtcptcf_contact_email'] . "\r\n";
        if (isset($_REQUEST['swtcptcf_contact_send_copy']) && $_REQUEST['swtcptcf_contact_send_copy'] == 1)
          @mail($_REQUEST['swtcptcf_contact_email'], stripslashes($subject), stripslashes($message), $headers);

        return @mail($to, stripslashes($subject), stripslashes($message), $headers);
      }
    }
    return false;
  }

}

//**********************************************************************************************************************
function swtcptcf_clean_input($string, $preserve_space = 0) {
  if (is_string($string)) {
    if ($preserve_space) {
      return swtcptcf_sanitize_string(strip_tags(stripslashes($string)), $preserve_space);
    }
    return trim(swtcptcf_sanitize_string(strip_tags(stripslashes($string))));
  } else if (is_array($string)) {
    reset($string);
    while (list($key, $value ) = each($string)) {
      $string[$key] = swtcptcf_clean_input($value, $preserve_space);
    }
    return $string;
  } else {
    return $string;
  }
}

//**********************************************************************************************************************
// protect and validate form vars

function swtcptcf_sanitize_string($string, $preserve_space = 0) {
  if (!$preserve_space)
    $string = preg_replace("/ +/", ' ', trim($string));

  return preg_replace("/[<>]/", '_', $string);
}

//**********************************************************************************************************************
function swtcptcf_email_name_filter($data) {
  global $swtcptcf_options;
  if (isset($swtcptcf_options['swtcptcf_from_field']) && trim($swtcptcf_options['swtcptcf_from_field']) != "")
    return stripslashes($swtcptcf_options['swtcptcf_from_field']);
  else
    return $data;
}

//**********************************************************************************************************************
function sweetcaptcha_validate_contact_form(&$errors) {
	global $sweetcaptcha_instance;
	$scValues = sweetcaptcha_get_values();
	if ( $sweetcaptcha_instance->check( $scValues ) != 'true' ) {
    $errors['error_captcha'] = '<strong>'.__( 'ERROR', 'sweetcaptcha' ) . '</strong>: ' . __(SWEETCAPTCHA_ERROR_MESSAGE_BR, 'sweetcaptcha' );
	}
	return $errors;
}

//**********************************************************************************************************************

add_shortcode('sweetcaptcha_contact_form', 'swtcptcf_display_form');
add_action('init', 'swtcptcf_check_and_send');
add_filter('wp_mail_from_name', 'swtcptcf_email_name_filter', 10, 1);

?>