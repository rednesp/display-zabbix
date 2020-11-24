<?php
/**
 * @package DisplayZabbix
 */
/**
 * Plugin Name: Display Zabbix Graphs
 * Description: Show Zabbix Graphs inside Wordpress
 * Author: Antonio Francisco
 * Version: 0.1
 */

defined('ABSPATH') or die('Get out!');

if ( file_exists( dirname(__FILE__).'/vendor/autoload.php')) {
    require_once dirname(__FILE__).'/vendor/autoload.php';
}
