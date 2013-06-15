=== Sync Facebook Events ===
Contributors: markpdxt, scottconnerly
Tags: facebook, events, synchronize, calendar
Requires at least: 3.0
Tested up to: 3.5.1
Stable tag: 1.0.8

A simple plugin to Sync Facebook events to The Events Calendar plugin by Modern Tribe.

== Description ==

A simple plugin to Sync Facebook events to The Events Calendar plugin by Modern Tribe.

Get The Events Calendar plugin:
http://wordpress.org/extend/plugins/the-events-calendar/

== Installation ==

1. Download the plugin archive and expand it
2. Upload the sync-facebook-events folder to your /wp-content/plugins/ directory
3. Go to the plugins page and click 'Activate' for Sync FB Events
4. Navigate to the Settings section within Wordpress and enter your Facebook App ID, App Secret & UID.
5. Ensure The Events Calendar plugin is installed and configured - http://wordpress.org/extend/plugins/the-events-calendar/
5. Press 'Update' to synchronize your current Facebook events for display within The Events Calendar.
6. Synchronization will continue to occur on the schedule you set. You can always update manually if/when needed.

== Frequently Asked Questions ==

Q: What is the Facebook App ID and App Secret, and why are they required?

A: The Facebook App ID and App Secret are required by Facebook to access data via the Facebook graph API. 
To signup for a developer account or learn more see - http://developers.facebook.com/docs/guides/canvas/

Q: How do I find the Facebook UID of the page for which I wish to synchronize events?

A: Goto the page you're interested in - ex. https://www.facebook.com/webtrends  
Copy the URL and replace 'www' with 'graph' - ex. https://graph.facebook.com/webtrends 
The UID is the first item in the resulting text. In this example it is "54905721286".

Q: Do my Facebook events get updated on a schedule?

A: Yes, You can choose the update interval and also update immediately when you press the 'Update' button from the Sync FB Events section within settings.

Q: Why do I get a blank screen when running an update?

A: Check your Facebook App ID, Facebook App Secret and Facebook UID. One of them is probably incorrect.

Q: Why doesn't Modern Tribe just provide this functionality within their own plugin?

A: They incorporated this one, actually.

== Upgrade Notice ==

Upgrade Notice

== Screenshots ==

1. Facebook Event Sync Configuration

== Changelog ==

= 1.0.7 / 1.0.8 =
* Fixing the duplicate events issue (finally).

= 1.0.6 =
* Adding the correct post_type for modern tribe events

= 1.0.5 =
* Minor compatibility fix for Wordpress 3.1

= 1.0.4 =
* Added ability to allow event synchronization from multiple Facebook pages

= 1.0.3 =
* Added ability to adjust event sync frequency

= 1.0.2 =
* Added automatic daily event sync
* Added ability to adjust event timezone to WordPress

= 1.0.1 =
* Improved update display

= 1.0 =
* Initial release