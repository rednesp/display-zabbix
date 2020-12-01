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
