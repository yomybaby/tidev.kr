=== bbPress Like Button ===
Tags: rate, rating, ratings, vote, votes, voting, star, like, widget, widgets, comment, comments, post, posts, page, admin, plugin, ajax, buddypress, bbpress
Requires at least: 2.6
Tested up to: 3.4.2
Stable tag: 1.3
Contributors: Jordi Plana

Add a Like button in all your posts and replies. Let the users appreciate others contribution.

== Description ==
bbPress Like button adds automatically a **Like Button** (Youtube alike) in all your forum posts and replies. It allows users to give some greetings to others contributions. 

= Shortcodes =
You can use a collection of shortcodes to embed some cool stadistics into posts, pages and widgets.

* **[most_liked_users]** and **[most_liked_users exclude_admins=true]**
* **[most_liking_users]**
* **[most_liked_posts]**

= Languages =
bbPress Like Button is currently in:

* English
* Macedonian (by [crazy-nomce](http://wordpress.org/support/profile/crazy-nomce))
* Persian (by [Mortaza Nazari](http://m-nazari.ir))
* Spanish

The plugin comes with .po files. Feel free to translate it to your language!

= AJAX ready =
The plugin is designed to interact via AJAX in both sides: dashboard and frontend.

= CSS3 and HTML5 =
All that prints the plugins is CSS3 and HTML5 compliant.

= TODO/Wishlist =
**Dashboard**

* export likes log to CSV
* reply/post list view column with like number in the dashboard
* reset logs button
* add do_action and apply_filters
* BuddyPress Activity Stream integration
* Option: allow anonymous vote (ip)
* Option: allow like only replies (exclude OP)
* Option: email notification on like

**Frontend**

* icons set
* public unlike?
* widget most liked post/user

= Official site =
For more information about this plugin you can check the [official site](http://jordiplana.com/bbpress-like-button-plugin).

= Thanks =
Thanks to Gilbert Pellegrom for his excelent [Wordpress Settings Framework](http://gilbert.pellegrom.me/wordpress-settings-framework/).

== Installation ==

1. Upload the plugin to your plugins directory.
2. Activate the plugin.
3. Enjoy!

== Screenshots ==

1. Likes Log Screen. You are able to see all likes in a fancy grid.
2. Likes Stadistics. This screen shows top 10 users
3. Example of Like Button


== Frequently Asked Questions ==

= I installed version 1.2 of the plugin and apparently it does not track likes =
Version 1.2 of the plugin had a bug on plugin activation. Is solved in the next versions. Please update your plugin

= Why does not appear the like button in the frontend? =
Plugin waits for **bbp_theme_before_reply_admin_links** action. Check your theme for this action. Another solutions is to add manually a call to the function that shows the button: **bbp_like_button()**.

= Where can I find plugin support? =
You can ask questions about the plugin in the plugin official site: [bbPress Like Button](http://jordiplana.com/bbpress-like-button-plugin)

== Change Log ==
= 1.3 =
* Fixed activation hook error (creating plugin table)
* Added Macedonian language
= 1.2 =
* Fixed error with the Grid (Likes Log)
* Fixed AJAX Error
* Settings page
* Data sanitization (security)
= 1.1 =
* Typo Errors
= 1.0 =
* Initial release.