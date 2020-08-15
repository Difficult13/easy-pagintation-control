=== Easy Pagination Control ===
Contributors: pet1t
Tags: pagination, usability, control, easy
Requires at least: 5.4.2
Tested up to: 5.5
Requires PHP: 7.0
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A lightweight and easy-to-configure plugin for quickly configuring the number of objects on the archives, categories, tags, taxonomies, home, search page, and front page

== Description ==

This plugin is designed to create a convenient page for pagination settings for the main wordpress entities, including custom types.
You can only work with the main wordpress query using the "pre_get_posts" hook. Other requests are ignored, which eliminates conflicts with the current theme settings. When developing the plugin, the emphasis was placed on maximum simplicity and minimalism.
After installation, the plugin must be configured. To do this, go to the "Easy Pagination Control" tab and set the desired number of elements on the page for each entity.
The plugin was created in order to have more control over the number of elements on pages within the main WP query, since by default, WP offers to specify the number of elements for all pages at once.

== Installation ==

1. Login to your WordPress admin and go to Plugins -> Add New
2. Type "Easy Pagination Control" in the search bar and select this plugin
3. Click "Install", and then "Activate Plugin"

== Frequently Asked Questions ==

= Can I configure pagination for my own post types? =

Yes, if the main WP query is used to output posts to the archive

= Why was this plugin created? =

For more control over pagination within the main WP query

== Screenshots ==

1. The Easy Pagination Plugin settings

== Changelog ==

= 1.0.3 =

* Update requirements for plugin (php7.0)
* Update readme
* Fix taxonomy pagination
* Add search page options
* Change default language to en_US

= 1.0.2 =

* Set required attr to input field
* Update readme

= 1.0.1 =
* Fix bug with default update template
* Fix bug with disabled button after error try
* Change '<?=' to '<?php echo' for better compatibility
* Added error handler for ajax
* All data is output from the database via escape functions
* Added escaping for default option template
* Added additional array-checking for form data
* Added additional validation of the number of elements on the page before writing to the database
* Added sanitize function for "name" option
* Added additional verification of user rights before saving changes
* Added nonce field for the plugin form
* Add plugin description to pot
* Set the unique namespace for plugin
* Change class's names to 'StudlyCase'
* Share the plugin to github