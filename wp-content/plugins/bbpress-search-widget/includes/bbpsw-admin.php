<?php
/**
 * Helper functions for the admin - plugin links and help tabs.
 *
 * @package    bbPress Search Widget
 * @subpackage Admin
 * @author     David Decker - DECKERWEB
 * @copyright  Copyright (c) 2011-2013, David Decker - DECKERWEB
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL-2.0+
 * @link       http://genesisthemes.de/en/wp-plugins/bbpress-search-widget/
 * @link       http://deckerweb.de/twitter
 *
 * @since      1.0.0
 */

/**
 * Prevent direct access to this file.
 *
 * @since 1.1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Setting helper links constant
 *
 * @since 1.2.0
 *
 * @uses  get_locale()
 */
define( 'BBPSW_URL_TRANSLATE',		'http://translate.wpautobahn.com/projects/wordpress-plugins-deckerweb/bbpress-search-widget' );
define( 'BBPSW_URL_WPORG_FAQ',		'http://wordpress.org/extend/plugins/bbpress-search-widget/faq/' );
define( 'BBPSW_URL_WPORG_FORUM',	'http://wordpress.org/support/plugin/bbpress-search-widget' );
define( 'BBPSW_URL_WPORG_PROFILE',	'http://profiles.wordpress.org/daveshine/' );
define( 'BBPSW_URL_SNIPPETS',		'https://gist.github.com/???' );
define( 'BBPSW_PLUGIN_LICENSE', 	'GPL-2.0+' );
if ( get_locale() == 'de_DE' || get_locale() == 'de_AT' || get_locale() == 'de_CH' || get_locale() == 'de_LU' ) {
	define( 'BBPSW_URL_DONATE', 	'http://genesisthemes.de/spenden/' );
	define( 'BBPSW_URL_PLUGIN',		'http://genesisthemes.de/plugins/bbpress-search-widget/' );
} else {
	define( 'BBPSW_URL_DONATE', 	'http://genesisthemes.de/en/donate/' );
	define( 'BBPSW_URL_PLUGIN', 	'http://genesisthemes.de/en/wp-plugins/bbpress-search-widget/' );
}


/**
 * Add "Widgets Page" link to plugin page.
 *
 * @since  1.0.0
 *
 * @param  $bbpsw_links
 * @param  $bbpsw_widgets_link
 *
 * @return strings widgets link
 */
function ddw_bbpsw_widgets_page_link( $bbpsw_links ) {

	/** Widgets Admin link */
	$bbpsw_widgets_link = sprintf(
		'<a href="%s" title="%s">%s</a>',
		admin_url( 'widgets.php' ),
		__( 'Go to the Widgets settings page', 'bbpress-search-widget' ),
		__( 'Widgets', 'bbpress-search-widget' )
	);

	/** Set the order of the links */	
	array_unshift( $bbpsw_links, $bbpsw_widgets_link );

	/** Display plugin settings links */
	return apply_filters( 'bbpsw_filter_settings_page_link', $bbpsw_links );

}  // end of function ddw_bbpsw_widgets_page_link


add_filter( 'plugin_row_meta', 'ddw_bbpsw_plugin_links', 10, 2 );
/**
 * Add various support links to plugin page.
 *
 * @since  1.0.0
 *
 * @param  $bbpsw_links
 * @param  $bbpsw_file
 *
 * @return strings plugin links
 */
function ddw_bbpsw_plugin_links( $bbpsw_links, $bbpsw_file ) {

	/** Capability check */
	if ( ! current_user_can( 'install_plugins' ) ) {

		return $bbpsw_links;

	}  // end-if cap check

	/** List additional links only for this plugin */
	if ( $bbpsw_file == BBPSW_PLUGIN_BASEDIR . '/bbpress-search-widget.php' ) {

		$bbpsw_links[] = '<a href="' . esc_url( BBPSW_URL_WPORG_FAQ ) . '" target="_new" title="' . __( 'FAQ', 'bbpress-search-widget' ) . '">' . __( 'FAQ', 'bbpress-search-widget' ) . '</a>';

		$bbpsw_links[] = '<a href="' . esc_url( BBPSW_URL_WPORG_FORUM ) . '" target="_new" title="' . __( 'Support', 'bbpress-search-widget' ) . '">' . __( 'Support', 'bbpress-search-widget' ) . '</a>';

		$bbpsw_links[] = '<a href="' . esc_url( BBPSW_URL_TRANSLATE ) . '" target="_new" title="' . __( 'Translations', 'bbpress-search-widget' ) . '">' . __( 'Translations', 'bbpress-search-widget' ) . '</a>';

		$bbpsw_links[] = '<a href="' . esc_url( BBPSW_URL_DONATE ) . '" target="_new" title="' . __( 'Donate', 'bbpress-search-widget' ) . '"><strong>' . __( 'Donate', 'bbpress-search-widget' ) . '</strong></a>';

	}  // end-if plugin links

	/** Output the links */
	return apply_filters( 'bbpsw_filter_plugin_links', $bbpsw_links );

}  // end of function ddw_bbpsw_plugin_links


add_action( 'sidebar_admin_setup', 'ddw_bbpsw_widgets_help' );
/**
 * Load plugin help tab after core help tabs on Widget admin page.
 *
 * @since  1.2.0
 *
 * @global mixed $pagenow
 */
function ddw_bbpsw_widgets_help() {

	global $pagenow;

	add_action( 'admin_head-' . $pagenow, 'ddw_bbpsw_widgets_help_tab' );

}  // end of function ddw_bbpsw_widgets_help


add_action( 'load-settings_page_bbpress', 'ddw_bbpsw_widgets_help_tab', 20 );
/**
 * Create and display plugin help tab content.
 *
 * @since  1.2.0
 *
 * @uses   get_current_screen()
 * @uses   WP_Screen::add_help_tab()
 * @uses   WP_Screen::set_help_sidebar()
 * @uses   ddw_bbpsw_help_sidebar_content()
 *
 * @global mixed $bbpsw_widgets_screen, $pagenow
 */
function ddw_bbpsw_widgets_help_tab() {

	global $bbpsw_widgets_screen, $pagenow;

	$bbpsw_widgets_screen = get_current_screen();

	/** Display help tabs only for WordPress 3.3 or higher */
	if( ! class_exists( 'WP_Screen' ) || ! $bbpsw_widgets_screen || ! class_exists( 'bbPress' ) ) {
		return;
	}

	/** Add the new help tab */
	$bbpsw_widgets_screen->add_help_tab( array(
		'id'       => 'bbpsw-widgets-help',
		'title'    => __( 'bbPress Search Widget', 'bbpress-search-widget' ),
		'callback' => apply_filters( 'bbpsw_filter_help_tab_content', 'ddw_bbpsw_help_tab_content' ),
	) );

	/** Add help sidebar */
	if ( $pagenow != 'widgets.php' ) {

		$bbpsw_widgets_screen->set_help_sidebar( ddw_bbpsw_help_sidebar_content() );

	}  // end-if $pagehook check

}  // end of function ddw_bbpsw_widgets_help_tab


/**
 * Create and display plugin help tab content.
 *
 * @since 1.0.0
 *
 * @uses  ddw_bbpsw_plugin_get_data()
 *
 * @param bool 	$bbpsw_noresults_widgetized
 */
function ddw_bbpsw_help_tab_content() {

	/** Helper variable */
	$bbpsw_noresults_widgetized = (bool) apply_filters( 'bbpsw_filter_noresults_widgetized', '__return_true' );

	/** Headline */
	echo '<h3>' . __( 'Plugin', 'bbpress-search-widget' ) . ': ' . __( 'bbPress Search Widget', 'bbpress-search-widget' ) . ' <small>v' . esc_attr( ddw_bbpsw_plugin_get_data( 'Version' ) ) . '</small></h3>';

	/** Search widget info */
	echo '<p><strong>' . sprintf( __( 'Added Widget by the plugin: %s', 'bbpress-search-widget' ), '<em>' . __( 'bbPress: Forum Search Extended', 'bbpress-search-widget' ) . '</em>' ) . '</strong></p>' .
		'<ul>' .
			'<li>' . __( 'All search form relevent strings, for example the search button, can easily be changed.', 'bbpress-search-widget' ) . ' ' .
				sprintf(
					__( 'Also, the widget comes lots of visibility options so you can setup it really fast. This should work for most use cases. However, if you still need more, use plugins like %1$s or %2$s (then leave all options unchecked and set visibility to %3$s).', 'bbpress-search-widget' ),
					'<em>Widget Logic</em>',
					'<em>Widget Display</em>',
					'<code>' . __( 'Global (default)', 'bbpress-search-widget' ) . '</code>'
				) . '</li>' .
			'<li>' . sprintf(
				__( 'It searches only in the bbPress specific post types %1$s, %2$s and %3$s and outputs the results formatted like the other regular views of bbPress.', 'bbpress-search-widget' ),
				'<em>' . __( 'Forum', 'bbpress-search-widget' ) . '</em>',
				'<em>' . __( 'Topic', 'bbpress-search-widget' ) . '</em>',
				'<em>' . __( 'Reply', 'bbpress-search-widget' ) . '</em>'
			) . '</li>' .
			'<li>' . __( 'Please note: This plugin does not mix up its displayed search results with WordPress built-in search. It is limited to the bbPress forum post types. For enhanced styling of the widget and/or the search results please have a look on the FAQ page linked below.', 'bbpress-search-widget' ) . '</li>' .
		'</ul>';

	/** Shortcode info, plus parameters */
	echo '<p><strong>' . sprintf( __( 'Provided Shortcode by the plugin: %s', 'bbpress-search-widget' ), '<code>[bbpress-searchbox]</code>' ) . '</strong></p>' .
		'<ul>' .
			'<li><em>' . __( 'Supporting the following parameters', 'bbpress-search-widget' ) . ':</em></li>' .
			'<li><code>label_text</code> &mdash; ' . __( 'Label text before the input field', 'bbpress-search-widget' ) . '</li>' .
			'<li><code>placeholder_text</code> &mdash; ' . __( 'Input field placeholder text', 'bbpress-search-widget' ) . '</li>' .
			'<li><code>button_text</code> &mdash; ' . __( 'Submit button text', 'bbpress-search-widget' ) . '</li>' .
			'<li><code>class</code> &mdash; ' . sprintf( __( 'Can be a custom class, added to the wrapper %s container', 'bbpress-search-widget' ), '<code>div</code>' ) . '</li>' .
		'</ul>';

	/** Only show help info if widgetized area is enabled */
	if ( $bbpsw_noresults_widgetized && ! function_exists( 'ddw_gwnf_bbpress_search_actions' ) ) {

		echo '<p><strong>' . sprintf( __( 'Widgetized content area for %s forum search results:', 'bbpress-search-widget' ), '<em>*' . __( 'Not found', 'bbpress-search-widget' ) . '*</em>' ) . '</strong></p>' .
			'<ul>' .
				'<li>' . __( 'Registered widget area, only if bbPress is active:', 'bbpress-search-widget' ) . ' <em>' . __( 'bbPress: Forum Search No Results', 'bbpress-search-widget' ) . '</em></li>' .
				'<li>' . sprintf( __( 'Actually used on the frontend, only if there are %s widgets in this area!', 'bbpress-search-widget' ), '<em>' . __( 'active', 'bbpress-search-widget' ) . '</em>' ) . '</li>' .
			'</ul>';

	}  // end-if filter check

	/** Help footer: plugin info */
	echo '<p><strong>' . __( 'Important plugin links:', 'bbpress-search-widget' ) . '</strong>' . 
		'<blockquote><a href="' . esc_url( BBPSW_URL_PLUGIN ) . '" target="_new" title="' . __( 'Plugin Homepage', 'bbpress-search-widget' ) . '">' . __( 'Plugin Homepage', 'bbpress-search-widget' ) . '</a> | <a href="' . esc_url( BBPSW_URL_WPORG_FAQ ) . '" target="_new" title="' . __( 'FAQ', 'bbpress-search-widget' ) . '">' . __( 'FAQ', 'bbpress-search-widget' ) . '</a> | <a href="' . esc_url( BBPSW_URL_WPORG_FORUM ) . '" target="_new" title="' . __( 'Support', 'bbpress-search-widget' ) . '">' . __( 'Support', 'bbpress-search-widget' ) . '</a> | <a href="' . esc_url( BBPSW_URL_TRANSLATE ) . '" target="_new" title="' . __( 'Translations', 'bbpress-search-widget' ) . '">' . __( 'Translations', 'bbpress-search-widget' ) . '</a> | <a href="' . esc_url( BBPSW_URL_DONATE ) . '" target="_new" title="' . __( 'Donate', 'bbpress-search-widget' ) . '"><strong>' . __( 'Donate', 'bbpress-search-widget' ) . '</strong></a></blockquote>';

	echo '<blockquote><a href="http://www.opensource.org/licenses/gpl-license.php" target="_new" title="' . esc_attr( BBPSW_PLUGIN_LICENSE ). '">' . esc_attr( BBPSW_PLUGIN_LICENSE ). '</a> &copy; 2011-' . date( 'Y' ) . ' <a href="' . esc_url( ddw_bbpsw_plugin_get_data( 'AuthorURI' ) ) . '" target="_new" title="' . esc_attr__( ddw_bbpsw_plugin_get_data( 'Author' ) ) . '">' . esc_attr__( ddw_bbpsw_plugin_get_data( 'Author' ) ) . '</a></blockquote></p>';

}  // end of function ddw_bbpsw_help_tab_content


/**
 * Helper function for returning the Help Sidebar content.
 *
 * @since  2.0.0
 *
 * @uses   ddw_bbpsw_plugin_get_data()
 *
 * @param  $bbpsw_help_sidebar
 *
 * @return string HTML content for help sidebar.
 */
function ddw_bbpsw_help_sidebar_content() {

	$bbpsw_help_sidebar = '<p><strong>' . __( 'More about the plugin author', 'bbpress-search-widget' ) . '</strong></p>' .
		'<p>' . __( 'Social:', 'bbpress-search-widget' ) . '<br /><a href="http://twitter.com/#!/deckerweb" target="_blank">Twitter</a> | <a href="http://www.facebook.com/deckerweb.service" target="_blank">Facebook</a> | <a href="http://deckerweb.de/gplus" target="_blank">Google+</a> | <a href="' . esc_url( ddw_bbpsw_plugin_get_data( 'AuthorURI' ) ) . '" target="_blank" title="@ deckerweb.de">deckerweb</a></p>' .
		'<p><a href="' . esc_url( BBPSW_URL_WPORG_PROFILE ) . '" target="_blank" title="@ WordPress.org">@ WordPress.org</a></p>';

	return apply_filters( 'bbpsw_filter_help_sidebar_content', $bbpsw_help_sidebar );

}  // end of function ddw_bbpsw_help_sidebar_content