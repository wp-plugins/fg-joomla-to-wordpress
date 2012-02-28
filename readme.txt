=== FG Joomla to WordPress ===
Contributors: Frédéric GILLES
Plugin Uri: http://wordpress.org/extend/plugins/fg-joomla-to-wordpress/
Tags: joomla, wordpress, migrator, converter, import
Requires at least: 3.3
Tested up to: WP 3.3.1
Stable tag: 1.0.1
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
* uploads all the posts images in WP uploads directories
* resizes images according to the sizes defined in WP
* defines the thumbnail to be the first post image
* modifies images src in content
* keeps the alt image attribute

== Installation ==

1.  Extract plugin zip file and load up to your wp-content/plugin directory
2.  Activate Plugin in the Admin => Plugins Menu
3.  Run the importer in Tools > Import > Joomla 1.5 (FG)

== Frequently Asked Questions ==

Don't hesitate to let a comment on the forum or to report bugs if you found some.
http://wordpress.org/tags/fg-joomla-to-wordpress?forum_id=10

== Screenshots ==

1. Parameters screen

== Translations ==
* French (fr_FR)
* English (default)
* other can be translated

== Changelog ==

= 1.0.1 =
* Fixed: The content was not imported in the post content for the posts without a "Read more" link.
* New: Option to choose to import the Joomla introtext in the excerpt or in the post content with a «Read more» tag.

= 1.0.0 =
* Initial version: Import Joomla 1.5 sections, categories, posts and images

== Upgrade Notice ==

= 1.0.1 =
* Fixed: The content was not imported in the post content for the posts without a "Read more" link.
* New: You can now choose to import the Joomla introtext in the excerpt or in the post content with a «Read more» tag.

= 1.0.0 =
Initial version

`<?php code(); // goes in backticks ?>`
