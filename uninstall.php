<?php
/**
 * @package DisplayZabbix
 */

defined('WP_UNINSTALL_PLUGIN') or die('Get out!');

// Clear database stored data

global $wpdb;
$wpdb->query("DELETE FROM wp_posts WHERE post_type = 'graph'");
$wpdb->query("DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)");
$wpdb->query("DELETE FROM wp_term_relationships WHERE object_id NOT IN (SELECT id FROM wp_posts)");