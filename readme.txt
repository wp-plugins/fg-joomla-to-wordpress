=== FG Joomla to WordPress ===
Contributors: Frédéric GILLES
Plugin Uri: http://wordpress.org/extend/plugins/fg-joomla-to-wordpress/
Tags: joomla, wordpress, migrator, converter, import
Requires at least: 3.3
Tested up to: WP 3.3.1
Stable tag: 1.3.1
License: GPLv2
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=fred%2egilles%40free%2efr&lc=FR&item_name=Fr%c3%a9d%c3%a9ric%20GILLES&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted

A plugin to migrate categories, posts, images and other medias from Joomla to WordPress

== Description ==

This plugin migrates sections, categories, posts, images and medias from Joomla to Wordpress.

It has been tested with **Joomla 1.5** and **Wordpress 3.3.1** on huge databases (72 000+ posts)

Major features include:

* migrates Joomla sections as categories
* migrates categories as sub-categories
* migrates Joomla posts
* uploads all the posts media in WP uploads directories (in option)
* modifies the post content to keep the media links
* resizes images according to the sizes defined in WP
* defines the thumbnail to be the first post image
* keeps the alt image attribute
* modifies the internal links

== Installation ==

1.  Extract plugin zip file and load up to your wp-content/plugin directory
2.  Activate Plugin in the Admin => Plugins Menu
3.  Run the importer in Tools > Import > Joomla 1.5 (FG)

== Frequently Asked Questions ==

= All the posts are not migrated. Why ? =

* The archived posts or posts put in trash are not migrated. But unpublished posts are migrated as drafts.

= The migration stops and I get the message: "Fatal error: Allowed memory size of XXXXXX bytes exhausted" =

* You can run the migration again. It will continue where it stopped. You can also increase the memory limit in php.ini if you have write access to this file.

= The media are not migrated and I get the error message: "Warning: copy() [function.copy]: URL file-access is disabled in the server configuration" =

* The PHP directive "Allow URL fopen" must be turned on in php.ini to copy the medias. If your remote host doesn't allow this directive, you will have to do the migration on localhost.

= I get the message: "Fatal error: Class 'PDO' not found" =

* PDO and PDO_MySQL libraries are needed. You must enable them in php.ini.

Don't hesitate to let a comment on the forum or to report bugs if you found some.
http://wordpress.org/tags/fg-joomla-to-wordpress?forum_id=10

== Screenshots ==

1. Parameters screen

== Translations ==
* French (fr_FR)
* English (default)
* other can be translated

== Changelog ==

= 1.3.1 =
* New: Deactivate the cache during the migration for improving speed

= 1.3.0 =
* New: Modify posts internal links using WordPress permalinks setup
* Fixed: Exhausted memory issue

= 1.2.2 =
* Fixed: Don't import HTML links as medias
* FAQ updated

= 1.2.1 =
* New: Get the post creation date when the publication date is empty
* Fixed: Accept categories with spaces in alias

= 1.2.0 =
* New: Import all media
* Fixed: Do not reimport already imported categories
* Fixed: Update categories cache
* Fixed: Issue with media containing spaces
* Fixed: Original images sizes are kept in post contents

= 1.1.1 =
* New: Manage sections and categories duplicates
* Fixed: Wrong categorization of posts

= 1.1.0 =
* Update the FAQ
* New: Can restart an import where it left after a crash (for big databases)
* New: Display the number of categories, posts and images already imported
* Fixed: Issue with categories with alias but no name
* Fixed: Now import only post categories, not all categories (ie modules categories, …)

= 1.0.2 =
* Fixed: The images with absolute links were not imported.
* New: Option to skip the images import
* New: Skip external images

= 1.0.1 =
* Fixed: The content was not imported in the post content for the posts without a "Read more" link.
* New: Option to choose to import the Joomla introtext in the excerpt or in the post content with a «Read more» tag.

= 1.0.0 =
* Initial version: Import Joomla 1.5 sections, categories, posts and images

== Upgrade Notice ==

= 1.3.1 =
Improve speed

= 1.3.0 =
Modify posts internal links using WordPress permalinks setup
Exhausted memory issue fixed

= 1.2.2 =
Don't import HTML links as medias

= 1.2.1 =
Get the post creation date when the publication date is empty
Accept categories with spaces in alias

= 1.2.0 =
Import all media

= 1.1.1 =
Manage sections and categories duplicates

= 1.1.0 =
You can restart an import where it left after a crash (for big databases).

= 1.0.2 =
You can now skip the images import. And even if you keep on importing the images, the external images are automatically skipped.

= 1.0.1 =
* Fixed: The content was not imported in the post content for the posts without a "Read more" link.
* New: You can now choose to import the Joomla introtext in the excerpt or in the post content with a «Read more» tag.

= 1.0.0 =
Initial version

`<?php code(); // goes in backticks ?>`
