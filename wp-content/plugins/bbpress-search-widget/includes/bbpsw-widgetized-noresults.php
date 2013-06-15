<?php
/**
 * Widgetized content area for bbPress Forum search no resulsts status.
 *
 * @package    bbPress Search Widget
 * @subpackage Widgets
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


add_action( 'init', 'ddw_bbpsw_widgetized_noresults_area' );
/**
 * Register widget area for bbPress Forum search no results status.
 *
 * Note: Forgive this one inline styling rule (at 'before_widget'), please! :)
 *       It just adds appropriate spacing; avoids extra stylesheet HTTP request!
 *
 * @since 2.0.0
 *
 * @uses  register_sidebar()
 *
 * @param string 	$bbpsw_noresults_widget_title
 * @param string 	$bbpsw_noresults_widget_description
 */
function ddw_bbpsw_widgetized_noresults_area() {

	$bbpsw_noresults_widget_title = apply_filters( 'bbpsw_filter_noresults_widget_title', __( 'bbPress: Forum Search No Results', 'bbpress-search-widget' ) );

	$bbpsw_noresults_widget_description = apply_filters( 'bbpsw_filter_noresults_widget_title', __( 'Only for bbPress 2.3+: Widgetized content area if there are no forum search results.', 'bbpress-search-widget' ) );

	/** Register Sidebar for widgetized "no results" area ---test: bbp-pagination */
	register_sidebar( array(
		'id'            => 'bbpsw-bbpress-notfound-area',
		'name'          => esc_attr__( $bbpsw_noresults_widget_title ),
		'description'   => esc_attr__( $bbpsw_noresults_widget_description ),
		'before_widget' => '<div id="%1$s" class="widget bbpsw-widgetized-noresults %2$s" style="margin-bottom: 30px;">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widgettitle">',
		'after_title'   => '</h3>',
	) );

}  // end of function ddw_bbpsw_widgetized_noresults_area


/**
 * Template logic helper function for bbPress filter 'bbp_get_template_part'.
 *
 * @since  2.0.0
 *
 * @param  array 	$templates
 * @param  string 	$slug
 * @param  string 	$name
 *
 * @return array Array of template parts for bbPress.
 */
function ddw_bbpsw_noresults_template_logic( $templates, $slug, $name ) {

	/** Only do stuff when on 'feedback-no-search.php' template part: */
	if ( $slug == 'feedback' && $name == 'no-search' ) {

		/** Only for no forum search results, remove this original bbPress filter */
		remove_filter( 'the_content', 'bbp_replace_the_content' );

		/**
		 * Add our widgetized area instead.
		 *
		 * Note: This needs to happen early on, BEFORE the original bbPress content.
		 */
		add_action( 'the_content', 'ddw_bbpsw_widgetized_noresults_content', 5 );

	}  // end-if bbPress template part check

	/** Let bbPress take over its templates again */
	return $templates;

}  // end of function ddw_bbpsw_noresults_template_logic


/**
 * Our template part:
 *    Widgetized content area, when there are no bbPress Forum search results.
 *
 * @since 2.0.0
 *
 * @uses  bbp_breadcrumb() 	Original bbPress breadcrumb functionality.
 * @uses  do_action() 		Original bbPress action hooks.
 * @uses  dynamic_sidebar()
 */
function ddw_bbpsw_widgetized_noresults_content() {

	/** Let bbPress take over its own Breadcrumbs */
	echo '<div id="bbpress-forums">';
		bbp_breadcrumb();
	echo '</div>';

	/** Add bbPress own "before" action hook */
	do_action( 'bbp_template_before_search' );

	/** Here is where the magic happens - our widgetized area gets displayed */
	echo '<div id="bbpsw-widgetized-content" class="bbpsw-bbpress-notfound-area entry-content">';

		dynamic_sidebar( 'bbpsw-bbpress-notfound-area' );

	echo '</div><!-- end #content .bbpsw-bbpress-notfound-area .entry-content -->';

	/** Add bbPress own "after" action hook */
	do_action( 'bbp_template_after_search_results' );

}  // end of function ddw_bbpsw_widgetized_noresults_content