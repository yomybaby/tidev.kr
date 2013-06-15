<!-- Additional options in admin SweetCaptcha Settings -->
<?php 
global $error, $wpdb; 
$userslogin = $wpdb->get_col("SELECT user_login FROM  $wpdb->users ", 0);
?>
<div class="wrap" id="sweetcaptcha_form_contact_options" style="<?php echo $display_cfoptions;?>">
  <div class="error" style="width:99%; float: left; <?php if (empty($error)) echo 'display:none'; ?>" ><p><strong><?php echo $error; ?></strong></p></div>
  <p><?php _e("If you would like to add a Contact Form to your website, just copy and put this shortcode onto your post or page:", 'sweetcaptcha'); ?> <b>[sweetcaptcha_contact_form]</b></p>
  <br>
  <?php _e("If information in the below fields are empty then the message will be send to an address which was specified during registration.", 'sweetcaptcha'); ?>
  <table class="form-table">
    <tr valign="top">
      <th scope="row" style="width:195px;"><?php _e("Use email of wordpress user:", 'sweetcaptcha'); ?> </th>
      <td style="width:15px;">
        <input type="radio" id="swtcptcf_select_email_user" name="swtcptcf_select_email" value="user" <?php if ($swtcptcf_options['swtcptcf_select_email'] == 'user') echo "checked=\"checked\" "; ?>/>
      </td>
      <td>
        <select name="swtcptcf_user_email" style="width:130px;">
          <option disabled><?php _e("Select user name", 'sweetcaptcha'); ?></option>
          <?php while (list( $key, $value ) = each($userslogin)) { ?>
            <option value="<?php echo $value; ?>" 
              <?php if ($swtcptcf_options['swtcptcf_user_email'] == $value) echo "selected=\"selected\" "; ?>><?php echo $value; ?>
            </option>
          <?php } ?>
        </select>
        <span class="swtcptcf_info"><?php _e("Set a name of user who will get messages from a contact form.", 'sweetcaptcha'); ?></span>
      </td>
    </tr>
    <tr valign="top">
      <th scope="row"><?php _e("Use this email:", 'sweetcaptcha'); ?> </th>
      <td>
        <input type="radio" id="swtcptcf_select_email_custom" name="swtcptcf_select_email" value="custom" <?php if ($swtcptcf_options['swtcptcf_select_email'] == 'custom') echo "checked=\"checked\" "; ?>/>
      </td>
      <td>
        <input type="text" name="swtcptcf_custom_email" value="<?php echo $swtcptcf_options['swtcptcf_custom_email']; ?>" onfocus="document.getElementById('swtcptcf_select_email_custom').checked = true;" />
        <span class="swtcptcf_info"><?php _e("Set an email address which will be used for messages receiving.", 'sweetcaptcha'); ?></span>
      </td>
    </tr>
    <tr valign="top">
      <th colspan="3" scope="row"><input type="checkbox" id="swtcptcf_additions_options" name="swtcptcf_additions_options" value="1" <?php if ($swtcptcf_options['swtcptcf_additions_options'] == '1') echo "checked=\"checked\" "; ?> /> <?php _e("Additional options", 'sweetcaptcha'); ?></th>
    </tr>
    <tr valign="top" class="swtcptcf_additions_block <?php if ($swtcptcf_options['swtcptcf_additions_options'] == '0') echo "swtcptcf_hidden"; ?>">
      <th scope="row"><?php _e("Display Send me a copy block", 'sweetcaptcha'); ?></th>
      <td colspan="2">
        <input type="checkbox" id="swtcptcf_send_copy" name="swtcptcf_send_copy" value="1" <?php if ($swtcptcf_options['swtcptcf_send_copy'] == '1') echo "checked=\"checked\" "; ?>/>
      </td>
    </tr>
    <tr class="swtcptcf_additions_block <?php if ($swtcptcf_options['swtcptcf_additions_options'] == '0') echo "swtcptcf_hidden"; ?>">
      <th rowspan="2"><?php _e('What use?', 'sweetcaptcha'); ?></th>
      <td>
        <input type='radio' name='swtcptcf_mail_method' value='wp-mail' <?php if ($swtcptcf_options['swtcptcf_mail_method'] == 'wp-mail') echo "checked=\"checked\" "; ?>/>
      </td>
      <td>
        <?php _e('Wp-mail', 'mail-send'); ?> 
        <span  class="swtcptcf_info">(<?php _e('To send mail you can use the wordpress wp_mail function', 'mail_send'); ?>)</span>
      </td>
    </tr>
    <tr class="swtcptcf_additions_block <?php if ($swtcptcf_options['swtcptcf_additions_options'] == '0') echo "swtcptcf_hidden"; ?>">
      <td>
        <input type='radio' name='swtcptcf_mail_method' value='mail' <?php if ($swtcptcf_options['swtcptcf_mail_method'] == 'mail') echo "checked=\"checked\" "; ?>/>
      </td>
      <td>
        <?php _e('Mail', 'mail-send'); ?> 
        <span  class="swtcptcf_info">(<?php _e('To send mail you can use the php mail function', 'mail_send'); ?>)</span>
      </td>
    </tr>
    <tr valign="top" class="swtcptcf_additions_block <?php if ($swtcptcf_options['swtcptcf_additions_options'] == '0') echo "swtcptcf_hidden"; ?>">
      <th scope="row"><?php _e("Change FROM fields of the contact form", 'sweetcaptcha'); ?></th>
      <td colspan="2">
        <input type="text" style="width:200px;" name="swtcptcf_from_field" value="<?php echo stripslashes($swtcptcf_options['swtcptcf_from_field']); ?>" /><br />
      </td>
    </tr>
    <tr valign="top" class="swtcptcf_additions_block <?php if ($swtcptcf_options['swtcptcf_additions_options'] == '0') echo "swtcptcf_hidden"; ?>">
      <th scope="row"><?php _e("Display additional info in email", 'sweetcaptcha'); ?></th>
      <td>
        <input type="checkbox" id="swtcptcf_display_add_info" name="swtcptcf_display_add_info" value="1" <?php if ($swtcptcf_options['swtcptcf_display_add_info'] == '1') echo "checked=\"checked\" "; ?>/>
      </td>
      <td class="swtcptcf_display_add_info_block <?php if ($swtcptcf_options['swtcptcf_display_add_info'] == '0') echo "swtcptcf_hidden"; ?>">
        <input type="checkbox" id="swtcptcf_display_sent_from" name="swtcptcf_display_sent_from" value="1" <?php if ($swtcptcf_options['swtcptcf_display_sent_from'] == '1') echo "checked=\"checked\" "; ?>/> <span class="swtcptcf_info"><?php _e("Sent from (ip address)", 'sweetcaptcha'); ?></span><br />
        <input type="checkbox" id="swtcptcf_display_date_time" name="swtcptcf_display_date_time" value="1" <?php if ($swtcptcf_options['swtcptcf_display_date_time'] == '1') echo "checked=\"checked\" "; ?>/> <span class="swtcptcf_info"><?php _e("Date/Time", 'sweetcaptcha'); ?></span><br />
        <input type="checkbox" id="swtcptcf_display_coming_from" name="swtcptcf_display_coming_from" value="1" <?php if ($swtcptcf_options['swtcptcf_display_coming_from'] == '1') echo "checked=\"checked\" "; ?>/> <span class="swtcptcf_info"><?php _e("Coming from (referer)", 'sweetcaptcha'); ?></span><br />
        <input type="checkbox" id="swtcptcf_display_user_agent" name="swtcptcf_display_user_agent" value="1" <?php if ($swtcptcf_options['swtcptcf_display_user_agent'] == '1') echo "checked=\"checked\" "; ?>/> <span class="swtcptcf_info"><?php _e("Using (user agent)", 'sweetcaptcha'); ?></span><br />
      </td>
    </tr>
    <tr valign="top" class="swtcptcf_additions_block <?php if ($swtcptcf_options['swtcptcf_additions_options'] == '0') echo "swtcptcf_hidden"; ?>">
      <th scope="row"><?php _e("Change label for fields of the contact form", 'sweetcaptcha'); ?></th>
      <td>
        <input type="checkbox" id="swtcptcf_change_label" name="swtcptcf_change_label" value="1" <?php if ($swtcptcf_options['swtcptcf_change_label'] == '1') echo "checked=\"checked\" "; ?>/>
      </td>
      <td class="swtcptcf_change_label_block <?php if ($swtcptcf_options['swtcptcf_change_label'] == '0') echo "swtcptcf_hidden"; ?>">
        <input type="text" name="swtcptcf_name_label" value="<?php echo $swtcptcf_options['swtcptcf_name_label']; ?>" /> <span class="swtcptcf_info"><?php _e("Name:", 'sweetcaptcha'); ?></span><br />
        <input type="text" name="swtcptcf_email_label" value="<?php echo $swtcptcf_options['swtcptcf_email_label']; ?>" /> <span class="swtcptcf_info"><?php _e("E-Mail Address:", 'sweetcaptcha'); ?></span><br />
        <input type="text" name="swtcptcf_subject_label" value="<?php echo $swtcptcf_options['swtcptcf_subject_label']; ?>" /> <span class="swtcptcf_info"><?php _e("Subject:", 'sweetcaptcha'); ?></span><br />
        <input type="text" name="swtcptcf_message_label" value="<?php echo $swtcptcf_options['swtcptcf_message_label']; ?>" /> <span class="swtcptcf_info"><?php _e("Message:", 'sweetcaptcha'); ?></span><br />
      </td>
    </tr>
    <tr valign="top" class="swtcptcf_additions_block <?php if ($swtcptcf_options['swtcptcf_additions_options'] == '0') echo "swtcptcf_hidden"; ?>">
      <th scope="row"><?php _e("Action after the send mail", 'sweetcaptcha'); ?></th>
      <td colspan="2" class="swtcptcf_action_after_send_block">
        <input type="radio" id="swtcptcf_action_after_send" name="swtcptcf_action_after_send" value="1" <?php if ($swtcptcf_options['swtcptcf_action_after_send'] == '1') echo "checked=\"checked\" "; ?>/> <span class="swtcptcf_info"><?php _e("Display text", 'sweetcaptcha'); ?></span><br />
        <input type="text" name="swtcptcf_thank_text" value="<?php echo $swtcptcf_options['swtcptcf_thank_text']; ?>" /> <span class="swtcptcf_info"><?php _e("Text", 'sweetcaptcha'); ?></span><br />
        <input type="radio" id="swtcptcf_action_after_send" name="swtcptcf_action_after_send" value="0" <?php if ($swtcptcf_options['swtcptcf_action_after_send'] == '0') echo "checked=\"checked\" "; ?>/> <span class="swtcptcf_info"><?php _e("Redirect to page", 'sweetcaptcha'); ?></span><br />
        <input type="text" name="swtcptcf_redirect_url" value="<?php echo $swtcptcf_options['swtcptcf_redirect_url']; ?>" /> <span class="swtcptcf_info"><?php _e("Url", 'sweetcaptcha'); ?></span><br />
      </td>
  </table>    
</div>
