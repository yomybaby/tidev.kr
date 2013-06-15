<?php
/**
 * Main plugin file.
 * Extended search widget for bbPress 2.3+, plus Forum search Shortcode, plus
 *    widgetized not found content area for Form search 'no results'.
 *
 * @package   bbPress Search Widget
 * @author    David Decker
 * @copyright Copyright (c) 2011-2013, David Decker - DECKERWEB
 * @link      http://deckerweb.de/twitter
 *
 * Plugin Name: bbPress Search Widget
 * Plugin URI: http://genesisthemes.de/en/wp-plugins/bbpress-search-widget/
 * Description: Extended search widget for bbPress 2.3+, plus Forum search Shortcode, plus widgetized not found content area for Form search 'no results'.
 * Version: 2.0.0
 * Author: David Decker - DECKERWEB
 * Author URI: http://deckerweb.de/
 * License: GPL-2.0+
 * License URI: http://www.opensource.org/licenses/gpl-license.php
 * Text Domain: bbpress-search-widget
 * Domain Path: /languages/
 *
 * Copyright (c) 2011-2013 David Decker - DECKERWEB
 *
 *     This file is part of bbPress Search Widget,
 *     a plugin for WordPress.
 *
 *     bbPress Search Widget is free software:
 *     You can redistribute it and/or modify it under the terms of the
 *     GNU General Public License as published by the Free Software
 *     Foundation, either version 2 of the License, or (at your option)
 *     any later version.
 *
 *     bbPress Search Widget is distributed in the hope that
 *     it will be useful, but WITHOUT ANY WARRANTY; without even the
 *     implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR
 *     PURPOSE. See the GNU General Public License for more details.
 *
 *     You should have received a copy of the GNU General Public License
 *     along with WordPress. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Prevent direct access to this file.
 *
 * @since 2.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Setting constants.
 *
 * @since 1.0.0
 */
/** Plugin directory */
define( 'BBPSW_PLUGIN_DIR', dirname( __FILE__ ) );

/** Plugin base directory */
define( 'BBPSW_PLUGIN_BASEDIR', dirname( plugin_basename( __FILE__ ) ) );

/** Set filter for plugin's languages directory */
define( 'BBPSW_PLUGIN_LANG_DIR', apply_filters( 'bbpsw_filter_lang_dir', BBPSW_PLUGIN_BASEDIR . '/languages/' ) );

/** Required Version of bbPress Forum plugin (our base) */
define( 'BBPSW_REQUIRED_BBPRESS', '2.3' );


register_activation_hook( __FILE__, 'ddw_bbpsw_activation' );
/**
 * Check the environment when plugin is activated.
 *   - Requirement: bbPress 2.3 or higher needs to be installed and activated.
 *   - Note: register_activation_hook() isn't run after auto or manual upgrade,
 *           only on activation!
 *
 * @since  2.0.0
 *
 * @uses   load_plugin_textdomain()
 * @uses   deactivate_plugins()
 * @uses   plugin_basename()
 * @uses   wp_die()
 *
 * @param  $gest_genesis_deactivation_message
 *
 * @return string Optional plugin activation messages for the user.
 */
function ddw_bbpsw_activation() {

	/** Load translations */
	load_plugin_textdomain( 'bbpress-search-widget', false, BBPSW_PLUGIN_LANG_DIR );

	/** Check for activated bbPress 2.3+ plugin */
	if ( ! function_exists( 'bbp_is_search' ) ) {

		/** If no bbPress 2.3+, deactivate ourself */
		deactivate_plugins( plugin_basename( __FILE__ ) );

		/** Message: no bbPress active */
		$bbpsw_bbpress_deactivation_message = sprintf(
			__( 'Sorry, you cannot use the %1$s plugin unless you have installed the latest version of the %2$sbbPress Forum Plugin%3$s (at least %4$s).', 'bbpress-search-widget' ),
			__( 'bbPress Search Widget', 'bbpress-search-widget' ),
			'<a href="http://wordpress.org/extend/plugins/bbpress/" target="_new"><strong><em>',
			'</em></strong></a>',
			'<code>v' . esc_attr( BBPSW_REQUIRED_BBPRESS ) . '</code>'
		);

		/** Deactivation message */
		wp_die(
			$bbpsw_bbpress_deactivation_message,
			__( 'Plugin', 'bbpress-search-widget' ) . ': ' . __( 'bbPress Search Widget', 'bbpress-search-widget' ),
			array( 'back_link' => true )
		);

	}  // end-if bbPress 2.3+ check

}  // end of function ddw_bbpsw_activation


add_action( 'init', 'ddw_bbpsw_init', 1 );
/**
 * General setup of the plugin:
 *    - Load the text domain for translation of the plugin.
 *    - Load admin helper functions - only within 'wp-admin'.
 *    - Setup helper constant.
 *    - Conditionally load plugin's Shortcode.
 *    - Conditionally load functions/ logic for additional widgetized area.
 * 
 * @since 1.0.0
 *
 * @uses  load_textdomain()	To load translations first from WP_LANG_DIR sub folder.
 * @uses  load_plugin_textdomain() To additionally load default translations from plugin folder (default).
 * @uses  is_admin()
 * @uses  current_user_can()
 *
 * @param string 	$textdomain
 * @param string 	$locale
 * @param string 	$bbpsw_wp_lang_dir
 * @param string 	$bbpsw_lang_dir
 */
function ddw_bbpsw_init() {

	/** Set unique textdomain string */
	$textdomain = 'bbpress-search-widget';

	/** The 'plugin_locale' filter is also used by default in load_plugin_textdomain() */
	$locale = apply_filters( 'plugin_locale', get_locale(), $textdomain );

	/** Set filter for WordPress languages directory */
	$bbpsw_wp_lang_dir = apply_filters(
		'bbpsw_filter_wp_lang_dir',
		WP_LANG_DIR . '/bbpress-search-widget/' . $textdomain . '-' . $locale . '.mo'
	);

	/** Translations: First, look in WordPress' "languages" folder = custom & update-secure! */
	load_textdomain( $textdomain, $bbpsw_wp_lang_dir );

	/** Translations: Secondly, look in plugin's "languages" folder = default */
	load_plugin_textdomain( $textdomain, FALSE, BBPSW_PLUGIN_LANG_DIR );


	/** If 'wp-admin' include admin helper functions */
	if ( is_admin() ) {

		/** Load admin extras */
		require_once( BBPSW_PLUGIN_DIR . '/includes/bbpsw-admin.php' );

	}  // end-if is_admin() check

	/** Add "Widgets Page" link to plugin page */
	if ( is_admin() && current_user_can( 'edit_theme_options' ) ) {

		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ) , 'ddw_bbpsw_widgets_page_link' );

	}  // end-if is_admin() & cap check

	/** Define helper constant for removing search label */
	if ( ! defined( 'BBPSW_SEARCH_LABEL_DISPLAY' ) ) {
		define( 'BBPSW_SEARCH_LABEL_DISPLAY', TRUE );
	}

	/**
	 * Filter for custom disabling of the widgetized no search results area.
	 *
	 * Usage: add_filter( 'bbpsw_filter_noresults_widgetized', '__return_false' );
	 */
	$bbpsw_noresults_widgetized = (bool) apply_filters( 'bbpsw_filter_noresults_widgetized', '__return_true' );

	/** Load Shortcode, plus optional widgetized not found area */
	if ( function_exists( 'bbp_is_search' ) ) {

		/** If bbPress search functionality exists, load our Shortcode stuff */
		require_once( BBPSW_PLUGIN_DIR . '/includes/bbpsw-shortcode-search.php' );

		/** Conditionally add a widgetized content area for bbPress Forum search no results */
		if ( $bbpsw_noresults_widgetized && ! function_exists( 'ddw_gwnf_bbpress_search_actions' ) ) {

			/** Load the needed logic and template content */
			require_once( BBPSW_PLUGIN_DIR . '/includes/bbpsw-widgetized-noresults.php' );

			/** Add the magic bbPress filter to do the heavy lifting, finally! :) */
			add_filter( 'bbp_get_template_part', 'ddw_bbpsw_noresults_template_logic', 10, 3 );

		}  // end-if filter & function check

	}  // end-if bbPress v2.3+ function check

}  // end of function ddw_bbpsw_init


add_action( 'widgets_init', 'ddw_bbpsw_register_widgets' );
/**
 * Register the widget, include plugin file.
 *
 * @since 1.0.0
 *
 * @uses  register_widget()
 */
function ddw_bbpsw_register_widgets() {

	/** Load widget code part */
	require_once( BBPSW_PLUGIN_DIR . '/includes/bbpsw-widget-search.php' );

	/** Register the widget */
	register_widget( 'bbPress_Forum_Plugin_Search' );

}  // end of function ddw_bbpsw_register_widgets


/**
 * Returns current plugin's header data in a flexible way.
 *
 * @since  2.0.0
 *
 * @uses   is_admin()
 * @uses   get_plugins()
 * @uses   plugin_basename()
 *
 * @param  $bbpsw_plugin_value
 * @param  $bbpsw_plugin_folder
 * @param  $bbpsw_plugin_file
 *
 * @return string Plugin data.
 */
function ddw_bbpsw_plugin_get_data( $bbpsw_plugin_value ) {

	/** Bail early if we are not in wp-admin */
	if ( ! is_admin() ) {
		return;
	}

	/** Include WordPress plugin data */
	if ( ! function_exists( 'get_plugins' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	}

	$bbpsw_plugin_folder = get_plugins( '/' . plugin_basename( dirname( __FILE__ ) ) );
	$bbpsw_plugin_file = basename( ( __FILE__ ) );

	return $bbpsw_plugin_folder[ $bbpsw_plugin_file ][ $bbpsw_plugin_value ];

}  // end of function ddw_bbpsw_plugin_get_data