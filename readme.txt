=== FG Joomla to WordPress ===
Contributors: Frédéric GILLES
Plugin Uri: http://wordpress.org/extend/plugins/fg-joomla-to-wordpress/
Tags: joomla, wordpress, migrator, converter, import
Requires at least: 3.3
Tested up to: WP 3.3.1
Stable tag: 1.1.1
License: GPLv2
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=fred%2egilles%40free%2efr&lc=FR&item_name=Fr%c3%a9d%c3%a9ric%20GILLES&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted

A plugin to migrate categories, posts and images from Joomla to WordPress

== Description ==

This plugin migrates sections, categories, posts, and images from Joomla to Wordpress.

It has been tested with **Joomla 1.5** and **Wordpress 3.3.1**

Major features include:

* migrates Joomla sections as categories
* migrates categories as sub-categories
* migrates Joomla posts
* associates posts to categories
* uploads all the posts images in WP uploads directories (optional)
* resizes images according to the sizes defined in WP
* defines the thumbnail to be the first post image
* modifies images src in content
* keeps the alt image attribute

== Installation ==

1.  Extract plugin zip file and load up to your wp-content/plugin directory
2.  Activate Plugin in the Admin => Plugins Menu
3.  Run the importer in Tools > Import > Joomla 1.5 (FG)

== Frequently Asked Questions ==

= All the posts are not migrated. Why ? =

* The archived posts or posts put in trash are not migrated. But unpublished posts are migrated as drafts.

Don't hesitate to let a comment on the forum or to report bugs if you found some.
http://wordpress.org/tags/fg-joomla-to-wordpress?forum_id=10

== Screenshots ==

1. Parameters screen

== Translations ==
* French (fr_FR)
* English (default)
* other can be translated

== Changelog ==

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
