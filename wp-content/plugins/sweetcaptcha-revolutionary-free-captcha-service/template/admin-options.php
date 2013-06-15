<script  type="text/javascript">
  jQuery(document).ready(function($) {
    jQuery('#sweetcaptcha_form_contact').click(function () {
      //jQuery("#sweetcaptcha_form_contact_options").slideToggle("fast");
      if (this.checked) {
      
      } else {
      
      }
    })
  });
</script>
<div class="wrap">
  <div style="height:66px;">
    <div class="icon32 icon32-bws" id="icon-options-sweetcaptcha"></div>
    <h2 style="height: 100%; padding-left: 150px; padding-top: 20px;"><?php _e('SweetCaptcha Settings', 'sweetcaptcha'); ?></h2>
  </div>
  <p style="margin-top: 5px; "><?php _e('Congratulations on your new SweetCaptcha!', 'sweetcaptcha'); ?></p>

  <div style="font-style: italic; margin-left: 10px; background: #eeeeee; padding:6px 4px 4px 4px; height:52px; width:410px; clear: both;
       -moz-box-shadow:    -2px -2px 10px 2px #E2E2E2;
       -webkit-box-shadow: -2px -2px 10px 2px #E2E2E2;
       box-shadow:         -2px -2px 10px 2px #E2E2E2;"
       >
    <div style="float:left;">
      If you like this plug-in and find it useful, help <br>keep this plug-in free and actively developed <br>
      by clicking the <a href="javascript:void(0)" onclick="document.formDonate.submit();">donate</a> button.
    </div>
    <!--<a style="display: block; float:left;margin-left: 10px;" href="http://www.paypal.com/" target="_new">
      <img style="width:100px; height:48px;" src="<?php //echo plugins_url('donate-paypal-100x48.png', __FILE__);      ?>" alt="Donate with PayPal"/>
    </a>-->
    <div style="float:right; padding:0; margin:0;margin-top: -2px;">
      <form action="https://www.paypal.com/cgi-bin/webscr" method="post" name="formDonate" target="_blank">
        <input type="hidden" name="cmd" value="_s-xclick">
        <input type="hidden" name="hosted_button_id" value="KJ9FG7STBXQ76">
        <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" name="submit" alt="PayPal - The safer, easier way to pay online!">
        <img style="width:1; height:1px; border:none; padding:0; margin:0;" alt="" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif">
      </form>
    </div>

  </div>

  <?php if (!empty($message)): ?>
    <div class="updated" style="width:99%; float: left">
      <p><strong><?php echo $message; ?></strong></p>
    </div>
  <?php endif; ?>

  <form name="form1" method="post" action="">
    <input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
    <table class="form-table">
      <tbody>
        <?php
        if (!empty($sweetcaptcha_options) && is_array($sweetcaptcha_options)):
          foreach ($sweetcaptcha_options as $opt_name => $opt):
        ?>
        <tr valign="top">
          <th scope="row" style="min-width: 15%"><label for="<?php echo $opt_name ?>"><?php echo $opt['title'] . ':'; ?></label></th>
          <?php
            if (!substr_count($opt_name, '_form_')) {
              $type = 'text';
              $checked = null;
              $class = ' class="regular-text"';
              $value = isset($options_values[$opt_name]) ? $options_values[$opt_name] : null;
            } else {
              $type = 'checkbox';
              $checked = isset($options_values[$opt_name]) && !empty($options_values[$opt_name]) ? ' checked="checked"' : null;
              $class = null;
              $value = 1;
            }
          ?>
          <td>
            <input<?php echo $class ?> id="<?php echo $opt_name ?>" type="<?php echo $type ?>" name="<?php echo $opt_name ?>" value="<?php echo $value ?>" size="50"<?php echo $checked ?> />
            <?php if (isset($sweetcaptcha_options[$opt_name]['description'])): ?>
            <span class="description">
            <?php echo $sweetcaptcha_options[$opt_name]['description']; ?>
            </span>
            <?php endif; ?>
          </td>
        </tr>
        
        <?php
        if ($opt_name == 'sweetcaptcha_form_contact_7') {
        ?>
        <tr>
          <td colspan="2" style="padding-top: 0px; padding-left: 20px;">
            <?php echo __('To integrate SweetCaptcha with Contact Form 7 please do the following:') . '<br />'; ?>
            <?php echo __('A. Copy the following tag with square brackets [sweetcaptcha]') . '<br />'; ?> 
            <?php echo __('B. Open the page with settings of Contact Form 7') . '<br />'; ?>
            <?php echo __('C. Paste the copied tag into "Form" section above the line which contains "&lt;p&gt;[submit "Send"]&lt;/p&gt;"') . '<br />'; ?>
            <?php printf(__('D. Need more help ?  <a href="%s" title="Contact us" target="_blank">Contact us</a>.'), 'http://'.SWEETCAPTCHA_SITE_URL.'/contact.php'); ?>
          </td>
        </tr>
        <?php } ?>
        
        <?php if ($opt_name == 'sweetcaptcha_form_contact') { ?>
        <tr>
          <td colspan="2" style="padding-top: 0px; padding-left: 20px;">
          <?php
          $display_cfoptions = ''; //( $checked ) ? '' : 'display:none;';
          include 'admin-options-contactform.php';
          ?>
          </td>
        </tr>
        <?php } ?>
        
        <?php
          endforeach;
        endif;
        ?>
      </tbody>
    </table>

    <p class="submit">
      <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
    </p>
    <p>
      <strong>How does your site FEEL today? Download this awesome FREE plugin.<br />
        <a href="http://wordpress.org/extend/plugins/Jumpple/" target="_blank">Jumpple</a> - Your website monitor.Protect your website with JUMPPLE - Jumpple on!.</strong>
    </p>
  </form>
</div>