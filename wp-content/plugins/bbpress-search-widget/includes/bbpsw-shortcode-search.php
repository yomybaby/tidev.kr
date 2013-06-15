<?php
/**
 * Shortcode: "bbPress" search box.
 *
 * @package    bbPress Search Widget
 * @subpackage Shortcode
 * @author     David Decker - DECKERWEB
 * @copyright  Copyright (c) 2013, David Decker - DECKERWEB
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL-2.0+
 * @link       http://genesisthemes.de/en/wp-plugins/bbpress-search-widget/
 * @link       http://deckerweb.de/twitter
 *
 * @since      2.0.0
 */

/**
 * Prevent direct access to this file.
 *
 * @since 2.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_shortcode( 'bbpress-searchbox', 'ddw_bbpsw_shortcode_search' );
/**
 * Shortcode: Search Box (for bbPress Forums & Topics & Replies).
 *
 * @since  2.0.0
 *
 * @param  array 	$defaults 	Default values of Shortcode parameters.
 * @param  array 	$atts 		Attributes passed from Shortcode.
 * @param  string 	$output
 * @param  string 	$bbpsw_label_string
 * @param  string 	$bbpsw_placeholder_string
 * @param  string 	$bbpsw_search_string
 * @param  string 	$form
 *
 * @return string HTML content of the shortcode.
 */
function ddw_bbpsw_shortcode_search( $atts ) {

	/** Set default shortcode attributes */
	$defaults = array(
		'label_text'        => __( 'Search Forums, Topics, Replies for:', 'bbpress-search-widget' ),
		'placeholder_text'  => __( 'Search Forums, Topics, Replies&#x2026;', 'bbpress-search-widget' ),
		'button_text'       => __( 'Search', 'bbpress-search-widget' ),
		'class'             => '',	// easter egg, kind of :)
	);

	/** Default shortcode attributes */
	$atts = shortcode_atts( $defaults, $atts, 'bbpress-searchbox' );

	/** Set filters for various strings */
	$bbpsw_label_string = ( ! empty( $atts[ 'label_text' ] ) ) ? apply_filters( 'bbpsw_filter_label_string', $atts[ 'label_text' ] ) : FALSE;
	$bbpsw_placeholder_string = apply_filters( 'bbpsw_filter_placeholder_string', $atts[ 'placeholder_text' ] );
	$bbpsw_search_string = apply_filters( 'bbpsw_filter_search_string', $atts[ 'button_text' ] );

	/** Construct the search form */
	$form = '<form role="search" method="get" id="searchform" class="searchform bbpsw-search-form" action="' . bbp_get_search_url() . '">';
	$form .= '<div class="bbpsw-form-container">';
		if ( BBPSW_SEARCH_LABEL_DISPLAY && $bbpsw_label_string ) {
			$form .= '<label class="screen-reader-text bbpsw-label" for="s">' . esc_attr__( $bbpsw_label_string ) . '</label>';
			$form .= '<br />';
		}
		$form .= '<input tabindex="' . bbp_get_tab_index() . '" type="text" value="' . esc_attr__( bbp_get_search_terms() ) . '" name="bbp_search" id="bbp_search" class="s bbpsw-search-field" placeholder="' . esc_attr__( $bbpsw_placeholder_string ) . '" />';
		$form .= '<input tabindex="' . bbp_get_tab_index() . '" type="submit" id="bbp_search_submit searchsubmit" class="searchsubmit bbpsw-search-submit" value="' . esc_attr__( $bbpsw_search_string ) . '" />';

	$form .= '</div>';
	$form .= '</form>';

	/** Prepare the shortcode frontend output */
	$output = sprintf(
		'<div id="bbpsw-form-wrapper"%1$s>%2$s</div>',
		! empty( $atts[ 'class' ] ) ? ' class="' . esc_attr( $atts[ 'class' ] ) . '"' : '',
		$form
	);

	/** Return Shortcode's HTML - filterable */
    return apply_filters( 'bbpsw_filter_shortcode_search', $output, $atts );

}  // end of function ddw_bbpsw_shortcode_search