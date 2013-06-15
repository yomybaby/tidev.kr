<?php
/**
 * Plugin Name: bbPress Like Button
 * Plugin URI:  http://jordiplana.com/bbpress-like-button-plugin
 * Description: Add a Like button in all your posts and replies. Let the users appreciate others contribution.
 * Author:      Jordi Plana
 * Author URI:  http://jordiplana.com
 * Version:     1.3
 */

load_plugin_textdomain( 'bbpl', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );

require_once(dirname(__FILE__).'/class.bbpress_like.php');

//Public function for showing the button manually
function bbp_like_button($echo = true){
    global $bbpl;
    $bbpl->bbpl_show_button($echo);
}

//Activation and deactivation hooks
register_activation_hook( __FILE__, array('bbpress_like','plugin_activation') );
//register_uninstall_hook( __FILE__, array('bbpress_like','plugin_uninstall') );