<?php
// settings definiiton
$sweetcaptcha_options = array(
    'sweetcaptcha_app_id' => array('title' => __('Application ID', 'sweetcaptcha'), 'description' => __('Insert your Application ID', 'sweetcaptcha')),
    'sweetcaptcha_key' => array('title' => __('SweetCaptcha Key', 'sweetcaptcha'), 'description' => __('Insert SweetCaptcha Key', 'sweetcaptcha')),
    'sweetcaptcha_secret' => array('title' => __('SweetCaptcha Secret', 'sweetcaptcha'), 'description' => __('Insert SweetCaptcha Secret', 'sweetcaptcha')),
//    'sweetcaptcha_public_url'			=> array('title' => __('SweetCaptcha Public URL', 'sweetcaptcha'), 'description' => __('Default values is "/wp-content/plugins/sweetcaptcha/library/sweetcaptcha.php" - don\'t change it unless you know what are you doing.', 'sweetcaptcha')),
    'sweetcaptcha_form_omit_users' => array('title' => __('Omit captcha for registered users', 'sweetcaptcha'), 'description' => __('Disable SweetCaptcha for registered users.', 'sweetcaptcha')),
    'sweetcaptcha_form_registration' => array('title' => __('SweetCaptcha for Registration Form', 'sweetcaptcha'), 'description' => __('Enable SweetCaptcha for registration form.', 'sweetcaptcha')),
    'sweetcaptcha_form_comment' => array('title' => __('SweetCaptcha for Comment Form', 'sweetcaptcha'), 'description' => __('Enable SweetCaptcha for comment form.', 'sweetcaptcha')),
    'sweetcaptcha_form_login' => array('title' => __('SweetCaptcha for Login Form', 'sweetcaptcha'), 'description' => __('Enable SweetCaptcha for login form.', 'sweetcaptcha')),
    'sweetcaptcha_form_lost' => array('title' => __('SweetCaptcha for Lost Password Form', 'sweetcaptcha'), 'description' => __('Enable SweetCaptcha for lost password form.', 'sweetcaptcha')),
    'sweetcaptcha_form_contact_7' => array('title' => __('SweetCaptcha for Contact Form 7', 'sweetcaptcha'), 'description' => __('Enable SweetCaptcha for contact form 7 plug-in.', 'sweetcaptcha')),
    'sweetcaptcha_form_contact' => array('title' => __('<b style="color:brown;">SweetCaptcha Contact Form</b>', 'sweetcaptcha'), 'description' => __('Do you want a contact form with SweetCaptcha? Check the check box, configure and save settings.', 'sweetcaptcha')),
);

/**
 * @return true if SweetCaptcha is properly registered.
 */
function sweetcaptcha_is_registered() {
  return ((get_option('sweetcaptcha_app_id', '')) && (get_option('sweetcaptcha_key', '')) && (get_option('sweetcaptcha_secret', '')));
}

/**
 * Display admin notices.
 * @return void
 */
function sweetcaptcha_admin_notices() {
  // If the plugin is not configured yet.
  if (!sweetcaptcha_is_registered()) {
    echo '<div class="error sweetcaptcha" style="text-align: center; float:left;width:99%;">
      <p style="color: red; font-size: 14px; font-weight: bold;">' . __('Your SweetCaptcha plugin is not setup yet') 
      . '</p><p>' . __('Click ') . '<a href="options-general.php?page=sweetcaptcha">' . __('here') . '</a> ' 
      . __('to finish setup.') . '</p></div>'
    ;
  }
}

/**
 * Add SweetCaptcha settings link to admin menu
 * @return void
 */
function sweetcaptcha_admin_menu() {
  //$menu_item = "<div class='admin-menu-item'>SweetCaptcha</div>";
  //add_options_page(__('SweetCaptcha', 'sweetcaptcha'), __($menu_item, 'sweetcaptcha'), 'manage_options', 'sweetcaptcha', 'sweetcaptcha_options_page');
  add_menu_page(__('SweetCaptcha', 'sweetcaptcha'), __('SweetCaptcha', 'sweetcaptcha'), 'manage_options', 'sweetcaptcha', 'sweetcaptcha_options_page', 
          SWEETCAPTCHA_URL.'/images/menu-icon.png');
}

/**
 * SweetCaptcha options page logic
 * @return void
 */
function sweetcaptcha_options_page() {
  //must check that the user has the required capability 
  if (!current_user_can('manage_options')) {
    wp_die(__('You do not have sufficient permissions to access this page.'));
  }

  $skip_register = ((isset($_REQUEST['skip_register'])) && ($_REQUEST['skip_register'] == 1));
  if ((sweetcaptcha_is_registered()) || ($skip_register)) {
    sweetcatpcha_main_settings();
  } else {
    sweetcaptcha_register_form();
  }
}

/**
 * Displays the SweetCaptcha register form.
 * @return void
 */
function sweetcaptcha_register_form() {
  global $sweetcaptcha_instance;

  $hidden_field_name = 'mt_submit_hidden';
  $form_html = 'Could not load registration form.';
  //var_export($_POST);
  // See if the user has posted us some information
  // If they did, this hidden field will be set to 'Y'
  if ((isset($_POST[$hidden_field_name])) && ($_POST[$hidden_field_name] == 'Y')) {
    $result = json_decode($sweetcaptcha_instance->submit_register_form($_POST), true);
    if ($result['error']) {
      if (!empty($result['html'])) {
        $form_html = $result['html'];
      }
    } else {
      update_option('sweetcaptcha_app_id', $result['app_id']);
      update_option('sweetcaptcha_key', $result['key']);
      update_option('sweetcaptcha_secret', $result['secret']);

      // Load the main options page, and ignore the post data (since it's missing all the options!).
      sweetcatpcha_main_settings(true);

      // Hide the "your plugin is not set up yet" message.
      echo "
				<script type=\"text/javascript\" language=\"javascript\">
					jQuery('div.error.sweetcaptcha').hide();
				</script>
			";
      return;
    }
  } else {
    $form_html = $sweetcaptcha_instance->get_register_form();
  }
  // Fill Register Form fields
  $website = json_encode(empty($_POST['website']) ? "http://{$_SERVER['SERVER_NAME']}/" : $_POST['website']);
  $email = json_encode($_POST['email']);
  
  //jQuery('<div><input type="text" class="field" name="dynamic[]" value="' + i + '" /></div>').fadeIn('slow').appendTo('.inputs');
  $form_html .= "<script type=\"text/javascript\" language=\"javascript\">\n";
  $form_html .= "    jQuery('input[name=website]').addClass('requiredField');\n";
  $form_html .= "    jQuery('input[name=email]').addClass('requiredField');\n";
  $form_html .= "    jQuery('select[name=site_category]').addClass('requiredField');\n";
    
  $form_html .= "    jQuery('input[name=website]').val($website);\n";
  $form_html .= "    jQuery('input[name=email]').val($email);\n";

  if (isset($_POST['language'])) {
    $language = (int) $_POST['language'];
    $form_html .= "    jQuery('select[name=language]').val($language);\n";
  }
  if (isset($_POST['category'])) {
    $category = (int) $_POST['category'];
    $form_html .= "    jQuery('select[name=category]').val($category);\n";
  }
  if (isset($_POST['site_category'])) {
    $site_category = (int) $_POST['site_category'];
    $form_html .= "    jQuery('select[name=site_category]').val($site_category);\n";
  }
  if (isset($_POST['gender'])) {
    $gender = (int) $_POST['gender'];
    $form_html .= "    jQuery('select[name=gender]').val($gender);\n";
  }
  $form_html .= "</script>\n";
  
  $form_html = preg_replace('/category:/', 'SweetCaptcha design:', $form_html);
  //$form_html = preg_replace('/Please fill in your site details/', 'Fill in your SweetCaptcha details to activate:', $form_html);
  $form_html = preg_replace('/language:/', 'SweetCaptcha language:', $form_html);
  //$form_html = preg_replace('/SweetCaptcha theme:/', 'SweetCaptcha design:', $form_html);
  //$form_html = str_lreplace("</tr>", '</tr><tr><td class="left">Website category:</td><td class="right"><select name="site_category">'.$select_html.'</select></td></tr>',$form_html);
  
  $form_html .= "<script type=\"text/javascript\">\n jQuery('input[name=email_verify]').val(jQuery('input[name=email]').val()); jQuery('input[name=email_verify]').parent().parent().hide(); </script>\n";
  $form_html .= "<script type=\"text/javascript\">\n jQuery('input[name=email]').change(function() {jQuery('input[name=email_verify]').val(jQuery(this).val());}); </script>\n";
  
  /*
  $cats = file(SWEETCAPTCHA_ROOT.'/site-categories.txt');
  $select_html = '';
  foreach ($cats as $cat) {
    $cat =  trim ( $cat);
    $select_html .= "<option value='$cat'>$cat</option>";
  }
  //$form_html = preg_replace(strrev("|</tr>|"),'</tr><tr><td></td><td></td></tr>',$form_html,1);
  $form_html = str_lreplace("</tr>", '</tr><tr><td class="left">Website category:</td><td class="right"><select name="site_category">'.$select_html.'</select></td></tr>',$form_html);
  */
  require_once SWEETCAPTCHA_TEMPLATE . '/admin-register.php';

  // Display share buttons.
  //sweetaptcha_share_buttons();
}

function str_lreplace($search, $replace, $subject) {
  return substr_replace($subject, $replace, strrpos($subject, $search), strlen($search));
}

/**
 * Displays the main SweetCaptcha settings.
 * @return void
 */
function sweetcatpcha_main_settings($ignore_post = false) {
  global $sweetcaptcha_options, $swtcptcf_options;

  // variables for the field and option names 
  $opt_name = 'mt_favorite_color';
  $hidden_field_name = 'mt_submit_hidden';
  $data_field_name = 'mt_favorite_color';

  sweetcaptcha_contactform_settings();

  // See if the user has posted us some information
  // If they did, this hidden field will be set to 'Y'
  if ((!$ignore_post) && (isset($_POST[$hidden_field_name])) && ($_POST[$hidden_field_name] == 'Y')) {
    $rs = TRUE;

    // Read their posted value
    foreach ($sweetcaptcha_options as $opt_name => $v) {
      $opt_val = isset($_POST[$opt_name]) ? $_POST[$opt_name] : null;

      // Save the posted value in the database
      update_option($opt_name, $opt_val);
    }

    if ( swtcptcf_settings_save() ) {
      // Put an settings updated message on the screen
      $saved_html = 'Settings saved.';
      if (sweetcaptcha_is_registered()) {
        $saved_html .= "
				<script type=\"text/javascript\" language=\"javascript\">
					jQuery( 'div.error.sweetcaptcha' ).hide();
				</script>
      	";
      }
    }

    $message = $rs ? __($saved_html, 'sweetcaptcha') : __('settings cannot be saved.', 'sweetcaptcha');
  }

  // Read in existing option value from database
  $options_values = sweetcaptcha_options();

  //echo 'swtcptcf_options='; var_export($swtcptcf_options);
  require_once SWEETCAPTCHA_TEMPLATE . '/admin-options.php';

  // Display share buttons.
  sweetaptcha_share_buttons();
}

// Sweet Captcha Contact Form settings 
function sweetcaptcha_contactform_settings() {
  global $swtcptcf_options;

  $swtcptcf_option_defaults = array(
      'swtcptcf_user_email' => 'admin',
      'swtcptcf_custom_email' => '',
      'swtcptcf_select_email' => 'user',
      'swtcptcf_additions_options' => 0,
      'swtcptcf_send_copy' => 0,
      'swtcptcf_from_field' => get_bloginfo('name'),
      'swtcptcf_display_add_info' => 1,
      'swtcptcf_display_sent_from' => 1,
      'swtcptcf_display_date_time' => 1,
      'swtcptcf_mail_method' => 'wp-mail',
      'swtcptcf_display_coming_from' => 1,
      'swtcptcf_display_user_agent' => 1,
      'swtcptcf_change_label' => 0,
      'swtcptcf_name_label' => __("Name:", 'sweetcaptcha'),
      'swtcptcf_email_label' => __("E-Mail Address:", 'sweetcaptcha'),
      'swtcptcf_subject_label' => __("Subject:", 'sweetcaptcha'),
      'swtcptcf_message_label' => __("Message:", 'sweetcaptcha'),
      'swtcptcf_action_after_send' => 1,
      'swtcptcf_thank_text' => __("Thank you for contacting us.", 'sweetcaptcha'),
      'swtcptcf_redirect_url' => ''
  );
  if (!get_option('sweetcaptcha_form_contact_options'))
    add_option('sweetcaptcha_form_contact_options', $swtcptcf_option_defaults);

  $swtcptcf_options = get_option('sweetcaptcha_form_contact_options');
  if (is_array($swtcptcf_options) ) {
    $swtcptcf_options = array_merge($swtcptcf_option_defaults, $swtcptcf_options);
  } else {
    $swtcptcf_options = $swtcptcf_option_defaults;
  }
  update_option('sweetcaptcha_form_contact_options', $swtcptcf_options);
}

function swtcptcf_settings_save() {
  global $swtcptcf_options, $wpdb, $error;
  $userslogin = $wpdb->get_col("SELECT user_login FROM  $wpdb->users ", 0);
  $swtcptcf_options_submit = array();
  // Save data for settings page
  $swtcptcf_options_submit['swtcptcf_user_email'] = $_REQUEST['swtcptcf_user_email'];
  $swtcptcf_options_submit['swtcptcf_custom_email'] = $_REQUEST['swtcptcf_custom_email'];
  $swtcptcf_options_submit['swtcptcf_select_email'] = $_REQUEST['swtcptcf_select_email'];
  $swtcptcf_options_submit['swtcptcf_additions_options'] = isset($_REQUEST['swtcptcf_additions_options']) ? $_REQUEST['swtcptcf_additions_options'] : 0;
  if ($swtcptcf_options_submit['swtcptcf_additions_options'] == 0) {
    $swtcptcf_options_submit['swtcptcf_send_copy'] = 0;
    $swtcptcf_options_submit['swtcptcf_from_field'] = get_bloginfo('name');
    $swtcptcf_options_submit['swtcptcf_display_add_info'] = 1;
    $swtcptcf_options_submit['swtcptcf_display_sent_from'] = 1;
    $swtcptcf_options_submit['swtcptcf_display_date_time'] = 1;
    $swtcptcf_options_submit['swtcptcf_mail_method'] = 'wp-mail';
    $swtcptcf_options_submit['swtcptcf_display_coming_from'] = 1;
    $swtcptcf_options_submit['swtcptcf_display_user_agent'] = 1;
    $swtcptcf_options_submit['swtcptcf_change_label'] = 0;
    $swtcptcf_options_submit['swtcptcf_name_label'] = __("Name:", 'sweetcaptcha');
    $swtcptcf_options_submit['swtcptcf_email_label'] = __("E-Mail Address:", 'sweetcaptcha');
    $swtcptcf_options_submit['swtcptcf_subject_label'] = __("Subject:", 'sweetcaptcha');
    $swtcptcf_options_submit['swtcptcf_message_label'] = __("Message:", 'sweetcaptcha');
    $swtcptcf_options_submit['swtcptcf_action_after_send'] = 1;
    $swtcptcf_options_submit['swtcptcf_thank_text'] = __("Thank you for contacting us.", 'sweetcaptcha');
    $swtcptcf_options_submit['swtcptcf_redirect_url'] = '';
  } else {
    $swtcptcf_options_submit['swtcptcf_send_copy'] = isset($_REQUEST['swtcptcf_send_copy']) ? $_REQUEST['swtcptcf_send_copy'] : 0;
    $swtcptcf_options_submit['swtcptcf_mail_method'] = $_REQUEST['swtcptcf_mail_method'];
    $swtcptcf_options_submit['swtcptcf_from_field'] = $_REQUEST['swtcptcf_from_field'];
    $swtcptcf_options_submit['swtcptcf_display_add_info'] = isset($_REQUEST['swtcptcf_display_add_info']) ? 1 : 0;
    $swtcptcf_options_submit['swtcptcf_change_label'] = isset($_REQUEST['swtcptcf_change_label']) ? 1 : 0;
    if ($swtcptcf_options_submit['swtcptcf_display_add_info'] == 1) {
      $swtcptcf_options_submit['swtcptcf_display_sent_from'] = isset($_REQUEST['swtcptcf_display_sent_from']) ? 1 : 0;
      $swtcptcf_options_submit['swtcptcf_display_date_time'] = isset($_REQUEST['swtcptcf_display_date_time']) ? 1 : 0;
      $swtcptcf_options_submit['swtcptcf_display_coming_from'] = isset($_REQUEST['swtcptcf_display_coming_from']) ? 1 : 0;
      $swtcptcf_options_submit['swtcptcf_display_user_agent'] = isset($_REQUEST['swtcptcf_display_user_agent']) ? 1 : 0;
    } else {
      $swtcptcf_options_submit['swtcptcf_display_sent_from'] = 1;
      $swtcptcf_options_submit['swtcptcf_display_date_time'] = 1;
      $swtcptcf_options_submit['swtcptcf_display_coming_from'] = 1;
      $swtcptcf_options_submit['swtcptcf_display_user_agent'] = 1;
    }
    if ($swtcptcf_options_submit['swtcptcf_change_label'] == 1) {
      $swtcptcf_options_submit['swtcptcf_name_label'] = isset($_REQUEST['swtcptcf_name_label']) ? $_REQUEST['swtcptcf_name_label'] : $swtcptcf_options_submit['swtcptcf_name_label'];
      $swtcptcf_options_submit['swtcptcf_email_label'] = isset($_REQUEST['swtcptcf_email_label']) ? $_REQUEST['swtcptcf_email_label'] : $swtcptcf_options_submit['swtcptcf_email_label'];
      $swtcptcf_options_submit['swtcptcf_subject_label'] = isset($_REQUEST['swtcptcf_subject_label']) ? $_REQUEST['swtcptcf_subject_label'] : $swtcptcf_options_submit['swtcptcf_subject_label'];
      $swtcptcf_options_submit['swtcptcf_message_label'] = isset($_REQUEST['swtcptcf_message_label']) ? $_REQUEST['swtcptcf_message_label'] : $swtcptcf_options_submit['swtcptcf_message_label'];
    } else {
      $swtcptcf_options_submit['swtcptcf_name_label'] = __("Name:", 'sweetcaptcha');
      $swtcptcf_options_submit['swtcptcf_email_label'] = __("E-Mail Address:", 'sweetcaptcha');
      $swtcptcf_options_submit['swtcptcf_subject_label'] = __("Subject:", 'sweetcaptcha');
      $swtcptcf_options_submit['swtcptcf_message_label'] = __("Message:", 'sweetcaptcha');
    }
    $swtcptcf_options_submit['swtcptcf_action_after_send'] = $_REQUEST['swtcptcf_action_after_send'];
    $swtcptcf_options_submit['swtcptcf_thank_text'] = $_REQUEST['swtcptcf_thank_text'];
    $swtcptcf_options_submit['swtcptcf_redirect_url'] = $_REQUEST['swtcptcf_redirect_url'];
  }
  $swtcptcf_options = array_merge($swtcptcf_options, $swtcptcf_options_submit);
  if ($swtcptcf_options_submit['swtcptcf_action_after_send'] == 0
          && ( trim($swtcptcf_options_submit['swtcptcf_redirect_url']) == ""
          || !preg_match('@^(?:http://)?([^/]+)@i', trim($swtcptcf_options_submit['swtcptcf_redirect_url'])) )) {
    $error .=__("If the option 'Redirect to page' is selected then url field should be fillied in the following format", 'sweetcaptcha') . " <code>http://your_site/your_page</code>";
    $swtcptcf_options['swtcptcf_action_after_send'] = 1;
  }
  if ('user' == $swtcptcf_options_submit['swtcptcf_select_email']) {
    if (function_exists('get_userdatabylogin') && false !== get_userdatabylogin($swtcptcf_options_submit['swtcptcf_user_email'])) {
      update_option('sweetcaptcha_form_contact_options', $swtcptcf_options, '', 'yes');
      $message = __("Options saved.", 'sweetcaptcha');
    } else if (false !== get_user_by('login', $swtcptcf_options_submit['swtcptcf_user_email'])) {
      update_option('sweetcaptcha_form_contact_options', $swtcptcf_options, '', 'yes');
      $message = __("Options saved.", 'sweetcaptcha');
    } else {
      $error .=__("Such user does not exist. Settings not saved.", 'sweetcaptcha');
    }
  } else {
    if ( isset($_REQUEST['sweetcaptcha_form_contact']) ) {
      if ($swtcptcf_options_submit['swtcptcf_custom_email'] != "" && preg_match("/^((?:[a-z0-9]+(?:[a-z0-9\-_\.]+)?@[a-z0-9]+(?:[a-z0-9\-\.]+)?\.[a-z]{2,5})[, ]*)+$/i", trim($swtcptcf_options_submit['swtcptcf_custom_email']))) {
        update_option('sweetcaptcha_form_contact_options', $swtcptcf_options, '', 'yes');
      $message = __("Options saved.", 'sweetcaptcha');
      } else {
        $error .= __("Please input correct email. Settings not saved.", 'sweetcaptcha');
      }
    } else {
      $message = __("Options saved.", 'sweetcaptcha');
    }
  }
  return empty($error);
}

/**
 * Get all SweetCaptcha options values as asociative array
 * @return array
 */
function sweetcaptcha_options() {
  global $sweetcaptcha_options;
  $options_values = array();
  foreach ($sweetcaptcha_options as $opt_name => $opt_title) {
    $options_values[$opt_name] = get_option($opt_name);
  }
  return $options_values;
}

/**
 * SweetCaptcha plug-in activation hook
 * @return void
 */
function sweetcaptcha_activate() {
  $sweetcaptcha_defaults = array(
      'sweetcaptcha_app_id' => '',
      'sweetcaptcha_key' => '',
      'sweetcaptcha_secret' => '',
      'sweetcaptcha_public_url' => '/wp-content/plugins/sweetcaptcha/library/sweetcaptcha.php',
      'sweetcaptcha_form_omit_users' => '1',
      'sweetcaptcha_form_registration' => '1',
      'sweetcaptcha_form_comment' => '1',
      'sweetcaptcha_form_login' => '',
      'sweetcaptcha_form_lost' => '1',
      'sweetcaptcha_form_contact_7' => '1',
      'sweetcaptcha_form_contact' => '0',
      'sweetcaptcha_installed' => '1',
  );
  if (!get_option('sweetcaptcha_installed')) {
    foreach ($sweetcaptcha_defaults as $opt_name => $opt_val) {
      $opt_curr_val = get_option($opt_name);
      if (empty($opt_curr_val)) {
        update_option($opt_name, $opt_val);
      }
    }
  }
}

/**
 * Delete SweetCaptcha options from database
 * @return void
 */
function sweetcaptcha_uninstall() {
  global $sweetcaptcha_options;

  foreach ($sweetcaptcha_options as $opt_name => $opt_title) {
    delete_option($opt_name);
  }
  // These do not appear in the global .
  delete_option('sweetcaptcha_installed');
}

/**
 * Display the facebook and twitter share buttons
 * @return void
 */
function sweetaptcha_share_buttons() {
  ?>

  <div id="share">
    <a name="fb_share" class="fb-share" type="button_count" href="#" onclick="window.open( 'http://www.facebook.com/sharer.php?u=http%3A%2F%2F<?php echo SWEETCAPTCHA_SITE_URL;?>&amp;t=Check%20this%20cool%20service%20out!', 'sharer', 'toolbar=0, status=0, width=626, height=436' ); return false;"><img src="<?php echo plugins_url('fbshare.jpg', dirname(__FILE__)); ?>" alt="Share" style="vertical-align: middle;" /></a>

    <a href="http://twitter.com/share" class="twitter-share-button" data-count="none" data-text="Check out this cool service!" data-via="sweetcaptcha">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
  </div>

  <style type="text/css">
    #share { text-align: left; padding-bottom: 2px; }

    .twitter-share-button, fb-share { vertical-align: middle }
  </style>

  <?php
}
