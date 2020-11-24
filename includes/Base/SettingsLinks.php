<?php
/**
 * @package DisplayZabbix
 */

namespace Includes\Base;

use \Includes\Base\BaseController;

class SettingsLinks extends BaseController
{
    public function register(){
        add_filter("plugin_action_links_$this->plugin", array($this, 'settings_link'));
    }

    function settings_link($links) {
        $settings_link = '<a href="admin.php?page=display_zabbix">Settings</a>';
        array_push($links, $settings_link);
        return $links;
    }
}