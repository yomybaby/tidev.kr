<?php

/**
 * Add SweetCaptcha jQuery - version >= 1.4 is required to login pages
 * @return void
 */
 
function sweetcaptcha_login_head() {
	global $wp_version;
	$wp_versions = explode( '.', $wp_version );
	if ( ( $wp_versions[ 0 ] >= 2 ) && ( $wp_versions[ 1 ] >= 9 ) ) {
    $jquery = get_option('home') . '/wp-includes/js/jquery/jquery.js';
	} else {
	   // edited voodoo
		$jquery = get_option('home') . '/wp-content/plugins/'.SWEETCAPTCHA_DIR_NAME.'/js/jquery.min.js';
	}
	echo '<script type="text/javascript" src="' . $jquery . '"></script>';
}

/**
 * Add Sweetcaptcha jQuery - version >= 1.4 is required to wordpress pages
 * @return void
 */
/*
function sweetcaptcha_wp_head() {
	//edited voodoo
	wp_enqueue_script( 'jquery' );
  //echo '<script type="text/javascript" src="' . get_bloginfo('siteurl') . '/wp-content/plugins/sweetcaptcha/js/jquery.min.js"></script>';
}
*/

/**
 * Get SweetCaptcha values from POST data
 * @return array
 */
function sweetcaptcha_get_values() {
	return array(
		'sckey'		=> ( isset( $_POST[ 'sckey' ] ) ? $_POST[ 'sckey' ] : '' ),
		'scvalue'	=> ( isset( $_POST[ 'scvalue' ] ) ? $_POST[ 'scvalue' ] : '' )
	);
}

/**
 * Move submit button under SweetCaptcha field.
 * @return string
 */
function sweetcaptcha_move_submit_button() {
	return '<div id="sweetcaptcha-submit-button" class="form-submit"><br /></div>'.
		'<script type="text/javascript">'.
			'var sub = document.getElementById("submit");'.
			'if (sub!=undefined){'.
			'sub.parentNode.removeChild(sub);'.
			'document.getElementById("sweetcaptcha-submit-button").appendChild (sub);'.
			'document.getElementById("submit").tabIndex = 6;}'.
		'</script>';
}

/**
 * Add SweetCaptcha to comment form
 * @return boolean
 */
function sweetcaptcha_comment_form() {
	global $sweetcaptcha_instance, $user_ID, $wp_version;
	$wp_versions = explode( '.', $wp_version );
	if ( get_option( 'sweetcaptcha_form_ommit_users' ) && isset($user_ID) && (int)$user_ID > 0 ) {
		return TRUE;
	}
	echo $sweetcaptcha_instance->get_html();
	echo sweetcaptcha_move_submit_button();
	if ( $wp_versions[ 0 ] >= 3 && $wp_versions[ 1 ] >= 0 ) { 
		echo '<script language="JavaScript">document.getElementById("respond").style.overflow="visible";</script>';
	}
	remove_action( 'comment_form', 'sweetcaptcha_comment_form' );
	return TRUE;
}

/**
 * Add SweetCaptcha check submitted comment form
 * @return boolean
 */
function sweetcaptcha_comment_form_check($comment) {
	global $sweetcaptcha_instance, $user_ID;
	if ( get_option( 'sweetcaptcha_form_ommit_users' ) && isset($user_ID) && (int)$user_ID > 0 ) {
		return $comment;
	}
	if ( !empty( $comment[ 'comment_type' ] ) && ( $comment[ 'comment_type' ] != 'comment' ) ) {
		return $comment;
	}
	$scValues = sweetcaptcha_get_values();
	if ( $sweetcaptcha_instance->check($scValues) != 'false' ) {
        return $comment;
	} else {
		// since 2.0.4
		if (function_exists('wp_die')) {
			wp_die('<strong>' . __( 'ERROR', 'sweetcaptcha' ) . '</strong>: ' . __( SWEETCAPTCHA_ERROR_MESSAGE, 'sweetcaptcha' ) );
		} else {
			die('<strong>' . __( 'ERROR', 'sweetcaptcha' ) . '</strong>: ' . __( SWEETCAPTCHA_ERROR_MESSAGE, 'sweetcaptcha' ));
		}
	}
}

/**
 * SweetCaptcha adjustments for login, registration, lost password,... form
 * @return boolean
 */
function sweetcaptcha_adjust_form() {
	return '
  <script language="JavaScript">
    jQuery(document).ready(function() { 
      jQuery("#sidebar-login-form #captchi li").css("display","block"); 
      jQuery("#sidebar-login-form #captchi").css("max-height","500px");
    });
  </script><br>'
  ;
}

/**
 * Add SweetCaptcha to login form
 * @return boolean
 */
function sweetcaptcha_login_form() {
	global $sweetcaptcha_instance;
	echo $sweetcaptcha_instance->get_html();
	echo '<script language="JavaScript">if (document.getElementById("login")) { document.getElementById("login").style.width = "582px"; } jQuery(document).ready(function(){ jQuery("#sidebar-login-form #captchi li").css("display","block"); jQuery("#sidebar-login-form #captchi").css("max-height","500px");});</script><br>';
	return true;
}

/**
 * Add SweetCaptcha to registration form
 * @return boolean
 */
function sweetcaptcha_registration_form() {
	global $sweetcaptcha_instance;
	if (!get_option('sweetcaptcha_form_registration')) {
		return true;
	}
	echo $sweetcaptcha_instance->get_html();
  //echo sweetcaptcha_adjust_form();
	return true;
}

/**
 * Add SweetCaptcha authetificate check
 * @param $user
 * @return WP_Error
 */
function sweetcaptcha_authenticate($user) {
	global $sweetcaptcha_instance;
	$scValues = sweetcaptcha_get_values();
	if ( !empty( $_POST ) && $sweetcaptcha_instance->check($scValues) == 'false' ) {
		$user = new WP_Error( 'captcha_wrong', '<strong>' . __( 'ERROR', 'sweetcaptcha' ) . '</strong>: ' . __( SWEETCAPTCHA_ERROR_MESSAGE, 'sweetcaptcha' ) );
	}
	return $user;
}

/**
 * Add SweetCaptcha lost password check
 * @param $user
 * @return mixed WP_Error or boolean
 */
function sweetcaptcha_lost_password_check($user) {
	global $sweetcaptcha_instance;
	$scValues = sweetcaptcha_get_values();
	if ( $sweetcaptcha_instance->check($scValues) == 'false' ) {
		$user = new WP_Error( 'captcha_wrong', '<strong>' . __( 'ERROR', 'sweetcaptcha' ) . '</strong>: ' . __(SWEETCAPTCHA_ERROR_MESSAGE, 'sweetcaptcha' ) );
		return $user;
	}
	return TRUE;
}

/**
 * Add SweetCaptcha registration form check
 * @param $errors
 * @return WP_Errors
 */
function sweetcaptcha_register_form_check($errors) {
	global $sweetcaptcha_instance;
	$scValues = sweetcaptcha_get_values();
	if ( $sweetcaptcha_instance->check($scValues) == 'false' ) {
		$errors->add( 'captcha_wrong', '<strong>' . __( 'ERROR', 'sweetcaptcha' ) . '</strong>: ' . __(SWEETCAPTCHA_ERROR_MESSAGE, 'sweetcaptcha' ) );			
	}
	return $errors;
}

/**
 * Add SweetCaptcha to BuddyPress registration form
 * @return boolean
 */
function sweetcaptcha_before_registration_submit_buttons() {
	global $sweetcaptcha_instance;
	echo 
    '<div id="sweetcaptcha-wrapper">' 
    .( ( function_exists('sweetcaptcha_header') ) ? sweetcaptcha_header() : '' )
    . $sweetcaptcha_instance->get_html() 
    . '</div>';
	return TRUE;
}

/**
 * Add SweetCaptcha to BuddyPress registration form validation
 * @return boolean
 */
function sweetcaptcha_signup_validate() {
	global $bp, $sweetcaptcha_instance;
	$scValues = sweetcaptcha_get_values();
	if ( $sweetcaptcha_instance->check($scValues) == 'false' ) {
		$bp->signup->errors['signup_username'] = __(SWEETCAPTCHA_ERROR_MESSAGE, 'sweetcaptcha' );
	}
}

/**
 * Add SweetCaptcha standard check (use for Contact Form 7)
 */
function sweetcaptcha_check($errors, $tag = '') {
	global $sweetcaptcha_instance;
	$scValues = sweetcaptcha_get_values();
	if ( $sweetcaptcha_instance->check( $scValues ) != 'true' ) {
		if ( !empty( $tag ) ) { 
			$errors['valid'] = false;
			$errors['reason']['your-sweetcaptcha'] = __(SWEETCAPTCHA_ERROR_MESSAGE, 'sweetcaptcha' );
		} else {
			$errors['errors']->add( 'sweetcaptcha', '<strong>' . __( 'ERROR', 'sweetcaptcha' ) . '</strong>: ' . __(SWEETCAPTCHA_ERROR_MESSAGE, 'sweetcaptcha' ) );
		}
	}
  //var_dump($errors); die();
	return $errors;
}

/**
 * Add SweetCaptcha to Wordpress Network sign-up form 
 * @param $errors
 * @return boolean
 */
function sweetcaptcha_signup_extra_fields($errors) {
	global $sweetcaptcha_instance;
	$error = $errors->get_error_message( 'captcha_wrong' );
	echo $sweetcaptcha_instance->get_html();
	if ( isset($error) && !empty( $error ) ) {
		echo '<p class="error">' . $error . '</p>';
	}
	return true;
}

/**
 * Add SweetCaptcha validation to Wordpress Network sign-up form
 * @param $errors
 * @return mixed
 */
function sweetcaptcha_wpmu_validate_user_signup($errors) {
	global $sweetcaptcha_instance;
	if ( $_POST['stage'] == 'validate-user-signup' ) {
		$scValues = sweetcaptcha_get_values();
		if ( $sweetcaptcha_instance->check( $scValues ) == 'false' ) {
			$errors['errors']->add( 'captcha_wrong', '<strong>' . __( 'ERROR', 'sweetcaptcha' ) . '</strong>: ' . __(SWEETCAPTCHA_ERROR_MESSAGE, 'sweetcaptcha' ) );
		}
		
	}
	return $errors;
}

/**
 * Add SweetCaptcha short code to Contact Form 7
 * @return a string with HTML code
 */
function sweetcaptcha_shortcode_cf7() {
  $input = '<span class="wpcf7-form-control-wrap your-sweetcaptcha"><input type="text" name="your-sweetcaptcha" value="" size="1" class="wpcf7-form-control wpcf7-text" style="display:none;" /></span>';
  $sc = $input.sweetcaptcha_shortcode();
	return $sc;
}

/**
 * Add SweetCaptcha short code
 * @param $atts
 * @return string
 */
function sweetcaptcha_shortcode( $atts = array() ) {
	global $sweetcaptcha_instance;
	return ( ( function_exists('sweetcaptcha_header') ) ? sweetcaptcha_header() : '' ).$sweetcaptcha_instance->get_html();
}

/**
 * Validate SweetCaptcha form
 * @param $errors
 * @param $tag
 * @return mixed array
 */
function sweetcaptcha_validate($errors, $tag = NULL) {
	global $sweetcaptcha_instance;
	$scValues = sweetcaptcha_get_values();
	if ( $sweetcaptcha_instance->check( $scValues ) != 'true' ) {
		if ( !empty( $tag ) ) { // if Contact Form 7
			$errors['valid'] = false;
			$errors['reason']['your-message'] = __(SWEETCAPTCHA_ERROR_MESSAGE, 'sweetcaptcha' );
		} else {
			$errors['errors']->add( 'sweetcaptcha', '<strong>' . __( 'ERROR', 'sweetcaptcha' ) . '</strong>: ' . __(SWEETCAPTCHA_ERROR_MESSAGE, 'sweetcaptcha' ) );
		}
	}
	return $errors;
}
