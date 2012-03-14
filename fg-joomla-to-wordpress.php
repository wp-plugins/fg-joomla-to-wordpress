<?php
/**
 * Plugin Name: FG Joomla to WordPress
 * Plugin Uri:  http://wordpress.org/extend/plugins/fg-joomla-to-wordpress/
 * Description: A plugin to migrate categories, posts, images and medias from Joomla to WordPress
 * Version:     1.2.1
 * Author:      Frédéric GILLES
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if ( !defined('WP_LOAD_IMPORTERS') )
	return;

// Load Importer API
require_once ABSPATH . 'wp-admin/includes/import.php';

if ( !class_exists( 'WP_Importer' ) ) {
	$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
	if ( file_exists( $class_wp_importer ) )
		require_once $class_wp_importer;
}

add_action( 'plugins_loaded', 'fgj2wp_load', 20 );

function fgj2wp_load() {
	$fgj2wp = new fgj2wp();
}

class fgj2wp extends WP_Importer {
	
	private $plugin_options;			// Plug-in options
	
	/**
	 * Sets up the plugin
	 *
	 */
	public function __construct() {
		$this->plugin_options = array();

		add_action( 'init', array (&$this, 'init') ); // Hook on init
	}

	/**
	 * Initialize the plugin
	 */
	public function init() {
		load_plugin_textdomain( 'fgj2wp', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	
		register_importer('fgj2wp', __('Joomla 1.5 (FG)', 'fgj2wp'), __('Import categories, articles and medias (images, attachments) from a Joomla 1.5 database into WordPress.', 'fgj2wp'), array ($this, 'dispatch'));
	}

	/**
	 * Display admin notice
	 */
	private function display_admin_notice( $message )	{
		echo '<div class="updated"><p>['.__CLASS__.'] '.$message.'</p></div>';
	}

	/**
	 * Display admin error
	 */
	private function display_admin_error( $message )	{
		echo '<div class="error"><p>['.__CLASS__.'] '.$message.'</p></div>';
	}

	/**
	 * Dispatch the actions
	 */
	public function dispatch() {
		set_time_limit(7200);
		
		// Default values
		$this->plugin_options = array(
			'url'					=> null,
			'hostname'				=> 'localhost',
			'port'					=> 3306,
			'database'				=> null,
			'username'				=> 'root',
			'password'				=> '',
			'prefix'				=> 'jos_',
			'introtext_in_excerpt'	=> 1,
			'skip_media'			=> 0,
		);
		$options = get_option('fgj2wp_options');
		if ( is_array($options) ) {
			$this->plugin_options = array_merge($this->plugin_options, $options);
		}
		
		if ( isset($_POST['action']) ) {
			
			switch ( $_POST['action'] ) {

				// Delete content
				case 'empty':
					if ( check_admin_referer( 'empty', 'fgj2wp_nonce' ) ) { // Security check
						if ($this->empty_database()) { // Empty WP database
							$this->display_admin_notice(__('Categories, posts and medias deleted', 'fgj2wp'));
						} else {
							$this->display_admin_error(__('Couldn\'t delete content', 'fgj2wp'));
						}
					}
					break;
					
				// Import content
				case 'import':
					if ( check_admin_referer( 'import', 'fgj2wp_nonce' ) ) { // Security check
						
						// Set database options
						$this->plugin_options = array_merge($this->plugin_options, $this->validate_form_info());
						update_option('fgj2wp_options', $this->plugin_options);
						
						// Categories
						$cat_count = $this->import_categories();
						$this->display_admin_notice(sprintf(_n('%d category imported', '%d categories imported', $cat_count, 'fgj2wp'), $cat_count));
						
						// Posts and medias
						$result = $this->import_posts();
						$this->display_admin_notice(sprintf(_n('%d post imported', '%d posts imported', $result['posts_count'], 'fgj2wp'), $result['posts_count']));
						$this->display_admin_notice(sprintf(_n('%d media imported', '%d medias imported', $result['media_count'], 'fgj2wp'), $result['media_count']));
					}
					break;
			}
		}
		
		$this->admin_build_page(); // Display the form
	}
	
	/**
	 * Build the option page
	 * 
	 */
	private function admin_build_page() {
		$posts_count = wp_count_posts('post');
		$media_count = wp_count_posts('attachment');
		$cat_count = count(get_categories(array('hide_empty' => 0)));
		
		$data = $this->plugin_options;
		$data['posts_count'] = $posts_count->publish + $posts_count->draft + $posts_count->future + $posts_count->pending;
		$data['media_count'] = $media_count->inherit;
		$data['cat_count'] = $cat_count;
		
		include('admin_build_page.tpl.php');
	}

	/**
	 * Delete all posts, medias and categories from the database
	 *
	 * @return boolean
	 */
	private function empty_database() {
		global $wpdb;
		$result = true;
		
		$wpdb->show_errors();
		
		$sql = <<<SQL
 -- Delete Comments meta
DELETE FROM $wpdb->commentmeta
WHERE comment_id IN
	(
	SELECT comment_ID FROM $wpdb->comments
	WHERE comment_post_ID IN
		(
		SELECT ID FROM $wpdb->posts
		WHERE post_type IN ('post', 'attachment', 'revision')
		OR post_status = 'trash'
		OR post_title = 'Brouillon auto'
		)
	);
SQL;
		$result &= $wpdb->query($wpdb->prepare($sql));

		$sql = <<<SQL
-- Delete Comments
DELETE FROM $wpdb->comments
WHERE comment_post_ID IN
	(
	SELECT ID FROM $wpdb->posts
	WHERE post_type IN ('post', 'attachment', 'revision')
	OR post_status = 'trash'
	OR post_title = 'Brouillon auto'
	);
SQL;
		$result &= $wpdb->query($wpdb->prepare($sql));

		$sql = <<<SQL
-- Delete Term relashionships
DELETE FROM $wpdb->term_relationships
WHERE `object_id` IN
	(
	SELECT ID FROM $wpdb->posts
	WHERE post_type IN ('post', 'attachment', 'revision')
	OR post_status = 'trash'
	OR post_title = 'Brouillon auto'
	);
SQL;
		$result &= $wpdb->query($wpdb->prepare($sql));

		$sql = <<<SQL
-- Delete Post meta
DELETE FROM $wpdb->postmeta
WHERE post_id IN
	(
	SELECT ID FROM $wpdb->posts
	WHERE post_type IN ('post', 'attachment', 'revision')
	OR post_status = 'trash'
	OR post_title = 'Brouillon auto'
	);
SQL;
		$result &= $wpdb->query($wpdb->prepare($sql));

		$sql = <<<SQL
-- Delete Posts
DELETE FROM $wpdb->posts
WHERE post_type IN ('post', 'attachment', 'revision')
OR post_status = 'trash'
OR post_title = 'Brouillon auto';
SQL;
		$result &= $wpdb->query($wpdb->prepare($sql));

		$sql = <<<SQL
-- Delete Categories
DELETE t, tt FROM $wpdb->terms t, $wpdb->term_taxonomy tt
WHERE t.term_id = tt.term_id
AND t.term_id > 1 -- non-classe
AND tt.taxonomy = 'category'
SQL;
		$result &= $wpdb->query($wpdb->prepare($sql));
		
		// Reset the Joomla last imported post ID
		update_option('fgj2wp_last_id', 0);
		
		$this->optimize_database();
		
		$wpdb->hide_errors();
		return ($result !== false);
	}

	/**
	 * Optimize the database
	 *
	 */
	private function optimize_database() {
		global $wpdb;
		
		$sql = <<<SQL
OPTIMIZE TABLE 
`$wpdb->commentmeta` ,
`$wpdb->comments` ,
`$wpdb->options` ,
`$wpdb->postmeta` ,
`$wpdb->posts` ,
`$wpdb->terms` ,
`$wpdb->term_relationships` ,
`$wpdb->term_taxonomy`
SQL;
		$wpdb->query($wpdb->prepare($sql));
	}
		
	/**
	 * Validate POST info
	 *
	 * @return array Form parameters
	 */
	private function validate_form_info() {
		return array(
			'url'					=> $_POST['url'],
			'hostname'				=> $_POST['hostname'],
			'port'					=> (int) $_POST['port'],
			'database'				=> $_POST['database'],
			'username'				=> $_POST['username'],
			'password'				=> $_POST['password'],
			'prefix'				=> $_POST['prefix'],
			'introtext_in_excerpt'	=> !empty($_POST['introtext_in_excerpt']),
			'skip_media'			=> !empty($_POST['skip_media']),
		);
	}

	/**
	 * Import categories
	 *
	 * @return int Number of categories imported
	 */
	private function import_categories() {
		$cat_count = 0;
		$sections = $this->get_sections(); // Get the Joomla sections
		$categories = $this->get_categories(); // Get the Joomla categories
		$categories = array_merge($sections, $categories);
		if ( is_array($categories) ) {
			$terms = array('1'); // unclassified category
			foreach ( $categories as $category ) {
				
				if ( get_category_by_slug($category['name']) ) {
					continue; // Do not import already imported category
				}
				
				//Parent category
				$parent_id = 0;
				if ( !empty($category['parent']) ) {
					$idObj = get_category_by_slug($category['parent']);
					$parent_id = $idObj->term_id;
				}
				
				// Insert the category
				$new_category = array(
					'cat_name' 				=> $category['title'],
					'category_description'	=> $category['description'],
					'category_nicename'		=> $category['name'],
					'category_parent'		=> $parent_id,
				);
				if ( $cat_id = wp_insert_category($new_category) ) {
					$cat_count++;
					$terms[] = $cat_id;
				}
			}
			
			// Update cache
			wp_update_term_count_now($terms, 'category');
			delete_option("category_children");
			clean_term_cache($terms, 'category');
		}
		return $cat_count;
	}

	/**
	 * Import posts
	 *
	 * @return int Number of posts imported
	 */
	private function import_posts() {
		$posts_count = 0;
		$media_count = 0;
		
		$tab_categories = $this->tab_categories(); // Get the categories list
		
		$posts = $this->get_posts(); // Get the Joomla posts
		
		if ( is_array($posts) ) {
			foreach ( $posts as $post ) {
				
				// Medias
				if ( !$this->plugin_options['skip_media'] ) {
					// Import media
					list($post_media, $post_media_count) = $this->import_media($post['introtext'] . $post['fulltext'], $post['date']);
					$media_count += $post_media_count;
				} else {
					// Skip media
					$post_media = array();
				}
				
				// Category ID
				$category = sanitize_title($post['category']);
				if ( array_key_exists($category, $tab_categories) ) {
					$cat_id = $tab_categories[$category];
				} else {
					$cat_id = 1; // default category
				}
				
				// Define excerpt and post content
				if ( empty($post['fulltext']) ) {
					// Posts without a "Read more" link
					$excerpt = '';
					$content = $post['introtext'];
				} else {
					// Posts with a "Read more" link
					if ( $this->plugin_options['introtext_in_excerpt'] ) {
						// Introtext imported in excerpt
						$excerpt = $post['introtext'];
						$content = $post['fulltext'];
					} else {
						// Introtext imported in post content with a "Read more" tag
						$excerpt = '';
						$content = $post['introtext'] . "\n<!--more-->\n" . $post['fulltext'];
					}
				}
				
				// Process content
				$excerpt = $this->process_content($excerpt, $post_media);
				$content = $this->process_content($content, $post_media);
				
				// Status
				$status = ($post['state'] == 1)? 'publish' : 'draft';
				
				// Insert the post
				$new_post = array(
					'post_category'		=> array($cat_id),
					'post_content'		=> $content,
					'post_date'			=> $post['date'],
					'post_excerpt'		=> $excerpt,
					'post_status'		=> $status,
					'post_title'		=> $post['title'],
					'post_name'			=> $post['alias'],
					'post_type'			=> 'post',
				);
				$new_post_id = wp_insert_post($new_post);
				if ( $new_post_id ) { 
					// Add links between the post and its medias
					$this->add_post_media($new_post_id, $new_post, $post_media);
					
					// Increment the Joomla last imported post ID
					update_option('fgj2wp_last_id', $post['id']);

					$posts_count++;					
				}
			}
		}
		return array(
			'posts_count'	=> $posts_count,
			'media_count'	=> $media_count,
		);
	}
	
	/**
	 * Get Joomla sections
	 *
	 * @return array of Sections
	 */
	private function get_sections() {
		$sections = array();

		try {
			$db = new PDO('mysql:host=' . $this->plugin_options['hostname'] . ';port=' . $this->plugin_options['port'] . ';dbname=' . $this->plugin_options['database'], $this->plugin_options['username'], $this->plugin_options['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
			$prefix = $this->plugin_options['prefix'];
			$sql = "
				SELECT s.title, CONCAT('s', s.id, '-', IFNULL(s.alias, s.name)) AS name, s.description
				FROM ${prefix}sections s
			";
			$query = $db->query($sql);
			if ( is_object($query) ) {
				foreach ( $query as $row ) {
					$sections[] = $row;
				}
			}
			$db = null;
		} catch ( PDOException $e ) {
			print "Erreur !: " . $e->getMessage() . "<br />";
			die();
		}
		return $sections;		
	}
	
	/**
	 * Get Joomla categories
	 *
	 * @return array of Categories
	 */
	private function get_categories() {
		$categories = array();

		try {
			$db = new PDO('mysql:host=' . $this->plugin_options['hostname'] . ';port=' . $this->plugin_options['port'] . ';dbname=' . $this->plugin_options['database'], $this->plugin_options['username'], $this->plugin_options['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
			$prefix = $this->plugin_options['prefix'];
			$sql = "
				SELECT c.title, CONCAT(c.id, '-', IFNULL(c.alias, c.name)) AS name, c.description, CONCAT('s', s.id, '-', IFNULL(s.alias, s.name)) AS parent
				FROM ${prefix}categories c
				INNER JOIN ${prefix}sections AS s ON s.id = c.section
			";
			$query = $db->query($sql);
			if ( is_object($query) ) {
				foreach ( $query as $row ) {
					$categories[] = $row;
				}
			}
			$db = null;
		} catch ( PDOException $e ) {
			print "Erreur !: " . $e->getMessage() . "<br />";
			die();
		}
		return $categories;		
	}
	
	/**
	 * Get Joomla posts
	 *
	 * @return array of Posts
	 */
	private function get_posts() {
		$posts = array();
		
		$last_id = (int)get_option('fgj2wp_last_id'); // to restore the import where it left

		try {
			$db = new PDO('mysql:host=' . $this->plugin_options['hostname'] . ';port=' . $this->plugin_options['port'] . ';dbname=' . $this->plugin_options['database'], $this->plugin_options['username'], $this->plugin_options['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
			$prefix = $this->plugin_options['prefix'];
			$sql = "
				SELECT p.id, p.title, p.alias, p.introtext, p.fulltext, p.state, CONCAT(c.id, '-', IFNULL(c.alias, c.name)) AS category, p.modified, IF(p.publish_up, p.publish_up, p.created) AS date
				FROM ${prefix}content p
				LEFT JOIN ${prefix}categories AS c ON p.catid = c.id
				WHERE p.state >= 0 -- don't get the trash
				AND p.id > '$last_id'
				ORDER BY p.id
			";
			$query = $db->query($sql);
			if ( is_object($query) ) {
				foreach ( $query as $row ) {
					$posts[] = $row;
				}
			}
			$db = null;
		} catch ( PDOException $e ) {
			print "Erreur !: " . $e->getMessage() . "<br />";
			die();
		}
		return $posts;		
	}
	
	/**
	 * Return an array with all the categories sorted by name
	 *
	 * @return array categoryname => id
	 */
	private function tab_categories() {
		$tab_categories = array();
		$categories = get_categories(array('hide_empty' => '0'));
		if ( is_array($categories) ) {
			foreach ( $categories as $category ) {
				$tab_categories[$category->slug] = $category->term_id;
			}
		}
		return $tab_categories;
	}
	
	/**
	 * Import post medias
	 *
	 * @param string $content post content
	 * @param date $post_date Post date (for storing media)
	 * @return array:
	 * 		array: Medias imported
	 * 		int:   Medias count
	 */
	private function import_media($content, $post_date) {
		$media = array();
		$media_count = 0;
		
		if ( preg_match_all('#<(img|a)(.*?)(src|href)="(.*?)"(.*?)>#', $content, $matches, PREG_SET_ORDER) > 0 ) {
			if ( is_array($matches) ) {
				foreach ($matches as $match ) {
					$filename = $match[4];
					$filename = str_replace("%20", " ", $filename); // for filenames with spaces
					$other_attributes = $match[2] . $match[5];
					
					$filetype = wp_check_filetype($filename);
					if ( empty($filetype['type']) ) { // Unrecognized file type
						continue;
					}
					
					// Upload the file from the Joomla web site to WordPress upload dir
					if ( preg_match('/^http/', $filename) ) {
						if ( preg_match('#^' . $this->plugin_options['url'] . '#', $filename) ) {
							// Local file
							$old_filename = $filename;
						} else {
							// Don't import external file
							continue;
						}
					} else {
						$old_filename = untrailingslashit($this->plugin_options['url']) . '/' . $filename;
					}
					$old_filename = str_replace(" ", "%20", $old_filename); // for filenames with spaces
					$date = strftime('%Y/%m', strtotime($post_date));
					$uploads = wp_upload_dir($date);
					$new_upload_dir = $uploads['path'];
					
					$new_filename = $new_upload_dir . '/' . basename($filename);
					
					// print "Copy \"$old_filename\" => $new_filename<br />";
					if ( !@copy($old_filename, $new_filename) ) {
						$this->display_admin_error("Can't copy $old_filename to $new_filename");
						continue;
					}

					$post_name = preg_replace('/\.[^.]+$/', '', basename($filename));
					
					// If the attachment does not exist yet, insert it in the database
					$attachment = $this->get_attachment_from_name($post_name);
					if ( !$attachment ) {
						$attachment_data = array(
							'post_mime_type'	=> $filetype['type'],
							'post_name'			=> $post_name,
							'post_title'		=> $post_name,
							'post_status'		=> 'inherit'
						);
						$attach_id = wp_insert_attachment($attachment_data, $new_filename);
						$attachment = get_post($attach_id);
						$post_name = $attachment->post_name; // Get the real post name
						$media_count++;
					}
					$attach_id = $attachment->ID;
					
					$media[$filename] = $post_name;
					
					if ( preg_match('/image/', $filetype['type']) ) { // Images
						// you must first include the image.php file
						// for the function wp_generate_attachment_metadata() to work
						require_once(ABSPATH . 'wp-admin/includes/image.php');
						$attach_data = wp_generate_attachment_metadata( $attach_id, $new_filename );
						wp_update_attachment_metadata( $attach_id, $attach_data );

						// Image Alt
						if (preg_match('#alt="(.+?)"#', $other_attributes, $alt_matches) ) {
							$image_alt = wp_strip_all_tags(stripslashes($alt_matches[1]), true);
							update_post_meta($attach_id, '_wp_attachment_image_alt', addslashes($image_alt)); // update_meta expects slashed
						}
					}
				}
			}
		}
		return array($media, $media_count);
	}

	/**
	 * Check if the attachment exists in the database
	 *
	 * @param string $name
	 * @return object Post
	 */
	private function get_attachment_from_name($name) {
		$name = preg_replace('/\.[^.]+$/', '', basename($name));
		$r = array(
			'name'			=> $name,
			'post_type'		=> 'attachment',
			'numberposts'	=> 1,
		);
		$posts_array = get_posts($r);
		if ( is_array($posts_array) && (count($posts_array) > 0) ) {
			return $posts_array[0];
		}
		else {
			return false;
		}
	}
	
	/**
	 * Process the post content
	 *
	 * @param string $content Post content
	 * @param array $post_media Post medias
	 * @return string Processed post content
	 */
	private function process_content($content, $post_media) {
		
		if ( !empty($content) ) {
			// Replace media URLs with the new URLs
			$content = $this->process_content_media_links($content, $post_media);
		}

		return $content;
	}

	/**
	 * Replace media URLs with the new URLs
	 *
	 * @param string $content Post content
	 * @param array $post_media Post medias
	 * @return string Processed post content
	 */
	private function process_content_media_links($content, $post_media) {
		if ( is_array($post_media) ) {
			foreach ( $post_media as $old_filename => $post_media_name ) {
				$attachment = $this->get_attachment_from_name($post_media_name);
				if ( $attachment ) {
					if ( preg_match('/image/', $attachment->post_mime_type) ) {
						// Image
						$image_src = wp_get_attachment_image_src($attachment->ID, 'full');
						$url = $image_src[0];
					} else {
						// Other media
						$url = wp_get_attachment_url($attachment->ID);
					}
					$url = str_replace(" ", "%20", $url); // for filenames with spaces
					$content = str_replace($old_filename, $url, $content);
					$old_filename = str_replace(" ", "%20", $old_filename); // for filenames with spaces
					$content = str_replace($old_filename, $url, $content);
				}
			}
		}
		return $content;
	}

	/**
	 * Add a link between a media and a post (parent id + thumbnail)
	 *
	 * @param int $post_id Post ID
	 * @param array $post_data Post data
	 * @param array $post_media Post medias
	 */
	function add_post_media($post_id, $post_data, $post_media) {
		$thumbnail_is_set = false;
		if ( is_array($post_media) ) {
			foreach ( $post_media as $old_filename => $post_media_name ) {
				$attachment = $this->get_attachment_from_name($post_media_name);
				$attachment->post_parent = $post_id; // Attach the post to the media
				$attachment->post_date = $post_data['post_date'] ;// Define the media's date
				wp_update_post($attachment);

				// Set the thumbnail to be the first image
				if ( !$thumbnail_is_set ) {
					set_post_thumbnail($post_id, $attachment->ID);
					$thumbnail_is_set = true;
				}
			}
		}
	}

}

?>
