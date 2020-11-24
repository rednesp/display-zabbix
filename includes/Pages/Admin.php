<?php

namespace Includes\Pages;

use \Includes\Base\BaseController;

class Admin extends BaseController
{
    public $settings;
    public $sections;
    public $fields;

    public function __construct() {
        parent::__construct();

        $this->settings = [
            [
                'option_group' => 'display_zabbix_group',
                'option_name'  => 'zabbix_url',
            ],
            [
                'option_group' => 'display_zabbix_group',
                'option_name'  => 'zabbix_user',
            ],
            [
                'option_group' => 'display_zabbix_group',
                'option_name'  => 'zabbix_pass',
            ],
        ];

        $this->sections = [
            [
                'id' => 'display_zabbix_index',
                'title' => 'Settings',
                'page' => 'display_zabbix_plugin'
            ],
        ];

        $this->fields = [
            [
                'id' => 'zabbix_url',
                'title' => 'Zabbix URL',
                'callback' => array($this, 'callback_url'),
                'page' => 'display_zabbix_plugin',
                'section' => 'display_zabbix_index',
                'args' => [
                    'label_for' => 'zabbix_url'
                ],
            ],
            [
                'id' => 'zabbix_user',
                'title' => 'Zabbix User',
                'callback' => array($this, 'callback_user'),
                'page' => 'display_zabbix_plugin',
                'section' => 'display_zabbix_index',
                'args' => [
                    'label_for' => 'zabbix_user'
                ],                
            ],
            [
                'id' => 'zabbix_pass',
                'title' => 'Zabbix Password',
                'callback' => array($this, 'callback_pass'),
                'page' => 'display_zabbix_plugin',
                'section' => 'display_zabbix_index',
                'args' => [
                    'label_for' => 'zabbix_pass'
                ],                
            ],       ];
    }

    public function callback_url() {
        $value = esc_attr(get_option('zabbix_url'));
        echo '<input type="text" class="regular-text" name="zabbix_url" value="' . $value . '" placeholder="Your Zabbix server URL">';
    }

    public function callback_user() {
        $value = esc_attr(get_option('zabbix_user'));
        echo '<input type="text" class="regular-text" name="zabbix_user" value="' . $value . '" placeholder="Your Zabbix user">';
    }

    public function callback_pass() {
        $value = esc_attr(get_option('zabbix_pass'));
        echo '<input type="password" class="regular-text" name="zabbix_pass" value="' . $value . '" placeholder="Your Zabbix password">';
    }

    public function register() {
        add_action('admin_menu', array($this, 'addAdminPages'));
        add_action('admin_init', array($this, 'registerCustomFields'));
    }

    function addAdminPages() {
        add_menu_page('Zabbix display', 'Zabbix display', 'manage_options', 'display_zabbix', array($this, 'adminIndex'));
    }
    
    function adminIndex() {
        require_once $this->plugin_path.'templates/admin.php';
    }

    function registerCustomFields() {
        foreach ($this->settings as $setting) {
            register_setting($setting["option_group"], $setting["option_name"], ( isset( $setting["callback"] ) ? $setting["callback"] : ''));
        }
		// add settings section
		foreach ( $this->sections as $section ) {
			add_settings_section( $section["id"], $section["title"], ( isset( $section["callback"] ) ? $section["callback"] : '' ), $section["page"] );
		}

		// add settings field
		foreach ( $this->fields as $field ) {
			add_settings_field( $field["id"], $field["title"], ( isset( $field["callback"] ) ? $field["callback"] : '' ), $field["page"], $field["section"], ( isset( $field["args"] ) ? $field["args"] : '' ) );
		}        
    }
}