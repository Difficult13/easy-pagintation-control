=== Plugin Name ===
Tags: pagination
Requires at least: 5.4.2
Tested up to: 5.4.2
Stable tag: 1.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A lightweight and easy-to-configure plugin for quickly configuring the number of objects on the archives, categories, tags, taxonomies, home, and front page

== Description ==

This plugin is designed to create a convenient page for pagination settings for the main wordpress entities, including custom types.
You can only work with the main wordpress query using the "pre_get_posts" hook. Other requests are ignored, which eliminates conflicts with the current theme settings. When developing the plugin, the emphasis was placed on maximum simplicity and minimalism.
After installation, the plugin must be configured. To do this, go to the "Easy Pagination Control" tab and set the desired number of elements on the page for each entity.
The plugin was created in order to have more control over the number of elements on pages within the main WP query, since by default, WP offers to specify the number of elements for all pages at once.

For backwards compatibility, if this section is missing, the full length of the short description will be used, and
Markdown parsed.

A few notes about the sections above:

*   "Contributors" is a comma separated list of wp.org/wp-plugins.org usernames
*   "Tags" is a comma separated list of tags that apply to the plugin
*   "Requires at least" is the lowest version that the plugin will work on
*   "Tested up to" is the highest version that you've *successfully used to test the plugin*. Note that it might work on
higher versions... this is just the highest one you've verified.
*   Stable tag should indicate the Subversion "tag" of the latest stable version, or "trunk," if you use `/trunk/` for
stable.

    Note that the `readme.txt` of the stable tag is the one that is considered the defining one for the plugin, so
if the `/trunk/readme.txt` file says that the stable tag is `4.3`, then it is `/tags/4.3/readme.txt` that'll be used
for displaying information about the plugin.  In this situation, the only thing considered from the trunk `readme.txt`
is the stable tag pointer.  Thus, if you develop in trunk, you can update the trunk `readme.txt` to reflect changes in
your in-development version, without having that information incorrectly disclosed about the current stable version
that lacks those changes -- as long as the trunk's `readme.txt` points to the correct stable tag.

    If no stable tag is provided, it is assumed that trunk is stable, but you should specify "trunk" if that's where
you put the stable version, in order to eliminate any doubt.

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Login to your WordPress admin and go to Plugins -> Add New
2. Type "Easy Pagination Control" in the search bar and select this plugin
3. Click "Install", and then "Activate Plugin"

== Frequently Asked Questions ==

= Can I configure pagination for my own post types? =

Yes, if the main WP query is used to output posts to the archive

= Why was this plugin created? =

For more control over pagination within the main WP query

== Screenshots ==

1. The "Easy Pagination Control" page.

== Changelog ==


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