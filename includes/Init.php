<?php

namespace Includes;

final class Init
{
    public static function get_services() {
        return [
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
