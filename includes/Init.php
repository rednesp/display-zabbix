<?php

namespace Includes;

final class Init
{
    public static function get_services() {
        return [
            Pages\Admin::class,
            Base\SettingsLinks::class,
            Base\ZabbixGraph::class,
        ];
    }

    public static function register_services() {
        foreach (self::get_services() as $class) {
            $service = new $class();
            if (method_exists( $service, 'register')) {
                $service->register();
            }
        }
    }
}

// use Includes\Activate;
// use Includes\Deactivate;
// use Includes\Admin\AdminPages;

// class DisplayZabbix
// {
//     public $plugin;

//     function __construct() {
//         $this->plugin = plugin_basename(__FILE__);
//     }

//     function register() {
//         add_action('init', array($this, 'custom_post_type'));
//         add_action('admin_menu', array($this, 'add_admin_pages'));
//         add_filter("plugin_action_links_$this->plugin", array($this, 'settings_link'));
//     }

//     function settings_link($links) {
//         $settings_link = '<a href="admin.php?page=display_zabbix">Settings</a>';
//         array_push($links, $settings_link);
//         return $links;
//     }

//     function add_admin_pages() {
//         add_menu_page('Zabbix display', 'Zabbix display', 'manage_options', 'display_zabbix', array($this, 'admin_index'));
//     }
    
//     function admin_index() {
//         require_once plugin_dir_path(__FILE__).'templates/admin.php';
//     }

//     function activate() {
//         $this->custom_post_type();
//         flush_rewrite_rules();
//     }

//     function deactivate() {
//         flush_rewrite_rules();
//     }

//     function uninstall() {
        
//     }

//     function custom_post_type() {
//         register_post_type('graph', ['public' => true, 'label' => 'Graphs']);
//     }
// }

// if (class_exists('DisplayZabbix')) {
//     $displayZabbix = new DisplayZabbix();
//     $displayZabbix->register();
// }

