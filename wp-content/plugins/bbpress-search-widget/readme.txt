=== bbPress Search Widget ===
Contributors: daveshine, deckerweb
Donate link: http://genesisthemes.de/en/donate/
Tags: bbpress, bbPress 2.0, search, widget, forum, forums, topic, topics, reply, replies, custom post type, search widget, searching, shortcode, not found, widget-only, deckerweb
Requires at least: 3.5 and bbPress 2.3+
Tested up to: 3.6
Stable tag: 2.0.0
License: GPL-2.0+
License URI: http://www.opensource.org/licenses/gpl-license.php

Extended search widget for bbPress 2.3+, plus Forum search Shortcode, plus widgetized not found content area for Form search 'no results'.

== Description ==

> #### Great Helper Tool for bbPress 2.3+ ;-)
> This **small and lightweight plugin** is pretty much like the regular, packaged bbPress search widget but just offers up to 13 awesome options for you! For example, easily change the search, placeholder and button texts. Also, set visibility options or add optional intro/ outro texts. -- How awesome is that?! :)
>
> Just drag the widget to your favorite widget area and enjoy to have a customized forum-limited search function for your bbPress install ;-).
>
> **Since v2.0.0** you can also use the Shortcode `[bbpress-searchbox]` anywhere Shortcodes are supported. New feature is also the widgetized content area for forum search that brings no results. Now you can customize this status to your liking and are no longer dependent of the (lame) default string. --- Futher, the plugin is also fully Multisite compatible, you can also network-enable it if ever needed (per site use is recommended).

= Features =
* Improved search results display for themes and bbPress post type detection/restriction.
* Easily change text strings via Widget options.
* Easily set visibility via Widget options.
* I added two new - fully optional - text fields: "Intro text" and "Outro text" to display for example additional (support) forum or user instructions. Just leave blank to not use them!
* Shortcode `[bbpress-searchbox]` to have bbPress Forum specific search box anywhere Shortcodes are supported. ([See FAQ here](http://wordpress.org/extend/plugins/bbpress-search-widget/faq/) for the supported parameters.)
* Widgetized "Not found" content area when bbPress Forum search has no results -- very handy, as you can customize this page now!
* Added more ways to customize the widget appearance: 3 filters for the search label/ search placeholder/ search button text as well as a constant to conditionally remove the search label.
* Improved translation loading.
* Fully internationalized, including help texts! Also, fully WPML compatible!
* Fully Multisite compatible, you can also network-enable it if ever needed (per site use is recommended, depending on bbPress usage).
* Tested with WordPress branches 3.5+ and upcoming 3.6 - also in debug mode (no stuff there, ok? :)
* Also, clean, well-documented code with security and coding standards in mind :)

= Useful for/ Use Cases =
* Preferred over built-in widget because of more options & flexibility!
* Support forums because you can setup visibility options and intro/ outro texts, great for extra instructions or info.
* With provided Shortcode you get even more display options on your site and so can improve the overall user experience of your forum/ site.
* Restricting search widget to only logged in users is possible with 1-click! :)
* Must-have feature: Easily customizing the "no results" status for forum searches via Widgets. This helps users stay on your site and you can offer useful options for this "edge case". Especially very handy for support forums etc. -- In general: improved user experience!

= Localization =
* English (default) - always included
* German (de_DE) - always included
* Spanish (es_ES) - user-submitted - 28% complete for v2.0.0 :)
* French (fr_FR) - user-submitted - 22% complete for v2.0.0 :)
* .pot file (`bbpress-search-widget.pot`) for translators is also always included :)
* Easy plugin translation platform with GlotPress tool: [Translate "bbPress Search Widget"...](http://translate.wpautobahn.com/projects/wordpress-plugins-deckerweb/bbpress-search-widget)
* *Your translation? - [Just send it in](http://genesisthemes.de/en/contact/)*

[A plugin from deckerweb.de and GenesisThemes](http://genesisthemes.de/en/)

= Feedback =
* I am open for your suggestions and feedback - Thank you for using or trying out one of my plugins!
* Drop me a line [@deckerweb](http://twitter.com/#!/deckerweb) on Twitter
* Follow me on [my Facebook page](http://www.facebook.com/deckerweb.service)
* Or follow me on [+David Decker](http://deckerweb.de/gplus) on Google Plus ;-)

= Tips & More =
* *Plugin tip:* [My bbPress Toolbar / Admin Bar plugin](http://wordpress.org/extend/plugins/bbpress-admin-bar-addition/) -- a great time safer and helper tool :)
* [Also see my other plugins](http://genesisthemes.de/en/wp-plugins/) or see [my WordPress.org profile page](http://profiles.wordpress.org/daveshine/)
* Tip: [*GenesisFinder* - Find then create. Your Genesis Framework Search Engine.](http://genesisfinder.com/)

== Installation ==

1. Upload the entire `bbpress-search-widget` folder to the `/wp-content/plugins/` directory -- or just upload the ZIP package via 'Plugins > Add New > Upload' in your WP Admin
2. Activate the plugin through the 'Plugins' menu in WordPress
3. On the regular WordPress Widgets settings page just drag the *bbPress: Forum Search* Widget to your favorite widget area, setup a few options and you're done :)
4. (Optional) Or use the built-in Shortcode to place a little bbPress search box anywhere Shortcodes are supported. See FAQ here for parameters... :)

**PLEASE NOTE: You need WordPress 3.5 or higher AND bbPress 2.3 or higher for this plugin in order to work! So, just update your install!**

**Note for legacy installs:** If you have an install with older versions you can still use version 1.1.0 or 1.2.0 of this plugin, just download from here: http://wordpress.org/extend/plugins/bbpress-search-widget/developers/ (Just beware of updates then, until you upgraded your whole install :)

**Note for own translation/wording:** For custom and update-secure language files please upload them to `/wp-content/languages/bbpress-search-widget/` (just create this folder) - This enables you to use fully custom translations that won't be overridden on plugin updates. Also, complete custom English wording is possible with that, just use a language file like `bbpress-search-widget-en_US.mo/.po` to achieve that (for creating one see the tools on "Other Notes").

== Frequently Asked Questions ==

= What are the supported Shortcode parameters? =
Currently, these attributes/ parameters are available:

* `label_text` — Label text before the input field (default: `Search Forums, Topics, Replies for:`)
* `placeholder_text` — Input field placeholder text (default: `Search Forums, Topics, Replies...`)
* `button_text` — Submit button text (default: `Search`)
* `class` — Can be a custom class, added to the wrapper `div` container (default: none, empty)

= How to use the Shortcode? =
Place the Shortcode tag in any Post, Page, Download product, or Shortcode-aware area. A few examples:

`
[bbpress-searchbox]
--> displays search box with default values

[bbpress-searchbox label_text=""]
--> will display no label!

[bbpress-searchbox placeholder_text="Search our support forums..." class="my-custom-class"]
--> will display other placeholder, plus add custom wrapper class for custom styling :-)
`

= Can I remove the widgetized content area for forum search "not found"? =
Of course, that possible - very easily :). Just add the following line of code to your theme's/ child theme's `functions.php` file or a functionality plugin:

`
/** bbPress Search Widget: Remove Widgetized Content Area on "not found" */
add_filter( 'bbpsw_filter_noresults_widgetized', '__return_false' );
`

= How can I style or remove the label "Search forum in topics and replies for"? =
(1) There's an extra CSS class included for that, named `.bbpsw-label` so you can style it with any rules or just remove this label with `display:none`.

(2) Second option, you can fully remove the label by adding a constant to your theme's/child theme's functions.php file or to a functionality plugin etc.:
`
/** bbPress Search Widget: Remove Search Label */
define( 'BBPSW_SEARCH_LABEL_DISPLAY', false );
`


**The following FAQ items were for plugin version prior v2.0.0 - but are still there and can be used (backward compatibility!)**

= How can I change the text of the label "Search forum in topics and replies for"? =
(1) You can use the translation language file to use custom wording for that - for English language the file would be /`wp-content/plugins/bbpress-search-widget/languages/bbpress-search-widget-en_US.mo`. Just via the appropiate language/translation file. For doing that, a .pot/.po file is always included.

(2) Second option: Or you use the built-in filter to change the string. Add the following code to your `functions.php` file of current them/child theme, just like that:
`
add_filter( 'bbpsw_filter_label_string', 'custom_bbpsw_label_string' );
/**
 * bbPress Search Widget: Custom Search Label
 */
function custom_bbpsw_label_string() {
	return __( 'Your custom search label text', 'your-theme-textdomain' );
}
`

= How can I change the text of the placeholder in the search input field? =
(1) See above question: via language file!

(2) Or second option, via built-in filter for your `functions.php` file of theme/child theme:
`
add_filter( 'bbpsw_filter_placeholder_string', 'custom_bbpsw_placeholder_string' );
/**
 * bbPress Search Widget: Custom Placeholder Text
 */
function custom_bbpsw_placeholder_string() {
	return __( 'Your custom placeholder text', 'your-theme-textdomain' );
}
`

= How can I change the text of the search button? =
(1) Again, see above questions: via language file!

(2) Or second option, via built-in filter for your `functions.php` file of theme/child theme:
`
add_filter( 'bbpsw_filter_search_string', 'custom_bbpsw_search_string' );
/**
 * bbPress Search Widget: Custom Search Button Text
 */
function custom_bbpsw_search_string() {
	return __( 'Your custom search button text', 'your-theme-textdomain' );
}
`

All the custom & branding stuff code above as well as theme CSS hacks can also be found as a Gist on GitHub: https://gist.github.com/2394575 (you can also add your questions/ feedback there :)

= How can I further style the appearance of this widget? =
There are CSS classes for every little part included:

* main widget ID: `#bbpress_search-<ID>`
* main widget class: `.widget_bbpress_search`
* intro text: `.bbpsw-intro-text`
* form wrapper ID: `#bbpsw-form-wrapper`
* form: `.bbpsw-search-form`
* form div container: `.bbpsw-form-container`
* search label: `.bbpsw-label`
* input field: `.bbpsw-search-field`
* search button: `.bbpsw-search-submit`
* outro text: `.bbpsw-outro-text`

= How can I style the actual search results? =
This plugin's widget is limited to provide the widget and search functionality itself. Styling the search results output in your THEME or CHILD THEME is beyond the purpose of this plugin. You might style it yourself so it will fit your theme.

= In my theme this widget's display is "crashed" - what could I do? =
Please report in the [support forum here](http://wordpress.org/support/plugin/bbpress-search-widget), giving the correct name of your theme/child theme plus more info from where the theme is and where its documentation is located. For example the "iFeature Lite" theme, found on WordPress.org has issues with the CSS styling. For this example theme you found a CSS fix/hack directly here: https://gist.github.com/2394575#file_theme_ifeature_lite.css ---> Just place this additional CSS styling ad the bottom of this file `/wp-content/themes/ifeature/css/style.css` (please note the `/css/` subfolder here!)

== Screenshots ==

1. bbPress Search Widget: the extended search widget with its options. ([Click here for larger version of screenshot](https://www.dropbox.com/s/aqi4hmk520vvn8x/screenshot-1.png))
2. bbPress Search Widget: the new widgetized not found content area in Widgets admin. ([Click here for larger version of screenshot](https://www.dropbox.com/s/kr6b40ta0358arh/screenshot-2.png))
3. bbPress Search Widget in a sidebar: default state (shown here with [the free Autobahn Child Theme for Genesis Framework](http://genesisthemes.de/en/genesis-child-themes/autobahn/)). ([Click here for larger version of screenshot](https://www.dropbox.com/s/c4jz6z6781r45vz/screenshot-3.png))
4. bbPress Search Widget in a sidebar: custom intro and outro text shown - all parts can by styled individually, just [see FAQ section here](http://wordpress.org/extend/plugins/bbpress-search-widget/faq/) for custom CSS styling. ([Click here for larger version of screenshot](https://www.dropbox.com/s/aszrnexdyn2c9l4/screenshot-4.png))
5. bbPress Search Widget: widgetized content area in action, when forum search returned no results. ([Click here for larger version of screenshot](https://www.dropbox.com/s/n6rbejr2tsmavx7/screenshot-5.png))
6. bbPress Search Widget: plugin help tab system. ([Click here for larger version of screenshot](https://www.dropbox.com/s/pi1yz1geth0c5cm/screenshot-6.png))

== Changelog ==

= 2.0.0 (2013-05-02) =
* **Only for bbPress 2.3+**
* *NOTE: Since this plugin version (2.0.0+) WordPress 3.5+ AND bbPress 2.3+ is REQUIRED!*
* *ALSO NOTE: You'll note that bbPress 2.3+ comes with its native search functionality plus search widget, so this plugin may no longer be needed. However, for consistency and to give users the chance to change their placeholder & search string etc. I've decided to still continue development. Just consider this widget an "extended version" of the now default search widget. :)*
* NEW: Updated search widget to work with new bbPress 2.3+ native search functionality.
* NEW: Added input options to Widget directly for: Label text, Placeholder text, Search button text -- now it's really easy to change this stuff, right? :-)
* NEW: Added widget display options to have faster setup of the widget. Default setting is "global" (as was before). -- *Note: If the provided options are not enough, just use the default setting and use other plugins like "Widget Logic" or "Widget Display" to setup more complex widget display behaviors.*
* NEW: Added Shortcode to display a little bbPress-specific search box anywhere, [see FAQ here](http://wordpress.org/extend/plugins/bbpress-search-widget/faq/) for supported parameters.
* NEW: Added widgetized content area for the "No results" state of the bbPress Forum search - now you can easily customize this "edge case" with well-known and proved regular WordPress tools (that are Widgets!).
* UPDATE: Some code refactoring for improved performance and better future maintenance.
* UPDATE: Improved and extended help tab system.
* CODE: Major code/ documentation tweaks and improvements.
* UPDATE: Updated German translations and also the .pot file for all translators!
* NEW: Added partly Spanish translation - user-submitted - currently 28% for v2.0.0 :).
* NEW: Added partly French translation - user-submitted - currently 22% for v2.0.0 :).
* UPDATE: Initiated new three digits versioning, starting with this version.
* UPDATE: Moved screenshots to 'assets' folder in WP.org SVN to reduce plugin package size.

= 1.2.x (2012) =
* (Private development; unreleased)

= 1.2.0 (2012-05-23) =
* **Only for bbPress 2.1.x**
* NEW: Added additional plugin help tab on the Widgets admin page.
* UPDATE: Added additional div and wrapper-ID around the search form code to make this whole thing more compatible -- a.k.a styleable -- with more themes out there. This way you can style every tiny little part of the widget display. See also FAQ for a sample CSS fix/hack for the "iFeature Lite" theme.
* UPDATE: Moved all admin-only functions/code from main file to extra admin file which only loads within 'wp-admin', this way it's all  performance-improved! :)
* CODE: Minor code/documentation tweaks and improvements.
* UPDATE: Updated the FAQ documentation here, especially with CSS fixes for "iFeature Lite" theme.
* UPDATE: Updated German translations and also the .pot file for all translators!
* UPDATE: Extended GPL License info in readme.txt as well as main plugin file.

= 1.1.0 (2012-04-15) =
* **Only for bbPress 2.1.x**
* UPDATE: Improved the display of the search results, therefore improved compatibility with lots of themes. -- Thanks to German WordPress developer Daniel Hüsken for his helping hand! :) Also thanks to Pippin Williamson for beta testing and additional advice!
* UPDATE: Removed the post type selection box in the widget - to streamline the performance. It's now more simple and therefore better.
* NEW: Added fully optional intro and outro text areas, so for example you can add additional search or forum instructions - leave blank to not use them.
* NEW: Added filter and constants to make the plugin more customizeable: change search input field "label", "placeholder" and "button" text via filter -- a new constant allows also for custom disabling of the label text! -- See "FAQ" section here for more info on that!
* NEW: Added possibility for custom and update-secure language files for this plugin - just upload them to `/wp-content/languages/buddypress-toolbar/` (just create this folder) - this enables you to use complete custom wording or translations.
* CODE: Minor code and documentation tweaks and improvements.
* UPDATE: Updated readme.txt file for the new features plus documentation.
* UPDATE: Added some new and updated existing screenshots.
* UPDATE: Updated German translations and also the .pot file for all translators!
* NEW: Added banner image on WordPress.org for better plugin branding :)

= 1.0.0 (2011-10-10) =
* **Only for bbPress 2.0.x**
* Initial release

== Upgrade Notice ==

= 2.0.0 =
Major additions & improvements: Added Shortcode; improved Widget; code/ documentation improvements. New partly Spanisch & French translations, updated German translations and .pot file for all translators.

= 1.2.1 =
(Private development version.)

= 1.2 =
Several additions & improvements: Added new CSS selector for improved styling & compatibility with themes. Added help tab system. Further optimized loading of admin stuff. Also, updated language files together width German translations.

= 1.1 =
Several changes and improvements - Improved search results display and theme compatibility. The forum post type selection is gone, now automatically searches in topics and replies. Also, updated language files together width German translations.

= 1.0 =
Just released into the wild.

== Plugin Links ==
* [Translations (GlotPress)](http://translate.wpautobahn.com/projects/wordpress-plugins-deckerweb/bbpress-search-widget)
* [User support forums](http://wordpress.org/support/plugin/bbpress-search-widget)
* [Code snippets archive for customizing, GitHub Gist](https://gist.github.com/2394575)
* *Plugin tip:* [My bbPress Toolbar / Admin Bar plugin](http://wordpress.org/extend/plugins/bbpress-admin-bar-addition/) -- a great time safer and helper tool :)

== Donate ==
Enjoy using *bbPress Search Widget*? Please consider [making a small donation](http://genesisthemes.de/en/donate/) to support the project's continued development.

== Translations ==

* English - default, always included
* German (de_DE): Deutsch - immer dabei! [Download auch via deckerweb.de](http://deckerweb.de/material/sprachdateien/bbpress-forum/#bbpress-search-widget)
* Spanish (es_ES): Español - user-submitted
* French (fr_FR): Français - user-submitted
* For custom and update-secure language files please upload them to `/wp-content/languages/bbpress-search-widget/` (just create this folder) - This enables you to use fully custom translations that won't be overridden on plugin updates. Also, complete custom English wording is possible with that, just use a language file like `bbpress-search-widget-en_US.mo/.po` to achieve that (for creating one see the following tools).

**Easy plugin translation platform with GlotPress tool:** [**Translate "bbPress Search Widget"...**](http://translate.wpautobahn.com/projects/wordpress-plugins-deckerweb/bbpress-search-widget)

*Note:* All my plugins are internationalized/ translateable by default. This is very important for all users worldwide. So please contribute your language to the plugin to make it even more useful. For translating I recommend the awesome ["Codestyling Localization" plugin](http://wordpress.org/extend/plugins/codestyling-localization/) and for validating the ["Poedit Editor"](http://www.poedit.net/), which works fine on Windows, Mac and Linux.

== Additional Info ==
**Idea Behind / Philosophy:** A search feature or a widget is just missing yet for the new and awesome bbPress forum plugin. So I just set up this little widget. It's small and lightweight and only limited to this functionality.

== Credits ==
* Thanks to the WPMU.org blog crew who did a great post about this plugin back in the fall of 2011!
* Thanks to Pippin Williamson [@pippinsplugins](http://twitter.com/pippinsplugins) for testing and giving very helpful feedback!
* Thanks to all users who have tested and used (and still using!) this plugin - for all feedback which helped to improve stuff!
* Thanks to WordPress developer Daniel Hüsken from Germany who helped fix and improve the search results display in versions prior to v2.0.0!