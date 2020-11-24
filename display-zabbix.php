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


function activate_display_zabbix_plugin() {
    Includes\Base\Activate::activate();
}
register_activation_hook(__FILE__, 'activate_display_zabbix_plugin');

function deactivate_display_zabbix_plugin() {
    Includes\Base\Deactivate::deactivate();
}
register_deactivation_hook(__FILE__, 'deactivate_display_zabbix_plugin');
