<?php
/**
 * BBPSW: Search Forums (Topics, Replies) Widget.
 *
 * @package    bbPress Search Widget
 * @subpackage Widgets
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
 * @since 2.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * The main plugin class - creating the bbPress search widget
 *
 * @since 1.0.0
 */
class bbPress_Forum_Plugin_Search extends WP_Widget {

	/**
	 * Constructor.
	 *
	 * Set up the widget's unique name, ID, class, description, and other options.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
	
		$widget_options = apply_filters( 'bbpsw_filter_search_widget_options', array(
			'classname'   => 'bbpsw-search',
			'description' => esc_html__( 'Search box for the bbPress 2.x forum plugin. Search in forum topics and replies only. (No mix up with regular WordPress search!)', 'bbpress-search-widget' ),
		) );

		/* Set up (additional) widget control options. */
		$control_options = array(
			'id_base' => 'bbpsw-search',
			'width'   => 375
		);

		/** Create the widget */
		parent::__construct(
			'bbpsw-search',
			__( 'bbPress: Forum Search Extended', 'bbpress-search-widget' ),
			$widget_options,
			$control_options
		);

	}  // end of method __construct


	/**
	 * Display the widget, based on the parameters/ arguments set through the
	 *    widget options.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args Display arguments including before_title, after_title, before_widget, and after_widget.
	 * @param array $instance The settings for the particular instance of the widget.
	 */
	public function widget( $args, $instance ) {
	
		/** bbPress v2.3+ check -- this is required for that widget to work! */
		if ( ! function_exists( 'bbp_is_search' ) ) {
			return;
		}

		/** Check SPECIFIC display option for this widget and optionally disable it from displaying */
		if ( ( $instance[ 'not_in_bbpbase' ] && bbp_is_forum_archive() )
			|| ( $instance[ 'not_in_bbpsearch' ] && bbp_is_search() )
			|| ( $instance[ 'not_in_public' ] && ! is_user_logged_in() )
		) {
			return;
		}

		/** Check GENERAL display option for this widget and optionally disable it from displaying */
		if (
				/** Forums: single */
			( ( 'single_forums' == $instance[ 'widget_display' ] ) && ! bbp_is_single_forum() )

				/** Topics: single */
			|| ( ( 'single_topics' == $instance[ 'widget_display' ] ) && ! bbp_is_single_topic() )

				/** Both, single Forums & Topics */
			|| ( ( 'single_forums_topics' == $instance[ 'widget_display' ] ) && ! ( bbp_is_single_forum() || bbp_is_single_topic() ) )

				/** Forums: archives */
			|| ( ( 'forums_archives' == $instance[ 'widget_display' ] ) && ! bbp_is_forum_archive() )

				/** Forums: archives */
			|| ( ( 'topics_archives' == $instance[ 'widget_display' ] ) && ! bbp_is_topic_archive() )

				/** Both, Forums & Topics archives */
			|| ( ( 'archives_forums_topics' == $instance[ 'widget_display' ] ) && ! is_post_type_archive( array( 'forum', 'topic' ) ) )

				/** Topics: taxonomies */
			|| ( ( 'topics_tax' == $instance[ 'widget_display' ] ) && ! bbp_is_topic_tag() )

				/** Forums & Topics: global (bbPress post types) */
			|| ( ( 'bbpress_global' == $instance[ 'widget_display' ] )
				&& ! ( is_bbpress()
						|| bbp_is_single_forum()
						|| bbp_is_single_topic()
						|| bbp_is_forum()
						|| bbp_is_topic()
						|| bbp_is_forum_archive()
						|| bbp_is_topic_archive()
						|| bbp_is_topic_tag()
						|| bbp_is_reply()
						|| bbp_is_single_reply()
						|| bbp_is_user_home()
						|| bbp_is_favorites()
						|| bbp_is_subscriptions()
						|| bbp_is_topics_created()
						|| bbp_is_replies_created()
						|| bbp_is_single_user()
						|| bbp_is_single_user_profile()
						|| bbp_is_single_user_topics()
						|| bbp_is_single_user_replies()
						|| bbp_is_search()
					)
				)

				/** Posts/ Pages stuff */
			|| ( ( 'single_posts' == $instance[ 'widget_display' ] ) && ! is_singular( 'post' ) )
			|| ( ( 'single_pages' == $instance[ 'widget_display' ] ) && ! is_singular( 'page' ) )
			|| ( ( 'single_posts_pages' == $instance[ 'widget_display' ] ) && ! is_singular( array( 'post', 'page' ) ) )
		) {

			return;

		}  // end-if widget display checks


		/** Extract the widget arguments */
		extract( $args );

		/** Set up the arguments */
		$args = array(
			'intro_text' => $instance[ 'intro_text' ],
			'outro_text' => $instance[ 'outro_text' ]
		);

		$instance = wp_parse_args( (array) $instance, array(
			'title'            => '',
			'label_text'       => '',
			'placeholder_text' => '',
			'button_text'      => ''
		) );

		/** Optional title URL target */
		$title_url_target = ( $instance[ 'title_url_target' ] ) ? ' target="_blank"' : '';

		/** Typical WordPress Widget title filter */
		$title = apply_filters( 'widget_title', $instance[ 'title' ], $instance, $this->id_base );

		/** BBPSW Widget title filter */
		$title = apply_filters( 'bbpsw_filter_search_widget_title', $instance[ 'title' ], $instance, $this->id_base );

		/** Build the title display string */
		$title_display = sprintf(
			'%1$s%2$s%3$s',
			( ! empty( $instance[ 'title_url' ] ) ) ? '<a href="' . esc_url( $instance[ 'title_url' ] ) . '"' . $title_url_target . '>' : '',
			esc_attr( $instance[ 'title' ] ),
			( ! empty( $instance[ 'title_url' ] ) ) ? '</a>' : ''
		);

		/** Output the widget wrapper and title */
		echo $before_widget;

		/** Display the widget title */
		if ( empty( $instance[ 'hide_title' ] ) && $instance[ 'title' ] ) {

			echo $before_title . $title_display . $after_title;

		}  // end-if title

		/** Action hook 'bbpsw_before_search_widget' */
		do_action( 'bbpsw_before_search_widget' );

		/** Display widget intro text if it exists */
		if ( ! empty( $instance[ 'intro_text' ] ) ) {

			echo '<div class="textwidget"><p class="'. $this->id . '-intro-text bbpsw-intro-text">' . $instance[ 'intro_text' ] . '</p></div>';

		}  // end-if optional intro

		/** Set filters for various strings */
		$bbpsw_label_string = ( ! empty( $instance[ 'label_text' ] ) ) ? apply_filters( 'bbpsw_filter_label_string', $instance[ 'label_text' ] ) : FALSE;
		$bbpsw_placeholder_string = apply_filters( 'bbpsw_filter_placeholder_string', $instance[ 'placeholder_text' ] );
		$bbpsw_search_string = apply_filters( 'bbpsw_filter_search_string', $instance[ 'button_text' ] );

		/** Begin form code */
		?>

		<div id="bbpsw-form-wrapper">
			<form role="search" method="get" id="searchform" class="searchform bbpsw-search-form" action="<?php bbp_search_url(); ?>">
				<div class="bbpsw-form-container">&nbsp;
					<?php if ( BBPSW_SEARCH_LABEL_DISPLAY && $bbpsw_label_string ) : ?>
						<label class="bbpsw-label" for="bbp_search">
							<?php echo esc_attr__( $bbpsw_label_string ); ?>
						</label>
						<br/> 
					<?php endif; ?>
					
					<input tabindex="<?php bbp_tab_index(); ?>" type="text" value="<?php echo esc_attr( bbp_get_search_terms() ); ?>" name="bbp_search" id="bbp_search" class="s bbpsw-search-field" placeholder="<?php echo esc_attr__( $bbpsw_placeholder_string ); ?>" />
					<input tabindex="<?php bbp_tab_index(); ?>" class="button searchsubmit eddsw-search-submit" type="submit" id="bbp_search_submit searchsubmit" value="<?php echo esc_attr__( $bbpsw_search_string ); ?>" />
				</div>
			</form>
		</div>

		<?php
		/** ^End form code */

		/** Display widget outro text if it exists */
		if ( ! empty( $instance[ 'outro_text' ] ) ) {

			echo '<div class="textwidget"><p class="'. $this->id . '-outro_text bbpsw-outro-text">' . $instance[ 'outro_text' ] . '</p></div>';

		}  // end-if optional outro

		/** Action hook 'bbpsw_after_search_widget' */
		do_action( 'bbpsw_after_search_widget' );

		/** Output the closing widget wrapper */
		echo $after_widget;

	}  // end of method widget


	/**
	 * Updates the widget control options for the particular instance of the
	 *    widget.
	 *
	 * This function should check that $new_instance is set correctly.
	 * The newly calculated value of $instance should be returned.
	 * If "false" is returned, the instance won't be saved/updated.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $new_instance New settings for this instance as input by the user via form()
	 * @param  array $old_instance Old settings for this instance
	 *
	 * @return array Settings to save or bool false to cancel saving
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		/** Set the instance to the new instance. */
		$instance = $new_instance;

		/** Strip tags from elements that don't need them */
		$instance[ 'title' ]            = strip_tags( stripslashes( $new_instance[ 'title' ] ) );
		$instance[ 'hide_title' ]       = strip_tags( stripslashes( $new_instance[ 'hide_title' ] ) );
		$instance[ 'title_url' ]        = strip_tags( stripslashes( $new_instance[ 'title_url' ] ) );
		$instance[ 'title_url_target' ] = strip_tags( stripslashes( $new_instance[ 'title_url_target' ] ) );
		$instance[ 'intro_text' ]       = $new_instance[ 'intro_text' ];
		$instance[ 'outro_text' ]       = $new_instance[ 'outro_text' ];
		$instance[ 'label_text' ]       = strip_tags( stripslashes( $new_instance[ 'label_text' ] ) );
		$instance[ 'placeholder_text' ] = strip_tags( stripslashes( $new_instance[ 'placeholder_text' ] ) );
		$instance[ 'button_text' ]      = strip_tags( stripslashes( $new_instance[ 'button_text' ] ) );
		$instance[ 'widget_display' ]   = strip_tags( $new_instance[ 'widget_display' ] );
		$instance[ 'not_in_bbpbase' ]   = strip_tags( $new_instance[ 'not_in_bbpbase' ] );
		$instance[ 'not_in_bbpsearch' ] = strip_tags( $new_instance[ 'not_in_bbpsearch' ] );
		$instance[ 'not_in_public' ]    = strip_tags( $new_instance[ 'not_in_public' ] );

		return $instance;

	}  // end of method update


	/**
	 * Displays the widget options in the Widgets admin screen.
	 *
	 * @since 1.0.0
	 *
	 * @param array $instance Current settings
	 */
	public function form( $instance ) {

		/** IMPORTANT: bbPress 2.3 check -- display user info if bbPress is outdated (= prior v2.3). */
		if ( ! function_exists( 'bbp_is_search' ) ) {

			$bbpsw_action_needed = '<p class="update-message">' . sprintf( __( 'This widget needs a newer version of the base plugin %s.', 'bbpress-search-widget' ), '<em>bbPress</em>' ) . '</p>';

			$bbpsw_admin_update = sprintf(
				'<a href="%s" target="_blank">update the %s plugin</a>',
				current_user_can( 'install_plugins' ) ? esc_url( network_admin_url( 'update-core.php' ) ) : esc_url( 'http://wordpress.org/extend/plugins/bbpress/' ),
				'<em>bbPress</em>'
			);

			if ( ! current_user_can( 'install_plugins' ) ) {

				/** Display user info for non-admins */
				echo $bbpsw_action_needed;

				echo '<p class="update-message">' . sprintf(
					__( 'If you would like to continue to use the %s functionality, please have a site administrator %s.', 'bbpress-search-widget' ),
					__( 'bbPress Search Widget', 'bbpress-search-widget' ),
					$bbpsw_admin_update
				) . '</p>';

				/** Then bail... */
				return;

			}

			echo $bbpsw_action_needed;

			echo '<p class="update-message">' . sprintf(
				__( 'If you would like to continue to use the %s functionality, please %s.', 'bbpress-search-widget' ),
				__( 'bbPress Search Widget', 'bbpress-search-widget' ),
				$bbpsw_admin_update
			) . '</p>';

			/** Then bail... */
			return;

		}  // end-if bbPress 2.3+ check


		/** Setup defaults parameters */
		$defaults = apply_filters( 'bbpsw_filter_search_widget_defaults', array(
			'hide_title'       => 0,
			'title_url'        => '',
			'title_url_target' => 0,
			'label_text'       => __( 'Search Forums, Topics, Replies for:', 'bbpress-search-widget' ),
			'placeholder_text' => __( 'Search Forums, Topics, Replies&#x2026;', 'bbpress-search-widget' ),
			'button_text'      => __( 'Search', 'bbpress-search-widget' ),
			'widget_display'   => 'global',
			'not_in_bbpbase'   => 0,
			'not_in_bbpsearch' => 0,
			'not_in_public'    => 0
		) );

		/** Get the values from the instance */
		$instance = wp_parse_args( (array) $instance, $defaults );

		/** Get values from instance */
		$title      = ( isset( $instance[ 'title' ] ) ) ? esc_attr( $instance[ 'title' ] ) : null;
		$title_url  = ( isset( $instance[ 'title_url' ] ) ) ? esc_url( $instance[ 'title_url' ] ) : null;
		$intro_text = ( isset( $instance[ 'intro_text' ] ) ) ? esc_textarea( $instance[ 'intro_text' ] ) : null;
		$outro_text = ( isset( $instance[ 'outro_text' ] ) ) ? esc_textarea( $instance[ 'outro_text' ] ) : null;
	
		$bbpsw_hr_style = 'style="border: 1px dashed #ddd; margin: 15px 0 !important;"';
		$bbpsw_select_divider = '<option value="void" disabled="disabled">—————————————————</option>';

		/** Begin form code */
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
				<strong><?php _e( 'Title:', 'bbpress-search-widget' ); ?></strong>
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $title; ?>" />
	   	</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'title_url' ); ?>">
			<?php _e( 'Optional Title URL:', 'bbpress-search-widget' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title_url' ); ?>" name="<?php echo $this->get_field_name( 'title_url' ); ?>" value="<?php echo $title_url; ?>" />
	   	</p>

		<p>
			<input type="checkbox" value="1" <?php checked( '1', $instance[ 'title_url_target' ] ); ?> id="<?php echo $this->get_field_id( 'title_url_target' ); ?>" name="<?php echo $this->get_field_name( 'title_url_target' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'title_url_target' ); ?>">
				<?php _e( 'Open the URL in a new window/ tab?' , 'bbpress-search-widget' ); ?>
			</label>
		</p>

		<p>
			<input type="checkbox" value="1" <?php checked( '1', $instance[ 'hide_title' ] ); ?> id="<?php echo $this->get_field_id( 'hide_title' ); ?>" name="<?php echo $this->get_field_name( 'hide_title' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'hide_title' ); ?>">
				<?php _e( 'Do not display the Title?' , 'bbpress-search-widget' ); ?>
			</label>
		</p>

		<hr <?php echo $bbpsw_hr_style; ?> />

		<p>
			<label for="<?php /** Optional intro text */ echo $this->get_field_id( 'intro_text' ); ?>"><?php _e( 'Optional intro text:', 'bbpress-search-widget' ); ?>
				<small><?php echo sprintf( __( 'Add some additional %s info. NOTE: Just leave blank to not use at all.', 'bbpress-search-widget' ), __( 'Search', 'bbpress-search-widget' ) ); ?></small>
				<textarea name="<?php echo $this->get_field_name( 'intro_text' ); ?>" id="<?php echo $this->get_field_id( 'intro_text' ); ?>" rows="2" class="widefat"><?php echo $intro_text; ?></textarea>
			</label>
		</p>

		<hr <?php echo $bbpsw_hr_style; ?> />

		<p>
			<strong><?php _e( 'Search form', 'bbpress-search-widget' ); ?>:</strong>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'label_text' ); ?>">
			<?php _e( 'Label string before search input field:', 'bbpress-search-widget' ); ?>
			<input type="text" id="<?php echo $this->get_field_id( 'label_text' ); ?>" name="<?php echo $this->get_field_name( 'label_text' ); ?>" value="<?php echo esc_attr( $instance[ 'label_text' ] ); ?>" class="widefat" />
				<small><?php _e( 'NOTE: Leave empty to not use/ display this string!', 'bbpress-search-widget' ); ?></small>
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'placeholder_text' ); ?>">
			<?php _e( 'Placeholder string for search input field:', 'bbpress-search-widget' ); ?>
			<input type="text" id="<?php echo $this->get_field_id( 'placeholder_text' ); ?>" name="<?php echo $this->get_field_name( 'placeholder_text' ); ?>" value="<?php echo esc_attr( $instance[ 'placeholder_text' ] ); ?>" class="widefat" />
				<small><?php _e( 'NOTE: Leave empty to not use/ display this string!', 'bbpress-search-widget' ); ?></small>
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'button_text' ); ?>">
			<?php _e( 'Search button string:', 'bbpress-search-widget' ); ?>
			<input type="text" id="<?php echo $this->get_field_id( 'button_text' ); ?>" name="<?php echo $this->get_field_name( 'button_text' ); ?>" value="<?php echo esc_attr( $instance[ 'button_text' ] ); ?>" class="widefat" />
				<small><?php _e( 'NOTE: Displaying may depend on your theme settings/ styles.', 'bbpress-search-widget' ); ?></small>
			</label>
		</p>

		<hr <?php echo $bbpsw_hr_style; ?> />

		<p>
    		<label for="<?php echo $this->get_field_id( 'widget_display' ); ?>">
				<strong><?php _e( 'Where to display this widget?', 'bbpress-search-widget' ); ?>:</strong>
				<select id="<?php echo $this->get_field_id( 'widget_display' ); ?>" name="<?php echo $this->get_field_name( 'widget_display' ); ?>">        
					<?php
						printf( '<option value="global" %s>%s</option>', selected( 'global', $instance[ 'widget_display' ], 0 ), __( 'Global (default)', 'bbpress-search-widget' ) );
						
						echo $bbpsw_select_divider;

						printf( '<option value="bbpress_global" %s>%s</option>', selected( 'bbpress_global', $instance[ 'widget_display' ], 0 ), __( 'All bbPress Instances', 'bbpress-search-widget' ) );

						echo $bbpsw_select_divider;

						printf( '<option value="single_forums" %s>%s</option>', selected( 'single_forums', $instance[ 'widget_display' ], 0 ), sprintf( __( 'Single %s', 'bbpress-search-widget' ), __( 'Forums', 'bbpress-search-widget' ) ) );

						printf( '<option value="single_topics" %s>%s</option>', selected( 'single_topics', $instance[ 'widget_display' ], 0 ), sprintf( __( 'Single %s', 'bbpress-search-widget' ), __( 'Topics', 'bbpress-search-widget' ) ) );

						printf( '<option value="single_forums_topics" %s>%s</option>', selected( 'single_forums_topics', $instance[ 'widget_display' ], 0 ), __( 'Both, Single Forums & Topics', 'bbpress-search-widget' ) );

						echo $bbpsw_select_divider;

						printf( '<option value="forums_archives" %s>%s</option>', selected( 'forums_archives', $instance[ 'widget_display' ], 0 ), sprintf( __( '%s Archives', 'bbpress-search-widget' ), __( 'Forums', 'bbpress-search-widget' ) ) );

						printf( '<option value="topics_archives" %s>%s</option>', selected( 'topics_archives', $instance[ 'widget_display' ], 0 ), sprintf( __( '%s Archives', 'bbpress-search-widget' ), __( 'Topics', 'bbpress-search-widget' ) ) );

						printf( '<option value="archives_forums_topics" %s>%s</option>', selected( 'archives_forums_topics', $instance[ 'widget_display' ], 0 ), __( 'Both, Forums & Topics Archives', 'bbpress-search-widget' ) );

						echo $bbpsw_select_divider;

						printf( '<option value="topics_tax" %s>%s</option>', selected( 'topics_tax', $instance[ 'widget_display' ], 0 ), __( 'Topics Taxonomies', 'bbpress-search-widget' ) );

						echo $bbpsw_select_divider;

						printf( '<option value="single_posts" %s>%s</option>', selected( 'single_posts', $instance[ 'widget_display' ], 0 ), sprintf( __( 'Single %s', 'bbpress-search-widget' ), __( 'Posts', 'bbpress-search-widget' ) ) );

						printf( '<option value="single_pages" %s>%s</option>', selected( 'single_pages', $instance[ 'widget_display' ], 0 ), sprintf( __( 'Single %s', 'bbpress-search-widget' ), __( 'Pages', 'bbpress-search-widget' ) ) );

						printf( '<option value="single_posts_pages" %s>%s</option>', selected( 'single_posts_pages', $instance[ 'widget_display' ], 0 ), __( 'Both, Single Posts & Pages', 'bbpress-search-widget' ) );
					?>
				</select>
        	</label>
		</p>

		<p>
			<input type="checkbox" value="1" <?php checked( '1', $instance[ 'not_in_bbpbase' ] ); ?> id="<?php echo $this->get_field_id( 'not_in_bbpbase' ); ?>" name="<?php echo $this->get_field_name( 'not_in_bbpbase' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'not_in_bbpbase' ); ?>">
				<?php _e( 'Not displaying on Forums base (start)?' , 'bbpress-search-widget' ); ?>
			</label>
		</p>

		<p>
			<input type="checkbox" value="1" <?php checked( '1', $instance[ 'not_in_bbpsearch' ] ); ?> id="<?php echo $this->get_field_id( 'not_in_bbpsearch' ); ?>" name="<?php echo $this->get_field_name( 'not_in_bbpsearch' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'not_in_bbpsearch' ); ?>">
				<?php _e( 'Not displaying when on a bbPress search results page?' , 'bbpress-search-widget' ); ?>
			</label>
		</p>

		<p>
			<input type="checkbox" value="1" <?php checked( '1', $instance[ 'not_in_public' ] ); ?> id="<?php echo $this->get_field_id( 'not_in_public' ); ?>" name="<?php echo $this->get_field_name( 'not_in_public' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'not_in_public' ); ?>">
				<?php _e( 'Only displaying for logged in users?' , 'bbpress-search-widget' ); ?>
			</label>
		</p>

		<hr <?php echo $bbpsw_hr_style; ?> />

		<p>
			<label for="<?php /** Optional outro text */ echo $this->get_field_id( 'outro_text' ); ?>"><?php _e( 'Optional outro text:', 'bbpress-search-widget' ); ?>
				<small><?php echo sprintf( __( 'Add some additional %s info. NOTE: Just leave blank to not use at all.', 'bbpress-search-widget' ), __( 'Search', 'bbpress-search-widget' ) ); ?></small>
				<textarea name="<?php echo $this->get_field_name( 'outro_text' ); ?>" id="<?php echo $this->get_field_id( 'outro_text' ); ?>" rows="2" class="widefat"><?php echo $outro_text; ?></textarea>
			</label>
		</p>

		<?php
		/** ^End form code */

	}  // end of method form

}  // end of main class bbPress_Forum_Plugin_Search