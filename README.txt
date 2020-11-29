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
*Since version 1.1.0, Customizer support has been added, so you can now configure pagination directly in the frontend
*Since version 1.1.2, the public function easy_pagination_control_get_ppp($Entity) has been added. As an argument, it gets the name of the entity ('Front-Page', 'Home', 'categories', 'Tags', 'Search', or post type's slug, or taxonomy's slug). Returns the number of elements on the page.

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
2. The Easy Pagination Plugin in Customizer
3. Built-in section in Customizer
4. Post Types section in Customizer

== Changelog ==

= 1.1.2=
* Add public function easy_pagination_control_get_ppp($entity). This function allows you to extract the number of posts per page for the specified entity.

= 1.1.1 =
* Add advanced is_front_page() function for static front page compatibilities
* Simplified method for determining the archive page of a post type

= 1.1.0 =

* Change "Options API" to "Settings API"
* Moved the plugin settings page to the standard WP section "Reading"
* General code refactoring
* Reduced the priority of the "pre_get_posts" event to reduce the chances of conflicts with other pagination plugins
* Added support for Customizer
* Update readme

= 1.0.5 =

* Add 'option_posts_per_page' hook to return the correct number of elements on the page when using this plugin

= 1.0.4 =

* Now plugin styles and scripts are enabled only on the plugin page

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